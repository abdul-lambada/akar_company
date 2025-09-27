<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_code }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #111; font-size: 13px; }
        .container { width: 100%; max-width: 900px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand h2 { margin: 0; letter-spacing: 1px; }
        .logo { width: 56px; height: 56px; object-fit: contain; border-radius: 8px; border: 1px solid #e5e7eb; background: #fff; }
        .muted { color: #666; }
        .pill { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #eef2ff; color: #3730a3; font-size: 12px; border: 1px solid #e5e7eb; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .card { border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        th, td { border: 1px solid #e5e7eb; padding: 10px 12px; text-align: left; vertical-align: top; }
        th { background: #f8fafc; font-weight: 600; }
        .right { text-align: right; }
        .total { font-weight: 700; }
        .summary { width: 100%; max-width: 360px; margin-left: auto; }
        .note { background: #fff7ed; border: 1px solid #fed7aa; color: #7c2d12; padding: 10px; border-radius: 6px; margin: 16px 0; }
        .footer { margin-top: 26px; font-size: 12px; color: #555; border-top: 1px dashed #e5e7eb; padding-top: 10px; }
        .small { font-size: 12px; }
        .company { line-height: 1.5; }
    </style>
</head>
<body>
<div class="container">
    @isset($pdf_unavailable)
        <div class="note">
            Paket PDF belum terpasang. Ini adalah preview HTML. Untuk mengunduh sebagai PDF, pasang paket <strong>barryvdh/laravel-dompdf</strong> terlebih dahulu.
        </div>
    @endisset

    @php
        // Data perusahaan dari config
        $companyName = config('company.name');
        $companyAddress = config('company.address');
        $companyEmail = config('company.email');
        $companyPhone = config('company.phone');
        $companyLogo = ltrim((string) config('company.logo_path', 'favicon.ico'), '/');

        // Gunakan asset() saat preview HTML agar gambar tampil di browser,
        // dan gunakan public_path() saat generate PDF (Dompdf butuh path file lokal).
        $isPdf = !isset($pdf_unavailable);

        // Dompdf tidak mendukung .ico dan membutuhkan path file yang benar.
        // Fallback ke logo NiceAdmin jika file tidak ada atau ekstensi .ico.
        $ext = strtolower(pathinfo($companyLogo, PATHINFO_EXTENSION));
        $candidate = $companyLogo;
        if ($ext === 'ico' || !file_exists(public_path($companyLogo))) {
            $candidate = 'NiceAdmin/assets/img/logo.png';
        }

        $logoSrc = $isPdf ? public_path($candidate) : asset($candidate);
    @endphp

    <div class="header">
        <div class="brand">
            {{-- Logo perusahaan (opsional). Ganti src sesuai aset/logo Anda. --}}
            <img class="logo" src="{{ $logoSrc }}" alt="Logo">
            <div>
                <h2>{{ $companyName }}</h2>
                <div class="muted small company">{{ $companyAddress }}<br>{{-- {{ $companyEmail }} • --}} {{ $companyPhone }}</div>
            </div>
        </div>
        <div class="meta right">
            <div class="muted">Kode</div>
            <div><strong>{{ $invoice->invoice_code }}</strong></div>
            <div class="muted" style="margin-top:8px;">Tanggal Terbit</div>
            <div><strong>{{ optional($invoice->issue_date)->format('d M Y') }}</strong></div>
            <div class="muted" style="margin-top:8px;">Jatuh Tempo</div>
            <div><strong>{{ optional($invoice->due_date)->format('d M Y') }}</strong></div>
            <div style="margin-top:8px;">Status: <span class="pill">{{ strtoupper($invoice->status) }}</span></div>
        </div>
    </div>

    <div class="grid">
        <div class="card">
            <div class="muted small">Ditagihkan Kepada</div>
            <div style="margin-top:4px;">
                <strong>{{ $invoice->client->client_name ?? '-' }}</strong><br>
                {{-- {{ $invoice->client->email ?? '-' }} --}}<br>
                {{ $invoice->client->whatsapp ?? '-' }}<br>
                {{ $invoice->client->address ?? '-' }}
            </div>
        </div>
        <div class="card">
            <div class="muted small">Informasi Invoice</div>
            <div style="margin-top:4px;">
                Kode: <strong>{{ $invoice->invoice_code }}</strong><br>
                Order: <strong>{{ $invoice->order_id ?? '-' }}</strong><br>
                Dibuat: <strong>{{ optional($invoice->created_at)->format('d M Y H:i') }}</strong>
            </div>
        </div>
    </div>

    @php
        $hasItems = isset($invoice) && $invoice->relationLoaded('items') && $invoice->items && $invoice->items->count() > 0;
        if ($hasItems) {
            $subtotal = (float) $invoice->items->sum('line_total');
        } else {
            $subtotal = (float) ($invoice->total_amount ?? 0);
        }
        $tax = 0; // Sesuaikan jika ada PPN/Pajak
        $grand = $subtotal + $tax;
    @endphp

    <table>
        <thead>
        <tr>
            <th style="width:58%">Deskripsi</th>
            <th style="width:10%" class="right">Qty</th>
            <th style="width:16%" class="right">Harga</th>
            <th style="width:16%" class="right">Jumlah</th>
        </tr>
        </thead>
        <tbody>
        @if($hasItems)
            @foreach($invoice->items as $it)
                <tr>
                    <td>{{ $it->description }}</td>
                    <td class="right">{{ number_format($it->quantity) }}</td>
                    <td class="right">@currency((float)$it->unit_price)</td>
                    <td class="right">@currency((float)$it->line_total)</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td>Jasa/Produk sesuai order {{ $invoice->order_id ?? '-' }}</td>
                <td class="right">1</td>
                <td class="right">@currency($subtotal)</td>
                <td class="right">@currency($subtotal)</td>
            </tr>
        @endif
        </tbody>
    </table>

    <table class="summary">
        <tbody>
        <tr>
            <td>Subtotal</td>
            <td class="right">@currency($subtotal)</td>
        </tr>
        <tr>
            <td>Pajak</td>
            <td class="right">@currency($tax)</td>
        </tr>
        <tr>
            <td class="total">Total</td>
            <td class="total right">@currency($grand)</td>
        </tr>
        </tbody>
    </table>

    <div class="footer">
        <div><strong>Catatan:</strong> Harap melakukan pembayaran sebelum tanggal jatuh tempo. Abaikan jika sudah melakukan pembayaran.</div>
        <div class="small">Dokumen ini dibuat secara otomatis oleh sistem Akar Company Sekawan.</div>
    </div>
</div>
</body>
</html>
