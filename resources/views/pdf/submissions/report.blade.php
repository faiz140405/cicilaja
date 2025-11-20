<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pengajuan Kredit - CicilAja</title>
    <style>
        /* CSS Reset & Font Dasar */
        @page { margin: 20px 30px; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif; /* Font aman untuk PDF */
            font-size: 9pt;
            color: #333;
            line-height: 1.4;
        }

        /* Header / Kop Surat */
        .header-table { width: 100%; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; margin-bottom: 20px; }
        .brand-name { font-size: 24pt; font-weight: bold; color: #4f46e5; text-transform: uppercase; margin: 0; }
        .brand-subtitle { font-size: 10pt; color: #666; letter-spacing: 1px; margin-top: 2px; }
        .company-info { text-align: right; font-size: 9pt; color: #555; }

        /* Judul Laporan */
        .report-title { text-align: center; margin-bottom: 20px; }
        .report-title h2 { margin: 0; font-size: 16pt; text-transform: uppercase; color: #1f2937; }
        .report-title p { margin: 5px 0 0; font-size: 10pt; color: #6b7280; }

        /* Tabel Data Utama */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th {
            background-color: #4f46e5; /* Warna Indigo */
            color: #ffffff;
            padding: 10px 8px;
            text-align: left;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .data-table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        
        /* Zebra Striping (Baris Belang) */
        .data-table tbody tr:nth-child(even) { background-color: #f3f4f6; }
        
        /* Total Row Style */
        .total-row td {
            background-color: #e0e7ff;
            font-weight: bold;
            color: #312e81;
            border-top: 2px solid #4f46e5;
            padding: 12px 8px;
        }

        /* Status Badges (Simulasi Badge CSS untuk PDF) */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }
        .badge-approved { background-color: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        .badge-pending { background-color: #fef3c7; color: #92400e; border: 1px solid #f59e0b; }
        .badge-rejected { background-color: #fee2e2; color: #b91c1c; border: 1px solid #ef4444; }
        .badge-fully_paid { background-color: #dbeafe; color: #1e40af; border: 1px solid #3b82f6; }
        .badge-default { background-color: #f3f4f6; color: #374151; border: 1px solid #d1d5db; }

        /* Footer Tanda Tangan */
        .signature-section {
            width: 100%;
            margin-top: 40px;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-line {
            margin-top: 70px;
            border-top: 1px solid #333;
        }

        /* Footer Halaman */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
            font-size: 8pt;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        
        /* Utilities */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-mono { font-family: 'Courier New', Courier, monospace; }
    </style>
</head>
<body>
    
    {{-- FOOTER HALAMAN (Akan muncul di tiap halaman bawah) --}}
    <div class="footer">
        Dicetak oleh Sistem CicilAja pada {{ date('d/m/Y H:i') }} WIB | Halaman <span class="page-number"></span>
    </div>

    {{-- HEADER KOP SURAT --}}
    <table class="header-table">
        <tr>
            <td width="60%">
                <h1 class="brand-name">CICILAJA</h1>
                <div class="brand-subtitle">Solusi Kredit Mudah & Cepat</div>
            </td>
            <td width="40%" class="company-info">
                <strong>PT. Cicil Aja Indonesia</strong><br>
                Jl. Karang Rejo, Kec. Semaka<br>
                Tanggamus, Lampung<br>
                Email: admin@cicilaja.com<br>
                Telp: (021) 555-0123
            </td>
        </tr>
    </table>

    {{-- JUDUL LAPORAN --}}
    <div class="report-title">
        <h2>Laporan Pengajuan Kredit</h2>
        <p>Periode: Semua Data hingga {{ date('d F Y') }}</p>
    </div>

    {{-- TABEL DATA --}}
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Pemohon</th>
                <th width="20%">Produk</th>
                <th width="12%" class="text-right">Harga Kredit</th>
                <th width="10%" class="text-right">Uang Muka</th>
                <th width="8%" class="text-center">Tenor</th>
                <th width="12%" class="text-right">Cicilan/Bln</th>
                <th width="13%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach ($submissions as $index => $submission)
                @php 
                    $grandTotal += $submission->total_credit_amount;
                    
                    // Logic Badge Class
                    $statusClass = match($submission->status) {
                        'approved' => 'badge-approved',
                        'pending' => 'badge-pending',
                        'rejected' => 'badge-rejected',
                        'fully_paid' => 'badge-fully_paid',
                        default => 'badge-default'
                    };
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td> {{-- Gunakan loop iteration agar urut --}}
                    <td>
                        <strong>{{ $submission->user->name ?? 'N/A' }}</strong><br>
                        <span style="font-size: 8pt; color: #666;">{{ $submission->user->email }}</span>
                    </td>
                    <td>{{ $submission->product->name ?? 'Produk Dihapus' }}</td>
                    <td class="text-right font-mono">Rp {{ number_format($submission->total_credit_amount, 0, ',', '.') }}</td>
                    <td class="text-right font-mono">Rp {{ number_format($submission->down_payment, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $submission->tenor }} Bln</td>
                    <td class="text-right font-mono">Rp {{ number_format($submission->monthly_installment, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <span class="badge {{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                        </span>
                    </td>
                </tr>
            @endforeach
            
            {{-- BARIS TOTAL --}}
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL NILAI KREDIT KESELURUHAN</td>
                <td colspan="5" class="text-left" style="padding-left: 15px;">
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- KOLOM TANDA TANGAN --}}
    <div class="signature-section">
        <div class="signature-box">
            <p>Bandar Lampung, {{ date('d F Y') }}</p>
            <p>Mengetahui, Admin Keuangan</p>
            <div class="signature-line"></div>
            <p><strong>( ........................................... )</strong></p>
        </div>
    </div>

</body>
</html>