<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Kelola Menu | Admin</title>

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
<link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >
<link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    >
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.tailwindcss.com"></script>
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

    --white:#fff;
    --black:#000;

    --shadow-soft:0 20px 60px rgba(0,0,0,.40);
    --shadow-hover:0 25px 70px rgba(0,0,0,.50);

    --radius-lg:28px;
    --radius-md:16px;
    --radius-sm:12px;
    --radius-full:999px;

    --transition:.25s cubic-bezier(.4,0,.2,1);

    --sidebar-width:270px;
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
    font-family:'Inter',ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
    background:
        radial-gradient(circle at 82% 8%,rgba(226,201,151,.055),transparent 30%),
        radial-gradient(circle at 8% 92%,rgba(226,201,151,.025),transparent 28%),
        var(--bg-primary);
    color:var(--text-primary);
    overflow-x:hidden;
    line-height:1.65;
}

button,
input,
select{
    font:inherit;
}

button,
a,
select{
    -webkit-tap-highlight-color:transparent;
}

::selection{
    background:rgba(226,201,151,.25);
    color:var(--text-primary);
}

.admin-main{
    min-height:100vh;
    margin-left:var(--sidebar-width);
    padding:48px 46px 60px;
    background:
        linear-gradient(180deg,rgba(255,255,255,.012),transparent 28%);
    transition:margin-left var(--transition),padding var(--transition);
}

.page-container{
    width:100%;
    max-width:1500px;
    margin:0 auto;
}

.page-enter{
    animation:pageEnter .45s ease-out both;
}

@keyframes pageEnter{
    from{
        opacity:0;
        transform:translateY(10px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}
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
    border:1px solid rgba(226,201,151,.25);
    border-radius:13px;
    background:rgba(18,18,18,.95);
    color:var(--accent);
    box-shadow:0 14px 35px rgba(0,0,0,.38);
    backdrop-filter:blur(16px);
    -webkit-backdrop-filter:blur(16px);
    cursor:pointer;
    transition:all var(--transition);
}

.admin-mobile-menu-button span{
    display:block;
    width:23px;
    height:2px;
    border-radius:999px;
    background:var(--accent);
}

.admin-mobile-menu-button:hover{
    border-color:rgba(226,201,151,.45);
    background:rgba(226,201,151,.09);
    transform:translateY(-1px);
}

.admin-mobile-menu-button:focus-visible{
    outline:2px solid rgba(226,201,151,.75);
    outline-offset:3px;
}
.top-section{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:30px;
    margin-bottom:30px;
}

.header-text-wrapper{
    min-width:0;
}


.dashboard-title{
    margin:0 0 12px;
    font-family:'Playfair Display',serif;
    font-size:clamp(36px,4vw,56px);
    font-weight:700;
    line-height:1.08;
    letter-spacing:-.7px;
    background:linear-gradient(135deg,var(--accent) 0%,#f8f4ed 50%,var(--accent-dark) 100%);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
}

.dashboard-desc{
    max-width:720px;
    margin:0;
    color:var(--text-muted);
    font-size:16px;
    line-height:1.75;
}
.btn-add{
    position:relative;
    flex:0 0 auto;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    min-height:52px;
    padding:0 22px;
    border:1px solid rgba(255,255,255,.08);
    border-radius:var(--radius-full);
    overflow:hidden;
    background:linear-gradient(135deg,var(--accent),var(--accent-hover));
    color:var(--bg-primary);
    font-size:15px;
    font-weight:800;
    letter-spacing:.1px;
    text-decoration:none;
    white-space:nowrap;
    box-shadow:0 12px 35px rgba(226,201,151,.12);
    transition:all var(--transition);
}

.btn-add:hover{
    background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark));
    color:var(--bg-primary);
    transform:translateY(-3px);
    box-shadow:var(--shadow-hover);
}

.btn-add:active{
    transform:translateY(-1px);
}
.custom-alert{
    display:flex;
    align-items:flex-start;
    gap:14px;
    margin-bottom:22px;
    padding:15px 17px;
    border-radius:var(--radius-md);
    font-size:14px;
    backdrop-filter:blur(14px);
    -webkit-backdrop-filter:blur(14px);
}

.custom-alert.success{
    border:1px solid rgba(127,201,149,.22);
    background:rgba(127,201,149,.075);
    color:#c9efd3;
}

.custom-alert.danger{
    border:1px solid rgba(239,110,110,.22);
    background:rgba(239,110,110,.075);
    color:#ffd0d0;
}

.alert-icon{
    display:flex;
    align-items:center;
    justify-content:center;
    width:34px;
    height:34px;
    flex-shrink:0;
    border:1px solid rgba(255,255,255,.07);
    border-radius:10px;
    background:rgba(255,255,255,.045);
}

.alert-content{
    flex:1;
    min-width:0;
}

.alert-title{
    margin-bottom:2px;
    font-size:14px;
    font-weight:700;
}

.alert-desc{
    color:inherit;
    font-size:13px;
    line-height:1.55;
    opacity:.88;
}

.alert-close{
    display:flex;
    align-items:center;
    justify-content:center;
    width:32px;
    height:32px;
    flex-shrink:0;
    border:0;
    border-radius:9px;
    background:transparent;
    color:currentColor;
    cursor:pointer;
    opacity:.65;
    transition:all var(--transition);
}

.alert-close:hover{
    background:rgba(255,255,255,.07);
    opacity:1;
}
.toolbar-card{
    margin-bottom:18px;
    padding:18px;
    border:1px solid var(--border-soft);
    border-radius:var(--radius-md);
    background:
        linear-gradient(145deg,rgba(255,255,255,.035),rgba(255,255,255,.012)),
        var(--bg-card);
    box-shadow:var(--shadow-soft);
}

.toolbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:18px;
}

