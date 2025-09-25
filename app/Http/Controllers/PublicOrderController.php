<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\OrderItem;
use Illuminate\Support\Facades\URL;
use App\Jobs\SendWhatsAppMessage;

class PublicOrderController extends Controller
{
    public function create(Request $request)
    {
        // Detect primary key column name (e.g., 'id' or 'service_id')
        $serviceModel = new Service();
        $pk = $serviceModel->getKeyName();
        // Select common fields and ensure primary key is available
        $columns = [$pk, 'service_name', 'slug', 'price'];
        $services = Service::orderBy('service_name')->get($columns);
        $prefill = [
            'service_id' => $request->integer('service_id'),
            'package_name' => $request->get('package_name'),
            'budget' => $request->get('budget'),
        ];
        return view('public.order', compact('services', 'prefill'));
    }

    private static function buildCustomerWaMessage(Invoice $invoice): string
    {
        $pdfLink = URL::signedRoute('invoices.public.pdf', ['invoice' => $invoice->getKey()]);
        $statusLink = URL::signedRoute('invoices.public.status', ['invoice' => $invoice->getKey()]);
        $orderCode = optional($invoice->order)->order_code;
        $lines = [
            'Halo '.$invoice->client->client_name.',',
            'Terima kasih, order Anda telah kami terima.',
            ($orderCode ? ('Order: '.$orderCode) : null),
            'Invoice: '.$invoice->invoice_code,
            'Total: Rp '.number_format((float)$invoice->total_amount, 0, ',', '.'),
            'Jatuh Tempo: '.optional($invoice->due_date)->format('d M Y'),
            'Status & Konfirmasi Pembayaran: '.$statusLink,
            'Unduh Invoice (PDF): '.$pdfLink,
            'Jika sudah melakukan pembayaran, mohon klik tautan status untuk konfirmasi agar kami bisa segera memproses.',
            'Terima kasih, '.config('app.name'),
        ];
        return implode("\n", $lines);
    }

