<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Custom CSS Global Modern Theme -->
    <style>
        body {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            background: linear-gradient(120deg, #e0ffe7 0%, #f8f9fa 100%), url('data:image/svg+xml;utf8,<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="0" y="0" width="40" height="40" fill="none"/><circle cx="20" cy="20" r="1.5" fill="%23b6f3d1"/><circle cx="0" cy="0" r="1.5" fill="%23b6f3d1"/><circle cx="40" cy="0" r="1.5" fill="%23b6f3d1"/><circle cx="0" cy="40" r="1.5" fill="%23b6f3d1"/><circle cx="40" cy="40" r="1.5" fill="%23b6f3d1"/></svg>');
            background-repeat: repeat;
            color: #222 !important;
        }
        .main-card {
            background: rgba(255,255,255,0.82);
            border-radius: 28px;
            box-shadow: 0 8px 36px 0 rgba(6,182,212,0.13), 0 2px 8px 0 rgba(13,110,253,0.06);
            padding: 2.2rem 1.7rem 1.7rem 1.7rem;
            margin-bottom: 2rem;
            border: 1.5px solid #67e8f9;
            backdrop-filter: blur(8px);
            transition: box-shadow 0.28s, border 0.28s, background 0.28s, transform 0.18s;
            will-change: box-shadow, border, background, transform;
        }
        .main-card:hover {
            box-shadow: 0 16px 48px 0 rgba(6,182,212,0.18), 0 4px 16px 0 rgba(0,0,0,0.10);
            border-color: #06b6d4;
            background: rgba(255,255,255,0.92);
            transform: translateY(-4px) scale(1.02);
        }
        }
        .main-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #222 !important;
            margin-bottom: 2rem;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 8px rgba(13,110,253,0.08);
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 2px 12px 0 rgba(34,197,94,0.13);
            border: 1.5px solid #b6f3d1;
        }
        .main-table th, .main-table td {
            padding: 0.95rem 1.2rem;
            border-bottom: 1px solid #e5e7eb;
            color: #222 !important;
        }
        .main-table th {
            background: #e0ffe7;
            color: #222 !important;
            font-weight: 700;
            letter-spacing: 0.2px;
        }
        .main-table tr:nth-child(even) td {
            background: #f8f9fa;
        }
        .main-table tr:last-child td {
            border-bottom: none;
        }
        .main-btn {
            background: linear-gradient(90deg, #06b6d4 60%, #22d3ee 100%);
            color: #fff;
            padding: 14px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 4px 16px 0 rgba(6,182,212,0.13);
            transition: background 0.25s, box-shadow 0.25s, transform 0.18s;
            will-change: background, box-shadow, transform;
        }
        .main-btn:hover {
            background: linear-gradient(90deg, #0e7490 60%, #06b6d4 100%);
            box-shadow: 0 8px 32px 0 rgba(6,182,212,0.18);
            transform: translateY(-2px) scale(1.04);
        }
        .main-label {
            font-weight: 600;
            color: #166534;
            margin-bottom: 0.5rem;
            display: block;
        }
        .input-icon-group {
            position: relative;
        }
        .input-icon-group .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.25rem;
            color: #16a34a;
            pointer-events: none;
        }
        .input-icon-group input[type="text"],
        .input-icon-group input[type="number"],
        .input-icon-group select {
            padding-left: 2.5rem !important;
            font-size: 1.05rem;
            border: 1.5px solid #d1fae5;
            background: #f9fafb;
            transition: border 0.2s;
            height: 44px;
        }
        .input-icon-group input[type="text"]:focus,
        .input-icon-group input[type="number"]:focus,
        .input-icon-group select:focus {
            border: 1.5px solid #16a34a;
            background: #fff;
        }
        .input-icon-group input[type="file"] {
            padding-left: 2.5rem !important;
        }
        .input-icon-group input[type="file"]::-webkit-file-upload-button {
            margin-left: 1.2rem;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100" style="margin-left: 280px;">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>
