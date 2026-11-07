<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>Tambah Event — Noyo Gimbal</title>


    {{-- FONT --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >


    {{-- FONT AWESOME --}}

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    {{-- VITE --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


<style>
@import "tailwindcss";

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

    --border-soft:rgba(255,255,255,.06);
    --border-gold:rgba(226,201,151,.15);

    --white:#ffffff;
    --black:#000000;

    --shadow-soft:0 20px 60px rgba(0,0,0,.4);
    --shadow-hover:0 25px 70px rgba(0,0,0,.5);

    --radius-lg:28px;
    --radius-md:16px;
    --radius-full:999px;

    --transition:.25s cubic-bezier(.4,0,.2,1);
    --sidebar-width:280px;
}

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{
    min-height:100vh;
    font-family:'Inter',Arial,sans-serif;
    background:
        radial-gradient(circle at 86% 4%,rgba(226,201,151,.06),transparent 28%),
        radial-gradient(circle at 4% 96%,rgba(226,201,151,.025),transparent 24%),
        var(--bg-primary);
    color:var(--text-primary);
    overflow-x:hidden;
    line-height:1.65;
    font-size:15px;
    -webkit-font-smoothing:antialiased;
    text-rendering:optimizeLegibility;
}

button,input,textarea,select{font:inherit}
button,a,input,textarea,select{-webkit-tap-highlight-color:transparent}
::selection{background:rgba(226,201,151,.24);color:var(--text-primary)}

/* ===== LAYOUT ===== */
.admin-main{
    width:calc(100% - var(--sidebar-width));
    min-height:100vh;
    margin-left:var(--sidebar-width);
    padding:52px 54px 76px;
}

.page-header{margin-bottom:30px}
.breadcrumb{
    display:flex;
    align-items:center;
    gap:9px;
    margin-bottom:15px;
    color:var(--text-dim);
    font-size:13px;
    font-weight:600;
}
.breadcrumb span:first-child{
    display:inline-flex;
    align-items:center;
    gap:8px;
    color:var(--accent-dark);
}
.breadcrumb .separator{font-size:9px;opacity:.65}
.header-content{display:flex;align-items:flex-end;justify-content:space-between;gap:24px}
.page-eyebrow{
    display:inline-flex;
    align-items:center;
    margin-bottom:8px;
    color:var(--accent);
    font-size:12px;
    font-weight:800;
    letter-spacing:2.2px;
    text-transform:uppercase;
}
.page-title{
    margin:0;
    font-family:'Playfair Display',Georgia,serif;
    font-size:clamp(42px,4vw,58px);
    line-height:1.08;
    letter-spacing:-1px;
    font-weight:700;
    background:linear-gradient(135deg,var(--accent) 0%,#f8f4ed 50%,var(--accent-dark) 100%);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
}
.page-description{
    max-width:760px;
    margin-top:11px;
    color:var(--text-muted);
    font-size:16px;
    line-height:1.75;
}

/* ===== MOBILE HEADER ===== */
.mobile-header{display:none}
.mobile-menu-button{
    width:48px;
    height:48px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(226,201,151,.22);
    border-radius:14px;
    background:rgba(18,18,18,.92);
    color:var(--accent);
    box-shadow:0 14px 35px rgba(0,0,0,.35);
    backdrop-filter:blur(18px);
    cursor:pointer;
}
.mobile-menu-button:hover{border-color:rgba(226,201,151,.48);background:rgba(226,201,151,.08)}

/* ===== ALERT ===== */
.alert{
    position:relative;
    display:flex;
    align-items:flex-start;
    gap:14px;
    margin-bottom:24px;
    padding:18px 20px;
    border:1px solid rgba(239,68,68,.16);
    border-left:3px solid #ef4444;
    border-radius:18px;
    background:rgba(239,68,68,.045);
    box-shadow:var(--shadow-soft);
}
.alert-icon{
    width:38px;height:38px;flex:0 0 38px;
    display:flex;align-items:center;justify-content:center;
    border:1px solid rgba(239,68,68,.13);
    border-radius:12px;
    background:rgba(239,68,68,.08);
    color:#f87171;
}
.alert-body{flex:1;min-width:0}
.alert-body strong{display:block;margin-bottom:4px;color:#f87171;font-size:14px;font-weight:800}
.alert-body p{margin:0 0 8px;color:var(--text-muted);font-size:14px}
.alert-body ul{margin:0;padding-left:19px;color:var(--text-secondary);font-size:14px;line-height:1.65}
.alert-close{
    width:38px;height:38px;flex:0 0 38px;
    border:1px solid var(--border-soft);
    border-radius:11px;
    background:rgba(255,255,255,.025);
    color:var(--text-muted);
    cursor:pointer;
}
.alert-close:hover{color:var(--accent);border-color:var(--border-gold);background:rgba(226,201,151,.06)}

/* ===== FORM LAYOUT ===== */
.form-layout{
    display:grid;
    grid-template-columns:minmax(0,1.55fr) minmax(340px,.82fr);
    align-items:start;
    gap:24px;
}
.form-main-card,.image-card,.info-card{
    border:1px solid var(--border-gold);
    border-radius:var(--radius-lg);
    background:
        linear-gradient(145deg,rgba(255,255,255,.045),rgba(255,255,255,.014)),
        rgba(18,18,18,.88);
    box-shadow:var(--shadow-soft);
    backdrop-filter:blur(24px);
    -webkit-backdrop-filter:blur(24px);
}
.form-main-card,.image-card{overflow:hidden}
.form-main-card::before,.image-card::before,.info-card::before{
    content:"";
    display:block;
    height:1px;
    background:linear-gradient(90deg,transparent,rgba(226,201,151,.35),transparent);
}
.card-header{
    display:flex;align-items:center;gap:13px;
    padding:22px 24px;
    border-bottom:1px solid rgba(226,201,151,.08);
}
.card-header-icon{
    width:42px;height:42px;flex:0 0 42px;
    display:flex;align-items:center;justify-content:center;
    border:1px solid rgba(226,201,151,.17);
    border-radius:13px;
    background:rgba(226,201,151,.075);
    color:var(--accent);
    font-size:16px;
}
.card-header h2{margin:0 0 3px;color:var(--text-primary);font-family:'Playfair Display',Georgia,serif;font-size:21px;font-weight:700;line-height:1.25}
.card-header p{margin:0;color:var(--text-muted);font-size:13px;line-height:1.6}
.card-body{padding:30px 26px 32px}

/* ===== FORM ===== */
.form-group{margin-bottom:24px}
.form-group:last-child{margin-bottom:0}
.form-group label{
    display:flex;align-items:center;gap:8px;
    margin-bottom:10px;
    color:var(--text-primary);
    font-size:15px;
    line-height:1.45;
    font-weight:800;
}
.label-icon{color:var(--accent);font-size:13px}
.required{color:#ef8d84;font-size:15px}
.input-wrapper,.textarea-wrapper{position:relative}
.input-wrapper input,.textarea-wrapper textarea{
    width:100%;
    border:1px solid rgba(255,255,255,.075);
    outline:none;
    background:rgba(255,255,255,.032);
    color:var(--text-primary);
    transition:all var(--transition);
}
.input-wrapper input{
    height:58px;
    padding:0 17px;
    border-radius:15px;
    font-size:16px;
}
.textarea-wrapper textarea{
    min-height:190px;
    padding:16px 18px 40px;
    border-radius:15px;
    resize:vertical;
    font-size:16px;
    line-height:1.75;
}
.input-wrapper input::placeholder,.textarea-wrapper textarea::placeholder{color:var(--text-dim);opacity:1}
.input-wrapper input:focus,.textarea-wrapper textarea:focus{
    border-color:rgba(226,201,151,.55);
    background:rgba(226,201,151,.04);
    box-shadow:0 0 0 4px rgba(226,201,151,.065);
}
.input-counter,.textarea-counter{position:absolute;right:14px;color:var(--text-dim);font-size:12px}
.input-counter{top:50%;transform:translateY(-50%)}
.textarea-counter{bottom:12px}
.input-counter.warning{color:#f6b453}
.field-hint,.field-error{
    display:flex;align-items:flex-start;gap:7px;
    margin-top:8px;
    font-size:13px;
    line-height:1.55;
}
.field-hint{color:var(--text-dim)}
.field-error{color:#f58f8f}

/* ===== RIGHT SIDE / IMAGE ===== */
.form-side{display:flex;flex-direction:column;gap:16px}
.image-card-body{padding:20px}
.image-preview{
    position:relative;width:100%;aspect-ratio:16/10;
    margin-bottom:14px;overflow:hidden;
    border:1px solid rgba(226,201,151,.14);
    border-radius:18px;
    background:
        radial-gradient(circle at 50% 0%,rgba(226,201,151,.06),transparent 42%),
        #0f0f0f;
}
.preview-empty{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:7px;color:var(--text-dim);text-align:center;padding:20px}
.preview-empty.hidden{display:none}
.preview-icon{
    width:58px;height:58px;
    display:flex;align-items:center;justify-content:center;
    margin-bottom:5px;
    border:1px solid rgba(226,201,151,.16);
    border-radius:17px;
    background:rgba(226,201,151,.07);
    color:var(--accent);
    font-size:22px;
}
.preview-empty strong{color:var(--text-secondary);font-size:15px;font-weight:800}
.preview-empty span{max-width:230px;color:var(--text-dim);font-size:13px;line-height:1.55}
#previewImage{display:none;width:100%;height:100%;object-fit:cover}
#previewImage.show{display:block}
.remove-image{
    position:absolute;top:12px;right:12px;z-index:2;
    width:42px;height:42px;display:none;align-items:center;justify-content:center;
    border:1px solid rgba(255,255,255,.15);border-radius:12px;
    background:rgba(0,0,0,.62);color:#fff;cursor:pointer;
    backdrop-filter:blur(8px);
}
.remove-image.show{display:flex}
.remove-image:hover{background:rgba(180,72,72,.8);border-color:rgba(240,170,170,.45)}
.upload-area{
    position:relative;min-height:150px;
    display:flex;flex-direction:column;align-items:center;justify-content:center;
    padding:24px;
    border:1px dashed rgba(226,201,151,.28);
    border-radius:18px;
    background:
        radial-gradient(circle at 50% 0%,rgba(226,201,151,.06),transparent 46%),
        rgba(255,255,255,.018);
    text-align:center;cursor:pointer;transition:all var(--transition);
}
.upload-area input{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer}
.upload-area:hover,.upload-area.dragging{border-color:rgba(226,201,151,.65);background:rgba(226,201,151,.05);transform:translateY(-1px)}
.upload-area.selected{border-color:rgba(127,201,149,.45);background:rgba(127,201,149,.03)}
.upload-icon{
    width:60px;height:60px;margin-bottom:13px;
    display:flex;align-items:center;justify-content:center;
    border:1px solid rgba(226,201,151,.16);border-radius:17px;
    background:rgba(226,201,151,.07);color:var(--accent);font-size:23px;
}
.upload-area strong{max-width:320px;overflow:hidden;color:var(--text-primary);font-size:16px;font-weight:800;text-overflow:ellipsis;white-space:nowrap}
.upload-area span{margin-top:5px;color:var(--text-muted);font-size:14px}
.upload-area small{margin-top:10px;color:var(--text-dim);font-size:12px;line-height:1.55}
.info-card{display:flex;align-items:flex-start;gap:12px;padding:18px 19px}
.info-icon{
    width:40px;height:40px;flex:0 0 40px;
    display:flex;align-items:center;justify-content:center;
    border:1px solid rgba(226,201,151,.14);border-radius:12px;
    background:rgba(226,201,151,.07);color:var(--accent);font-size:14px;
}
.info-card strong{display:block;margin-bottom:4px;color:var(--text-secondary);font-size:14px}
.info-card p{margin:0;color:var(--text-muted);font-size:13px;line-height:1.65}

/* ===== ACTIONS ===== */
.form-actions{
    display:flex;justify-content:flex-end;align-items:center;gap:12px;
    margin-top:24px;padding-top:22px;border-top:1px solid rgba(226,201,151,.09);
}
.cancel-button,.save-button{
    min-height:56px;display:inline-flex;align-items:center;justify-content:center;gap:8px;
    padding:0 24px;border-radius:var(--radius-full);font-size:15px;font-weight:800;
    text-decoration:none;cursor:pointer;transition:all var(--transition);
}
.cancel-button{border:1px solid var(--border-gold);background:rgba(226,201,151,.045);color:var(--text-secondary)}
.cancel-button:hover{border-color:rgba(226,201,151,.44);background:rgba(226,201,151,.10);color:var(--accent);transform:translateY(-2px)}
.save-button{
    min-width:175px;border:1px solid rgba(226,201,151,.18);
    background:linear-gradient(135deg,var(--accent),var(--accent-hover));
    color:var(--bg-primary);box-shadow:0 14px 35px rgba(0,0,0,.25)
}
.save-button:hover:not(:disabled){background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark));transform:translateY(-3px);box-shadow:var(--shadow-hover)}
.save-button:disabled{opacity:.65;cursor:wait}
.button-loading{display:none;align-items:center;gap:8px}

/* ===== RESPONSIVE ===== */
@media (min-width:1400px){
    :root{--sidebar-width:290px}
    .admin-main{padding:60px 68px 82px}
    .form-layout{grid-template-columns:minmax(0,1.6fr) minmax(390px,.84fr);gap:28px}
    .card-body{padding:32px 30px 34px}
}

@media (min-width:901px) and (max-width:1199px){
    :root{--sidebar-width:270px}
    .admin-main{padding:42px 28px 60px}
    .page-title{font-size:44px}
    .page-description{font-size:15px}
    .form-layout{grid-template-columns:minmax(0,1.45fr) minmax(300px,.85fr);gap:20px}
}

@media (max-width:1000px) and (min-width:901px){
    .header-content{align-items:flex-start}
    .form-layout{grid-template-columns:1fr}
    .form-side{display:grid;grid-template-columns:1fr 1fr;align-items:start}
}

@media (max-width:900px){
    .admin-main{width:100%;margin-left:0;padding:92px 24px 48px}
    .mobile-header{
        position:fixed;top:0;left:0;right:0;z-index:2000;
        height:70px;display:flex;align-items:center;justify-content:space-between;
        padding:0 20px;border-bottom:1px solid var(--border-soft);
        background:rgba(9,9,9,.90);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px)
    }
    .mobile-brand{display:flex;align-items:center;gap:5px;font-family:'Playfair Display',Georgia,serif;font-size:18px}
    .mobile-brand span{color:var(--text-primary)}
    .mobile-brand strong{color:var(--accent)}
    .page-header{margin-bottom:26px}
    .page-title{font-size:45px}
    .page-description{font-size:15px}
    .form-layout{grid-template-columns:1fr;gap:18px}
}

@media (max-width:640px){
    .admin-main{padding:86px 15px 36px}
    .mobile-header{height:66px;padding:0 15px}
    .mobile-menu-button{width:46px;height:46px}
    .breadcrumb{font-size:12px;gap:7px}
    .page-eyebrow{font-size:11px;letter-spacing:1.8px}
    .page-title{font-size:37px;letter-spacing:-.65px}
    .page-description{font-size:14px;line-height:1.72}
    .alert{padding:15px;gap:11px}
    .alert-icon{width:36px;height:36px;flex-basis:36px}
    .alert-body strong{font-size:13px}
    .alert-body p,.alert-body ul{font-size:13px}
    .form-main-card,.image-card,.info-card{border-radius:21px}
    .card-header{padding:18px}
    .card-header-icon{width:38px;height:38px;flex-basis:38px;border-radius:11px}
    .card-header h2{font-size:20px}
    .card-header p{font-size:13px}
    .card-body{padding:22px 18px 24px}
    .form-group{margin-bottom:21px}
    .form-group label{font-size:15px;margin-bottom:9px}
    .input-wrapper input{height:56px;font-size:15px}
    .textarea-wrapper textarea{min-height:155px;font-size:15px}
    .field-hint,.field-error{font-size:13px}
    .image-card-body{padding:16px}
    .image-preview{aspect-ratio:16/9}
    .upload-area{min-height:142px;padding:20px}
    .upload-icon{width:54px;height:54px}
    .upload-area strong{font-size:15px}
    .upload-area span{font-size:13px}
    .upload-area small{font-size:12px}
    .info-card{padding:15px}
    .info-card strong{font-size:14px}
    .info-card p{font-size:13px}
    .form-side{display:flex;flex-direction:column}
    .form-actions{display:grid;grid-template-columns:1fr 1.35fr;gap:8px;position:sticky;bottom:0;z-index:20;margin:0 -15px;padding:11px 15px;background:rgba(9,9,9,.92);backdrop-filter:blur(15px);-webkit-backdrop-filter:blur(15px)}
    .cancel-button,.save-button{width:100%;min-height:54px;padding:0 12px;font-size:14px}
    .save-button{min-width:0}
}

@media (max-width:380px){
    .admin-main{padding-left:11px;padding-right:11px}
    .mobile-header{padding-left:12px;padding-right:12px}
    .page-title{font-size:33px}
    .page-description{font-size:13.5px}
    .card-body{padding-left:15px;padding-right:15px}
    .form-actions{margin-left:-11px;margin-right:-11px;padding-left:11px;padding-right:11px}
}

@media (prefers-reduced-motion:reduce){
    *,*::before,*::after{scroll-behavior:auto!important;transition:none!important;animation:none!important}
}
</style>


    <style>
        /* =========================================================
           SIDEBAR MOBILE — REFERENSI TRANSparan, TIDAK TERPOTONG
           Mengikuti struktur sidebar Admin.partials.sidebar
        ========================================================== */

        @media (max-width:900px){
            html,
            body{
                width:100%;
                min-height:100%;
            }

            body{
                overflow-x:hidden;
            }

            .admin-sidebar{
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
                        rgba(18,18,18,.86) 0%,
                        rgba(10,10,10,.82) 100%
                    ) !important;

                backdrop-filter:blur(20px) saturate(115%) !important;
                -webkit-backdrop-filter:blur(20px) saturate(115%) !important;

                box-shadow:
                    20px 0 60px rgba(0,0,0,.40),
                    0 12px 40px rgba(0,0,0,.22) !important;

                overflow:hidden !important;

                transform:translate3d(calc(-100% - 18px),0,0) !important;

                z-index:2100 !important;
            }

            .admin-sidebar.open{
                transform:translate3d(0,0,0) !important;
            }

            .admin-sidebar-brand{
                position:relative;
                padding:18px 14px 13px !important;
                border-bottom:1px solid rgba(255,255,255,.055);
                background:rgba(0,0,0,.08);
            }

            .admin-sidebar-close-button{
                display:flex !important;
                top:14px !important;
                right:13px !important;

                width:40px !important;
                height:40px !important;

                border:1px solid rgba(226,201,151,.13) !important;
                border-radius:11px !important;

                background:rgba(255,255,255,.035) !important;
                color:var(--admin-accent,#e2c997) !important;
            }

            .admin-brand-link{
                gap:11px !important;
                padding-right:52px;
            }

            .admin-brand-logo{
                width:45px !important;
                height:45px !important;
                flex-basis:45px !important;
                border-radius:12px !important;
            }

            .admin-brand-text strong{
                font-size:18px !important;
            }

            .admin-brand-text span{
                margin-top:4px !important;
                font-size:8.5px !important;
            }

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
                flex-basis:40px !important;
            }

            .admin-user-info strong{
                font-size:14px !important;
            }

            .admin-user-info span{
                font-size:12px !important;
            }

            .admin-sidebar-nav{
                padding:0 10px 8px !important;
                overflow-x:hidden !important;
                overflow-y:auto !important;
                min-height:0 !important;
            }

            .admin-nav-title{
                margin:15px 9px 7px !important;
                font-size:10px !important;
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
                flex-basis:36px !important;
                font-size:13px !important;
            }

            .admin-nav-text{
                font-size:14.5px !important;
            }

            .admin-sidebar-footer{
                padding:10px 12px max(12px, env(safe-area-inset-bottom)) !important;
                border-top:1px solid rgba(255,255,255,.055) !important;
                background:rgba(0,0,0,.22) !important;
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

            .admin-sidebar-overlay{
                z-index:2050 !important;
                background:rgba(0,0,0,.46) !important;
                backdrop-filter:blur(3px) !important;
                -webkit-backdrop-filter:blur(3px) !important;
            }

            .mobile-header{
                position:fixed !important;
                top:0 !important;
                left:0 !important;
                right:0 !important;

                height:68px !important;
                z-index:2000 !important;

                display:flex !important;
                align-items:center !important;
                justify-content:flex-start !important;

                padding:0 14px !important;

                border-bottom:1px solid rgba(255,255,255,.055) !important;

                background:
                    linear-gradient(
                        180deg,
                        rgba(10,10,10,.90),
                        rgba(10,10,10,.72)
                    ) !important;

                backdrop-filter:blur(16px) !important;
                -webkit-backdrop-filter:blur(16px) !important;
            }

            .mobile-menu-button{
                width:46px !important;
                height:46px !important;

                display:inline-flex !important;
                align-items:center !important;
                justify-content:center !important;

                border:1px solid rgba(226,201,151,.20) !important;
                border-radius:13px !important;

                background:rgba(255,255,255,.035) !important;
                color:#e2c997 !important;

                box-shadow:0 10px 28px rgba(0,0,0,.20) !important;
            }
        }

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

            .mobile-header{
                height:64px !important;
                padding:0 12px !important;
            }

            .mobile-menu-button{
                width:46px !important;
                height:46px !important;
            }
        }

        @media (max-width:380px){
            .admin-sidebar{
                width:min(305px, calc(100vw - 16px)) !important;
                left:8px !important;
                top:8px !important;
                bottom:8px !important;
                height:calc(100dvh - 16px) !important;
                max-height:calc(100dvh - 16px) !important;
            }
        }

        @media (prefers-reduced-motion:reduce){
            .admin-sidebar,
            .admin-sidebar-overlay{
                transition:none !important;
            }
        }
    </style>



<style id="tambah-event-no-topbar-final">
/* =========================================================
   TAMBAH EVENT — MOBILE HAMBURGER
   TANPA TOPBAR / TANPA "NOYO GIMBAL"
========================================================= */

@media (max-width:900px){

    /* Pastikan bar lama benar-benar tidak tampil */
    .mobile-header{
        display:none !important;
    }

    /* Hamburger berdiri sendiri di atas halaman */
    .admin-mobile-menu-button{
        position:fixed !important;

        top:16px !important;
        left:16px !important;

        width:48px !important;
        height:48px !important;

        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        flex-direction:column !important;
        gap:5px !important;

        margin:0 !important;
        padding:0 !important;

        z-index:2200 !important;

        border:1px solid rgba(226,201,151,.22) !important;
        border-radius:14px !important;

        background:
            linear-gradient(
                145deg,
                rgba(226,201,151,.10),
                rgba(255,255,255,.025)
            ),
            rgba(12,12,12,.86) !important;

        color:#e2c997 !important;

        box-shadow:
            0 14px 38px rgba(0,0,0,.34),
            inset 0 1px 0 rgba(255,255,255,.04) !important;

        backdrop-filter:blur(18px) !important;
        -webkit-backdrop-filter:blur(18px) !important;

        cursor:pointer !important;

        transition:
            transform .22s ease,
            border-color .22s ease,
            background .22s ease,
            opacity .22s ease !important;
    }

    .admin-mobile-menu-button:hover{
        transform:translateY(-1px) !important;

        border-color:rgba(226,201,151,.48) !important;

        background:
            linear-gradient(
                145deg,
                rgba(226,201,151,.15),
                rgba(255,255,255,.035)
            ),
            rgba(15,15,15,.92) !important;
    }

    .admin-mobile-menu-button:focus-visible{
        outline:2px solid rgba(226,201,151,.78) !important;
        outline-offset:3px !important;
    }

    .admin-mobile-menu-button span{
        display:block !important;

        width:20px !important;
        height:2px !important;

        border-radius:999px !important;

        background:currentColor !important;
    }

    /* Hilangkan tombol ketika drawer sidebar sedang terbuka */
    body.admin-sidebar-open .admin-mobile-menu-button,
    body.sidebar-open .admin-mobile-menu-button{
        opacity:0 !important;
        pointer-events:none !important;
        transform:translateY(-8px) !important;
    }

    /* Tidak ada ruang bekas topbar */
    .admin-main{
        padding-top:90px !important;
    }
}

@media (max-width:640px){

    .admin-mobile-menu-button{
        top:13px !important;
        left:13px !important;

        width:46px !important;
        height:46px !important;
    }

    .admin-main{
        padding-top:84px !important;
    }
}

@media (max-width:380px){

    .admin-mobile-menu-button{
        top:11px !important;
        left:11px !important;

        width:44px !important;
        height:44px !important;
    }

    .admin-main{
        padding-top:80px !important;
    }
}

/* Desktop: tombol mobile tidak ikut muncul */
@media (min-width:901px){
    .admin-mobile-menu-button{
        display:none !important;
    }
}
</style>

</head>


<body>


    {{-- =========================================================
        SIDEBAR
    ========================================================== --}}

    @include('Admin.partials.sidebar')


    {{-- =========================================================
        MAIN
    ========================================================== --}}

    <main class="admin-main">


        {{-- =====================================================
            MOBILE HEADER
        ====================================================== --}}

        
    <button
        type="button"
        class="admin-mobile-menu-button"
        id="openAdminSidebar"
        aria-controls="adminSidebar"
        aria-expanded="false"
        aria-label="Buka menu navigasi"
        title="Buka menu"
    >
        <span></span>
        <span></span>
        <span></span>
    </button>

{{-- =====================================================
            PAGE HEADER
        ====================================================== --}}

        <section class="page-header">

<div class="header-content">

                <div>
<h1 class="page-title">
                        Tambah Event
                    </h1>

                    <p class="page-description">
                        Tambahkan event yang akan datang
                        ke dalam sistem Noyo Gimbal.
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
            VALIDATION ERROR
        ====================================================== --}}

        @if($errors->any())

            <div class="alert alert-danger">

                <div class="alert-icon">

                    <i class="fas fa-circle-exclamation"></i>

                </div>


                <div class="alert-body">

                    <strong>
                        Data belum dapat disimpan
                    </strong>

                    <p>
                        Silakan periksa kembali data berikut:
                    </p>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>


                <button
                    type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove()"
                >

                    <i class="fas fa-xmark"></i>

                </button>

            </div>

        @endif


        {{-- =====================================================
            FORM
        ====================================================== --}}

        <form
            action="{{ route('admin.event.store') }}"
            method="POST"
            enctype="multipart/form-data"
            id="eventForm"
        >

            @csrf


            <div class="form-layout">


                {{-- =================================================
                    INFORMASI EVENT
                ================================================== --}}

                <div class="form-main-card">


                    <div class="card-header">

                        <div class="card-header-icon">

                            <i class="fas fa-calendar-plus"></i>

                        </div>


                        <div>

                            <h2>
                                Informasi Event
                            </h2>

                            <p>
                                Masukkan informasi utama event.
                            </p>

                        </div>

                    </div>


                    <div class="card-body">


                        {{-- JUDUL --}}

                        <div class="form-group">

                            <label for="judul">

                                <span class="label-icon">
                                    <i class="fas fa-heading"></i>
                                </span>

                                Judul Event

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <div class="input-wrapper">

                                <input
                                    type="text"
                                    id="judul"
                                    name="judul"
                                    value="{{ old('judul') }}"
                                    placeholder="Contoh: Festival Noyo Gimbal 2026"
                                    maxlength="255"
                                    autocomplete="off"
                                    required
                                >


                                <span
                                    class="input-counter"
                                    id="judulCounter"
                                >
                                    0 / 255
                                </span>

                            </div>


                            @error('judul')

                                <span class="field-error">

                                    <i class="fas fa-circle-exclamation"></i>

                                    {{ $message }}

                                </span>

                            @enderror

                        </div>


                        {{-- TANGGAL --}}

                        <div class="form-group">

                            <label for="tanggal">

                                <span class="label-icon">
                                    <i class="far fa-calendar"></i>
                                </span>

                                Tanggal Event

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <div class="input-wrapper date-wrapper">

                                <input
                                    type="date"
                                    id="tanggal"
                                    name="tanggal"
                                    value="{{ old('tanggal') }}"\n                                    min="{{ now()->format('Y-m-d') }}"
                                    required
                                >

                            </div>


                            <span class="field-hint">

                                <i class="fas fa-circle-info"></i>

                                Masukkan tanggal pelaksanaan atau tanggal
                                publikasi berita.

                            </span>


                            @error('tanggal')

                                <span class="field-error">

                                    <i class="fas fa-circle-exclamation"></i>

                                    {{ $message }}

                                </span>

                            @enderror

                        </div>


                        {{-- DESKRIPSI --}}

                        <div class="form-group">

                            <label for="deskripsi">

                                <span class="label-icon">
                                    <i class="fas fa-align-left"></i>
                                </span>

                                Deskripsi

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <div class="textarea-wrapper">

                                <textarea
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="8"
                                    placeholder="Tuliskan informasi lengkap mengenai event..."
                                    required
                                >{{ old('deskripsi') }}</textarea>


                                <span
                                    class="textarea-counter"
                                    id="deskripsiCounter"
                                >
                                    0 karakter
                                </span>

                            </div>


                            @error('deskripsi')

                                <span class="field-error">

                                    <i class="fas fa-circle-exclamation"></i>

                                    {{ $message }}

                                </span>

                            @enderror

                        </div>


                    </div>

                </div>


                {{-- =================================================
                    POSTER
                ================================================== --}}

                <div class="form-side">


                    <div class="image-card">


                        <div class="card-header">

                            <div class="card-header-icon">

                                <i class="fas fa-image"></i>

                            </div>


                            <div>

                                <h2>
                                    Poster Event
                                </h2>

                                <p>
                                    Tambahkan gambar event.
                                </p>

                            </div>

                        </div>


                        <div class="image-card-body">


                            {{-- PREVIEW --}}

                            <div
                                class="image-preview"
                                id="imagePreview"
                            >

                                <div
                                    class="preview-empty"
                                    id="previewEmpty"
                                >

                                    <div class="preview-icon">

                                        <i class="fas fa-image"></i>

                                    </div>

                                    <strong>
                                        Belum ada gambar
                                    </strong>

                                    <span>
                                        Preview poster akan muncul di sini
                                    </span>

                                </div>


                                <img
                                    src=""
                                    alt="Preview"
                                    id="previewImage"
                                >


                                <button
                                    type="button"
                                    class="remove-image"
                                    id="removeImage"
                                >

                                    <i class="fas fa-xmark"></i>

                                </button>

                            </div>


                            {{-- UPLOAD --}}

                            <label
                                for="gambar"
                                class="upload-area"
                                id="uploadArea"
                            >

                                <input
                                    type="file"
                                    id="gambar"
                                    name="gambar"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                >


                                <div class="upload-icon">

                                    <i class="fas fa-cloud-arrow-up"></i>

                                </div>


                                <strong id="uploadTitle">
                                    Pilih gambar
                                </strong>


                                <span id="uploadDescription">
                                    Klik untuk memilih poster event
                                </span>


                                <small>
                                    JPG, JPEG, PNG, WEBP
                                    <br>
                                    Maksimal 2 MB
                                </small>

                            </label>


                            @error('gambar')

                                <span class="field-error">

                                    <i class="fas fa-circle-exclamation"></i>

                                    {{ $message }}

                                </span>

                            @enderror


                        </div>

                    </div>


                    {{-- =================================================
                        TIPS
                    ================================================== --}}

                    <div class="info-card">

                        <div class="info-icon">

                            <i class="fas fa-lightbulb"></i>

                        </div>


                        <div>

                            <strong>
                                Tips
                            </strong>

                            <p>
                                Gunakan gambar poster dengan kualitas
                                yang baik agar tampil menarik pada
                                halaman publik.
                            </p>

                        </div>

                    </div>


                </div>

            </div>


            {{-- =====================================================
                ACTION
            ====================================================== --}}

            <div class="form-actions">


                <a
                    href="{{ route('admin.event.index') }}"
                    class="cancel-button"
                >

                    <i class="fas fa-xmark"></i>

                    Batal

                </a>


                <button
                    type="submit"
                    class="save-button"
                    id="saveButton"
                >

                    <span
                        class="button-normal"
                        id="buttonNormal"
                    >

                        <i class="fas fa-check"></i>

                        Simpan Event

                    </span>


                    <span
                        class="button-loading"
                        id="buttonLoading"
                    >

                        <i class="fas fa-spinner fa-spin"></i>

                        Menyimpan...

                    </span>

                </button>

            </div>

        </form>


    </main>


    {{-- =============================================================
        JAVASCRIPT
    ============================================================= --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | ELEMENTS
        |--------------------------------------------------------------------------
        */

        const eventForm =
            document.getElementById('eventForm');

        const judulInput =
            document.getElementById('judul');

        const judulCounter =
            document.getElementById('judulCounter');

        const deskripsiInput =
            document.getElementById('deskripsi');

        const deskripsiCounter =
            document.getElementById('deskripsiCounter');

        const gambarInput =
            document.getElementById('gambar');

        const previewEmpty =
            document.getElementById('previewEmpty');

        const previewImage =
            document.getElementById('previewImage');

        const removeImage =
            document.getElementById('removeImage');

        const uploadArea =
            document.getElementById('uploadArea');

        const uploadTitle =
            document.getElementById('uploadTitle');

        const uploadDescription =
            document.getElementById('uploadDescription');

        const saveButton =
            document.getElementById('saveButton');

        const buttonNormal =
            document.getElementById('buttonNormal');

        const buttonLoading =
            document.getElementById('buttonLoading');


        /*
        |--------------------------------------------------------------------------
        | JUDUL COUNTER
        |--------------------------------------------------------------------------
        */

        function updateJudulCounter()
        {
            const length =
                judulInput.value.length;

            judulCounter.textContent =
                `${length} / 255`;

            if (length >= 230) {

                judulCounter.classList.add(
                    'warning'
                );

            } else {

                judulCounter.classList.remove(
                    'warning'
                );

            }
        }


        judulInput.addEventListener(
            'input',
            updateJudulCounter
        );


        /*
        |--------------------------------------------------------------------------
        | DESKRIPSI COUNTER
        |--------------------------------------------------------------------------
        */

        function updateDeskripsiCounter()
        {
            const length =
                deskripsiInput.value.length;

            deskripsiCounter.textContent =
                `${length} karakter`;
        }


        deskripsiInput.addEventListener(
            'input',
            updateDeskripsiCounter
        );


        /*
        |--------------------------------------------------------------------------
        | IMAGE UPLOAD
        |--------------------------------------------------------------------------
        */

        gambarInput.addEventListener(
            'change',
            function ()
            {

                const file =
                    this.files[0];


                if (!file) {

                    resetImage();

                    return;
                }


                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];


                if (
                    !allowedTypes.includes(
                        file.type
                    )
                ) {

                    alert(
                        'Format gambar tidak didukung. Gunakan JPG, JPEG, PNG, atau WEBP.'
                    );

                    this.value = '';

                    resetImage();

                    return;
                }


                const maxSize =
                    2 * 1024 * 1024;


                if (file.size > maxSize) {

                    alert(
                        'Ukuran gambar terlalu besar. Maksimal 2 MB.'
                    );

                    this.value = '';

                    resetImage();

                    return;
                }


                const reader =
                    new FileReader();


                reader.onload =
                    function (event)
                    {

                        previewImage.src =
                            event.target.result;


                        previewImage.classList.add(
                            'show'
                        );


                        previewEmpty.classList.add(
                            'hidden'
                        );


                        removeImage.classList.add(
                            'show'
                        );


                        uploadArea.classList.add(
                            'selected'
                        );


                        uploadTitle.textContent =
                            file.name;


                        uploadDescription.textContent =
                            formatFileSize(
                                file.size
                            );

                    };


                reader.readAsDataURL(file);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | REMOVE IMAGE
        |--------------------------------------------------------------------------
        */

        removeImage.addEventListener(
            'click',
            function (event)
            {

                event.preventDefault();

                event.stopPropagation();

                gambarInput.value = '';

                resetImage();

            }
        );


        function resetImage()
        {

            previewImage.src = '';

            previewImage.classList.remove(
                'show'
            );

            previewEmpty.classList.remove(
                'hidden'
            );

            removeImage.classList.remove(
                'show'
            );

            uploadArea.classList.remove(
                'selected'
            );

            uploadTitle.textContent =
                'Pilih gambar';

            uploadDescription.textContent =
                'Klik untuk memilih poster event';

        }


        /*
        |--------------------------------------------------------------------------
        | FILE SIZE
        |--------------------------------------------------------------------------
        */

        function formatFileSize(bytes)
        {

            if (bytes < 1024) {

                return bytes + ' B';

            }


            if (bytes < 1024 * 1024) {

                return (
                    bytes / 1024
                ).toFixed(1) + ' KB';

            }


            return (
                bytes /
                (1024 * 1024)
            ).toFixed(2) + ' MB';

        }


        /*
        |--------------------------------------------------------------------------
        | DRAG & DROP
        |--------------------------------------------------------------------------
        */

        [
            'dragenter',
            'dragover'
        ].forEach(
            function (eventName)
            {

                uploadArea.addEventListener(
                    eventName,
                    function (event)
                    {

                        event.preventDefault();

                        uploadArea.classList.add(
                            'dragging'
                        );

                    }
                );

            }
        );


        [
            'dragleave',
            'drop'
        ].forEach(
            function (eventName)
            {

                uploadArea.addEventListener(
                    eventName,
                    function (event)
                    {

                        event.preventDefault();

                        uploadArea.classList.remove(
                            'dragging'
                        );

                    }
                );

            }
        );


        uploadArea.addEventListener(
            'drop',
            function (event)
            {

                const files =
                    event.dataTransfer.files;


                if (!files.length) {

                    return;

                }


                gambarInput.files =
                    files;


                gambarInput.dispatchEvent(
                    new Event('change')
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | FORM SUBMIT
        |--------------------------------------------------------------------------
        */

        eventForm.addEventListener(
            'submit',
            function (event)
            {

                if (
                    saveButton.disabled
                ) {

                    event.preventDefault();

                    return;

                }


                saveButton.disabled =
                    true;


                buttonNormal.style.display =
                    'none';


                buttonLoading.style.display =
                    'inline-flex';

            }
        );


        /*
        |--------------------------------------------------------------------------
        | INITIAL VALUE
        |--------------------------------------------------------------------------
        */

        updateJudulCounter();

        updateDeskripsiCounter();


        /*
        |--------------------------------------------------------------------------
        | CLOSE SIDEBAR
        |--------------------------------------------------------------------------
        */
</script>


    {{-- =============================================================
        STYLE
    ============================================================= --}}

    

<script>
document.addEventListener('DOMContentLoaded', function () {

    const openButton = document.getElementById('openAdminSidebar');

    if (!openButton) {
        return;
    }

    openButton.addEventListener('click', function () {

        /*
         * Gunakan fungsi sidebar bawaan apabila partial sidebar
         * sudah menyediakannya.
         */
        if (typeof window.openAdminSidebar === 'function') {
            window.openAdminSidebar();
            return;
        }

        /*
         * Fallback agar tombol tetap bekerja.
         */
        const sidebar = document.getElementById('adminSidebar');

        const overlay =
            document.querySelector('.admin-sidebar-overlay') ||
            document.getElementById('adminSidebarOverlay') ||
            document.getElementById('sidebarOverlay');

        if (sidebar) {
            sidebar.classList.add('open');
        }

        if (overlay) {
            overlay.classList.add('show');
            overlay.classList.add('visible');
        }

        document.body.classList.add('admin-sidebar-open');
        document.body.classList.add('sidebar-open');

        openButton.setAttribute('aria-expanded', 'true');
    });

    /*
     * Klik overlay menutup sidebar pada fallback.
     */
    document.addEventListener('click', function (event) {

        const overlay = event.target.closest(
            '.admin-sidebar-overlay, #adminSidebarOverlay, #sidebarOverlay'
        );

        if (!overlay) {
            return;
        }

        const sidebar = document.getElementById('adminSidebar');

        if (sidebar) {
            sidebar.classList.remove('open');
        }

        overlay.classList.remove('show');
        overlay.classList.remove('visible');

        document.body.classList.remove('admin-sidebar-open');
        document.body.classList.remove('sidebar-open');

        openButton.setAttribute('aria-expanded', 'false');
    });

    /*
     * ESC untuk menutup drawer.
     */
    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        const sidebar = document.getElementById('adminSidebar');

        if (sidebar) {
            sidebar.classList.remove('open');
        }

        document.querySelectorAll(
            '.admin-sidebar-overlay, #adminSidebarOverlay, #sidebarOverlay'
        ).forEach(function (overlay) {
            overlay.classList.remove('show');
            overlay.classList.remove('visible');
        });

        document.body.classList.remove('admin-sidebar-open');
        document.body.classList.remove('sidebar-open');

        openButton.setAttribute('aria-expanded', 'false');
    });
});
</script>

</body>

</html>