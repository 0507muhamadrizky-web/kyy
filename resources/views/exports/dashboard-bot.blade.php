<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Total Masuk</th>
            <th>Total Keluar</th>
            <th>Stok Saat Ini</th>
            <th>Satuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item['nama_barang'] }}</td>
            <td>{{ $item['masuk'] }}</td>
            <td>{{ $item['keluar'] }}</td>
            <td>{{ $item['stok'] }}</td>
            <td>{{ $item['satuan'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
