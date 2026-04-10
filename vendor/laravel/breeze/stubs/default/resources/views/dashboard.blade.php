<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* Animasi smooth summary box */
        @keyframes pop {
            0% { transform: scale(1); }
            60% { transform: scale(1.08); }
            100% { transform: scale(1.04); }
        }
        body {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            background: linear-gradient(120deg, #e0ffe7 0%, #f8f9fa 100%);
            color: #222 !important;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 8px 36px 0 rgba(34,197,94,0.13);
            padding: 2.2rem 1.7rem 1.7rem 1.7rem;
            margin-bottom: 2rem;
            border: 1.5px solid #d1fae5;
        }
        .dashboard-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #222 !important;
            margin-bottom: 2rem;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 8px rgba(13,110,253,0.08);
        }
        .dashboard-summary {
            display: flex;
            gap: 2rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }
        .summary-box {
            flex: 1 1 220px;
            min-width: 220px;
            border-radius: 20px;
            padding: 2.1rem 1.1rem 1.3rem 1.1rem;
            text-align: center;
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.16), 0 2px 8px 0 rgba(0,0,0,0.08);
            border: 2.5px solid #e3e3e3;
            transition: box-shadow 0.25s, transform 0.25s, background 0.25s;
            cursor: pointer;
            color: #222 !important;
            background: #fff;
            position: relative;
            overflow: hidden;
        }
        .summary-box.active, .summary-box:hover {
            box-shadow: 0 16px 48px 0 rgba(13,110,253,0.22), 0 4px 16px 0 rgba(0,0,0,0.13);
            transform: translateY(-8px) scale(1.06);
            animation: pop 0.3s;
            z-index: 2;
        }
        .summary-icon {
            font-size: 2.5rem;
            margin-bottom: 0.7rem;
            display: block;
            opacity: 0.85;
        }
        .summary-desc {
            font-size: 0.98rem;
            color: #555;
            margin-bottom: 0.7rem;
        }
        .summary-badge {
            position: absolute;
            top: 18px;
            right: 18px;
            font-size: 0.95rem;
            padding: 0.3em 0.8em;
            border-radius: 12px;
            font-weight: 600;
            background: #ffc107;
            color: #222;
            box-shadow: 0 2px 8px 0 rgba(255,193,7,0.13);
        }
        /* Kolom Jenis Barang (Kuning) */
        .summary-box.jenis-barang {
            background: linear-gradient(135deg, #fffbe6 60%, #fff9c4 100%);
            border: 2.5px solid #ffe066;
            box-shadow: 0 10px 32px 0 rgba(255,224,102,0.22), 0 2px 8px 0 rgba(0,0,0,0.10);
        }
        /* Kolom Total Barang (Biru) */
        .summary-box.total-barang {
            background: linear-gradient(135deg, #e3f0ff 60%, #b6d4fe 100%);
            border: 2.5px solid #0d6efd;
            box-shadow: 0 10px 32px 0 rgba(13,110,253,0.22), 0 2px 8px 0 rgba(0,0,0,0.10);
        }
        /* Kolom Barang Masuk (Hijau) */
        .summary-box.barang-masuk {
            background: linear-gradient(135deg, #e0ffe7 60%, #b6f3d1 100%);
            border: 2.5px solid #198754;
            box-shadow: 0 10px 32px 0 rgba(25,135,84,0.22), 0 2px 8px 0 rgba(0,0,0,0.10);
        }
        /* Kolom Barang Keluar (Merah) */
        .summary-box.barang-keluar {
            background: linear-gradient(135deg, #ffeaea 60%, #ffb6b6 100%);
            border: 2.5px solid #dc3545;
            box-shadow: 0 10px 32px 0 rgba(220,53,69,0.22), 0 2px 8px 0 rgba(0,0,0,0.10);
        }
        .summary-label, .summary-value {
            color: #222 !important;
        }
        .summary-label {
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.13rem;
            letter-spacing: 0.2px;
        }
        .summary-value {
            font-size: 2.5rem;
            font-weight: 800;
            text-shadow: 0 2px 12px rgba(0,0,0,0.10);
        }
        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 2px 12px 0 rgba(34,197,94,0.13);
            border: 1.5px solid #b6f3d1;
        }
        .dashboard-table th, .dashboard-table td {
            padding: 0.95rem 1.2rem;
            border-bottom: 1px solid #e5e7eb;
            color: #222 !important;
        }
        .dashboard-table th {
            background: #e0ffe7;
            color: #222 !important;
            font-weight: 700;
            letter-spacing: 0.2px;
        }
        .dashboard-table tr:last-child td {
            border-bottom: none;
        }
        .chartjs-render-monitor {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif !important;
        }
    </style>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS interaksi summary box -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.summary-box').forEach(function(box) {
                box.addEventListener('mouseenter', function() {
                    this.classList.add('active');
                });
                box.addEventListener('mouseleave', function() {
                    this.classList.remove('active');
                });
            });
        });
    </script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dashboard-card">
                <div class="dashboard-title">Dashboard Pergudangan DISTANBUN</div>
                <div class="dashboard-summary">
                    <div class="summary-box jenis-barang">
                        <i class="bi bi-tags summary-icon"></i>
                        <div class="summary-label">Total Jenis Barang</div>
                        <div class="summary-desc">Jumlah variasi barang yang tercatat di sistem</div>
                        <div class="summary-value">
                            {{ collect(
                                array_unique(
                                    array_merge(
                                        \App\Models\BarangMasuk::pluck('nama_barang')->toArray(),
                                        \App\Models\BarangKeluar::pluck('nama_barang')->toArray()
                                    )
                                )
                            )->filter(fn($b) => $b != null && $b != '')->count() }}
                        </div>
                    </div>
                    <div class="summary-box total-barang">
                        <i class="bi bi-box2 summary-icon"></i>
                        <div class="summary-label">Total Barang (Stok Tersedia)</div>
                        <div class="summary-desc">Akumulasi stok semua jenis barang</div>
                        <div class="summary-value">
                            @php
                                $allBarang = collect(array_unique(array_merge(
                                    \App\Models\BarangMasuk::pluck('nama_barang')->toArray(),
                                    \App\Models\BarangKeluar::pluck('nama_barang')->toArray()
                                )))->filter(fn($b) => $b != null && $b != '');
                                $totalStok = 0;
                                foreach($allBarang as $barang) {
                                    $masuk = \App\Models\BarangMasuk::where('nama_barang', $barang)->sum('jumlah_barang');
                                    $keluar = \App\Models\BarangKeluar::where('nama_barang', $barang)->sum('jumlah_barang');
                                    $totalStok += ($masuk - $keluar);
                                }
                            @endphp
                            {{ $totalStok }}
                        </div>
                        @if($totalStok == 0)
                        <span class="summary-badge">Stok Habis</span>
                        @elseif($totalStok < 10)
                        <span class="summary-badge">Stok Menipis</span>
                        @endif
                    </div>
                    <div class="summary-box barang-masuk">
                        <i class="bi bi-arrow-down-circle summary-icon"></i>
                        <div class="summary-label">Total Barang Masuk</div>
                        <div class="summary-desc">Total barang yang pernah masuk ke gudang</div>
                        <div class="summary-value">
                            {{ \App\Models\BarangMasuk::sum('jumlah_barang') }}
                        </div>
                    </div>
                    <div class="summary-box barang-keluar">
                        <i class="bi bi-arrow-up-circle summary-icon"></i>
                        <div class="summary-label">Total Barang Keluar</div>
                        <div class="summary-desc">Total barang yang sudah keluar dari gudang</div>
                        <div class="summary-value">
                            {{ \App\Models\BarangKeluar::sum('jumlah_barang') }}
                        </div>
                    </div>
                </div>
                <!-- Chart.js Line Chart Stok Barang -->
                <div class="mt-10">
                    <h3 class="text-lg font-bold mb-4 text-green-800">Grafik Stok Barang per Jenis Barang (Line Chart)</h3>
                    <canvas id="lineChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Chart.js CDN -->
    @php
        $stokBarangData = collect(array_unique(array_merge(
            \App\Models\BarangMasuk::pluck('nama_barang')->toArray(),
            \App\Models\BarangKeluar::pluck('nama_barang')->toArray()
        )))->filter(fn($b) => $b != null && $b != '')->map(function($barang) {
            $masuk = \App\Models\BarangMasuk::where('nama_barang', $barang)->sum('jumlah_barang');
            $keluar = \App\Models\BarangKeluar::where('nama_barang', $barang)->sum('jumlah_barang');
            $stok = $masuk - $keluar;
            return [
                'nama_barang' => $barang,
                'stok' => $stok > 0 ? $stok : 0
            ];
        })->values();
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var stokBarangData = @json($stokBarangData);
            // Setiap antar barang kembali ke titik nol, titik nol tidak diberi marker
            var labels = [];
            var data = [];
            var pointRadius = [];
            for (var i = 0; i < stokBarangData.length; i++) {
                // Titik sebelum barang (nol)
                labels.push('');
                data.push(0);
                pointRadius.push(0);
                // Titik barang
                labels.push(stokBarangData[i].nama_barang);
                data.push(stokBarangData[i].stok);
                pointRadius.push(5);
            }
            // Titik nol terakhir setelah barang terakhir
            labels.push('');
            data.push(0);
            pointRadius.push(0);
            if(labels.length === 0) {
                labels = ['-'];
                data = [0];
                pointRadius = [0];
            }
            var lineCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Stok Barang',
                        data: data,
                        fill: true,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13,110,253,0.12)',
                        tension: 0.4,
                        pointBackgroundColor: '#0d6efd',
                        pointRadius: pointRadius,
                        pointHoverRadius: pointRadius
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Line Chart Stok Barang', color: '#0d6efd', font: { size: 22, weight: 'bold' } }
                    },
                    scales: {
                        x: { ticks: { color: '#222', font: { weight: 'bold', size: 14 } }, grid: { color: '#e0ffe7' } },
                        y: { beginAtZero: true, ticks: { color: '#222', font: { weight: 'bold', size: 14 } } }
                    }
                }
            });
        });
    </script>
    <footer class="text-center py-4 mt-5" style="color:#888;font-size:1rem;">
        <hr style="margin-bottom:18px;">
        <span>© {{ date('Y') }} DISTANBUN Warehouse Dashboard. All rights reserved.</span>
    </footer>
</x-app-layout>
