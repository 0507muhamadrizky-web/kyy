<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barang Masuk') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-6">Edit Barang Masuk</h2>
                <form method="POST" action="{{ route('barangmasuk.update', $barangMasuk->id) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="nama_penginput" :value="'Nama Penginput'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input id="nama_penginput" name="nama_penginput" type="text" class="form-control" value="{{ $barangMasuk->nama_penginput }}" required />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="nama_barang" :value="'Nama Barang'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box"></i></span>
                            <input id="nama_barang" name="nama_barang" type="text" class="form-control" value="{{ $barangMasuk->nama_barang }}" required />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="jumlah_barang" :value="'Jumlah Barang'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                            <input id="jumlah_barang" name="jumlah_barang" type="number" class="form-control" value="{{ $barangMasuk->jumlah_barang }}" required />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="satuan_barang" :value="'Satuan Barang'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-bag"></i></span>
                            <input id="satuan_barang" name="satuan_barang" type="text" class="form-control" value="{{ $barangMasuk->satuan_barang }}" required />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="foto_bukti" :value="'Foto Bukti (Opsional)'" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-image"></i></span>
                            <input id="foto_bukti" name="foto_bukti" type="file" accept="image/*" class="form-control" />
                        </div>
                        @if($barangMasuk->foto_bukti)
                            <div class="mt-2">
                                <a href="{{ asset('storage/'.$barangMasuk->foto_bukti) }}" target="_blank" class="text-sm text-blue-600 underline">Lihat Foto Lama</a>
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button><i class="bi bi-pencil-square"></i> Update</x-primary-button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
