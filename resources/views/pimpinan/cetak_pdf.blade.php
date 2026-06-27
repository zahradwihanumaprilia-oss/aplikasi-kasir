<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #d97706; }
        table { w-full; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { bg-color: #f3f4f6; font-weight: bold; }
        .total-row { font-weight: bold; bg-color: #f9fafb; }
    </style>
</head>
<body>

    <div class="header text-center">
        <h2>SMART KASIR QRIS</h2>
        <p>Laporan Penjualan Bisnis Mandiri Resmi</p>
        <small>Periode Transaksi: {{ $tgl_mulai }} s/d {{ $tgl_selesai }}</small>
    </div>

    <table style="width: 100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu Transaksi</th>
                <th>Kode Transaksi</th>
                <th>Metode Bayar</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($transaksis as $trx)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $trx->tgl_transaksi }}</td>
                    <td style="font-family: monospace;">{{ $trx->kode_transaksi }}</td>
                    <td style="text-transform: uppercase;">{{ $trx->metode_bayar }}</td>
                    <td class="text-right">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" class="text-right">GRAND TOTAL PENDAPATAN:</td>
                <td class="text-right" style="color: #16a34a;">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>