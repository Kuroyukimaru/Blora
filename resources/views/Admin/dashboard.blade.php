<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Admin | Noyo Gimbal</title>

    

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
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

    --success:#9bc9a7;
    --danger:#d58a8a;

    --sidebar-width:270px;
    --shadow-soft:0 20px 60px rgba(0,0,0,.38);
    --shadow-hover:0 25px 70px rgba(0,0,0,.48);

    --radius-lg:22px;
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
    min-height:100vh;
    background:
        radial-gradient(circle at 85% 0%, rgba(226,201,151,.045), transparent 28%),
        var(--bg-primary);
    color:var(--text-primary);
    font-family:"DM Sans",sans-serif;
    overflow-x:hidden;
    line-height:1.65;
}

button,
input{
    font-family:inherit;
}

a{
    text-decoration:none;
    color:inherit;
}

.dashboard-wrapper{
    min-height:100vh;
    margin-left:var(--sidebar-width);
    padding:32px 36px 42px;
}

.dashboard-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    margin-bottom:28px;
}

.header-left{
    min-width:0;
}

.header-label{
    display:flex;
    align-items:center;
    gap:9px;
    margin-bottom:8px;
    color:var(--accent);
    font-size:12px;
    font-weight:700;
    letter-spacing:1.8px;
    text-transform:uppercase;
}

.header-label::before{
    content:"";
    width:18px;
    height:1px;
    background:var(--accent);
    opacity:.75;
}

.dashboard-header h1{
    color:var(--text-primary);
    font-size:34px;
    font-weight:700;
    line-height:1.15;
    letter-spacing:-.8px;
}

.dashboard-header p{
    margin-top:7px;
    color:var(--text-muted);
    font-size:14px;
    line-height:1.6;
}


.hero{
    position:relative;
    min-height:210px;
    display:flex;
    align-items:center;
    padding:34px 38px;
    margin-bottom:30px;
    overflow:hidden;
    border:1px solid var(--border-gold);
    border-radius:var(--radius-lg);
    background:
        linear-gradient(135deg,rgba(226,201,151,.075),rgba(255,255,255,.025) 45%,rgba(255,255,255,.015)),
        var(--bg-secondary);
    box-shadow:var(--shadow-soft);
}

.hero::before{
    content:"";
    position:absolute;
    width:360px;
    height:360px;
    right:-190px;
    top:-210px;
    border:1px solid rgba(226,201,151,.12);
    border-radius:50%;
}

.hero::after{
    content:"";
    position:absolute;
    width:230px;
    height:230px;
    right:65px;
    bottom:-185px;
    border:1px solid rgba(226,201,151,.07);
    border-radius:50%;
}

.hero-content{
    position:relative;
    z-index:2;
    max-width:690px;
}

.hero-small{
    display:inline-flex;
    align-items:center;
    gap:7px;
    padding:6px 10px;
    margin-bottom:15px;
    background:rgba(226,201,151,.08);
    border:1px solid var(--border-gold);
    border-radius:var(--radius-full);
    color:var(--accent);
    font-size:11px;
    font-weight:700;
    letter-spacing:1.5px;
    text-transform:uppercase;
}

.hero-small i{
    font-size:6px;
}

.hero h2{
    color:var(--text-primary);
    font-size:30px;
    font-weight:700;
    line-height:1.25;
    letter-spacing:-.6px;
}

.hero h2 span{
    color:var(--accent);
}

.hero p{
    max-width:610px;
    margin-top:10px;
    color:var(--text-muted);
    font-size:13px;
    line-height:1.8;
}

.section-title{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:13px;
}

.section-title h2{
    color:var(--text-primary);
    font-size:16px;
    font-weight:700;
}

.section-title span{
    color:var(--text-dim);
    font-size:12px;
}

.statistics{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:14px;
    margin-bottom:26px;
}

.stat-card{
    position:relative;
    padding:19px;
    overflow:hidden;
    background:linear-gradient(145deg,rgba(255,255,255,.035),rgba(255,255,255,.015));
    border:1px solid var(--border-soft);
    border-radius:var(--radius-md);
    transition:transform var(--transition),border-color var(--transition),box-shadow var(--transition);
}

