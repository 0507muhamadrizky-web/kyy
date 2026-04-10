<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Barang Masuk') }}
        </h2>
    </x-slot>
    <style>
        .custom-table-container {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px 0 rgba(34,197,94,0.10);
            padding: 2.2rem 1.7rem 1.7rem 1.7rem;
        }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px 0 rgba(34,197,94,0.10);
        }
        .custom-table th, .custom-table td {
            padding: 0.95rem 1.2rem;
            border-bottom: 1px solid #e5e7eb;
            color: #222 !important;
        }
        .custom-table th {
            background: #198754 !important;
            color: #fff !important;
            font-weight: 700;
            letter-spacing: 0.2px;
            text-transform: uppercase;
            font-size: 0.95rem;
            border-bottom: 3px solid #145c32;
        }
        .custom-table tr:last-child td {
            border-bottom: none;
        }
        .custom-table tbody tr {
            transition: background 0.2s, box-shadow 0.2s, transform 0.18s;
        }
        .custom-table tbody tr:hover {
            background: #f0fdf4;
            box-shadow: 0 4px 18px 0 rgba(34,197,94,0.13);
            transform: scale(1.012);
            z-index: 2;
        }
        .search-bar {
            border-radius: 8px;
            border: 1.5px solid #b6f3d1;
            padding: 0.5rem 1rem;
            margin-bottom: 1.2rem;
            width: 100%;
            max-width: 320px;
            font-size: 1rem;
        }
        @media (max-width: 640px) {
            .custom-table th, .custom-table td { padding: 0.6rem 0.5rem; font-size: 0.95rem; }
            .custom-table-container { padding: 1rem 0.2rem; }
        }
    </style>
        <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="custom-table-container">
                                <h2 class="text-lg font-bold text-green-800 mb-6">Data Barang Masuk</h2>
                                <input type="text" id="searchInput" class="search-bar" placeholder="Cari nama barang, user, atau penginput...">
                                <div class="overflow-x-auto" style="position:relative;">
                                <table class="custom-table" id="barangMasukTable">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Nama Penginput</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Foto Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\BarangMasuk::with('user')->latest()->get() as $bm)
                        <tr>
                            <td>{{ $bm->user->name ?? '-' }}</td>
                            <td>{{ $bm->nama_penginput }}</td>
                            <td>{{ $bm->nama_barang }}</td>
                            <td>{{ $bm->jumlah_barang }}</td>
                            <td>
                                @if($bm->foto_bukti)
                                    <a href="{{ asset('storage/'.$bm->foto_bukti) }}" target="_blank" class="text-blue-600 underline"><i class="bi bi-eye"></i> Lihat Foto</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <style>
    </style>
    <script>
        // Simple search/filter for table
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('searchInput');
            const table = document.getElementById('barangMasukTable');
            input.addEventListener('keyup', function() {
                const filter = input.value.toLowerCase();
                for (const row of table.tBodies[0].rows) {
                    let text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                }
            });
        });
    </script>
</x-app-layout>
