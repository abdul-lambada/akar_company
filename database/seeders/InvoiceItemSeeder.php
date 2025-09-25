<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;

class InvoiceItemSeeder extends Seeder
{
    public function run(): void
    {
        // Untuk setiap invoice, buat 2-4 item acak dan update total invoice
        Invoice::query()->orderBy('invoice_id')->chunk(50, function ($chunk) {
            foreach ($chunk as $invoice) {
                // Hapus item lama agar idempotent
                $invoice->items()->delete();

                $count = rand(2, 4);
                $subtotal = 0;
                for ($i = 0; $i < $count; $i++) {
                    $qty = rand(1, 5);
                    $price = rand(100000, 3000000);
                    $line = $qty * $price;
                    InvoiceItem::create([
                        'invoice_id' => $invoice->getKey(),
                        'description' => 'Item layanan #' . ($i + 1),
                        'quantity' => $qty,
                        'unit_price' => $price,
                        'line_total' => $line,
                    ]);
                    $subtotal += $line;
                }

                // Pajak 0% untuk sekarang; sesuaikan jika perlu
                $invoice->update([
                    'total_amount' => $subtotal,
                ]);
            }
        });
    }
}