.stat-card:hover{
    transform:translateY(-3px);
    border-color:var(--border-gold);
    box-shadow:var(--shadow-soft);
}

.stat-card::after{
    content:"";
    position:absolute;
    width:100px;
    height:100px;
    right:-55px;
    bottom:-55px;
    border-radius:50%;
    background:rgba(226,201,151,.035);
}

.stat-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.stat-icon{
    width:39px;
    height:39px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:11px;
    background:rgba(226,201,151,.09);
    border:1px solid rgba(226,201,151,.10);
    color:var(--accent);
    font-size:12px;
}

.stat-status{
    color:var(--success);
    font-size:11px;
    font-weight:700;
}

.stat-label{
    margin-top:17px;
    color:var(--text-muted);
    font-size:12px;
    font-weight:600;
}

.stat-value{
    margin-top:4px;
    color:var(--text-primary);
    font-size:28px;
    font-weight:700;
    letter-spacing:-.7px;
}

.content-grid{
    display:grid;
    grid-template-columns:minmax(0,1.45fr) minmax(280px,.8fr);
    gap:17px;
}

.panel{
    background:rgba(18,18,18,.86);
    border:1px solid var(--border-soft);
    border-radius:var(--radius-md);
    padding:21px;
    box-shadow:0 12px 35px rgba(0,0,0,.16);
}

.panel-header{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:15px;
    margin-bottom:17px;
}

.panel-title h3{
    color:var(--text-primary);
    font-size:16px;
    font-weight:700;
}

.panel-title p{
    margin-top:4px;
    color:var(--text-dim);
    font-size:12px;
}

.panel-tag{
    padding:5px 9px;
    border-radius:var(--radius-full);
    background:rgba(226,201,151,.08);
    border:1px solid rgba(226,201,151,.10);
    color:var(--accent);
    font-size:10px;
    font-weight:700;
    letter-spacing:.8px;
    text-transform:uppercase;
}

.quick-menu{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:10px;
}

.quick-item{
    display:flex;
    align-items:center;
    gap:11px;
    min-height:69px;
    padding:12px;
    background:rgba(255,255,255,.022);
    border:1px solid var(--border-soft);
    border-radius:var(--radius-sm);
    transition:transform var(--transition),background var(--transition),border-color var(--transition);
}

.quick-item:hover{
    transform:translateY(-2px);
    background:rgba(226,201,151,.045);
    border-color:var(--border-gold);
}

.quick-icon{
    width:35px;
    height:35px;
    flex:0 0 35px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    background:rgba(226,201,151,.085);
    color:var(--accent);
    font-size:11px;
}

.quick-content strong{
    display:block;
    color:var(--text-primary);
    font-size:12px;
    font-weight:700;
}

.quick-content span{
    display:block;
    margin-top:3px;
    color:var(--text-dim);
    font-size:8px;
    line-height:1.45;
}

.status-list{
    display:flex;
    flex-direction:column;
    gap:0;
}

.status-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    padding:13px 0;
    border-bottom:1px solid var(--border-soft);
}

.status-item:first-child{
    padding-top:0;
}

.status-item:last-child{
    padding-bottom:0;
    border-bottom:0;
}

.status-info{
    display:flex;
    align-items:center;
    gap:10px;
}

.status-icon{
    width:33px;
    height:33px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:9px;
    background:rgba(226,201,151,.075);
    color:var(--accent);
    font-size:12px;
}

.status-text strong{
    display:block;
    color:var(--text-primary);
    font-size:12px;
    font-weight:700;
}

.status-text span{
    display:block;
    margin-top:3px;
    color:var(--text-dim);
    font-size:12px;
}

.status-badge{
    padding:5px 8px;
    border-radius:var(--radius-full);
    background:rgba(155,201,167,.08);
    border:1px solid rgba(155,201,167,.10);
    color:var(--success);
    font-size:10px;
    font-weight:700;
}
.dashboard-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    margin-top:28px;
    padding-top:17px;
    border-top:1px solid var(--border-soft);
    color:var(--text-dim);
    font-size:11px;
}


/* ============================================================
   MOBILE SIDEBAR TRIGGER
   ============================================================ */
