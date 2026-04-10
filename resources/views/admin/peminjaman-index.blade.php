<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Verifikasi Peminjaman</h2>
    </x-slot>

    <style>
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-disetujui { background: #d1fae5; color: #065f46; }
        .status-ditolak { background: #fee2e2; color: #991b1b; }
        .status-dikembalikan { background: #dbeafe; color: #1e40af; }
        .filter-btn {
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1.5px solid #d1fae5;
            background: #fff;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
        }
        .filter-btn:hover, .filter-btn.active {
            background: #16a34a;
            color: #fff;
            border-color: #16a34a;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="main-card">
                <div class="main-title" style="font-size: 1.8rem;">
                    <i class="bi bi-clipboard-check"></i> Verifikasi Peminjaman
                </div>

                @if(session('success'))
                    <div class="alert alert-success" style="border-radius: 12px;">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Filter -->
                <div class="d-flex gap-2 mb-4 flex-wrap">
                    <a href="{{ route('admin.peminjaman.index') }}" class="filter-btn {{ !request('status') || request('status') == 'semua' ? 'active' : '' }}">Semua</a>
                    <a href="{{ route('admin.peminjaman.index', ['status' => 'pending']) }}" class="filter-btn {{ request('status') == 'pending' ? 'active' : '' }}">Pending</a>
                    <a href="{{ route('admin.peminjaman.index', ['status' => 'disetujui']) }}" class="filter-btn {{ request('status') == 'disetujui' ? 'active' : '' }}">Disetujui</a>
                    <a href="{{ route('admin.peminjaman.index', ['status' => 'ditolak']) }}" class="filter-btn {{ request('status') == 'ditolak' ? 'active' : '' }}">Ditolak</a>
                    <a href="{{ route('admin.peminjaman.index', ['status' => 'dikembalikan']) }}" class="filter-btn {{ request('status') == 'dikembalikan' ? 'active' : '' }}">Dikembalikan</a>
                </div>

                @if($peminjamans->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="main-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User (Akun)</th>
                                    <th>Nama Peminjam</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Keperluan</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Rencana Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamans as $i => $p)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $p->user->name ?? '-' }}</td>
                                    <td><span class="badge bg-secondary" style="font-size: 0.9rem;">{{ $p->nama_peminjam ?? '-' }}</span></td>
                                    <td><strong>{{ $p->nama_barang }}</strong></td>
                                    <td>{{ $p->jumlah }}</td>
                                    <td style="max-width: 200px;">{{ Str::limit($p->keperluan, 50) }}</td>
                                    <td>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                                    <td>{{ $p->tanggal_kembali_rencana->format('d M Y') }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $p->status }}">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($p->status === 'pending')
                                            <div class="d-flex gap-1">
                                                <form action="{{ route('admin.peminjaman.verify', $p->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="disetujui">
                                                    <button type="submit" class="btn btn-sm btn-success" style="border-radius: 8px;"
                                                            onclick="return confirm('Setujui peminjaman ini?')">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-danger" style="border-radius: 8px;"
                                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $p->id }}">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal{{ $p->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content" style="border-radius: 16px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tolak Peminjaman</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route('admin.peminjaman.verify', $p->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <div class="modal-body">
                                                                <label class="form-label fw-bold">Catatan (Alasan Penolakan)</label>
                                                                <textarea name="catatan_admin" class="form-control" rows="3"
                                                                          style="border-radius: 10px;" placeholder="Masukkan alasan penolakan..."></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                                                                <button type="submit" class="btn btn-danger" style="border-radius: 10px;">Tolak Peminjaman</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
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
                        <p class="mt-3 fs-5">Tidak ada data peminjaman</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
