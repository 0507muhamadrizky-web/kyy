<table>
    <thead>
        <tr>
            <th style="background:#15803d;color:#fff;font-weight:bold;border:2px solid #fff;">Nama Barang</th>
            <th style="background:#15803d;color:#fff;font-weight:bold;border:2px solid #fff;">Total Masuk</th>
            <th style="background:#15803d;color:#fff;font-weight:bold;border:2px solid #fff;">Total Keluar</th>
            <th style="background:#15803d;color:#fff;font-weight:bold;border:2px solid #fff;">Stok Akhir</th>
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
