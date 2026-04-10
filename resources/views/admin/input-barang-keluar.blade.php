<x-app-layout>
    <!-- ...hapus CSS lokal, gunakan class global... -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Barang Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-6">Input Barang Keluar</h2>
                <form method="POST" action="#" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="user" :value="'User (Akun)'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                            <input id="user" name="user" type="text" class="form-control" value="{{ Auth::user()->name }}" readonly />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="nama_penginput" :value="'Nama Penginput'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input id="nama_penginput" name="nama_penginput" type="text" class="form-control" required />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="nama_barang" :value="'Nama Barang'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box"></i></span>
                            <select id="nama_barang" name="nama_barang" class="form-control" required>
                                <option value="" disabled selected>Pilih Barang</option>
                                @php
                                    $barangMasuk = \App\Models\BarangMasuk::select('nama_barang', \DB::raw('SUM(jumlah_barang) as masuk'))
                                        ->groupBy('nama_barang')->get()->keyBy('nama_barang');
                                    $barangKeluar = \App\Models\BarangKeluar::select('nama_barang', \DB::raw('SUM(jumlah_barang) as keluar'))
                                        ->groupBy('nama_barang')->get()->keyBy('nama_barang');
                                    $barangTersedia = [];
                                    foreach($barangMasuk as $nama => $bm) {
                                        $keluar = $barangKeluar[$nama]->keluar ?? 0;
                                        $stok = $bm->masuk - $keluar;
                                        if($stok > 0) {
                                            $barangTersedia[] = [
                                                'nama' => $nama,
                                                'stok' => $stok
                                            ];
                                        }
                                    }
                                @endphp
                                @foreach($barangTersedia as $barang)
                                    <option value="{{ $barang['nama'] }}">{{ $barang['nama'] }} (Stok: {{ $barang['stok'] }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="jumlah_barang" :value="'Jumlah Barang'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                            <input id="jumlah_barang" name="jumlah_barang" type="number" class="form-control" required />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="foto_bukti" :value="'Foto Bukti (Opsional)'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-image"></i></span>
                            <input id="foto_bukti" name="foto_bukti" type="file" accept="image/*" class="form-control" />
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button><i class="bi bi-save"></i> Simpan</x-primary-button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
