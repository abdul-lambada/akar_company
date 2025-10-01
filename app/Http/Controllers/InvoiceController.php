<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Jobs\SendWhatsAppMessage;
// Email flow removed; using WhatsApp only

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('client')->orderByDesc('invoice_id')->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $clients = Client::orderBy('client_name')->get();
        return view('invoices.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|integer|exists:clients,client_id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|string|max:50',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $invoice = new Invoice($data);
        $invoice->invoice_code = 'INV-'.strtoupper(Str::random(6));
        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Invoice created');
    }

    public function edit(Invoice $invoice)
    {
        $clients = Client::orderBy('client_name')->get();
        return view('invoices.edit', compact('invoice', 'clients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'client_id' => 'required|integer|exists:clients,client_id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|string|max:50',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $invoice->update($data);
        return redirect()->route('invoices.index')->with('success', 'Invoice updated');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client','order','items']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Signed public endpoint to download invoice PDF without authentication.
     */
    public function publicPdf(Invoice $invoice)
    {
        $invoice->load(['client','order','items']);

        $filename = 'Invoice-'.$invoice->invoice_code.'.pdf';

        // Prefer Barryvdh/laravel-dompdf via container binding if available (no direct class reference)
        if (app()->bound('dompdf.wrapper')) {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('invoices.pdf', compact('invoice'));
            return $pdf->download($filename);
        }

        // Fallback to native dompdf if installed (use dynamic class names to avoid static analysis errors)
        $dompdfClass = 'Dompdf\\Dompdf';
        $optionsClass = 'Dompdf\\Options';
        if (class_exists($dompdfClass)) {
            $html = view('invoices.pdf', ['invoice' => $invoice])->render();
            $options = class_exists($optionsClass) ? new $optionsClass() : null;
            if ($options) {
                $options->set('isRemoteEnabled', true);
                $dompdf = new $dompdfClass($options);
            } else {
                $dompdf = new $dompdfClass();
            }
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4');
            $dompdf->render();
            $output = $dompdf->output();
            return response($output)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
        }

        // Last resort: HTML preview
        return response()->view('invoices.pdf', compact('invoice'))->withHeaders([
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Admin download endpoint (requires auth via route group), mirrors publicPdf without signed middleware.
     */
    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load(['client','order','items']);

        $filename = 'Invoice-'.$invoice->invoice_code.'.pdf';

        // Prefer Barryvdh/laravel-dompdf via container binding if available (no direct class reference)
        if (app()->bound('dompdf.wrapper')) {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('invoices.pdf', compact('invoice'));
            return $pdf->download($filename);
        }

        // Fallback to native dompdf if installed (use dynamic class names to avoid static analysis errors)
        $dompdfClass = 'Dompdf\\Dompdf';
        $optionsClass = 'Dompdf\\Options';
        if (class_exists($dompdfClass)) {
            $html = view('invoices.pdf', ['invoice' => $invoice])->render();
            $options = class_exists($optionsClass) ? new $optionsClass() : null;
            if ($options) {
                $options->set('isRemoteEnabled', true);
                $dompdf = new $dompdfClass($options);
            } else {
                $dompdf = new $dompdfClass();
            }
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4');
            $dompdf->render();
            $output = $dompdf->output();
            return response($output)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
        }

        // Last resort: HTML preview
        return response()->view('invoices.pdf', compact('invoice'))->withHeaders([
            'Content-Type' => 'application/pdf',
        ]);
    }

    private function buildCustomerWaMessage(Invoice $invoice): string
    {
        $pdfLink = URL::signedRoute('invoices.public.pdf', ['invoice' => $invoice->getKey()]);
        $statusLink = URL::signedRoute('invoices.public.status', ['invoice' => $invoice->getKey()]);
        $orderCode = optional($invoice->order)->order_code;
        $lines = [
            'Halo ' . ($invoice->client->client_name ?? 'Pelanggan') . ',',
            'Berikut detail invoice Anda.',
            ($orderCode ? ('Order: ' . $orderCode) : null),
            'Invoice: ' . $invoice->invoice_code,
            'Total: Rp ' . number_format((float) $invoice->total_amount, 0, ',', '.'),
            'Jatuh Tempo: ' . optional($invoice->due_date)->format('d M Y'),
            'Status & Konfirmasi Pembayaran: ' . $statusLink,
            'Unduh Invoice (PDF): ' . $pdfLink,
            'Terima kasih, ' . config('app.name'),
        ];
        return implode("\n", array_filter($lines));
    }

    public function sendWhatsApp(Request $request, Invoice $invoice)
    {
        $invoice->loadMissing(['client', 'order', 'items']);
        $to = (string) optional($invoice->client)->whatsapp;
        if (empty($to)) {
            return redirect()->route('invoices.show', $invoice)->with('danger', 'Nomor WhatsApp pelanggan tidak tersedia.');
        }

        $statusUrl = URL::signedRoute('invoices.public.status', ['invoice' => $invoice->getKey()]);
        $message = $this->buildCustomerWaMessage($invoice);

        // Local: send synchronously so Settings changes take effect without worker restart
        if (app()->environment('local')) {
            SendWhatsAppMessage::dispatchSync(
                to: $to,
                message: $message,
                ctaUrl: $statusUrl,
                templateVars: [
                    $invoice->invoice_code,
                    optional($invoice->due_date)->format('d M Y'),
                    number_format((float) $invoice->total_amount, 0, ',', '.'),
                    $statusUrl,
                ]
            );
        } else {
            // Production: queue for non-blocking
            SendWhatsAppMessage::dispatch(
                to: $to,
                message: $message,
                ctaUrl: $statusUrl,
                templateVars: [
                    $invoice->invoice_code,
                    optional($invoice->due_date)->format('d M Y'),
                    number_format((float) $invoice->total_amount, 0, ',', '.'),
                    $statusUrl,
                ]
            );
        }

        return redirect()->route('invoices.show', $invoice)->with('success', 'WhatsApp berhasil dikirim ke pelanggan.');
    }

    private function buildAdminWaMessage(Invoice $invoice): string
    {
        $adminLink = route('invoices.show', $invoice);
        $clientName = optional($invoice->client)->client_name ?: '-';
        $lines = [
            'Follow-up internal Invoice',
            'Invoice: ' . $invoice->invoice_code,
            'Client: ' . $clientName,
            'Total: Rp ' . number_format((float) $invoice->total_amount, 0, ',', '.'),
            'Link Admin: ' . $adminLink,
        ];
        return implode("\n", $lines);
    }

    public function sendWhatsAppAdmin(Request $request, Invoice $invoice)
    {
        $invoice->loadMissing(['client', 'order', 'items']);
        $adminRaw = config('app.whatsapp_number') ?: config('app.company_whatsapp');
        if (empty($adminRaw)) {
            return redirect()->route('invoices.show', $invoice)->with('danger', 'Nomor WhatsApp admin belum diset di Settings.');
        }

        $ctaUrl = route('invoices.show', $invoice);
        $message = $this->buildAdminWaMessage($invoice);

        if (app()->environment('local')) {
            SendWhatsAppMessage::dispatchSync(
                to: $adminRaw,
                message: $message,
                ctaUrl: $ctaUrl,
                templateVars: [
                    $invoice->invoice_code,
                    optional($invoice->due_date)->format('d M Y'),
                    number_format((float) $invoice->total_amount, 0, ',', '.'),
                    $ctaUrl,
                ]
            );
        } else {
            SendWhatsAppMessage::dispatch(
                to: $adminRaw,
                message: $message,
                ctaUrl: $ctaUrl,
                templateVars: [
                    $invoice->invoice_code,
                    optional($invoice->due_date)->format('d M Y'),
                    number_format((float) $invoice->total_amount, 0, ',', '.'),
                    $ctaUrl,
                ]
            );
        }

        return redirect()->route('invoices.show', $invoice)->with('success', 'WhatsApp berhasil dikirim ke Admin.');
    }

}