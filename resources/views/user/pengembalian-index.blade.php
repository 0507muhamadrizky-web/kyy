<x-user-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Pengembalian</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="main-card">
                <div class="main-title" style="color: #1e40af !important; font-size: 1.8rem;">
                    <i class="bi bi-arrow-return-left"></i> Riwayat Pengembalian
                </div>

                @if(session('success'))
                    <div class="alert alert-success" style="border-radius: 12px;">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if($pengembalians->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="main-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Tgl Kembali</th>
                                    <th>Kondisi</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                    <th>Catatan Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengembalians as $i => $pg)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><strong>{{ $pg->peminjaman->nama_barang ?? '-' }}</strong></td>
                                    <td>{{ $pg->tanggal_kembali->format('d M Y') }}</td>
                                    <td>{{ $pg->kondisi_barang }}</td>
                                    <td>{{ $pg->catatan ?? '-' }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $pg->status }}">
                                            {{ ucfirst($pg->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $pg->catatan_admin ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 3rem; color: #6b7280;">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-3 fs-5">Belum ada pengembalian</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-user-app-layout>
