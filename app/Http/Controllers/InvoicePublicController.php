<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class InvoicePublicController extends Controller
{
    // Tampilkan halaman status pembayaran (signed public route)
    public function status(Invoice $invoice)
    {
        $invoice->load(['client','order','items']);
        return view('invoices.status', compact('invoice'));
    }

    // Tandai invoice sebagai paid (signed public route)
    public function confirmPaid(Request $request, Invoice $invoice)
    {
        $invoice->load(['client']);

        $updates = ['status' => 'paid'];
        // Jika ada kolom paid_at pada tabel invoices, set waktu bayar
        if (Schema::hasColumn($invoice->getTable(), 'paid_at')) {
            $updates['paid_at'] = now();
        }
        $invoice->update($updates);

        return back()->with('success', 'Terima kasih, status pembayaran telah ditandai sebagai Lunas.');
    }
}
