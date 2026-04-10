<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - User</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            body {
                font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
                background: linear-gradient(120deg, #e0ecff 0%, #f8f9fa 100%);
                background-repeat: repeat;
                color: #222 !important;
            }
            .main-card {
                background: rgba(255,255,255,0.85);
                border-radius: 28px;
                box-shadow: 0 8px 36px 0 rgba(30,64,175,0.10), 0 2px 8px 0 rgba(13,110,253,0.06);
                padding: 2.2rem 1.7rem 1.7rem 1.7rem;
                margin-bottom: 2rem;
                border: 1.5px solid #93c5fd;
                backdrop-filter: blur(8px);
                transition: box-shadow 0.28s, border 0.28s, background 0.28s, transform 0.18s;
            }
            .main-card:hover {
                box-shadow: 0 16px 48px 0 rgba(30,64,175,0.14), 0 4px 16px 0 rgba(0,0,0,0.08);
                border-color: #3b82f6;
                background: rgba(255,255,255,0.92);
                transform: translateY(-4px) scale(1.01);
            }
            .main-title {
                font-size: 2.2rem;
                font-weight: 800;
                color: #1e40af !important;
                margin-bottom: 2rem;
                letter-spacing: 0.5px;
            }
            .main-table {
                width: 100%;
                border-collapse: collapse;
                background: #fff;
                border-radius: 18px;
                overflow: hidden;
                box-shadow: 0 2px 12px 0 rgba(59,130,246,0.10);
                border: 1.5px solid #bfdbfe;
            }
            .main-table th, .main-table td {
                padding: 0.95rem 1.2rem;
                border-bottom: 1px solid #e5e7eb;
                color: #222 !important;
            }
            .main-table th {
                background: #dbeafe;
                color: #222 !important;
                font-weight: 700;
            }
            .main-table tr:nth-child(even) td {
                background: #f8f9fa;
            }
            .main-table tr:last-child td {
                border-bottom: none;
            }
            .main-btn {
                background: linear-gradient(90deg, #3b82f6 60%, #60a5fa 100%);
                color: #fff;
                padding: 12px 32px;
                font-size: 1rem;
                font-weight: 600;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                box-shadow: 0 4px 16px 0 rgba(59,130,246,0.13);
                transition: background 0.25s, box-shadow 0.25s, transform 0.18s;
            }
            .main-btn:hover {
                background: linear-gradient(90deg, #1d4ed8 60%, #3b82f6 100%);
                box-shadow: 0 8px 32px 0 rgba(59,130,246,0.18);
                transform: translateY(-2px) scale(1.04);
                color: #fff;
            }
            .status-badge {
                display: inline-block;
                padding: 0.3rem 0.8rem;
                border-radius: 999px;
                font-size: 0.8rem;
                font-weight: 600;
            }
            .status-pending { background: #fef3c7; color: #92400e; }
            .status-disetujui { background: #d1fae5; color: #065f46; }
            .status-ditolak { background: #fee2e2; color: #991b1b; }
            .status-dikembalikan { background: #dbeafe; color: #1e40af; }
            .status-diverifikasi { background: #d1fae5; color: #065f46; }
        </style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen" style="margin-left: 280px;">
            @include('layouts.user-navigation')

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
