@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$kasir = $kasir ?? Auth::guard('admin')->user();
$role = $role ?? ($kasir?->role ?? '');
$namaKasir = $kasir?->nama ?? 'Kasir';

$roleName = $roleName ?? match ($role) {
    'kasir_menu' => 'Kasir Menu',
    'kasir_wahana' => 'Kasir Wahana',
    'kasir_oleholeh' => 'Kasir Oleh-Oleh',
    default => 'Kasir',
};

$orderTitle = $orderTitle ?? match ($role) {
    'kasir_menu' => 'Pesanan Menu',
    'kasir_wahana' => 'Pesanan Wahana',
    'kasir_oleholeh' => 'Pesanan Oleh-Oleh',
    default => 'Pesanan',
};

$orderIcon = $orderIcon ?? match ($role) {
    'kasir_menu' => 'fa-utensils',
    'kasir_wahana' => 'fa-ticket',
    'kasir_oleholeh' => 'fa-bag-shopping',
    default => 'fa-receipt',
};

$statistics = $statistics ?? [
    'total_pesanan' => 0,
    'menunggu' => 0,
    'diproses' => 0,
    'selesai' => 0,
    'pendapatan' => 0,
];

$shortcut = $shortcut ?? [];
$recentOrders = $recentOrders ?? [];

$orderUrl = $orderUrl ?? null;
$bundlingUrl = $bundlingUrl ?? null;
$stockUrl = $stockUrl ?? null;

if (!$orderUrl) {
    $orderRoutes = match ($role) {
        'kasir_menu' => [
            'kasir.menu.pesanan.index',
            'kasir.menu.pesanan',
            'kasir.menu.orders.index',
            'kasir.menu.orders',
        ],
        'kasir_wahana' => [
            'kasir.wahana.pesanan.index',
            'kasir.wahana.pesanan',
            'kasir.wahana.orders.index',
            'kasir.wahana.orders',
        ],
        'kasir_oleholeh' => [
            'kasir.oleholeh.pesanan.index',
            'kasir.oleholeh.pesanan',
            'kasir.oleholeh.orders.index',
            'kasir.oleholeh.orders',
        ],
        default => [],
    };

    foreach ($orderRoutes as $routeName) {
        if (Route::has($routeName)) {
            $orderUrl = route($routeName);
            break;
        }
    }

    if (!$orderUrl) {
        $orderUrl = match ($role) {
            'kasir_menu' => url('/kasir-menu/pesanan'),
            'kasir_wahana' => url('/kasir-wahana/pesanan'),
            'kasir_oleholeh' => url('/kasir-oleholeh/pesanan'),
            default => url('/kasir'),
        };
    }
}

if (
    !$bundlingUrl &&
    in_array($role, ['kasir_menu', 'kasir_wahana'], true)
) {
    $bundlingRoutes = match ($role) {
        'kasir_menu' => [
            'kasir.menu.bundling.index',
            'kasir.menu.bundling',
            'kasir.bundling.pesanan.index',
            'kasir.bundling.pesanan',
            'kasir.bundling.index',
            'kasir.bundling',
        ],
        'kasir_wahana' => [
            'kasir.wahana.bundling.index',
            'kasir.wahana.bundling',
            'kasir.bundling.pesanan.index',
            'kasir.bundling.pesanan',
            'kasir.bundling.index',
            'kasir.bundling',
        ],
        default => [],
    };

    foreach ($bundlingRoutes as $routeName) {
        if (Route::has($routeName)) {
            $bundlingUrl = route($routeName);
            break;
        }
    }

    if (!$bundlingUrl) {
        $bundlingUrl = match ($role) {
            'kasir_menu' => url('/kasir-menu/pesanan-bundling'),
            'kasir_wahana' => url('/kasir-wahana/pesanan-bundling'),
            default => url('/kasir'),
        };
    }
}

if ($role === 'kasir_oleholeh' && !$stockUrl) {
    $stockUrl = Route::has('kasir.oleholeh.stock')
        ? route('kasir.oleholeh.stock')
        : url('/kasir-oleholeh/stok-oleholeh');
}

