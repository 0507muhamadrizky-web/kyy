<x-user-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Peminjaman</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="main-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="main-title mb-0" style="color: #1e40af !important; font-size: 1.8rem;">
                        <i class="bi bi-list-ul"></i> Riwayat Peminjaman
                    </div>
                    <a href="{{ route('user.peminjaman.create') }}" class="main-btn">
                        <i class="bi bi-plus-circle"></i> Ajukan Peminjaman
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success" style="border-radius: 12px;">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if($peminjamans->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="main-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peminjam</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Rencana Kembali</th>
                                    <th>Status</th>
                                    <th>Catatan Admin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamans as $i => $p)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $p->nama_peminjam }}</td>
                                    <td><strong>{{ $p->nama_barang }}</strong></td>
                                    <td>{{ $p->jumlah }}</td>
                                    <td>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                                    <td>{{ $p->tanggal_kembali_rencana->format('d M Y') }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $p->status }}">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $p->catatan_admin ?? '-' }}</td>
                                    <td>
                                        @if($p->status === 'disetujui' && !$p->pengembalian)
                                            <a href="{{ route('user.pengembalian.create', $p->id) }}"
                                               class="btn btn-sm btn-warning" style="border-radius: 8px;">
                                                <i class="bi bi-arrow-return-left"></i> Kembalikan
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 3rem; color: #6b7280;">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-3 fs-5">Belum ada peminjaman</p>
                        <a href="{{ route('user.peminjaman.create') }}" class="main-btn mt-3">
                            <i class="bi bi-plus-circle"></i> Ajukan Peminjaman Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-user-app-layout>
