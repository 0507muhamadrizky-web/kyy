<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS Animate On Scroll CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* Modern Dashboard Styles */
        @keyframes pop {
            0% { transform: scale(1); }
            60% { transform: scale(1.10); }
            100% { transform: scale(1.04); }
        }
        body {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            background: linear-gradient(120deg, #e0ffe7 0%, #f8f9fa 100%), url('data:image/svg+xml;utf8,<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="0" y="0" width="40" height="40" fill="none"/><circle cx="20" cy="20" r="1.5" fill="%23b6f3d1"/><circle cx="0" cy="0" r="1.5" fill="%23b6f3d1"/><circle cx="40" cy="0" r="1.5" fill="%23b6f3d1"/><circle cx="0" cy="40" r="1.5" fill="%23b6f3d1"/><circle cx="40" cy="40" r="1.5" fill="%23b6f3d1"/></svg>');
            background-repeat: repeat;
            color: #222 !important;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 8px 36px 0 rgba(34,197,94,0.13), 0 2px 8px 0 rgba(13,110,253,0.06);
            padding: 2.5rem 2rem 2rem 2rem;
            margin-bottom: 2.5rem;
            border: 1.5px solid #d1fae5;
            transition: box-shadow 0.3s, border 0.3s;
        }
        .dashboard-title {
            font-size: 2.4rem;
            font-weight: 900;
            color: #198754 !important;
            margin-bottom: 2.2rem;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 8px rgba(13,110,253,0.08);
        }
        .dashboard-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }
        /* Compact card with left colored border */
        .summary-box {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            border: 1px solid #e5e7eb;
            border-left: 5px solid #999;
            transition: all 0.3s ease;
            cursor: pointer;
            color: #222 !important;
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .summary-box.active, .summary-box:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            transform: translateY(-4px);
        }
        .summary-content {
            flex: 1;
        }
        .summary-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #fff;
            flex-shrink: 0;
            margin-left: 1rem;
        }
        .summary-box.jenis-barang {
            border-left-color: #3b82f6;
        }
        .summary-box.jenis-barang .summary-icon {
            background: #3b82f6;
        }
        .summary-box.total-barang {
            border-left-color: #10b981;
        }
        .summary-box.total-barang .summary-icon {
            background: #10b981;
        }
        .summary-box.barang-masuk {
            border-left-color: #f59e0b;
        }
        .summary-box.barang-masuk .summary-icon {
            background: #f59e0b;
        }
        .summary-box.barang-keluar {
            border-left-color: #ec4899;
        }
        .summary-box.barang-keluar .summary-icon {
            background: #ec4899;
        }
        .summary-value {
            font-size: 2rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 0.25rem;
        }
        .summary-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .summary-desc {
            font-size: 0.85rem;
            color: #ef4444;
            font-weight: 500;
            margin-bottom: 0;
        }
        .summary-badge {
            display: none;
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
        /* Responsive tweaks */
        @media (max-width: 900px) {
            .dashboard-summary { flex-direction: column; gap: 1.2rem; }
            .summary-box { min-width: 0; }
        }
        @media (max-width: 600px) {
            .dashboard-card { padding: 1.2rem 0.5rem; }
            .dashboard-title { font-size: 1.3rem; }
            .summary-value { font-size: 1.5rem; }
        }
    </style>
    <!-- Bootstrap JS Bundle -->
    <!-- AOS Animate On Scroll JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 900,
                once: true
            });
            // Animate summary values (count up)
            document.querySelectorAll('.summary-value').forEach(function(el) {
                var target = parseInt(el.textContent.replace(/[^\d]/g, ''));
                if (isNaN(target) || target === 0) return;
                var start = 0;
                var duration = 900;
                var step = Math.ceil(target / 40);
                var current = 0;
                var interval = setInterval(function() {
                    current += step;
                    if (current >= target) {
                        el.textContent = target;
                        clearInterval(interval);
                    } else {
                        el.textContent = current;
                    }
                }, duration / (target/step));
            });
        });
    </script>
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
                <div class="dashboard-card" data-aos="fade-up" data-aos-duration="900">
                <div class="dashboard-title">Dashboard Pergudangan DISTANBUN</div>
                <div class="dashboard-summary">
                    <div class="summary-box jenis-barang" data-aos="fade-right" data-aos-delay="0">
                        <div class="summary-content">
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
                            <div class="summary-label">Total Jenis Barang</div>
                        </div>
                        <i class="bi bi-tags summary-icon"></i>
                    </div>
                    <div class="summary-box total-barang" data-aos="fade-up" data-aos-delay="100">
                        <div class="summary-content">
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
                            <div class="summary-value">{{ $totalStok }}</div>
                            <div class="summary-label">Total Barang</div>
                        </div>
                        <i class="bi bi-box2 summary-icon"></i>
                    </div>
                    <div class="summary-box barang-masuk" data-aos="fade-up" data-aos-delay="200">
                        <div class="summary-content">
                            <div class="summary-value">
                                {{ \App\Models\BarangMasuk::sum('jumlah_barang') }}
                            </div>
                            <div class="summary-label">Barang Masuk</div>
                            
                        </div>
                        <i class="bi bi-arrow-down-circle summary-icon"></i>
                    </div>
                    <div class="summary-box barang-keluar" data-aos="fade-left" data-aos-delay="300">
                        <div class="summary-content">
                            <div class="summary-value">
                                {{ \App\Models\BarangKeluar::sum('jumlah_barang') }}
                            </div>
                            <div class="summary-label">Barang Keluar</div>
                        
                        </div>
                        <i class="bi bi-arrow-up-circle summary-icon"></i>
                    </div>
                </div>
                <!-- Chart.js Horizontal Bar Chart Stok Barang -->
                <div class="mt-10">
                    <h3 class="text-lg font-bold mb-4 text-green-800">Stok Barang per Jenis Barang</h3>
                    <canvas id="barChart" height="60" data-aos="zoom-in" data-aos-delay="200"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var stokBarangData = @json($stokBarangData);
            var labels = stokBarangData.map(function(item) { return item.nama_barang; });
            var data = stokBarangData.map(function(item) { return item.stok; });
            var barCtx = document.getElementById('barChart').getContext('2d');
            // Multiple colors for bars like reference
            var barColors = ['#3b82f6', '#1d4ed8', '#60a5fa', '#93c5fd', '#bfdbfe'];
            var chart = new Chart(barCtx, {
                plugins: [ChartDataLabels],
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Stok Barang',
                        data: data,
                        backgroundColor: data.map((_, i) => barColors[i % barColors.length]),
                        borderColor: data.map((_, i) => barColors[i % barColors.length]),
                        borderWidth: 0,
                        borderRadius: 6,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    animation: {
                        duration: 1200,
                        easing: 'easeOutCubic',
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#3b82f6',
                            borderWidth: 1,
                            padding: 10,
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'end',
                            color: '#1f2937',
                            font: { weight: 'bold', size: 13 },
                            formatter: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { color: '#6b7280', font: { weight: '500', size: 11 } },
                            grid: { color: '#e5e7eb', drawBorder: false },
                        },
                        y: {
                            ticks: { color: '#374151', font: { weight: '600', size: 12 } },
                            grid: { display: false, drawBorder: false }
                        }
                    },
                    layout: {
                        padding: { top: 10, right: 20, bottom: 10, left: 10 }
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                }
            });
        });
    </script>
    
</x-app-layout>
