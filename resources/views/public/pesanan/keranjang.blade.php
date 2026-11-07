@extends('public.layouts.app')

@section('title', 'Keranjang - Noyo Gimbal')

@push('styles')
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
    --border-gold-strong:rgba(226,201,151,.30);

    --shadow-soft:0 20px 60px rgba(0,0,0,.40);
    --shadow-hover:0 25px 70px rgba(0,0,0,.50);

    --radius-lg:28px;
    --radius-md:18px;
    --radius-sm:14px;
    --radius-full:999px;

    --transition:.25s cubic-bezier(.4,0,.2,1);
}

.cart-page,
.cart-page *,
.cart-page *::before,
.cart-page *::after{
    box-sizing:border-box;
}

.cart-page{
    min-height:100vh;
    width:100%;
    overflow-x:clip;
    padding:112px 0 78px;
    background:
        radial-gradient(circle at 85% 0%, rgba(226,201,151,.085), transparent 28%),
        radial-gradient(circle at 10% 55%, rgba(226,201,151,.025), transparent 25%),
        var(--bg-primary);
    color:var(--text-primary);
}

.cart-container{
    width:min(1280px, calc(100% - 56px));
    min-width:0;
    margin-inline:auto;
}

.cart-header{
    margin-bottom:28px;
}

.cart-title{
    margin:0;
    color:var(--text-primary);
    font-family:"Playfair Display", Georgia, serif;
    font-size:clamp(42px, 5vw, 64px);
    font-weight:500;
    line-height:1.05;
    letter-spacing:-.035em;
}

.cart-title span{
    color:var(--accent);
    font-style:italic;
}

.cart-info{
    display:flex;
    align-items:center;
    gap:18px;
    margin-bottom:24px;
    padding:18px 20px;
    border:1px solid var(--border-gold);
    border-radius:var(--radius-md);
    background:
        linear-gradient(135deg, rgba(226,201,151,.075), rgba(255,255,255,.018));
    box-shadow:0 12px 36px rgba(0,0,0,.16);
}

.cart-info-left{
    display:flex;
    align-items:center;
    gap:16px;
    min-width:0;
}

.cart-info-icon{
    width:50px;
    height:50px;
    flex:0 0 50px;
    display:grid;
    place-items:center;
    border:1px solid rgba(226,201,151,.18);
    border-radius:15px;
    background:rgba(226,201,151,.09);
    color:var(--accent);
}

.cart-info-icon svg{
    width:24px;
    height:24px;
}

.cart-info-title{
    margin:0 0 4px;
    color:var(--text-primary);
    font-family:"Playfair Display", Georgia, serif;
    font-size:20px;
    font-weight:600;
    line-height:1.2;
}

.cart-info-text{
    margin:0;
    color:var(--text-muted);
    font-size:15px;
    line-height:1.65;
}

.cart-empty{
    padding:72px 28px;
    border:1px solid var(--border-soft);
    border-radius:var(--radius-lg);
    background:var(--bg-card);
    box-shadow:var(--shadow-soft);
    text-align:center;
}

.cart-empty-icon{
    width:84px;
    height:84px;
    margin:0 auto 22px;
    display:grid;
    place-items:center;
    border:1px solid var(--border-gold);
    border-radius:22px;
    color:var(--accent);
    background:rgba(226,201,151,.075);
}

.cart-empty-icon svg{
    width:38px;
    height:38px;
}

.cart-empty h2{
    margin:0 0 10px;
    color:var(--text-primary);
    font-family:"Playfair Display", Georgia, serif;
    font-size:32px;
    font-weight:600;
    line-height:1.2;
}

.cart-empty p{
    max-width:560px;
    margin:0 auto 28px;
    color:var(--text-muted);
    font-size:16px;
    line-height:1.8;
}

.cart-grid{
    display:grid;
    grid-template-columns:minmax(0, 1fr) minmax(300px, 380px);
    gap:24px;
    align-items:start;
    min-width:0;
}

