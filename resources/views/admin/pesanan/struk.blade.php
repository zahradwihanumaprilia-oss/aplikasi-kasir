<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk #{{ $order->kode_pesanan }}</title>
    <style>
        /* 💡 PENGATURAN KERTAS THERMAL KECIL (MODEL ALFAMART/INDOMARET) */
        @page {
            size: 58mm auto; /* Lebar standar kertas thermal kasir kecil */
            margin: 0;
        }
        
        /* 💡 MEMBUAT STRUK BERADA DI TENGAH MONITOR SAAT DILIHAT */
        body {
            background-color: #f1f5f9; /* Warna latar belakang luar biar kontras */
            margin: 0;
            padding: 20px 0;
            font-family: "Courier New", Courier, monospace;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        /* 💡 KONTAINER UTAMA STRUK (KERTAS THERMAL KASIR) */
        .struk-container {
            background-color: #fff; /* Warna kertas putih murni */
            width: 58mm; 
            padding: 14px 4px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); /* Efek bayangan kertas di layar */
            box-sizing: border-box;
            color: #000;
            font-size: 11px;
            line-height: 1.2;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        .header {
            margin-bottom: 8px;
        }
        .header h3 {
            margin: 0 0 3px 0;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header p {
            margin: 1px 0;
            font-size: 10px;
        }

        /* Garis pembatas putus-putus khas printer kasir */
        .divider {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .meta-table, .item-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .meta-table td {
            font-size: 10px;
            padding: 1px 0;
        }

        .item-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .total-section {
            width: 100%;
            margin-top: 4px;
        }
        .total-section td {
            padding: 1px 0;
        }

        .footer {
            margin-top: 12px;
            font-size: 9px;
        }

        /* 💡 LOGIKA PRINT: Menghilangkan background abu saat kertas thermal keluar */
        @media print {
            body { 
                background-color: transparent; 
                padding: 0; 
                min-height: auto;
            }
            .struk-container { 
                box-shadow: none; 
                padding: 10px 2px;
                width: 54mm;
            }
        }
    </style>
</head>
<body onload="window.print();">

    <div class="struk-container">
        
        <div class="header text-center">
            <h3>SMART CAFE & RESTO</h3>
            <p>📍 Jl. Raya Universitas Bina Bangsa</p>
            <p>Lantai 1 - Gedung Fakultas PTI</p>
            <p>Telp: 0812-3456-7890</p>
        </div>

        <div class="divider"></div>

        <table class="meta-table">
            <tr>
                <td>ID NOTA: {{ $order->kode_pesanan }}</td>
            </tr>
            <tr>
                <td>TANGGAL: {{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>KASIR  : Admin Kasir Utama</td>
            </tr>
            <tr>
                <td>MEJA   : QR-01 (ONLINE)</td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="item-table">
            @foreach(($order->items ?? $order->orderItems ?? []) as $item)
                <tr>
                    <td colspan="2" style="word-break: break-all;">{{ $item->product->nama ?? 'Menu Terhapus' }}</td>
                </tr>
                <tr>
                    <td style="padding-left: 5px;">{{ $item->jumlah }} x Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">Rp{{ number_format($item->subtotal ?? ($item->jumlah * $item->harga_satuan), 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>

        <div class="divider"></div>

        <table class="total-section">
            <tr>
                <td>TOTAL BELANJA</td>
                <td class="text-right font-bold">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>METODE BAYAR</td>
                <td class="text-right" style="text-transform: uppercase;">{{ $order->metode_bayar ?? 'QRIS' }}</td>
            </tr>
            <tr>
                <td>STATUS</td>
                <td class="text-right font-bold" style="text-transform: uppercase;">{{ $order->status }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="footer text-center">
            <p class="font-bold">TERIMA KASIH</p>
            <p>Atas Kunjungan Anda</p>
            <p>=== LAYANAN KONSUMEN ===</p>
            <p>SMS/WA: 0812-9999-8888</p>
            <p style="margin-top: 5px; font-size: 8px; color: #555;">Sistem Kasir Berbasis AI v1.0</p>
        </div>

    </div>

</body>
</html>