<?php

namespace App\Jobs;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $invoiceId)
    {
    }

    public function handle(): void
    {
        $invoice = Invoice::with(['client','items','order'])->find($this->invoiceId);
        if (!$invoice || !$invoice->client || empty($invoice->client->email)) {
            Log::warning('SendInvoiceEmail skipped: invoice or client email missing', ['invoice_id' => $this->invoiceId]);
            return;
        }

        $pdfBinary = null;
        $pdfFilename = null;

        // Generate PDF only if dompdf is available
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', [
                'invoice' => $invoice,
            ]);
            $pdfBinary = $pdf->output();
            $pdfFilename = 'Invoice-'.$invoice->invoice_code.'.pdf';
        }

        Mail::to($invoice->client->email)->send(new InvoiceMail(
            invoice: $invoice,
            pdfBinary: $pdfBinary,
            pdfFilename: $pdfFilename,
        ));
    }
}
