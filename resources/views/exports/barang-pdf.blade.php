<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export PDF Data Barang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #aaa; padding: 8px 10px; text-align: left; }
        th { background: #e0ffe7; font-weight: bold; }
        h2 { margin-bottom: 0; }
    </style>
</head>
<body>
    <h2>Rekapitulasi Data Barang</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Total Masuk</th>
                <th>Total Keluar</th>
                <th>Stok Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row['nama_barang'] }}</td>
                <td>{{ $row['masuk'] }}</td>
                <td>{{ $row['keluar'] }}</td>
                <td>{{ $row['stok'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
