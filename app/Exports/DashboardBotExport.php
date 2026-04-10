<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
// Use aliases to avoid conflicts if models have same names (not the case here)

class DashboardBotExport implements FromView, WithStyles
{
    public function view(): View
    {
        // Get unique item names
        $items = collect(array_unique(array_merge(
            BarangMasuk::pluck('nama_barang')->toArray(),
            BarangKeluar::pluck('nama_barang')->toArray()
        )))->filter()->values();

        $data = $items->map(function($nama) {
            $masuk = BarangMasuk::where('nama_barang', $nama)->sum('jumlah_barang');
            // Get unit from data masuk (assuming consistent)
            $satuan = BarangMasuk::where('nama_barang', $nama)->value('satuan_barang') ?? '-';
            
            $keluar = BarangKeluar::where('nama_barang', $nama)->sum('jumlah_barang');
            
            return [
                'nama_barang' => $nama,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'stok' => $masuk - $keluar,
                'satuan' => $satuan
            ];
        });

        return view('exports.dashboard-bot', [
            'data' => $data
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [ 'rgb' => '15803d' ] 
            ],
        ]);
    }
}