.cart-grid > *,
.cart-item > *{
    min-width:0;
}

.cart-panel{
    overflow:hidden;
    border:1px solid var(--border-soft);
    border-radius:var(--radius-lg);
    background:var(--bg-card);
    box-shadow:0 12px 38px rgba(0,0,0,.16);
}

.cart-panel-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    padding:22px 24px;
    border-bottom:1px solid var(--border-soft);
}

.cart-panel-title{
    margin:0;
    color:var(--text-primary);
    font-family:"Playfair Display", Georgia, serif;
    font-size:23px;
    font-weight:600;
    line-height:1.2;
}

.cart-item-count{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:38px;
    padding:0 13px;
    border:1px solid rgba(226,201,151,.18);
    border-radius:var(--radius-full);
    background:rgba(226,201,151,.08);
    color:var(--accent);
    font-size:14px;
    font-weight:800;
}

.cart-items{
    padding:2px 24px 10px;
}

.cart-item{
    display:grid;
    grid-template-columns:96px minmax(0,1fr) auto;
    gap:18px;
    align-items:center;
    padding:20px 0;
    border-bottom:1px solid var(--border-soft);
}

.cart-item:last-child{
    border-bottom:0;
}

.cart-item-image{
    width:96px;
    height:96px;
    overflow:hidden;
    border:1px solid var(--border-soft);
    border-radius:18px;
    background:var(--bg-soft);
}

.cart-item-image img{
    display:block;
    width:100%;
    height:100%;
    object-fit:cover;
}

.cart-item-image-fallback{
    width:100%;
    height:100%;
    display:grid;
    place-items:center;
    color:var(--accent-dark);
}

.cart-item-image-fallback svg{
    width:30px;
    height:30px;
}

.cart-item-type{
    display:inline-flex;
    align-items:center;
    min-height:28px;
    padding:0 10px;
    margin-bottom:7px;
    border:1px solid rgba(226,201,151,.14);
    border-radius:var(--radius-full);
    background:rgba(226,201,151,.07);
    color:var(--accent);
    font-size:12px;
    font-weight:800;
    line-height:1;
}

.cart-item-name{
    overflow-wrap:anywhere;
    margin:0 0 6px;
    color:var(--text-primary);
    font-family:"Playfair Display", Georgia, serif;
    font-size:20px;
    font-weight:600;
    line-height:1.25;
}

.cart-item-meta{
    color:var(--text-muted);
    font-size:15px;
    line-height:1.5;
}

.cart-item-price-mobile{
    display:none;
}

.cart-item-right{
    min-width:178px;
    display:flex;
    flex-direction:column;
    align-items:flex-end;
    gap:11px;
}

.cart-item-price{
    max-width:100%;
    overflow-wrap:anywhere;
    color:var(--accent);
    font-size:18px;
    font-weight:900;
    line-height:1.3;
    white-space:nowrap;
}

.cart-item-actions{
    display:flex;
    min-width:0;
    max-width:100%;
    align-items:center;
    gap:9px;
}

.qty-control{
    display:inline-flex;
    align-items:center;
    min-height:44px;
    overflow:hidden;
    border:1px solid var(--border-soft);
    border-radius:13px;
    background:#0e0e0e;
}

.qty-btn{
    width:42px;
    height:44px;
    padding:0;
    border:0;
    color:var(--text-secondary);
    background:transparent;
    cursor:pointer;
    font-size:20px;
    line-height:1;
    transition:all var(--transition);
}

.qty-btn:hover,
.qty-btn:focus-visible{
    color:var(--accent);
    background:rgba(226,201,151,.08);
    outline:none;
}

.qty-value{
    width:42px !important;
    min-width:42px;
    height:44px;
    padding:0;
    border:0 !important;
    outline:none !important;
    background:transparent !important;
    color:var(--text-primary) !important;
    text-align:center;
    font-size:15px;
    font-weight:800;
}

