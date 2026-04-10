<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // User: daftar peminjaman milik user
    public function index()
    {
        $peminjamans = Peminjaman::where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('user.peminjaman-index', compact('peminjamans'));
    }

    // User: form peminjaman
    public function create()
    {
        $barangs = \App\Models\BarangMasuk::select('nama_barang')->distinct()->orderBy('nama_barang')->get();
        return view('user.peminjaman-create', compact('barangs'));
    }

    // User: simpan peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'keperluan' => 'required|string',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Peminjaman::create($validated);

        return redirect()->route('user.peminjaman.index')->with('success', 'Peminjaman berhasil diajukan! Menunggu persetujuan admin.');
    }

    // Admin: daftar semua peminjaman
    public function adminIndex(Request $request)
    {
        $query = Peminjaman::with(['user'])->latest();

        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->get();
        return view('admin.peminjaman-index', compact('peminjamans'));
    }

    // Admin: verifikasi (setujui/tolak)
    public function updateStatus(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $peminjaman->update($validated);
        
        // --- OTOMATISASI STOK ---
        if ($validated['status'] === 'disetujui') {
            try {
                \App\Models\BarangKeluar::create([
                    'nama_barang' => $peminjaman->nama_barang,
                    'jumlah_barang' => $peminjaman->jumlah,
                    'user_id' => Auth::id(),
                    'nama_penginput' => 'Sistem (Peminjaman: ' . $peminjaman->user->name . ')',
                    'foto_bukti' => null,
                ]);
                \Log::info("Automated BarangKeluar created via Web for Peminjaman #$id");
            } catch (\Exception $e) {
                \Log::error("Failed to automate BarangKeluar via Web: " . $e->getMessage());
            }
        }
        // ------------------------

        $statusLabel = $validated['status'] === 'disetujui' ? 'disetujui' : 'ditolak';
        return redirect()->route('admin.peminjaman.index')->with('success', "Peminjaman berhasil {$statusLabel}!");
    }

    // AJAX: Cek stok barang
    public function checkStock(Request $request)
    {
        $namaBarang = $request->query('nama_barang');
        if (!$namaBarang) {
            return response()->json(['stock' => 0]);
        }

        $masuk = BarangMasuk::where('nama_barang', $namaBarang)->sum('jumlah_barang');
        $keluar = BarangKeluar::where('nama_barang', $namaBarang)->sum('jumlah_barang');
        $stok = $masuk - $keluar;

        return response()->json(['stock' => $stok]);
    }
}
