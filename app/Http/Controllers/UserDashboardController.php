<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();
        $peminjamanAktif = Peminjaman::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $peminjamanPending = Peminjaman::where('user_id', $user->id)->where('status', 'pending')->count();
        $totalDikembalikan = Peminjaman::where('user_id', $user->id)->where('status', 'dikembalikan')->count();
        $totalDikembalikan = Peminjaman::where('user_id', $user->id)->where('status', 'dikembalikan')->count();

        $recentPeminjamans = Peminjaman::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'totalPeminjaman',
            'peminjamanAktif',
            'peminjamanPending',
            'totalDikembalikan',
            'recentPeminjamans'
        ));
    }
}