.qty-value::-webkit-outer-spin-button,
.qty-value::-webkit-inner-spin-button{
    margin:0;
    appearance:none;
}

.qty-value[type=number]{
    -moz-appearance:textfield;
}

.cart-delete{
    width:44px;
    height:44px;
    display:grid;
    place-items:center;
    padding:0;
    border:1px solid rgba(210,90,70,.17);
    border-radius:13px;
    color:#d58c80;
    background:rgba(210,90,70,.055);
    cursor:pointer;
    transition:all var(--transition);
}

.cart-delete:hover,
.cart-delete:focus-visible{
    border-color:rgba(210,90,70,.32);
    background:rgba(210,90,70,.11);
    color:#efab9f;
    outline:none;
}

.cart-delete svg{
    width:18px;
    height:18px;
}

.cart-summary{
    position:sticky;
    top:102px;
}

.summary-inner{
    padding:26px;
}

.summary-title{
    margin:0 0 22px;
    color:var(--text-primary);
    font-family:"Playfair Display", Georgia, serif;
    font-size:25px;
    font-weight:600;
    line-height:1.2;
}

.summary-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    margin-bottom:15px;
    color:var(--text-muted);
    font-size:16px;
    line-height:1.5;
}

.summary-row strong{
    color:var(--text-primary);
    font-weight:700;
}

.summary-divider{
    height:1px;
    margin:21px 0;
    background:var(--border-soft);
}

.summary-total{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:18px;
}

.summary-total span{
    color:var(--text-muted);
    font-size:15px;
    line-height:1.5;
}

.summary-total strong{
    color:var(--accent);
    font-size:27px;
    font-weight:900;
    line-height:1.15;
    text-align:right;
}

.checkout-btn{
    width:100%;
    min-height:56px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    margin-top:24px;
    padding:0 18px;
    border:1px solid var(--accent);
    border-radius:15px;
    background:linear-gradient(135deg, var(--accent), var(--accent-hover));
    color:#15120e;
    font-size:16px;
    font-weight:900;
    line-height:1;
    text-decoration:none;
    cursor:pointer;
    transition:all var(--transition);
}

.checkout-btn:hover,
.checkout-btn:focus-visible{
    color:#15120e;
    background:linear-gradient(135deg, var(--accent-hover), var(--accent-dark));
    transform:translateY(-2px);
    box-shadow:0 15px 35px rgba(226,201,151,.13);
    outline:none;
}

.checkout-btn svg{
    width:19px;
    height:19px;
}

.cart-explore-btn{
    max-width:260px;
    margin:0 auto;
}

.clear-cart-form{
    margin-top:15px;
    text-align:center;
}

.clear-cart-btn{
    min-height:42px;
    padding:0 10px;
    border:0;
    border-radius:10px;
    background:transparent;
    color:#d98276;
    font-size:14px;
    font-weight:800;
    line-height:1.4;
    cursor:pointer;
    transition:all var(--transition);
}

.clear-cart-btn:hover,
.clear-cart-btn:focus-visible{
    color:#ef9d8d;
    background:rgba(210,90,70,.055);
    outline:none;
}

.clear-cart-modal{
    position:fixed;
    inset:0;
    z-index:9999;
    display:none;
    align-items:center;
    justify-content:center;
    padding:20px;
    background:rgba(0,0,0,.74);
    backdrop-filter:blur(8px);
    -webkit-backdrop-filter:blur(8px);
}

.clear-cart-modal.is-open{
    display:flex;
}

.clear-cart-dialog{
    width:min(460px,100%);
    padding:30px;
    border:1px solid var(--border-gold);
    border-radius:24px;
    background:var(--bg-card);
    box-shadow:0 25px 80px rgba(0,0,0,.55);
    text-align:center;
    animation:clearCartModalIn .22s ease-out;
}