.admin-mobile-menu-button{
    display:none;

    position:fixed;
    top:18px;
    left:18px;
    z-index:1200;

    width:50px;
    height:50px;

    align-items:center;
    justify-content:center;
    flex-direction:column;
    gap:5px;

    padding:0;

    background:rgba(18,18,18,.95);
    border:1px solid rgba(226,201,151,.24);
    border-radius:13px;

    box-shadow:
        0 12px 30px rgba(0,0,0,.35),
        inset 0 1px 0 rgba(255,255,255,.03);

    cursor:pointer;

    -webkit-backdrop-filter:blur(14px);
    backdrop-filter:blur(14px);

    transition:
        background var(--transition),
        border-color var(--transition),
        transform var(--transition),
        box-shadow var(--transition);
}

.admin-mobile-menu-button span{
    display:block;

    width:23px;
    height:2px;

    background:var(--accent);
    border-radius:999px;

    transition:transform var(--transition),opacity var(--transition);
}

.admin-mobile-menu-button:hover{
    background:rgba(226,201,151,.10);
    border-color:rgba(226,201,151,.40);
    transform:translateY(-1px);

    box-shadow:
        0 15px 35px rgba(0,0,0,.42),
        0 0 0 1px rgba(226,201,151,.05);
}

.admin-mobile-menu-button:active{
    transform:scale(.96);
}

.admin-mobile-menu-button:focus-visible{
    outline:2px solid rgba(226,201,151,.75);
    outline-offset:3px;
}

/* ============================================================
   DESKTOP SIDEBAR ALIGNMENT
   ============================================================ */
@media (min-width:1200px){
    .dashboard-wrapper{
        margin-left:280px;
    }
}

@media (min-width:1400px){
    .dashboard-wrapper{
        margin-left:290px;
    }
}

@media (min-width:901px) and (max-width:1199px){
    .dashboard-wrapper{
        margin-left:270px;
    }
}

/* ============================================================
   TABLET / MOBILE
   ============================================================ */
@media (max-width:900px){
    .admin-mobile-menu-button{
        display:flex;
    }

    .dashboard-wrapper{
        width:100%;
        margin-left:0;
        padding:92px 24px 32px;
    }

    .dashboard-header{
        margin-bottom:24px;
    }

    .dashboard-header h1{
        font-size:30px;
    }

    .dashboard-header p{
        font-size:14px;
    }

    .header-label{
        font-size:11px;
    }

    .hero{
        padding:30px;
    }

    .hero h2{
        font-size:27px;
    }

    .hero p{
        font-size:13px;
    }

    .section-title h2{
        font-size:17px;
    }

    .section-title span{
        font-size:12px;
    }

    .stat-card{
        padding:20px;
    }

    .stat-label{
        font-size:12px;
    }

    .stat-value{
        font-size:29px;
    }

    .stat-status{
        font-size:10px;
    }

    .panel{
        padding:22px;
    }

    .panel-title h3{
        font-size:16px;
    }

    .panel-title p{
        font-size:11px;
    }

    .quick-content strong{
        font-size:13px;
    }

    .quick-content span{
        font-size:11px;
    }

    .status-text strong{
        font-size:12px;
    }

    .status-text span{
        font-size:10px;
    }

    .status-badge{
        font-size:10px;
    }

    .activity-empty strong{
        font-size:13px;
    }

    .activity-empty span{
        font-size:11px;
    }

    .dashboard-footer{
        font-size:10px;
    }
}