.toolbar-left{
    display:flex;
    align-items:center;
    gap:11px;
    flex:1;
    min-width:0;
}
.search-wrapper{
    position:relative;
    width:100%;
    max-width:420px;
}

.search-icon{
    position:absolute;
    top:50%;
    left:15px;
    color:var(--text-dim);
    transform:translateY(-50%);
    pointer-events:none;
}

.search-input{
    width:100%;
    height:48px;
    padding:0 42px;
    border:1px solid var(--border-soft);
    border-radius:12px;
    outline:none;
    background:rgba(255,255,255,.035);
    color:var(--text-primary);
    font-size:14px;
    transition:all var(--transition);
}

.search-input::placeholder{
    color:var(--text-dim);
}

.search-input:focus{
    border-color:var(--border-gold);
    background:rgba(226,201,151,.045);
    box-shadow:0 0 0 3px rgba(226,201,151,.055);
}

.clear-search{
    position:absolute;
    top:50%;
    right:10px;
    display:none;
    align-items:center;
    justify-content:center;
    width:28px;
    height:28px;
    padding:0;
    border:0;
    border-radius:8px;
    background:transparent;
    color:var(--text-muted);
    cursor:pointer;
    transform:translateY(-50%);
}

.clear-search:hover{
    background:rgba(255,255,255,.07);
    color:var(--accent);
}
.select-wrapper{
    position:relative;
    width:195px;
    flex-shrink:0;
}

.select-wrapper.small{
    width:88px;
}

.filter-select{
    width:100%;
    height:48px;
    padding:0 38px 0 14px;
    border:1px solid var(--border-soft);
    border-radius:12px;
    outline:none;
    appearance:none;
    background:rgba(255,255,255,.035);
    color:var(--text-secondary);
    font-size:14px;
    cursor:pointer;
    transition:all var(--transition);
}

.filter-select option{
    background:#171717;
    color:var(--text-primary);
}

.filter-select:focus{
    border-color:var(--border-gold);
    background:rgba(226,201,151,.045);
}

.select-arrow{
    position:absolute;
    top:50%;
    right:13px;
    color:var(--text-dim);
    pointer-events:none;
    transform:translateY(-50%);
}

.display-control{
    display:flex;
    align-items:center;
    gap:9px;
    color:var(--text-muted);
    font-size:13px;
    white-space:nowrap;
}
.table-card{
    overflow:hidden;
    border:1px solid var(--border-soft);
    border-radius:var(--radius-md);
    background:var(--bg-card);
    box-shadow:var(--shadow-soft);
}

.table-responsive{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
    scrollbar-width:thin;
    scrollbar-color:rgba(226,201,151,.35) transparent;
}

.table-responsive::-webkit-scrollbar{
    height:7px;
}

.table-responsive::-webkit-scrollbar-track{
    background:rgba(255,255,255,.025);
}

.table-responsive::-webkit-scrollbar-thumb{
    border-radius:999px;
    background:rgba(226,201,151,.30);
}

.menu-table{
    width:100%;
    min-width:920px;
    border-collapse:collapse;
}

.menu-table thead{
    background:rgba(255,255,255,.025);
}

.menu-table th{
    padding:16px 18px;
    border-bottom:1px solid var(--border-soft);
    color:var(--text-muted);
    font-size:12px;
    font-weight:700;
    letter-spacing:1px;
    text-align:left;
    text-transform:uppercase;
    white-space:nowrap;
}

.menu-table th.center{
    text-align:center;
}

.menu-table td{
    padding:17px 18px;
    border-bottom:1px solid rgba(255,255,255,.045);
    color:var(--text-secondary);
    vertical-align:middle;
}

.menu-table tbody tr{
    transition:background var(--transition);
}

.menu-table tbody tr:hover{
    background:rgba(226,201,151,.035);
}

.menu-table tbody tr:last-child td{
    border-bottom:0;
}

.row-number{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:30px;
    color:var(--text-dim);
    font-size:13px;
}
.menu-info{
    display:flex;
    align-items:center;
    gap:14px;
    min-width:330px;
}

.menu-image{
    display:flex;
    align-items:center;
    justify-content:center;
    width:62px;
    height:62px;
    flex-shrink:0;
    overflow:hidden;
    border:1px solid var(--border-gold);
    border-radius:13px;
    background:var(--bg-soft);
}

.menu-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:transform .3s ease;
}

.menu-row:hover .menu-image img{
    transform:scale(1.045);
}

.menu-image-placeholder{
    display:flex;
    align-items:center;
    justify-content:center;
    width:100%;
    height:100%;
    color:var(--accent-dark);
    background:rgba(226,201,151,.045);
    font-size:18px;
}

.menu-details{
    min-width:0;
}

.menu-name{
    margin-bottom:4px;
    color:var(--text-primary);
    font-size:15px;
    font-weight:750;
    line-height:1.4;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.menu-description{
    max-width:380px;
    color:var(--text-muted);
    font-size:14px;
    line-height:1.65;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}
.category-badge{
    display:inline-flex;
    align-items:center;
    padding:7px 11px;
    border:1px solid var(--border-soft);
    border-radius:var(--radius-full);
    background:rgba(255,255,255,.035);
    color:var(--text-secondary);
    font-size:12px;
    font-weight:600;
    white-space:nowrap;
}

.category-badge.paket-kenyang,
.category-badge.minuman,
.category-badge.sambal,
.category-badge.lainnya{
    border-color:var(--border-gold);
    background:rgba(226,201,151,.055);
    color:var(--text-secondary);
}
.menu-price{
    color:var(--text-primary);
    font-size:16px;
    font-weight:800;
    white-space:nowrap;
}
.status-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    min-height:34px;
    padding:7px 12px;
    border:1px solid transparent;
    border-radius:var(--radius-full);
    font-size:13px;
    font-weight:700;
    white-space:nowrap;
}

