<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;
use PDF;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class ExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new BarangExport, 'data-barang.xlsx');
    }

    public function exportPDF()
    {
        $data = $this->getBarangData();
        $pdf = PDF::loadView('exports.barang-pdf', ['data' => $data]);
        return $pdf->download('data-barang.pdf');
    }

    private function getBarangData()
    {
        $barang = collect(array_unique(array_merge(
            BarangMasuk::pluck('nama_barang')->toArray(),
            BarangKeluar::pluck('nama_barang')->toArray()
        )))->filter(fn($b) => $b != null && $b != '')->map(function($nama) {
            $masuk = BarangMasuk::where('nama_barang', $nama)->sum('jumlah_barang');
            $keluar = BarangKeluar::where('nama_barang', $nama)->sum('jumlah_barang');
            return [
                'nama_barang' => $nama,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'stok' => $masuk - $keluar
            ];
        })->values();
        return $barang;
    }
}
