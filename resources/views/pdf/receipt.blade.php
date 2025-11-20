<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuitansi Pembayaran</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; padding: 20px; }
        .container { border: 2px solid #4f46e5; padding: 30px; position: relative; }
        
        /* Header */
        .header { display: table; width: 100%; border-bottom: 2px dashed #ccc; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #4f46e5; text-transform: uppercase; }
        .receipt-title { text-align: right; font-size: 20px; font-weight: bold; color: #555; }
        
        /* Content */
        .row { margin-bottom: 15px; display: table; width: 100%; }
        .label { display: table-cell; width: 150px; font-weight: bold; color: #666; }
        .value { display: table-cell; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        
        /* Total Box */
        .amount-box {
            background-color: #e0e7ff;
            color: #312e81;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            display: inline-block;
            border-radius: 5px;
            margin-top: 20px;
        }

        /* Footer */
        .footer { margin-top: 40px; text-align: right; }
        .signature { margin-top: 60px; border-top: 1px solid #333; display: inline-block; width: 200px; text-align: center; padding-top: 5px; }

        /* Stamp LUNAS */
        .stamp {
            position: absolute;
            top: 150px;
            right: 50px;
            border: 3px solid #22c55e;
            color: #22c55e;
            font-size: 30px;
            font-weight: bold;
            padding: 10px 20px;
            text-transform: uppercase;
            transform: rotate(-15deg);
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="container">
        {{-- STAMP LUNAS --}}
        <div class="stamp">LUNAS</div>

        {{-- HEADER --}}
        <div class="header">
            <div style="display: table-cell;">
                <div class="logo">CicilAja</div>
                <div style="font-size: 12px; color: #777;">PT. Cicil Aja Indonesia<br>Lampung, Indonesia</div>
            </div>
            <div class="receipt-title" style="display: table-cell;">
                NO. REFERENSI: #PAY-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
            </div>
        </div>

        {{-- ISI KUITANSI --}}
        <div class="row">
            <div class="label">Telah terima dari :</div>
            <div class="value">{{ $payment->submission->user->name }}</div>
        </div>

        <div class="row">
            <div class="label">Untuk Pembayaran :</div>
            <div class="value">
                Angsuran ke-{{ $payment->period }} untuk produk <strong>{{ $payment->submission->product->name }}</strong>
                <br>
                <span style="font-size: 12px; color: #777;">(ID Pengajuan: {{ $payment->submission->id }})</span>
            </div>
        </div>

        <div class="row">
            <div class="label">Tanggal Bayar :</div>
            <div class="value">{{ $payment->updated_at->translatedFormat('d F Y') }}</div>
        </div>

        <div class="amount-box">
            Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}
        </div>
        <span style="font-style: italic; color: #666; margin-left: 10px;">(Terbilang: {{ ucwords(Terbilang::make($payment->amount_paid)) }} Rupiah)</span>
        
        {{-- FOOTER --}}
        <div class="footer">
            <p>Bandar Lampung, {{ date('d F Y') }}</p>
            <div class="signature">Admin Keuangan</div>
        </div>
    </div>

</body>
</html>