.status-dot{
    width:7px;
    height:7px;
    border-radius:50%;
}

.status-badge.available{
    border-color:rgba(127,201,149,.20);
    background:rgba(127,201,149,.08);
    color:#9fe0af;
}

.status-badge.available .status-dot{
    background:#7fc995;
    box-shadow:0 0 8px rgba(127,201,149,.35);
}

.status-badge.empty{
    border-color:rgba(239,110,110,.20);
    background:rgba(239,110,110,.08);
    color:#ffb0b0;
}

.status-badge.empty .status-dot{
    background:#ef7474;
}
.action-group{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:7px;
}

.action-button{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:38px;
    height:38px;
    border:1px solid var(--border-soft);
    border-radius:10px;
    background:rgba(255,255,255,.035);
    color:var(--text-muted);
    text-decoration:none;
    cursor:pointer;
    transition:all var(--transition);
}

.action-button:hover{
    transform:translateY(-2px);
}

.action-button.edit:hover{
    border-color:var(--border-gold);
    background:rgba(226,201,151,.10);
    color:var(--accent);
}

.action-button.delete:hover{
    border-color:rgba(239,110,110,.25);
    background:rgba(239,110,110,.09);
    color:#ff9f9f;
}

.delete-form{
    margin:0;
}
.empty-state{
    padding:75px 25px;
    text-align:center;
}

.empty-icon{
    display:flex;
    align-items:center;
    justify-content:center;
    width:68px;
    height:68px;
    margin:0 auto 18px;
    border:1px solid var(--border-gold);
    border-radius:18px;
    background:rgba(226,201,151,.055);
    color:var(--accent);
    font-size:21px;
}

.empty-state h3{
    margin:0;
    color:var(--text-primary);
    font-size:17px;
    font-weight:700;
}

.empty-state p{
    max-width:440px;
    margin:8px auto 0;
    color:var(--text-muted);
    font-size:13px;
    line-height:1.7;
}

.empty-add-button{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-top:20px;
    padding:11px 16px;
    border:1px solid var(--accent);
    border-radius:var(--radius-full);
    background:rgba(226,201,151,.10);
    color:var(--accent);
    font-size:13px;
    font-weight:700;
    text-decoration:none;
    transition:all var(--transition);
}

.empty-add-button:hover{
    background:var(--accent);
    color:var(--bg-primary);
    transform:translateY(-2px);
}

#searchEmptyRow{
    display:none;
}

.menu-row.hidden-row{
    display:none;
}
.table-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    padding:16px 18px;
    border-top:1px solid var(--border-soft);
    background:rgba(255,255,255,.018);
}

.pagination-info{
    color:var(--text-muted);
    font-size:12px;
    white-space:nowrap;
}

.pagination{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
}

.pagination-button{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:38px;
    height:38px;
    padding:0 9px;
    border:1px solid var(--border-soft);
    border-radius:10px;
    background:rgba(255,255,255,.035);
    color:var(--text-muted);
    font-size:12px;
    font-weight:700;
    cursor:pointer;
    transition:all var(--transition);
}

.pagination-button:hover:not(:disabled){
    border-color:var(--border-gold);
    background:rgba(226,201,151,.075);
    color:var(--accent);
}

.pagination-button.active{
    border-color:var(--accent);
    background:var(--accent);
    color:var(--bg-primary);
}

.pagination-button:disabled{
    opacity:.35;
    cursor:not-allowed;
}

.pagination-dots{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:28px;
    height:38px;
    color:var(--text-dim);
    font-size:13px;
}
:focus-visible{
    outline:2px solid rgba(226,201,151,.70);
    outline-offset:3px;
}
@media (min-width:1400px){
    .admin-main{
        margin-left:285px;
        padding:54px 58px 70px;
    }

    .dashboard-title{
        font-size:56px;
    }

    .dashboard-desc{
        font-size:16px;
    }
}

@media (min-width:1101px) and (max-width:1399px){
    .admin-main{
        margin-left:270px;
        padding:48px 38px 60px;
    }

    .dashboard-title{
        font-size:48px;
    }

    .dashboard-desc{
        font-size:16px;
    }
}

@media (min-width:901px) and (max-width:1100px){
    .admin-main{
        margin-left:0;
        padding:108px 30px 52px;
    }

    .admin-mobile-menu-button{
        display:flex;
    }

    .top-section{
        align-items:flex-start;
    }

    .dashboard-title{
        font-size:44px;
    }

    .dashboard-desc{
        font-size:15px;
    }

    .btn-add{
        min-height:50px;
        padding:0 20px;
    }
}

@media (max-width:900px){
    .admin-mobile-menu-button{
        display:flex;
    }

    .admin-main{
        width:100%;
        margin-left:0;
        padding:94px 22px 42px;
    }

    .top-section{
        align-items:stretch;
        flex-direction:column;
        gap:20px;
        margin-bottom:28px;
    }

    .dashboard-title{
        font-size:38px;
    }

    .dashboard-desc{
        font-size:15px;
        line-height:1.7;
    }

    .btn-add{
        width:100%;
        min-height:54px;
        font-size:15px;
    }

    .toolbar{
        align-items:stretch;
        flex-direction:column;
    }

    .toolbar-left{
        align-items:stretch;
        flex-direction:column;
    }

    .search-wrapper{
        max-width:none;
    }

    .select-wrapper{
        width:100%;
    }

    .display-control{
        justify-content:flex-end;
    }
}

