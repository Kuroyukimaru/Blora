@php
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | PESANAN BUNDLING - KASIR MENU
    |--------------------------------------------------------------------------
    | Halaman ini khusus untuk bagian MENU dari Paket Bundling.
    |
    | Alur:
    | 1. Customer membayar bagian Menu secara Cash.
    | 2. Kasir Menu membuka Detail Pesanan.
    | 3. Kasir Menu melihat seluruh item Menu dalam paket.
    | 4. Kasir Menu memverifikasi pembayaran + bagian Menu.
    | 5. Bagian Wahana tetap menjadi tanggung jawab Kasir Wahana.
    |
    | Status pembayaran Menu dan Wahana TIDAK menggunakan status
    | pesanan utama karena pembayarannya dilakukan terpisah.
    */

    $orders = $orders ?? ($pesanans ?? collect());

    $user = auth('admin')->user();
    $role = $user?->role ?? '';
    $namaKasir = $user?->nama ?? $user?->name ?? 'Kasir';

    $isKasirMenu = $role === 'kasir_menu';

    $currentBundlingRoute = Route::has('kasir.menu.bundling')
        ? 'kasir.menu.bundling'
        : null;

    $verifyMenuRoute = Route::has('kasir.menu.bundling.verify-menu')
        ? 'kasir.menu.bundling.verify-menu'
        : null;

    $search = request('search', '');

    $getStatusClass = function ($status) {
        return match ($status) {
            'Selesai' => 'status-selesai',
            'Diproses' => 'status-diproses',
            'Batal' => 'status-batal',
            default => 'status-menunggu',
        };
    };

    /*
    | Nilai yang dianggap sudah dibayar untuk bagian Menu.
    | Field utama yang digunakan:
    |     status_pembayaran_menu_bundling
    |
    | Jika field masih kosong/null, dianggap BELUM dibayar.
    | Ini penting supaya status pembayaran Menu tidak ikut mengambil
    | nilai dari $order->status yang merupakan status keseluruhan pesanan.
    */
    $isMenuPaymentPaid = function ($status) {
        return in_array(
            mb_strtolower(trim((string) $status)),
            [
                'sudah dibayar',
                'dibayar',
                'paid',
                'selesai',
            ],
            true
        );
    };
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesanan Bundling | Noyo Gimbal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>
        :root {
            --bg: #f6f4f0;
            --white: #ffffff;
            --dark: #22211f;
            --text: #302f2c;
            --muted: #88847c;
            --border: #e7e3dc;

            --gold: #b98746;
            --gold-dark: #95682f;
            --gold-light: #faf4ea;

            --green: #4f8963;
            --green-bg: #edf7f0;

            --blue: #55799f;
            --blue-bg: #eef4f9;

            --orange: #a27635;
            --orange-bg: #fbf4e7;

            --red: #a95850;
            --red-bg: #faeeee;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
        }

        .bundling-main {
            min-height: 100vh;
            margin-left: 252px;
        }

        /* TOPBAR */
        .bundling-topbar {
            position: sticky;
            top: 0;
            z-index: 100;

            min-height: 68px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 34px;

            background: rgba(255, 255, 255, .95);
            border-bottom: 1px solid var(--border);

            backdrop-filter: blur(10px);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;

            color: #aaa69e;
            font-size: 9px;
        }

        .breadcrumb .active {
            color: var(--dark);
            font-weight: 700;
        }

        .breadcrumb i {
            font-size: 7px;
        }

        .cashier-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cashier-text {
            text-align: right;
        }

        .cashier-text strong {
            display: block;
            color: var(--dark);
            font-size: 10px;
            font-weight: 700;
        }

        .cashier-text span {
            display: block;
            margin-top: 2px;
            color: var(--muted);
            font-size: 8px;
        }

        .cashier-avatar {
            width: 35px;
            height: 35px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--gold-dark);
            background: var(--gold-light);

            border: 1px solid #ead9bf;
            border-radius: 9px;

            font-size: 11px;
            font-weight: 800;
        }

        /* CONTENT */
        .bundling-content {
            width: min(calc(100% - 68px), 1240px);
            margin: 0 auto;
            padding: 31px 0 45px;
        }

        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;

            margin-bottom: 22px;
        }

        .eyebrow {
            display: block;
            margin-bottom: 5px;

            color: var(--gold);

            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .page-title {
            margin: 0;

            color: var(--dark);
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            line-height: 1.1;
        }

        .page-description {
            margin: 8px 0 0;

            color: var(--muted);

            font-size: 10px;
            line-height: 1.6;
        }

        .bundling-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 10px 13px;

            color: var(--gold-dark);
            background: var(--gold-light);

            border: 1px solid #ead9bf;
            border-radius: 9px;

            font-size: 9px;
            font-weight: 800;
            white-space: nowrap;
        }

        .bundling-label i {
            font-size: 11px;
        }

        /* ALERT */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;

            margin-bottom: 18px;
            padding: 12px 14px;

            border-radius: 10px;

            font-size: 10px;
            line-height: 1.5;
        }

        .alert.success {
            color: var(--green);
            background: var(--green-bg);
            border: 1px solid #d7ebdc;
        }

        .alert.error {
            color: var(--red);
            background: var(--red-bg);
            border: 1px solid #efd5d2;
        }

        /* SEARCH */
        .search-card {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;

            padding: 14px;

            margin-bottom: 18px;

            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            top: 50%;
            left: 13px;

            transform: translateY(-50%);

            color: #aaa69e;
            font-size: 10px;
        }

        .search-input {
            width: 100%;
            height: 40px;

            padding: 0 13px 0 34px;

            color: var(--text);
            background: #faf9f7;

            border: 1px solid var(--border);
            border-radius: 8px;

            outline: none;

            font-family: inherit;
            font-size: 10px;
        }

        .search-input:focus {
            border-color: #cba978;
            box-shadow: 0 0 0 3px rgba(185,135,70,.08);
            background: #fff;
        }

        .search-button {
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            padding: 0 16px;

            color: #fff;
            background: var(--gold);

            border: 0;
            border-radius: 8px;

            cursor: pointer;

            font-family: inherit;
            font-size: 9px;
            font-weight: 800;
        }

        .search-button:hover {
            background: var(--gold-dark);
        }

        /* ORDER CARD */
        .orders {
            display: grid;
            gap: 12px;
        }

        .order-card {
            overflow: hidden;

            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 13px;

            transition: .18s ease;
        }

        .order-card:hover {
            box-shadow: 0 8px 25px rgba(40, 35, 28, .05);
            transform: translateY(-1px);
        }

        .order-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            padding: 16px 18px;

            border-bottom: 1px solid #eeebe6;
        }

        .order-code {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .order-icon {
            width: 37px;
            height: 37px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--gold-dark);
            background: var(--gold-light);

            border-radius: 9px;

            font-size: 12px;
        }

        .order-code strong {
            display: block;

            color: var(--dark);

            font-size: 11px;
            font-weight: 800;
        }

        .order-code span {
            display: block;

            margin-top: 3px;

            color: var(--muted);

            font-size: 8px;
        }

        .order-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 7px 9px;

            border-radius: 7px;

            font-size: 8px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-stack {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            flex-direction: column;
            gap: 5px;
        }

        .payment-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 6px 9px;

            border-radius: 7px;

            font-size: 7px;
            font-weight: 800;
            white-space: nowrap;
        }

        .payment-paid {
            color: var(--green);
            background: var(--green-bg);
        }

        .payment-unpaid {
            color: var(--orange);
            background: var(--orange-bg);
        }

        .payment-cancelled {
            color: var(--red);
            background: var(--red-bg);
        }

        .status-menunggu {
            color: var(--orange);
            background: var(--orange-bg);
        }

        .status-diproses {
            color: var(--blue);
            background: var(--blue-bg);
        }

        .status-selesai {
            color: var(--green);
            background: var(--green-bg);
        }

        .status-batal {
            color: var(--red);
            background: var(--red-bg);
        }

        /* ORDER BODY */
        .order-body {
            padding: 16px 18px 18px;
        }

        .customer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 9px;

            margin-bottom: 13px;
        }

        .info-box {
            padding: 10px 11px;

            background: #faf9f7;
            border: 1px solid #eeebe6;
            border-radius: 8px;
        }

        .info-label {
            display: block;

            margin-bottom: 4px;

            color: #aaa69e;

            font-size: 7px;
            font-weight: 800;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .info-value {
            display: block;

            color: var(--text);

            font-size: 9px;
            font-weight: 700;

            word-break: break-word;
        }

        /* BUNDLE */
        .bundle-box {
            padding: 12px;

            background: #fffdf9;

            border: 1px solid #eee5d6;
            border-radius: 10px;
        }

        .bundle-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;

            margin-bottom: 10px;
        }

        .bundle-title {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .bundle-title i {
            color: var(--gold);
            font-size: 11px;
        }

        .bundle-title strong {
            color: var(--dark);
            font-size: 10px;
            font-weight: 800;
        }

        .qty {
            padding: 5px 7px;

            color: var(--gold-dark);
            background: var(--gold-light);

            border-radius: 6px;

            font-size: 8px;
            font-weight: 800;
        }

        .component-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 9px;
        }

        .component {
            padding: 10px;

            background: #fff;

            border: 1px solid #eeeae5;
            border-radius: 8px;
        }

        .component-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;

            margin-bottom: 7px;
        }

        .component-name {
            display: flex;
            align-items: center;
            gap: 6px;

            color: var(--text);

            font-size: 8px;
            font-weight: 800;
        }

        .component-name.menu i {
            color: var(--gold);
        }

        .component-name.wahana i {
            color: var(--blue);
        }

        .component-status {
            padding: 4px 6px;

            border-radius: 5px;

            font-size: 7px;
            font-weight: 800;
            white-space: nowrap;
        }

        .component-status.done {
            color: var(--green);
            background: var(--green-bg);
        }

        .component-status.wait {
            color: var(--orange);
            background: var(--orange-bg);
        }

        .component-list {
            margin: 0;
            padding-left: 15px;

            color: var(--muted);

            font-size: 8px;
            line-height: 1.6;
        }

        .component-list li {
            margin-bottom: 1px;
        }

        .no-component {
            margin: 0;

            color: #aaa69e;

            font-size: 8px;
        }

        .item-status-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            margin-top: 9px;
            padding-top: 8px;

            border-top: 1px dashed #e9dfce;
        }

        .item-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            padding: 5px 7px;

            border-radius: 6px;

            font-size: 7px;
            font-weight: 800;
        }

        .item-status.done {
            color: var(--green);
            background: var(--green-bg);
        }

        .item-status.wait {
            color: var(--orange);
            background: var(--orange-bg);
        }

        /* FOOTER */
        .order-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;

            margin-top: 13px;
        }

        .total {
            color: var(--muted);
            font-size: 8px;
        }

        .total strong {
            margin-left: 5px;

            color: var(--dark);

            font-size: 11px;
        }

        .detail-button {
            min-height: 38px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            padding: 0 14px;

            color: #fff;
            background: var(--dark);

            border: 0;
            border-radius: 8px;

            text-decoration: none;

            font-size: 8px;
            font-weight: 800;
        }

        .detail-button:hover {
            background: var(--gold-dark);
        }

        .route-warning {
            padding: 9px 11px;

            color: var(--red);
            background: var(--red-bg);

            border: 1px solid #efd5d2;
            border-radius: 7px;

            font-size: 8px;
        }

        /* EMPTY */
        .empty {
            padding: 65px 25px;

            text-align: center;

            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 13px;
        }

        .empty-icon {
            width: 55px;
            height: 55px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 13px;

            color: var(--gold);
            background: var(--gold-light);

            border-radius: 13px;

            font-size: 18px;
        }

        .empty h3 {
            margin: 0;

            color: var(--dark);

            font-family: 'Playfair Display', serif;
            font-size: 20px;
        }

        .empty p {
            max-width: 430px;

            margin: 8px auto 0;

            color: var(--muted);

            font-size: 9px;
            line-height: 1.6;
        }

        /* PAGINATION */
        .pagination {
            margin-top: 18px;
        }

        .pagination nav {
            display: flex;
            justify-content: center;
        }

        .pagination svg {
            width: 15px;
            height: 15px;
        }

        .pagination a,
        .pagination span {
            font-size: 9px !important;
        }

        /* MENU DETAIL MODAL */
        .menu-modal {
            position: fixed;
            inset: 0;
            z-index: 500;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(25, 23, 20, .58);
            backdrop-filter: blur(5px);
        }

        .menu-modal.show {
            display: flex;
        }

        .menu-modal-card {
            width: min(100%, 570px);
            max-height: min(720px, calc(100vh - 40px));
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 25px 70px rgba(25, 23, 20, .20);
            animation: menuModalIn .18s ease-out;
        }

        @keyframes menuModalIn {
            from {
                opacity: 0;
                transform: translateY(8px) scale(.985);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .menu-modal-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            padding: 18px 20px;
            border-bottom: 1px solid #eeebe6;
        }

        .menu-modal-eyebrow {
            display: block;
            margin-bottom: 4px;
            color: var(--gold);
            font-size: 7px;
            font-weight: 800;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .menu-modal-title {
            margin: 0;
            color: var(--dark);
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            line-height: 1.15;
        }

        .menu-modal-code {
            margin-top: 5px;
            color: var(--muted);
            font-size: 8px;
            font-weight: 600;
        }

        .menu-modal-close {
            width: 31px;
            height: 31px;
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #77736c;
            background: #f7f5f1;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: .18s ease;
        }

        .menu-modal-close:hover {
            color: var(--dark);
            background: #eeeae4;
        }

        .menu-modal-body {
            overflow-y: auto;
            padding: 16px 20px;
        }

        .menu-payment-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
            padding: 11px 12px;
            background: #faf9f7;
            border: 1px solid #eeebe6;
            border-radius: 9px;
        }

        .menu-payment-summary .label {
            color: #aaa69e;
            font-size: 7px;
            font-weight: 800;
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        .menu-payment-summary .method {
            margin-top: 3px;
            color: var(--text);
            font-size: 9px;
            font-weight: 700;
        }

        .menu-payment-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 8px;
            border-radius: 6px;
            font-size: 7px;
            font-weight: 800;
            white-space: nowrap;
        }

        .menu-payment-badge.paid {
            color: var(--green);
            background: var(--green-bg);
        }

        .menu-payment-badge.unpaid {
            color: var(--orange);
            background: var(--orange-bg);
        }

        .menu-payment-badge.cancelled {
            color: var(--red);
            background: var(--red-bg);
        }

        .menu-modal-section {
            display: grid;
            gap: 9px;
        }

        .menu-modal-package {
            padding: 12px;
            background: #fffdf9;
            border: 1px solid #eee5d6;
            border-radius: 10px;
        }

        .menu-modal-package-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 9px;
        }

        .menu-modal-package-name {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--dark);
            font-size: 10px;
            font-weight: 800;
        }

        .menu-modal-package-name i {
            color: var(--gold);
            font-size: 10px;
        }

        .menu-modal-qty {
            padding: 5px 7px;
            color: var(--gold-dark);
            background: var(--gold-light);
            border-radius: 6px;
            font-size: 7px;
            font-weight: 800;
        }

        .menu-modal-list {
            display: grid;
            gap: 6px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .menu-modal-list li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 9px 10px;
            color: var(--text);
            background: #fff;
            border: 1px solid #eeeae5;
            border-radius: 8px;
            font-size: 8px;
            font-weight: 700;
        }

        .menu-modal-list li span:first-child {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .menu-modal-list li i {
            color: var(--gold);
            font-size: 8px;
        }

        .menu-modal-list .item-qty {
            color: var(--muted);
            font-size: 7px;
            font-weight: 700;
            white-space: nowrap;
        }

        .menu-modal-empty {
            padding: 12px;
            color: var(--muted);
            background: #faf9f7;
            border: 1px dashed #ddd7ce;
            border-radius: 8px;
            font-size: 8px;
            text-align: center;
        }

        .menu-modal-foot {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            padding: 14px 20px;
            border-top: 1px solid #eeebe6;
            background: #fff;
        }

        .menu-modal-action {
            min-height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0 13px;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            font-size: 8px;
            font-weight: 800;
            transition: .18s ease;
        }

        .menu-modal-action.secondary {
            color: var(--text);
            background: #f7f5f1;
            border: 1px solid var(--border);
        }

        .menu-modal-action.secondary:hover {
            background: #eeeae4;
        }

        .menu-modal-action.primary {
            color: #fff;
            background: var(--gold);
            border: 1px solid var(--gold);
        }

        .menu-modal-action.primary:hover {
            background: var(--gold-dark);
            border-color: var(--gold-dark);
        }

        .menu-modal-action.disabled {
            color: var(--green);
            background: var(--green-bg);
            border: 1px solid #d7ebdc;
            cursor: default;
        }

        .menu-modal-note {
            margin-right: auto;
            color: var(--muted);
            font-size: 7px;
            line-height: 1.5;
        }

        .detail-button {
            cursor: pointer;
        }

        body.modal-open {
            overflow: hidden;
        }

        @media (max-width: 520px) {
            .menu-modal {
                padding: 12px;
            }

            .menu-modal-card {
                max-height: calc(100vh - 24px);
                border-radius: 13px;
            }

            .menu-modal-head,
            .menu-modal-body,
            .menu-modal-foot {
                padding-left: 15px;
                padding-right: 15px;
            }

            .menu-modal-foot {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .menu-modal-action {
                width: 100%;
            }

            .menu-modal-note {
                margin-right: 0;
                text-align: center;
            }
        }

        /* RESPONSIVE */
        @media (max-width: 1050px) {
            .bundling-main {
                margin-left: 0;
            }

            .bundling-content {
                width: min(calc(100% - 36px), 1240px);
            }
        }

        @media (max-width: 760px) {
            .bundling-topbar {
                padding: 0 18px;
            }

            .cashier-text {
                display: none;
            }

            .bundling-content {
                width: min(calc(100% - 24px), 1240px);
                padding-top: 22px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-title {
                font-size: 27px;
            }

            .search-card {
                grid-template-columns: 1fr;
            }

            .search-button {
                width: 100%;
            }

            .order-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .customer-grid {
                grid-template-columns: 1fr;
            }

            .component-grid {
                grid-template-columns: 1fr;
            }

            .order-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .detail-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR KASIR EXISTING --}}
    @include('kasir.partials.sidebar')

    <main class="bundling-main">

        {{-- TOPBAR --}}
        <header class="bundling-topbar">

            <div class="breadcrumb">
                <span>Kasir</span>

                <i class="fa-solid fa-chevron-right"></i>

                <span class="active">
                    Pesanan Bundling
                </span>
            </div>

            <div class="cashier-profile">

                <div class="cashier-text">
                    <strong>{{ $namaKasir }}</strong>

                    <span>
                        @if ($isKasirMenu)
                            Kasir Menu
                        @elseif ($isKasirWahana)
                            Kasir Wahana
                        @else
                            Kasir
                        @endif
                    </span>
                </div>

                <div class="cashier-avatar">
                    {{ strtoupper(substr($namaKasir, 0, 1)) }}
                </div>

            </div>

        </header>

        {{-- CONTENT --}}
        <section class="bundling-content">

            <div class="page-heading">

                <div>
                    <span class="eyebrow">
                        Paket Pesanan
                    </span>

                    <h1 class="page-title">
                        Pesanan Bundling
                    </h1>

                    <p class="page-description">
                        Daftar pesanan yang menggunakan paket bundling.
                        Menu dan wahana dalam paket diverifikasi oleh kasir masing-masing.
                    </p>
                </div>

                <div class="bundling-label">
                    <i class="fa-solid fa-box-open"></i>
                    Paket Bundling
                </div>

            </div>

            {{-- FLASH MESSAGE --}}
            @if (session('success'))
                <div class="alert success">
                    <i class="fa-solid fa-circle-check"></i>

                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert error">
                    <i class="fa-solid fa-circle-exclamation"></i>

                    <div>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert error">
                    <i class="fa-solid fa-circle-exclamation"></i>

                    <div>
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            {{-- SEARCH --}}
            <form
                method="GET"
                action="{{ $currentBundlingRoute ? route($currentBundlingRoute) : url()->current() }}"
                class="search-card"
            >

                <div class="search-wrapper">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        class="search-input"
                        placeholder="Cari kode pesanan, pelanggan, WhatsApp, atau nama paket..."
                        autocomplete="off"
                    >

                </div>

                <button
                    type="submit"
                    class="search-button"
                >
                    <i class="fa-solid fa-search"></i>
                    Cari
                </button>

            </form>

            {{-- ORDER LIST --}}
            @if ($orders->count() === 0)

                <div class="empty">

                    <div class="empty-icon">
                        <i class="fa-solid fa-box-open"></i>
                    </div>

                    <h3>
                        Belum Ada Pesanan Bundling
                    </h3>

                    <p>
                        @if ($search !== '')
                            Pesanan bundling dengan kata kunci
                            "<strong>{{ $search }}</strong>"
                            tidak ditemukan.
                        @else
                            Pesanan yang menggunakan Paket Bundling akan muncul di halaman ini.
                        @endif
                    </p>

                </div>

            @else

                <div class="orders">

                    @foreach ($orders as $order)

                        @php
                            /*
                            |--------------------------------------------------------------
                            | Hanya detail Bundling yang memiliki komponen MENU.
                            | Pesanan Bundling yang hanya memiliki Wahana tidak masuk
                            | ke halaman Kasir Menu.
                            |--------------------------------------------------------------
                            */
                            $bundleDetails = ($order->details ?? collect())
                                ->filter(function ($detail) {
                                    $paket = $detail->paketBundling;

                                    return !is_null($detail->id_paket_bundling)
                                        && $paket
                                        && $paket->menus
                                        && $paket->menus->isNotEmpty();
                                })
                                ->values();

                            $orderStatus = $order->status ?? 'Menunggu Pembayaran';
                            $isCancelled = $orderStatus === 'Batal';

                            /*
                            |--------------------------------------------------------------
                            | PEMBAYARAN MENU
                            |--------------------------------------------------------------
                            | Jangan mengambil pembayaran dari $order->status.
                            | Pembayaran Menu dan Wahana dilakukan terpisah.
                            */
                            $allMenuPaid = !$bundleDetails->isEmpty()
                                && $bundleDetails->every(function ($detail) use ($isMenuPaymentPaid) {
                                    return $isMenuPaymentPaid(
                                        $detail->status_pembayaran_menu_bundling ?? null
                                    );
                                });

                            $paymentLabel = $isCancelled
                                ? 'Pesanan Dibatalkan'
                                : ($allMenuPaid ? 'Menu Sudah Dibayar' : 'Menu Belum Dibayar');

                            $paymentClass = $isCancelled
                                ? 'payment-cancelled'
                                : ($allMenuPaid ? 'payment-paid' : 'payment-unpaid');

                            $paymentIcon = $isCancelled
                                ? 'fa-ban'
                                : ($allMenuPaid ? 'fa-circle-check' : 'fa-clock');

                            $modalId = 'menuDetailModal-' . $order->id_pesanan;
                        @endphp

                        @if ($bundleDetails->isNotEmpty())

                            <article class="order-card">

                                {{-- ORDER HEADER --}}
                                <div class="order-head">

                                    <div class="order-code">

                                        <div class="order-icon">
                                            <i class="fa-solid fa-box-open"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $order->kode_pesanan ?? 'ORD-' . $order->id_pesanan }}
                                            </strong>

                                            <span>
                                                {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                                            </span>
                                        </div>

                                    </div>

                                    <div class="status-stack">

                                        <span class="payment-status {{ $paymentClass }}">
                                            <i class="fa-solid {{ $paymentIcon }}"></i>
                                            {{ $paymentLabel }}
                                        </span>

                                        <span class="order-status {{ $getStatusClass($orderStatus) }}">
                                            <i class="fa-solid fa-circle"></i>
                                            {{ $orderStatus }}
                                        </span>

                                    </div>

                                </div>

                                {{-- ORDER BODY --}}
                                <div class="order-body">

                                    {{-- CUSTOMER --}}
                                    <div class="customer-grid">

                                        <div class="info-box">
                                            <span class="info-label">Pelanggan</span>
                                            <span class="info-value">
                                                {{ $order->nama_pelanggan ?? '-' }}
                                            </span>
                                        </div>

                                        <div class="info-box">
                                            <span class="info-label">WhatsApp</span>
                                            <span class="info-value">
                                                {{ $order->no_wa ?? '-' }}
                                            </span>
                                        </div>

                                        <div class="info-box">
                                            <span class="info-label">Pembayaran Bagian Menu</span>
                                            <span class="info-value">
                                                {{ $order->metode_pembayaran ?? '-' }}
                                            </span>
                                        </div>

                                    </div>

                                    {{-- STATUS PEMBAYARAN MENU --}}
                                    <div class="info-box" style="margin-bottom: 13px;">

                                        <span class="info-label">
                                            Status Pembayaran Menu
                                        </span>

                                        <span
                                            class="info-value"
                                            style="display:flex;align-items:center;gap:6px;"
                                        >
                                            @if ($isCancelled)

                                                <i
                                                    class="fa-solid fa-ban"
                                                    style="color:var(--red);"
                                                ></i>

                                                <span style="color:var(--red);">
                                                    Pesanan Dibatalkan
                                                </span>

                                            @elseif ($allMenuPaid)

                                                <i
                                                    class="fa-solid fa-circle-check"
                                                    style="color:var(--green);"
                                                ></i>

                                                <span style="color:var(--green);">
                                                    Sudah Dibayar
                                                </span>

                                            @else

                                                <i
                                                    class="fa-solid fa-clock"
                                                    style="color:var(--orange);"
                                                ></i>

                                                <span style="color:var(--orange);">
                                                    Belum Dibayar
                                                </span>

                                            @endif
                                        </span>

                                    </div>

                                    {{-- RINGKASAN PAKET --}}
                                    @foreach ($bundleDetails as $detail)

                                        @php
                                            $paket = $detail->paketBundling;
                                            $menus = $paket?->menus ?? collect();

                                            $menuStatus = $detail->status_menu_bundling ?? 'Menunggu';
                                            $menuPaymentStatus = $detail->status_pembayaran_menu_bundling ?? null;

                                            $menuDone = $menuStatus === 'Selesai';
                                            $menuPaid = $isMenuPaymentPaid($menuPaymentStatus);
                                        @endphp

                                        <div class="bundle-box">

                                            <div class="bundle-title-row">

                                                <div class="bundle-title">

                                                    <i class="fa-solid fa-box-open"></i>

                                                    <strong>
                                                        {{ $paket?->nama_paket ?? 'Paket Bundling' }}
                                                    </strong>

                                                </div>

                                                <span class="qty">
                                                    Qty {{ $detail->qty ?? 1 }}
                                                </span>

                                            </div>

                                            <div class="component">

                                                <div class="component-head">

                                                    <div class="component-name menu">
                                                        <i class="fa-solid fa-utensils"></i>
                                                        Menu
                                                    </div>

                                                    <span
                                                        class="component-status {{ $menuDone ? 'done' : 'wait' }}"
                                                    >
                                                        {{ $menuStatus }}
                                                    </span>

                                                </div>

                                                @if ($menus->isNotEmpty())

                                                    <ul class="component-list">

                                                        @foreach ($menus as $menu)

                                                            <li>
                                                                {{ $menu->nama_menu ?? $menu->nama ?? 'Menu' }}
                                                            </li>

                                                        @endforeach

                                                    </ul>

                                                @else

                                                    <p class="no-component">
                                                        Tidak ada komponen Menu.
                                                    </p>

                                                @endif

                                                <div class="item-status-row">

                                                    <span
                                                        class="item-status {{ $menuPaid ? 'done' : 'wait' }}"
                                                    >
                                                        @if ($menuPaid)
                                                            <i class="fa-solid fa-circle-check"></i>
                                                            Pembayaran Menu: Sudah Dibayar
                                                        @else
                                                            <i class="fa-solid fa-clock"></i>
                                                            Pembayaran Menu: Belum Dibayar
                                                        @endif
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                    {{-- FOOTER --}}
                                    <div class="order-footer">

                                        <div class="total">
                                            Total Pesanan:

                                            <strong>
                                                Rp {{ number_format((int) ($order->total_harga ?? 0), 0, ',', '.') }}
                                            </strong>
                                        </div>

                                        <button
                                            type="button"
                                            class="detail-button"
                                            onclick="openMenuDetailModal(@js($modalId))"
                                        >
                                            <i class="fa-solid fa-utensils"></i>
                                            Detail Pesanan
                                        </button>

                                    </div>

                                </div>

                            </article>

                            {{-- ==========================================================
                                 MODAL DETAIL MENU
                                 ========================================================== --}}
                            <div
                                id="{{ $modalId }}"
                                class="menu-modal"
                                aria-hidden="true"
                            >

                                <div
                                    class="menu-modal-card"
                                    role="dialog"
                                    aria-modal="true"
                                    aria-labelledby="{{ $modalId }}-title"
                                >

                                    <div class="menu-modal-head">

                                        <div>

                                            <span class="menu-modal-eyebrow">
                                                Bagian Kasir Menu
                                            </span>

                                            <h2
                                                id="{{ $modalId }}-title"
                                                class="menu-modal-title"
                                            >
                                                Detail Pesanan Menu
                                            </h2>

                                            <div class="menu-modal-code">
                                                {{ $order->kode_pesanan ?? 'ORD-' . $order->id_pesanan }}
                                            </div>

                                        </div>

                                        <button
                                            type="button"
                                            class="menu-modal-close"
                                            aria-label="Tutup"
                                            onclick="closeMenuDetailModal(@js($modalId))"
                                        >
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>

                                    </div>

                                    <div class="menu-modal-body">

                                        <div class="menu-payment-summary">

                                            <div>
                                                <div class="label">
                                                    Pembayaran Bagian Menu
                                                </div>

                                                <div class="method">
                                                    {{ $order->metode_pembayaran ?? 'Cash' }}
                                                </div>
                                            </div>

                                            @if ($isCancelled)

                                                <span class="menu-payment-badge cancelled">
                                                    <i class="fa-solid fa-ban"></i>
                                                    Dibatalkan
                                                </span>

                                            @elseif ($allMenuPaid)

                                                <span class="menu-payment-badge paid">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    Sudah Dibayar
                                                </span>

                                            @else

                                                <span class="menu-payment-badge unpaid">
                                                    <i class="fa-solid fa-clock"></i>
                                                    Belum Dibayar
                                                </span>

                                            @endif

                                        </div>

                                        <div class="menu-modal-section">

                                            @foreach ($bundleDetails as $detail)

                                                @php
                                                    $paket = $detail->paketBundling;
                                                    $menus = $paket?->menus ?? collect();
                                                    $qtyPaket = max(1, (int) ($detail->qty ?? 1));
                                                    $menuPaymentPaid = $isMenuPaymentPaid(
                                                        $detail->status_pembayaran_menu_bundling ?? null
                                                    );
                                                @endphp

                                                <div class="menu-modal-package">

                                                    <div class="menu-modal-package-head">

                                                        <div class="menu-modal-package-name">
                                                            <i class="fa-solid fa-box-open"></i>

                                                            <span>
                                                                {{ $paket?->nama_paket ?? 'Paket Bundling' }}
                                                            </span>
                                                        </div>

                                                        <span class="menu-modal-qty">
                                                            Qty {{ $qtyPaket }}
                                                        </span>

                                                    </div>

                                                    @if ($menus->isNotEmpty())

                                                        <ul class="menu-modal-list">

                                                            @foreach ($menus as $menu)

                                                                <li>

                                                                    <span>
                                                                        <i class="fa-solid fa-utensils"></i>

                                                                        {{ $menu->nama_menu ?? $menu->nama ?? 'Menu' }}
                                                                    </span>

                                                                    <span class="item-qty">
                                                                        x{{ $qtyPaket }}
                                                                    </span>

                                                                </li>

                                                            @endforeach

                                                        </ul>

                                                    @else

                                                        <div class="menu-modal-empty">
                                                            Paket ini tidak memiliki komponen Menu.
                                                        </div>

                                                    @endif

                                                </div>

                                            @endforeach

                                        </div>

                                    </div>

                                    <div class="menu-modal-foot">

                                        <div class="menu-modal-note">
                                            Verifikasi di sini hanya untuk bagian Menu.
                                            Bagian Wahana tetap diverifikasi oleh Kasir Wahana.
                                        </div>

                                        <button
                                            type="button"
                                            class="menu-modal-action secondary"
                                            onclick="closeMenuDetailModal(@js($modalId))"
                                        >
                                            Tutup
                                        </button>

                                        @if ($isCancelled)

                                            <button
                                                type="button"
                                                class="menu-modal-action disabled"
                                                disabled
                                            >
                                                <i class="fa-solid fa-ban"></i>
                                                Pesanan Dibatalkan
                                            </button>

                                        @elseif ($allMenuPaid)

                                            <button
                                                type="button"
                                                class="menu-modal-action disabled"
                                                disabled
                                            >
                                                <i class="fa-solid fa-circle-check"></i>
                                                Menu Sudah Diverifikasi
                                            </button>

                                        @elseif ($verifyMenuRoute)

                                            <form
                                                method="POST"
                                                action="{{ route($verifyMenuRoute, $order->id_pesanan) }}"
                                                style="margin:0;"
                                                onsubmit="return confirmMenuVerification(this);"
                                            >
                                                @csrf

                                                <input
                                                    type="hidden"
                                                    name="confirmation"
                                                    value="1"
                                                >

                                                <button
                                                    type="submit"
                                                    class="menu-modal-action primary"
                                                >
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    Verifikasi Menu
                                                </button>

                                            </form>

                                        @else

                                            <button
                                                type="button"
                                                class="menu-modal-action disabled"
                                                disabled
                                            >
                                                Route Verifikasi Belum Tersedia
                                            </button>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endif

                    @endforeach

                </div>

                {{-- PAGINATION --}}
                @if (method_exists($orders, 'links'))

                    <div class="pagination">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>

                @endif

            @endif

        </section>

    </main>

    <script>
        function openMenuDetailModal(id) {
            const modal = document.getElementById(id);

            if (!modal) {
                return;
            }

            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');

            const closeButton = modal.querySelector('.menu-modal-close');

            if (closeButton) {
                setTimeout(() => closeButton.focus(), 30);
            }
        }

        function closeMenuDetailModal(id) {
            const modal = document.getElementById(id);

            if (!modal) {
                return;
            }

            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');

            const openModal = document.querySelector('.menu-modal.show');

            if (!openModal) {
                document.body.classList.remove('modal-open');
            }
        }

        function confirmMenuVerification(form) {
            return window.confirm(
                'Pastikan pembayaran Cash untuk bagian Menu sudah diterima.\\n\\n' +
                'Setelah diverifikasi, bagian Menu paket ini akan ditandai selesai.\\n' +
                'Bagian Wahana tetap menjadi tanggung jawab Kasir Wahana.\\n\\n' +
                'Lanjutkan verifikasi Menu?'
            );
        }

        document.addEventListener('click', function (event) {
            if (!event.target.classList.contains('menu-modal')) {
                return;
            }

            const modal = event.target;

            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');

            const openModal = document.querySelector('.menu-modal.show');

            if (!openModal) {
                document.body.classList.remove('modal-open');
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') {
                return;
            }

            const modal = document.querySelector('.menu-modal.show');

            if (modal) {
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
            }
        });
    </script>
</body>
</html>
