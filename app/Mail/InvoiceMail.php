<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invoice $invoice,
        public ?string $pdfBinary = null,
        public ?string $pdfFilename = null,
    )
    {
    }

    public function build(): self
    {
        $mail = $this->subject('Invoice '.$this->invoice->invoice_code)
            ->view('emails.invoice', [
                'invoice' => $this->invoice,
            ]);

        // Lampirkan PDF jika tersedia
        if ($this->pdfBinary && $this->pdfFilename) {
            $mail->attachData($this->pdfBinary, $this->pdfFilename, [
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
