<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class BarangExport implements FromView, WithStyles
{
    /**
     * Style header kolom Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Baris 1 = header
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [ 'rgb' => '15803d' ] // hijau gelap
            ],
        ]);
        return [];
    }

    public function view(): View
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
        return view('exports.barang-excel', [ 'data' => $barang ]);
    }
}
