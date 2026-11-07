<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Pesanan Wahana — Kasir Wahana</title>


    

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap"
        rel="stylesheet"
    >


    

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>


    

    @include('kasir.partials.sidebar')


    @php

        

        $statusAktif =
            request(
                'status',
                'Menunggu'
            );

        $searchAktif =
            request('search');

        $opsiPerHalaman = [15, 30, 50, 75, 100];

        $perHalamanAktif = (int) request('per_page', 15);

        if (!in_array($perHalamanAktif, $opsiPerHalaman, true)) {
            $perHalamanAktif = 15;
        }


    @endphp


    

    <main class="kasir-main">


        

        <div class="mobile-topbar">

            <button
                type="button"
                class="mobile-menu-button"
                id="openKasirSidebar"
                aria-label="Buka menu"
            >

                <i class="fas fa-bars"></i>

            </button>


            <div class="mobile-brand">

                <strong>
                    NOYO GIMBAL
                </strong>

                <span>
                    KASIR WAHANA
                </span>

            </div>

        </div>


        

        <section class="page-header">

            <div class="page-header-content">

                <h1 class="page-title">
                    Pesanan Wahana
                </h1>


                <p class="page-description">
                    Kelola pembayaran dan verifikasi tiket wahana
                    yang perlu diproses oleh Kasir Wahana.
                </p>

            </div>


            <div class="header-stat">

                <div class="header-stat-icon">

                    <i class="fas fa-ticket"></i>

                </div>


                <div class="header-stat-content">

                    <span>
                        PESANAN DITAMPILKAN
                    </span>


                    <strong>
                        {{ $pesanans->total() }}
                    </strong>

                </div>

            </div>

        </section>


        

        @if(session('success'))

            <div class="alert-box alert-success">

                <div class="alert-icon">

                    <i class="fas fa-circle-check"></i>

                </div>


                <div class="alert-content">

                    <strong>
                        Berhasil
                    </strong>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>


                <button
                    type="button"
                    class="alert-close"
                    onclick="this.closest('.alert-box').remove()"
                    aria-label="Tutup"
                >

                    <i class="fas fa-xmark"></i>

                </button>

            </div>

        @endif


        

        @if(session('error'))

            <div class="alert-box alert-error">

                <div class="alert-icon">

                    <i class="fas fa-circle-exclamation"></i>

                </div>


                <div class="alert-content">

                    <strong>
                        Terjadi Kesalahan
                    </strong>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>


                <button
                    type="button"
                    class="alert-close"
                    onclick="this.closest('.alert-box').remove()"
                    aria-label="Tutup"
                >

                    <i class="fas fa-xmark"></i>

                </button>

            </div>

        @endif


        

        @if($errors->any())

            <div class="alert-box alert-error">

                <div class="alert-icon">

                    <i class="fas fa-circle-exclamation"></i>

                </div>


                <div class="alert-content">

                    <strong>
                        Data Tidak Valid
                    </strong>


                    <span>

                        {{ $errors->first() }}

                    </span>

                </div>


                <button
                    type="button"
                    class="alert-close"
                    onclick="this.closest('.alert-box').remove()"
                    aria-label="Tutup"
                >

                    <i class="fas fa-xmark"></i>

                </button>

            </div>

        @endif


        

        <section class="filter-card">

            <form
                action="{{ route('kasir.wahana.orders') }}"
                method="GET"
                class="filter-form"
            >


                

                <div class="search-wrapper">

                    <i class="fas fa-search"></i>


                    <input
                        type="text"
                        name="search"
                        value="{{ $searchAktif }}"
                        placeholder="Cari kode pesanan, nama pelanggan, atau nomor WhatsApp..."
                        autocomplete="off"
                    >


                    @if($searchAktif)

                        <a
                            href="{{ route(
                                'kasir.wahana.orders',
                                ['status' => $statusAktif, 'per_page' => $perHalamanAktif]
                            ) }}"
                            class="clear-search"
                            title="Hapus pencarian"
                        >

                            <i class="fas fa-xmark"></i>

                        </a>

                    @endif

                </div>


                

                <div class="status-wrapper">

                    <i class="fas fa-filter"></i>


                    <select
                        name="status"
                        onchange="this.form.submit()"
                    >

                        <option
                            value="Menunggu"
                            {{ $statusAktif === 'Menunggu' ? 'selected' : '' }}
                        >
                            Menunggu / Perlu Diproses
                        </option>


                        <option
                            value="Menunggu Pembayaran"
                            {{ $statusAktif === 'Menunggu Pembayaran' ? 'selected' : '' }}
                        >
                            Menunggu Pembayaran
                        </option>


                        <option
                            value="Menunggu Pengambilan"
                            {{ $statusAktif === 'Menunggu Pengambilan' ? 'selected' : '' }}
                        >
                            Menunggu Pengambilan
                        </option>

                        <option
                            value="Pembayaran Gagal"
                            {{ $statusAktif === 'Pembayaran Gagal' ? 'selected' : '' }}
                        >
                            Pembayaran Gagal
                        </option>

                        <option
                            value="Selesai"
                            {{ $statusAktif === 'Selesai' ? 'selected' : '' }}
                        >
                            Selesai
                        </option>


                        <option
                            value="Batal"
                            {{ $statusAktif === 'Batal' ? 'selected' : '' }}
                        >
                            Batal
                        </option>

                    </select>

                </div>

                <div class="per-page-wrapper">
                    <label for="per_page">Tampilkan</label>
                    <select id="per_page" name="per_page" aria-label="Jumlah pesanan per halaman">
                        @foreach($opsiPerHalaman as $jumlah)
                            <option value="{{ $jumlah }}" {{ $perHalamanAktif === $jumlah ? 'selected' : '' }}>
                                {{ $jumlah }} data
                            </option>
                        @endforeach
                    </select>
                </div>


            

            </form>

        </section>


        

        <section class="orders-card">


            

            <div class="orders-card-header">

                <div>
                    <h2>
                        Daftar Pesanan Wahana
                    </h2>

                </div>


                <div class="result-info">

                    <i class="fas fa-list"></i>


                    <span>

                        Menampilkan

                        <strong>
                            {{ $pesanans->count() }}
                        </strong>

                        dari

                        <strong>
                            {{ $pesanans->total() }}
                        </strong>

                        pesanan

                    </span>

                </div>

            </div>


            

            <div class="table-container">

                <table class="orders-table">

                    <thead>

                        <tr>

                            <th width="70">
                                #
                            </th>

                            <th>
                                Pesanan
                            </th>

                            <th>
                                Pelanggan
                            </th>

                            <th>
                                Pembayaran
                            </th>

                            <th>
                                Item Wahana
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="130">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($pesanans as $index => $pesanan)

                            @php

                                

                                $itemsWahana =
                                    $pesanan->detailPesanans
                                        ->filter(
                                            function ($detail) {

                                                return
                                                    !empty(
                                                        $detail->id_tiket_wahana
                                                    )
                                                    ||
                                                    !empty(
                                                        $detail->id_paket_bundling
                                                    );

                                            }
                                        );


                                
                                $bundlingWahanaDetails =
                                    $itemsWahana
                                        ->filter(
                                            function ($detail) {

                                                return
                                                    !empty(
                                                        $detail->id_paket_bundling
                                                    )
                                                    &&
                                                    $detail->paketBundling
                                                    &&
                                                    $detail->paketBundling->wahanas
                                                    &&
                                                    $detail->paketBundling->wahanas->isNotEmpty();

                                            }
                                        )
                                        ->values();


                                

                                $totalQty =
                                    $itemsWahana->sum(
                                        fn ($detail) =>
                                            (int) (
                                                $detail->qty ?? 0
                                            )
                                    );


                                

                                $totalItem =
                                    $itemsWahana->sum(
                                        fn ($detail) =>
                                            (int) (
                                                $detail->subtotal ?? 0
                                            )
                                    );


                                

                                $nomor =
                                    (
                                        ($pesanans->currentPage() - 1)
                                        *
                                        $pesanans->perPage()
                                    )
                                    +
                                    $index
                                    +
                                    1;

                            @endphp


                            <tr>


                                

                                <td>

                                    <span class="row-number">

                                        {{ str_pad(
                                            $nomor,
                                            2,
                                            '0',
                                            STR_PAD_LEFT
                                        ) }}

                                    </span>

                                </td>


                                

                                <td>

                                    <div class="order-identity">

                                        <div class="order-icon">

                                            <i class="fas fa-ticket"></i>

                                        </div>


                                        <div class="order-info">

                                            <strong class="order-code">

                                                {{ $pesanan->kode_pesanan }}

                                            </strong>


                                            <span>

                                                <i class="far fa-calendar"></i>

                                                {{ optional(
                                                    $pesanan->created_at
                                                )->format('d M Y, H:i') }}

                                            </span>

                                        </div>

                                    </div>

                                </td>


                                

                                <td>

                                    <div class="customer-info">

                                        <strong>

                                            {{ $pesanan->nama_pelanggan }}

                                        </strong>


                                        @if($pesanan->no_wa)

                                            <span>

                                                <i class="fab fa-whatsapp"></i>

                                                {{ $pesanan->no_wa }}

                                            </span>

                                        @else

                                            <span class="muted">

                                                Nomor WhatsApp tidak tersedia

                                            </span>

                                        @endif

                                    </div>

                                </td>

                                <td>
                                    @php
                                        $metodeBayar = strtoupper(trim((string) ($pesanan->metode_pembayaran ?? '')));
                                    @endphp
                                    <div class="payment-method-cell">
                                        <span class="payment-method-icon {{ $metodeBayar === 'QRIS' ? 'qris' : 'cash' }}">
                                            <i class="fas {{ $metodeBayar === 'QRIS' ? 'fa-qrcode' : 'fa-money-bill-wave' }}"></i>
                                        </span>
                                        <div>
                                            <strong>{{ $metodeBayar !== '' ? $metodeBayar : 'Belum dipilih' }}</strong>
                                            <span>{{ $metodeBayar === 'QRIS' ? 'Pembayaran QRIS' : (in_array($metodeBayar, ['CASH', 'TUNAI'], true) ? 'Bayar di kasir' : 'Metode pembayaran') }}</span>
                                        </div>
                                    </div>
                                </td>

                                

                                <td>

                                    <div class="items-list">

                                        @forelse(
                                            $itemsWahana->take(3)
                                            as $detail
                                        )

                                            @php

                                                $namaItem = null;
                                                $jenisItem = null;


                                                if (
                                                    $detail->id_tiket_wahana
                                                    &&
                                                    $detail->tiketWahana
                                                ) {

                                                    $namaItem =
                                                        $detail
                                                            ->tiketWahana
                                                            ->nama_wahana;

                                                    $jenisItem =
                                                        'Tiket Wahana';

                                                }


                                                elseif (
                                                    $detail->id_paket_bundling
                                                    &&
                                                    $detail->paketBundling
                                                ) {

                                                    $namaItem =
                                                        $detail
                                                            ->paketBundling
                                                            ->nama_paket
                                                        ??
                                                        $detail
                                                            ->paketBundling
                                                            ->nama_bundling
                                                        ??
                                                        'Paket Bundling';

                                                    $jenisItem =
                                                        'Paket Bundling';

                                                }

                                            @endphp


                                            @if($namaItem)

                                                <div class="item-row">

                                                    <div class="item-mini-icon">

                                                        @if(
                                                            $jenisItem ===
                                                            'Paket Bundling'
                                                        )

                                                            <i class="fas fa-box-open"></i>

                                                        @else

                                                            <i class="fas fa-ticket"></i>

                                                        @endif

                                                    </div>


                                                    <div class="item-text">

                                                        <strong>
                                                            {{ $namaItem }}
                                                        </strong>


                                                        <span>

                                                            {{ $detail->qty ?? 0 }}
                                                            ×
                                                            Rp
                                                            {{ number_format(
                                                                (int) (
                                                                    $detail->harga ?? 0
                                                                ),
                                                                0,
                                                                ',',
                                                                '.'
                                                            ) }}

                                                        </span>

                                                    </div>

                                                </div>

                                            @endif

                                        @empty

                                            <span class="empty-item">
                                                Tidak ada item wahana
                                            </span>

                                        @endforelse


                                        @if($itemsWahana->count() > 3)

                                            <span class="more-items">

                                                +{{ $itemsWahana->count() - 3 }}
                                                item lainnya

                                            </span>

                                        @endif

                                    </div>

                                </td>


                                

                                <td>

                                    <div class="total-info">

                                        <strong>

                                            Rp
                                            {{ number_format(
                                                $totalItem,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </strong>


                                        <span>

                                            {{ $totalQty }}
                                            tiket/item

                                        </span>

                                    </div>

                                </td>


                                

                                <td>

                                    @if(
                                        $pesanan->status ===
                                        'Menunggu Pembayaran'
                                    )

                                        <span class="status-badge waiting">

                                            <span class="status-dot"></span>

                                            Menunggu Pembayaran

                                        </span>


                                    @elseif(
                                        $pesanan->status ===
                                        'Menunggu Pengambilan'
                                    )

                                        <span class="status-badge waiting">

                                            <span class="status-dot"></span>

                                            Menunggu Pengambilan

                                        </span>


                                    @elseif(
                                        $pesanan->status ===
                                        'Selesai'
                                    )

                                        <span class="status-badge completed">

                                            <span class="status-dot"></span>

                                            Selesai

                                        </span>


                                    @else

                                        <span class="status-badge other">

                                            <span class="status-dot"></span>

                                            {{ $pesanan->status }}

                                        </span>

                                    @endif

                                </td>


                                

                                <td>

                                    @if($bundlingWahanaDetails->isNotEmpty())

                                        <button
                                            type="button"
                                            class="btn-detail"
                                            onclick="openWahanaBundlingModal({{ $pesanan->id_pesanan }})"
                                        >

                                            <span>
                                                Detail Wahana
                                            </span>

                                            <i class="fas fa-ticket"></i>

                                        </button>

                                    @else

                                        <button
                                            type="button"
                                            class="btn-detail"
                                            onclick="openWahanaNormalModal({{ $pesanan->id_pesanan }})"
                                        >

                                            <span>
                                                Detail
                                            </span>

                                            <i class="fas fa-arrow-right"></i>

                                        </button>

                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="empty-state"
                                >

                                    <div class="empty-icon">

                                        <i class="fas fa-ticket-slash"></i>

                                    </div>


                                    <h3>
                                        Tidak Ada Pesanan
                                    </h3>


                                    <p>

                                        @if($searchAktif)

                                            Tidak ditemukan pesanan yang
                                            sesuai dengan pencarian
                                            "{{ $searchAktif }}".

                                        @else

                                            Belum ada pesanan wahana
                                            dengan status tersebut.

                                        @endif

                                    </p>


                                    @if($searchAktif)

                                        <a
                                            href="{{ route(
                                                'kasir.wahana.orders',
                                                ['status' => $statusAktif, 'per_page' => $perHalamanAktif]
                                            ) }}"
                                            class="empty-reset"
                                        >

                                            Tampilkan Semua

                                        </a>

                                    @endif

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            

            <div class="mobile-orders">

                @forelse($pesanans as $pesanan)

                    @php

                        $itemsWahanaMobile =
                            $pesanan->detailPesanans
                                ->filter(
                                    function ($detail) {

                                        return
                                            !empty(
                                                $detail->id_tiket_wahana
                                            )
                                            ||
                                            !empty(
                                                $detail->id_paket_bundling
                                            );

                                    }
                                );


                        $bundlingWahanaDetailsMobile =
                            $itemsWahanaMobile
                                ->filter(
                                    function ($detail) {

                                        return
                                            !empty(
                                                $detail->id_paket_bundling
                                            )
                                            &&
                                            $detail->paketBundling
                                            &&
                                            $detail->paketBundling->wahanas
                                            &&
                                            $detail->paketBundling->wahanas->isNotEmpty();

                                    }
                                )
                                ->values();


                        $totalQtyMobile =
                            $itemsWahanaMobile->sum(
                                fn ($detail) =>
                                    (int) (
                                        $detail->qty ?? 0
                                    )
                            );


                        $totalItemMobile =
                            $itemsWahanaMobile->sum(
                                fn ($detail) =>
                                    (int) (
                                        $detail->subtotal ?? 0
                                    )
                            );

                    @endphp


                    <article class="mobile-order-card">


                        

                        <div class="mobile-order-top">

                            <div class="mobile-order-code">

                                <div class="mobile-ticket-icon">

                                    <i class="fas fa-ticket"></i>

                                </div>


                                <div>

                                    <strong>
                                        {{ $pesanan->kode_pesanan }}
                                    </strong>


                                    <span>

                                        {{ optional(
                                            $pesanan->created_at
                                        )->format('d M Y, H:i') }}

                                    </span>

                                </div>

                            </div>


                            @if(
                                $pesanan->status ===
                                'Menunggu Pembayaran'
                            )

                                <span class="status-badge waiting">

                                    <span class="status-dot"></span>

                                    Menunggu Pembayaran

                                </span>


                            @elseif(
                                $pesanan->status ===
                                'Menunggu Pengambilan'
                            )

                                <span class="status-badge waiting">

                                    <span class="status-dot"></span>

                                    Menunggu Pengambilan

                                </span>


                            @elseif(
                                $pesanan->status ===
                                'Selesai'
                            )

                                <span class="status-badge completed">

                                    <span class="status-dot"></span>

                                    Selesai

                                </span>


                            @else

                                <span class="status-badge other">

                                    <span class="status-dot"></span>

                                    {{ $pesanan->status }}

                                </span>

                            @endif

                        </div>


                        <div class="mobile-divider"></div>


                        

                        <div class="mobile-customer">

                            <span class="mobile-label">
                                PELANGGAN
                            </span>


                            <strong>
                                {{ $pesanan->nama_pelanggan }}
                            </strong>


                            @if($pesanan->no_wa)

                                <span class="mobile-phone">

                                    <i class="fab fa-whatsapp"></i>

                                    {{ $pesanan->no_wa }}

                                </span>

                            @endif

                        </div>

                        <div class="mobile-payment-method">
                            <span class="mobile-label">METODE PEMBAYARAN</span>
                            <div class="payment-method-cell">
                                @php
                                    $metodeBayarMobile = strtoupper(trim((string) ($pesanan->metode_pembayaran ?? '')));
                                @endphp
                                <span class="payment-method-icon {{ $metodeBayarMobile === 'QRIS' ? 'qris' : 'cash' }}">
                                    <i class="fas {{ $metodeBayarMobile === 'QRIS' ? 'fa-qrcode' : 'fa-money-bill-wave' }}"></i>
                                </span>
                                <div>
                                    <strong>{{ $metodeBayarMobile !== '' ? $metodeBayarMobile : 'Belum dipilih' }}</strong>
                                    <span>{{ $metodeBayarMobile === 'QRIS' ? 'Pembayaran QRIS' : (in_array($metodeBayarMobile, ['CASH', 'TUNAI'], true) ? 'Bayar di kasir' : 'Metode pembayaran') }}</span>
                                </div>
                            </div>
                        </div>

                        

                        <div class="mobile-items">

                            <span class="mobile-label">
                                ITEM WAHANA
                            </span>


                            @forelse(
                                $itemsWahanaMobile
                                as $mobileItemIndex => $detail
                            )

                                <div class="mobile-item {{ $mobileItemIndex >= 3 ? 'mobile-item-extra' : '' }}" @if($mobileItemIndex >= 3) hidden @endif>

                                    <span>

                                        @if($detail->id_tiket_wahana)

                                            {{ $detail->tiketWahana?->nama_wahana
                                                ?? 'Tiket Wahana' }}

                                        @elseif(
                                            $detail->id_paket_bundling
                                        )

                                            {{ $detail->paketBundling?->nama_paket
                                                ?? $detail->paketBundling?->nama_bundling
                                                ?? 'Paket Bundling' }}

                                        @endif

                                    </span>


                                    <strong>

                                        ×
                                        {{ $detail->qty ?? 0 }}

                                    </strong>

                                </div>

                            @empty

                                <span class="muted">
                                    Tidak ada item.
                                </span>

                            @endforelse

                            @if($itemsWahanaMobile->count() > 3)
                                <button type="button" class="mobile-more-items" aria-expanded="false" onclick="const list=this.parentElement; const hidden=list.querySelectorAll('.mobile-item-extra'); const expanded=this.getAttribute('aria-expanded')==='true'; hidden.forEach(item=>item.hidden=expanded); this.setAttribute('aria-expanded', String(!expanded)); this.innerHTML=expanded ? '<i class=&quot;fas fa-ellipsis&quot;></i> Lihat ' + ({{ $itemsWahanaMobile->count() }} - 3) + ' item lainnya' : '<i class=&quot;fas fa-chevron-up&quot;></i> Sembunyikan item';">
                                    <i class="fas fa-ellipsis"></i> Lihat {{ $itemsWahanaMobile->count() - 3 }} item lainnya
                                </button>
                            @endif

                        </div>


                        

                        <div class="mobile-total">

                            <div>

                                <span>
                                    TOTAL
                                </span>


                                <strong>

                                    Rp
                                    {{ number_format(
                                        $totalItemMobile,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </strong>

                            </div>


                            <span>

                                {{ $totalQtyMobile }}
                                item

                            </span>

                        </div>


                        

                        @if($bundlingWahanaDetailsMobile->isNotEmpty())

                            <button
                                type="button"
                                class="mobile-detail-button"
                                onclick="openWahanaBundlingModal({{ $pesanan->id_pesanan }})"
                            >

                                <span>
                                    Detail Wahana
                                </span>

                                <i class="fas fa-ticket"></i>

                            </button>

                        @else

                            <button
                                type="button"
                                class="mobile-detail-button"
                                onclick="openWahanaNormalModal({{ $pesanan->id_pesanan }})"
                            >

                                <span>
                                    Lihat Detail Pesanan
                                </span>

                                <i class="fas fa-arrow-right"></i>

                            </button>

                        @endif

                    </article>


                @empty

                    <div class="mobile-empty">

                        <i class="fas fa-ticket-slash"></i>


                        <strong>
                            Tidak Ada Pesanan
                        </strong>


                        <span>
                            Belum ada pesanan yang tersedia.
                        </span>

                    </div>

                @endforelse

            </div>


            

            @if($pesanans->hasPages())

                <div class="pagination-wrapper">


                    <div class="pagination-info">

                        Menampilkan

                        <strong>
                            {{ $pesanans->firstItem() ?? 0 }}
                        </strong>

                        –

                        <strong>
                            {{ $pesanans->lastItem() ?? 0 }}
                        </strong>

                        dari

                        <strong>
                            {{ $pesanans->total() }}
                        </strong>

                    </div>


                    <div class="pagination-buttons">


                        

                        @if($pesanans->onFirstPage())

                            <span class="pagination-button disabled">

                                <i class="fas fa-chevron-left"></i>

                            </span>

                        @else

                            <a
                                href="{{ $pesanans
                                    ->appends(request()->query())
                                    ->previousPageUrl() }}"
                                class="pagination-button"
                            >

                                <i class="fas fa-chevron-left"></i>

                            </a>

                        @endif


                        

                        @foreach(
                            $pesanans->getUrlRange(
                                max(
                                    1,
                                    $pesanans->currentPage() - 2
                                ),
                                min(
                                    $pesanans->lastPage(),
                                    $pesanans->currentPage() + 2
                                )
                            )
                            as $page => $url
                        )

                            @if(
                                $page ==
                                $pesanans->currentPage()
                            )

                                <span
                                    class="pagination-button active"
                                >

                                    {{ $page }}

                                </span>

                            @else

                                <a
                                    href="{{ $pesanans->appends(request()->except('page'))->url($page) }}"
                                    class="pagination-button"
                                >

                                    {{ $page }}

                                </a>

                            @endif

                        @endforeach


                        

                        @if($pesanans->hasMorePages())

                            <a
                                href="{{ $pesanans
                                    ->appends(request()->query())
                                    ->nextPageUrl() }}"
                                class="pagination-button"
                            >

                                <i class="fas fa-chevron-right"></i>

                            </a>

                        @else

                            <span
                                class="pagination-button disabled"
                            >

                                <i class="fas fa-chevron-right"></i>

                            </span>

                        @endif

                    </div>

                </div>

            @endif

        </section>

    </main>


    

    @foreach($pesanans as $pesanan)

        @php

            $modalBundlingWahanaDetails =
                $pesanan->detailPesanans
                    ->filter(
                        function ($detail) {

                            return
                                !empty(
                                    $detail->id_paket_bundling
                                )
                                &&
                                $detail->paketBundling
                                &&
                                $detail->paketBundling->wahanas
                                &&
                                $detail->paketBundling->wahanas->isNotEmpty();

                        }
                    )
                    ->values();

        @endphp


        @if($modalBundlingWahanaDetails->isNotEmpty())

            @php
                $firstBundlingDetail =
                    $modalBundlingWahanaDetails->first();

                $menuPaymentStatus =
                    $firstBundlingDetail
                        ->status_pembayaran_menu_bundling
                        ?? 'Menunggu';

                $wahanaPaymentStatus =
                    $firstBundlingDetail
                        ->status_pembayaran_wahana_bundling
                        ?? 'Menunggu';

                $wahanaAlreadyPaid =
                    $wahanaPaymentStatus === 'Sudah Dibayar';

                $metodePembayaranWahana =
                    strtoupper(trim((string) ($pesanan->metode_pembayaran ?? '')));

                $qrisTerkonfirmasi =
                    $metodePembayaranWahana === 'QRIS'
                    && in_array($pesanan->status, ['Menunggu Pengambilan', 'Selesai'], true);

                $qrisBelumTerkonfirmasi =
                    $metodePembayaranWahana === 'QRIS'
                    && $pesanan->status === 'Menunggu Pembayaran';

                $pesananTidakBisaDiverifikasi =
                    in_array($pesanan->status, ['Selesai', 'Batal', 'Pembayaran Gagal'], true);
            @endphp


            <div
                class="wahana-modal"
                id="wahanaBundlingModal{{ $pesanan->id_pesanan }}"
                aria-hidden="true"
                onclick="closeWahanaBundlingModal(event, {{ $pesanan->id_pesanan }})"
            >

                <div
                    class="wahana-modal-dialog"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="wahanaModalTitle{{ $pesanan->id_pesanan }}"
                    onclick="event.stopPropagation()"
                >

                    <div class="wahana-modal-header">

                        <div>

                            <span class="wahana-modal-eyebrow">
                                BAGIAN KASIR WAHANA
                            </span>

                            <h3
                                id="wahanaModalTitle{{ $pesanan->id_pesanan }}"
                            >
                                Detail Pesanan Wahana
                            </h3>

                            <p>
                                {{ $pesanan->kode_pesanan }}
                                <span>•</span>
                                {{ $firstBundlingDetail->paketBundling->nama_paket
                                    ?? $firstBundlingDetail->paketBundling->nama_bundling
                                    ?? 'Paket Bundling' }}
                            </p>

                        </div>


                        <button
                            type="button"
                            class="wahana-modal-close"
                            onclick="closeWahanaBundlingModal(
                                null,
                                {{ $pesanan->id_pesanan }}
                            )"
                            aria-label="Tutup"
                        >
                            <i class="fas fa-xmark"></i>
                        </button>

                    </div>


                    <div class="wahana-payment-status-row">

                        <div>
                            <span>
                                PEMBAYARAN BAGIAN WAHANA
                            </span>

                            <strong>
                                {{ $pesanan->metode_pembayaran ?? 'Tidak diketahui' }}
                            </strong>
                        </div>


                        @if($qrisTerkonfirmasi)

                            <span class="wahana-payment-badge paid">
                                <i class="fas fa-circle-check"></i>
                                QRIS Terbayar
                            </span>

                        @elseif($wahanaAlreadyPaid)

                            <span class="wahana-payment-badge paid">
                                <i class="fas fa-circle-check"></i>
                                Sudah Diverifikasi
                            </span>

                        @elseif($qrisBelumTerkonfirmasi)

                            <span class="wahana-payment-badge waiting">
                                <i class="fas fa-clock"></i>
                                Menunggu Pembayaran QRIS
                            </span>

                        @else

                            <span class="wahana-payment-badge waiting">
                                <i class="fas fa-clock"></i>
                                Belum Diverifikasi
                            </span>

                        @endif

                    </div>


                    <div class="wahana-modal-section">

                        <div class="wahana-modal-section-title">

                            <span>
                                ITEM WAHANA
                            </span>

                            <small>
                                Kasir Wahana
                            </small>

                        </div>


                        <div class="wahana-modal-items">

                            @foreach($modalBundlingWahanaDetails as $detail)

                                @php

                                    $qtyBundling =
                                        (int) (
                                            $detail->qty ?? 1
                                        );

                                    $wahanasBundling =
                                        $detail->paketBundling->wahanas;

                                @endphp


                                @foreach($wahanasBundling as $wahana)

                                    @php

                                        $pivotQty =
                                            (int) (
                                                $wahana->pivot->qty
                                                ?? 1
                                            );

                                        $totalQtyWahana =
                                            $pivotQty
                                            * $qtyBundling;

                                        $namaWahana =
                                            $wahana->nama_wahana
                                            ?? $wahana->nama
                                            ?? 'Tiket Wahana';

                                    @endphp


                                    <div class="wahana-modal-item">

                                        <div class="wahana-modal-item-icon">
                                            <i class="fas fa-ticket"></i>
                                        </div>


                                        <div class="wahana-modal-item-info">

                                            <strong>
                                                {{ $namaWahana }}
                                            </strong>

                                            <span>
                                                {{ $totalQtyWahana }}
                                                tiket
                                            </span>

                                        </div>

                                    </div>

                                @endforeach

                            @endforeach

                        </div>

                    </div>


                    <div class="wahana-modal-note">

                        <i class="fas fa-circle-info"></i>

                        <span>
                            Kasir Wahana hanya memverifikasi bagian
                            Wahana. Pembayaran dan status Menu tetap
                            menjadi tanggung jawab Kasir Menu.
                        </span>

                    </div>


                    <div class="wahana-modal-footer">

                        <button
                            type="button"
                            class="wahana-modal-button secondary"
                            onclick="closeWahanaBundlingModal(
                                null,
                                {{ $pesanan->id_pesanan }}
                            )"
                        >
                            Tutup
                        </button>


                        <form
                            action="{{ route(
                                'kasir.wahana.orders.verify',
                                $pesanan->id_pesanan
                            ) }}"
                            method="POST"
                            class="wahana-verify-form"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="confirmation"
                                value="1"
                            >

                            <input
                                type="hidden"
                                name="nama_pelanggan"
                                value="{{ $pesanan->nama_pelanggan }}"
                            >

                            <input
                                type="hidden"
                                name="kode_pesanan"
                                value="{{ $pesanan->kode_pesanan }}"
                            >


                            <button
                                type="submit"
                                class="wahana-modal-button primary"
                                {{ ($wahanaAlreadyPaid || $qrisBelumTerkonfirmasi || $pesananTidakBisaDiverifikasi) ? 'disabled' : '' }}
                            >

                                @if($wahanaAlreadyPaid)

                                    <i class="fas fa-circle-check"></i>
                                    Sudah Diverifikasi

                                @elseif($qrisBelumTerkonfirmasi)

                                    <i class="fas fa-clock"></i>
                                    Menunggu Pembayaran QRIS

                                @elseif($pesananTidakBisaDiverifikasi)

                                    <i class="fas fa-ban"></i>
                                    Tidak Dapat Diverifikasi

                                @else

                                    <i class="fas fa-circle-check"></i>
                                    Verifikasi Wahana

                                @endif

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @endif

    @endforeach


    

    @foreach($pesanans as $pesanan)

        @php
            $modalNormalWahanaDetails =
                $pesanan->detailPesanans
                    ->filter(function ($detail) {
                        return !empty($detail->id_tiket_wahana)
                            && empty($detail->id_paket_bundling);
                    })
                    ->values();

            $metodePembayaranNormal =
                strtoupper(trim((string) ($pesanan->metode_pembayaran ?? '')));

            $qrisBelumTerkonfirmasiNormal =
                $metodePembayaranNormal === 'QRIS'
                && $pesanan->status === 'Menunggu Pembayaran';

            $pesananNormalTidakBisaDiverifikasi =
                in_array($pesanan->status, ['Selesai', 'Batal', 'Pembayaran Gagal'], true);
        @endphp

        @if($modalNormalWahanaDetails->isNotEmpty())

            <div
                class="wahana-modal wahana-normal-modal"
                id="wahanaNormalModal{{ $pesanan->id_pesanan }}"
                aria-hidden="true"
                onclick="closeWahanaNormalModal(event, {{ $pesanan->id_pesanan }})"
            >

                <div
                    class="wahana-modal-dialog"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="wahanaNormalModalTitle{{ $pesanan->id_pesanan }}"
                    onclick="event.stopPropagation()"
                >

                    <div class="wahana-modal-header">

                        <div>

                            <span class="wahana-modal-eyebrow">
                                BAGIAN KASIR WAHANA
                            </span>

                            <h3 id="wahanaNormalModalTitle{{ $pesanan->id_pesanan }}">
                                Detail Pesanan Wahana
                            </h3>

                            <p>
                                {{ $pesanan->kode_pesanan }}
                                <span>•</span>
                                {{ $pesanan->nama_pelanggan }}
                            </p>

                        </div>

                        <button
                            type="button"
                            class="wahana-modal-close"
                            onclick="closeWahanaNormalModal(null, {{ $pesanan->id_pesanan }})"
                            aria-label="Tutup"
                        >
                            <i class="fas fa-xmark"></i>
                        </button>

                    </div>

                    <div class="wahana-payment-status-row">

                        <div>
                            <span>STATUS PESANAN</span>
                            <strong>{{ $pesanan->status }}</strong>
                            <small class="payment-method-label">Metode: {{ $pesanan->metode_pembayaran ?? 'Tidak diketahui' }}</small>
                        </div>

                        @if($pesanan->status === 'Selesai')
                            <span class="wahana-payment-badge paid">
                                <i class="fas fa-circle-check"></i>
                                Selesai
                            </span>
                        @elseif($pesanan->status === 'Menunggu Pembayaran')
                            <span class="wahana-payment-badge waiting">
                                <i class="fas fa-clock"></i>
                                Menunggu Pembayaran
                            </span>
                        @else
                            <span class="wahana-payment-badge waiting">
                                <i class="fas fa-clock"></i>
                                Menunggu Pengambilan
                            </span>
                        @endif

                    </div>

                    <div class="wahana-modal-section">

                        <div class="wahana-modal-section-title">
                            <span>ITEM WAHANA</span>
                            <small>Kasir Wahana</small>
                        </div>

                        <div class="wahana-modal-items">

                            @foreach($modalNormalWahanaDetails as $detail)

                                @php
                                    $namaWahana =
                                        $detail->tiketWahana->nama_wahana
                                        ?? 'Tiket Wahana';

                                    $qty = (int) ($detail->qty ?? 0);
                                    $harga = (int) ($detail->harga ?? 0);
                                    $subtotal = (int) ($detail->subtotal ?? ($harga * $qty));
                                @endphp

                                <div class="wahana-modal-item">

                                    <div class="wahana-modal-item-icon">
                                        <i class="fas fa-ticket"></i>
                                    </div>

                                    <div class="wahana-modal-item-info">
                                        <strong>{{ $namaWahana }}</strong>
                                        <span>
                                            {{ $qty }} tiket
                                            · Rp {{ number_format($harga, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div style="margin-left:auto; text-align:right;">
                                        <strong style="color:var(--gold-light); font-size:12px;">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </strong>
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                    <div class="wahana-modal-note">
                        <i class="fas fa-circle-info"></i>
                        <span>
                            Kasir Wahana hanya memverifikasi tiket Wahana pada pesanan ini.
                        </span>
                    </div>

                    <div class="wahana-modal-footer">

                        <button
                            type="button"
                            class="wahana-modal-button secondary"
                            onclick="closeWahanaNormalModal(null, {{ $pesanan->id_pesanan }})"
                        >
                            Tutup
                        </button>

                        <form
                            action="{{ route('kasir.wahana.orders.verify', $pesanan->id_pesanan) }}"
                            method="POST"
                            class="wahana-verify-form"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="confirmation"
                                value="1"
                            >

                            <input
                                type="hidden"
                                name="nama_pelanggan"
                                value="{{ $pesanan->nama_pelanggan }}"
                            >

                            <input
                                type="hidden"
                                name="kode_pesanan"
                                value="{{ $pesanan->kode_pesanan }}"
                            >

                            <button
                                type="submit"
                                class="wahana-modal-button primary"
                                {{ ($pesananNormalTidakBisaDiverifikasi || $qrisBelumTerkonfirmasiNormal) ? 'disabled' : '' }}
                            >
                                @if($pesanan->status === 'Selesai')
                                    <i class="fas fa-circle-check"></i>
                                    Sudah Selesai
                                @elseif($qrisBelumTerkonfirmasiNormal)
                                    <i class="fas fa-clock"></i>
                                    Menunggu Pembayaran QRIS
                                @elseif($pesananNormalTidakBisaDiverifikasi)
                                    <i class="fas fa-ban"></i>
                                    Tidak Dapat Diverifikasi
                                @else
                                    <i class="fas fa-circle-check"></i>
                                    Verifikasi Wahana
                                @endif
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @endif

    @endforeach


    

    <style>

        :root {

            --gold: #e2c997;
            --gold-dark: #b99a5c;
            --gold-light: #f3dfad;

            --bg-primary: #0c0c0c;
            --bg-secondary: #111111;

            --text-primary: #f5f5f5;
            --text-secondary: #c6c6c6;
            --text-muted: #888;

            --border: rgba(226, 201, 151, .13);
            --border-soft: rgba(255,255,255,.08);

            --green: #66d19e;
            --green-soft: rgba(102,209,158,.10);

            --orange: #f1b65d;
            --orange-soft: rgba(241,182,93,.10);

            --red: #ff7777;

            --transition: .25s ease;

        }


        * {
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {

            margin: 0;

            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 80% 5%,
                    rgba(226,201,151,.055),
                    transparent 32%
                ),
                var(--bg-primary);

            color: var(--text-primary);

            font-family: 'Inter', sans-serif;

            overflow-x: hidden;

        }


        button,
        input,
        select {
            font-family: inherit;
        }


        a {
            color: inherit;
        }


        

        .kasir-main {

            margin-left: 280px;

            min-height: 100vh;

            padding: 52px 55px 70px;

        }


        

        .mobile-topbar {
            display: none;
        }


        

        .page-header {

            display: flex;

            align-items: flex-end;

            justify-content: space-between;

            gap: 30px;

            margin-bottom: 38px;

        }


        .page-header-content {
            max-width: 750px;
        }


        .page-eyebrow {

            display: block;

            margin-bottom: 9px;

            color: var(--gold-dark);

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 3px;

            text-transform: uppercase;

        }


        .page-title {

            margin: 0 0 12px;

            font-family: 'Playfair Display', serif;

            font-size: 46px;

            line-height: 1.08;

            letter-spacing: -.5px;

        }


        .page-description {

            margin: 0;

            max-width: 650px;

            color: var(--text-muted);

            font-size: 14px;

            line-height: 1.7;

        }


        

        .header-stat {

            display: flex;

            align-items: center;

            gap: 13px;

            min-width: 190px;

            padding: 15px 18px;

            border: 1px solid var(--border);

            border-radius: 16px;

            background: rgba(255,255,255,.025);

            backdrop-filter: blur(12px);

        }


        .header-stat-icon {

            width: 42px;

            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 12px;

            background: rgba(226,201,151,.08);

            color: var(--gold);

        }


        .header-stat-content {

            display: flex;

            flex-direction: column;

            gap: 2px;

        }


        .header-stat-content span {

            color: var(--text-muted);

            font-size: 9px;

            font-weight: 700;

            letter-spacing: 1px;

        }


        .header-stat-content strong {
            font-size: 20px;
        }


        

        .alert-box {

            display: flex;

            align-items: center;

            gap: 14px;

            margin-bottom: 24px;

            padding: 16px 18px;

            border-radius: 15px;

            border: 1px solid var(--border-soft);

            background: rgba(255,255,255,.025);

        }


        .alert-icon {

            width: 38px;

            height: 38px;

            flex: 0 0 38px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 11px;

        }


        .alert-success {
            border-left: 3px solid var(--green);
        }


        .alert-success .alert-icon {

            background: var(--green-soft);

            color: var(--green);

        }


        .alert-error {
            border-left: 3px solid var(--red);
        }


        .alert-error .alert-icon {

            background: rgba(255,119,119,.10);

            color: var(--red);

        }


        .alert-content {

            display: flex;

            flex-direction: column;

            gap: 3px;

            flex: 1;

        }


        .alert-content strong {

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: .8px;

        }


        .alert-content span {

            color: var(--text-muted);

            font-size: 13px;

        }


        .alert-close {

            width: 32px;

            height: 32px;

            border: 0;

            background: transparent;

            color: var(--text-muted);

            cursor: pointer;

            border-radius: 8px;

        }


        .alert-close:hover {

            background: rgba(255,255,255,.05);

            color: var(--text-primary);

        }


        

        .filter-card {

            margin-bottom: 25px;

            padding: 15px;

            border: 1px solid var(--border);

            border-radius: 18px;

            background: rgba(18,18,18,.55);

            box-shadow: 0 15px 45px rgba(0,0,0,.12);

        }


        .filter-form {

            display: grid;

            grid-template-columns:
                minmax(250px, 1fr)
                minmax(210px, 240px)
                minmax(135px, 160px);

            gap: 10px;

        }


        .per-page-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 52px;
            padding: 0 14px;
            border: 1px solid var(--border-soft);
            border-radius: 12px;
            background: rgba(255,255,255,.025);
            color: var(--text-secondary);
            font-size: 12px;
            white-space: nowrap;
        }

        .per-page-wrapper label {
            color: var(--text-muted);
            font-weight: 600;
        }

        .per-page-wrapper select {
            min-width: 85px;
            max-width: 100%;
            height: 40px;
            padding: 0 8px;
            border: 1px solid var(--border);
            border-radius: 9px;
            outline: none;
            background: #181818;
            color: var(--text-primary);
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        .per-page-wrapper select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(226,201,151,.08);
        }

        .search-wrapper,
        .status-wrapper {

            position: relative;

            height: 52px;

        }


        .search-wrapper > i,
        .status-wrapper > i {

            position: absolute;

            left: 18px;

            top: 50%;

            transform: translateY(-50%);

            color: var(--gold-dark);

            pointer-events: none;

            z-index: 2;

            font-size: 13px;

        }


        .search-wrapper input,
        .status-wrapper select {

            width: 100%;

            height: 52px;

            padding: 0 45px;

            border: 1px solid var(--border-soft);

            border-radius: 12px;

            outline: none;

            background: rgba(255,255,255,.025);

            color: var(--text-primary);

            font-size: 13px;

            transition: var(--transition);

        }


        .status-wrapper select {

            appearance: none;

            cursor: pointer;

        }


        .status-wrapper::after {

            content: '\f078';

            position: absolute;

            right: 17px;

            top: 50%;

            transform: translateY(-50%);

            font-family:
                'Font Awesome 6 Free';

            font-weight: 900;

            color: var(--gold-dark);

            pointer-events: none;

            font-size: 10px;

        }


        .search-wrapper input:focus,
        .status-wrapper select:focus {

            border-color:
                rgba(226,201,151,.45);

            box-shadow:
                0 0 0 3px
                rgba(226,201,151,.06);

        }


        .search-wrapper input::placeholder {
            color: #666;
        }


        .status-wrapper select option {

            background: #181818;

            color: white;

        }


        .clear-search {

            position: absolute;

            right: 12px;

            top: 50%;

            transform: translateY(-50%);

            width: 28px;

            height: 28px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 8px;

            color: var(--text-muted);

            text-decoration: none;

        }


        .clear-search:hover {

            background:
                rgba(255,255,255,.05);

            color:
                var(--text-primary);

        }


        .btn-filter,
        .btn-reset {

            height: 52px;

            padding: 0 20px;

            border-radius: 12px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            font-size: 12px;

            font-weight: 700;

            cursor: pointer;

            text-decoration: none;

            transition: var(--transition);

        }


        .btn-filter {

            border:
                1px solid var(--gold);

            background:
                var(--gold);

            color: #111;

        }


        .btn-filter:hover {

            background:
                var(--gold-light);

            transform:
                translateY(-1px);

            box-shadow:
                0 8px 25px
                rgba(226,201,151,.16);

        }


        .btn-reset {

            border:
                1px solid var(--border-soft);

            background:
                rgba(255,255,255,.025);

            color:
                var(--text-secondary);

        }


        .btn-reset:hover {

            border-color:
                var(--gold);

            color:
                var(--gold);

        }


        

        .orders-card {

            overflow: hidden;

            border:
                1px solid var(--border);

            border-radius: 22px;

            background:
                rgba(17,17,17,.65);

            box-shadow:
                0 25px 70px
                rgba(0,0,0,.16);

        }


        .orders-card-header {

            min-height: 88px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 22px 25px;

            border-bottom:
                1px solid var(--border-soft);

        }


        .section-label {

            display: block;

            margin-bottom: 5px;

            color:
                var(--gold-dark);

            font-size: 9px;

            font-weight: 800;

            letter-spacing: 2px;

        }


        .orders-card-header h2 {

            margin: 0;

            font-family:
                'Playfair Display', serif;

            font-size: 24px;

            font-weight: 600;

        }


        .result-info {

            display: flex;

            align-items: center;

            gap: 8px;

            color:
                var(--text-muted);

            font-size: 11px;

        }


        .result-info i {
            color: var(--gold-dark);
        }


        .result-info strong {
            color: var(--text-secondary);
        }


        

        .table-container {

            width: 100%;

            overflow-x: auto;

        }


        .orders-table {

            width: 100%;

            min-width: 1080px;

            border-collapse: collapse;

        }


        .orders-table th {

            padding: 15px 18px;

            border-bottom:
                1px solid var(--border-soft);

            color: #777;

            background:
                rgba(255,255,255,.012);

            font-size: 9px;

            font-weight: 800;

            letter-spacing: 1.3px;

            text-align: left;

            text-transform: uppercase;

            white-space: nowrap;

        }


        .orders-table td {

            padding: 19px 18px;

            border-bottom:
                1px solid
                rgba(255,255,255,.045);

            vertical-align: middle;

        }


        .orders-table tbody tr {

            transition:
                background var(--transition);

        }


        .orders-table tbody tr:hover {

            background:
                rgba(226,201,151,.025);

        }


        .orders-table tbody tr:last-child td {
            border-bottom: 0;
        }


        

        .row-number {

            color: #666;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: 1px;

        }


        

        .order-identity {

            display: flex;

            align-items: center;

            gap: 11px;

        }


        .order-icon {

            width: 40px;

            height: 40px;

            flex: 0 0 40px;

            display: flex;

            align-items: center;

            justify-content: center;

            border:
                1px solid var(--border);

            border-radius: 11px;

            background:
                rgba(226,201,151,.055);

            color:
                var(--gold);

        }


        .order-info {

            display: flex;

            flex-direction: column;

            gap: 5px;

        }


        .order-code {

            color:
                var(--text-primary);

            font-size: 12px;

            letter-spacing: .5px;

        }


        .order-info span {

            color: #666;

            font-size: 10px;

        }


        .order-info span i {
            margin-right: 4px;
        }


        

        .customer-info {

            display: flex;

            flex-direction: column;

            gap: 5px;

            min-width: 145px;

        }


        .customer-info strong {

            max-width: 190px;

            overflow: hidden;

            color:
                var(--text-primary);

            font-size: 12px;

            text-overflow: ellipsis;

            white-space: nowrap;

        }


        .customer-info span {

            color: #777;

            font-size: 10px;

        }


        .customer-info span i {

            margin-right: 4px;

            color: #66c995;

        }


        .customer-info .muted {
            color: #555;
        }


        

        .items-list {

            display: flex;

            flex-direction: column;

            gap: 8px;

            min-width: 205px;

            max-width: 270px;

        }


        .item-row {

            display: flex;

            align-items: center;

            gap: 8px;

        }


        .item-mini-icon {

            width: 27px;

            height: 27px;

            flex: 0 0 27px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 8px;

            background:
                rgba(226,201,151,.06);

            color:
                var(--gold-dark);

            font-size: 10px;

        }


        .item-text {

            display: flex;

            flex-direction: column;

            gap: 2px;

            min-width: 0;

        }


        .item-text strong {

            overflow: hidden;

            color:
                var(--text-secondary);

            font-size: 11px;

            font-weight: 600;

            text-overflow: ellipsis;

            white-space: nowrap;

        }


        .item-text span {

            color: #666;

            font-size: 9px;

        }


        .more-items {

            padding-left: 35px;

            color:
                var(--gold-dark);

            font-size: 9px;

        }


        .empty-item {

            color: #555;

            font-size: 10px;

        }


        

        .total-info {

            display: flex;

            flex-direction: column;

            gap: 5px;

            white-space: nowrap;

        }


        .total-info strong {

            color:
                var(--gold-light);

            font-size: 13px;

        }


        .total-info span {

            color: #666;

            font-size: 9px;

        }


        

        .status-badge {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            padding: 7px 10px;

            border-radius: 30px;

            font-size: 9px;

            font-weight: 700;

            white-space: nowrap;

        }


        .status-dot {

            width: 6px;

            height: 6px;

            border-radius: 50%;

        }


        .status-badge.waiting {

            background:
                var(--orange-soft);

            color:
                var(--orange);

            border:
                1px solid
                rgba(241,182,93,.13);

        }


        .status-badge.waiting .status-dot {
            background:
                var(--orange);
        }


        .status-badge.completed {

            background:
                var(--green-soft);

            color:
                var(--green);

            border:
                1px solid
                rgba(102,209,158,.13);

        }


        .status-badge.completed .status-dot {
            background:
                var(--green);
        }


        .status-badge.other {

            background:
                rgba(255,255,255,.05);

            color:
                #aaa;

        }


        .status-badge.other .status-dot {
            background: #aaa;
        }


        

        .btn-detail {

            min-width: 92px;

            height: 38px;

            padding: 0 12px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            border:
                1px solid var(--border);

            border-radius: 10px;

            background:
                rgba(226,201,151,.035);

            color:
                var(--text-secondary);

            font-size: 10px;

            font-weight: 700;

            text-decoration: none;

            transition:
                var(--transition);

        }


        .btn-detail i {

            color:
                var(--gold-dark);

            transition:
                transform var(--transition);

        }


        .btn-detail:hover {

            border-color:
                var(--gold);

            background:
                rgba(226,201,151,.07);

            color:
                var(--gold-light);

        }


        .btn-detail:hover i {
            transform:
                translateX(3px);
        }


        

        .empty-state {

            padding: 85px 30px !important;

            text-align: center;

        }


        .empty-icon {

            width: 70px;

            height: 70px;

            margin:
                0 auto 18px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 22px;

            background:
                rgba(226,201,151,.05);

            color:
                var(--gold-dark);

            font-size: 25px;

        }


        .empty-state h3 {

            margin:
                0 0 7px;

            font-family:
                'Playfair Display', serif;

            font-size: 22px;

        }


        .empty-state p {

            max-width: 430px;

            margin:
                0 auto 18px;

            color: #666;

            font-size: 12px;

            line-height: 1.6;

        }


        .empty-reset {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding: 9px 15px;

            border:
                1px solid var(--border);

            border-radius: 9px;

            color:
                var(--gold);

            font-size: 10px;

            font-weight: 700;

            text-decoration: none;

        }


        

        .mobile-orders {
            display: none;
        }


        .pagination-wrapper {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 18px 23px;

            border-top:
                1px solid var(--border-soft);

        }


        .pagination-info {

            color: #666;

            font-size: 10px;

        }


        .pagination-info strong {
            color:
                var(--text-secondary);
        }


        .pagination-buttons {

            display: flex;

            align-items: center;

            gap: 5px;

        }


        .pagination-button {

            min-width: 32px;

            height: 32px;

            padding: 0 8px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            border:
                1px solid var(--border-soft);

            border-radius: 8px;

            background:
                rgba(255,255,255,.02);

            color:
                var(--text-muted);

            font-size: 10px;

            font-weight: 700;

            text-decoration: none;

            transition:
                var(--transition);

        }


        .pagination-button:hover {

            border-color:
                var(--gold);

            color:
                var(--gold);

        }


        .pagination-button.active {

            border-color:
                var(--gold);

            background:
                var(--gold);

            color:
                #111;

        }


        .pagination-button.disabled {

            opacity: .3;

            cursor: not-allowed;

        }


        

        @media (max-width: 1300px) {

            .kasir-main {

                margin-left: 260px;

                padding-left: 38px;

                padding-right: 38px;

            }


            .filter-form {

                grid-template-columns:
                    1fr
                    210px
                    auto;

            }


            .btn-reset {

                grid-column: 3;

            }

        }


        

        @media (max-width: 1100px) {

            .page-header {

                align-items:
                    flex-start;

                flex-direction:
                    column;

            }


            .header-stat {
                width: 100%;
            }


            .filter-form {

                grid-template-columns:
                    1fr 1fr;

            }


            .btn-filter,
            .btn-reset {

                width: 100%;

            }

        }


        

        @media (max-width: 991px) {

            .kasir-main {

                margin-left: 0;

                padding:
                    95px 24px 45px;

            }


            .mobile-topbar {

                position: fixed;

                top: 0;

                left: 0;

                right: 0;

                z-index: 900;

                height: 68px;

                display: flex;

                align-items: center;

                gap: 13px;

                padding: 0 18px;

                border-bottom:
                    1px solid var(--border-soft);

                background:
                    rgba(12,12,12,.92);

                backdrop-filter:
                    blur(16px);

            }


            .mobile-menu-button {

                width: 40px;

                height: 40px;

                border:
                    1px solid var(--border-soft);

                border-radius: 10px;

                background:
                    rgba(255,255,255,.025);

                color:
                    var(--text-primary);

                cursor: pointer;

            }


            .mobile-brand {

                display: flex;

                flex-direction: column;

                gap: 1px;

            }


            .mobile-brand strong {

                font-size: 11px;

                letter-spacing: 1px;

            }


            .mobile-brand span {

                color:
                    var(--gold-dark);

                font-size: 8px;

                font-weight: 700;

                letter-spacing: 1.5px;

            }


            .page-title {
                font-size: 39px;
            }


            .table-container {
                display: none;
            }


            .mobile-orders {

                display: flex;

                flex-direction: column;

                gap: 12px;

                padding: 15px;

            }


            .mobile-order-card {

                padding: 17px;

                border:
                    1px solid var(--border-soft);

                border-radius: 16px;

                background:
                    rgba(255,255,255,.018);

            }


            .mobile-order-top {

                display: flex;

                align-items: center;

                justify-content: space-between;

                gap: 12px;

            }


            .mobile-order-code {

                display: flex;

                align-items: center;

                gap: 10px;

                min-width: 0;

            }


            .mobile-ticket-icon {

                width: 38px;

                height: 38px;

                flex: 0 0 38px;

                display: flex;

                align-items: center;

                justify-content: center;

                border-radius: 11px;

                background:
                    rgba(226,201,151,.07);

                color:
                    var(--gold);

            }


            .mobile-order-code > div:last-child {

                display: flex;

                flex-direction: column;

                gap: 3px;

                min-width: 0;

            }


            .mobile-order-code strong {

                overflow: hidden;

                text-overflow: ellipsis;

                white-space: nowrap;

                font-size: 11px;

            }


            .mobile-order-code span {

                color: #666;

                font-size: 9px;

            }


            .mobile-divider {

                height: 1px;

                margin: 14px 0;

                background:
                    var(--border-soft);

            }


            .mobile-label {

                display: block;

                margin-bottom: 6px;

                color: #666;

                font-size: 8px;

                font-weight: 800;

                letter-spacing: 1.5px;

            }


            .mobile-customer {

                display: flex;

                flex-direction: column;

                margin-bottom: 17px;

            }


            .mobile-customer > strong {
                font-size: 13px;
            }


            .mobile-phone {

                margin-top: 4px;

                color: #66c995;

                font-size: 9px;

            }


            .mobile-items {
                margin-bottom: 17px;
            }


            .mobile-item {

                display: flex;

                align-items: center;

                justify-content: space-between;

                gap: 15px;

                padding: 8px 0;

                border-bottom:
                    1px solid
                    rgba(255,255,255,.04);

                color:
                    var(--text-secondary);

                font-size: 10px;

            }


            .mobile-item:last-child {
                border-bottom: 0;
            }


            .mobile-item strong {

                color:
                    var(--gold-dark);

                white-space: nowrap;

            }


            .mobile-total {

                display: flex;

                align-items: flex-end;

                justify-content: space-between;

                gap: 10px;

                padding-top: 13px;

                border-top:
                    1px solid var(--border-soft);

            }


            .mobile-total > div {

                display: flex;

                flex-direction: column;

                gap: 3px;

            }


            .mobile-total > div span {

                color: #666;

                font-size: 8px;

                font-weight: 800;

                letter-spacing: 1px;

            }


            .mobile-total strong {

                color:
                    var(--gold-light);

                font-size: 17px;

            }


            .mobile-total > span {

                color: #666;

                font-size: 9px;

            }


            .mobile-detail-button {

                height: 42px;

                margin-top: 16px;

                display: flex;

                align-items: center;

                justify-content: center;

                gap: 9px;

                border:
                    1px solid var(--border);

                border-radius: 10px;

                background:
                    rgba(226,201,151,.045);

                color:
                    var(--text-secondary);

                font-size: 10px;

                font-weight: 700;

                text-decoration: none;

            }


            .mobile-detail-button i {
                color:
                    var(--gold-dark);
            }


            .mobile-empty {

                display: flex;

                flex-direction: column;

                align-items: center;

                gap: 7px;

                padding: 55px 20px;

                color: #666;

                text-align: center;

            }


            .mobile-empty i {

                margin-bottom: 7px;

                color:
                    var(--gold-dark);

                font-size: 30px;

            }


            .mobile-empty strong {

                color:
                    var(--text-primary);

                font-size: 15px;

            }


            .mobile-empty span {
                font-size: 10px;
            }

        }


        

        @media (min-width: 651px) and (max-width: 1050px) {
            .filter-form {
                grid-template-columns: minmax(0, 1fr) minmax(190px, 230px);
            }

            .search-wrapper {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 650px) {

            .kasir-main {

                padding:
                    90px 15px 35px;

            }


            .page-header {
                margin-bottom: 27px;
            }


            .page-title {
                font-size: 32px;
            }


            .page-description {
                font-size: 12px;
            }


            .filter-card {
                padding: 10px;
            }


            .filter-form {

                grid-template-columns: 1fr;

            }

            .per-page-wrapper {
                justify-content: space-between;
            }


            .btn-filter,
            .btn-reset {

                grid-column: auto;

            }


            .orders-card {
                border-radius: 17px;
            }


            .orders-card-header {

                align-items:
                    flex-start;

                flex-direction:
                    column;

                padding: 18px;

            }


            .orders-card-header h2 {
                font-size: 20px;
            }


            .result-info {
                font-size: 9px;
            }


            .pagination-wrapper {

                align-items:
                    flex-start;

                flex-direction:
                    column;

                padding: 16px;

            }


            .pagination-buttons {
                width: 100%;
            }


            .pagination-button {
                flex: 1;
            }

        }


        .wahana-modal-button:disabled {
            opacity: .5;
            cursor: not-allowed;
            pointer-events: none;
            filter: grayscale(.25);
        }

        .payment-method-label {
            display: block;
            margin-top: 5px;
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
        }

        

        .wahana-modal {
            position: fixed;
            inset: 0;
            z-index: 2000;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 24px;

            background: rgba(0,0,0,.72);
            backdrop-filter: blur(8px);

            opacity: 0;
            visibility: hidden;

            transition:
                opacity .2s ease,
                visibility .2s ease;
        }


        .wahana-modal.open {
            opacity: 1;
            visibility: visible;
        }


        .wahana-modal-dialog {
            width: min(560px, 100%);
            max-height: min(760px, calc(100vh - 48px));

            overflow-y: auto;

            border:
                1px solid
                rgba(226,201,151,.18);

            border-radius: 20px;

            background: #111;

            box-shadow:
                0 30px 90px
                rgba(0,0,0,.45);

            transform:
                translateY(12px)
                scale(.98);

            transition:
                transform .2s ease;
        }


        .wahana-modal.open .wahana-modal-dialog {
            transform:
                translateY(0)
                scale(1);
        }


        .wahana-modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;

            padding: 23px 23px 18px;

            border-bottom:
                1px solid
                rgba(255,255,255,.07);
        }


        .wahana-modal-eyebrow {
            display: block;

            margin-bottom: 6px;

            color: var(--gold-dark);

            font-size: 8px;
            font-weight: 800;
            letter-spacing: 2px;
        }


        .wahana-modal-header h3 {
            margin: 0 0 6px;

            color: var(--text-primary);

            font-family:
                'Playfair Display',
                serif;

            font-size: 25px;
            font-weight: 600;
        }


        .wahana-modal-header p {
            margin: 0;

            color: #777;

            font-size: 10px;
        }


        .wahana-modal-header p span {
            margin: 0 5px;
            color: #444;
        }


        .wahana-modal-close {
            width: 34px;
            height: 34px;

            flex: 0 0 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            border:
                1px solid
                rgba(255,255,255,.08);

            border-radius: 10px;

            background:
                rgba(255,255,255,.025);

            color: #777;

            cursor: pointer;
        }


        .wahana-modal-close:hover {
            color: var(--text-primary);
            border-color:
                rgba(226,201,151,.3);
        }


        .wahana-payment-status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;

            margin: 17px 20px 0;
            padding: 13px 15px;

            border:
                1px solid
                rgba(226,201,151,.12);

            border-radius: 13px;

            background:
                rgba(226,201,151,.035);
        }


        .wahana-payment-status-row > div {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }


        .wahana-payment-status-row span:first-child {
            color: #777;

            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1px;
        }


        .wahana-payment-status-row strong {
            color: var(--text-primary);

            font-size: 12px;
        }


        .wahana-payment-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 7px 9px;

            border-radius: 30px;

            font-size: 8px;
            font-weight: 800;
        }


        .wahana-payment-badge.paid {
            color: var(--green);
            background: var(--green-soft);
            border:
                1px solid
                rgba(102,209,158,.14);
        }


        .wahana-payment-badge.waiting {
            color: var(--orange);
            background: var(--orange-soft);
            border:
                1px solid
                rgba(241,182,93,.14);
        }


        .wahana-modal-section {
            padding: 20px;
        }


        .wahana-modal-section-title {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 10px;
        }


        .wahana-modal-section-title span {
            color: var(--text-secondary);

            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
        }


        .wahana-modal-section-title small {
            color: var(--gold-dark);

            font-size: 8px;
            font-weight: 700;
        }


        .wahana-modal-items {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }


        .wahana-modal-item {
            display: flex;
            align-items: center;
            gap: 11px;

            padding: 11px;

            border:
                1px solid
                rgba(255,255,255,.06);

            border-radius: 12px;

            background:
                rgba(255,255,255,.018);
        }


        .wahana-modal-item-icon {
            width: 35px;
            height: 35px;

            flex: 0 0 35px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            color: var(--gold);
            background:
                rgba(226,201,151,.065);
        }


        .wahana-modal-item-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }


        .wahana-modal-item-info strong {
            color: var(--text-secondary);

            font-size: 11px;
            font-weight: 600;
        }


        .wahana-modal-item-info span {
            color: #666;

            font-size: 9px;
        }


        .wahana-modal-note {
            display: flex;
            align-items: flex-start;
            gap: 9px;

            margin: 0 20px 20px;
            padding: 11px 12px;

            border:
                1px solid
                rgba(226,201,151,.10);

            border-radius: 11px;

            background:
                rgba(226,201,151,.025);

            color: #777;

            font-size: 9px;
            line-height: 1.6;
        }


        .wahana-modal-note i {
            margin-top: 2px;
            color: var(--gold-dark);
        }


        .wahana-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 8px;

            padding: 15px 20px 20px;

            border-top:
                1px solid
                rgba(255,255,255,.06);
        }


        .wahana-modal-footer form {
            margin: 0;
        }


        .wahana-modal-button {
            min-height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            padding: 0 15px;

            border-radius: 10px;

            font-size: 9px;
            font-weight: 800;

            cursor: pointer;

            transition: var(--transition);
        }


        .wahana-modal-button.secondary {
            border:
                1px solid
                rgba(255,255,255,.08);

            background:
                rgba(255,255,255,.025);

            color: var(--text-secondary);
        }


        .wahana-modal-button.secondary:hover {
            border-color: var(--gold);
            color: var(--gold);
        }


        .wahana-modal-button.primary {
            border:
                1px solid var(--gold);

            background: var(--gold);

            color: #111;
        }


        .wahana-modal-button.primary:hover {
            background: var(--gold-light);

            transform: translateY(-1px);
        }


        .wahana-modal-button.primary:disabled {
            cursor: not-allowed;
            opacity: .55;
            transform: none;
        }


        body.modal-open {
            overflow: hidden;
        }


        @media (max-width: 600px) {

            .wahana-modal {
                align-items: flex-end;
                padding: 0;
            }


            .wahana-modal-dialog {
                width: 100%;
                max-height: 88vh;

                border-radius:
                    20px
                    20px
                    0
                    0;
            }


            .wahana-modal-header {
                padding: 20px 18px 16px;
            }


            .wahana-modal-section {
                padding: 18px;
            }


            .wahana-payment-status-row {
                margin-left: 18px;
                margin-right: 18px;
            }


            .wahana-modal-note {
                margin-left: 18px;
                margin-right: 18px;
            }


            .wahana-modal-footer {
                padding-left: 18px;
                padding-right: 18px;
            }


            .wahana-modal-button {
                flex: 1;
            }

        }


        

        @media (prefers-reduced-motion: reduce) {

            * {

                scroll-behavior:
                    auto !important;

                transition:
                    none !important;

            }

        }


        :root {
            --gold: #e2c997; --gold-dark: #b89a6e; --gold-light: #f8f4ed;
            --bg-primary: #0a0a0a; --bg-secondary: #151515; --bg-card: #121212;
            --text-primary: #f8f4ed; --text-secondary: #d4c9b5; --text-muted: #a89988;
            --border: rgba(226,201,151,.18); --border-soft: rgba(255,255,255,.09);
        }
        body { background:var(--bg-primary); color:var(--text-primary); line-height:1.65; font-size:16px; }
        .kasir-main { padding:clamp(24px,3vw,52px) clamp(18px,3.5vw,55px) 60px; }
        .page-eyebrow { display:none !important; }
        .page-title { font-size:clamp(30px,3vw,46px); line-height:1.2; }
        .page-description { font-size:16px; color:var(--text-secondary); }
        .header-stat-content span,.section-label,.result-info,.mobile-label { font-size:12px; }
        .header-stat-content strong { font-size:24px; }
        .filter-card,.orders-card { border:1px solid var(--border); background:rgba(18,18,18,.92); border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,.28); }
        .filter-card { padding:18px; }
        .filter-form { grid-template-columns:minmax(220px,1fr) minmax(210px,260px) !important; gap:12px; }
        .search-wrapper,.status-wrapper,.search-wrapper input,.status-wrapper select { height:56px; }
        .search-wrapper input,.status-wrapper select { font-size:16px; border-radius:14px; }
        .search-wrapper input { padding-right:48px; }
        .status-wrapper select { padding-right:42px; }
        .btn-filter { display:none !important; }
        .btn-reset { min-height:48px; font-size:14px; }
        .orders-card-header { gap:16px; flex-wrap:wrap; }
        .orders-card-header h2 { font-size:clamp(21px,2vw,28px); }
        .orders-table { min-width:1080px; }
        .orders-table th { font-size:12px; padding:17px 14px; }
        .orders-table td { padding:17px 14px; font-size:14px; }
        .order-code,.customer-info strong,.item-text strong,.total-info strong { font-size:14px; }
        .order-info span,.customer-info span,.item-text span,.total-info span { font-size:12px; }
        .status-badge { font-size:12px; padding:8px 11px; line-height:1.35; }
        .btn-detail,.mobile-detail-button,.wahana-modal-button { min-height:48px; font-size:14px; }
        .payment-method-cell { display:flex; align-items:center; gap:10px; min-width:140px; }
        .payment-method-icon { display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; flex:0 0 42px; border-radius:12px; background:rgba(226,201,151,.12); color:var(--gold); font-size:17px; }
        .payment-method-icon.qris { background:rgba(102,209,158,.12); color:#8fe0b2; }
        .payment-method-icon.cash { background:rgba(226,201,151,.12); color:var(--gold); }
        .payment-method-cell > div { display:flex; flex-direction:column; gap:3px; min-width:0; }
        .payment-method-cell strong { color:var(--text-primary); font-size:14px; }
        .payment-method-cell span:not(.payment-method-icon) { color:var(--text-muted); font-size:12px; }
        .mobile-payment-method { margin:0 0 18px; }
        .mobile-more-items { display:inline-flex; align-items:center; gap:7px; margin-top:9px; padding:9px 12px; color:var(--gold); background:rgba(226,201,151,.08); border:1px solid var(--border); border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; }
        .mobile-item[hidden] { display:none !important; }
        input,select,button,a { -webkit-tap-highlight-color:transparent; }
        button:focus-visible,a:focus-visible,input:focus-visible,select:focus-visible { outline:3px solid var(--gold); outline-offset:3px; }
        .wahana-modal-dialog { width:min(720px, calc(100vw - 32px)); max-height:calc(100dvh - 32px); overflow:auto; }
        .wahana-modal-header h3 { font-size:clamp(21px,2vw,28px); }
        .wahana-modal-section-title span,.wahana-modal-item-info strong { font-size:15px; }
        .wahana-modal-item-info span,.wahana-modal-note span { font-size:14px; line-height:1.6; }
        @media (min-width:1500px) {
            .kasir-main { max-width:1900px; margin-left:252px; padding-left:clamp(40px,3vw,72px); padding-right:clamp(40px,3vw,72px); }
            .orders-table { min-width:0; width:100%; }
        }
        @media (max-width:1300px) and (min-width:992px) {
            .kasir-main { margin-left:252px; padding:36px 28px 50px; }
            .filter-form { grid-template-columns:minmax(0,1fr) minmax(200px,240px) !important; }
            .table-container { overflow-x:auto; }
        }
        @media (max-width:991px) {
            .kasir-main { margin-left:0; padding:92px 24px 40px; }
            .page-header { align-items:flex-start; gap:20px; margin-bottom:28px; }
            .page-title { font-size:clamp(28px,4vw,38px); }
            .filter-form { grid-template-columns:minmax(0,1fr) !important; }
            .header-stat { width:100%; }
            .mobile-topbar { min-height:72px; height:auto; padding:12px 20px; }
            .mobile-brand strong { font-size:17px; }
            .mobile-brand span { font-size:12px; letter-spacing:1px; }
        }
        @media (max-width:600px) {
            .kasir-main { padding:88px 14px 28px; }
            .page-title { font-size:29px; }
            .page-description { font-size:15px; }
            .header-stat { padding:14px; }
            .filter-card { padding:12px; margin-bottom:18px; }
            .search-wrapper,.status-wrapper,.search-wrapper input,.status-wrapper select { height:54px; }
            .search-wrapper input,.status-wrapper select { font-size:15px; }
            .orders-card { border-radius:16px; }
            .orders-card-header { padding:18px 15px; }
            .orders-card-header h2 { font-size:21px; }
            .mobile-order-card { padding:17px; border-radius:16px; }
            .mobile-order-code strong { font-size:15px; }
            .mobile-order-code span,.mobile-phone { font-size:13px; }
            .mobile-label { font-size:12px; letter-spacing:1px; }
            .mobile-customer > strong { font-size:16px; }
            .mobile-item { font-size:14px; gap:10px; }
            .mobile-item strong { font-size:14px; }
            .mobile-total strong { font-size:19px; }
            .mobile-detail-button { width:100%; min-height:52px; font-size:15px; }
            .mobile-more-items { font-size:14px; min-height:44px; }
            .pagination-wrapper { flex-direction:column; align-items:flex-start; gap:14px; padding:16px; }
            .pagination-buttons { flex-wrap:wrap; }
            .wahana-modal-dialog { width:calc(100vw - 20px); max-height:calc(100dvh - 20px); }
            .wahana-modal-header { padding:18px; }
            .wahana-modal-section,.wahana-payment-status-row,.wahana-modal-note { margin-left:16px; margin-right:16px; }
            .wahana-modal-footer { position:sticky; bottom:0; gap:10px; padding:14px; background:var(--bg-card); }
            .wahana-modal-button { flex:1; min-width:0; padding:12px 10px; }
        }
        @media (prefers-reduced-motion:reduce) {
            *,*::before,*::after { scroll-behavior:auto !important; animation-duration:.01ms !important; transition-duration:.01ms !important; }
        }


        @media (min-width: 1200px) {
            .kasir-main { min-width: 0; }
            .orders-card, .orders-card-header, .table-container { width: 100%; min-width: 0; max-width: 100%; }
            .table-container { overflow-x: hidden; }
            .orders-table { width: 100%; min-width: 0 !important; table-layout: fixed; }
            .orders-table th { padding: 14px 10px; font-size: 11px; letter-spacing: .7px; white-space: normal; }
            .orders-table td { padding: 15px 10px; font-size: 13px; overflow-wrap: anywhere; }
            .orders-table th:nth-child(1), .orders-table td:nth-child(1) { width: 4%; }
            .orders-table th:nth-child(2), .orders-table td:nth-child(2) { width: 13%; }
            .orders-table th:nth-child(3), .orders-table td:nth-child(3) { width: 14%; }
            .orders-table th:nth-child(4), .orders-table td:nth-child(4) { width: 13%; }
            .orders-table th:nth-child(5), .orders-table td:nth-child(5) { width: 22%; }
            .orders-table th:nth-child(6), .orders-table td:nth-child(6) { width: 10%; }
            .orders-table th:nth-child(7), .orders-table td:nth-child(7) { width: 15%; }
            .orders-table th:nth-child(8), .orders-table td:nth-child(8) { width: 9%; }
            .order-identity, .customer-info, .payment-method-cell, .items-list, .total-info { min-width: 0; }
            .order-identity { gap: 8px; }
            .order-icon { flex: 0 0 36px; width: 36px; height: 36px; }
            .order-code { overflow-wrap: anywhere; word-break: break-word; }
            .payment-method-cell { gap: 7px; min-width: 0; }
            .payment-method-icon { width: 34px; height: 34px; flex-basis: 34px; font-size: 14px; }
            .payment-method-cell strong, .payment-method-cell span:not(.payment-method-icon) { overflow-wrap: anywhere; }
            .status-badge { white-space: normal; font-size: 11px; padding: 7px 8px; }
            .btn-detail { min-width: 0; width: 100%; padding: 10px 8px; gap: 6px; white-space: normal; }
        }
        @media (min-width: 1200px) and (max-width: 1450px) {
            .kasir-main { padding-left: 24px; padding-right: 24px; }
            .orders-table th, .orders-table td { padding-left: 8px; padding-right: 8px; }
            .orders-table th { font-size: 10px; }
            .orders-table td { font-size: 12px; }
            .order-code, .customer-info strong, .item-text strong, .total-info strong, .payment-method-cell strong { font-size: 12px; }
            .order-info span, .customer-info span, .item-text span, .total-info span, .payment-method-cell span:not(.payment-method-icon) { font-size: 11px; }
            .payment-method-icon { width: 30px; height: 30px; flex-basis: 30px; }
        }
        @media (max-width: 1199px) and (min-width: 992px) {
            .table-container { overflow-x: auto; }
            .orders-table { min-width: 1080px; }
        }

        .filter-form {
            grid-template-columns: minmax(0, 1fr) minmax(220px, 260px) auto !important;
            align-items: stretch;
        }

        .per-page-wrapper {
            min-width: 170px;
            min-height: 56px;
            justify-content: center;
            padding: 0 14px;
            border-radius: 14px;
        }

        .per-page-wrapper select {
            min-width: 88px;
            height: 42px;
            font-size: 14px;
        }

        @media (max-width: 1300px) and (min-width: 992px) {
            .filter-form {
                grid-template-columns: minmax(0, 1fr) minmax(210px, 240px) auto !important;
            }

            .per-page-wrapper {
                min-width: 160px;
                padding: 0 10px;
                gap: 7px;
            }
        }

        @media (max-width: 991px) {
            .filter-form {
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
            }

            .search-wrapper {
                grid-column: 1 / -1;
            }

            .status-wrapper,
            .per-page-wrapper {
                min-width: 0;
                width: 100%;
            }

            .per-page-wrapper {
                justify-content: space-between;
                padding: 0 12px;
            }
        }

        @media (max-width: 480px) {
            .filter-form {
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
                gap: 9px;
            }

            .per-page-wrapper {
                gap: 5px;
                padding: 0 8px;
                font-size: 12px;
            }

            .per-page-wrapper select {
                min-width: 76px;
                padding: 0 4px;
                font-size: 12px;
            }

            .status-wrapper select {
                padding-left: 38px;
                padding-right: 30px;
                font-size: 13px;
            }
        }

    </style>


    

    <script>

        

        function openWahanaNormalModal(id) {

            const modal =
                document.getElementById(
                    'wahanaNormalModal' + id
                );

            if (!modal) {
                return;
            }

            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');

        }


        function closeWahanaNormalModal(event, id) {

            if (
                event &&
                event.target !== event.currentTarget
            ) {
                return;
            }

            const modal =
                document.getElementById(
                    'wahanaNormalModal' + id
                );

            if (!modal) {
                return;
            }

            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');

        }


        

        function openWahanaBundlingModal(id) {

            const modal =
                document.getElementById(
                    'wahanaBundlingModal' + id
                );

            if (!modal) {
                return;
            }

            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');

            document.body.classList.add('modal-open');

        }


        function closeWahanaBundlingModal(event, id) {

            if (
                event &&
                event.target !== event.currentTarget
            ) {
                return;
            }

            const modal =
                document.getElementById(
                    'wahanaBundlingModal' + id
                );

            if (!modal) {
                return;
            }

            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');

            document.body.classList.remove('modal-open');

        }


        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key !== 'Escape') {
                    return;
                }

                const openModal =
                    document.querySelector(
                        '.wahana-modal.open'
                    );

                if (!openModal) {
                    return;
                }

                if (openModal.classList.contains('wahana-normal-modal')) {
                    const id =
                        openModal.id.replace(
                            'wahanaNormalModal',
                            ''
                        );

                    closeWahanaNormalModal(null, id);
                    return;
                }

                const id =
                    openModal.id.replace(
                        'wahanaBundlingModal',
                        ''
                    );

                closeWahanaBundlingModal(
                    null,
                    id
                );

            }
        );


        document.addEventListener(
            'DOMContentLoaded',
            function () {

                

                const verifyForms =
                    document.querySelectorAll(
                        '.wahana-verify-form'
                    );


                verifyForms.forEach(
                    function (form) {

                        form.addEventListener(
                            'submit',
                            function () {

                                const button =
                                    form.querySelector(
                                        'button[type="submit"]'
                                    );

                                if (!button) {
                                    return;
                                }

                                button.disabled = true;

                                button.innerHTML =
                                    '<i class="fas fa-spinner fa-spin"></i> Memproses...';

                            }
                        );

                    }
                );





                

                const alerts =
                    document.querySelectorAll(
                        '.alert-box'
                    );


                alerts.forEach(
                    function (alert) {

                        setTimeout(
                            function () {

                                alert.style.opacity =
                                    '0';

                                alert.style.transform =
                                    'translateY(-6px)';

                                alert.style.transition =
                                    'opacity .3s ease, transform .3s ease';


                                setTimeout(
                                    function () {

                                        alert.remove();

                                    },
                                    300
                                );

                            },
                            5000
                        );

                    }
                );


                

                const searchInput =
                    document.querySelector(
                        '.search-wrapper input'
                    );


                if (searchInput) {

                    searchInput.addEventListener(
                        'keydown',
                        function (event) {

                            if (
                                event.key ===
                                'Enter'
                            ) {

                                event.preventDefault();


                                const form =
                                    this.closest(
                                        'form'
                                    );


                                if (form) {
                                    form.submit();
                                }

                            }

                        }
                    );

                }

            }
        );

    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterForm = document.querySelector('.filter-form');
            if (!filterForm) return;
            const searchInput = filterForm.querySelector('input[name="search"]');
            const statusSelect = filterForm.querySelector('select[name="status"]');
            const perPageSelect = filterForm.querySelector('select[name="per_page"]');
            let searchTimer;
            const submitFilters = function () {
                const params = new URLSearchParams(new FormData(filterForm));
                params.delete('page');
                const query = params.toString();
                const current = new URLSearchParams(window.location.search);
                current.delete('page');
                if (query === current.toString()) return;
                const action = filterForm.getAttribute('action');
                window.location.href = action + (query ? '?' + query : '');
            };
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    window.clearTimeout(searchTimer);
                    searchTimer = window.setTimeout(submitFilters, 450);
                });
                searchInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        window.clearTimeout(searchTimer);
                        submitFilters();
                    }
                });
            }
            if (statusSelect) {
                statusSelect.removeAttribute('onchange');
                statusSelect.addEventListener('change', submitFilters);
            }
            if (perPageSelect) {
                perPageSelect.addEventListener('change', submitFilters);
            }
        });
    </script>

</body>

</html>