<x-user-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Form Pengembalian</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="main-card">
                <div class="main-title" style="color: #1e40af !important; font-size: 1.8rem;">
                    <i class="bi bi-arrow-return-left"></i> Form Pengembalian Barang
                </div>

                <!-- Info Peminjaman -->
                <div style="background: #dbeafe; border-radius: 14px; padding: 1.2rem 1.5rem; margin-bottom: 1.5rem; border: 1px solid #93c5fd;">
                    <h5 class="fw-bold mb-2" style="color: #1e40af;"><i class="bi bi-info-circle"></i> Detail Peminjaman</h5>
                    <div class="row">
                        <div class="col-md-6 mb-2"><strong>Barang:</strong> {{ $peminjaman->nama_barang }}</div>
                        <div class="col-md-6 mb-2"><strong>Jumlah Pinjam:</strong> <span class="badge bg-primary" style="font-size: 1rem;">{{ $peminjaman->jumlah }}</span></div>
                        <div class="col-md-6"><strong>Tgl Pinjam:</strong> {{ $peminjaman->tanggal_pinjam->format('d M Y') }}</div>
                        <div class="col-md-6"><strong>Rencana Kembali:</strong> {{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger" style="border-radius: 12px;">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.pengembalian.store', $peminjaman->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #1e40af;">
                            <i class="bi bi-calendar-event"></i> Tanggal Pengembalian
                        </label>
                        <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali', date('Y-m-d')) }}"
                               style="border-radius: 10px; border: 1.5px solid #bfdbfe; padding: 0.75rem;" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #1e40af;">
                            <i class="bi bi-clipboard-check"></i> Kondisi Barang
                        </label>
                        <select name="kondisi_barang" class="form-select" style="border-radius: 10px; border: 1.5px solid #bfdbfe; padding: 0.75rem;" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="Baik" {{ old('kondisi_barang') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ old('kondisi_barang') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ old('kondisi_barang') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            <option value="Hilang" {{ old('kondisi_barang') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #1e40af;">
                            <i class="bi bi-chat-text"></i> Catatan (Opsional)
                        </label>
                        <textarea name="catatan" class="form-control" rows="3"
                                  style="border-radius: 10px; border: 1.5px solid #bfdbfe; padding: 0.75rem;"
                                  placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #1e40af;">
                            <i class="bi bi-camera"></i> Foto Bukti (Opsional)
                        </label>
                        <input type="file" name="foto_bukti" class="form-control" accept="image/*"
                               style="border-radius: 10px; border: 1.5px solid #bfdbfe; padding: 0.75rem;">
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="main-btn">
                            <i class="bi bi-send"></i> Ajukan Pengembalian
                        </button>
                        <a href="{{ route('user.peminjaman.index') }}" class="btn btn-outline-secondary" style="border-radius: 12px; padding: 12px 32px;">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-user-app-layout>
