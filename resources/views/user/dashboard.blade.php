<x-user-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 800, once: true });
            document.querySelectorAll('.summary-value').forEach(function(el) {
                var target = parseInt(el.textContent.replace(/[^\d]/g, ''));
                if (isNaN(target) || target === 0) return;
                var current = 0;
                var step = Math.ceil(target / 30);
                var interval = setInterval(function() {
                    current += step;
                    if (current >= target) { el.textContent = target; clearInterval(interval); }
                    else { el.textContent = current; }
                }, 25);
            });
        });
    </script>

    <style>
        .user-dashboard-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }
        .summary-box {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            border: 1px solid #e5e7eb;
            border-left: 5px solid #3b82f6;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .summary-box:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
            transform: translateY(-4px);
        }
        .summary-box.aktif { border-left-color: #10b981; }
        .summary-box.aktif .summary-icon { background: #10b981; }
        .summary-box.pending { border-left-color: #f59e0b; }
        .summary-box.pending .summary-icon { background: #f59e0b; }
        .summary-box.kembali { border-left-color: #8b5cf6; }
        .summary-box.kembali .summary-icon { background: #8b5cf6; }
        .summary-box.kategori { border-left-color: #ec4899; }
        .summary-box.kategori .summary-icon { background: #ec4899; }
        .summary-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            background: #3b82f6;
            flex-shrink: 0;
            margin-left: 1rem;
        }
        .summary-value {
            font-size: 2rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.2;
        }
        .summary-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="main-card" data-aos="fade-up">
                <div class="main-title" style="color: #1e40af !important;">
                    <i class="bi bi-person-circle"></i> Selamat Datang, {{ Auth::user()->name }}!
                </div>

                <div class="user-dashboard-summary">
                    <div class="summary-box" data-aos="fade-right" data-aos-delay="0">
                        <div>
                            <div class="summary-value">{{ $totalPeminjaman }}</div>
                            <div class="summary-label">Total Peminjaman</div>
                        </div>
                        <div class="summary-icon"><i class="bi bi-box-arrow-up-right"></i></div>
                    </div>
                    <div class="summary-box aktif" data-aos="fade-up" data-aos-delay="100">
                        <div>
                            <div class="summary-value">{{ $peminjamanAktif }}</div>
                            <div class="summary-label">Sedang Dipinjam</div>
                        </div>
                        <div class="summary-icon"><i class="bi bi-check-circle"></i></div>
                    </div>
                    <div class="summary-box pending" data-aos="fade-up" data-aos-delay="200">
                        <div>
                            <div class="summary-value">{{ $peminjamanPending }}</div>
                            <div class="summary-label">Menunggu Persetujuan</div>
                        </div>
                        <div class="summary-icon"><i class="bi bi-hourglass-split"></i></div>
                    </div>
                    <div class="summary-box kembali" data-aos="fade-up" data-aos-delay="300">
                        <div>
                            <div class="summary-value">{{ $totalDikembalikan }}</div>
                            <div class="summary-label">Sudah Dikembalikan</div>
                        </div>
                        <div class="summary-icon"><i class="bi bi-arrow-return-left"></i></div>
                    </div>
                </div>

                <!-- Recent Peminjaman -->
                <h3 class="text-lg font-bold mb-3" style="color: #1e40af;">
                    <i class="bi bi-clock-history"></i> Peminjaman Terbaru
                </h3>
                @if($recentPeminjamans->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="main-table">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPeminjamans as $p)
                                <tr>
                                    <td>{{ $p->nama_barang }}</td>
                                    <td>{{ $p->jumlah }}</td>
                                    <td>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $p->status }}">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem; color: #6b7280;">
                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                        <p class="mt-2">Belum ada peminjaman</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-user-app-layout>
