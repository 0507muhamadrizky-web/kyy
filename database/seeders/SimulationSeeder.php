<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\KategoriBarang;
use App\Models\BarangMasuk;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class SimulationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Aktor
        $admin = User::where('role', 'admin')->first();
        $user = User::where('role', 'user')->first();

        if (!$admin || !$user) {
            $this->command->error("Admin atau User tidak ditemukan. Pastikan seeder utama sudah dijalankan.");
            return;
        }

        // 2. Ambil Kategori
        $catTani = KategoriBarang::where('nama_kategori', 'Alat Pertanian')->first();
        $catElektronik = KategoriBarang::where('nama_kategori', 'Elektronik & IT')->first();

        // 3. Tambah Barang Masuk (Stok)
        $items = [
            [
                'nama_barang' => 'Traktor Tangan G1000',
                'jumlah_barang' => 5,
                'foto_bukti' => 'barang/traktor.png',
                'user_id' => $admin->id,
                'nama_penginput' => $admin->name,
                'satuan_barang' => 'Unit'
            ],
            [
                'nama_barang' => 'Drone Penyemprot Agras T30',
                'jumlah_barang' => 2,
                'foto_bukti' => 'barang/drone.png',
                'user_id' => $admin->id,
                'nama_penginput' => $admin->name,
                'satuan_barang' => 'Unit'
            ],
            [
                'nama_barang' => 'Laptop Dell Latitude 5420',
                'jumlah_barang' => 10,
                'foto_bukti' => 'barang/laptop.png',
                'user_id' => $admin->id,
                'nama_penginput' => $admin->name,
                'satuan_barang' => 'Unit'
            ]
        ];

        foreach ($items as $item) {
            BarangMasuk::updateOrCreate(['nama_barang' => $item['nama_barang']], $item);
        }

        // 4. Simulasi Peminjaman
        Peminjaman::where('user_id', $user->id)->delete();

        // Peminjaman 1: Selesai (Dikembalikan)
        $pinjam1 = Peminjaman::create([
            'user_id' => $user->id,
            'kategori_barang_id' => $catElektronik->id,
            'nama_barang' => 'Laptop Dell Latitude 5420',
            'jumlah' => 1,
            'keperluan' => 'Pekerjaan Inventaris Lapangan',
            'tanggal_pinjam' => now()->subDays(10),
            'tanggal_kembali_rencana' => now()->subDays(3),
            'status' => 'dikembalikan',
            'catatan_admin' => 'Disetujui untuk dinas.'
        ]);

        // Pengembalian
        Pengembalian::create([
            'peminjaman_id' => $pinjam1->id,
            'user_id' => $user->id,
            'tanggal_kembali' => now()->subDays(2),
            'kondisi_barang' => 'Baik',
            'catatan' => 'Barang dikembalikan dalam kondisi lengkap.',
            'foto_bukti' => 'bukti_pengembalian/bukti_kembali.png',
            'status' => 'diverifikasi',
            'catatan_admin' => 'Sudah dicek, sesuai.'
        ]);

        // Peminjaman 2: Sedang Dipinjam (Disetujui)
        Peminjaman::create([
            'user_id' => $user->id,
            'kategori_barang_id' => $catTani->id,
            'nama_barang' => 'Traktor Tangan G1000',
            'jumlah' => 1,
            'keperluan' => 'Pengolahan lahan sawah percobaan',
            'tanggal_pinjam' => now()->subDays(2),
            'tanggal_kembali_rencana' => now()->addDays(5),
            'status' => 'disetujui',
            'catatan_admin' => 'Harap jaga kebersihan alat.'
        ]);

        // Peminjaman 3: Menunggu (Pending)
        Peminjaman::create([
            'user_id' => $user->id,
            'kategori_barang_id' => $catTani->id,
            'nama_barang' => 'Drone Penyemprot Agras T30',
            'jumlah' => 1,
            'keperluan' => 'Monitoring hama tanaman paria',
            'tanggal_pinjam' => now()->addDay(),
            'tanggal_kembali_rencana' => now()->addDays(3),
            'status' => 'pending'
        ]);
    }
}
