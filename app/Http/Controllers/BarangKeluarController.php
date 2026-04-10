<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penginput' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer|min:1',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hitung stok barang di gudang
        $masuk = BarangMasuk::where('nama_barang', $validated['nama_barang'])->sum('jumlah_barang');
        $keluar = BarangKeluar::where('nama_barang', $validated['nama_barang'])->sum('jumlah_barang');
        $stok = $masuk - $keluar;

        if ($validated['jumlah_barang'] > $stok) {
            return redirect()->back()->withInput()->withErrors(['jumlah_barang' => 'Jumlah barang keluar melebihi stok tersedia ('.$stok.').']);
        }

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('barang_keluar', 'public');
        }

        BarangKeluar::create([
            'user_id' => Auth::id(),
            'nama_penginput' => $validated['nama_penginput'],
            'nama_barang' => $validated['nama_barang'],
            'jumlah_barang' => $validated['jumlah_barang'],
            'foto_bukti' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Data barang keluar berhasil disimpan!');
    }

    public function edit($id)
    {
        $barangKeluar = \App\Models\BarangKeluar::findOrFail($id);
        return view('admin.edit-barang-keluar', compact('barangKeluar'));
    }

    public function update(Request $request, $id)
    {
        $barangKeluar = \App\Models\BarangKeluar::findOrFail($id);
        $validated = $request->validate([
            'nama_penginput' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer|min:1',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hitung stok barang di gudang (jika nama_barang berubah)
        $masuk = \App\Models\BarangMasuk::where('nama_barang', $validated['nama_barang'])->sum('jumlah_barang');
        $keluar = \App\Models\BarangKeluar::where('nama_barang', $validated['nama_barang'])->where('id', '!=', $barangKeluar->id)->sum('jumlah_barang');
        $stok = $masuk - $keluar;
        if ($validated['jumlah_barang'] > $stok) {
            return redirect()->back()->withInput()->withErrors(['jumlah_barang' => 'Jumlah barang keluar melebihi stok tersedia ('.$stok.').']);
        }

        if ($request->hasFile('foto_bukti')) {
            // Hapus foto lama jika ada
            if ($barangKeluar->foto_bukti && \Storage::disk('public')->exists($barangKeluar->foto_bukti)) {
                \Storage::disk('public')->delete($barangKeluar->foto_bukti);
            }
            $fotoPath = $request->file('foto_bukti')->store('barang_keluar', 'public');
            $barangKeluar->foto_bukti = $fotoPath;
        }

        $barangKeluar->update([
            'nama_penginput' => $validated['nama_penginput'],
            'nama_barang' => $validated['nama_barang'],
            'jumlah_barang' => $validated['jumlah_barang'],
            'foto_bukti' => $barangKeluar->foto_bukti,
        ]);

        return redirect()->route('riwayat')->with('success', 'Data barang keluar berhasil diupdate!');
    }

    public function destroy($id)
    {
        $barangKeluar = \App\Models\BarangKeluar::findOrFail($id);
        if ($barangKeluar->foto_bukti && \Storage::disk('public')->exists($barangKeluar->foto_bukti)) {
            \Storage::disk('public')->delete($barangKeluar->foto_bukti);
        }
        $barangKeluar->delete();
        return redirect()->route('riwayat')->with('success', 'Data barang keluar berhasil dihapus!');
    }
}