@media (max-width:650px){
    .admin-mobile-menu-button{
        top:15px;
        left:15px;

        width:47px;
        height:47px;

        border-radius:12px;
    }

    .admin-mobile-menu-button span{
        width:21px;
    }

    .dashboard-wrapper{
        padding:78px 15px 26px;
    }

    .dashboard-header{
        align-items:flex-start;
        margin-bottom:20px;
    }

    .dashboard-header h1{
        font-size:27px;
        letter-spacing:-.5px;
    }

    .dashboard-header p{
        margin-top:6px;
        font-size:13px;
    }

    .header-label{
        margin-bottom:7px;
        font-size:10px;
        letter-spacing:1.5px;
    }

    .hero{
        min-height:auto;
        padding:25px 21px;
        margin-bottom:25px;
        border-radius:18px;
    }

    .hero-small{
        padding:7px 11px;
        margin-bottom:13px;
        font-size:10px;
    }

    .hero h2{
        font-size:23px;
        line-height:1.3;
    }

    .hero p{
        margin-top:9px;
        font-size:12px;
        line-height:1.7;
    }

    .section-title{
        margin-bottom:12px;
    }

    .section-title h2{
        font-size:16px;
    }

    .section-title span{
        font-size:10px;
    }

    .statistics{
        grid-template-columns:1fr;
        gap:11px;
        margin-bottom:22px;
    }

    .stat-card{
        padding:18px;
    }

    .stat-icon{
        width:40px;
        height:40px;
        font-size:13px;
    }

    .stat-label{
        margin-top:14px;
        font-size:12px;
    }

    .stat-value{
        font-size:28px;
    }

    .stat-status{
        font-size:10px;
    }

    .content-grid{
        gap:13px;
    }

    .panel{
        padding:18px;
        border-radius:14px;
    }

    .panel-header{
        margin-bottom:14px;
    }

    .panel-title h3{
        font-size:15px;
    }

    .panel-title p{
        font-size:10px;
    }

    .panel-tag{
        padding:6px 9px;
        font-size:9px;
    }

    .quick-menu{
        grid-template-columns:1fr;
        gap:9px;
    }

    .quick-item{
        min-height:65px;
        padding:12px;
    }

    .quick-icon{
        width:37px;
        height:37px;
        flex-basis:37px;
        font-size:12px;
    }

    .quick-content strong{
        font-size:13px;
    }

    .quick-content span{
        margin-top:3px;
        font-size:10.5px;
    }

    .status-item{
        padding:12px 0;
    }

    .status-icon{
        width:35px;
        height:35px;
        font-size:11px;
    }

    .status-text strong{
        font-size:12px;
    }

    .status-text span{
        font-size:10px;
    }

    .status-badge{
        padding:5px 8px;
        font-size:9px;
    }
.activity-empty strong{
        font-size:13px;
    }

    .activity-empty span{
        font-size:10px;
    }

    .dashboard-footer{
        margin-top:23px;
        padding-top:15px;
        gap:7px;
        font-size:10px;
    }
}

@media (max-width:380px){
    .dashboard-wrapper{
        padding:75px 12px 22px;
    }

    .dashboard-header h1{
        font-size:25px;
    }

    .dashboard-header p{
        font-size:12px;
    }

    .hero{
        padding:22px 18px;
    }

    .hero h2{
        font-size:21px;
    }

    .hero p{
        font-size:11.5px;
    }

    .stat-card{
        padding:16px;
    }

    .panel{
        padding:16px;
    }

    .quick-content strong{
        font-size:12.5px;
    }

    .quick-content span{
        font-size:10px;
    }
}