.clear-cart-icon{
    width:62px;
    height:62px;
    margin:0 auto 18px;
    display:grid;
    place-items:center;
    border:1px solid rgba(210,90,70,.22);
    border-radius:18px;
    color:#e18b7e;
    background:rgba(210,90,70,.09);
}

.clear-cart-icon svg{
    width:28px;
    height:28px;
}

.clear-cart-title{
    margin:0 0 9px;
    color:var(--text-primary);
    font-family:"Playfair Display", Georgia, serif;
    font-size:27px;
    font-weight:600;
    line-height:1.2;
}

.clear-cart-text{
    max-width:350px;
    margin:0 auto 24px;
    color:var(--text-muted);
    font-size:15px;
    line-height:1.7;
}

.clear-cart-modal-actions{
    display:flex;
    gap:11px;
}

.clear-cart-cancel,
.clear-cart-confirm{
    flex:1;
    min-height:48px;
    border-radius:13px;
    font-size:15px;
    font-weight:800;
    cursor:pointer;
    transition:all var(--transition);
}

.clear-cart-cancel{
    border:1px solid var(--border-soft);
    color:var(--text-secondary);
    background:#181818;
}

.clear-cart-cancel:hover,
.clear-cart-cancel:focus-visible{
    color:var(--text-primary);
    background:#202020;
    outline:none;
}

.clear-cart-confirm{
    border:1px solid rgba(210,90,70,.35);
    color:#fff4f1;
    background:#a9574b;
}

.clear-cart-confirm:hover,
.clear-cart-confirm:focus-visible{
    background:#b96558;
    transform:translateY(-1px);
    outline:none;
}

@keyframes clearCartModalIn{
    from{opacity:0; transform:translateY(8px) scale(.97);}
    to{opacity:1; transform:translateY(0) scale(1);}
}

@media (max-width:1180px){
    .cart-container{
        width:min(1080px, calc(100% - 42px));
    }

    .cart-grid{
        grid-template-columns:minmax(0,1fr) 330px;
        gap:20px;
    }

    .cart-item-right{
        min-width:160px;
    }
}

@media (max-width:900px){
    .cart-page{

        padding:100px 0 64px;
    }

    .cart-container{
        width:min(760px, calc(100% - 34px));
    }

    .cart-grid{
        grid-template-columns:1fr;
    }

    .cart-summary{
        position:static;
    }

    .summary-inner{
        padding:24px;
    }

    .cart-item{
        grid-template-columns:88px minmax(0,1fr) minmax(116px, auto);
        gap:14px;
        align-items:center;
    }

    .cart-item-image{
        width:88px;
        height:88px;
    }

    .cart-item-right{
        grid-column:auto;
        min-width:0;
        align-items:flex-end;
        justify-content:center;
        flex-direction:column;
        flex-wrap:nowrap;
        gap:10px;
    }

    .cart-item-price{
        display:block;
        order:0;
    }

    .cart-item-actions{
        order:1;
        justify-content:flex-end;
        width:100%;
    }
}

