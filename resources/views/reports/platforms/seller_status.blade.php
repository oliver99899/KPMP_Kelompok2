<!DOCTYPE html>
<html>
<head>
    <title>Laporan Akun Penjual</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        h1 { text-align: center; font-size: 14pt; margin-bottom: 5px; }
        .info { margin-bottom: 20px; font-size: 8pt; }
        .info span { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .status-active { color: green; font-weight: bold; }
        .status-rejected { color: red; }
    </style>
</head>
<body>
    <h1>Laporan Daftar Akun Penjual Berdasarkan Status</h1>
    <div class="info">
        Tanggal dibuat: <span>{{ $date }}</span> oleh <span>{{ $processor }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Nama PIC</th>
                <th>Nama Toko</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->user_name }}</td>
                <td>{{ $item->pic_name }}</td>
                <td>{{ $item->store_name }}</td>
                <td class="status-{{ strtolower($item->status) }}">{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>