@extends('public.layouts.app')

@section('title', 'Pesanan Berhasil - Noyo Gimbal')

@section('content')
@php
    $nomorWhatsAppNoyo = '6289516328034';

    $namaPelanggan = $pesanan->nama_pelanggan ?? '-';
    $noWa = $pesanan->no_wa ?? '-';
    $kodePesanan = $pesanan->kode_pesanan ?? '-';
    $metodePembayaran = $pesanan->metode_pembayaran ?? 'Cash';
    $statusPesanan = $pesanan->status ?? 'Menunggu Pembayaran';
    $totalHarga = (int) ($pesanan->total_harga ?? 0);
    $isQris = strtoupper(trim((string) $metodePembayaran)) === 'QRIS';
    $statusNormalized = mb_strtolower(trim((string) $statusPesanan));
    $statusPembayaran = mb_strtolower(trim((string) ($pesanan->status_pembayaran ?? '')));
    $isPaymentFailed = in_array($statusNormalized, ['pembayaran gagal', 'batal', 'dibatalkan', 'failed', 'cancelled', 'canceled'], true)
        || in_array($statusPembayaran, ['gagal', 'failed', 'expire', 'expired', 'cancel', 'cancelled', 'canceled'], true);
    $isPaid = !$isPaymentFailed && (
        in_array($statusPembayaran, ['berhasil', 'success', 'paid', 'settlement', 'capture', 'lunas'], true)
        || in_array($statusNormalized, ['menunggu pengambilan', 'diproses', 'selesai', 'lunas'], true)
    );

    $formatRupiah = function ($nominal) {
        return 'Rp ' . number_format((int) $nominal, 0, ',', '.');
    };

    $detailPesanan = $pesanan->details ?? collect();

    if (is_array($detailPesanan)) {
        $detailPesanan = collect($detailPesanan);
    } elseif (!$detailPesanan instanceof \Illuminate\Support\Collection && !$detailPesanan instanceof \Illuminate\Database\Eloquent\Collection) {
        $detailPesanan = collect();
    }

    $namaItem = function ($detail) {
        $detail = is_array($detail) ? (object) $detail : $detail;

        $menu = data_get($detail, 'menu');
        if ($menu) {
            return data_get($menu, 'nama') ?? data_get($menu, 'nama_menu') ?? 'Menu';
        }

        $tiket = data_get($detail, 'tiketWahana');
        if ($tiket) {
            return data_get($tiket, 'nama_wahana')
                ?? data_get($tiket, 'nama_tiket')
                ?? data_get($tiket, 'nama')
                ?? 'Tiket Wahana';
        }

        $olehOleh = data_get($detail, 'olehOleh');
        if ($olehOleh) {
            return data_get($olehOleh, 'nama')
                ?? data_get($olehOleh, 'nama_oleh_oleh')
                ?? 'Oleh-Oleh';
        }

        $paket = data_get($detail, 'paketBundling');
        if ($paket) {
            return data_get($paket, 'nama_paket')
                ?? data_get($paket, 'nama_paket_bundling')
                ?? 'Paket Bundling';
        }

        return data_get($detail, 'nama_produk') ?? data_get($detail, 'nama') ?? 'Produk';
    };

    $jenisItem = function ($detail) {
        if (data_get($detail, 'menu')) return 'Menu';
        if (data_get($detail, 'tiketWahana')) return 'Wahana';
        if (data_get($detail, 'olehOleh')) return 'Oleh-Oleh';
        if (data_get($detail, 'paketBundling')) return 'Paket Bundling';
        return 'Produk';
    };

    if ($isQris) {
        $pesanWa = "Halo Admin Noyo Gimbal 👋

";
        $pesanWa .= "*PERTANYAAN STATUS PEMBAYARAN QRIS*
";
        $pesanWa .= "────────────────────

";
        $pesanWa .= "Nama pelanggan : {$namaPelanggan}
";
        $pesanWa .= "No. WhatsApp   : {$noWa}
";
        $pesanWa .= "Kode pesanan   : {$kodePesanan}
";
        $pesanWa .= "Total pesanan  : {$formatRupiah($totalHarga)}
";
        $pesanWa .= "Status sistem  : {$statusPesanan}

";
        $pesanWa .= $isPaid
            ? "Pembayaran QRIS saya sudah terkonfirmasi. Mohon informasi proses selanjutnya.

"
            : "Saya ingin meminta bantuan untuk mengecek status pembayaran QRIS pesanan ini.

";
        $pesanWa .= "Terima kasih. 🙏";
    } else {
        $pesanWa = "Halo Admin Noyo Gimbal 👋

";
        $pesanWa .= "*KONFIRMASI PESANAN CASH*
";
        $pesanWa .= "────────────────────

";
        $pesanWa .= "Nama pelanggan : {$namaPelanggan}
";
        $pesanWa .= "No. WhatsApp   : {$noWa}
";
        $pesanWa .= "Kode pesanan   : {$kodePesanan}
";
        $pesanWa .= "Pembayaran     : Cash
";
        $pesanWa .= "Status         : {$statusPesanan}
";
        $pesanWa .= "Total pesanan  : {$formatRupiah($totalHarga)}

";
        $pesanWa .= "Saya akan melakukan pembayaran Cash di Noyo Gimbal. Mohon bantu konfirmasi pesanan saya.

";
        $pesanWa .= "Terima kasih. 🙏";
    }

    $nomorWhatsAppNoyo = preg_replace('/\D+/', '', $nomorWhatsAppNoyo);
    $whatsappUrl = 'https://wa.me/' . $nomorWhatsAppNoyo
        . '?text=' . rawurlencode($pesanWa);

    if ($isQris && $isPaid) {
        $pageTitle = 'Pembayaran Terkonfirmasi';
        $pageDescription = 'Pembayaran QRIS kamu sudah terkonfirmasi. Simpan kode pesanan ini untuk keperluan pengambilan atau pengecekan pesanan.';
    } elseif ($isQris && $isPaymentFailed) {
        $pageTitle = 'Status Pembayaran Perlu Diperiksa';
        $pageDescription = 'Pesanan tercatat, tetapi status pembayaran QRIS belum berhasil. Hubungi admin untuk memeriksa transaksi sebelum mencoba membayar kembali.';
    } elseif ($isQris) {
        $pageTitle = 'Pesanan Berhasil Dibuat';
        $pageDescription = 'Pesanan kamu sudah dibuat. Status pembayaran QRIS masih menunggu konfirmasi dari Midtrans. Simpan kode pesanan ini dan periksa status sebelum melakukan pembayaran ulang.';
    } elseif ($isPaymentFailed) {
        $pageTitle = 'Pesanan Tidak Aktif';
        $pageDescription = 'Pesanan ini berstatus dibatalkan atau pembayaran gagal. Hubungi admin apabila kamu membutuhkan bantuan untuk memeriksa pesanan.';
    } else {
        $pageTitle = 'Pesanan Berhasil Dibuat';
        $pageDescription = 'Pesanan kamu sudah berhasil dibuat. Simpan kode pesanan ini dan sampaikan kepada kasir saat melakukan pembayaran Cash di Noyo Gimbal.';
    }