@media (max-width:700px){
    .cart-page{

        padding:92px 0 52px;
    }

    .cart-container{
        width:calc(100% - 28px);
    }

    .cart-header{
        margin-bottom:22px;
    }

    .cart-title{
        font-size:clamp(38px, 11vw, 50px);
    }

    .cart-info{
        padding:16px;
    }

    .cart-info-left{
        align-items:flex-start;
    }

    .cart-info-icon{
        width:46px;
        height:46px;
        flex-basis:46px;
        border-radius:14px;
    }

    .cart-info-title{
        font-size:18px;
    }

    .cart-info-text{
        font-size:14px;
    }

    .cart-panel-header{
        padding:19px;
    }

    .cart-panel-title{
        font-size:21px;
    }

    .cart-item-count{
        min-height:35px;
        font-size:13px;
    }

    .cart-items{
        padding:0 19px 8px;
    }

    .cart-item{
        grid-template-columns:78px minmax(0,1fr) 122px;
        gap:12px;
        padding:17px 0;
        align-items:center;
    }

    .cart-item-image{
        width:78px;
        height:78px;
        border-radius:16px;
    }

    .cart-item-name{
        font-size:19px;
    }

    .cart-item-meta{
        font-size:14px;
    }

    .cart-item-type{
        min-height:27px;
        padding:0 9px;
        font-size:11px;
    }

    .cart-item-right{
        grid-column:auto;
        min-width:0;
        align-items:flex-end;
        justify-content:center;
        flex-direction:column;
        flex-wrap:nowrap;
        gap:8px;
    }

    .cart-item-price{
        display:block;
        font-size:15px;
    }

    .cart-item-price-mobile{
        display:none;
    }

    .cart-item-actions{
        width:auto;
        flex-wrap:nowrap;
        justify-content:flex-end;
        gap:7px;
    }

    .qty-control{
        min-height:42px;
        height:42px;
    }

    .qty-btn{
        width:34px;
        height:42px;
    }

    .qty-value{
        width:30px !important;
        min-width:30px;
        height:42px;
        font-size:13px;
    }

    .cart-delete{
        width:42px;
        height:42px;
    }

    .summary-inner{
        padding:20px;
    }

    .summary-title{
        font-size:23px;
    }

    .summary-row{
        font-size:15px;
    }

    .summary-total span{
        font-size:14px;
    }

    .summary-total strong{
        font-size:24px;
    }

    .checkout-btn{
        min-height:56px;
        font-size:15px;
    }

    .clear-cart-btn{
        min-height:44px;
        font-size:14px;
    }
}

@media (max-width:600px){
    .cart-item-actions{
        gap:6px;
    }

    .cart-item-right{
        width:100%;
    }

    .qty-control{
        flex:0 0 auto;
    }

    .cart-delete{
        flex:0 0 auto;
    }
}

@media (max-width:480px){
    .cart-item{
        grid-template-columns:64px minmax(0,1fr);
        align-items:start;
    }

    .cart-item-image{
        width:64px;
        height:64px;
        grid-row:1 / span 2;
    }

    .cart-item-right{
        grid-column:2;
        width:100%;
        align-items:flex-start;
        flex-direction:row;
        justify-content:space-between;
        flex-wrap:wrap;
    }

    .cart-item-actions{
        flex-wrap:wrap;
    }

    .cart-container{
        width:calc(100% - 22px);
    }

    .cart-info{
        border-radius:18px;
    }

    .cart-item{
        grid-template-columns:70px minmax(0,1fr) 108px;
        gap:10px;
    }

    .cart-item-image{
        width:70px;
        height:70px;
    }

    .cart-item-name{
        font-size:18px;
    }

    .cart-item-meta,
    .cart-info-text{
        font-size:13.5px;
    }

    .cart-empty{
        padding:60px 20px;
    }

    .cart-empty h2{
        font-size:28px;
    }

    .cart-empty p{
        font-size:15px;
    }

    .clear-cart-dialog{
        padding:25px 19px;
        border-radius:21px;
    }

    .clear-cart-modal-actions{
        flex-direction:column-reverse;
    }

    .clear-cart-cancel,
    .clear-cart-confirm{
        width:100%;
        min-height:50px;
    }
}

@media (max-width:360px){
    .cart-title{
        font-size:36px;
    }

    .cart-panel-header{
        padding:16px;
    }

    .cart-items{
        padding-inline:16px;
    }

    .cart-item{
        grid-template-columns:58px minmax(0,1fr) 96px;
        gap:8px;
    }

    .cart-item-image{
        width:58px;
        height:58px;
    }

    .cart-item-name{
        font-size:17px;
    }

    .cart-item-type{
        font-size:10px;
    }

    .summary-inner{
        padding:18px;
    }
}

.cart-page button,
.cart-page a{
    -webkit-tap-highlight-color:transparent;
}

