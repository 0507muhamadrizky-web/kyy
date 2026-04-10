<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penginput' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer|min:1',
            'satuan_barang' => 'required|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('barang_masuk', 'public');
        }


        BarangMasuk::create([
            'user_id' => Auth::id(),
            'nama_penginput' => $validated['nama_penginput'],
            'nama_barang' => $validated['nama_barang'],
            'jumlah_barang' => $validated['jumlah_barang'],
            'satuan_barang' => $validated['satuan_barang'],
            'foto_bukti' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Data barang masuk berhasil disimpan!');
    }

    public function edit($id)
    {
        $barangMasuk = \App\Models\BarangMasuk::findOrFail($id);
        return view('admin.edit-barang-masuk', compact('barangMasuk'));
    }

    public function update(Request $request, $id)
    {
        $barangMasuk = \App\Models\BarangMasuk::findOrFail($id);
        $validated = $request->validate([
            'nama_penginput' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer|min:1',
            'satuan_barang' => 'required|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_bukti')) {
            // Hapus foto lama jika ada
            if ($barangMasuk->foto_bukti && \Storage::disk('public')->exists($barangMasuk->foto_bukti)) {
                \Storage::disk('public')->delete($barangMasuk->foto_bukti);
            }
            $fotoPath = $request->file('foto_bukti')->store('barang_masuk', 'public');
            $barangMasuk->foto_bukti = $fotoPath;
        }

        $barangMasuk->update([
            'nama_penginput' => $validated['nama_penginput'],
            'nama_barang' => $validated['nama_barang'],
            'jumlah_barang' => $validated['jumlah_barang'],
            'satuan_barang' => $validated['satuan_barang'],
            'foto_bukti' => $barangMasuk->foto_bukti,
        ]);

        return redirect()->route('riwayat')->with('success', 'Data barang masuk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $barangMasuk = \App\Models\BarangMasuk::findOrFail($id);
        if ($barangMasuk->foto_bukti && \Storage::disk('public')->exists($barangMasuk->foto_bukti)) {
            \Storage::disk('public')->delete($barangMasuk->foto_bukti);
        }
        $barangMasuk->delete();
        return redirect()->route('riwayat')->with('success', 'Data barang masuk berhasil dihapus!');
    }
}