@endphp

<style>
    .order-success-page {
        width: 100%;
        min-width: 0;
        min-height: calc(100vh - 80px);
        overflow-x: clip;
        background:
            radial-gradient(circle at 50% 0%, rgba(226, 201, 151, .08), transparent 34%),
            #0a0a0a;
        color: #f8f4ed;
        padding: 70px 20px 90px;
    }

    .order-success-container {
        width: min(900px, 100%);
        min-width: 0;
        margin: 0 auto;
    }

    .success-card {
        min-width: 0;
        background: #121212;
        border: 1px solid rgba(226, 201, 151, .20);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 70px rgba(0,0,0,.35);
    }

    .success-top {
        text-align: center;
        padding: 55px 30px 38px;
        border-bottom: 1px solid rgba(226, 201, 151, .12);
    }

    .success-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(226, 201, 151, .45);
        background: rgba(226, 201, 151, .08);
        color: #e2c997;
    }

    .success-icon svg {
        width: 31px;
        height: 31px;
    }

    .success-eyebrow {
        margin: 0 0 10px;
        color: #e2c997;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .22em;
        text-transform: uppercase;
    }

    .success-title {
        margin: 0;
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(34px, 5vw, 52px);
        line-height: 1.05;
        font-weight: 500;
        color: #f8f4ed;
    }

    .success-description {
        max-width: 590px;
        margin: 18px auto 0;
        color: #a89988;
        font-size: 14px;
        line-height: 1.8;
    }

    .order-code-box {
        margin: 28px auto 0;
        width: min(430px, 100%);
        padding: 18px 20px;
        border: 1px solid rgba(226, 201, 151, .22);
        border-radius: 14px;
        background: #151515;
    }

    .order-code-label {
        display: block;
        margin-bottom: 7px;
        color: #7a6f62;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .16em;
        text-transform: uppercase;
    }

    .order-code {
        color: #e2c997;
        overflow-wrap: anywhere;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: .08em;
    }

    .success-body {
        padding: 35px;
    }

    .section-title {
        margin: 0 0 18px;
        color: #f8f4ed;
        font-family: "Playfair Display", Georgia, serif;
        font-size: 25px;
        font-weight: 500;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 32px;
    }

    .info-item {
        padding: 17px 18px;
        border: 1px solid rgba(226, 201, 151, .12);
        border-radius: 13px;
        background: #151515;
    }

    .info-label {
        display: block;
        margin-bottom: 6px;
        color: #7a6f62;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .info-value {
        min-width: 0;
        color: #e8e0d4;
        font-size: 14px;
        font-weight: 600;
        word-break: break-word;
    }

    .status-value {
        color: #e2c997;
        overflow-wrap: anywhere;
    }

    .order-success-page a:focus-visible {
        outline: 3px solid rgba(226, 201, 151, .55);
        outline-offset: 3px;
    }

    @media (prefers-reduced-motion: reduce) {
        .order-success-page *,
        .order-success-page *::before,
        .order-success-page *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
            scroll-behavior: auto !important;
        }
    }

    .items-wrapper {
        border: 1px solid rgba(226, 201, 151, .12);
        border-radius: 15px;
        overflow: hidden;
        background: #151515;
    }

    .item-row {
        display: grid;
        min-width: 0;
        grid-template-columns: minmax(0, 1fr) auto auto;
        gap: 20px;
        align-items: center;
        padding: 17px 19px;
        border-bottom: 1px solid rgba(226, 201, 151, .08);
    }

    .item-row:last-child {
        border-bottom: 0;
    }

    .item-name {
        min-width: 0;
        color: #f8f4ed;
        overflow-wrap: anywhere;
        font-size: 14px;
        font-weight: 600;
    }

    .item-type {
        margin-top: 4px;
        color: #7a6f62;
        font-size: 11px;
    }

    .item-qty {
        color: #a89988;
        font-size: 13px;
        white-space: nowrap;
    }

    .item-subtotal {
        color: #e2c997;
        overflow-wrap: anywhere;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
        text-align: right;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-top: 15px;
        padding: 20px;
        border: 1px solid rgba(226, 201, 151, .20);
        border-radius: 14px;
        background: rgba(226, 201, 151, .045);
    }

    .total-label {
        color: #a89988;
        font-size: 13px;
    }

    .total-value {
        max-width: 65%;
        color: #e2c997;
        overflow-wrap: anywhere;
        text-align: right;
        font-size: 21px;
        font-weight: 700;
    }

    .order-notice {
        margin-top: 25px;
        padding: 19px 20px;
        border-left: 2px solid #e2c997;
        border-radius: 0 12px 12px 0;
        background: rgba(226, 201, 151, .05);
    }

    .order-notice.is-success {
        border-left-color: #86c99b;
        background: rgba(134, 201, 155, .06);
    }

    .order-notice.is-warning {
        border-left-color: #d98276;
        background: rgba(217, 130, 118, .055);
    }

    .order-notice-title {
        margin-bottom: 6px;
        color: #e2c997;
        font-size: 13px;
        font-weight: 700;
    }

    .order-notice.is-success .order-notice-title {
        color: #9dd9ad;
    }

    .order-notice.is-warning .order-notice-title {
        color: #dfa69e;
    }

    .order-notice-text {
        color: #a89988;
        font-size: 13px;
        line-height: 1.7;
    }

    .cash-notice {
        margin-top: 25px;
        padding: 19px 20px;
        border-left: 2px solid #e2c997;
        border-radius: 0 12px 12px 0;
        background: rgba(226, 201, 151, .05);
    }

    .cash-notice-title {
        margin-bottom: 6px;
        color: #e2c997;
        font-size: 13px;
        font-weight: 700;
    }

    .cash-notice-text {
        color: #a89988;
        font-size: 13px;
        line-height: 1.7;
    }

    .actions {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 12px;
        margin-top: 30px;
    }

    .action-btn {
        min-width: 0;
        min-height: 50px;
        overflow-wrap: anywhere;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
    }

    .action-primary {
        color: #0a0a0a;
        background: #e2c997;
    }

    .action-primary:hover {
        background: #d4b384;
        transform: translateY(-1px);
    }

    .action-secondary {
        color: #e2c997;
        border: 1px solid rgba(226, 201, 151, .28);
        background: transparent;
    }

    .action-secondary:hover {
        background: rgba(226, 201, 151, .06);
        border-color: rgba(226, 201, 151, .48);
    }

    .wa-icon {
        width: 17px;
        height: 17px;
        margin-right: 8px;
    }

    .wa-auto-notice {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        margin-top: 24px;
        padding: 12px 15px;
        border: 1px solid rgba(226, 201, 151, .12);
        border-radius: 10px;
        background: rgba(226, 201, 151, .035);
        color: #a89988;
        font-size: 12px;
        line-height: 1.5;
        text-align: center;
    }

    .wa-auto-dot {
        width: 7px;
        height: 7px;
        flex: 0 0 7px;
        border-radius: 50%;
        background: #e2c997;
        box-shadow: 0 0 0 4px rgba(226, 201, 151, .08);
        animation: waPulse 1.2s ease-in-out infinite;
    }

    @keyframes waPulse {
        0%, 100% {
            opacity: .45;
            transform: scale(.9);
        }
        50% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @media (max-width: 640px) {
        .order-success-page {
            padding: 40px 14px 60px;
        }

        .success-top {
            padding: 40px 20px 30px;
        }

        .success-body {
            padding: 25px 18px 28px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .item-row {
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 7px 12px;
            align-items: start;
        }

        .item-row > div:first-child {
            min-width: 0;
        }

        .item-subtotal {
            grid-column: 2;
            grid-row: 1 / span 2;
        }

        .actions {
            grid-template-columns: 1fr;
        }

        .total-row {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .total-value {
            max-width: 70%;
            text-align: right;
        }
    }
</style>

<div class="order-success-page">
    <div class="order-success-container">
        <div class="success-card">

            <div class="success-top">
                <div class="success-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        @if($isPaymentFailed)
                            <path d="M12 8v5m0 4h.01M10.3 3.8 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0Z" stroke-linecap="round" stroke-linejoin="round"/>
                        @elseif($isPaid)
                            <path d="M20 6 9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/>
                        @else
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 2" stroke-linecap="round" stroke-linejoin="round"/>
                        @endif
                    </svg>
                </div>

                <p class="success-eyebrow">Noyo Gimbal</p>

                <h1 class="success-title">{{ $pageTitle }}</h1>

                <p class="success-description">{{ $pageDescription }}</p>

                <div class="order-code-box">
                    <span class="order-code-label">Kode Pesanan</span>
                    <div class="order-code">{{ $kodePesanan }}</div>
                </div>
            </div>

            <div class="success-body">

                <h2 class="section-title">Informasi Pesanan</h2>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nama Pelanggan</span>
                        <span class="info-value">{{ $namaPelanggan }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">No. WhatsApp</span>
                        <span class="info-value">{{ $noWa }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Pembayaran</span>
                        <span class="info-value">{{ $metodePembayaran }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value status-value">{{ $statusPesanan }}</span>
                    </div>
                </div>

                <h2 class="section-title">Detail Pesanan</h2>

                <div class="items-wrapper">
                    @forelse($detailPesanan as $detail)
                        <div class="item-row">
                            <div>
                                <div class="item-name">
                                    {{ $namaItem($detail) }}
                                </div>

                                <div class="item-type">
                                    {{ $jenisItem($detail) }}
                                    · {{ $formatRupiah($detail->harga ?? 0) }} / item
                                </div>
                            </div>

                            <div class="item-qty">
                                x{{ (int) ($detail->qty ?? 1) }}
                            </div>

                            <div class="item-subtotal">
                                {{ $formatRupiah($detail->subtotal ?? 0) }}
                            </div>
                        </div>
                    @empty
                        <div class="item-row">
                            <div class="item-name">Tidak ada detail pesanan.</div>
                        </div>
                    @endforelse
                </div>

                <div class="total-row">
                    <span class="total-label">Total Pesanan</span>
                    <span class="total-value">{{ $formatRupiah($totalHarga) }}</span>
                </div>

                @if($isPaymentFailed)
                    <div class="order-notice is-warning" role="status">
                        <div class="order-notice-title">Pesanan atau pembayaran tidak aktif</div>
                        <div class="order-notice-text">
                            Status pesanan saat ini adalah {{ $statusPesanan }}. Jangan melakukan pembayaran ulang sebelum status transaksi diperiksa. Hubungi admin dan sertakan kode pesanan untuk mendapatkan bantuan.
                        </div>
                    </div>
                @elseif($isQris)
                    <div class="order-notice {{ $isPaid ? 'is-success' : '' }}" role="status">
                        @if($isPaid)
                            <div class="order-notice-title">Pembayaran QRIS terkonfirmasi</div>
                            <div class="order-notice-text">
                                Midtrans telah mengonfirmasi pembayaran ini. Simpan kode pesanan untuk pengecekan atau pengambilan pesanan. Status operasional pesanan tetap ditampilkan sesuai data sistem.
                            </div>
                        @else
                            <div class="order-notice-title">Menunggu konfirmasi Midtrans</div>
                            <div class="order-notice-text">
                                Jika kamu baru saja membayar, tunggu notifikasi pembayaran diproses oleh sistem. Jangan membayar dua kali. Jika status belum berubah setelah beberapa saat, hubungi admin untuk pengecekan.
                            </div>
                        @endif
                    </div>
                @else
                    <div class="order-notice" role="status">
                        <div class="order-notice-title">Pembayaran Cash</div>
                        <div class="order-notice-text">
                            Silakan datang ke Noyo Gimbal dan lakukan pembayaran tunai kepada kasir. Sampaikan <strong>nama pelanggan</strong> atau <strong>kode pesanan</strong> agar pesanan dapat ditemukan dan diproses.
                        </div>
                    </div>
                @endif

                <div class="actions">
                    <a href="{{ $whatsappUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="action-btn action-primary">
                        <svg class="wa-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.04 2C6.51 2 2 6.51 2 12.04c0 1.77.46 3.5 1.33 5.04L2 22l5.07-1.31a10 10 0 0 0 4.97 1.35h.01c5.53 0 10.03-4.51 10.03-10.04C22.08 6.51 17.57 2 12.04 2Zm5.84 14.43c-.25.7-1.46 1.34-2 1.43-.5.08-1.13.12-1.83-.11-.42-.14-.95-.31-1.64-.6-2.89-1.25-4.78-4.16-4.93-4.35-.14-.19-1.18-1.57-1.18-2.99s.75-2.12 1.02-2.41c.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.42-.07.65.5.24.58.83 2.02.9 2.17.07.14.12.31.02.5-.09.19-.14.31-.28.48-.14.17-.29.37-.41.5-.14.14-.29.29-.12.58.17.29.75 1.24 1.61 2.01 1.1.98 2.03 1.28 2.32 1.42.29.14.46.12.63-.07.17-.19.72-.84.91-1.13.19-.29.38-.24.64-.14.26.09 1.68.79 1.97.93.29.14.48.21.55.33.07.12.07.72-.18 1.42Z"/>
                        </svg>
                        {{ $isQris ? 'Hubungi Admin via WhatsApp' : 'Konfirmasi Pesanan via WhatsApp' }}
                    </a>

                    <a href="{{ route('public.home') }}"
                       class="action-btn action-secondary">
                        Kembali ke Home
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
