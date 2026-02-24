<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice_no }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            padding: 10px 30px;
        }

        /* ── HEADER ── */
        .header {
            display: table;
            width: 100%;
            border-bottom: 3px solid #c9a227;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }
        .header-logo {
            display: table-cell;
            width: 120px;
            vertical-align: middle;
        }
        .header-logo img { width: 110px; }
        .header-info {
            display: table-cell;
            vertical-align: middle;
            padding-left: 14px;
        }
        .header-info .company-name {
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .header-info .address {
            font-size: 9.5px;
            color: #555;
            margin-top: 3px;
            line-height: 1.6;
        }

       /* ── META ── */
        .meta-row {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            padding: 0 4px;         /* ✅ tambahan */
        }
        .meta-left {
            display: table-cell;
            width: 55%;
            vertical-align: top;
            padding-right: 10px;    /* ✅ tambahan */
        }
        .meta-right {
            display: table-cell;
            width: 45%;
            vertical-align: top;
            text-align: right;
            padding-left: 10px;     /* ✅ tambahan */
        }
        .meta-label {
            font-size: 10px;
            color: #888;
            margin-top: 8px;        /* ✅ lebih lega */
        }
        .meta-value {
            font-size: 11px;
            font-weight: bold;
            margin-top: 2px;        /* ✅ sedikit jarak */
        }
        .meta-date {
            font-size: 11px;
            color: #333;
            margin-bottom: 14px;
        }
        .badge-invoice {
            display: inline-block;
            background: #c9a227;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            padding: 4px 14px;
            border-radius: 4px;
            letter-spacing: 1px;
            margin-bottom: 10px;    /* ✅ lebih lega */
        }

        /* ── DESKRIPSI ── */
        .description {
            background: #f8f6f0;
            border-left: 4px solid #c9a227;
            padding: 8px 14px;
            font-size: 10.5px;
            color: #444;
            margin-bottom: 18px;
        }

        /* ── TABEL ── */
        table.invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.invoice-table thead tr {
            background: #1a1a1a;
            color: #c9a227;
        }
        table.invoice-table thead th {
            padding: 9px 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table.invoice-table tbody tr:nth-child(even) { background: #fafafa; }
        table.invoice-table tbody tr:nth-child(odd)  { background: #ffffff; }
        table.invoice-table tbody td {
            padding: 9px 12px;
            border-bottom: 1px solid #efefef;
            font-size: 10.5px;
        }
        .text-right  { text-align: right; }
        .text-center { text-align: center; }

        /* ── GRAND TOTAL ── */
        .total-row    { display: table; width: 100%; margin-top: 6px; }
        .total-spacer { display: table-cell; width: 60%; }
        .total-box    { display: table-cell; width: 40%; }
        .total-inner  {
            background: #1a1a1a;
            color: #fff;
            border-radius: 6px;
            padding: 10px 14px;
        }
        .total-label { font-size: 10px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; }
        .total-value { font-size: 16px; font-weight: bold; color: #c9a227; margin-top: 2px; }

        /* ── CATATAN & TANDA TANGAN ── */
        .note-payment { display: table; width: 100%; margin-top: 24px; padding: 0 10px;}
        .note-box     { display: table-cell; width: 55%; vertical-align: top; padding-right: 30px; padding-left: 10px; }
        .sign-box     { display: table-cell; width: 45%; vertical-align: top; text-align: right; padding-right: 10px;}

        .note-title { font-weight: bold; font-size: 10.5px; margin-bottom: 5px; }
        .note-text  { font-size: 10px; color: #444; line-height: 1.7; }
        .note-highlight { color: #c9a227; font-weight: bold; }

        .payment-bank {
            margin-top: 10px;
            background: #f8f6f0;
            border: 1px solid #e8d99a;
            border-radius: 6px;
            padding: 8px 12px;
        }
        .bank-name { font-weight: bold; font-size: 11px; }
        .bank-acc  { font-size: 13px; font-weight: bold; color: #c9a227; letter-spacing: 1px; margin-top: 2px; }
        .bank-an   { font-size: 10px; color: #555; }

        .sign-title { font-size: 10px; color: #555; margin-bottom: 48px; }
        .sign-name  {
            font-weight: bold;
            font-size: 11px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
            display: inline-block;
        }

        /* ── FOOTER ── */
        .footer {
            margin-top: 28px;
            border-top: 1px solid #e8d99a;
            padding-top: 8px;
            text-align: center;
            font-size: 9px;
            color: #aaa;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo">
        </div>
        <div class="header-info">
            <div class="company-name">CENTRA TELEMEDIA</div>
            <div class="address">
                Alamat: JL. Kebonsari Baru Selatan III/23, Jambangan, Surabaya, 60233<br>
                Phone: 081230422497 &nbsp;|&nbsp; E-Mail: centra.telemedia@gmail.com
            </div>
        </div>
    </div>

    {{-- META --}}
    <div class="meta-row">
        <div class="meta-left">
            <div class="meta-date">
                Surabaya, {{ $tanggal->translatedFormat('d F Y') }}
            </div>
            <div class="meta-label">Kepada Yth.</div>
            <div class="meta-value">{{ $kepada }}</div>
            <div style="margin-top:6px; font-size:10.5px; color:#555;">
                {{ $alamat }}
            </div>
        </div>
        <div class="meta-right">
            <div class="badge-invoice">INVOICE</div>
            <br>
            <div class="meta-label">Username</div>
            <div class="meta-value">{{ $username }}</div>
            <div class="meta-label">No. Invoice</div>
            <div class="meta-value">{{ $invoice_no }}</div>
        </div>
    </div>

    {{-- DESKRIPSI --}}
    <div class="description">
        {{ $keterangan }}
    </div>

    {{-- TABEL ITEM --}}
    <table class="invoice-table">
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th style="width:38%;">User Name / Layanan</th>
                <th class="text-right" style="width:18%;">QTY</th>
                <th class="text-right" style="width:20%;">Harga / Satuan</th>
                <th class="text-right" style="width:19%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $i => $item)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $item['nama'] }}</td>
                <td class="text-right">{{ number_format($item['qty'], 0, ',', '.') }} {{ $item['satuan'] }}</td>
                <td class="text-right">@ Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- GRAND TOTAL --}}
    <div class="total-row">
        <div class="total-spacer"></div>
        <div class="total-box">
            <div class="total-inner">
                <div class="total-label">Total Tagihan</div>
                <div class="total-value">Rp {{ number_format($grand_total, 0, ',', '.') }},-</div>
            </div>
        </div>
    </div>

    {{-- CATATAN & TANDA TANGAN --}}
    <div class="note-payment">
        <div class="note-box">
            <div class="note-title">Catatan Pembayaran</div>
            <div class="note-text">
                Jatuh Tempo Pembayaran:
                <span class="note-highlight">{{ $jatuh_tempo->translatedFormat('d F Y') }}</span>
            </div>
            <div class="payment-bank">
                <div class="bank-name">Bank {{ $rekening['bank'] }}</div>
                <div class="bank-acc">{{ $rekening['nomor'] }}</div>
                <div class="bank-an">a.n. {{ $rekening['nama'] }}</div>
            </div>
        </div>
        <div class="sign-box">
            <div class="sign-title">
                Hormat Kami,<br>
                CENTRA TELEMEDIA
            </div>
            <div class="sign-name">Lilis Sugijanti</div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        Dokumen ini dibuat secara otomatis oleh sistem invoice Centra Telemedia.
        Harap simpan sebagai bukti tagihan resmi.
    </div>

</body>
</html>