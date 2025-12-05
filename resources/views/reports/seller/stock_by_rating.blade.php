<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Produk Berdasarkan Rating - {{ $seller->store_name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 9pt; }
        h1 { text-align: center; font-size: 14pt; margin-bottom: 5px; }
        .info { margin-bottom: 20px; font-size: 8pt; }
        .info span { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .rating-star { color: #f59e0b; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Laporan Daftar Stok Produk Berdasarkan Rating</h1>
    <div class="info">
        Tanggal dibuat: <span>{{ $date }}</span> oleh <span>{{ $processor }})</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Nama Produk</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 15%;">Harga</th>
                <th style="width: 10%; text-align: center;">Stok</th>
                <th style="width: 15%; text-align: center;">Rating Avg.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ $item->stock }}</td>
                <td class="rating-star" style="text-align: center;">{{ number_format($item->reviews_avg_rating ?? 0, 1) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>