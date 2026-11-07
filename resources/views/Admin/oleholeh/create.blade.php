<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Oleh-Oleh</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

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
    --sidebar-width:270px;
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{
    width:100%;min-height:100vh;overflow-x:hidden;
    font-family:'Inter',sans-serif;
    background:
        radial-gradient(circle at 88% 4%,rgba(226,201,151,.055),transparent 30%),
        radial-gradient(circle at 4% 96%,rgba(226,201,151,.025),transparent 28%),
        var(--bg-primary);
    color:var(--text-primary);line-height:1.65;
}
button,input,textarea,select{font:inherit}
a{text-decoration:none;color:inherit}
::selection{background:rgba(226,201,151,.25);color:var(--text-primary)}

.admin-oleholeh-page{
    width:calc(100% - var(--sidebar-width));
    min-height:100vh;margin-left:var(--sidebar-width);
    padding:48px 46px 64px;
    overflow-x:hidden;
}
.admin-oleholeh-inner{width:100%;max-width:1320px;margin:0 auto}

.page-header{
    margin-bottom:30px;
}
.page-breadcrumb{
    margin:0 0 8px;color:var(--text-muted);
    font-size:13px;font-weight:700;letter-spacing:1.8px;
    text-transform:uppercase;
}
.page-title{
    margin:0;font-family:'Playfair Display','Inter',serif;
    font-size:clamp(38px,4vw,58px);font-weight:700;
    line-height:1.12;letter-spacing:-.7px;
}
.text-gradient{
    background:linear-gradient(135deg,var(--accent) 0%,#f8f4ed 50%,var(--accent-dark) 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.page-description{
    max-width:760px;margin:11px 0 0;color:var(--text-muted);
    font-size:16px;line-height:1.7;
}

.form-alert{
    display:flex;align-items:flex-start;gap:13px;
    margin-bottom:22px;padding:17px 19px;
    border:1px solid rgba(239,68,68,.28);border-radius:var(--radius-md);
    background:rgba(239,68,68,.075);box-shadow:0 12px 35px rgba(0,0,0,.18);
}
.form-alert-icon{flex:0 0 auto;color:#ff8f8f;font-size:18px;line-height:1.5}
.form-alert-title{margin:0 0 7px;color:#ffd0d0;font-size:15px;font-weight:800}
.form-alert-list{margin:0;padding-left:18px;color:var(--text-secondary);font-size:14px;line-height:1.65}

.form-card{
    width:100%;padding:clamp(28px,3vw,40px);
    border:1px solid var(--border-soft);border-radius:var(--radius-lg);
    background:linear-gradient(145deg,rgba(255,255,255,.035),rgba(255,255,255,.012)),var(--bg-card);
    box-shadow:var(--shadow-soft);
    backdrop-filter:blur(18px);
}
.oleholeh-form{width:100%}
.form-grid{
    display:grid;grid-template-columns:minmax(0,1.08fr) minmax(0,.92fr);
    gap:clamp(26px,3vw,42px);width:100%;
}
.form-column{min-width:0}
.form-field{min-width:0;margin-bottom:28px}
.form-label{
    display:block;margin-bottom:9px;color:var(--text-secondary);
    font-size:15px;font-weight:700;
}
.required{color:var(--accent)}
.form-input,.form-select,.form-textarea{
    display:block;width:100%;max-width:100%;
    color:var(--text-primary);background:rgba(255,255,255,.035);
    border:1px solid var(--border-soft);border-radius:var(--radius-md);
    outline:none;font-family:'Inter',sans-serif;font-size:15px;
    transition:all var(--transition);
}
.form-input,.form-select{min-height:58px;padding:14px 17px}
.form-textarea{min-height:190px;padding:15px 17px;line-height:1.7;resize:vertical}
.form-input::placeholder,.form-textarea::placeholder{color:var(--text-dim)}
.form-input:hover,.form-select:hover,.form-textarea:hover{
    border-color:rgba(226,201,151,.24);background:rgba(255,255,255,.045)
}
.form-input:focus,.form-select:focus,.form-textarea:focus{
    border-color:rgba(226,201,151,.58);background:rgba(226,201,151,.045);
    box-shadow:0 0 0 3px rgba(226,201,151,.075)
}
.form-input.is-invalid,.form-select.is-invalid,.form-textarea.is-invalid{
    border-color:rgba(239,110,110,.68)!important
}
.field-error{margin:7px 0 0;color:#ffaaaa;font-size:13px;line-height:1.55}
.form-select option{color:#f8f4ed;background:#171717}

.input-with-prefix{position:relative}
.input-prefix{
    position:absolute;left:17px;top:50%;z-index:1;transform:translateY(-50%);
    color:var(--accent);font-size:15px;font-weight:700;pointer-events:none
}
.price-input{padding-left:50px}

.image-box{
    width:100%;padding:22px;text-align:center;
    border:1px dashed rgba(226,201,151,.26);border-radius:var(--radius-md);
    background:linear-gradient(145deg,rgba(226,201,151,.045),rgba(255,255,255,.018));
    transition:all var(--transition);
}
.image-box:hover{border-color:rgba(226,201,151,.55);background:rgba(226,201,151,.06)}
.image-preview{
    width:100%;max-width:100%;height:230px;display:none;
    margin:0 auto 16px;object-fit:cover;border-radius:14px;
    border:1px solid var(--border-soft)
}
.file-input{
    width:100%;max-width:100%;color:var(--text-secondary);
    font-family:inherit;font-size:14px
}
.file-input::file-selector-button{
    margin-right:10px;padding:12px 16px;color:var(--bg-primary);
    background:linear-gradient(135deg,var(--accent),var(--accent-hover));
    border:0;border-radius:var(--radius-full);font-family:inherit;
    font-size:14px;font-weight:800;cursor:pointer
}
.file-name{min-height:20px;margin:12px 0 0;color:var(--text-muted);font-size:14px;line-height:1.5;word-break:break-word}
.file-help{margin:5px 0 0;color:var(--text-dim);font-size:13px}

.info-box{
    display:flex;align-items:flex-start;gap:14px;margin-bottom:20px;padding:19px;
    border:1px solid var(--border-soft);border-radius:var(--radius-md);
    background:rgba(255,255,255,.035)
}
.info-icon{
    width:42px;height:42px;display:flex;align-items:center;justify-content:center;
    flex:0 0 auto;color:var(--accent);border:1px solid var(--border-gold);
    border-radius:13px;background:rgba(226,201,151,.08);font-size:16px
}
.info-content{min-width:0}
.info-title{margin:0;color:var(--text-primary);font-size:15px;font-weight:800}
.info-text{margin:7px 0 0;color:var(--text-muted);font-size:14px;line-height:1.65}

.form-actions{
    display:flex;align-items:center;justify-content:flex-end;gap:12px;
    margin-top:10px;padding-top:24px;border-top:1px solid var(--border-soft);
    flex-wrap:wrap
}
.btn-save,.btn-back{
    min-height:56px;display:inline-flex;align-items:center;justify-content:center;
    gap:8px;padding:0 25px;border-radius:var(--radius-full);
    font-family:'Inter',sans-serif;font-size:15px;font-weight:800;
    text-decoration:none;cursor:pointer;transition:all var(--transition)
}
.btn-save{
    color:var(--bg-primary);
    background:linear-gradient(135deg,var(--accent),var(--accent-hover));
    border:1px solid var(--accent);box-shadow:0 10px 28px rgba(0,0,0,.22)
}
.btn-save:hover{background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark));transform:translateY(-3px);box-shadow:var(--shadow-hover)}
.btn-back{
    color:var(--text-secondary);background:rgba(255,255,255,.035);
    border:1px solid var(--border-soft)
}
.btn-back:hover{background:rgba(226,201,151,.08);border-color:var(--border-gold);color:var(--accent);transform:translateY(-2px)}
.btn-save:disabled{opacity:.6;cursor:wait;transform:none}

.admin-mobile-menu-button{
    display:none;position:fixed;top:18px;left:18px;z-index:1200;
    width:52px;height:52px;align-items:center;justify-content:center;flex-direction:column;
    gap:5px;padding:0;border:1px solid rgba(226,201,151,.27);border-radius:14px;
    background:rgba(18,18,18,.96);color:var(--accent);
    box-shadow:0 14px 35px rgba(0,0,0,.4);backdrop-filter:blur(16px);cursor:pointer
}
.admin-mobile-menu-button span{display:block;width:24px;height:2px;border-radius:999px;background:var(--accent)}
.admin-mobile-menu-button:hover{border-color:rgba(226,201,151,.48);background:rgba(226,201,151,.09)}
:focus-visible{outline:2px solid rgba(226,201,151,.78);outline-offset:3px}

@media (min-width:1400px){
    .admin-oleholeh-page{margin-left:285px;width:calc(100% - 285px);padding:54px 58px 72px}
    .page-title{font-size:58px}
    .form-card{padding:40px}
}
@media (min-width:1101px) and (max-width:1399px){
    .admin-oleholeh-page{padding:46px 40px 62px}
    .page-title{font-size:46px}
}
@media (min-width:901px) and (max-width:1100px){
    .admin-oleholeh-page{margin-left:255px;width:calc(100% - 255px);padding:40px 28px 54px}
    .page-title{font-size:40px}
    .form-grid{grid-template-columns:1fr}
}
@media (max-width:900px){
    .admin-mobile-menu-button{display:flex}
    .admin-oleholeh-page{width:100%;margin-left:0;padding:90px 26px 48px}
    .admin-oleholeh-inner{max-width:760px}
    .page-header{margin-bottom:26px}
    .page-title{font-size:44px}
    .page-description{font-size:15px}
    .form-card{padding:30px 26px}
    .form-grid{grid-template-columns:1fr;gap:0}
    .form-field{margin-bottom:25px}
}
@media (max-width:600px){
    .admin-mobile-menu-button{top:14px;left:14px;width:48px;height:48px}
    .admin-oleholeh-page{padding:78px 15px 36px}
    .page-breadcrumb{font-size:12px;letter-spacing:1.4px}
    .page-title{font-size:38px;letter-spacing:-.4px}
    .page-description{margin-top:8px;font-size:14px;line-height:1.7}
    .form-alert{padding:14px;font-size:14px}
    .form-alert-title{font-size:14px}
    .form-alert-list{font-size:13px}
    .form-card{padding:24px 19px;border-radius:22px}
    .form-label{font-size:15px}
    .form-input,.form-select{min-height:56px;font-size:15px}
    .form-textarea{min-height:155px;font-size:15px}
    .image-box{padding:18px}
    .image-preview{height:210px}
    .file-input{font-size:14px}
    .file-name{font-size:14px}
    .file-help{font-size:13px}
    .info-box{padding:17px}
    .info-title{font-size:15px}
    .info-text{font-size:14px}
    .form-actions{flex-direction:column-reverse;align-items:stretch}
    .btn-save,.btn-back{width:100%;min-height:54px;font-size:15px}
}
@media (max-width:380px){
    .admin-oleholeh-page{padding-left:12px;padding-right:12px}
    .page-title{font-size:34px}
    .page-description{font-size:14px}
    .form-card{padding:21px 16px}
}
@media (prefers-reduced-motion:reduce){
    *,*::before,*::after{scroll-behavior:auto!important;transition:none!important;animation:none!important}
}

    </style>

<style id="noyo-gimbal-sidebar-reference">

@media (max-width:900px){

    html,
    body{
        width:100%;
        min-width:0;
        min-height:100%;
    }

    body{
        overflow-x:hidden !important;
    }

    .admin-sidebar{
        position:fixed !important;

        top:14px !important;
        left:18px !important;
        right:auto !important;
        bottom:14px !important;

        width:min(320px, calc(100vw - 36px)) !important;
        height:calc(100dvh - 28px) !important;
        max-height:calc(100dvh - 28px) !important;
        min-height:0 !important;

        border:1px solid rgba(226,201,151,.16) !important;
        border-radius:20px !important;

        background:
            linear-gradient(
                180deg,
                rgba(19,19,19,.94) 0%,
                rgba(9,9,9,.90) 100%
            ) !important;

        backdrop-filter:blur(24px) saturate(120%) !important;
        -webkit-backdrop-filter:blur(24px) saturate(120%) !important;

        box-shadow:
            24px 0 70px rgba(0,0,0,.42),
            0 18px 48px rgba(0,0,0,.28),
            inset 0 1px 0 rgba(255,255,255,.025) !important;

        overflow:hidden !important;
        isolation:isolate !important;

        transform:translate3d(calc(-100% - 30px),0,0) !important;
        transition:transform .30s cubic-bezier(.4,0,.2,1) !important;

        z-index:2100 !important;
    }

    .admin-sidebar.open{
        transform:translate3d(0,0,0) !important;
    }

    .admin-sidebar-brand{
        position:relative !important;
        min-height:80px !important;

        padding:17px 12px 13px !important;

        border-bottom:1px solid rgba(255,255,255,.055) !important;
        background:rgba(0,0,0,.07) !important;
    }

    .admin-brand-link{
        display:flex !important;
        align-items:center !important;
        gap:11px !important;

        width:100% !important;
        min-width:0 !important;
        padding-right:52px !important;

        text-decoration:none !important;
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
        display:block !important;

        color:#f8f4ed !important;
        font-family:'Playfair Display',Georgia,serif !important;
        font-size:18px !important;
        font-weight:700 !important;
        line-height:1.15 !important;

        white-space:nowrap !important;
        overflow:hidden !important;
        text-overflow:ellipsis !important;
    }

    .admin-brand-text span{
        display:block !important;

        margin-top:4px !important;

        color:#e2c997 !important;
        font-size:8.5px !important;
        font-weight:800 !important;
        line-height:1 !important;
        letter-spacing:1.35px !important;
    }

    .admin-sidebar-close-button{
        display:flex !important;
        position:absolute !important;

        top:14px !important;
        right:12px !important;

        width:40px !important;
        height:40px !important;

        align-items:center !important;
        justify-content:center !important;

        border:1px solid rgba(226,201,151,.14) !important;
        border-radius:11px !important;

        background:rgba(255,255,255,.035) !important;
        color:#e2c997 !important;

        cursor:pointer !important;
        z-index:5 !important;

        transition:
            background .2s ease,
            border-color .2s ease,
            transform .2s ease,
            color .2s ease !important;
    }

    .admin-sidebar-close-button:hover{
        background:rgba(226,201,151,.09) !important;
        border-color:rgba(226,201,151,.40) !important;
        color:#f8f4ed !important;
        transform:translateY(-1px) !important;
    }

    .admin-sidebar-user{
        margin:11px 12px 10px !important;
        padding:10px !important;

        border:1px solid rgba(226,201,151,.10) !important;
        border-radius:14px !important;

        background:rgba(255,255,255,.028) !important;
        box-shadow:inset 0 1px 0 rgba(255,255,255,.018) !important;
    }

    .admin-user-avatar{
        width:40px !important;
        height:40px !important;
        flex:0 0 40px !important;

        border-radius:12px !important;
    }

    .admin-user-info{
        min-width:0 !important;
    }

    .admin-user-info strong{
        display:block !important;

        color:#f8f4ed !important;
        font-size:14px !important;
        font-weight:800 !important;
        line-height:1.35 !important;

        white-space:nowrap !important;
        overflow:hidden !important;
        text-overflow:ellipsis !important;
    }

    .admin-user-info span{
        display:block !important;

        margin-top:2px !important;

        color:#a89988 !important;
        font-size:12px !important;
        line-height:1.35 !important;

        white-space:nowrap !important;
        overflow:hidden !important;
        text-overflow:ellipsis !important;
    }

    .admin-sidebar-nav{
        min-height:0 !important;
        padding:0 9px 8px !important;

        overflow-x:hidden !important;
        overflow-y:auto !important;

        scrollbar-width:thin !important;
        scrollbar-color:rgba(226,201,151,.20) transparent !important;
    }

    .admin-sidebar-nav::-webkit-scrollbar{
        width:4px !important;
    }

    .admin-sidebar-nav::-webkit-scrollbar-track{
        background:transparent !important;
    }

    .admin-sidebar-nav::-webkit-scrollbar-thumb{
        background:rgba(226,201,151,.20) !important;
        border-radius:999px !important;
    }

    .admin-nav-title{
        margin:14px 9px 6px !important;

        color:#8f8578 !important;
        font-size:10px !important;
        font-weight:800 !important;
        line-height:1.2 !important;
        letter-spacing:1.35px !important;

        text-transform:uppercase !important;
    }

    .admin-nav-link{
        position:relative !important;

        width:100% !important;
        min-height:50px !important;

        display:flex !important;
        align-items:center !important;

        margin:2px 0 !important;
        padding:0 8px !important;

        border:1px solid transparent !important;
        border-radius:11px !important;

        color:#d0cbc3 !important;

        transition:
            background .2s ease,
            border-color .2s ease,
            color .2s ease,
            transform .2s ease !important;
    }

    .admin-nav-link:hover{
        background:rgba(255,255,255,.03) !important;
        border-color:rgba(255,255,255,.04) !important;
        color:#f8f4ed !important;
        transform:translateX(1px) !important;
    }

    .admin-nav-icon{
        width:36px !important;
        height:36px !important;
        flex:0 0 36px !important;

        display:flex !important;
        align-items:center !important;
        justify-content:center !important;

        border-radius:11px !important;

        color:#a9a39a !important;
        font-size:13px !important;
    }

    .admin-nav-text{
        min-width:0 !important;

        color:inherit !important;
        font-size:14.5px !important;
        font-weight:700 !important;
        line-height:1.3 !important;

        white-space:nowrap !important;
        overflow:hidden !important;
        text-overflow:ellipsis !important;
    }

    .admin-nav-link.active,
    .admin-nav-link[aria-current="page"]{
        border-color:rgba(226,201,151,.20) !important;

        background:
            linear-gradient(
                135deg,
                rgba(226,201,151,.095),
                rgba(226,201,151,.025)
            ) !important;

        color:#f8f4ed !important;
    }

    .admin-nav-link.active::before,
    .admin-nav-link[aria-current="page"]::before{
        content:"" !important;

        position:absolute !important;
        left:-1px !important;
        top:8px !important;
        bottom:8px !important;

        width:3px !important;

        border-radius:0 999px 999px 0 !important;

        background:#e2c997 !important;
        box-shadow:0 0 12px rgba(226,201,151,.22) !important;
    }

    .admin-nav-link.active .admin-nav-icon,
    .admin-nav-link[aria-current="page"] .admin-nav-icon{
        color:#e2c997 !important;
        background:rgba(226,201,151,.075) !important;
    }

    .admin-sidebar-footer{
        padding:
            9px
            11px
            max(11px,env(safe-area-inset-bottom))
            !important;

        border-top:1px solid rgba(255,255,255,.055) !important;

        background:
            linear-gradient(
                180deg,
                rgba(0,0,0,.12),
                rgba(0,0,0,.28)
            ) !important;
    }

    .admin-system-status{
        min-height:39px !important;

        display:flex !important;
        align-items:center !important;

        margin:0 0 6px !important;
        padding:0 10px !important;

        border:1px solid rgba(255,255,255,.045) !important;
        border-radius:10px !important;

        background:rgba(255,255,255,.022) !important;

        color:#a89988 !important;
        font-size:11px !important;
    }

    .admin-logout-button{
        min-height:43px !important;
        padding:0 9px !important;

        border-radius:10px !important;

        color:#bdb6ac !important;
        font-size:13.5px !important;
        font-weight:700 !important;
    }

    .admin-logout-button:hover{
        background:rgba(255,255,255,.025) !important;
        color:#f8f4ed !important;
    }

    .admin-sidebar-copyright{
        display:flex !important;
        align-items:center !important;
        justify-content:space-between !important;

        margin-top:5px !important;
        padding:8px 2px 0 !important;

        border-top:1px solid rgba(255,255,255,.045) !important;
    }

    .admin-sidebar-copyright small{
        color:#71695f !important;
        font-size:9px !important;
        line-height:1.2 !important;
    }

    .admin-sidebar-overlay,
    #adminSidebarOverlay,
    #sidebarOverlay{
        position:fixed !important;
        inset:0 !important;
        z-index:2050 !important;

        background:rgba(0,0,0,.42) !important;

        backdrop-filter:blur(3px) !important;
        -webkit-backdrop-filter:blur(3px) !important;

        opacity:0 !important;
        pointer-events:none !important;

        transition:opacity .25s ease !important;
    }

    .admin-sidebar-overlay.show,
    .admin-sidebar-overlay.visible,
    #adminSidebarOverlay.show,
    #adminSidebarOverlay.visible,
    #sidebarOverlay.show,
    #sidebarOverlay.visible{
        opacity:1 !important;
        pointer-events:auto !important;
    }

    .admin-mobile-menu-button{
        position:fixed !important;

        top:14px !important;
        left:14px !important;
        right:auto !important;

        width:46px !important;
        height:46px !important;

        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        flex-direction:column !important;
        gap:5px !important;

        padding:0 !important;

        z-index:2000 !important;

        border:1px solid rgba(226,201,151,.20) !important;
        border-radius:13px !important;

        background:
            linear-gradient(
                145deg,
                rgba(226,201,151,.10),
                rgba(255,255,255,.025)
            ),
            rgba(12,12,12,.94) !important;

        color:#e2c997 !important;

        box-shadow:
            0 12px 35px rgba(0,0,0,.34),
            inset 0 1px 0 rgba(255,255,255,.045) !important;

        backdrop-filter:blur(17px) !important;
        -webkit-backdrop-filter:blur(17px) !important;

        cursor:pointer !important;
    }

    .admin-mobile-menu-button:hover{
        border-color:rgba(226,201,151,.40) !important;
    }

    .admin-mobile-menu-button span{
        display:block !important;
        width:19px !important;
        height:2px !important;

        border-radius:999px !important;

        background:currentColor !important;
    }

    body.admin-sidebar-open .admin-mobile-menu-button,
    body.sidebar-open .admin-mobile-menu-button{
        opacity:0 !important;
        pointer-events:none !important;
        transform:translateY(-8px) !important;
    }
}

@media (max-width:600px){

    .admin-sidebar{
        top:10px !important;
        left:10px !important;
        bottom:10px !important;

        width:min(320px,calc(100vw - 20px)) !important;
        height:calc(100dvh - 20px) !important;
        max-height:calc(100dvh - 20px) !important;

        border-radius:18px !important;
    }

    .admin-sidebar-brand{
        min-height:78px !important;
        padding:16px 11px 12px !important;
    }

    .admin-brand-logo{
        width:44px !important;
        height:44px !important;
        flex-basis:44px !important;
    }

    .admin-brand-text strong{
        font-size:17px !important;
    }

    .admin-sidebar-user{
        margin:10px 11px 9px !important;
    }

    .admin-nav-title{
        margin-top:13px !important;
    }

    .admin-nav-link{
        min-height:49px !important;
    }

    .admin-mobile-menu-button{
        top:12px !important;
        left:12px !important;
    }
}

@media (max-width:380px){

    .admin-sidebar{
        top:8px !important;
        left:8px !important;
        bottom:8px !important;

        width:min(305px,calc(100vw - 16px)) !important;
        height:calc(100dvh - 16px) !important;
        max-height:calc(100dvh - 16px) !important;

        border-radius:16px !important;
    }

    .admin-sidebar-brand{
        padding-left:10px !important;
        padding-right:10px !important;
    }

    .admin-sidebar-user{
        margin-left:10px !important;
        margin-right:10px !important;
    }

    .admin-nav-link{
        min-height:47px !important;
    }

    .admin-nav-text{
        font-size:14px !important;
    }
}

@media (prefers-reduced-motion:reduce){

    .admin-sidebar,
    .admin-sidebar-overlay,
    #adminSidebarOverlay,
    #sidebarOverlay,
    .admin-mobile-menu-button,
    .admin-nav-link,
    .admin-sidebar-close-button{
        transition:none !important;
    }
}
</style>

</head>

<body>

    <button type="button" class="admin-mobile-menu-button" id="openAdminSidebar" aria-label="Buka menu navigasi" aria-controls="adminSidebar" aria-expanded="false" title="Buka menu">
        <span></span><span></span><span></span>
    </button>

    @include('admin.partials.sidebar')

    <main class="admin-oleholeh-page">

        <div class="admin-oleholeh-inner">

            <header class="page-header">

                <p class="page-breadcrumb">
                    
                </p>

                <h1 class="page-title text-gradient">
                    Tambah Oleh-Oleh Baru
                </h1>

                <p class="page-description">
                    Tambahkan produk oleh-oleh khas Blora untuk wisatawan.
                </p>

            </header>

            @if ($errors->any())

                <div class="form-alert">

                    <div class="form-alert-icon">
                        <i class="fas fa-circle-exclamation"></i>
                    </div>

                    <div class="form-alert-content">

                        <p class="form-alert-title">
                            Gagal Memproses Data
                        </p>

                        <ul class="form-alert-list">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            @endif

            <section class="form-card">

                <form
                    action="{{ route('admin.oleholeh.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="oleholeh-form"
                    id="oleholehForm"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="status"
                        value="Tersedia"
                    >

                    <div class="form-grid">

                        <div class="form-column">

                            <div class="form-field">

                                <label
                                    for="nama"
                                    class="form-label"
                                >
                                    Nama Oleh-Oleh
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="nama"
                                    name="nama"
                                    value="{{ old('nama') }}"
                                    placeholder="Contoh: Kaos Blora"
                                    maxlength="255"
                                    required
                                    autofocus
                                    class="form-input @error('nama') is-invalid @enderror"
                                >

                                @error('nama')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                            <div class="form-field">

                                <label
                                    for="deskripsi"
                                    class="form-label"
                                >
                                    Deskripsi
                                </label>

                                <textarea
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="6"
                                    placeholder="Masukkan deskripsi produk oleh-oleh..."
                                    class="form-textarea @error('deskripsi') is-invalid @enderror"
                                >{{ old('deskripsi') }}</textarea>

                                @error('deskripsi')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                            <div class="form-field">

                                <label
                                    for="gambarInput"
                                    class="form-label"
                                >
                                    Gambar Produk
                                </label>

                                <div class="image-box">

                                    <img
                                        id="previewImage"
                                        src=""
                                        alt="Preview gambar"
                                        class="image-preview"
                                    >

                                    <input
                                        type="file"
                                        name="gambar"
                                        id="gambarInput"
                                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                        class="file-input"
                                    >

                                    <p
                                        id="fileName"
                                        class="file-name"
                                    >
                                        Belum ada gambar dipilih
                                    </p>

                                    <p class="file-help">
                                        Format: JPG, JPEG, PNG, WEBP
                                    </p>

                                </div>

                                @error('gambar')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>

                        <div class="form-column">

                            <div class="form-field">

                                <label
                                    for="jenis"
                                    class="form-label"
                                >
                                    Jenis Oleh-Oleh
                                    <span class="required">*</span>
                                </label>

                                <select
                                    id="jenis"
                                    name="jenis"
                                    required
                                    class="form-select @error('jenis') is-invalid @enderror"
                                >

                                    <option value="">
                                        Pilih Jenis
                                    </option>

                                    @foreach([
                                        'Totebag',
                                        'Baju',
                                        'Celana',
                                        'Topi',
                                        'Gantungan Kunci',
                                        'Ikat Rambut',
                                        'Kacamata',
                                        'Daster',
                                        'Sandal',
                                        'Pajangan Tumbuhan',
                                        'Barongan'
                                    ] as $jenis)

                                        <option
                                            value="{{ $jenis }}"
                                            @selected(old('jenis') === $jenis)
                                        >
                                            {{ $jenis }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('jenis')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                            <div class="form-field">

                                <label
                                    for="harga"
                                    class="form-label"
                                >
                                    Harga
                                    <span class="required">*</span>
                                </label>

                                <div class="input-with-prefix">

                                    <span class="input-prefix">
                                        Rp
                                    </span>

                                    <input
                                        type="text"
                                        id="harga"
                                        name="harga"
                                        inputmode="numeric"
                                        autocomplete="off"
                                        maxlength="12"
                                        value="{{ old('harga') }}"
                                        placeholder="10.000"
                                        required
                                        class="form-input price-input @error('harga') is-invalid @enderror"
                                    >

                                </div>

                                <p class="field-help">Harga minimal Rp10.000 dan maksimal Rp100.000.</p>

                                @error('harga')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                            <div class="info-box">

                                <div class="info-icon">
                                    <i class="fas fa-boxes-stacked"></i>
                                </div>

                                <div class="info-content">

                                    <p class="info-title">
                                        Stok Produk
                                    </p>

                                    <p class="info-text">
                                        Stok awal produk akan otomatis diatur
                                        menjadi <strong>0</strong>.
                                        Pengelolaan stok dilakukan oleh
                                        <strong>Kasir Oleh-Oleh</strong>.
                                    </p>

                                </div>

                            </div>

                            <div class="info-box">

                                <div class="info-icon">
                                    <i class="fas fa-circle-info"></i>
                                </div>

                                <div class="info-content">

                                    <p class="info-title">
                                        Status Produk
                                    </p>

                                    <p class="info-text">
                                        Status tidak perlu dipilih secara manual.
                                        Produk baru menggunakan status
                                        <strong>Tersedia</strong> dan selanjutnya
                                        mengikuti pengelolaan stok.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="form-actions">

                        <a
                            href="{{ route('admin.oleholeh.index') }}"
                            class="btn-back"
                        >
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn-save"
                            id="saveButton"
                        >
                            <i class="fas fa-floppy-disk"></i>
                            Simpan Oleh-Oleh
                        </button>

                    </div>

                </form>

            </section>

        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const gambarInput = document.getElementById('gambarInput');
            const previewImage = document.getElementById('previewImage');
            const fileName = document.getElementById('fileName');
            const form = document.getElementById('oleholehForm');
            const saveButton = document.getElementById('saveButton');
            const hargaInput = document.getElementById('harga');
            const allowedImageTypes = ['image/jpeg', 'image/png', 'image/webp'];

            function formatRupiah(value) {
                const digits = String(value || '').replace(/\D/g, '');
                return digits ? digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
            }

            function numericPrice(value) {
                return Number(String(value || '').replace(/\D/g, '')) || 0;
            }

            function validatePrice() {
                if (!hargaInput) return true;

                const value = numericPrice(hargaInput.value);

                if (value < 10000 || value > 100000) {
                    hargaInput.setCustomValidity('Harga harus antara Rp10.000 dan Rp100.000.');
                    return false;
                }

                hargaInput.setCustomValidity('');
                return true;
            }

            if (hargaInput) {
                hargaInput.value = formatRupiah(hargaInput.value);

                hargaInput.addEventListener('input', function () {
                    let digits = this.value.replace(/\D/g, '').replace(/^0+(?=\d)/, '');

                    if (Number(digits) > 100000) {
                        digits = '100000';
                    }

                    this.value = formatRupiah(digits);
                    this.setCustomValidity('');
                });

                hargaInput.addEventListener('blur', validatePrice);
            }

            if (gambarInput && previewImage && fileName) {
                gambarInput.addEventListener('change', function () {
                    const file = this.files && this.files[0];

                    if (!file) {
                        previewImage.removeAttribute('src');
                        previewImage.style.display = 'none';
                        fileName.textContent = 'Belum ada gambar dipilih';
                        return;
                    }

                    if (!allowedImageTypes.includes(file.type)) {
                        this.value = '';
                        previewImage.removeAttribute('src');
                        previewImage.style.display = 'none';
                        fileName.textContent = 'Format gambar tidak didukung. Gunakan JPG, PNG, atau WEBP.';
                        return;
                    }

                    fileName.textContent = file.name;

                    const reader = new FileReader();

                    reader.onload = function (event) {
                        previewImage.src = event.target.result;
                        previewImage.style.display = 'block';
                    };

                    reader.onerror = function () {
                        previewImage.removeAttribute('src');
                        previewImage.style.display = 'none';
                        fileName.textContent = 'Gambar gagal dibaca. Silakan pilih ulang.';
                        gambarInput.value = '';
                    };

                    reader.readAsDataURL(file);
                });
            }

            if (form && saveButton) {
                form.addEventListener('submit', function (event) {
                    if (!validatePrice()) {
                        event.preventDefault();
                        hargaInput.reportValidity();
                        return;
                    }

                    if (saveButton.dataset.submitted === '1') {
                        event.preventDefault();
                        return;
                    }

                    if (hargaInput) {
                        hargaInput.value = numericPrice(hargaInput.value);
                    }

                    saveButton.dataset.submitted = '1';
                    saveButton.disabled = true;
                    saveButton.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Menyimpan...';
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuButton = document.getElementById('openAdminSidebar');
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay') || document.querySelector('.admin-sidebar-overlay');

            if (!menuButton || !sidebar) return;

            function openSidebar() {
                if (typeof window.openAdminSidebar === 'function') {
                    window.openAdminSidebar();
                } else {
                    sidebar.classList.add('open');
                    if (overlay) overlay.classList.add('show');
                    document.body.classList.add('sidebar-open');
                }

                menuButton.setAttribute('aria-expanded', 'true');
            }

            function closeSidebar() {
                if (typeof window.closeAdminSidebar === 'function') {
                    window.closeAdminSidebar();
                } else {
                    sidebar.classList.remove('open');
                    if (overlay) overlay.classList.remove('show');
                    document.body.classList.remove('sidebar-open', 'admin-sidebar-open');
                }

                menuButton.setAttribute('aria-expanded', 'false');
            }

            menuButton.addEventListener('click', function () {
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && sidebar.classList.contains('open')) {
                    closeSidebar();
                }
            });
        });
    </script>

</body>
</html>