@media (max-width:1100px){
    .statistics{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .content-grid{
        grid-template-columns:1fr;
    }
}

@media (max-width:991px){
    .dashboard-wrapper{
        width:100%;
        margin-left:0;
        padding:90px 20px 30px;
    }
}

@media (max-width:650px){
    .dashboard-wrapper{
        padding:82px 14px 25px;
    }

    .dashboard-header{
        align-items:flex-start;
    }

    .dashboard-header h1{
        font-size:25px;
    }

    .hero{
        min-height:auto;
        padding:26px 22px;
        border-radius:18px;
    }

    .hero h2{
        font-size:22px;
    }

    .hero p{
        font-size:10px;
    }

    .statistics{
        grid-template-columns:1fr;
        gap:10px;
    }

    .quick-menu{
        grid-template-columns:1fr;
    }

    .dashboard-footer{
        align-items:flex-start;
        flex-direction:column;
    }
}

@media (prefers-reduced-motion:reduce){
    html{
        scroll-behavior:auto;
    }

    *,
    *::before,
    *::after{
        transition:none !important;
    }
}

/* FINAL RESPONSIVE OVERRIDE */
@media (max-width:900px){
    .dashboard-wrapper{
        width:100%;
        margin-left:0;
    }

    .admin-mobile-menu-button{
        display:flex;
    }
}

@media (min-width:901px) and (max-width:1199px){
    .dashboard-wrapper{
        margin-left:270px;
    }

    .admin-mobile-menu-button{
        display:none;
    }
}

@media (min-width:1200px) and (max-width:1399px){
    .dashboard-wrapper{
        margin-left:280px;
    }

    .admin-mobile-menu-button{
        display:none;
    }
}

@media (min-width:1400px){
    .dashboard-wrapper{
        margin-left:290px;
    }

    .admin-mobile-menu-button{
        display:none;
    }
}

</style>


<style id="noyo-gimbal-sidebar-reference-final">
/* =========================================================
   NOYO GIMBAL SIDEBAR — FLOATING GLASS
   Disamakan dengan screenshot referensi pengguna
   Responsive HP / Tablet dan aman untuk layar pendek
========================================================= */

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

    /* =====================================================
       SIDEBAR UTAMA
    ===================================================== */
    .admin-sidebar{
        position:fixed !important;

        top:14px !important;
        left:18px !important;
        right:auto !important;
        bottom:14px !important;

        width:min(320px,calc(100vw - 36px)) !important;
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

    /* =====================================================
       HEADER / BRAND
    ===================================================== */
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

    /* =====================================================
       CLOSE
    ===================================================== */
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
            color .2s ease,
            transform .2s ease !important;
    }

    .admin-sidebar-close-button:hover{
        background:rgba(226,201,151,.09) !important;
        border-color:rgba(226,201,151,.40) !important;
        color:#f8f4ed !important;
        transform:translateY(-1px) !important;
    }

    .admin-sidebar-close-button:focus-visible{
        outline:2px solid rgba(226,201,151,.72) !important;
        outline-offset:3px !important;
    }

    /* =====================================================
       ADMINISTRATOR CARD
    ===================================================== */
    .admin-sidebar-user{
        margin:11px 12px 10px !important;
        padding:10px !important;

        border:1px solid rgba(226,201,151,.10) !important;
        border-radius:14px !important;

        background:rgba(255,255,255,.028) !important;

        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.018) !important;
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

    /* =====================================================
       NAVIGATION
    ===================================================== */
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

    /* Active */
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

    /* =====================================================
       FOOTER
    ===================================================== */
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

    /* =====================================================
       OVERLAY
    ===================================================== */
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

    body.admin-sidebar-open,
    body.sidebar-open{
        overflow:hidden !important;
    }

    /* =====================================================
       HAMBURGER
    ===================================================== */
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

/* =========================================================
   HP
========================================================= */

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
        width:46px !important;
        height:46px !important;
    }
}

/* =========================================================
   HP KECIL
========================================================= */

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

/* =========================================================
   REDUCED MOTION
========================================================= */

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


/* =========================================================
   DASHBOARD — TANPA========================================================= */

/* Empat kartu statistik tetap memenuhi lebar secara proporsional. */
.statistics{
    grid-template-columns:repeat(4,minmax(0,1fr));
}

