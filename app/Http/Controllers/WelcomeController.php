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
        // Wrap in try-catch so landing page works even without database
        try {
            $totalBarang = (int) BarangMasuk::sum('jumlah_barang') - (int) BarangKeluar::sum('jumlah_barang');
            $jenisBarang = BarangMasuk::distinct('nama_barang')->count('nama_barang');
            $barangMasuk = (int) BarangMasuk::sum('jumlah_barang');
            $barangKeluar = (int) BarangKeluar::sum('jumlah_barang');
        } catch (\Exception $e) {
            // If database is not available, show default values
            $totalBarang = 0;
            $jenisBarang = 0;
            $barangMasuk = 0;
            $barangKeluar = 0;
        }

        return view('user.welcome', compact('totalBarang', 'jenisBarang', 'barangMasuk', 'barangKeluar'));
    }
}
