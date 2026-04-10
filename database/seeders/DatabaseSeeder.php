<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeding Admin
        \App\Models\User::updateOrCreate(
            ['email' => 'admindistanbun@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Seeding User
        \App\Models\User::updateOrCreate(
            ['email' => 'userdistanbun@gmail.com'],
            [
                'name' => 'User Peminjam',
                'password' => \Illuminate\Support\Facades\Hash::make('user123'),
                'role' => 'user',
            ]
        );

        // Seeding Kategori Barang Dummy
        $kategoris = [
            ['nama_kategori' => 'Alat Pertanian', 'deskripsi' => 'Peralatan berat dan ringan untuk pertanian.'],
            ['nama_kategori' => 'Kendaraan Dinas', 'deskripsi' => 'Mobil, Motor, dan Truk Operasional.'],
            ['nama_kategori' => 'Elektronik & IT', 'deskripsi' => 'Laptop, Proyektor, Kamera, dll.']
        ];

        foreach ($kategoris as $kat) {
            \App\Models\KategoriBarang::updateOrCreate(
                ['nama_kategori' => $kat['nama_kategori']],
                ['deskripsi' => $kat['deskripsi']]
            );
        }
    }
}