.cart-page button:focus-visible,
.cart-page a:focus-visible{
    outline:3px solid rgba(226,201,151,.48);
    outline-offset:3px;
}

@media (hover:none){
    .checkout-btn:hover,
    .cart-delete:hover,
    .qty-btn:hover,
    .clear-cart-btn:hover{
        transform:none;
    }
}

@media (max-width:360px){
    .cart-page{ padding-top:88px; }
}

@media (prefers-reduced-motion:reduce){
    .cart-page *,
    .cart-page *::before,
    .cart-page *::after{
        scroll-behavior:auto !important;
        transition-duration:.01ms !important;
        animation-duration:.01ms !important;
        animation-iteration-count:1 !important;
    }
}
</style>
@endpush

@section('content')

<div class="cart-page">

    <div class="cart-container">

        <div class="cart-header">

            <h1 class="cart-title">
                Keranjang <span>Belanja</span>
            </h1>

        </div>

        <div class="cart-info">

            <div class="cart-info-left">

                <div class="cart-info-icon">
                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.5L21 8H6"/>
                        <circle cx="10" cy="20" r="1"/>
                        <circle cx="18" cy="20" r="1"/>
                    </svg>
                </div>

                <div>
                    <h3 class="cart-info-title">
                        Pesanan Anda
                    </h3>

                    <p class="cart-info-text">
                        Periksa kembali item yang kamu pilih sebelum melanjutkan ke pembayaran.
                    </p>
                </div>

            </div>

        </div>

        @php
            $cart = $cart ?? session('keranjang', []);

            if ($cart instanceof \Illuminate\Support\Collection) {
                $cart = $cart->toArray();
            }

            $cart = is_array($cart) ? $cart : [];
            $cartLines = [];
            $cartTotal = 0;
            $cartQty = 0;

            foreach ($cart as $key => $rawItem) {
                $item = is_array($rawItem) ? $rawItem : (array) $rawItem;
                $qty = max(1, min(99, (int) ($item['qty'] ?? $item['quantity'] ?? 1)));
                $price = max(0, (int) ($item['harga'] ?? $item['price'] ?? 0));
                $subtotal = $price * $qty;
                $type = strtolower((string) ($item['type'] ?? $item['jenis'] ?? $item['kategori'] ?? 'produk'));

                $typeLabel = match ($type) {
                    'menu' => 'Menu',
                    'wahana' => 'Wahana',
                    'oleh_oleh', 'oleh-oleh', 'oleh oleh' => 'Oleh-Oleh',
                    'bundling', 'paket', 'paket_bundling' => 'Paket Bundling',
                    default => ucwords(str_replace(['_', '-'], ' ', $type)),
                };

                $cartLines[] = [
                    'key' => $key,
                    'name' => $item['nama'] ?? $item['name'] ?? $item['nama_menu'] ?? $item['nama_wahana'] ?? $item['nama_paket'] ?? 'Produk',
                    'typeLabel' => $typeLabel,
                    'price' => $price,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                    'image' => $item['gambar_url'] ?? $item['image'] ?? $item['gambar'] ?? null,
                ];

                $cartQty += $qty;
                $cartTotal += $subtotal;
            }
        @endphp

        @if(empty($cart))

            <div class="cart-empty">

                <div class="cart-empty-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.7">
                        <path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.5L21 8H6"/>
                        <circle cx="10" cy="20" r="1"/>
                        <circle cx="18" cy="20" r="1"/>
                    </svg>

                </div>

                <h2>
                    Keranjang masih kosong
                </h2>

                <p>
                    Belum ada produk yang kamu pilih.
                    Yuk, jelajahi menu, wahana, oleh-oleh, atau paket bundling Noyo Gimbal.
                </p>

                <a href="{{ route('public.home') }}"
                   class="checkout-btn"
                   style="max-width:260px;margin:0 auto;">
                    Jelajahi Noyo Gimbal
                </a>

            </div>

        @else

            <div class="cart-grid">

                <div class="cart-panel">

                    <div class="cart-panel-header">

                        <h2 class="cart-panel-title">
                            Item Pesanan
                        </h2>

                        <span class="cart-item-count">
                            {{ $cartQty }} Item
                        </span>

                    </div>

                    <div class="cart-items">

                        @foreach($cartLines as $line)

                            @php
                                $key = $line['key'];
                                $name = $line['name'];
                                $typeLabel = $line['typeLabel'];
                                $price = $line['price'];
                                $qty = $line['qty'];
                                $subtotal = $line['subtotal'];
                                $image = $line['image'] ?? null;
                                $fallbackImage = asset('images/no-image.png');
                            @endphp

                            <div class="cart-item">

                                <div class="cart-item-image">

                                    @if(!empty($image))
                                        <img
                                            src="{{ $image }}"
                                            alt="{{ $name }}"
                                            loading="lazy"
                                            onerror="this.onerror=null;this.src='{{ $fallbackImage }}';"
                                        >
                                    @else

                                        <div class="cart-item-image-fallback">

                                            <svg viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.6">
                                                <rect x="3" y="3" width="18" height="18" rx="3"/>
                                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                                <path d="m21 15-5-5L5 21"/>
                                            </svg>

                                        </div>

                                    @endif

                                </div>

                                <div>

                                    <span class="cart-item-type">
                                        {{ $typeLabel }}
                                    </span>

                                    <h3 class="cart-item-name">
                                        {{ $name }}
                                    </h3>

                                    <div class="cart-item-meta">
                                        {{ $qty }} ×
                                        Rp {{ number_format($price, 0, ',', '.') }}
                                    </div>

                                    <div class="cart-item-price-mobile">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </div>

                                </div>

                                <div class="cart-item-right">

                                    <div class="cart-item-price">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </div>

                                    <div class="cart-item-actions">

                                        <form
                                            method="POST"
                                            action="{{ route('pesanan.keranjang.update') }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <input
                                                type="hidden"
                                                name="key"
                                                value="{{ $key }}"
                                            >

                                            <div class="qty-control">

                                                <button
                                                    type="button"
                                                    class="qty-btn"
                                                    aria-label="Kurangi jumlah {{ $name }}"
                                                    onclick="changeQty(this, -1)"
                                                >
                                                    −
                                                </button>

                                                <input
                                                    type="number"
                                                    name="qty"
                                                    value="{{ $qty }}"
                                                    min="1"
                                                    max="99"
                                                    class="qty-value"
                                                    aria-label="Jumlah {{ $name }}"
                                                    required
                                                    onchange="if (this.form.reportValidity()) this.form.requestSubmit()"
                                                >

                                                <button
                                                    type="button"
                                                    class="qty-btn"
                                                    aria-label="Tambah jumlah {{ $name }}"
                                                    onclick="changeQty(this, 1)"
                                                >
                                                    +
                                                </button>

                                            </div>

                                        </form>

                                        <form
                                            method="POST"
                                            action="{{ route('pesanan.keranjang.hapus', ['key' => $key]) }}"
                                            onsubmit="return confirm('Hapus item ini dari keranjang?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="cart-delete"
                                                title="Hapus"
                                                aria-label="Hapus {{ $name }} dari keranjang"
                                            >
                                                <svg viewBox="0 0 24 24"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     stroke-width="1.8">
                                                    <path d="M4 7h16"/>
                                                    <path d="M10 11v6M14 11v6"/>
                                                    <path d="M6 7l1 13h10l1-13"/>
                                                    <path d="M9 7V4h6v3"/>
                                                </svg>
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

                <aside class="cart-panel cart-summary">

                    <div class="summary-inner">

                        <h2 class="summary-title">
                            Ringkasan Pesanan
                        </h2>

                        <div class="summary-row">
                            <span>
                                Jumlah item
                            </span>

                            <strong>
                                {{ $cartQty }}
                            </strong>
                        </div>

                        <div class="summary-row">
                            <span>
                                Subtotal
                            </span>

                            <strong>
                                Rp {{ number_format($cartTotal, 0, ',', '.') }}
                            </strong>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-total">
                            <span>
                                Total Pembayaran
                            </span>

                            <strong>
                                Rp {{ number_format($cartTotal, 0, ',', '.') }}
                            </strong>
                        </div>

                        <a
                            href="{{ route('pesanan.checkout') }}"
                            class="checkout-btn"
                        >
                            Lanjut ke Pembayaran

                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M5 12h14"/>
                                <path d="m13 6 6 6-6 6"/>
                            </svg>
                        </a>
