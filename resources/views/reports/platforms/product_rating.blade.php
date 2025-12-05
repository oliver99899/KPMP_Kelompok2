<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produk Berdasarkan Rating</title>
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
    <h1>Laporan Daftar Produk Berdasarkan Rating</h1>
    <div class="info">
        Tanggal dibuat: <span>{{ $date }}</span> oleh <span>{{ $processor }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Rating</th>
                <th>Nama Toko</th>
                <th>Propinsi Toko</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->category_name }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="rating-star">{{ number_format($item->reviews_avg_rating, 1) }}</td>
                <td>{{ $item->store_name }}</td>
                <td>{{ $item->pic_province }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>