<x-app-layout>
    <!-- ...hapus CSS lokal, gunakan class global... -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Barang Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-6">Input Barang Masuk</h2>
                <form method="POST" action="{{ route('input.barang.masuk.store') }}" enctype="multipart/form-data" class="space-y-6">
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
                            <input id="nama_barang" name="nama_barang" type="text" class="form-control" required />
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
                        <x-input-label for="satuan_barang" :value="'Satuan Barang'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-bag"></i></span>
                            <input id="satuan_barang" name="satuan_barang" type="text" class="form-control" required />
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
</x-app-layout>
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
