<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    // User: daftar pengembalian milik user
    public function index()
    {
        $pengembalians = Pengembalian::where('user_id', Auth::id())
            ->with(['peminjaman'])
            ->latest()
            ->get();
        return view('user.pengembalian-index', compact('pengembalians'));
    }

    // User: form pengembalian
    public function create($peminjamanId)
    {
        $peminjaman = Peminjaman::where('id', $peminjamanId)
            ->where('user_id', Auth::id())
            ->where('status', 'disetujui')
            ->whereDoesntHave('pengembalian')
            ->firstOrFail();

        return view('user.pengembalian-create', compact('peminjaman'));
    }

    // User: simpan pengembalian
    public function store(Request $request, $peminjamanId)
    {
        $peminjaman = Peminjaman::where('id', $peminjamanId)
            ->where('user_id', Auth::id())
            ->where('status', 'disetujui')
            ->whereDoesntHave('pengembalian')
            ->firstOrFail();

        $validated = $request->validate([
            'tanggal_kembali' => 'required|date',
            'kondisi_barang' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('pengembalian', 'public');
        }

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'user_id' => Auth::id(),
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'kondisi_barang' => $validated['kondisi_barang'],
            'catatan' => $validated['catatan'] ?? null,
            'foto_bukti' => $fotoPath,
            'status' => 'pending',
        ]);

        return redirect()->route('user.pengembalian.index')->with('success', 'Pengembalian berhasil diajukan! Menunggu verifikasi admin.');
    }

    // Admin: daftar semua pengembalian
    public function adminIndex(Request $request)
    {
        $query = Pengembalian::with(['peminjaman', 'user'])->latest();

        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $pengembalians = $query->get();
        return view('admin.pengembalian-index', compact('pengembalians'));
    }

    // Admin: verifikasi (verifikasi/tolak)
    public function updateStatus(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:diverifikasi,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $pengembalian->update($validated);
        
        // --- OTOMATISASI STOK ---
        if ($validated['status'] === 'diverifikasi') {
            // Update status peminjaman jadi "dikembalikan"
            $pengembalian->peminjaman->update(['status' => 'dikembalikan']);
            
            // Tambahkan kembali ke stok
            try {
                $namaBarang = $pengembalian->peminjaman->nama_barang;
                $jumlah = $pengembalian->peminjaman->jumlah;
                
                // Ambil satuan dari record BarangMasuk sebelumnya agar konsisten
                $satuan = \App\Models\BarangMasuk::where('nama_barang', $namaBarang)->latest()->value('satuan_barang') ?? 'pcs';
                
                \App\Models\BarangMasuk::create([
                    'nama_barang' => $namaBarang,
                    'jumlah_barang' => $jumlah,
                    'satuan_barang' => $satuan,
                    'user_id' => Auth::id(),
                    'nama_penginput' => 'Sistem (Pengembalian: ' . $pengembalian->user->name . ')',
                    'foto_bukti' => $pengembalian->foto_bukti,
                ]);
                \Log::info("Automated BarangMasuk created via Web for Pengembalian #$id");
            } catch (\Exception $e) {
                \Log::error("Failed to automate BarangMasuk via Web: " . $e->getMessage());
            }
        }
        // ------------------------

        $statusLabel = $validated['status'] === 'diverifikasi' ? 'diverifikasi' : 'ditolak';
        return redirect()->route('admin.pengembalian.index')->with('success', "Pengembalian berhasil {$statusLabel}!");
    }
}
