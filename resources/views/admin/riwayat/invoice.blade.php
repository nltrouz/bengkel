<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Premium | ABAKURA RACING</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2A4365;
            --secondary: #4299E1;
            --accent: #48BB78;
        }

        .container {
            width: 70%;
            /* Kurangi lebar konten */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            margin: 0;
            /* Menghapus margin body */
            padding: 20px;
            /* Menambahkan padding ke body */
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            /* Mempertebal shadow */
            overflow: hidden;
            width: calc(100% - 40px);
            /* Memastikan container tidak menempel di tepi */
        }

        .header-section {
            background: var(--primary);
            padding: 2rem;
            color: white;
            position: relative;
        }

        .invoice-title {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .invoice-title h1 {
            font-size: 2.2rem;
            margin: 0;
            letter-spacing: 1px;
        }

        .invoice-title .subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .status-badge {
            background: var(--accent);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            position: absolute;
            right: 2rem;
            top: 2rem;
        }

        .client-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            padding: 2rem;
            background: #EBF8FF;
        }

        .info-group p {
            margin: 6px 0;
        }

        .info-label {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.9rem;
            background-color: #f0f0f0;
            /* Warna abu-abu terang */
            padding: 5px 10px;
            /* Padding agar lebih rapi */
            border-radius: 5px;
            /* Sudut sedikit melengkung */
            display: inline-block;
            /* Agar tidak melebar ke seluruh layar */
            font-weight: bold;
            /* Membuat teks lebih menonjol */
        }

        .info-value {
            font-size: 1rem;
            color: #2d3748;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
        }

        .items-table thead {
            background: var(--primary);
            color: white;
        }

        .items-table th {
            padding: 1rem;
            font-weight: 500;
            text-align: left;
        }

        .items-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .text-right {
            text-align: right;
        }

        .monospace {
            font-family: 'Courier New', monospace;
        }

        .total-section {
            padding: 1.5rem 2rem;
            background: #f8fafc;
            margin: 2rem;
            border-radius: 8px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .grand-total {
            font-size: 1.4rem;
            color: var(--primary);
            font-weight: 700;
        }

        .footer-section {
            padding: 2rem;
            background: var(--primary);
            color: white;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .footer-group h4 {
            margin: 0 0 1rem 0;
        }

        .footer-group p {
            margin: 0.3rem 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .notes-section {
            padding: 0 2rem 2rem 2rem;
            color: #718096;
        }

        /* Tambahkan media query untuk mobile */
        @media (max-width: 640px) {
            .client-info {
                grid-template-columns: 1fr !important;
                padding: 1rem !important;
            }

            .status-badge {
                position: static !important;
                margin: 0 auto 1rem auto !important;
                width: fit-content;
            }

            .footer-section {
                grid-template-columns: 1fr !important;
                padding: 1.5rem !important;
            }
        }

        @page {
            size: A4 Portrait;
            margin: 1mm;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header-section">
            <div class="status-badge">
                {{ ucfirst($riwayat->status) }}
            </div>
            <div class="invoice-title">
                <h1>ABAKURA RACING</h1>
                <div class="subtitle">INVOICE SERVIS PREMIUM</div>
            </div>

            <div class="client-info">
                <div class="info-group">
                    <p class="info-label">Tanggal Invoice :</p>
                    <p class="info-value">{{ $riwayat->tanggal }}</p>

                    <p class="info-label">Nomor Polisi :</p>
                    <p class="info-value">{{ $riwayat->nopol }}</p>

                    <p class="info-label">Catatan Servis :</p>
                    <p class="info-value">{{ $riwayat->catatan }}</p>
                </div>

                <div class="info-group">
                    <p class="info-label">Pelanggan :</p>
                    <p class="info-value">{{ $riwayat->pelanggan->nama ?? '-' }}</p>

                    <p class="info-label">Teknisi :</p>
                    <p class="info-value">{{ $riwayat->karyawan->nama ?? '-' }}</p>

                    <p class="info-label">Penanganan :</p>
                    <p class="info-value">{{ $riwayat->penanganan }}</p>
                </div>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Qty</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total_harga = 0;
                @endphp

                <!-- Jasa Servis -->
                <tr>
                    <td>
                        <strong>{{ $riwayat->jasaServis->jenis ?? '-' }}</strong><br>
                        <small>Keluhan: {{ $riwayat->keluhan }}</small>
                    </td>
                    <td>1</td>
                    <td class="text-right monospace">{{ number_format($riwayat->jasaServis->harga ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right monospace">{{ number_format($riwayat->jasaServis->harga ?? 0, 0, ',', '.') }}</td>
                </tr>
                @php
                $total_harga += $riwayat->jasaServis->harga ?? 0;
                @endphp

                <!-- Spareparts -->
                @foreach ($riwayat->spareparts as $sparepart)
                @php
                $subtotal_sparepart = $sparepart->pivot->jumlah * $sparepart->harga;
                $total_harga += $subtotal_sparepart;
                @endphp
                <tr>
                    <td>{{ $sparepart->nama }} ({{ $sparepart->kode ?? 'N/A' }})</td>
                    <td>{{ $sparepart->pivot->jumlah }}</td>
                    <td class="text-right monospace">{{ number_format($sparepart->harga, 0, ',', '.') }}</td>
                    <td class="text-right monospace">{{ number_format($subtotal_sparepart, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal</span>
                <span class="monospace">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL PEMBAYARAN</span>
                <span class="monospace">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer-section">
            <div class="footer-group">
                <h4>Metode Pembayaran</h4>
                <p>Bank Central Asia</p>
                <p>No. Rek: 0987 6543 210</p>
                <p>Atas Nama: ABAKURA RACING</p>
            </div>

            <div class="footer-group">
                <h4>Kontak</h4>
                <p>Jl. Teknik Komputer No. 123</p>
                <p>Telp: (022) 1234 5678</p>
                <p>Email: info@abakuraracing.id</p>
            </div>
        </div>
    </div>
</body>

</html>