<form
                            method="POST"
                            action="{{ route('pesanan.keranjang.kosongkan') }}"
                            class="clear-cart-form"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                class="clear-cart-btn"
                                onclick="openClearCartModal()"
                            >
                                Kosongkan Keranjang
                            </button>

                        </form>

                    </div>

                </aside>

            </div>

            <div
                id="clearCartModal"
                class="clear-cart-modal"
                role="dialog"
                aria-modal="true"
                aria-labelledby="clearCartTitle"
                aria-hidden="true"
                onclick="handleClearCartBackdrop(event)"
            >
                <div class="clear-cart-dialog" onclick="event.stopPropagation()">

                    <div class="clear-cart-icon">
                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M12 8v4"/>
                            <circle cx="12" cy="16" r=".8" fill="currentColor" stroke="none"/>
                            <path d="M10.3 3.8 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3l-7.5-13.2a2 2 0 0 0-3.4 0Z"/>
                        </svg>
                    </div>

                    <h2 id="clearCartTitle" class="clear-cart-title">
                        Kosongkan Keranjang?
                    </h2>

                    <p class="clear-cart-text">
                        Semua item yang ada di keranjang akan dihapus.
                        Apakah kamu yakin ingin melanjutkan?
                    </p>

                    <div class="clear-cart-modal-actions">
                        <button
                            type="button"
                            class="clear-cart-cancel"
                            onclick="closeClearCartModal()"
                        >
                            Batal
                        </button>

                        <button
                            type="button"
                            class="clear-cart-confirm"
                            onclick="submitClearCart()"
                        >
                            Ya, Kosongkan
                        </button>
                    </div>

                </div>
            </div>

        @endif

    </div>