    public function store(Request $request)
    {
        $serviceModel = new Service();
        $pk = $serviceModel->getKeyName();
        $data = $request->validate([
            'customer_name' => ['required','string','max:120'],
            'customer_email' => ['required','email','max:160'],
            'whatsapp_number' => ['required','string','max:32'],
            'service_id' => ['required','integer','exists:services,'.$pk],
            'package_name' => ['nullable','string','max:120'],
            'budget' => ['nullable','numeric','min:0'],
            'notes' => ['nullable','string','max:5000'],
            'recaptcha_token' => ['nullable','string'],
            'website' => ['nullable','string','max:120'], // honeypot
        ]);

        // Honeypot check: if 'website' filled, treat as spam
        if (!empty($data['website'])) {
            return back()->withErrors(['form' => 'Terjadi kesalahan. Silakan coba lagi.'])->withInput();
        }

        // Optional reCAPTCHA v3 verification
        $siteKey = (string) config('services.recaptcha.site_key');
        $secretKey = (string) config('services.recaptcha.secret_key');
        $threshold = (float) config('services.recaptcha.score_threshold', 0.5);
        if (!empty($siteKey) && !empty($secretKey)) {
            $token = (string) ($data['recaptcha_token'] ?? '');
            if (empty($token)) {
                return back()->withErrors(['recaptcha' => 'Verifikasi keamanan diperlukan.'])->withInput();
            }
            try {
                $resp = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secretKey,
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ])->json();
                $ok = ($resp['success'] ?? false) && ($resp['score'] ?? 0) >= $threshold;
                if (!$ok) {
                    Log::warning('reCAPTCHA failed', ['resp' => $resp]);
                    return back()->withErrors(['recaptcha' => 'Gagal verifikasi reCAPTCHA. Silakan coba lagi.'])->withInput();
                }
            } catch (\Throwable $e) {
                Log::error('reCAPTCHA error: ' . $e->getMessage());
                // Graceful fallback: allow submission
            }
        } else {
            Log::info('reCAPTCHA skipped: keys not configured');
        }

        // Hitung base total terlebih dahulu (dari budget atau fallback harga service)
        $baseTotal = (float) ($data['budget'] ?? 0);
        if (!empty($data['service_id'])) {
            $svc = Service::find($data['service_id']);
            if ($svc && isset($svc->price) && $baseTotal <= 0) {
                $baseTotal = (float) $svc->price;
            }
        }

        // Generate order code: AKR-YYYYMMDD-<5 random>
        $orderCode = 'AKR-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

        // Build insert payload only with columns that exist to avoid SQL errors
        $candidate = [
            'order_code' => $orderCode,
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'whatsapp_number' => $data['whatsapp_number'],
            'service_id' => $data['service_id'] ?? null,
            'package_name' => $data['package_name'] ?? null,
            'budget' => $data['budget'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // If table uses alternative column for code
        if (!Schema::hasColumn('orders', 'order_code') && Schema::hasColumn('orders', 'code')) {
            $candidate['code'] = $candidate['order_code'];
            unset($candidate['order_code']);
        }

        // Map alternative names for common fields
        if (!Schema::hasColumn('orders', 'customer_name') && Schema::hasColumn('orders', 'name')) {
            $candidate['name'] = $candidate['customer_name'];
            unset($candidate['customer_name']);
        }
        if (!Schema::hasColumn('orders', 'customer_email')) {
            if (Schema::hasColumn('orders', 'email')) {
                $candidate['email'] = $candidate['customer_email'];
            }
            unset($candidate['customer_email']);
        }
        // WhatsApp / phone mapping
        if (!Schema::hasColumn('orders', 'whatsapp_number')) {
            if (Schema::hasColumn('orders', 'customer_whatsapp')) {
                $candidate['customer_whatsapp'] = $candidate['whatsapp_number'];
            } elseif (Schema::hasColumn('orders', 'phone')) {
                $candidate['phone'] = $candidate['whatsapp_number'];
            } elseif (Schema::hasColumn('orders', 'phone_number')) {
                $candidate['phone_number'] = $candidate['whatsapp_number'];
            }
            unset($candidate['whatsapp_number']);
        }

        // Monetary fields on orders should reflect the same base total as invoice
        if (Schema::hasColumn('orders', 'total_amount') && !isset($candidate['total_amount'])) {
            $candidate['total_amount'] = $baseTotal;
        }
        if (Schema::hasColumn('orders', 'amount') && !isset($candidate['amount'])) {
            $candidate['amount'] = $baseTotal;
        }
        if (Schema::hasColumn('orders', 'total') && !isset($candidate['total'])) {
            $candidate['total'] = $baseTotal;
        }

        $insert = [];
        foreach ($candidate as $col => $val) {
            if (Schema::hasColumn('orders', $col)) {
                $insert[$col] = $val;
            }
        }

        // As a safety net, if 'notes' column exists, append unsaved fields
        if (Schema::hasColumn('orders', 'notes')) {
            $unsaved = array_diff_key($candidate, $insert);
            if (!empty($unsaved)) {
                $meta = "\n\n[Meta]\n" . json_encode($unsaved, JSON_UNESCAPED_UNICODE);
                $insert['notes'] = ($insert['notes'] ?? '') . $meta;
            }
        }

        // Simpan order dan proses pasca-order dalam transaksi
        DB::transaction(function () use ($insert, $orderCode, $data, $baseTotal) {
            DB::table('orders')->insert($insert);

            // Ambil kembali order yang baru dibuat
            $orderRow = DB::table('orders')
                ->when(Schema::hasColumn('orders', 'order_code'), fn($q) => $q->where('order_code', $orderCode))
                ->when(!Schema::hasColumn('orders', 'order_code') && Schema::hasColumn('orders', 'code'), fn($q) => $q->where('code', $orderCode))
                ->first();

            // Buat/temukan Client berdasarkan email
            $client = Client::firstOrCreate(
                ['email' => $data['customer_email']],
                [
                    'client_name' => $data['customer_name'],
                    'whatsapp' => $data['whatsapp_number'],
                    'address' => '',
                ]
            );

            // $baseTotal sudah dihitung sebelum insert agar order & invoice sinkron

            // Buat Invoice
            $invoice = new Invoice([
                'invoice_code' => 'INV-'.strtoupper(Str::random(6)),
                'client_id' => $client->getKey(),
                'order_id' => $orderRow->order_id ?? null,
                'issue_date' => now()->toDateString(),
                'due_date' => now()->addDays(14)->toDateString(),
                'status' => 'sent',
                'total_amount' => $baseTotal,
            ]);
            $invoice->save();

            // Buat item dasar di invoice
            $desc = 'Order '.$orderCode.(empty($data['package_name']) ? '' : ' - '.$data['package_name']);
            InvoiceItem::create([
                'invoice_id' => $invoice->getKey(),
                'description' => $desc,
                'quantity' => 1,
                'unit_price' => $baseTotal,
                'line_total' => $baseTotal,
            ]);

            // Buat OrderItem (agar modul Orders menampilkan item)
            if (!empty($orderRow?->order_id) && !empty($data['service_id']) && Schema::hasTable('order_items')) {
                OrderItem::create([
                    'order_id' => $orderRow->order_id,
                    'service_id' => (int) $data['service_id'],
                    'price_at_order' => $baseTotal,
                ]);
            }

            // Kirim WhatsApp ke customer dengan CTA ke status pembayaran (signed URL)
            $statusUrl = URL::signedRoute('invoices.public.status', ['invoice' => $invoice->getKey()]);
            SendWhatsAppMessage::dispatchSync(
                to: $data['whatsapp_number'],
                message: self::buildCustomerWaMessage($invoice),
                ctaUrl: $statusUrl,
                templateVars: [
                    $invoice->invoice_code,
                    number_format((float)$invoice->total_amount, 0, ',', '.'),
                    optional($invoice->due_date)->format('d M Y'),
                    $statusUrl,
                ]
            );

            // Notifikasi admin via WhatsApp (jika nomor admin diset di config app.whatsapp_number)
            $adminRaw = config('app.whatsapp_number');
            if (!empty($adminRaw)) {
                $adminMsg = "Order baru masuk\n".
                    'Order: '.$orderCode."\n".
                    'Invoice: '.$invoice->invoice_code."\n".
                    'Customer: '.$data['customer_name'].' ('.$data['customer_email'].')';
                SendWhatsAppMessage::dispatchSync(
                    to: $adminRaw,
                    message: $adminMsg
                );
            }
        });

        return redirect()->route('public.order.success', ['code' => $orderCode]);
    }

    public function success(Request $request)
    {
        $code = $request->string('code');
        // Try fetch by order_code, fallback to code
        $query = DB::table('orders');
        if (Schema::hasColumn('orders', 'order_code')) {
            $query->where('order_code', $code);
        } elseif (Schema::hasColumn('orders', 'code')) {
            $query->where('code', $code);
        }
        $order = $query->first();
        abort_if(!$order, 404);

        // Build WhatsApp link to company number with templated message
        $waRaw = config('app.whatsapp_number', '085156553226');
        $digits = preg_replace('/\D/', '', (string) $waRaw);
        if (Str::startsWith($digits, '0')) { $digits = '62' . substr($digits, 1); }
        $serviceName = null;
        if (Schema::hasColumn('orders', 'service_id') && !empty($order->service_id)) {
            $serviceName = optional(Service::find($order->service_id))->service_name;
        }
        // Resolve common fields possibly using alternative column names
        $orderCodeVal = Schema::hasColumn('orders', 'order_code') ? $order->order_code : ($order->code ?? '');
        $customerNameVal = Schema::hasColumn('orders', 'customer_name') ? $order->customer_name : ($order->name ?? '');
        $customerEmailVal = Schema::hasColumn('orders', 'customer_email') ? $order->customer_email : ($order->email ?? '');
        $customerWaVal = null;
        if (Schema::hasColumn('orders', 'whatsapp_number')) $customerWaVal = $order->whatsapp_number;
        elseif (Schema::hasColumn('orders', 'customer_whatsapp')) $customerWaVal = $order->customer_whatsapp;
        elseif (Schema::hasColumn('orders', 'phone')) $customerWaVal = $order->phone;
        elseif (Schema::hasColumn('orders', 'phone_number')) $customerWaVal = $order->phone_number;

        $lines = [
            'Halo Admin, saya ingin melanjutkan order.',
            'Order Code: ' . $orderCodeVal,
            'Nama: ' . $customerNameVal,
            'Email: ' . $customerEmailVal,
            'WhatsApp: ' . (string) $customerWaVal,
        ];
        if ($serviceName) $lines[] = 'Layanan: ' . $serviceName;
        if (Schema::hasColumn('orders', 'package_name') && !empty($order->package_name)) $lines[] = 'Paket: ' . $order->package_name;
        if (Schema::hasColumn('orders', 'budget') && !empty($order->budget)) $lines[] = 'Budget: ' . number_format((float) $order->budget, 0, ',', '.');
        if (Schema::hasColumn('orders', 'notes') && !empty($order->notes)) $lines[] = 'Catatan: ' . Str::limit($order->notes, 200);
        $message = implode("\n", $lines);
        $waLink = 'https://wa.me/' . $digits . '?text=' . rawurlencode($message);

        // Provide resolved values for the view to avoid undefined property errors
        $orderCodeResolved = $orderCodeVal;
        $customerNameResolved = $customerNameVal;
        $customerEmailResolved = $customerEmailVal;
        $customerWaResolved = $customerWaVal;

        return view('public.order-success', compact(
            'order', 'serviceName', 'waLink',
            'orderCodeResolved', 'customerNameResolved', 'customerEmailResolved', 'customerWaResolved'
        ));
    }
}
