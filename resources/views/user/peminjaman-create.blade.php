<x-user-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajukan Peminjaman</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="main-card">
                <div class="main-title" style="color: #1e40af !important; font-size: 1.8rem;">
                    <i class="bi bi-plus-circle"></i> Form Peminjaman Barang
                </div>

                @if($errors->any())
                    <div class="alert alert-danger" style="border-radius: 12px; margin-bottom: 1.5rem;">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.peminjaman.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #1e40af;">
                            <i class="bi bi-person"></i> Nama Peminjam
                        </label>
                        <input type="text" name="nama_peminjam" class="form-control" value="{{ old('nama_peminjam') }}"
                               style="border-radius: 10px; border: 1.5px solid #bfdbfe; padding: 0.75rem;"
                               placeholder="Masukkan nama lengkap peminjam" required>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label fw-bold mb-0" style="color: #1e40af;">
                                <i class="bi bi-box"></i> Nama Barang
                            </label>
                            <span id="stock-info" class="badge bg-info" style="display: none; border-radius: 8px; padding: 6px 12px;">
                                <i class="bi bi-boxes"></i> Stok: <span id="current-stock">0</span>
                            </span>
                        </div>
                        <select name="nama_barang" id="nama_barang" class="form-select" style="border-radius: 10px; border: 1.5px solid #bfdbfe; padding: 0.75rem;" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->nama_barang }}" {{ old('nama_barang') == $barang->nama_barang ? 'selected' : '' }}>
                                    {{ $barang->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #1e40af;">
                            <i class="bi bi-123"></i> Jumlah
                        </label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah') }}" min="1"
                               style="border-radius: 10px; border: 1.5px solid #bfdbfe; padding: 0.75rem;"
                               placeholder="Jumlah barang" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #1e40af;">
                            <i class="bi bi-chat-text"></i> Keperluan
                        </label>
                        <textarea name="keperluan" class="form-control" rows="3"
                                   style="border-radius: 10px; border: 1.5px solid #bfdbfe; padding: 0.75rem;"
                                   placeholder="Jelaskan keperluan peminjaman" required>{{ old('keperluan') }}</textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="color: #1e40af;">
                                <i class="bi bi-calendar-event"></i> Tanggal Pinjam
                            </label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                                   style="border-radius: 10px; border: 1.5px solid #bfdbfe; padding: 0.75rem;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="color: #1e40af;">
                                <i class="bi bi-calendar-check"></i> Rencana Pengembalian
                            </label>
                            <input type="date" name="tanggal_kembali_rencana" class="form-control" value="{{ old('tanggal_kembali_rencana') }}"
                                   style="border-radius: 10px; border: 1.5px solid #bfdbfe; padding: 0.75rem;" required>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="main-btn">
                            <i class="bi bi-send"></i> Ajukan Peminjaman
                        </button>
                        <a href="{{ route('user.peminjaman.index') }}" class="btn btn-outline-secondary" style="border-radius: 12px; padding: 12px 32px;">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('nama_barang').addEventListener('change', function() {
            const namaBarang = this.value;
            const stockInfo = document.getElementById('stock-info');
            const currentStock = document.getElementById('current-stock');
            const jumlahInput = document.getElementById('jumlah');

            if (namaBarang) {
                fetch(`{{ route('user.peminjaman.check-stock') }}?nama_barang=${encodeURIComponent(namaBarang)}`)
                    .then(response => response.json())
                    .then(data => {
                        currentStock.innerText = data.stock;
                        stockInfo.style.display = 'inline-block';
                        jumlahInput.max = data.stock; // Set max input to available stock
                    })
                    .catch(error => console.error('Error fetching stock:', error));
            } else {
                stockInfo.style.display = 'none';
                jumlahInput.removeAttribute('max');
            }
        });

        // Trigger change if old name exists (validation error case)
        if (document.getElementById('nama_barang').value) {
            document.getElementById('nama_barang').dispatchEvent(new Event('change'));
        }
    </script>
</x-user-app-layout>