</div>

@endsection

@push('scripts')
<script>
    function changeQty(button, amount) {
        const form = button.closest('form');

        if (!form) {
            return;
        }

        const input = form.querySelector('input[name="qty"]');

        if (!input) {
            return;
        }

        let value = parseInt(input.value || 1);

        value += amount;

        if (value < 1) {
            value = 1;
        }

        if (value > 99) {
            value = 99;
        }

        input.value = value;

        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
        } else {
            form.submit();
        }
    }

    let previouslyFocusedElement = null;

    function openClearCartModal() {
        const modal = document.getElementById('clearCartModal');

        if (!modal) {
            return;
        }

        previouslyFocusedElement = document.activeElement;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        const cancelButton = modal.querySelector('.clear-cart-cancel');

        if (cancelButton) {
            setTimeout(() => cancelButton.focus(), 50);
        }
    }

    function closeClearCartModal() {
        const modal = document.getElementById('clearCartModal');

        if (!modal) {
            return;
        }

        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';

        if (previouslyFocusedElement && typeof previouslyFocusedElement.focus === 'function') {
            previouslyFocusedElement.focus();
        }
    }

    function handleClearCartBackdrop(event) {
        if (event.target === event.currentTarget) {
            closeClearCartModal();
        }
    }

    function submitClearCart() {
        const form = document.querySelector('.clear-cart-form');

        if (form) {
            form.submit();
        }
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeClearCartModal();
        }
    });
</script>
@endpush
