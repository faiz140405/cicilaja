<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengajuan Kredit</title>
    <style>
        body { font-family: 'Poppins', sans-serif; font-size: 10pt; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #5a57a8; padding-bottom: 10px; }
        .header h1 { color: #5a57a8; margin: 0; font-size: 24pt; }
        .header p { color: #555; margin: 0; font-size: 12pt; }
        .content { margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-size: 10pt; }
        .total-row td { font-weight: bold; background-color: #e0e7ff; }
    </style>
</head>
<body>
    
    {{-- HEADER KUSTOM CICILAJA --}}
    <div class="header">
        <h1>CICILAJA</h1>
        <p>Laporan Detail Pengajuan Kredit - {{ date('d F Y') }}</p>
    </div>

    <div class="content">
        <h2>Ringkasan Transaksi</h2>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pemohon</th>
                    <th>Produk</th>
                    <th>Harga Kredit</th>
                    <th>DP</th>
                    <th>Tenor</th>
                    <th>Cicilan/Bulan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach ($submissions as $submission)
                    @php $grandTotal += $submission->total_credit_amount; @endphp
                    <tr>
                        <td>{{ $submission->id }}</td>
                        <td>{{ $submission->user->name ?? 'N/A' }}</td>
                        <td>{{ $submission->product->name ?? 'N/A' }}</td>
                        <td>Rp {{ number_format($submission->total_credit_amount, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($submission->down_payment, 0, ',', '.') }}</td>
                        <td>{{ $submission->tenor }} Bln</td>
                        <td>Rp {{ number_format($submission->monthly_installment, 0, ',', '.') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $submission->status)) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">TOTAL KESELURUHAN NILAI KREDIT</td>
                    <td colspan="5">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>