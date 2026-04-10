<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Transaksi Barang') }}
        </h2>
    </x-slot>
    <!-- ...hapus CSS lokal, gunakan class global... -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex flex-col md:flex-row items-center justify-between mb-2">
                    <h2 class="text-lg font-medium text-gray-900 mb-2 md:mb-0">Riwayat Transaksi Barang Masuk & Keluar</h2>
                    <div class="flex gap-2">
                        <a href="{{ route('riwayat.export.excel') }}" class="inline-block px-4 py-2" style="background:#15803d;color:#fff;font-weight:600;border-radius:0.375rem;box-shadow:0 1px 2px 0 rgba(16,185,129,0.10);"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
                        <a href="{{ route('riwayat.export.pdf') }}" class="inline-block px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded shadow transition"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
                    </div>
                </div>
                <div class="mb-6 flex gap-3 items-center">
                    <input id="searchRiwayat" type="text" placeholder="Cari nama barang, tanggal, user, dll..." class="block w-full border-gray-300 rounded-md shadow-sm py-2 px-4 text-base focus:ring-2 focus:ring-green-200 focus:border-green-400" />
                </div>
                <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="riwayatTable">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Penginput</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Foto Bukti</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @php
                            $masuk = \App\Models\BarangMasuk::with('user')->select('id','created_at','nama_barang','jumlah_barang','user_id','nama_penginput','foto_bukti')
                                ->get()->map(function($item){
                                    $item->jenis = 'Masuk';
                                    return $item;
                                });
                            $keluar = \App\Models\BarangKeluar::with('user')->select('id','created_at','nama_barang','jumlah_barang','user_id','nama_penginput','foto_bukti')
                                ->get()->map(function($item){
                                    $item->jenis = 'Keluar';
                                    return $item;
                                });
                            $riwayat = $masuk->concat($keluar)->sortByDesc('created_at');
                        @endphp
                        @forelse($riwayat as $row)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800">{{ $row->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <span class="flex items-center bg-white rounded-full text-xs font-bold shadow-sm px-3 py-1 ml-0.5" style="border-left:6px solid {{ $row->jenis == 'Masuk' ? '#22c55e' : '#ef4444' }}; color: {{ $row->jenis == 'Masuk' ? '#22c55e' : '#ef4444' }}; min-width:70px;">
                                    {{ $row->jenis }}
                                </span>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800">{{ $row->nama_barang }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800">{{ $row->jumlah_barang }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800">{{ optional($row->user)->name ?? $row->nama_penginput }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800">{{ $row->nama_penginput }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                @if($row->foto_bukti)
                                    <a href="{{ asset('storage/'.$row->foto_bukti) }}" target="_blank" class="text-blue-600 underline">Lihat Foto</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                <div class="flex gap-1">
                                    @if($row->jenis == 'Masuk')
                                        <a href="{{ route('barangmasuk.edit', $row->id) }}" style="background-color:#f59e42 !important;color:#fff !important;border:1px solid #eab308;box-shadow:0 1px 2px #eab308;" class="inline-block px-3 py-1 rounded font-semibold text-xs mr-1 hover:opacity-90 transition"><i class="bi bi-pencil"></i> Edit</a>
                                        <form action="{{ route('barangmasuk.destroy', $row->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data barang masuk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block px-3 py-1 rounded bg-red-500 text-white font-semibold text-xs"><i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    @else
                                        <a href="{{ route('barangkeluar.edit', $row->id) }}" style="background-color:#f59e42 !important;color:#fff !important;border:1px solid #eab308;box-shadow:0 1px 2px #eab308;" class="inline-block px-3 py-1 rounded font-semibold text-xs mr-1 hover:opacity-90 transition"><i class="bi bi-pencil"></i> Edit</a>
                                        <form action="{{ route('barangkeluar.destroy', $row->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data barang keluar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block px-3 py-1 rounded bg-red-500 text-white font-semibold text-xs"><i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-400 text-base">Belum ada riwayat transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchRiwayat');
            const table = document.getElementById('riwayatTable');
            searchInput.addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                for (const row of table.tBodies[0].rows) {
                    let text = row.innerText.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                }
            });
        });
    </script>
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')),
                showConfirmButton: false,
                timer: 1800
            });
        });
    </script>
@endif
</x-app-layout>
