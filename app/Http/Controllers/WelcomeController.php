<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        // Total barang = jumlah barang masuk - jumlah barang keluar
        $totalBarang = (int) BarangMasuk::sum('jumlah_barang') - (int) BarangKeluar::sum('jumlah_barang');
        // Jenis barang unik dari barang masuk dan keluar
        $jenisBarang = BarangMasuk::distinct('nama_barang')->count('nama_barang');
        $barangMasuk = (int) BarangMasuk::sum('jumlah_barang');
        $barangKeluar = (int) BarangKeluar::sum('jumlah_barang');
        return view('user.welcome', compact('totalBarang', 'jenisBarang', 'barangMasuk', 'barangKeluar'));
    }
}
