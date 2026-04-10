<nav x-data="{ open: false, dataOpen: false, inputOpen: false, userOpen: false }" class="sidebar-nav">
    <!-- Sidebar Navigation -->
    <style>
        .sidebar-nav {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #198754 0%, #145c32 100%);
            z-index: 50;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
        }
        .sidebar-header {
            padding: 1.5rem 1.5rem 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar-logo img {
            height: 40px;
            width: auto;
        }
        .sidebar-title {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }
        .sidebar-subtitle {
            color: rgba(255,255,255,0.75);
            font-size: 0.8rem;
            margin: 0.25rem 0 0 0;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
            overflow-y: auto;
            padding-top: 1rem;
        }
        .sidebar-menu-item {
            margin: 0.5rem 0.75rem;
        }
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
        }
        .sidebar-menu-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-left-color: #fbbf24;
            transform: translateX(4px);
        }
        .sidebar-menu-link.active {
            background: rgba(255,255,255,0.15);
            color: #fbbf24;
            border-left-color: #fbbf24;
        }
        .sidebar-dropdown-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.9);
            background: transparent;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s ease;
            width: 100%;
            text-align: left;
            border-left: 3px solid transparent;
        }
        .sidebar-dropdown-btn:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-left-color: #fbbf24;
        }
        .sidebar-dropdown-btn svg {
            width: 16px;
            height: 16px;
            transition: transform 0.25s ease;
        }
        .sidebar-dropdown-btn[aria-expanded="true"] svg {
            transform: rotate(180deg);
        }
        .sidebar-dropdown-menu {
            list-style: none;
            padding: 0.5rem 0.75rem 0.5rem 1.5rem;
            margin: 0.5rem 0.75rem;
            background: rgba(255,255,255,0.05);
            border-radius: 6px;
        }
        .sidebar-dropdown-menu li {
            margin: 0.25rem 0;
        }
        .sidebar-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .sidebar-dropdown-menu a:hover {
            background: rgba(255,255,255,0.1);
            color: #fbbf24;
        }
        .sidebar-user {
            margin-top: auto;
            position: relative;
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.1);
        }
        .sidebar-user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.25s ease;
        }
        .sidebar-user-profile:hover {
            background: rgba(255,255,255,0.15);
        }
        .sidebar-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fbbf24;
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }
        .sidebar-user-name {
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-email {
            color: rgba(255,255,255,0.7);
            font-size: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-dropdown {
            position: absolute;
            bottom: calc(100% + 0.5rem);
            left: 0.75rem;
            right: 0.75rem;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border: 1px solid rgba(0,0,0,0.1);
        }
        .sidebar-user-dropdown a {
            display: block;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            transition: all 0.2s ease;
            border-bottom: 1px solid #eee;
            font-weight: 500;
        }
        .sidebar-user-dropdown a:last-child {
            border-bottom: none;
        }
        .sidebar-user-dropdown a:hover {
            background: #f8f9fa;
            color: #198754;
        }
        .sidebar-user-dropdown a i {
            margin-right: 0.5rem;
            color: #198754;
        }
    </style>

    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="{{ asset('logo/logo-jateng.svg') }}" alt="Logo Jateng" />
            <div>
                <h1 class="sidebar-title">DISTANBUN</h1>
                <p class="sidebar-subtitle">Pergudangan</p>
            </div>
        </div>
    </div>

    <ul class="sidebar-menu">
        @php
            $pendingPeminjaman = \App\Models\Peminjaman::where('status', 'pending')->count();
            $pendingPengembalian = \App\Models\Pengembalian::where('status', 'pending')->count();
        @endphp

        <!-- Dashboard Link -->
        @if (Route::has('dashboard'))
            <li class="sidebar-menu-item">
                <a href="{{ route('dashboard') }}" class="sidebar-menu-link @if(request()->routeIs('dashboard')) active @endif">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        @endif

        <!-- Data Dropdown -->
        <li class="sidebar-menu-item">
            <button @click="dataOpen = !dataOpen" :aria-expanded="dataOpen" class="sidebar-dropdown-btn">
                <span style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-database"></i>
                    <span>Data</span>
                </span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <ul x-show="dataOpen" class="sidebar-dropdown-menu">
                @if (Route::has('data.barang.masuk'))
                    <li><a href="{{ route('data.barang.masuk') }}"><i class="bi bi-box-arrow-in-down"></i> Data Barang Masuk</a></li>
                @endif
                @if (Route::has('data.barang.keluar'))
                    <li><a href="{{ route('data.barang.keluar') }}"><i class="bi bi-box-arrow-up"></i> Data Barang Keluar</a></li>
                @endif
            </ul>
        </li>

        <!-- Input Dropdown -->
        <li class="sidebar-menu-item">
            <button @click="inputOpen = !inputOpen" :aria-expanded="inputOpen" class="sidebar-dropdown-btn">
                <span style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-pencil-square"></i>
                    <span>Input</span>
                </span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <ul x-show="inputOpen" class="sidebar-dropdown-menu">
                @if (Route::has('input.barang.masuk'))
                    <li><a href="{{ route('input.barang.masuk') }}"><i class="bi bi-plus-circle"></i> Input Barang Masuk</a></li>
                @endif
                @if (Route::has('input.barang.keluar'))
                    <li><a href="{{ route('input.barang.keluar') }}"><i class="bi bi-plus-circle"></i> Input Barang Keluar</a></li>
                @endif
            </ul>
        </li>

        <!-- Riwayat Link -->
        @if (Route::has('riwayat'))
            <li class="sidebar-menu-item">
                <a href="{{ route('riwayat') }}" class="sidebar-menu-link @if(request()->routeIs('riwayat')) active @endif">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat</span>
                </a>
            </li>
        @endif


        <!-- Verifikasi Peminjaman -->
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.peminjaman.index') }}" class="sidebar-menu-link @if(request()->routeIs('admin.peminjaman.*')) active @endif" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Verifikasi Peminjaman</span>
                </div>
                @if($pendingPeminjaman > 0)
                    <span style="background: #fbbf24; color: #000; border-radius: 999px; padding: 0.15rem 0.5rem; font-size: 0.75rem; font-weight: 700; margin-left: auto;">{{ $pendingPeminjaman }}</span>
                @endif
            </a>
        </li>

        <!-- Verifikasi Pengembalian -->
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.pengembalian.index') }}" class="sidebar-menu-link @if(request()->routeIs('admin.pengembalian.*')) active @endif" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-clipboard2-check"></i>
                    <span>Verifikasi Pengembalian</span>
                </div>
                @if($pendingPengembalian > 0)
                    <span style="background: #fbbf24; color: #000; border-radius: 999px; padding: 0.15rem 0.5rem; font-size: 0.75rem; font-weight: 700; margin-left: auto;">{{ $pendingPengembalian }}</span>
                @endif
            </a>
        </li>
    </ul>

    <!-- User Profile Section -->
    <div class="sidebar-user">
        <div class="sidebar-user-profile" @click="userOpen = !userOpen">
            @php
                $user = Auth::user();
                $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper($w[0]))->join('');
            @endphp
            <div class="sidebar-avatar">
                {{ $initials }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ $user->name }}</div>
                <div class="sidebar-user-email">{{ $user->email }}</div>
            </div>
        </div>
        <div x-show="userOpen" @click.away="userOpen = false" class="sidebar-user-dropdown">
            <a href="{{ route('profile.edit') }}"><i class="bi bi-person-circle"></i> Profile</a>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="border-bottom: none;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </form>
        </div>
    </div>
</nav>