if ($role === 'kasir_oleholeh' && $stockUrl) {
    $hasStockShortcut = collect($shortcut)->contains(function ($item) {
        return strtolower(trim($item['title'] ?? '')) === 'stok oleh-oleh';
    });

    if (!$hasStockShortcut) {
        $stockShortcut = [
            'title' => 'Stok Oleh-Oleh',
            'description' => 'Kelola dan perbarui stok produk oleh-oleh.',
            'icon' => 'fa-boxes-stacked',
            'url' => $stockUrl,
        ];

        $bundlingIndex = null;

        foreach ($shortcut as $index => $item) {
            if (strtolower(trim($item['title'] ?? '')) === 'pesanan bundling') {
                $bundlingIndex = $index;
                break;
            }
        }

        if ($bundlingIndex !== null) {
            array_splice($shortcut, $bundlingIndex, 0, [$stockShortcut]);
        } else {
            $shortcut[] = $stockShortcut;
        }
    }
}
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0a0a0a">
    <title>Dashboard {{ $roleName }} - Noyo Gimbal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @stack('styles')
</head>

<body class="kasir-dashboard-page">
    @include('kasir.partials.sidebar')

    <main class="kasir-main-content">
        <header class="kasir-topbar">
            <div class="kasir-topbar-left">
                <button type="button" class="kasir-mobile-menu-button" id="openKasirSidebar" aria-label="Buka menu">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="kasir-breadcrumb">
                    <span>Kasir</span>
                    <i class="fas fa-chevron-right"></i>
                    <span class="current">Dashboard</span>
                </div>
            </div>

            <div class="kasir-topbar-user">
                <div class="kasir-topbar-user-text">
                    <strong>{{ $namaKasir }}</strong>
                    <span>{{ $roleName }}</span>
                </div>

                <div class="kasir-topbar-avatar">
                    {{ strtoupper(mb_substr(trim($namaKasir), 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="kasir-content-wrapper">
            <section class="kasir-welcome">
                <div class="kasir-welcome-glow"></div>

                <div class="kasir-welcome-content">
                    <div class="kasir-welcome-label">
                        <span class="kasir-welcome-dot"></span>
                        Panel Kasir
                    </div>

                    <h1>
                        Selamat datang,
                        <span>{{ $namaKasir }}</span>
                    </h1>

                    <p>
                        Kelola {{ strtolower($orderTitle) }}
                        @if($role === 'kasir_oleholeh')
                            dan stok oleh-oleh
                        @elseif(in_array($role, ['kasir_menu', 'kasir_wahana'], true))
                            serta transaksi bundling
                        @endif
                        melalui panel kasir Noyo Gimbal.
                    </p>
                </div>

                <div class="kasir-welcome-role">
                    <span>Role</span>
                    <strong>{{ $roleName }}</strong>
                </div>
            </section>

            <section class="kasir-section">
                <div class="kasir-section-header">
                    <div>
                        <span class="kasir-section-eyebrow">Ringkasan</span>
                        <h2>Statistik Pesanan</h2>
                    </div>

                    <span class="kasir-section-note">Data transaksi</span>
                </div>

                <div class="kasir-stat-grid">
                    <div class="kasir-stat-card">
                        <div class="kasir-stat-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="kasir-stat-info">
                            <span>Total Pesanan</span>
                            <strong>{{ number_format($statistics['total_pesanan'] ?? 0, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div class="kasir-stat-card">
                        <div class="kasir-stat-icon warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="kasir-stat-info">
                            <span>Menunggu</span>
                            <strong>{{ number_format($statistics['menunggu'] ?? 0, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div class="kasir-stat-card">
                        <div class="kasir-stat-icon process">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="kasir-stat-info">
                            <span>Diproses</span>
                            <strong>{{ number_format($statistics['diproses'] ?? 0, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div class="kasir-stat-card">
                        <div class="kasir-stat-icon success">
                            <i class="fas fa-circle-check"></i>
                        </div>
                        <div class="kasir-stat-info">
                            <span>Selesai</span>
                            <strong>{{ number_format($statistics['selesai'] ?? 0, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div class="kasir-stat-card kasir-stat-income">
                        <div class="kasir-stat-icon income">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="kasir-stat-info">
                            <span>Pendapatan</span>
                            <strong>Rp {{ number_format($statistics['pendapatan'] ?? 0, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            </section>

            <div class="kasir-dashboard-grid">
                <section class="kasir-panel">
                    <div class="kasir-panel-header">
                        <div>
                            <span class="kasir-panel-eyebrow">Akses Cepat</span>
                            <h2>Kelola Transaksi</h2>
                        </div>
                    </div>

                    <div class="kasir-shortcut-list">
                        @forelse($shortcut as $item)
                            <a href="{{ $item['url'] ?? '#' }}" class="kasir-shortcut-card">
                                <div class="kasir-shortcut-icon">
                                    <i class="fas {{ $item['icon'] ?? 'fa-receipt' }}"></i>
                                </div>

                                <div class="kasir-shortcut-content">
                                    <strong>{{ $item['title'] ?? 'Pesanan' }}</strong>
                                    <span>{{ $item['description'] ?? '' }}</span>
                                </div>

                                <div class="kasir-shortcut-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        @empty
                            @if($orderUrl)
                                <a href="{{ $orderUrl }}" class="kasir-shortcut-card">
                                    <div class="kasir-shortcut-icon">
                                        <i class="fas {{ $orderIcon }}"></i>
                                    </div>

                                    <div class="kasir-shortcut-content">
                                        <strong>{{ $orderTitle }}</strong>
                                        <span>{{ $orderDescription ?? 'Kelola dan verifikasi pesanan sesuai role kasir.' }}</span>
                                    </div>

                                    <div class="kasir-shortcut-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </a>
                            @endif

                            @if(in_array($role, ['kasir_menu', 'kasir_wahana'], true) && $bundlingUrl)
                                <a href="{{ $bundlingUrl }}" class="kasir-shortcut-card">
                                    <div class="kasir-shortcut-icon">
                                        <i class="fas fa-boxes-stacked"></i>
                                    </div>

                                    <div class="kasir-shortcut-content">
                                        <strong>Pesanan Bundling</strong>
                                        <span>Kelola dan verifikasi pesanan paket bundling.</span>
                                    </div>

                                    <div class="kasir-shortcut-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </a>
                            @endif
                        @endforelse
                    </div>
                </section>

                <section class="kasir-panel kasir-role-panel">
                    <div class="kasir-panel-header">
                        <div>
                            <span class="kasir-panel-eyebrow">Informasi Akun</span>
                            <h2>Hak Akses</h2>
                        </div>
                    </div>

                    <div class="kasir-role-box">
                        <div class="kasir-role-icon">
                            @if($role === 'kasir_menu')
                                <i class="fas fa-utensils"></i>
                            @elseif($role === 'kasir_wahana')
                                <i class="fas fa-ticket"></i>
                            @elseif($role === 'kasir_oleholeh')
                                <i class="fas fa-bag-shopping"></i>
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>

                        <div>
                            <span>Login sebagai</span>
                            <strong>{{ $roleName }}</strong>
                        </div>
                    </div>

                    <div class="kasir-access-list">
                        <div class="kasir-access-item">
                            <span class="kasir-access-check"><i class="fas fa-check"></i></span>
                            <span>Dashboard Kasir</span>
                        </div>

                        <div class="kasir-access-item">
                            <span class="kasir-access-check"><i class="fas fa-check"></i></span>
                            <span>{{ $orderTitle }}</span>
                        </div>

                        @if($role === 'kasir_oleholeh')
                            <div class="kasir-access-item">
                                <span class="kasir-access-check"><i class="fas fa-check"></i></span>
                                <span>Stok Oleh-Oleh</span>
                            </div>
                        @endif

                        @if(in_array($role, ['kasir_menu', 'kasir_wahana'], true))
                            <div class="kasir-access-item">
                                <span class="kasir-access-check"><i class="fas fa-check"></i></span>
                                <span>Pesanan Bundling</span>
                            </div>
                        @endif
                    </div>

                    <div class="kasir-role-note">
                        <i class="fas fa-circle-info"></i>
                        <span>Menu yang tersedia disesuaikan dengan role akun kasir.</span>
                    </div>
                </section>
            </div>

            <section class="kasir-panel kasir-recent-panel">
                <div class="kasir-panel-header">
                    <div>
                        <span class="kasir-panel-eyebrow">Aktivitas</span>
                        <h2>Pesanan Terbaru</h2>
                    </div>

                    @if($orderUrl)
                        <a href="{{ $orderUrl }}" class="kasir-view-all">
                            Lihat Semua
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif
                </div>

                @if(count($recentOrders) > 0)
                    <div class="kasir-order-table-wrapper">
                        <table class="kasir-order-table">
                            <thead>
                                <tr>
                                    <th>Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td><strong>{{ $order['kode'] ?? '-' }}</strong></td>
                                        <td>{{ $order['pelanggan'] ?? '-' }}</td>
                                        <td>
                                            @php
                                                $status = strtolower($order['status'] ?? '');
                                            @endphp

                                            <span class="kasir-order-status {{ $status }}">
                                                {{ ucfirst($order['status'] ?? '-') }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($order['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $order['waktu'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="kasir-empty-state">
                        <div class="kasir-empty-icon">
                            <i class="fas fa-receipt"></i>
                        </div>

                        <h3>Belum Ada Pesanan</h3>

                        <p>Pesanan terbaru akan muncul di sini setelah terdapat transaksi.</p>

                        @if($orderUrl)
                            <a href="{{ $orderUrl }}" class="kasir-empty-button">
                                <i class="fas fa-arrow-right"></i>
                                Kelola {{ $orderTitle }}
                            </a>
                        @endif
                    </div>
                @endif
            </section>

            <footer class="kasir-dashboard-footer">
                <span>© {{ date('Y') }} Noyo Gimbal</span>
                <span class="kasir-footer-divider">•</span>
                <span>{{ $roleName }}</span>
            </footer>
        </div>
    </main>

    <style>
        :root{
            --bg-primary:#0a0a0a;
            --bg-secondary:#151515;
            --bg-soft:#1a1a1a;
            --bg-card:#121212;
            --text-primary:#f8f4ed;
            --text-secondary:#d4c9b5;
            --text-muted:#a89988;
            --text-dim:#7a6f62;
            --accent:#e2c997;
            --accent-hover:#d4b384;
            --accent-dark:#b89a6e;
            --border-soft:rgba(255,255,255,.07);
            --border-gold:rgba(226,201,151,.16);
            --white:#ffffff;
            --black:#000000;
            --shadow-soft:0 20px 60px rgba(0,0,0,.4);
            --shadow-hover:0 25px 70px rgba(0,0,0,.5);
            --radius-lg:28px;
            --radius-md:16px;
            --radius-sm:12px;
            --radius-full:999px;
            --transition:.25s cubic-bezier(.4,0,.2,1);
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html{
            scroll-behavior:smooth;
        }

        body{
            font-family:'Inter','DM Sans',Arial,sans-serif;
            background:var(--bg-primary);
            color:var(--text-primary);
            overflow-x:hidden;
            line-height:1.6;
        }

        .kasir-main-content{
            min-height:100vh;
            margin-left:252px;
            background:
                radial-gradient(circle at 82% 8%,rgba(226,201,151,.08),transparent 28%),
                radial-gradient(circle at 15% 75%,rgba(226,201,151,.035),transparent 30%),
                var(--bg-primary);
        }

        .kasir-topbar{
            position:sticky;
            top:0;
            z-index:900;
            display:flex;
            align-items:center;
            justify-content:space-between;
            min-height:76px;
            padding:0 clamp(20px,3vw,46px);
            background:rgba(10,10,10,.86);
            border-bottom:1px solid var(--border-soft);
            backdrop-filter:blur(22px);
        }

        .kasir-topbar-left{
            display:flex;
            align-items:center;
            gap:16px;
        }

        .kasir-breadcrumb{
            display:flex;
            align-items:center;
            gap:10px;
            color:var(--text-dim);
            font-size:12px;
            font-weight:500;
        }

        .kasir-breadcrumb i{
            color:var(--accent-dark);
            font-size:8px;
        }

        .kasir-breadcrumb .current{
            color:var(--text-secondary);
            font-weight:700;
        }

        .kasir-mobile-menu-button{
            display:none;
            align-items:center;
            justify-content:center;
            width:44px;
            height:44px;
            color:var(--text-primary);
            background:var(--bg-secondary);
            border:1px solid var(--border-gold);
            border-radius:12px;
            cursor:pointer;
        }

        .kasir-topbar-user{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .kasir-topbar-user-text{
            text-align:right;
        }

        .kasir-topbar-user-text strong{
            display:block;
            color:var(--text-primary);
            font-size:13px;
            font-weight:700;
        }

        .kasir-topbar-user-text span{
            display:block;
            margin-top:2px;
            color:var(--text-muted);
            font-size:10px;
        }

        .kasir-topbar-avatar{
            display:flex;
            align-items:center;
            justify-content:center;
            width:42px;
            height:42px;
            color:var(--bg-primary);
            background:linear-gradient(135deg,var(--accent),var(--accent-dark));
            border-radius:13px;
            font-size:14px;
            font-weight:800;
            box-shadow:0 8px 25px rgba(226,201,151,.12);
        }

        .kasir-content-wrapper{
            width:min(92%,1380px);
            margin:0 auto;
            padding:34px 0 30px;
        }

        .kasir-welcome{
            position:relative;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:28px;
            min-height:220px;
            margin-bottom:36px;
            padding:clamp(28px,4vw,48px);
            background:
                linear-gradient(135deg,rgba(226,201,151,.13),rgba(255,255,255,.025) 46%,rgba(255,255,255,.015)),
                var(--bg-secondary);
            border:1px solid var(--border-gold);
            border-radius:var(--radius-lg);
            overflow:hidden;
            box-shadow:var(--shadow-soft);
        }

        .kasir-welcome::before{
            content:'';
            position:absolute;
            width:260px;
            height:260px;
            right:-90px;
            top:-120px;
            background:radial-gradient(circle,rgba(226,201,151,.18),transparent 70%);
            pointer-events:none;
        }

        .kasir-welcome-glow{
            position:absolute;
            width:170px;
            height:170px;
            left:-100px;
            bottom:-100px;
            background:rgba(226,201,151,.06);
            border-radius:50%;
            filter:blur(12px);
        }

        .kasir-welcome-content{
            position:relative;
            z-index:1;
            min-width:0;
        }

        .kasir-welcome-label{
            display:flex;
            align-items:center;
            gap:9px;
            margin-bottom:13px;
            color:var(--accent);
            font-size:11px;
            font-weight:700;
            letter-spacing:1.8px;
            text-transform:uppercase;
        }

        .kasir-welcome-dot{
            width:7px;
            height:7px;
            background:var(--accent);
            border-radius:50%;
            box-shadow:0 0 14px rgba(226,201,151,.6);
        }

        .kasir-welcome h1{
            margin:0;
            color:var(--text-primary);
            font-family:'Playfair Display',Georgia,serif;
            font-size:clamp(30px,4vw,48px);
            line-height:1.15;
            font-weight:700;
        }

        .kasir-welcome h1 span{
            color:var(--accent);
        }

        .kasir-welcome p{
            max-width:720px;
            margin:15px 0 0;
            color:var(--text-muted);
            font-size:14px;
            line-height:1.8;
        }

        .kasir-welcome p strong{
            color:var(--text-secondary);
        }

        .kasir-welcome-role{
            position:relative;
            z-index:1;
            flex-shrink:0;
            min-width:190px;
            padding:18px 20px;
            background:rgba(255,255,255,.045);
            border:1px solid var(--border-gold);
            border-radius:var(--radius-md);
            backdrop-filter:blur(14px);
        }

        .kasir-welcome-role span{
            display:block;
            margin-bottom:6px;
            color:var(--text-dim);
            font-size:10px;
            letter-spacing:1.3px;
            text-transform:uppercase;
        }

        .kasir-welcome-role strong{
            color:var(--text-primary);
            font-size:14px;
            font-weight:700;
        }

        .kasir-section{
            margin-bottom:34px;
        }

        .kasir-section-header,
        .kasir-panel-header{
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:20px;
        }

        .kasir-section-header{
            margin-bottom:16px;
        }

        .kasir-section-eyebrow,
        .kasir-panel-eyebrow{
            display:block;
            margin-bottom:6px;
            color:var(--accent);
            font-size:10px;
            font-weight:700;
            letter-spacing:1.7px;
            text-transform:uppercase;
        }

        .kasir-section-header h2,
        .kasir-panel-header h2{
            margin:0;
            color:var(--text-primary);
            font-family:'Playfair Display',Georgia,serif;
            font-size:clamp(20px,2vw,25px);
            line-height:1.25;
            font-weight:700;
        }

        .kasir-section-note{
            color:var(--text-dim);
            font-size:11px;
        }

        .kasir-stat-grid{
            display:grid;
            grid-template-columns:repeat(5,minmax(0,1fr));
            gap:14px;
        }

        .kasir-stat-card{
            position:relative;
            display:flex;
            align-items:center;
            gap:14px;
            min-width:0;
            min-height:104px;
            padding:18px;
            background:linear-gradient(145deg,rgba(255,255,255,.055),rgba(255,255,255,.025));
            border:1px solid var(--border-soft);
            border-radius:var(--radius-md);
            transition:transform var(--transition),border-color var(--transition),box-shadow var(--transition);
        }

        .kasir-stat-card:hover{
            transform:translateY(-4px);
            border-color:var(--border-gold);
            box-shadow:var(--shadow-hover);
        }

        .kasir-stat-icon{
            display:flex;
            align-items:center;
            justify-content:center;
            width:46px;
            height:46px;
            flex-shrink:0;
            color:var(--accent);
            background:rgba(226,201,151,.10);
            border:1px solid rgba(226,201,151,.13);
            border-radius:13px;
            font-size:15px;
        }

        .kasir-stat-icon.warning{
            color:#e0b56a;
            background:rgba(224,181,106,.10);
        }

        .kasir-stat-icon.process{
            color:#9eb5cc;
            background:rgba(158,181,204,.10);
        }

        .kasir-stat-icon.success{
            color:#9dc6a7;
            background:rgba(157,198,167,.10);
        }

        .kasir-stat-icon.income{
            color:var(--accent);
            background:rgba(226,201,151,.12);
        }

        .kasir-stat-info{
            min-width:0;
        }

        .kasir-stat-info span{
            display:block;
            margin-bottom:6px;
            overflow:hidden;
            color:var(--text-muted);
            font-size:11px;
            line-height:1.2;
            text-overflow:ellipsis;
            white-space:nowrap;
        }

        .kasir-stat-info strong{
            display:block;
            overflow:hidden;
            color:var(--text-primary);
            font-size:21px;
            line-height:1.1;
            font-weight:700;
            text-overflow:ellipsis;
            white-space:nowrap;
        }

        .kasir-stat-income .kasir-stat-info strong{
            color:var(--accent);
            font-size:17px;
        }

        .kasir-dashboard-grid{
            display:grid;
            grid-template-columns:minmax(0,1.4fr) minmax(300px,.8fr);
            gap:18px;
            margin-bottom:18px;
        }

        .kasir-panel{
            background:rgba(18,18,18,.82);
            border:1px solid var(--border-soft);
            border-radius:var(--radius-lg);
            overflow:hidden;
            box-shadow:0 14px 45px rgba(0,0,0,.22);
        }

        .kasir-panel-header{
            padding:24px 25px 19px;
            border-bottom:1px solid var(--border-soft);
        }

        .kasir-shortcut-list{
            padding:10px 12px 14px;
        }

        .kasir-shortcut-card{
            display:flex;
            align-items:center;
            gap:14px;
            padding:15px 13px;
            color:inherit;
            text-decoration:none;
            border:1px solid transparent;
            border-radius:14px;
            transition:background var(--transition),border-color var(--transition),transform var(--transition);
        }

        .kasir-shortcut-card:hover{
            background:rgba(226,201,151,.055);
            border-color:var(--border-gold);
            transform:translateX(3px);
        }

        .kasir-shortcut-icon{
            display:flex;
            align-items:center;
            justify-content:center;
            width:46px;
            height:46px;
            flex-shrink:0;
            color:var(--accent);
            background:rgba(226,201,151,.08);
            border:1px solid rgba(226,201,151,.12);
            border-radius:13px;
            font-size:15px;
        }

        .kasir-shortcut-content{
            min-width:0;
            flex:1;
        }

        .kasir-shortcut-content strong{
            display:block;
            margin-bottom:4px;
            color:var(--text-primary);
            font-size:13px;
            font-weight:700;
        }

        .kasir-shortcut-content span{
            display:block;
            overflow:hidden;
            color:var(--text-muted);
            font-size:11px;
            line-height:1.5;
            text-overflow:ellipsis;
            white-space:nowrap;
        }

        .kasir-shortcut-arrow{
            display:flex;
            align-items:center;
            justify-content:center;
            width:32px;
            height:32px;
            flex-shrink:0;
            color:var(--text-dim);
            border:1px solid var(--border-soft);
            border-radius:50%;
            font-size:10px;
            transition:color var(--transition),border-color var(--transition),transform var(--transition);
        }

        .kasir-shortcut-card:hover .kasir-shortcut-arrow{
            color:var(--accent);
            border-color:var(--border-gold);
            transform:translateX(2px);
        }

        .kasir-role-panel{
            padding-bottom:18px;
        }

        .kasir-role-box{
            display:flex;
            align-items:center;
            gap:13px;
            margin:18px 20px;
            padding:16px;
            background:rgba(255,255,255,.035);
            border:1px solid var(--border-soft);
            border-radius:14px;
        }

        .kasir-role-icon{
            display:flex;
            align-items:center;
            justify-content:center;
            width:46px;
            height:46px;
            color:var(--accent);
            background:rgba(226,201,151,.08);
            border:1px solid var(--border-gold);
            border-radius:13px;
            font-size:15px;
        }

        .kasir-role-box span{
            display:block;
            margin-bottom:4px;
            color:var(--text-dim);
            font-size:10px;
        }

        .kasir-role-box strong{
            color:var(--text-primary);
            font-size:13px;
            font-weight:700;
        }

        .kasir-access-list{
            padding:0 20px;
        }

        .kasir-access-item{
            display:flex;
            align-items:center;
            gap:10px;
            padding:10px 0;
            color:var(--text-secondary);
            font-size:11px;
            border-bottom:1px solid var(--border-soft);
        }

        .kasir-access-item:last-child{
            border-bottom:none;
        }

        .kasir-access-check{
            display:flex;
            align-items:center;
            justify-content:center;
            width:20px;
            height:20px;
            flex-shrink:0;
            color:var(--accent);
            background:rgba(226,201,151,.09);
            border-radius:50%;
            font-size:8px;
        }

        .kasir-role-note{
            display:flex;
            align-items:flex-start;
            gap:9px;
            margin:16px 20px 0;
            padding:12px;
            color:var(--text-muted);
            background:rgba(255,255,255,.025);
            border:1px solid var(--border-soft);
            border-radius:11px;
            font-size:10px;
            line-height:1.55;
        }

        .kasir-role-note i{
            flex-shrink:0;
            margin-top:2px;
            color:var(--accent);
        }

        .kasir-recent-panel{
            margin-bottom:24px;
        }

        .kasir-view-all{
            display:inline-flex;
            align-items:center;
            gap:7px;
            color:var(--accent);
            text-decoration:none;
            font-size:11px;
            font-weight:700;
            transition:color var(--transition);
        }

        .kasir-view-all:hover{
            color:var(--text-primary);
        }

        .kasir-order-table-wrapper{
            width:100%;
            overflow-x:auto;
        }

        .kasir-order-table{
            width:100%;
            min-width:650px;
            border-collapse:collapse;
        }

        .kasir-order-table th{
            padding:13px 22px;
            color:var(--text-dim);
            background:rgba(255,255,255,.025);
            font-size:10px;
            font-weight:700;
            letter-spacing:.7px;
            text-align:left;
            text-transform:uppercase;
            border-bottom:1px solid var(--border-soft);
        }

        .kasir-order-table td{
            padding:16px 22px;
            color:var(--text-muted);
            font-size:11px;
            border-bottom:1px solid var(--border-soft);
        }

        .kasir-order-table tbody tr:last-child td{
            border-bottom:none;
        }

        .kasir-order-table tbody tr{
            transition:background var(--transition);
        }

        .kasir-order-table tbody tr:hover{
            background:rgba(226,201,151,.035);
        }

        .kasir-order-table td strong{
            color:var(--text-primary);
            font-size:12px;
        }

        .kasir-order-status{
            display:inline-flex;
            align-items:center;
            padding:5px 9px;
            border:1px solid transparent;
            border-radius:var(--radius-full);
            font-size:9px;
            font-weight:700;
        }

        .kasir-order-status.menunggu{
            color:#e4bd77;
            background:rgba(228,189,119,.08);
            border-color:rgba(228,189,119,.15);
        }

        .kasir-order-status.diproses{
            color:#a9c0d7;
            background:rgba(169,192,215,.08);
            border-color:rgba(169,192,215,.15);
        }

        .kasir-order-status.selesai{
            color:#a9cfb2;
            background:rgba(169,207,178,.08);
            border-color:rgba(169,207,178,.15);
        }

        .kasir-empty-state{
            display:flex;
            align-items:center;
            flex-direction:column;
            padding:58px 24px 64px;
            text-align:center;
        }

        .kasir-empty-icon{
            display:flex;
            align-items:center;
            justify-content:center;
            width:58px;
            height:58px;
            margin-bottom:15px;
            color:var(--accent);
            background:rgba(226,201,151,.07);
            border:1px solid var(--border-gold);
            border-radius:16px;
            font-size:19px;
        }

        .kasir-empty-state h3{
            margin:0 0 7px;
            color:var(--text-primary);
            font-family:'Playfair Display',Georgia,serif;
            font-size:18px;
            font-weight:700;
        }

        .kasir-empty-state p{
            max-width:430px;
            margin:0 0 20px;
            color:var(--text-muted);
            font-size:11px;
            line-height:1.7;
        }

        .kasir-empty-button{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:11px 17px;
            color:var(--bg-primary);
            background:linear-gradient(135deg,var(--accent),var(--accent-hover));
            border-radius:var(--radius-full);
            font-size:11px;
            font-weight:700;
            text-decoration:none;
            transition:transform var(--transition),box-shadow var(--transition);
        }

        .kasir-empty-button:hover{
            transform:translateY(-2px);
            box-shadow:0 12px 30px rgba(226,201,151,.14);
        }

        .kasir-dashboard-footer{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:9px;
            padding:8px 0 3px;
            color:var(--text-dim);
            font-size:10px;
        }

        .kasir-footer-divider{
            color:var(--accent-dark);
        }

        @media (max-width:1200px){
            .kasir-content-wrapper{
                width:min(94%,1180px);
            }

            .kasir-stat-grid{
                grid-template-columns:repeat(3,minmax(0,1fr));
            }

            .kasir-stat-income{
                grid-column:span 1;
            }
        }

        @media (max-width:1024px){
            .kasir-main-content{
                margin-left:0;
            }

            .kasir-mobile-menu-button{
                display:flex;
            }

            .kasir-dashboard-grid{
                grid-template-columns:1fr;
            }

            .kasir-welcome{
                min-height:200px;
            }
        }

        @media (max-width:768px){
            .kasir-topbar{
                min-height:68px;
                padding:0 20px;
            }

            .kasir-content-wrapper{
                width:calc(100% - 32px);
                padding:24px 0 24px;
            }

            .kasir-welcome{
                align-items:flex-start;
                flex-direction:column;
                gap:22px;
                min-height:auto;
                padding:28px 24px;
                border-radius:22px;
            }

            .kasir-welcome h1{
                font-size:32px;
            }

            .kasir-welcome p{
                font-size:13px;
            }

            .kasir-welcome-role{
                width:100%;
                min-width:0;
            }

            .kasir-stat-grid{
                grid-template-columns:repeat(2,minmax(0,1fr));
                gap:11px;
            }

            .kasir-stat-card{
                min-height:100px;
                padding:16px;
            }

            .kasir-stat-info strong{
                font-size:19px;
            }

            .kasir-section-header h2,
            .kasir-panel-header h2{
                font-size:21px;
            }

            .kasir-panel-header{
                padding:21px 20px 17px;
            }
        }

        @media (max-width:560px){
            .kasir-topbar{
                padding:0 14px;
            }

            .kasir-content-wrapper{
                width:calc(100% - 24px);
                padding-top:18px;
            }

            .kasir-breadcrumb{
                font-size:11px;
            }

            .kasir-topbar-user-text{
                display:none;
            }

            .kasir-topbar-avatar{
                width:40px;
                height:40px;
            }

            .kasir-welcome{
                margin-bottom:27px;
                padding:25px 20px;
            }

            .kasir-welcome h1{
                font-size:28px;
            }

            .kasir-welcome p{
                font-size:12px;
            }

            .kasir-stat-grid{
                grid-template-columns:1fr 1fr;
                gap:9px;
            }

            .kasir-stat-card{
                flex-direction:column;
                align-items:flex-start;
                gap:10px;
                min-height:126px;
                padding:14px;
            }

            .kasir-stat-icon{
                width:40px;
                height:40px;
                border-radius:11px;
            }

            .kasir-stat-info span{
                font-size:10px;
            }

            .kasir-stat-info strong{
                font-size:17px;
            }

            .kasir-stat-income .kasir-stat-info strong{
                font-size:13px;
            }

            .kasir-section-header{
                align-items:flex-start;
                flex-direction:column;
                gap:5px;
            }

            .kasir-section-header h2,
            .kasir-panel-header h2{
                font-size:19px;
            }

            .kasir-shortcut-card{
                padding:13px 9px;
            }

            .kasir-shortcut-icon{
                width:42px;
                height:42px;
            }

            .kasir-shortcut-content span{
                white-space:normal;
            }

            .kasir-role-box{
                margin:16px;
            }

            .kasir-access-list{
                padding:0 16px;
            }

            .kasir-role-note{
                margin-left:16px;
                margin-right:16px;
            }

            .kasir-dashboard-footer{
                font-size:9px;
            }
        }

        @media (prefers-reduced-motion:reduce){
            *,
            *::before,
            *::after{
                scroll-behavior:auto !important;
                transition:none !important;
            }
        }
    </style>
</body>
</html>
