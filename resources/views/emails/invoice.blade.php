@php
    $companyName = config('company.name');
@endphp

<p>Halo {{ $invoice->client->client_name ?? 'Klien' }},</p>

<p>Terlampir invoice Anda dengan kode <strong>{{ $invoice->invoice_code }}</strong>.
Silakan tinjau rincian tagihan pada lampiran PDF atau melalui tautan berikut:</p>

<p><a href="{{ route('invoices.show', $invoice) }}">Lihat Invoice di {{ $companyName }}</a></p>

<table role="presentation" style="border-collapse:collapse; width: 100%; max-width: 480px;">
    <tr>
        <td style="padding:6px 8px; border:1px solid #e5e7eb;">Tanggal Terbit</td>
        <td style="padding:6px 8px; border:1px solid #e5e7eb;">{{ optional($invoice->issue_date)->format('d M Y') }}</td>
    </tr>
    <tr>
        <td style="padding:6px 8px; border:1px solid #e5e7eb;">Jatuh Tempo</td>
        <td style="padding:6px 8px; border:1px solid #e5e7eb;">{{ optional($invoice->due_date)->format('d M Y') }}</td>
    </tr>
    <tr>
        <td style="padding:6px 8px; border:1px solid #e5e7eb;">Total</td>
        <td style="padding:6px 8px; border:1px solid #e5e7eb;">@currency((float) $invoice->total_amount)</td>
    </tr>
</table>

<p>Terima kasih,<br>{{ $companyName }}</p>