/* Tablet */
@media (max-width:1100px){
    .statistics{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

/* HP */
@media (max-width:650px){
    .statistics{
        grid-template-columns:1fr;
    }
}


/* =========================================================
   STATISTIK — 5 DATA MASTER
   Menu • Wahana • Oleh-Oleh • Bundling • Event
========================================================= */

.statistics{
    display:grid;
    grid-template-columns:repeat(5,minmax(0,1fr));
    gap:14px;
    margin-bottom:26px;
}

.stat-card{
    min-width:0;
}

.stat-label{
    min-height:36px;
    display:flex;
    align-items:flex-start;
}

@media (max-width:1400px){

    .statistics{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }
}

@media (max-width:900px){

    .statistics{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media (max-width:650px){

    .statistics{
        grid-template-columns:1fr;
    }

    .stat-label{
        min-height:auto;
    }
}

</style>

</head>

<body>

    

    @include('Admin.partials.sidebar')

    


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

    <main class="dashboard-wrapper">

        

        <header class="dashboard-header">

            <div class="header-left">
<h1>
                    Dashboard
                </h1>

                <p>
                    Selamat datang di panel pengelolaan Noyo Gimbal.
                </p>

            </div>
        </header>

        

        <section class="hero">

            <div class="hero-content">

                <div class="hero-small">

                    <i class="fa-solid fa-circle"></i>

                    Sistem Aktif

                </div>

                <h2>

                    Selamat datang,

                    <span>
                        {{ $user->nama ?? 'Administrator' }}
                    </span>

                </h2>

                <p>

                    Kelola seluruh kebutuhan operasional Noyo Gimbal
                    mulai dari menu, paket bundling, tiket wahana,
                    event yang akan datang, hingga produk oleh-oleh
                    melalui panel administrator.

                </p>

            </div>

        </section>

        

        <div class="section-title">

            <h2>
                Ringkasan
            </h2>

            <span>
                Data keseluruhan sistem
            </span>

        </div>

        <section class="statistics">

            {{-- TOTAL MENU --}}
            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-icon">
                        <i class="fa-solid fa-utensils"></i>
                    </div>

                    <div class="stat-status">
                        Tersedia
                    </div>

                </div>

                <div class="stat-label">
                    Total Menu
                </div>

                <div class="stat-value">
                    {{ number_format($statistics['total_menu'] ?? 0) }}
                </div>

            </div>


            {{-- TOTAL WAHANA --}}
            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-icon">
                        <i class="fa-solid fa-ticket"></i>
                    </div>

                    <div class="stat-status">
                        Aktif
                    </div>

                </div>

                <div class="stat-label">
                    Total Wahana
                </div>

                <div class="stat-value">
                    {{ number_format($statistics['total_wahana'] ?? 0) }}
                </div>

            </div>


            {{-- TOTAL OLEH-OLEH --}}
            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>

                    <div class="stat-status">
                        Tersedia
                    </div>

                </div>

                <div class="stat-label">
                    Total Oleh-Oleh
                </div>

                <div class="stat-value">
                    {{ number_format($statistics['total_oleholeh'] ?? 0) }}
                </div>

            </div>


            {{-- TOTAL PAKET BUNDLING --}}
            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-icon">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>

                    <div class="stat-status">
                        Tersedia
                    </div>

                </div>

                <div class="stat-label">
                    Total Paket Bundling
                </div>

                <div class="stat-value">
                    {{ number_format($statistics['total_bundling'] ?? 0) }}
                </div>

            </div>


            {{-- TOTAL EVENT --}}
            <div class="stat-card">

                <div class="stat-top">

                    <div class="stat-icon">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>

                    <div class="stat-status">
                        Aktif
                    </div>

                </div>

                <div class="stat-label">
                    Total Event
                </div>

                <div class="stat-value">
                    {{ number_format($statistics['total_event'] ?? 0) }}
                </div>

            </div>

        </section>

        

        <section class="content-grid">

            

            <div class="panel">

                <div class="panel-header">

                    <div class="panel-title">

                        <h3>
                            Manajemen
                        </h3>

                        <p>
                            Akses cepat pengelolaan sistem.
                        </p>

                    </div>

                    <div class="panel-tag">
                        Admin
                    </div>

                </div>

                <div class="quick-menu">

                    

                    <a
                        href="{{ url('/admin/menu') }}"
                        class="quick-item"
                    >

                        <div class="quick-icon">

                            <i class="fa-solid fa-utensils"></i>

                        </div>

                        <div class="quick-content">

                            <strong>
                                Menu
                            </strong>

                            <span>
                                Kelola makanan dan minuman.
                            </span>

                        </div>

                    </a>

                    

                    <a
                        href="{{ url('/admin/paketbundling') }}"
                        class="quick-item"
                    >

                        <div class="quick-icon">

                            <i class="fa-solid fa-boxes-stacked"></i>

                        </div>

                        <div class="quick-content">

                            <strong>
                                Paket Bundling
                            </strong>

                            <span>
                                Kelola paket dan kombinasi produk.
                            </span>

                        </div>

                    </a>

                    

                    <a
                        href="{{ url('/admin/tiket-wahana') }}"
                        class="quick-item"
                    >

                        <div class="quick-icon">

                            <i class="fa-solid fa-ticket"></i>

                        </div>

                        <div class="quick-content">

                            <strong>
                                Tiket Wahana
                            </strong>

                            <span>
                                Kelola tiket dan wahana wisata.
                            </span>

                        </div>

                    </a>

                    

                    <a
                        href="{{ url('/admin/oleholeh') }}"
                        class="quick-item"
                    >

                        <div class="quick-icon">

                            <i class="fa-solid fa-bag-shopping"></i>

                        </div>

                        <div class="quick-content">

                            <strong>
                                Oleh-Oleh
                            </strong>

                            <span>
                                Kelola produk oleh-oleh.
                            </span>

                        </div>

                    </a>

                    

                    <a
                        href="{{ Route::has('admin.event.index')
                            ? route('admin.event.index')
                            : url('/admin/event') }}"
                        class="quick-item"
                    >

                        <div class="quick-icon">

                            <i class="fa-solid fa-calendar-days"></i>

                        </div>

                        <div class="quick-content">

                            <strong>
                                Event
                            </strong>

                            <span>
                                Kelola event yang akan datang.
                            </span>

                        </div>

                    </a>

                    

                    <a
                        href="{{ url('/admin/pesanan') }}"
                        class="quick-item"
                    >

                        <div class="quick-icon">

                            <i class="fa-solid fa-receipt"></i>

                        </div>

                        <div class="quick-content">

                            <strong>
                                Pesanan
                            </strong>

                            <span>
                                Lihat dan kelola pesanan.
                            </span>

                        </div>

                    </a>

                </div>

            </div>

            

            <div class="panel">

                <div class="panel-header">

                    <div class="panel-title">

                        <h3>
                            Status Sistem
                        </h3>

                        <p>
                            Kondisi layanan saat ini.
                        </p>

                    </div>

                </div>

                <div class="status-list">

                    

                    <div class="status-item">

                        <div class="status-info">

                            <div class="status-icon">

                                <i class="fa-solid fa-server"></i>

                            </div>

                            <div class="status-text">

                                <strong>
                                    Server
                                </strong>

                                <span>
                                    Application server
                                </span>

                            </div>

                        </div>

                        <div class="status-badge">
                            Online
                        </div>

                    </div>

                    

                    <div class="status-item">

                        <div class="status-info">

                            <div class="status-icon">

                                <i class="fa-solid fa-database"></i>

                            </div>

                            <div class="status-text">

                                <strong>
                                    Database
                                </strong>

                                <span>
                                    Database connection
                                </span>

                            </div>

                        </div>

                        <div class="status-badge">
                            Connected
                        </div>

                    </div>

                    

                    <div class="status-item">

                        <div class="status-info">

                            <div class="status-icon">

                                <i class="fa-solid fa-shield-halved"></i>

                            </div>

                            <div class="status-text">

                                <strong>
                                    Authentication
                                </strong>

                                <span>
                                    Admin session
                                </span>

                            </div>

                        </div>

                        <div class="status-badge">
                            Secure
                        </div>

                    </div>

                    

                    <div class="status-item">

                        <div class="status-info">

                            <div class="status-icon">

                                <i class="fa-solid fa-user-check"></i>

                            </div>

                            <div class="status-text">

                                <strong>
                                    Akun Admin
                                </strong>

                                <span>
                                    {{ $user->email ?? 'Administrator' }}
                                </span>

                            </div>

                        </div>

                        <div class="status-badge">
                            Aktif
                        </div>

                    </div>

                </div>

            </div>

        </section>
<footer class="dashboard-footer">

            <span>
                © {{ date('Y') }} Noyo Gimbal
            </span>

            <span>
                Administrator Management System
            </span>

        </footer>

    </main>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const openButton = document.getElementById('openAdminSidebar');

    if (!openButton) {
        return;
    }

    openButton.addEventListener('click', function () {
        const sidebar = document.getElementById('adminSidebar');

        if (typeof window.openAdminSidebar === 'function') {
            window.openAdminSidebar();
            return;
        }

        if (sidebar) {
            sidebar.classList.add('open');
        }

        const overlay = document.getElementById('adminSidebarOverlay');

        if (overlay) {
            overlay.classList.add('show');
            overlay.setAttribute('aria-hidden', 'false');
        }

        document.body.classList.add('admin-sidebar-open');

        openButton.setAttribute('aria-expanded', 'true');
    });
});
</script>

</body>

</html>