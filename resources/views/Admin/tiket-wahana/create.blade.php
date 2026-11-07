<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Tiket Wahana — Admin Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
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

<style>
:root{
 --bg-primary:#0a0a0a;--bg-secondary:#151515;--bg-soft:#1a1a1a;--bg-card:#121212;
 --text-primary:#f8f4ed;--text-secondary:#d4c9b5;--text-muted:#a89988;--text-dim:#7a6f62;
 --accent:#e2c997;--accent-hover:#d4b384;--accent-dark:#b89a6e;
 --border-soft:rgba(255,255,255,.06);--border-gold:rgba(226,201,151,.15);
 --danger:#ef7676;--success:#72d39a;--shadow-soft:0 20px 60px rgba(0,0,0,.4);
 --shadow-hover:0 25px 70px rgba(0,0,0,.5);--radius-lg:28px;--radius-md:16px;
 --radius-full:999px;--transition:.25s cubic-bezier(.4,0,.2,1);
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{
 min-height:100vh;overflow-x:hidden;font-family:'Inter',sans-serif;line-height:1.65;color:var(--text-primary);
 background:radial-gradient(circle at 85% 5%,rgba(226,201,151,.055),transparent 28%),
 radial-gradient(circle at 10% 85%,rgba(226,201,151,.035),transparent 30%),var(--bg-primary);
}
a{color:inherit}button,input,textarea,select{font:inherit}
.admin-main{min-height:100vh;margin-left:290px;padding:52px 54px 70px}
.page-header{display:flex;align-items:flex-end;justify-content:space-between;gap:28px;margin-bottom:34px}
.page-title{
 margin:0 0 12px;font-family:'Playfair Display',serif;font-size:clamp(38px,4vw,58px);
 line-height:1.08;font-weight:700;letter-spacing:-1.4px;
 background:linear-gradient(135deg,#fff 0%,var(--accent) 68%,var(--accent-dark) 100%);
 -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.page-description{max-width:760px;margin:0;color:var(--text-muted);font-size:16px;line-height:1.75}
.mobile-menu-button{
 display:none;position:fixed;top:18px;right:18px;z-index:10050;width:48px;height:48px;
 border:1px solid var(--border-gold);border-radius:14px;background:rgba(18,18,18,.94);
 color:var(--accent);box-shadow:var(--shadow-soft);cursor:pointer
}
.mobile-menu-button span{display:block;width:20px;height:2px;margin:4px auto;border-radius:99px;background:currentColor}
.alert-box{
 display:flex;align-items:flex-start;gap:15px;margin-bottom:24px;padding:18px 20px;
 border:1px solid var(--border-soft);border-radius:var(--radius-md);background:rgba(255,255,255,.025);
 backdrop-filter:blur(18px)
}
.alert-box.error{border-color:rgba(239,118,118,.24);background:rgba(239,118,118,.045)}
.alert-box.success{border-color:rgba(114,211,154,.24);background:rgba(114,211,154,.045)}
.alert-icon{
 width:42px;height:42px;flex:0 0 42px;display:flex;align-items:center;justify-content:center;
 border-radius:13px;background:rgba(255,255,255,.05);color:var(--accent);font-size:17px
}
.error .alert-icon{color:var(--danger)}.success .alert-icon{color:var(--success)}
.alert-title{display:block;margin-bottom:4px;font-size:14px;font-weight:800}
.alert-content ul{margin:0;padding-left:19px;color:var(--text-secondary);font-size:14px}
.alert-message{color:var(--text-secondary);font-size:14px}
.content-grid{display:grid;grid-template-columns: minmax(0, 1fr);gap:30px;align-items:start}
.card{
 border:1px solid var(--border-soft);border-radius:var(--radius-lg);
 background:linear-gradient(145deg,rgba(255,255,255,.035),rgba(255,255,255,.012));
 box-shadow:var(--shadow-soft);backdrop-filter:blur(22px)
}
.form-card{padding:34px}
.card-heading{display:flex;align-items:center;gap:14px;margin-bottom:30px;padding-bottom:22px;border-bottom:1px solid var(--border-soft)}
.card-heading-icon{
 width:46px;height:46px;flex:0 0 46px;display:flex;align-items:center;justify-content:center;
 border:1px solid var(--border-gold);border-radius:14px;background:rgba(226,201,151,.08);
 color:var(--accent);font-size:18px
}
.card-heading h2{margin:0 0 3px;font-size:20px;font-weight:800}
.card-heading p{margin:0;color:var(--text-muted);font-size:14px}
.form-group{margin-bottom:25px}
.form-label{display:flex;align-items:center;gap:5px;margin-bottom:10px;color:var(--text-secondary);font-size:15px;font-weight:700}
.required{color:var(--danger)}
.input-wrap{position:relative}
.input-icon{position:absolute;top:50%;left:18px;z-index:2;transform:translateY(-50%);color:var(--accent-dark);font-size:16px;pointer-events:none}
.form-input,.form-select,.form-textarea{
 width:100%;border:1px solid var(--border-soft);outline:none;color:var(--text-primary);
 background:rgba(255,255,255,.025);transition:var(--transition)
}
.form-input,.form-select{height:58px;padding:0 48px;border-radius:14px;font-size:15px}
.form-input::placeholder,.form-textarea::placeholder{color:#68645d}
.form-input:focus,.form-select:focus,.form-textarea:focus{
 border-color:var(--accent);background:rgba(226,201,151,.025);box-shadow:0 0 0 4px rgba(226,201,151,.07)
}
.form-select{padding-right:48px;appearance:none;cursor:pointer}
.select-arrow{position:absolute;top:50%;right:18px;transform:translateY(-50%);color:var(--accent-dark);pointer-events:none}
.form-select option{background:#171717;color:#fff}
.form-textarea{min-height:155px;padding:17px 18px;border-radius:14px;resize:vertical;font-size:15px;line-height:1.7}
.field-helper{display:flex;justify-content:space-between;gap:12px;margin-top:9px;color:var(--text-muted);font-size:13px}
.field-helper i{margin-right:5px;color:var(--accent-dark)}
.field-error{display:block;margin-top:8px;color:var(--danger);font-size:13px}
.upload-box{
 position:relative;min-height:270px;overflow:hidden;border:1px dashed rgba(226,201,151,.32);
 border-radius:18px;background:linear-gradient(145deg,rgba(226,201,151,.045),rgba(255,255,255,.015));
 cursor:pointer;transition:var(--transition)
}
.upload-box:hover,.upload-box.dragging{border-color:var(--accent);background:rgba(226,201,151,.065);box-shadow:0 0 0 4px rgba(226,201,151,.055)}
.upload-placeholder{min-height:270px;padding:30px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center}
.upload-icon{
 width:66px;height:66px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;
 border:1px solid var(--border-gold);border-radius:18px;background:rgba(226,201,151,.09);color:var(--accent);font-size:25px
}
.upload-title{margin-bottom:7px;font-size:16px;font-weight:800}
.upload-description{max-width:430px;color:var(--text-muted);font-size:14px;line-height:1.65}
.upload-format{margin-top:13px;color:var(--accent-dark);font-size:12px;font-weight:800;letter-spacing:.5px}
.upload-preview{position:absolute;inset:0;display:none}.upload-preview.show{display:block}
.upload-preview img{width:100%;height:100%;object-fit:cover}
.upload-overlay{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;opacity:0;background:rgba(0,0,0,.58);transition:var(--transition)}
.upload-box:hover .upload-overlay{opacity:1}
.upload-overlay span{display:inline-flex;align-items:center;gap:8px;padding:11px 16px;border-radius:11px;background:rgba(0,0,0,.72);color:#fff;font-size:13px;font-weight:700}
.remove-image{
 position:absolute;right:13px;bottom:13px;z-index:5;display:none;align-items:center;gap:7px;height:38px;padding:0 14px;
 border:1px solid rgba(239,118,118,.3);border-radius:10px;background:rgba(15,15,15,.9);color:#ff9292;cursor:pointer;font-size:13px
}
.remove-image.show{display:inline-flex}
.media-regulation-grid{
 display:grid;
 grid-template-columns:minmax(0,1.1fr) minmax(320px,.9fr);
 gap:28px;
 align-items:start;
 margin-top:2px;
}
.media-regulation-grid .form-group{margin-bottom:25px}
.image-column .upload-box{min-height:300px}
.regulation-column .form-textarea{min-height:300px;resize:vertical}
@media(max-width:900px){
 .media-regulation-grid{grid-template-columns:1fr;gap:0}
 .image-column .upload-box{min-height:250px}
 .regulation-column .form-textarea{min-height:220px}
}

.form-actions{display:flex;align-items:center;justify-content:flex-end;gap:12px;margin-top:12px}
.btn{
 min-height:56px;padding:0 22px;display:inline-flex;align-items:center;justify-content:center;gap:9px;
 border-radius:14px;font-size:15px;font-weight:800;text-decoration:none;cursor:pointer;transition:var(--transition)
}
.btn-back{border:1px solid var(--border-soft);background:rgba(255,255,255,.025);color:var(--text-secondary)}
.btn-back:hover{border-color:var(--accent);color:var(--text-primary);transform:translateY(-2px)}
.btn-submit{border:0;background:linear-gradient(135deg,var(--accent),var(--accent-hover));color:#17130c}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 14px 30px rgba(226,201,151,.18)}
.btn-submit:disabled{opacity:.65;cursor:not-allowed;transform:none}
.form-input:focus-visible,.form-select:focus-visible,.form-textarea:focus-visible,.btn:focus-visible,button:focus-visible{outline:2px solid var(--accent);outline-offset:2px}
@media(max-width:1280px){
 .admin-main{margin-left:270px;padding:42px 40px 60px}
 .content-grid{grid-template-columns:1fr}.preview-wrapper{position:relative;top:auto}.ticket-card{max-width:680px}
}
@media(max-width:1024px){
 .admin-main{margin-left:0;padding:90px 30px 50px}.mobile-menu-button{display:block}
 .page-header{align-items:flex-start;flex-direction:column}.page-title{font-size:44px}
}
@media(max-width:768px){
 .admin-main{padding:82px 20px 45px}.page-title{font-size:38px;letter-spacing:-.8px}
 .page-description{font-size:15px}.form-card{padding:26px 21px}.form-label{font-size:15px}
 .form-input,.form-select{height:56px;font-size:15px}.field-helper{font-size:12px;flex-wrap:wrap}
}
@media(max-width:576px){
 .admin-main{padding:78px 14px 35px}.mobile-menu-button{top:14px;right:14px;width:46px;height:46px}
 .page-title{font-size:32px}.page-description{font-size:14px}.alert-box{padding:15px;gap:11px}
 .alert-icon{width:38px;height:38px;flex-basis:38px}.form-card{padding:22px 17px}
 .card-heading{align-items:flex-start;margin-bottom:24px}.card-heading-icon{width:42px;height:42px;flex-basis:42px}
 .upload-box,.upload-placeholder{min-height:230px}.upload-placeholder{padding:22px}.upload-description{font-size:13px}
 .form-actions{justify-content:flex-end;flex-wrap:wrap}.btn{width:auto}.ticket-image{height:205px}
 .ticket-top,.ticket-body,.ticket-footer{padding-left:20px;padding-right:20px}.ticket-title{font-size:29px}.ticket-price{font-size:27px}
}
@media(prefers-reduced-motion:reduce){*,*::before,*::after{scroll-behavior:auto!important;transition:none!important;animation:none!important}}

.page-header{
    display:flex;
    flex-direction:column;
    align-items:flex-start;
    margin-bottom:36px;
}

.page-title{
    display:block;
    width:100%;
    margin:0 0 12px;
}

.page-description{
    display:block;
    width:100%;
    max-width:720px;
    margin:0;
}


/* =========================================================
   MOBILE / TABLET MENU BUTTON
   ========================================================= */

.admin-mobile-menu-button{
    display:none;
    position:fixed !important;
    top:18px !important;
    left:18px !important;
    right:auto !important;
    z-index:99999 !important;

    width:48px;
    height:48px;
    padding:0;

    align-items:center;
    justify-content:center;
    flex-direction:column;
    gap:5px;

    border:1px solid var(--border-gold);
    border-radius:14px;
    background:rgba(18,18,18,.96);
    color:var(--accent);
    box-shadow:0 14px 35px rgba(0,0,0,.45);
    backdrop-filter:blur(18px);
    cursor:pointer;
}

.admin-mobile-menu-button span{
    display:block;
    width:20px;
    height:2px;
    border-radius:99px;
    background:currentColor;
    transition:var(--transition);
}

.admin-mobile-menu-button:hover{
    border-color:var(--accent);
    background:rgba(226,201,151,.10);
    transform:translateY(-1px);
}

@media (max-width:1024px){
    .admin-mobile-menu-button{
        display:flex !important;
    }

    .admin-main{
        margin-left:0 !important;
        padding-top:82px !important;
    }
}

@media (max-width:560px){
    .admin-mobile-menu-button{
        top:14px !important;
        left:14px !important;
        width:46px;
        height:46px;
        border-radius:13px;
    }

    .admin-main{
        padding-top:76px !important;
    }
}


/* =========================================================
   GAMBAR + KETENTUAN
   ========================================================= */

.form-two-column{
    display:grid;
    grid-template-columns:minmax(0, .9fr) minmax(0, 1.1fr);
    gap:28px;
    align-items:start;
}

.form-two-column .form-group{
    margin-bottom:25px;
}

@media (max-width:900px){
    .form-two-column{
        grid-template-columns:1fr;
        gap:0;
    }
}

@media (max-width:560px){
    .form-two-column{
        grid-template-columns:1fr;
    }
}

</style>



<style>
/* =========================================================
   SIDEBAR MOBILE / TABLET — REFERENSI FLOATING GLASS
   ========================================================= */

@media (max-width: 900px){

    body{
        overflow-x:hidden;
    }

    .admin-sidebar{
        position:fixed !important;

        top:10px !important;
        left:10px !important;
        right:auto !important;
        bottom:10px !important;

        width:min(320px, calc(100vw - 20px)) !important;
        height:calc(100dvh - 20px) !important;
        max-height:calc(100dvh - 20px) !important;
        min-height:0 !important;

        border:1px solid rgba(226,201,151,.16) !important;
        border-radius:18px !important;

        background:
            linear-gradient(
                180deg,
                rgba(19,19,19,.90) 0%,
                rgba(9,9,9,.84) 100%
            ) !important;

        backdrop-filter:blur(22px) saturate(120%) !important;
        -webkit-backdrop-filter:blur(22px) saturate(120%) !important;

        box-shadow:
            18px 0 60px rgba(0,0,0,.38),
            0 12px 45px rgba(0,0,0,.22) !important;

        overflow:hidden !important;
        isolation:isolate !important;

        transform:translate3d(calc(-100% - 18px),0,0) !important;
        transition:transform .30s cubic-bezier(.4,0,.2,1) !important;

        z-index:2100 !important;
    }

    .admin-sidebar.open{
        transform:translate3d(0,0,0) !important;
    }

    /* Header/sidebar brand */
    .admin-sidebar-brand{
        position:relative !important;

        padding:18px 13px 13px !important;

        border-bottom:1px solid rgba(255,255,255,.055) !important;

        background:rgba(0,0,0,.075) !important;
    }

    .admin-brand-link{
        gap:11px !important;
        padding-right:52px !important;
    }

    .admin-brand-logo{
        width:45px !important;
        height:45px !important;
        flex:0 0 45px !important;
        border-radius:12px !important;
    }

    .admin-brand-text{
        min-width:0 !important;
    }

    .admin-brand-text strong{
        font-size:18px !important;
        line-height:1.2 !important;
    }

    .admin-brand-text span{
        margin-top:4px !important;
        font-size:8.5px !important;
        letter-spacing:1.3px !important;
    }

    /* Tombol X */
    .admin-sidebar-close-button{
        display:flex !important;

        position:absolute !important;
        top:14px !important;
        right:13px !important;

        width:40px !important;
        height:40px !important;

        align-items:center !important;
        justify-content:center !important;

        border:1px solid rgba(226,201,151,.14) !important;
        border-radius:11px !important;

        background:rgba(255,255,255,.035) !important;
        color:#e2c997 !important;

        z-index:5 !important;
    }

    .admin-sidebar-close-button:hover{
        background:rgba(226,201,151,.08) !important;
        border-color:rgba(226,201,151,.38) !important;
    }

    /* User card */
    .admin-sidebar-user{
        margin:12px 13px 12px !important;
        padding:11px !important;

        border:1px solid rgba(226,201,151,.10) !important;
        border-radius:14px !important;

        background:rgba(255,255,255,.028) !important;
    }

    .admin-user-avatar{
        width:40px !important;
        height:40px !important;
        flex:0 0 40px !important;
        border-radius:12px !important;
    }

    .admin-user-info strong{
        font-size:14px !important;
    }

    .admin-user-info span{
        font-size:12px !important;
    }

    /* Navigation */
    .admin-sidebar-nav{
        min-height:0 !important;

        padding:0 10px 8px !important;

        overflow-x:hidden !important;
        overflow-y:auto !important;

        scrollbar-width:thin !important;
        scrollbar-color:rgba(226,201,151,.22) transparent !important;
    }

    .admin-sidebar-nav::-webkit-scrollbar{
        width:5px;
    }

    .admin-sidebar-nav::-webkit-scrollbar-track{
        background:transparent;
    }

    .admin-sidebar-nav::-webkit-scrollbar-thumb{
        background:rgba(226,201,151,.22);
        border-radius:999px;
    }

    .admin-nav-title{
        margin:15px 9px 7px !important;
        font-size:10px !important;
        letter-spacing:1.2px !important;
    }

    .admin-nav-link{
        min-height:51px !important;

        margin:3px 0 !important;
        padding:0 9px !important;

        border-radius:11px !important;
    }

    .admin-nav-icon{
        width:36px !important;
        height:36px !important;
        flex:0 0 36px !important;
        font-size:13px !important;
    }

    .admin-nav-text{
        font-size:14.5px !important;
    }

    /* Footer */
    .admin-sidebar-footer{
        padding:
            10px
            12px
            max(12px, env(safe-area-inset-bottom))
            !important;

        border-top:1px solid rgba(255,255,255,.055) !important;

        background:rgba(0,0,0,.20) !important;
    }

    .admin-system-status{
        margin-bottom:7px !important;
        padding:9px 10px !important;
        border-radius:10px !important;
        font-size:11px !important;
    }

    .admin-logout-button{
        min-height:43px !important;
        padding:0 9px !important;
        font-size:13.5px !important;
    }

    .admin-sidebar-copyright{
        margin-top:7px !important;
        padding-top:8px !important;
        font-size:9px !important;
    }

    .admin-sidebar-copyright small{
        font-size:9px !important;
    }

    /* Overlay dibuat transparan agar konten belakang masih terlihat */
    .admin-sidebar-overlay{
        display:block !important;

        z-index:2050 !important;

        background:rgba(0,0,0,.43) !important;

        backdrop-filter:blur(3px) !important;
        -webkit-backdrop-filter:blur(3px) !important;

        opacity:0 !important;
        pointer-events:none !important;

        transition:opacity .25s ease !important;
    }

    .admin-sidebar-overlay.show{
        opacity:1 !important;
        pointer-events:auto !important;
    }

    body.admin-sidebar-open{
        overflow:hidden !important;
    }

    /* Tombol hamburger */
    .admin-mobile-menu-button{
        position:fixed !important;
        top:18px !important;
        left:18px !important;
        right:auto !important;

        width:48px !important;
        height:48px !important;

        z-index:2000 !important;

        border:1px solid rgba(226,201,151,.20) !important;
        border-radius:14px !important;

        background:rgba(18,18,18,.90) !important;
        color:#e2c997 !important;

        box-shadow:0 12px 35px rgba(0,0,0,.32) !important;

        backdrop-filter:blur(18px) !important;
        -webkit-backdrop-filter:blur(18px) !important;
    }

    .admin-mobile-menu-button span{
        width:19px !important;
        height:2px !important;
    }
}

/* HP */
@media (max-width:600px){

    .admin-sidebar{
        top:9px !important;
        left:9px !important;
        bottom:9px !important;

        width:min(320px, calc(100vw - 18px)) !important;
        height:calc(100dvh - 18px) !important;
        max-height:calc(100dvh - 18px) !important;

        border-radius:17px !important;
    }

    .admin-sidebar-brand{
        padding:18px 12px 12px !important;
    }

    .admin-sidebar-user{
        margin-left:12px !important;
        margin-right:12px !important;
    }

    .admin-mobile-menu-button{
        top:14px !important;
        left:14px !important;
        width:46px !important;
        height:46px !important;
        border-radius:13px !important;
    }
}

/* HP kecil */
@media (max-width:380px){

    .admin-sidebar{
        top:8px !important;
        left:8px !important;
        bottom:8px !important;

        width:min(305px, calc(100vw - 16px)) !important;
        height:calc(100dvh - 16px) !important;
        max-height:calc(100dvh - 16px) !important;
    }
}
</style>

</head>

<body>

    @include('Admin.partials.sidebar')

    <main class="admin-main">

        <button
            type="button"
            class="admin-mobile-menu-button"
            id="openAdminSidebar"
            aria-label="Buka menu navigasi"
            aria-controls="adminSidebar"
            aria-expanded="false"
            title="Buka menu"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

<header class="page-header">
<h1 class="page-title">
                Tambah Tiket Wahana
            </h1>

            <p class="page-description">
                Tambahkan tiket wahana baru lengkap dengan informasi
                nama wahana, tarif, ketentuan penggunaan, status
                ketersediaan, dan gambar wahana.
            </p>

        </header>

        

        @if ($errors->any())

            <div class="alert-box error">

                <div class="alert-icon">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>

                <div class="alert-content">

                    <span class="alert-title">
                        Gagal menyimpan data
                    </span>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            </div>

        @endif

        

        @if (session('success'))

            <div class="alert-box success">

                <div class="alert-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div class="alert-content">

                    <span class="alert-title">
                        Berhasil
                    </span>

                    <div class="alert-message">
                        {{ session('success') }}
                    </div>

                </div>

            </div>

        @endif

        

        @if (session('error'))

            <div class="alert-box error">

                <div class="alert-icon">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>

                <div class="alert-content">

                    <span class="alert-title">
                        Terjadi kesalahan
                    </span>

                    <div class="alert-message">
                        {{ session('error') }}
                    </div>

                </div>

            </div>

        @endif

        

        <div class="content-grid">

            <section class="card form-card">

                <div class="card-heading">

                    <div class="card-heading-icon">
                        <i class="fa-solid fa-ticket"></i>
                    </div>

                    <div>
                        <h2>Informasi Tiket</h2>
                        <p>Lengkapi data tiket wahana di bawah ini.</p>
                    </div>

                </div>

                <form
                    id="tiketForm"
                    action="{{ route('admin.tiket-wahana.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf

                    

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="nama_wahana"
                        >
                            Nama Wahana
                            <span class="required">*</span>
                        </label>

                        <div class="input-wrap">

                            <i class="fa-solid fa-ticket input-icon"></i>

                            <input
                                type="text"
                                name="nama_wahana"
                                id="nama_wahana"
                                class="form-input"
                                value="{{ old('nama_wahana') }}"
                                placeholder="Contoh: Ferris Wheel"
                                maxlength="255"
                                autocomplete="off"
                                required
                            >

                        </div>

                        @error('nama_wahana')
                            <small class="field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="harga"
                        >
                            Harga Tiket
                            <span class="required">*</span>
                        </label>

                        <div class="input-wrap">

                            <i class="fa-solid fa-wallet input-icon"></i>

                            <input
                                 type="text"
                                 name="harga"
                                 id="harga"
                                 class="form-input"
                                 value="{{ old('harga') }}"
                                 placeholder="2.000"
                                 inputmode="numeric"
                                 pattern="[0-9.]*"
                                 maxlength="6"
                                 autocomplete="off"
                                 aria-describedby="hargaHint hargaStatus"
                                 required
                            >

                        </div>

                        <div class="field-helper">

                            <span>
                                <i class="fa-solid fa-circle-info"></i>
                                Minimal harga tiket Rp 2.000.
                            </span>

                            <span id="hargaStatus"></span>

                        </div>

                        @error('harga')
                            <small class="field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="status"
                        >
                            Status Ketersediaan
                            <span class="required">*</span>
                        </label>

                        <div class="input-wrap">

                            <i class="fa-solid fa-toggle-on input-icon"></i>

                            <select
                                name="status"
                                id="status"
                                class="form-select"
                                required
                            >

                                <option
                                    value="Tersedia"
                                    {{ old('status', 'Tersedia') === 'Tersedia' ? 'selected' : '' }}
                                >
                                    Tersedia
                                </option>

                                <option
                                    value="Tidak Tersedia"
                                    {{ old('status') === 'Tidak Tersedia' ? 'selected' : '' }}
                                >
                                    Tidak Tersedia
                                </option>

                            </select>

                            <i class="fa-solid fa-chevron-down select-arrow"></i>

                        </div>

                        @error('status')
                            <small class="field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    

                    <div class="media-regulation-grid">

                        <div class="regulation-column">

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="ketentuan"
                        >
                            Ketentuan & Regulasi
                        </label>

                        <textarea
                            name="ketentuan"
                            id="ketentuan"
                            class="form-textarea"
                            rows="6"
                            maxlength="1000"
                            placeholder="Contoh: Minimal tinggi 120 cm. Anak-anak wajib didampingi orang dewasa."
                        >{{ old('ketentuan') }}</textarea>

                        <div class="field-helper">

                            <span>
                                <i class="fa-solid fa-circle-info"></i>
                                Jelaskan aturan penggunaan wahana.
                            </span>

                            <span id="counter">
                                0 / 1000
                            </span>

                        </div>

                        @error('ketentuan')
                            <small class="field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror

                    </div>
                        </div>

                        <div class="image-column">

                    <div class="form-group">

                        <label class="form-label" for="gambar">
                            Gambar Wahana
                        </label>

                        <input
                            type="file"
                            name="gambar"
                            id="gambar"
                            accept="image/jpeg,image/png,image/webp"
                            hidden
                        >

                        <div
                            class="upload-box"
                            id="uploadBox"
                        >

                            <label
                                for="gambar"
                                style="display:block; width:100%; height:100%; cursor:pointer;"
                            >

                                <div
                                    class="upload-placeholder"
                                    id="uploadPlaceholder"
                                >

                                    <div class="upload-icon">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                    </div>

                                    <div class="upload-title">
                                        Upload Gambar Wahana
                                    </div>

                                    <div class="upload-description">
                                        Klik untuk memilih gambar atau
                                        tarik gambar ke area ini.
                                    </div>

                                    <div class="upload-format">
                                        JPG / JPEG / PNG / WEBP • Maksimal 2 MB
                                    </div>

                                </div>

                                <div
                                    class="upload-preview"
                                    id="uploadPreview"
                                >

                                    <img
                                        src=""
                                        alt="Preview gambar"
                                        id="imagePreview"
                                    >

                                    <div class="upload-overlay">
                                        <span>
                                            <i class="fa-solid fa-camera"></i>
                                            Ganti gambar
                                        </span>
                                    </div>

                                </div>

                            </label>

                            <button
                                type="button"
                                class="remove-image"
                                id="removeImage"
                            >
                                <i class="fa-solid fa-trash"></i>
                                Hapus
                            </button>

                        </div>

                        <div class="field-helper">
                            <span>
                                <i class="fa-solid fa-circle-info"></i>
                                Gunakan gambar yang jelas.
                            </span>

                            <span>
                                Maks. <strong>2 MB</strong>
                            </span>
                        </div>

                        @error('gambar')
                            <small class="field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </small>
                        @enderror

                    </div>
                        </div>

                    </div>

                                        <div class="form-actions">

                        <a
                            href="{{ route('admin.tiket-wahana.index') }}"
                            class="btn btn-back"
                        >
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn btn-submit"
                            id="submitBtn"
                        >
                            <span id="submitText">
                                Simpan Tiket
                            </span>

                            <i
                                class="fa-solid fa-arrow-right"
                                id="submitIcon"
                            ></i>
                        </button>

                    </div>

                </form>

            </section>
</div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const openAdminSidebar = document.getElementById('openAdminSidebar');

            if (openAdminSidebar) {
                openAdminSidebar.addEventListener('click', function () {
                    if (typeof window.openAdminSidebar === 'function') {
                        window.openAdminSidebar();
                        return;
                    }

                    const sidebar = document.getElementById('adminSidebar');
                    const overlay = document.getElementById('sidebarOverlay');

                    if (sidebar) sidebar.classList.add('open', 'active');
                    if (overlay) overlay.classList.add('show', 'active');

                    document.body.classList.add('sidebar-open');
                    openAdminSidebar.setAttribute('aria-expanded', 'true');
                });
            }

            

            const form = document.getElementById('tiketForm');

            const namaInput =
                document.getElementById('nama_wahana');

            const hargaInput =
                document.getElementById('harga');

            const statusInput =
                document.getElementById('status');

            const ketentuanInput =
                document.getElementById('ketentuan');

            const gambarInput =
                document.getElementById('gambar');

            const uploadBox =
                document.getElementById('uploadBox');

            const uploadPlaceholder =
                document.getElementById('uploadPlaceholder');

            const uploadPreview =
                document.getElementById('uploadPreview');

            const imagePreview =
                document.getElementById('imagePreview');

            const removeImage =
                document.getElementById('removeImage');

            const counter =
                document.getElementById('counter');

            const hargaStatus =
                document.getElementById('hargaStatus');

            const submitBtn =
                document.getElementById('submitBtn');

            const submitText =
                document.getElementById('submitText');

            const submitIcon =
                document.getElementById('submitIcon');

            

            const MIN_HARGA = 2000;
            const MAX_HARGA = 50000;

            function getRawHarga(value) {
                return String(value || '').replace(/\D/g, '');
            }

            function formatHarga(value) {
                const raw = getRawHarga(value);
                if (!raw) return '';
                return new Intl.NumberFormat('id-ID').format(parseInt(raw, 10));
            }

            function getNumericHarga() {
                const raw = getRawHarga(hargaInput ? hargaInput.value : '');
                return raw ? parseInt(raw, 10) : 0;
            }

            function setHargaStatus(message, valid) {
                if (!hargaStatus) return;
                hargaStatus.textContent = message;
                hargaStatus.style.color = valid ? '#72d39a' : '#ef7676';
            }

            function updateHargaStatus() {
                const harga = getNumericHarga();
                if (!harga) {
                    setHargaStatus('', false);
                    return;
                }
                if (harga < MIN_HARGA) {
                    setHargaStatus('Minimal Rp 2.000', false);
                    return;
                }
                if (harga > MAX_HARGA) {
                    setHargaStatus('Maksimal Rp 50.000', false);
                    return;
                }
                setHargaStatus('Harga valid', true);
            }

            if (hargaInput) {
                hargaInput.addEventListener('input', function () {
                    const raw = getRawHarga(this.value).slice(0, 5);
                    this.value = formatHarga(raw);
                    updateHargaStatus();
                });

                hargaInput.addEventListener('keydown', function (event) {
                    const allowed = ['Backspace','Delete','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Tab','Home','End'];
                    if (allowed.includes(event.key) || event.ctrlKey || event.metaKey) return;
                    if (!/^[0-9]$/.test(event.key)) event.preventDefault();
                });

                hargaInput.addEventListener('paste', function (event) {
                    event.preventDefault();
                    const pasted = (event.clipboardData || window.clipboardData).getData('text');
                    this.value = formatHarga(getRawHarga(pasted).slice(0, 5));
                    updateHargaStatus();
                });

                hargaInput.value = formatHarga(getRawHarga(hargaInput.value).slice(0, 5));
                updateHargaStatus();
            }

            function updateCounter() {
                if (!ketentuanInput || !counter) return;
                counter.textContent = `${ketentuanInput.value.length} / 1000`;
            }

            if (ketentuanInput) {
                ketentuanInput.addEventListener('input', updateCounter);
                updateCounter();
            }

            function resetImage() {
                if (gambarInput) gambarInput.value = '';
                if (imagePreview) imagePreview.src = '';
                if (uploadPreview) uploadPreview.classList.remove('show');
                if (uploadPlaceholder) uploadPlaceholder.style.display = 'flex';
                if (removeImage) removeImage.classList.remove('show');
            }

            function showImage(file) {
                if (!file) return;
                const allowedTypes = ['image/jpeg','image/png','image/webp'];
                const maxSize = 2 * 1024 * 1024;

                if (!allowedTypes.includes(file.type)) {
                    alert('Format gambar harus JPG, JPEG, PNG, atau WEBP.');
                    resetImage();
                    return;
                }
                if (file.size > maxSize) {
                    alert('Ukuran gambar maksimal adalah 2 MB.');
                    resetImage();
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (event) {
                    if (imagePreview) imagePreview.src = event.target.result;
                    if (uploadPreview) uploadPreview.classList.add('show');
                    if (uploadPlaceholder) uploadPlaceholder.style.display = 'none';
                    if (removeImage) removeImage.classList.add('show');
                };
                reader.readAsDataURL(file);
            }

            if (gambarInput) {
                gambarInput.addEventListener('change', function () {
                    if (this.files && this.files.length) showImage(this.files[0]);
                });
            }

            if (removeImage) {
                removeImage.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    resetImage();
                });
            }

            if (uploadBox) {
                ['dragenter','dragover'].forEach(function (eventName) {
                    uploadBox.addEventListener(eventName, function (event) {
                        event.preventDefault();
                        event.stopPropagation();
                        uploadBox.classList.add('dragging');
                    });
                });

                ['dragleave','drop'].forEach(function (eventName) {
                    uploadBox.addEventListener(eventName, function (event) {
                        event.preventDefault();
                        event.stopPropagation();
                        uploadBox.classList.remove('dragging');
                    });
                });

                uploadBox.addEventListener('drop', function (event) {
                    const files = event.dataTransfer.files;
                    if (!files || !files.length) return;
                    const file = files[0];
                    try {
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        gambarInput.files = dataTransfer.files;
                    } catch (error) {
                        console.warn('Browser tidak mendukung DataTransfer.', error);
                    }
                    showImage(file);
                });
            }

            form.addEventListener(
                'submit',
                function (event) {

                    const nama =
                        namaInput.value.trim();

                    const harga =
                        getNumericHarga();

                    if (!nama) {

                        event.preventDefault();

                        alert(
                            'Nama wahana wajib diisi.'
                        );

                        namaInput.focus();

                        return;

                    }

                    if (!harga || harga < MIN_HARGA) {

                        event.preventDefault();

                        alert(
                            'Harga tiket minimal adalah Rp 2.000.'
                        );

                        hargaInput.focus();

                        return;

                    }

                    if (harga > MAX_HARGA) {

                        event.preventDefault();

                        alert(
                            'Harga tiket maksimal adalah Rp 50.000.'
                        );

                        hargaInput.focus();

                        return;

                    }

                    

                    hargaInput.value =
                        harga;

                    

                    submitBtn.disabled =
                        true;

                    submitText.textContent =
                        'Menyimpan...';

                    submitIcon.className =
                        'fa-solid fa-spinner fa-spin';

                }
            );

        });
    </script>

</body>

</html>