@media (min-width:601px) and (max-width:900px){
    .admin-main{
        padding:92px 30px 48px;
    }

    .dashboard-title{
        font-size:38px;
    }

    .toolbar-card{
        padding:20px;
    }

    .search-input,
    .filter-select{
        height:50px;
        font-size:14px;
    }

    .menu-table th{
        font-size:12px;
    }

    .menu-table td{
        padding-top:18px;
        padding-bottom:18px;
    }
}
@media (max-width:600px){
    .admin-mobile-menu-button{
        top:14px;
        left:14px;
        width:46px;
        height:46px;
        border-radius:13px;
    }

    .admin-main{
        padding:82px 15px 32px;
    }

    .dashboard-title{
        font-size:33px;
        letter-spacing:-.4px;
    }

    .dashboard-desc{
        font-size:14px;
    }

    .btn-add{
        min-height:52px;
        border-radius:15px;
        font-size:15px;
    }

    .menu-name{
        font-size:15px;
    }

    .menu-description{
        font-size:14px;
    }

    .menu-price{
        font-size:16px;
    }

    .status-badge{
        font-size:13px;
    }
}
@media (max-width:380px){
    .admin-main{
        padding:76px 12px 25px;
    }

    .dashboard-title{
        font-size:26px;
    }

    .dashboard-desc{
        font-size:12.5px;
    }

    .btn-add{
        min-height:48px;
        font-size:13px;
    }

    .toolbar-card{
        padding:11px;
    }

    .menu-table{
        min-width:880px;
    }
}
@media (prefers-reduced-motion:reduce){
    *,
    *::before,
    *::after{
        scroll-behavior:auto !important;
        transition:none !important;
        animation:none !important;
    }
}

    .swal2-container{
        z-index:99999 !important;
        padding:24px !important;
        background:rgba(0,0,0,.72) !important;
        backdrop-filter:blur(8px) !important;
        -webkit-backdrop-filter:blur(8px) !important;
    }

    .ng-delete-content{
        width:100%;
        margin-top:14px;
    }

    .ng-delete-menu-name{
        display:flex;
        align-items:center;
        gap:10px;
        width:100%;
        margin:0 auto 15px;
        padding:12px 14px;
        border:1px solid rgba(226,201,151,.14);
        border-radius:14px;
        background:rgba(226,201,151,.055);
        color:var(--text-primary);
        text-align:left;
        font-size:14px;
        font-weight:700;
    }

    .ng-delete-menu-name i{
        flex-shrink:0;
        color:var(--accent);
    }

    .ng-delete-menu-name span{
        min-width:0;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }

    .ng-delete-content p{
        margin:0 auto;
        max-width:365px;
        color:var(--text-muted);
        font-family:'Inter',sans-serif;
        font-size:14px;
        line-height:1.7;
    }

    .ng-delete-content p strong{
        color:var(--text-secondary);
    }

    .ng-delete-warning{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        margin:15px auto 0;
        padding:10px 12px;
        border:1px solid rgba(239,110,110,.15);
        border-radius:12px;
        background:rgba(239,110,110,.055);
        color:#e8a4a4;
        font-size:12px;
        line-height:1.5;
    }

    .ng-delete-warning i{
        color:#ef8585;
    }

    .ng-delete-popup{
        width:min(470px,calc(100vw - 30px)) !important;
        padding:32px 32px 28px !important;
        border:1px solid rgba(226,201,151,.18) !important;
        border-radius:28px !important;
        background:
            radial-gradient(circle at 50% 0%,rgba(226,201,151,.07),transparent 38%),
            linear-gradient(145deg,rgba(255,255,255,.045),rgba(255,255,255,.012)),
            #121212 !important;
        box-shadow:0 30px 90px rgba(0,0,0,.62),0 0 0 1px rgba(255,255,255,.025) !important;
        color:var(--text-primary) !important;
    }

    .ng-delete-popup .swal2-icon{
        width:72px !important;
        height:72px !important;
        margin:0 auto 20px !important;
        border:1px solid rgba(226,201,151,.25) !important;
        border-radius:22px !important;
        background:rgba(226,201,151,.08) !important;
        color:var(--accent) !important;
        box-shadow:0 14px 35px rgba(0,0,0,.25) !important;
    }

    .ng-delete-popup .swal2-icon.swal2-warning{
        border-color:rgba(226,201,151,.25) !important;
        color:var(--accent) !important;
    }

    .ng-delete-popup .swal2-icon.swal2-warning .swal2-icon-content{
        color:var(--accent) !important;
        font-size:34px !important;
        font-weight:700 !important;
    }

    .ng-delete-popup .swal2-title{
        margin:0 !important;
        padding:0 !important;
        color:var(--text-primary) !important;
        font-family:'Playfair Display',serif !important;
        font-size:26px !important;
        font-weight:700 !important;
        line-height:1.25 !important;
    }

    .ng-delete-popup .swal2-html-container{
        margin:11px auto 0 !important;
        max-width:365px !important;
        color:var(--text-muted) !important;
        font-family:'Inter',sans-serif !important;
        font-size:14px !important;
        line-height:1.7 !important;
    }

    .ng-delete-popup .swal2-actions{
        width:100% !important;
        margin:25px 0 0 !important;
        gap:10px !important;
        flex-wrap:nowrap !important;
    }

    .ng-delete-confirm,
    .ng-delete-cancel{
        min-width:145px !important;
        min-height:48px !important;
        margin:0 !important;
        padding:0 20px !important;
        border-radius:999px !important;
        font-family:'Inter',sans-serif !important;
        font-size:14px !important;
        font-weight:700 !important;
        line-height:1 !important;
        transition:all .25s cubic-bezier(.4,0,.2,1) !important;
        box-shadow:none !important;
    }

    .ng-delete-confirm{
        border:1px solid rgba(239,110,110,.48) !important;
        background:linear-gradient(135deg,#b94f4f,#963b3b) !important;
        color:#fff !important;
    }

    .ng-delete-confirm:hover{
        border-color:rgba(255,155,155,.72) !important;
        background:linear-gradient(135deg,#c85a5a,#a64242) !important;
        color:#fff !important;
        transform:translateY(-2px) !important;
        box-shadow:0 14px 30px rgba(130,35,35,.28) !important;
    }

    .ng-delete-cancel{
        border:1px solid rgba(226,201,151,.16) !important;
        background:rgba(255,255,255,.045) !important;
        color:var(--text-secondary) !important;
    }

    .ng-delete-cancel:hover{
        border-color:rgba(226,201,151,.40) !important;
        background:rgba(226,201,151,.08) !important;
        color:var(--accent) !important;
        transform:translateY(-2px) !important;
    }

    .ng-delete-popup .swal2-close{
        position:absolute !important;
        top:15px !important;
        right:16px !important;
        width:34px !important;
        height:34px !important;
        border-radius:10px !important;
        color:var(--text-dim) !important;
        font-size:22px !important;
        transition:all .25s ease !important;
    }

    .ng-delete-popup .swal2-close:hover{
        background:rgba(255,255,255,.06) !important;
        color:var(--accent) !important;
    }

    @media (max-width:600px){
        .swal2-container{
            padding:15px !important;
        }

        .ng-delete-popup{
            width:100% !important;
            padding:29px 20px 22px !important;
            border-radius:23px !important;
        }

        .ng-delete-menu-name{
            margin-bottom:13px;
            padding:11px 12px;
            font-size:13px;
        }

        .ng-delete-content p{
            font-size:13px;
        }

        .ng-delete-warning{
            font-size:11.5px;
        }


        .ng-delete-popup .swal2-icon{
            width:64px !important;
            height:64px !important;
            margin-bottom:17px !important;
            border-radius:19px !important;
        }

        .ng-delete-popup .swal2-icon.swal2-warning .swal2-icon-content{
            font-size:30px !important;
        }

        .ng-delete-popup .swal2-title{
            font-size:23px !important;
        }

        .ng-delete-popup .swal2-html-container{
            max-width:330px !important;
            font-size:13px !important;
        }

        .ng-delete-popup .swal2-actions{
            flex-direction:column-reverse !important;
            gap:9px !important;
            margin-top:22px !important;
        }

        .ng-delete-confirm,
        .ng-delete-cancel{
            width:100% !important;
            min-width:0 !important;
            min-height:50px !important;
        }
    }

    @media (prefers-reduced-motion:reduce){
        .ng-delete-confirm,
        .ng-delete-cancel,
        .ng-delete-popup .swal2-close{
            transition:none !important;
        }
    }

</style>



<style id="noyo-gimbal-sidebar-reference-final">
/* =========================================================
   NOYO GIMBAL SIDEBAR — REFERENSI MOBILE / TABLET
   Floating • Glass • Rounded • Tidak Terpotong
========================================================= */

@media (max-width:900px){

    html, body{
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

    .admin-sidebar-close-button:focus-visible{
        outline:2px solid rgba(226,201,151,.72) !important;
        outline-offset:3px !important;
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
        padding:9px 11px max(11px,env(safe-area-inset-bottom)) !important;

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

    body.admin-sidebar-open,
    body.sidebar-open{
        overflow:hidden !important;
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
<main class="admin-main page-enter">

        <div class="page-container">
<section class="top-section">

                <div class="header-text-wrapper">
<h1 class="dashboard-title">
                        Kelola Menu
                    </h1>

                    <p class="dashboard-desc">
                        Kelola daftar makanan, minuman, sambal, dan menu lainnya
                        yang tersedia di Noyo Gimbal.
                    </p>

                </div>
<a
                    href="{{ route('admin.menu.create') }}"
                    class="btn-add"
                >

                    <i class="fa-solid fa-plus"></i>

                    <span>
                        Tambah Menu
                    </span>

                </a>

            </section>
@if(session('success'))

                <div class="custom-alert success">

                    <div class="alert-icon">

                        <i class="fa-solid fa-check"></i>

                    </div>

                    <div class="alert-content">

                        <div class="alert-title">
                            Berhasil
                        </div>

                        <div class="alert-desc">
                            {{ session('success') }}
                        </div>

                    </div>

                    <button
                        type="button"
                        class="alert-close"
                        onclick="this.parentElement.remove()"
                    >

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

            @endif
@if(session('error'))

                <div class="custom-alert danger">

                    <div class="alert-icon">

                        <i class="fa-solid fa-circle-exclamation"></i>

                    </div>

                    <div class="alert-content">

                        <div class="alert-title">
                            Terjadi Kesalahan
                        </div>

                        <div class="alert-desc">
                            {{ session('error') }}
                        </div>

                    </div>

                    <button
                        type="button"
                        class="alert-close"
                        onclick="this.parentElement.remove()"
                    >

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

            @endif
@if($errors->any())

                <div class="custom-alert danger">

                    <div class="alert-icon">

                        <i class="fa-solid fa-triangle-exclamation"></i>

                    </div>

                    <div class="alert-content">

                        <div class="alert-title">
                            Validasi Gagal
                        </div>

                        <div class="alert-desc">
                            {{ $errors->first() }}
                        </div>

                    </div>

                    <button
                        type="button"
                        class="alert-close"
                        onclick="this.parentElement.remove()"
                    >

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

            @endif
<section class="toolbar-card">

                <div class="toolbar">
<div class="toolbar-left">
<div class="search-wrapper">

                            <i
                                class="fa-solid fa-magnifying-glass search-icon"
                            ></i>


                            <input
                                type="text"
                                id="searchMenu"
                                class="search-input"
                                placeholder="Cari nama menu..."
                                autocomplete="off"
                            >


                            <button
                                type="button"
                                id="clearSearch"
                                class="clear-search"
                                aria-label="Hapus pencarian"
                            >

                                <i class="fa-solid fa-xmark"></i>

                            </button>

                        </div>
<div class="select-wrapper">

                            <select
                                id="filterKategori"
                                class="filter-select"
                            >

                                <option value="">
                                    Semua Kategori
                                </option>

                                <option value="Paket Kenyang">
                                    Paket Kenyang
                                </option>

                                <option value="Minuman">
                                    Minuman
                                </option>

                                <option value="Sambal">
                                    Sambal
                                </option>

                                <option value="Lainnya">
                                    Lainnya
                                </option>

                            </select>


                            <i
                                class="fa-solid fa-chevron-down select-arrow"
                            ></i>

                        </div>

                    </div>
<div class="display-control">

                        <span>
                            Tampilkan
                        </span>


                        <div class="select-wrapper small">

                            <select
                                id="perPage"
                                class="filter-select"
                            >

                                <option value="5">
                                    5
                                </option>

                                <option
                                    value="10"
                                    selected
                                >
                                    10
                                </option>

                            </select>


                            <i
                                class="fa-solid fa-chevron-down select-arrow"
                            ></i>

                        </div>


                        <span>
                            data
                        </span>

                    </div>

                </div>

            </section>
<section class="table-card">

                <div class="table-responsive">

                    <table class="menu-table">
<thead>

                            <tr>

                                <th
                                    class="center"
                                    style="width: 65px;"
                                >
                                    No
                                </th>


                                <th>
                                    Menu
                                </th>


                                <th
                                    style="width: 145px;"
                                >
                                    Kategori
                                </th>


                                <th
                                    style="width: 150px;"
                                >
                                    Harga
                                </th>


                                <th
                                    class="center"
                                    style="width: 135px;"
                                >
                                    Status
                                </th>


                                <th
                                    class="center"
                                    style="width: 125px;"
                                >
                                    Aksi
                                </th>

                            </tr>

                        </thead>
<tbody id="menuTableBody">


                            @forelse($menus as $menu)

                                <tr
                                    class="menu-row"
                                    data-name="{{ strtolower($menu->nama_menu) }}"
                                    data-kategori="{{ $menu->kategori }}"
                                    data-id="{{ $menu->id_menu }}"
                                >
<td class="text-center">

                                        <span class="row-number">
                                            {{ $loop->iteration }}
                                        </span>

                                    </td>
<td>

                                        <div class="menu-info">
<div class="menu-image">

                                                @if($menu->gambar)

                                                    <img
                                                        src="{{ asset('storage/' . $menu->gambar) }}"
                                                        alt="{{ $menu->nama_menu }}"
                                                        loading="lazy"
                                                    >

                                                @else

                                                    <div class="menu-image-placeholder">

                                                        <i class="fa-solid fa-utensils"></i>

                                                    </div>

                                                @endif

                                            </div>
<div class="menu-details">

                                                <div class="menu-name">

                                                    {{ $menu->nama_menu }}

                                                </div>


                                                @if($menu->deskripsi)

                                                    <div class="menu-description">

                                                        {{ $menu->deskripsi }}

                                                    </div>

                                                @else

                                                    <div class="menu-description">

                                                        Tidak ada deskripsi.

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </td>
<td>

                                        @php

                                            $categoryClass = match(
                                                $menu->kategori
                                            ) {

                                                'Paket Kenyang' => 'paket-kenyang',

                                                'Minuman' => 'minuman',

                                                'Sambal' => 'sambal',

                                                default => 'lainnya',

                                            };

                                        @endphp


                                        <span
                                            class="category-badge {{ $categoryClass }}"
                                        >

                                            {{ $menu->kategori }}

                                        </span>

                                    </td>
<td>

                                        <span class="menu-price">

                                            Rp
                                            {{ number_format(
                                                $menu->harga,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </span>

                                    </td>
<td class="text-center">

                                        @if($menu->status === 'Tersedia')

                                            <span class="status-badge available">

                                                <span class="status-dot"></span>

                                                Tersedia

                                            </span>

                                        @else

                                            <span class="status-badge empty">

                                                <span class="status-dot"></span>

                                                Habis

                                            </span>

                                        @endif

                                    </td>
<td>

                                        <div class="action-group">
<a
                                                href="{{ route(
                                                    'admin.menu.edit',
                                                    $menu->id_menu
                                                ) }}"
                                                class="action-button edit"
                                                title="Edit menu"
                                            >

                                                <i class="fa-solid fa-pen"></i>

                                            </a>
<form
                                                action="{{ route(
                                                    'admin.menu.destroy',
                                                    $menu->id_menu
                                                ) }}"
                                                method="POST"
                                                class="delete-form"
                                            >

                                                @csrf

                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="action-button delete delete-menu-button"
                                                    title="Hapus menu"
                                                >

                                                    <i class="fa-regular fa-trash-can"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                            @empty
<tr id="databaseEmptyRow">

                                    <td colspan="6">

                                        <div class="empty-state">

                                            <div class="empty-icon">

                                                <i class="fa-solid fa-utensils"></i>

                                            </div>


                                            <h3>
                                                Belum Ada Menu
                                            </h3>


                                            <p>
                                                Belum terdapat data menu yang tersimpan.
                                                Tambahkan menu pertama untuk mulai mengelola
                                                daftar makanan dan minuman.
                                            </p>


                                            <a
                                                href="{{ route('admin.menu.create') }}"
                                                class="empty-add-button"
                                            >

                                                <i class="fa-solid fa-plus"></i>

                                                Tambah Menu

                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse
<tr id="searchEmptyRow">

                                <td colspan="6">

                                    <div class="empty-state">

                                        <div class="empty-icon">

                                            <i class="fa-solid fa-magnifying-glass"></i>

                                        </div>


                                        <h3>
                                            Menu Tidak Ditemukan
                                        </h3>


                                        <p>
                                            Tidak ada menu yang sesuai dengan
                                            pencarian atau kategori yang dipilih.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>
<div
                    class="table-footer"
                    id="tableFooter"
                >
<div
                        class="pagination-info"
                        id="paginationInfo"
                    >

                        Menampilkan 0 data

                    </div>
<div
                        class="pagination"
                        id="pagination"
                    >
<button
                            type="button"
                            id="prevPage"
                            class="pagination-button"
                            aria-label="Halaman sebelumnya"
                        >

                            <i class="fa-solid fa-chevron-left"></i>

                        </button>
<div
                            id="pageNumbers"
                            class="flex items-center gap-[5px]"
                        >
                        </div>
<button
                            type="button"
                            id="nextPage"
                            class="pagination-button"
                            aria-label="Halaman berikutnya"
                        >

                            <i class="fa-solid fa-chevron-right"></i>

                        </button>

                    </div>

                </div>

            </section>

        </div>

    </main>
<script>

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        document.addEventListener(
            'DOMContentLoaded',
            function () {
const searchInput =
                    document.getElementById(
                        'searchMenu'
                    );


                const clearSearch =
                    document.getElementById(
                        'clearSearch'
                    );


                const kategoriSelect =
                    document.getElementById(
                        'filterKategori'
                    );


                const perPageSelect =
                    document.getElementById(
                        'perPage'
                    );


                const paginationInfo =
                    document.getElementById(
                        'paginationInfo'
                    );


                const pagination =
                    document.getElementById(
                        'pagination'
                    );


                const pageNumbers =
                    document.getElementById(
                        'pageNumbers'
                    );


                const prevPage =
                    document.getElementById(
                        'prevPage'
                    );


                const nextPage =
                    document.getElementById(
                        'nextPage'
                    );


                const searchEmptyRow =
                    document.getElementById(
                        'searchEmptyRow'
                    );


                const databaseEmptyRow =
                    document.getElementById(
                        'databaseEmptyRow'
                    );


                const menuRows =
                    Array.from(
                        document.querySelectorAll(
                            '.menu-row'
                        )
                    );
let currentPage = 1;


                let perPage =
                    parseInt(
                        perPageSelect.value,
                        10
                    );


                let filteredRows = [
                    ...menuRows
                ];
function filterData() {

                    const keyword =
                        searchInput.value
                            .trim()
                            .toLowerCase();


                    const kategori =
                        kategoriSelect.value;


                    filteredRows =
                        menuRows.filter(
                            function (row) {

                                const name =
                                    row.dataset.name || '';


                                const rowKategori =
                                    row.dataset.kategori || '';


                                const matchName =
                                    name.includes(
                                        keyword
                                    );


                                const matchKategori =
                                    !kategori ||
                                    rowKategori === kategori;


                                return (
                                    matchName &&
                                    matchKategori
                                );

                            }
                        );


                    currentPage = 1;


                    updateClearButton();

                    renderTable();

                }
function updateClearButton() {

                    if (
                        searchInput.value
                            .trim() !== ''
                    ) {

                        clearSearch.style.display =
                            'flex';

                    } else {

                        clearSearch.style.display =
                            'none';

                    }

                }
function renderTable() {
menuRows.forEach(
                        function (row) {

                            row.classList.add(
                                'hidden-row'
                            );

                        }
                    );
if (
                        menuRows.length === 0
                    ) {

                        if (databaseEmptyRow) {

                            databaseEmptyRow.style.display =
                                '';

                        }


                        if (searchEmptyRow) {

                            searchEmptyRow.style.display =
                                'none';

                        }


                        pagination.style.display =
                            'none';


                        paginationInfo.textContent =
                            'Belum ada data';


                        return;

                    }
if (databaseEmptyRow) {

                        databaseEmptyRow.style.display =
                            'none';

                    }
if (
                        filteredRows.length === 0
                    ) {

                        if (searchEmptyRow) {

                            searchEmptyRow.style.display =
                                '';

                        }


                        pagination.style.display =
                            'none';


                        paginationInfo.textContent =
                            'Tidak ada data yang ditemukan.';


                        return;

                    }
if (searchEmptyRow) {

                        searchEmptyRow.style.display =
                            'none';

                    }
const total =
                        filteredRows.length;


                    const totalPages =
                        Math.ceil(
                            total /
                            perPage
                        );
if (
                        currentPage >
                        totalPages
                    ) {

                        currentPage =
                            totalPages;

                    }
const start =
                        (
                            currentPage - 1
                        ) *
                        perPage;


                    const end =
                        Math.min(
                            start + perPage,
                            total
                        );
const currentRows =
                        filteredRows.slice(
                            start,
                            end
                        );
currentRows.forEach(
                        function (
                            row,
                            index
                        ) {

                            row.classList.remove(
                                'hidden-row'
                            );


                            const number =
                                row.querySelector(
                                    '.row-number'
                                );


                            if (number) {

                                number.textContent =
                                    start +
                                    index +
                                    1;

                            }

                        }
                    );
paginationInfo.textContent =
                        `Menampilkan ${
                            start + 1
                        }–${
                            end
                        } dari ${
                            total
                        } data`;
if (
                        totalPages <= 1
                    ) {

                        pagination.style.display =
                            'none';

                    } else {

                        pagination.style.display =
                            'flex';

                    }
prevPage.disabled =
                        currentPage === 1;


                    nextPage.disabled =
                        currentPage === totalPages;


                    renderPageNumbers(
                        totalPages
                    );

                }
function renderPageNumbers(
                    totalPages
                ) {

                    pageNumbers.innerHTML =
                        '';


                    const maxVisible =
                        5;


                    let startPage =
                        Math.max(
                            1,
                            currentPage - 2
                        );


                    let endPage =
                        Math.min(
                            totalPages,
                            startPage +
                            maxVisible -
                            1
                        );


                    if (
                        endPage -
                        startPage +
                        1 <
                        maxVisible
                    ) {

                        startPage =
                            Math.max(
                                1,
                                endPage -
                                maxVisible +
                                1
                            );

                    }
if (
                        startPage > 1
                    ) {

                        addPageButton(1);


                        if (
                            startPage > 2
                        ) {

                            addEllipsis();

                        }

                    }
for (
                        let page =
                            startPage;

                        page <=
                            endPage;

                        page++
                    ) {

                        addPageButton(
                            page
                        );

                    }
if (
                        endPage <
                        totalPages
                    ) {

                        if (
                            endPage <
                            totalPages - 1
                        ) {

                            addEllipsis();

                        }


                        addPageButton(
                            totalPages
                        );

                    }

                }
function addPageButton(
                    page
                ) {

                    const button =
                        document.createElement(
                            'button'
                        );


                    button.type =
                        'button';


                    button.className =
                        'pagination-button';


                    button.textContent =
                        page;


                    if (
                        page ===
                        currentPage
                    ) {

                        button.classList.add(
                            'active'
                        );

                    }


                    button.addEventListener(
                        'click',
                        function () {

                            currentPage =
                                page;


                            renderTable();


                            scrollToTable();

                        }
                    );


                    pageNumbers.appendChild(
                        button
                    );

                }
function addEllipsis() {

                    const span =
                        document.createElement(
                            'span'
                        );


                    span.className =
                        'pagination-dots';


                    span.textContent =
                        '…';


                    pageNumbers.appendChild(
                        span
                    );

                }
function scrollToTable() {

                    const table =
                        document.getElementById(
                            'menuTableBody'
                        );


                    if (!table) {

                        return;

                    }


                    const rect =
                        table.getBoundingClientRect();


                    if (
                        rect.top < 0 ||
                        rect.top >
                        window.innerHeight
                    ) {

                        window.scrollTo({

                            top:
                                window.scrollY +
                                rect.top -
                                130,

                            behavior:
                                'smooth'

                        });

                    }

                }
searchInput.addEventListener(
                    'input',
                    function () {

                        filterData();

                    }
                );
kategoriSelect.addEventListener(
                    'change',
                    function () {

                        filterData();

                    }
                );
perPageSelect.addEventListener(
                    'change',
                    function () {

                        perPage =
                            parseInt(
                                perPageSelect.value,
                                10
                            );


                        currentPage =
                            1;


                        renderTable();

                    }
                );
clearSearch.addEventListener(
                    'click',
                    function () {

                        searchInput.value =
                            '';


                        filterData();


                        searchInput.focus();

                    }
                );
prevPage.addEventListener(
                    'click',
                    function () {

                        if (
                            currentPage >
                            1
                        ) {

                            currentPage--;


                            renderTable();


                            scrollToTable();

                        }

                    }
                );
nextPage.addEventListener(
                    'click',
                    function () {

                        const totalPages =
                            Math.ceil(
                                filteredRows.length /
                                perPage
                            );


                        if (
                            currentPage <
                            totalPages
                        ) {

                            currentPage++;


                            renderTable();


                            scrollToTable();

                        }

                    }
                );
document
                    .querySelectorAll(
                        '.delete-menu-button'
                    )
                    .forEach(
                        function (button) {

                            button.addEventListener(
                                'click',
                                function (event) {

                                    event.preventDefault();


                                    const form =
                                        button.closest(
                                            'form'
                                        );


                                    const menuNameElement =
                                        button
                                            .closest('tr')
                                            ?.querySelector('.menu-name');

                                    const menuName =
                                        menuNameElement
                                            ? menuNameElement.textContent.trim()
                                            : 'menu ini';

                                    Swal.fire({
                                        title: 'Hapus menu secara permanen?',
                                        html: `
                                            <div class="ng-delete-content">
                                                <div class="ng-delete-menu-name">
                                                    <i class="fa-solid fa-utensils"></i>
                                                    <span>${escapeHtml(menuName)}</span>
                                                </div>

                                                <p>
                                                    Menu ini akan dihapus dari daftar menu
                                                    <strong>beserta menu yg sudah dimasukkan ke bundling</strong>.
                                                </p>
                                            </div>
                                        `,
                                        icon: 'warning',
                                        showCancelButton: true,
                                        showCloseButton: true,
                                        confirmButtonText:
                                            '<i class="fa-solid fa-trash-can" style="margin-right:7px;"></i> Hapus Permanen',
                                        cancelButtonText:
                                            '<i class="fa-solid fa-xmark" style="margin-right:7px;"></i> Batal',
                                        reverseButtons: true,
                                        buttonsStyling: false,
                                        allowOutsideClick: true,
                                        allowEscapeKey: true,
                                        focusCancel: true,
                                        customClass: {
                                            popup: 'ng-delete-popup',
                                            confirmButton: 'ng-delete-confirm',
                                            cancelButton: 'ng-delete-cancel'
                                        }
                                    }).then(
                                        function (result) {
                                            if (result.isConfirmed) {
                                                form.submit();
                                            }
                                        }
                                    );

                                }
                            );

                        }
                    );
renderTable();


            }
        );

    </script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const openButton = document.getElementById('openAdminSidebar');

    if (!openButton) return;

    openButton.addEventListener('click', function () {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminSidebarOverlay');

        if (typeof window.openAdminSidebar === 'function') {
            window.openAdminSidebar();
        } else {
            if (sidebar) sidebar.classList.add('open');

            if (overlay) {
                overlay.classList.add('show');
                overlay.setAttribute('aria-hidden', 'false');
            }

            document.body.classList.add('admin-sidebar-open');
        }

        openButton.setAttribute('aria-expanded', 'true');
    });
});
</script>

</body>

</html>