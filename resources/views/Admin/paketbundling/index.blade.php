<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Paket Bundling</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        @import "tailwindcss";

        /* =========================
           DESIGN SYSTEM
        ========================= */
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

            --transition:.25s cubic-bezier(0.4,0,0.2,1);
            --sidebar-width:280px;
        }

        /* =========================
           RESET
        ========================= */
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
            font-family:'Inter',sans-serif;
            background:
                radial-gradient(circle at 88% 4%,rgba(226,201,151,.045),transparent 30%),
                radial-gradient(circle at 4% 95%,rgba(226,201,151,.025),transparent 28%),
                var(--bg-primary);
            color:var(--text-primary);
            overflow-x:hidden;
            line-height:1.65;
            font-size:15px;
        }

        button,
        input,
        select{
            font:inherit;
        }

        ::selection{
            background:rgba(226,201,151,.25);
            color:var(--text-primary);
        }

        /* =========================
           MOBILE SIDEBAR BUTTON
        ========================= */
        .admin-mobile-menu-button{
            display:none;
            position:fixed;
            top:16px;
            left:16px;
            z-index:1250;
            width:50px;
            height:50px;
            padding:0;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            gap:5px;
            border:1px solid rgba(226,201,151,.2);
            border-radius:14px;
            background:rgba(18,18,18,.92);
            color:var(--text-primary);
            box-shadow:0 15px 40px rgba(0,0,0,.35);
            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);
            cursor:pointer;
            transition:all var(--transition);
        }

        .admin-mobile-menu-button:hover{
            border-color:rgba(226,201,151,.5);
            background:rgba(226,201,151,.08);
            transform:translateY(-2px);
        }

        .admin-mobile-menu-button:active{
            transform:scale(.96);
        }

        .admin-mobile-menu-button span{
            width:21px;
            height:2px;
            border-radius:999px;
            background:var(--text-primary);
            transition:all var(--transition);
        }

        /* =========================
           MAIN LAYOUT
        ========================= */
        .bundling-page{
            width:calc(100% - var(--sidebar-width));
            margin-left:var(--sidebar-width);
            min-height:100vh;
            padding:54px 46px 72px;
        }

        .bundling-inner{
            width:min(100%,1480px);
            margin:0 auto;
        }

        /* =========================
           HEADER
        ========================= */
        .page-header{
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:30px;
            margin-bottom:34px;
        }

        .page-header-copy{
            min-width:0;
        }

        .page-title{
            margin:0;
            font-family:'Playfair Display',Georgia,serif;
            font-size:clamp(40px,4vw,58px);
            font-weight:700;
            line-height:1.08;
            letter-spacing:-1.2px;
        }

        .text-gradient{
            background:
                linear-gradient(
                    135deg,
                    var(--accent) 0%,
                    #f8f4ed 50%,
                    var(--accent-dark) 100%
                );
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            background-clip:text;
        }

        .page-description{
            max-width:720px;
            margin-top:11px;
            color:var(--text-muted);
            font-size:16px;
            line-height:1.75;
        }

        /* =========================
           BUTTONS
        ========================= */
        .btn-primary-travel{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:9px;
            min-height:56px;
            padding:0 24px;
            border-radius:var(--radius-full);
            background:linear-gradient(135deg,var(--accent) 0%,var(--accent-hover) 100%);
            color:var(--bg-primary);
            text-decoration:none;
            font-size:15px;
            font-weight:800;
            letter-spacing:.1px;
            box-shadow:0 12px 30px rgba(0,0,0,.24);
            position:relative;
            overflow:hidden;
            white-space:nowrap;
            transition:all var(--transition);
        }

        .btn-primary-travel:hover{
            background:linear-gradient(135deg,var(--accent-hover) 0%,var(--accent-dark) 100%);
            transform:translateY(-3px);
            box-shadow:var(--shadow-hover);
        }

        .btn-primary-travel:active{
            transform:translateY(-1px);
        }

        .action-button{
            width:46px;
            height:46px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border:1px solid var(--border-gold);
            border-radius:13px;
            background:rgba(226,201,151,.045);
            color:var(--text-secondary);
            text-decoration:none;
            cursor:pointer;
            transition:all var(--transition);
        }

        .action-button:hover{
            color:var(--accent);
            border-color:rgba(226,201,151,.48);
            background:rgba(226,201,151,.10);
            transform:translateY(-2px);
        }

        .action-button.delete:hover{
            color:#f0a4a4;
            border-color:rgba(205,100,100,.45);
            background:rgba(157,75,75,.12);
        }

        /* =========================
           FLASH MESSAGES
        ========================= */
        .flash-stack{
            display:grid;
            gap:12px;
            margin-bottom:20px;
        }

        .flash-message{
            display:flex;
            align-items:flex-start;
            gap:12px;
            padding:17px 18px;
            border:1px solid var(--border-gold);
            border-radius:18px;
            background:rgba(255,255,255,.03);
            box-shadow:var(--shadow-soft);
            color:var(--text-secondary);
            font-size:15px;
            line-height:1.6;
        }

        .flash-message.success .flash-icon{
            color:#8fe6bd;
        }

        .flash-message.error .flash-icon,
        .flash-message.validation .flash-icon{
            color:#efabab;
        }

        .flash-icon{
            width:34px;
            height:34px;
            flex:0 0 34px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:10px;
            background:rgba(226,201,151,.08);
        }

        .flash-message ul{
            margin:7px 0 0;
            padding-left:18px;
        }

        /* =========================
           FILTER TOOLBAR
        ========================= */
        .filter-toolbar{
            display:grid;
            grid-template-columns:minmax(0,1fr) minmax(430px,470px);
            gap:12px;
            margin-bottom:18px;
            padding:13px;
            border:1px solid rgba(255,255,255,.07);
            border-radius:20px;
            background:
                linear-gradient(145deg,rgba(255,255,255,.045),rgba(255,255,255,.018)),
                rgba(18,18,18,.92);
            box-shadow:0 18px 55px rgba(0,0,0,.28);
            width:100%;
            max-width:100%;
            overflow:visible;
        }

        .search-wrap{
            position:relative;
            min-width:0;
        }

        .search-wrap input{
            width:100%;
            height:56px;
            padding:0 50px 0 54px;
            border:1px solid rgba(255,255,255,.07);
            border-radius:15px;
            outline:none;
            background:rgba(255,255,255,.035);
            color:var(--text-primary);
            font-size:16px;
            line-height:1.5;
            transition:all var(--transition);
        }

        .search-wrap input::placeholder{
            color:var(--text-dim);
            opacity:.95;
        }

        .search-wrap input:focus{
            border-color:rgba(226,201,151,.52);
            background:rgba(226,201,151,.045);
            box-shadow:0 0 0 4px rgba(226,201,151,.06);
        }

        .search-icon{
            position:absolute;
            left:19px;
            top:50%;
            z-index:2;
            color:var(--text-dim);
            font-size:16px;
            transform:translateY(-50%);
            pointer-events:none;
        }

        .search-clear{
            position:absolute;
            right:10px;
            top:50%;
            width:34px;
            height:34px;
            display:none;
            align-items:center;
            justify-content:center;
            border:0;
            border-radius:10px;
            background:rgba(255,255,255,.05);
            color:var(--text-muted);
            cursor:pointer;
            transform:translateY(-50%);
            transition:all var(--transition);
        }

        .search-clear:hover{
            color:var(--accent);
            background:rgba(226,201,151,.09);
        }

        .filter-select-wrap{
            position:relative;
        }

        .filter-select-label{
            position:absolute;
            left:15px;
            top:50%;
            display:flex;
            align-items:center;
            gap:8px;
            color:var(--text-dim);
            font-size:13px;
            font-weight:700;
            transform:translateY(-50%);
            pointer-events:none;
            transition:opacity var(--transition);
        }

        .filter-select-label i{
            color:var(--accent);
            font-size:12px;
        }

        .filter-select-wrap select{
            width:100%;
            min-width:215px;
            height:56px;
            appearance:none;
            -webkit-appearance:none;
            padding:0 46px 0 84px;
            border:1px solid rgba(255,255,255,.07);
            border-radius:15px;
            outline:none;
            background:#181818;
            color:var(--text-primary);
            font-size:15px;
            font-weight:700;
            cursor:pointer;
            transition:all var(--transition);
            text-overflow:clip;
            white-space:nowrap;
            overflow:visible;
        }

        .filter-select-wrap select:focus{
            border-color:rgba(226,201,151,.52);
            box-shadow:0 0 0 4px rgba(226,201,151,.06);
        }

        .filter-select-wrap select option{
            background:#171717;
            color:var(--text-primary);
        }

        .filter-select-arrow{
            position:absolute;
            right:17px;
            top:50%;
            color:var(--text-dim);
            font-size:12px;
            pointer-events:none;
            transform:translateY(-50%);
        }


        /* =========================
           PAGINATION
        ========================= */
        .filter-controls-right{
            display:grid;
            grid-template-columns:minmax(215px,1fr) 205px;
            align-items:center;
            gap:12px;
            min-width:0;
            width:100%;
        }

        .per-page-wrap{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            min-height:56px;
            min-width:205px;
            width:205px;
            padding:0 14px;
            border:1px solid rgba(255,255,255,.07);
            border-radius:15px;
            background:rgba(255,255,255,.025);
            white-space:nowrap;
        }

        .per-page-label{
            color:var(--text-dim);
            font-size:13px;
            font-weight:700;
            white-space:nowrap;
        }

        .per-page-select{
            height:40px;
            min-width:72px;
            width:72px;
            padding:0 24px 0 13px;
            border:1px solid rgba(226,201,151,.13);
            border-radius:11px;
            background:#181818;
            color:var(--text-primary);
            outline:none;
            appearance:auto;
            text-align:center;
            text-align-last:center;
            font-size:14px;
            font-weight:800;
            cursor:pointer;
        }

        .pagination-wrap{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:16px;
            padding:13px 18px;
            border-top:1px solid rgba(255,255,255,.04);
            background:rgba(255,255,255,.012);
            flex-wrap:wrap;
        }

        .pagination-wrap[hidden]{
            display:none !important;
        }

        .pagination-controls{
            display:flex;
            align-items:center;
            gap:7px;
            flex-wrap:wrap;
        }

        .page-button{
            min-width:40px;
            height:40px;
            padding:0 11px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(226,201,151,.13);
            border-radius:11px;
            background:rgba(226,201,151,.035);
            color:var(--text-secondary);
            font-size:13px;
            font-weight:800;
            cursor:pointer;
            transition:all var(--transition);
        }

        .page-button:hover:not(:disabled){
            border-color:rgba(226,201,151,.42);
            background:rgba(226,201,151,.09);
            color:var(--accent);
            transform:translateY(-1px);
        }

        .page-button.active{
            border-color:rgba(226,201,151,.52);
            background:linear-gradient(135deg,var(--accent),var(--accent-hover));
            color:var(--bg-primary);
        }

        .page-button:disabled{
            opacity:.35;
            cursor:not-allowed;
        }

        .page-ellipsis{
            color:var(--text-dim);
            font-size:13px;
            padding:0 2px;
        }

        /* =========================
           TABLE CARD
        ========================= */
        .table-card{
            border:1px solid var(--border-gold);
            border-radius:var(--radius-lg);
            background:
                radial-gradient(circle at 100% 0%,rgba(226,201,151,.045),transparent 30%),
                linear-gradient(145deg,rgba(255,255,255,.035),rgba(255,255,255,.015)),
                rgba(18,18,18,.96);
            box-shadow:var(--shadow-soft);
            overflow:hidden;
        }

        .table-scroll{
            width:100%;
            overflow-x:hidden;
            overflow-y:hidden;
        }

        .bundling-table{
            width:100%;
            min-width:0;
            table-layout:fixed;
            border-collapse:separate;
            border-spacing:0;
        }

        .bundling-table th:nth-child(1),
        .bundling-table td:nth-child(1){width:9%;}
        .bundling-table th:nth-child(2),
        .bundling-table td:nth-child(2){width:15%;}
        .bundling-table th:nth-child(3),
        .bundling-table td:nth-child(3){width:11%;}
        .bundling-table th:nth-child(4),
        .bundling-table td:nth-child(4){width:17%;}
        .bundling-table th:nth-child(5),
        .bundling-table td:nth-child(5){width:17%;}
        .bundling-table th:nth-child(6),
        .bundling-table td:nth-child(6){width:10%;}
        .bundling-table th:nth-child(7),
        .bundling-table td:nth-child(7){width:12%;}
        .bundling-table th:nth-child(8),
        .bundling-table td:nth-child(8){width:9%;}

        .bundling-table thead th{
            padding:18px 12px;
            border-bottom:1px solid rgba(226,201,151,.12);
            background:rgba(255,255,255,.018);
            color:var(--text-muted);
            font-size:13px;
            font-weight:800;
            line-height:1.4;
            letter-spacing:.65px;
            text-align:left;
            text-transform:uppercase;
            white-space:nowrap;
        }

        .bundling-table thead th.center{
            text-align:center;
        }

        .bundling-table tbody tr{
            background:rgba(0,0,0,.04);
            transition:background var(--transition),transform var(--transition);
        }

        .bundling-table tbody tr:hover{
            background:rgba(226,201,151,.035);
        }

        .bundling-table tbody td{
            padding:17px 12px;
            border-bottom:1px solid rgba(255,255,255,.045);
            color:var(--text-secondary);
            font-size:15px;
            line-height:1.6;
            vertical-align:middle;
        }

        .bundling-table tbody td:nth-child(4),
        .bundling-table tbody td:nth-child(5){
            vertical-align:top;
        }

        .bundling-table tbody tr:last-child td{
            border-bottom:0;
        }

        .bundle-image{
            width:78px;
            height:78px;
            display:block;
            object-fit:cover;
            border:1px solid rgba(226,201,151,.12);
            border-radius:16px;
            background:var(--bg-soft);
            box-shadow:0 10px 26px rgba(0,0,0,.18);
        }

        .bundle-image-placeholder{
            width:78px;
            height:78px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(226,201,151,.12);
            border-radius:16px;
            background:linear-gradient(145deg,#1c1c1c,#121212);
            color:var(--accent);
            font-size:22px;
        }

        .bundle-name{
            display:block;
            max-width:270px;
            overflow:hidden;
            color:var(--text-primary);
            font-size:16px;
            font-weight:800;
            line-height:1.4;
            text-overflow:ellipsis;
            white-space:nowrap;
        }


        .target-badge{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-height:38px;
            padding:0 14px;
            border:1px solid rgba(226,201,151,.17);
            border-radius:var(--radius-full);
            background:rgba(226,201,151,.075);
            color:var(--accent);
            font-size:14px;
            font-weight:800;
            white-space:nowrap;
        }

        .item-list{
            display:flex;
            flex-direction:column;
            gap:5px;
            width:min(100%,220px);
            min-width:150px;
        }

        .item-list span{
            display:block;
            max-width:100%;
            overflow:hidden;
            color:var(--text-secondary);
            font-size:14px;
            line-height:1.45;
            white-space:nowrap;
            text-overflow:ellipsis;
        }

        .item-list .item-more{
            color:var(--text-dim);
            font-weight:800;
            letter-spacing:1px;
        }

        .item-empty{
            color:var(--text-dim) !important;
            font-size:14px !important;
        }

        .price{
            color:var(--accent);
            font-family:'Inter',sans-serif;
            font-size:16px;
            font-weight:800;
            white-space:nowrap;
        }

        .status-badge{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:7px;
            min-height:38px;
            padding:0 14px;
            border-radius:var(--radius-full);
            font-size:14px;
            font-weight:800;
            white-space:nowrap;
        }

        .status-badge.available{
            border:1px solid rgba(127,201,149,.18);
            background:rgba(127,201,149,.085);
            color:#9be4bd;
        }

        .status-badge.unavailable{
            border:1px solid rgba(236,130,130,.18);
            background:rgba(236,130,130,.075);
            color:#f1aaaa;
        }

        .action-group{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
        }

        .table-empty{
            padding:82px 28px !important;
            text-align:center;
        }

        .table-empty-icon{
            width:70px;
            height:70px;
            margin:0 auto 18px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(226,201,151,.18);
            border-radius:20px;
            background:rgba(226,201,151,.065);
            color:var(--accent);
            font-size:26px;
        }

        .table-empty h3{
            margin:0;
            color:var(--text-primary);
            font-family:'Playfair Display',Georgia,serif;
            font-size:25px;
            font-weight:700;
        }

        .table-empty p{
            margin-top:7px;
            color:var(--text-muted);
            font-size:15px;
        }

        /* =========================
           TABLE FOOTER SUMMARY
        ========================= */
        .table-footer{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            padding:15px 18px;
            border-top:1px solid rgba(255,255,255,.04);
            background:rgba(255,255,255,.012);
        }

        .table-summary{
            display:flex;
            align-items:center;
            gap:10px;
            color:var(--text-dim);
            font-size:13px;
            line-height:1.5;
        }

        .table-summary strong{
            color:var(--text-secondary);
            font-weight:800;
        }

        .table-summary-icon{
            width:32px;
            height:32px;
            flex:0 0 32px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(226,201,151,.11);
            border-radius:9px;
            background:rgba(226,201,151,.045);
            color:rgba(226,201,151,.7);
            font-size:12px;
        }

        /* =========================
           DELETE MODAL
        ========================= */
        .delete-modal-backdrop{
            position:fixed;
            inset:0;
            z-index:3000;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
            background:rgba(0,0,0,.72);
            backdrop-filter:blur(10px);
            -webkit-backdrop-filter:blur(10px);
            opacity:0;
            visibility:hidden;
            pointer-events:none;
            transition:opacity .22s ease,visibility .22s ease;
        }

        .delete-modal-backdrop.show{
            opacity:1;
            visibility:visible;
            pointer-events:auto;
        }

        .delete-modal{
            position:relative;
            width:min(100%,500px);
            padding:36px;
            border:1px solid rgba(226,201,151,.18);
            border-radius:28px;
            background:
                radial-gradient(circle at 50% 0%,rgba(226,201,151,.09),transparent 42%),
                linear-gradient(145deg,rgba(255,255,255,.055),rgba(255,255,255,.018)),
                #121212;
            box-shadow:0 35px 100px rgba(0,0,0,.65);
            transform:translateY(18px) scale(.97);
            transition:transform .25s cubic-bezier(.4,0,.2,1);
        }

        .delete-modal-backdrop.show .delete-modal{
            transform:translateY(0) scale(1);
        }

        .delete-modal-close{
            position:absolute;
            top:16px;
            right:16px;
            width:40px;
            height:40px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(255,255,255,.08);
            border-radius:50%;
            background:rgba(255,255,255,.035);
            color:var(--text-muted);
            font-size:16px;
            cursor:pointer;
            transition:all .2s ease;
        }

        .delete-modal-close:hover{
            color:var(--accent);
            border-color:var(--border-gold);
            background:rgba(226,201,151,.08);
            transform:rotate(8deg);
        }

        .delete-modal-icon{
            width:68px;
            height:68px;
            margin:0 auto 22px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(226,201,151,.25);
            border-radius:22px;
            background:rgba(226,201,151,.075);
            color:var(--accent);
            font-size:26px;
        }

        .delete-modal-content{
            text-align:center;
        }

        .delete-modal-eyebrow{
            margin:0 0 7px;
            color:var(--accent);
            font-size:12px;
            font-weight:800;
            letter-spacing:1.5px;
            text-transform:uppercase;
        }

        .delete-modal-content h2{
            margin:0;
            color:var(--text-primary);
            font-family:'Playfair Display',Georgia,serif;
            font-size:30px;
            font-weight:700;
            line-height:1.25;
        }

        .delete-modal-message{
            max-width:390px;
            margin:13px auto 0;
            color:var(--text-muted);
            font-size:15px;
            line-height:1.7;
        }

        .delete-modal-message strong{
            color:var(--text-secondary);
            font-weight:800;
        }

        .delete-modal-actions{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:12px;
            margin-top:28px;
        }

        .delete-modal-actions button{
            min-height:52px;
            border-radius:var(--radius-full);
            font-size:15px;
            font-weight:800;
            cursor:pointer;
            transition:all var(--transition);
        }

        .delete-cancel{
            border:1px solid var(--border-soft);
            background:rgba(255,255,255,.035);
            color:var(--text-secondary);
        }

        .delete-cancel:hover{
            border-color:var(--border-gold);
            background:rgba(226,201,151,.08);
            color:var(--accent);
            transform:translateY(-2px);
        }

        .delete-confirm{
            border:1px solid rgba(180,72,72,.55);
            background:linear-gradient(135deg,#9d4b4b,#713737);
            color:#fff4f1;
            box-shadow:0 10px 28px rgba(80,25,25,.25);
        }

        .delete-confirm:hover{
            background:linear-gradient(135deg,#b65a5a,#843e3e);
            transform:translateY(-2px);
            box-shadow:0 16px 35px rgba(80,25,25,.35);
        }

        body.modal-open{
            overflow:hidden;
        }

        /* =========================
           RESPONSIVE
        ========================= */
        @media (min-width:1400px){
            :root{
                --sidebar-width:290px;
            }

            .bundling-page{
                padding:58px 60px 78px;
            }
        }

        @media (min-width:901px) and (max-width:1199px){
            :root{
                --sidebar-width:270px;
            }

            .bundling-page{
                padding:42px 22px 58px;
            }

            .page-title{
                font-size:42px;
            }

            .page-description{
                font-size:15px;
            }
        }

        @media (max-width:1100px) and (min-width:901px){
            .page-header{
                align-items:flex-start;
                flex-direction:column;
                gap:20px;
            }

            .btn-primary-travel{
                width:100%;
            }

            .filter-toolbar{
                grid-template-columns:1fr;
            }

            .filter-controls-right{
                grid-template-columns:minmax(0,1fr) 205px;
            }

            .filter-select-wrap{
                width:100%;
                min-width:0;
            }

            .filter-select-wrap select{
                padding-left:88px;
            }

            .per-page-wrap{
                min-width:190px;
            }
        }

        @media (max-width:900px){
            .admin-mobile-menu-button{
                display:flex;
            }

            .bundling-page{
                width:100%;
                margin-left:0;
                padding:92px 26px 48px;
            }

            .page-header{
                align-items:flex-start;
                flex-direction:column;
                gap:18px;
                margin-bottom:26px;
            }

            .page-title{
                font-size:44px;
            }

            .page-description{
                font-size:15px;
            }

            .btn-primary-travel{
                width:100%;
            }

            .filter-toolbar{
                grid-template-columns:1fr;
            }

            .filter-controls-right{
                grid-template-columns:1fr;
            }

            .per-page-wrap{
                justify-content:center;
                width:100%;
                min-width:0;
            }

            .per-page-select{
                width:72px;
                min-width:72px;
            }

            .table-card{
                border-radius:22px;
            }
        }

        @media (max-width:600px){
            .admin-mobile-menu-button{
                top:12px;
                left:12px;
                width:48px;
                height:48px;
            }

            .bundling-page{
                padding:78px 15px 36px;
            }

            .page-title{
                font-size:38px;
                letter-spacing:-.7px;
            }

            .page-description{
                font-size:14px;
                line-height:1.7;
            }

            .btn-primary-travel{
                min-height:56px;
                padding:0 20px;
                font-size:15px;
            }

            .flash-message{
                padding:15px;
                font-size:14px;
            }

            .filter-toolbar{
                padding:11px;
                border-radius:18px;
            }

            .search-wrap input,
            .filter-select-wrap select{
                height:56px;
                font-size:15px;
            }

            .search-wrap input{
                padding-left:55px;
            }

            .table-footer{
                align-items:flex-start;
                padding:13px 15px;
            }

            .table-summary{
                font-size:13px;
            }

            .delete-modal-backdrop{
                padding:16px;
            }

            .delete-modal{
                padding:30px 20px 22px;
                border-radius:24px;
            }

            .delete-modal-icon{
                width:60px;
                height:60px;
                margin-bottom:18px;
                border-radius:19px;
                font-size:23px;
            }

            .delete-modal-content h2{
                font-size:26px;
            }

            .delete-modal-message{
                font-size:15px;
            }

            .delete-modal-actions{
                grid-template-columns:1fr;
            }

            .delete-modal-actions button{
                min-height:54px;
            }
        }

        @media (max-width:380px){
            .bundling-page{
                padding-left:12px;
                padding-right:12px;
            }

            .page-title{
                font-size:34px;
            }

            .filter-toolbar{
                padding:9px;
            }

            .table-card{
                border-radius:19px;
            }
        }

        /* =========================
           HORIZONTAL SCROLL - TABLET & HP
        ========================= */
        @media (max-width:900px){
            .table-scroll{
                overflow-x:auto;
                overflow-y:hidden;
                -webkit-overflow-scrolling:touch;
                scrollbar-width:thin;
                scrollbar-color:rgba(226,201,151,.28) transparent;
            }

            .table-scroll::-webkit-scrollbar{
                height:7px;
            }

            .table-scroll::-webkit-scrollbar-thumb{
                background:rgba(226,201,151,.24);
                border-radius:999px;
            }

            .bundling-table{
                min-width:1080px;
                table-layout:fixed;
            }
        }

        @media (max-width:600px){
            .bundling-table{
                min-width:1040px;
            }
        }

        @media (prefers-reduced-motion:reduce){
            *,*::before,*::after{
                scroll-behavior:auto !important;
                animation:none !important;
                transition:none !important;
            }
        }
    </style>


<style>
/* =========================================================
   SIDEBAR HP / TABLET — FLOATING GLASS
   Referensi: sidebar kecil, rounded, transparan, tidak terpotong
========================================================= */

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
                rgba(18,18,18,.91) 0%,
                rgba(10,10,10,.84) 100%
            ) !important;

        backdrop-filter:blur(22px) saturate(120%) !important;
        -webkit-backdrop-filter:blur(22px) saturate(120%) !important;

        box-shadow:
            18px 0 60px rgba(0,0,0,.40),
            0 12px 45px rgba(0,0,0,.24) !important;

        overflow:hidden !important;
        isolation:isolate !important;

        transform:translate3d(calc(-100% - 18px),0,0) !important;
        transition:transform .30s cubic-bezier(.4,0,.2,1) !important;

        z-index:2100 !important;
    }

    .admin-sidebar.open{
        transform:translate3d(0,0,0) !important;
    }

    /* Header brand */
    .admin-sidebar-brand{
        position:relative !important;
        padding:18px 13px 13px !important;

        border-bottom:1px solid rgba(255,255,255,.055) !important;
        background:rgba(0,0,0,.07) !important;
    }

    .admin-brand-link{
        display:flex !important;
        align-items:center !important;
        gap:11px !important;
        min-width:0 !important;
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

    /* Tombol close */
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
        border-color:rgba(226,201,151,.40) !important;
    }

    /* Administrator */
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

    /* Overlay transparan */
    .admin-sidebar-overlay{
        display:block !important;
        position:fixed !important;
        inset:0 !important;

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

    /* Hamburger */
    .admin-mobile-menu-button{
        display:flex !important;

        position:fixed !important;
        top:18px !important;
        left:18px !important;
        right:auto !important;

        width:48px !important;
        height:48px !important;

        z-index:2000 !important;

        align-items:center !important;
        justify-content:center !important;
        flex-direction:column !important;
        gap:5px !important;

        border:1px solid rgba(226,201,151,.20) !important;
        border-radius:14px !important;

        background:rgba(18,18,18,.90) !important;
        color:#e2c997 !important;

        box-shadow:0 12px 35px rgba(0,0,0,.32) !important;

        backdrop-filter:blur(18px) !important;
        -webkit-backdrop-filter:blur(18px) !important;

        cursor:pointer !important;
    }

    .admin-mobile-menu-button span{
        width:19px !important;
        height:2px !important;
        border-radius:99px !important;
        background:currentColor !important;
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

    @include('admin.partials.sidebar')

    <main class="bundling-page">
        <div class="bundling-inner">

            <header class="page-header">
                <div class="page-header-copy">
                    <h1 class="page-title text-gradient">
                        Kelola Paket Bundling
                    </h1>

                    <p class="page-description">
                        Kombinasikan tiket masuk, wahana, dan menu menjadi paket menarik.
                    </p>
                </div>

                <a
                    href="{{ route('admin.paketbundling.create') }}"
                    class="btn-primary-travel"
                >
                    <i class="fas fa-plus"></i>
                    Tambah Paket
                </a>
            </header>

            <div class="flash-stack">
                @if(session('success'))
                    <div class="flash-message success">
                        <div class="flash-icon">
                            <i class="fas fa-circle-check"></i>
                        </div>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="flash-message error">
                        <div class="flash-icon">
                            <i class="fas fa-circle-exclamation"></i>
                        </div>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="flash-message validation">
                        <div class="flash-icon">
                            <i class="fas fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <strong>Terdapat kesalahan:</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            <section class="filter-toolbar" aria-label="Filter paket bundling">
                <div class="search-wrap">
                    <i class="fas fa-magnifying-glass search-icon" aria-hidden="true"></i>
                    <input
                        type="text"
                        id="searchPaket"
                        placeholder="Cari nama paket..."
                        autocomplete="off"
                        aria-label="Cari nama paket"
                    >
                    <button
                        type="button"
                        class="search-clear"
                        id="clearSearchPaket"
                        aria-label="Hapus pencarian"
                        title="Hapus pencarian"
                    >
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>

                <div class="filter-controls-right">
                    <div class="filter-select-wrap">
                        <span class="filter-select-label">
                            <i class="fas fa-sliders"></i>
                            Untuk
                        </span>
                        <select id="filterTarget" aria-label="Filter target paket">
                            <option value="all">Semua Target</option>
                            <option value="anak-anak">Anak-anak</option>
                            <option value="dewasa">Dewasa</option>
                        </select>
                        <i class="fas fa-chevron-down filter-select-arrow" aria-hidden="true"></i>
                    </div>

                    <div class="per-page-wrap">
                        <span class="per-page-label">Tampilkan</span>
                        <select class="per-page-select" id="perPage" aria-label="Jumlah data per halaman">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                        </select>
                        <span class="per-page-label">data</span>
                    </div>
                </div>
            </section>

            <section class="table-card" aria-label="Daftar paket bundling">
                <div class="table-scroll">
                    <table class="bundling-table">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Paket</th>
                                <th>Untuk</th>
                                <th>Wahana</th>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th class="center">Status</th>
                                <th class="center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="bundlingTableBody">
                            @forelse($paketBundlings as $paket)
                                @php
                                    $paketId = $paket->id_paket_bundling;

                                    $target = strtolower(trim((string) $paket->untuk));

                                    $namaPaket = strtolower(
                                        trim((string) $paket->nama_paket)
                                    );

                                    $wahanaCount = $paket->wahanas?->count() ?? 0;
                                    $menuCount = $paket->menus?->count() ?? 0;
                                @endphp

                                <tr
                                    class="paket-row"
                                    data-nama="{{ $namaPaket }}"
                                    data-target="{{ $target }}"
                                    data-id="{{ $paketId }}"
                                >
                                    <td data-label="Gambar">
                                        @if($paket->gambar)
                                            <img
                                                src="{{ asset('storage/' . $paket->gambar) }}"
                                                alt="{{ $paket->nama_paket }}"
                                                width="78"
                                                height="78"
                                                loading="lazy"
                                                class="bundle-image"
                                            >
                                        @else
                                            <div class="bundle-image-placeholder" aria-label="Tidak ada gambar">
                                                <i class="fas fa-box-open"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td data-label="Nama Paket">
                                        <strong class="bundle-name" title="{{ $paket->nama_paket }}">
                                            {{ $paket->nama_paket }}
                                        </strong>
                                    </td>

                                    <td data-label="Untuk">
                                        <span class="target-badge">
                                            {{ $paket->untuk }}
                                        </span>
                                    </td>

                                    <td data-label="Wahana">
                                        @if($wahanaCount > 0)
                                            <div class="item-list" title="@foreach($paket->wahanas->take(3) as $wahana){{ $wahana->wahana ?? $wahana->nama_wahana ?? $wahana->nama_tiket ?? $wahana->nama ?? '-' }}@if(!$loop->last), @endif @endforeach{{ $wahanaCount > 3 ? ' dan lainnya' : '' }}">
                                                @foreach($paket->wahanas->take(3) as $wahana)
                                                    <span>
                                                        • {{ $wahana->wahana
                                                            ?? $wahana->nama_wahana
                                                            ?? $wahana->nama_tiket
                                                            ?? $wahana->nama
                                                            ?? '-' }}
                                                    </span>
                                                @endforeach
                                                @if($wahanaCount > 3)
                                                    <span class="item-more">…</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="item-empty">Tidak ada wahana</span>
                                        @endif
                                    </td>

                                    <td data-label="Menu">
                                        @if($menuCount > 0)
                                            <div class="item-list" title="@foreach($paket->menus->take(3) as $menu){{ $menu->nama_menu ?? '-' }}@if(!$loop->last), @endif @endforeach{{ $menuCount > 3 ? ' dan lainnya' : '' }}">
                                                @foreach($paket->menus->take(3) as $menu)
                                                    <span>
                                                        • {{ $menu->nama_menu ?? '-' }}
                                                    </span>
                                                @endforeach
                                                @if($menuCount > 3)
                                                    <span class="item-more">…</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="item-empty">Tidak ada menu</span>
                                        @endif
                                    </td>

                                    <td data-label="Harga">
                                        <strong class="price">
                                            Rp {{ number_format(
                                                (int) $paket->harga,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </strong>
                                    </td>

                                    <td data-label="Status" style="text-align:center;">
                                        @if($paket->status === 'Tersedia')
                                            <span class="status-badge available">
                                                <i class="fas fa-circle-check"></i>
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="status-badge unavailable">
                                                <i class="fas fa-circle-xmark"></i>
                                                Tidak Tersedia
                                            </span>
                                        @endif
                                    </td>

                                    <td data-label="Aksi">
                                        <div class="action-group">
                                            <a
                                                href="{{ route('admin.paketbundling.edit', $paketId) }}"
                                                class="action-button"
                                                title="Edit Paket"
                                                aria-label="Edit Paket {{ $paket->nama_paket }}"
                                            >
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <form
                                                id="deleteForm{{ $paketId }}"
                                                action="{{ route('admin.paketbundling.destroy', $paketId) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="button"
                                                    class="action-button delete"
                                                    title="Hapus Paket"
                                                    aria-label="Hapus Paket {{ $paket->nama_paket }}"
                                                    onclick="openDeleteModal('{{ $paketId }}', @js($paket->nama_paket))"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="table-empty">
                                        <div class="table-empty-icon">
                                            <i class="fas fa-box-open"></i>
                                        </div>

                                        <h3>Belum Ada Paket Bundling</h3>

                                        <p>
                                            Tambahkan paket bundling pertama Anda.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-footer" id="tableFooter">
                    <div class="table-summary">
                        <span class="table-summary-icon">
                            <i class="fas fa-layer-group"></i>
                        </span>
                        <span>
                            Menampilkan <strong id="visibleFrom">0</strong>–<strong id="visibleTo">0</strong>
                            dari <strong id="totalCount">0</strong> paket
                        </span>
                    </div>
                </div>

                <div class="pagination-wrap" id="paginationWrap" hidden>
                    <div class="pagination-controls" id="paginationControls" aria-label="Navigasi halaman"></div>
                </div>
            </section>
        </div>
    </main>

    {{-- DELETE MODAL --}}
    <div
        class="delete-modal-backdrop"
        id="deleteModalBackdrop"
        aria-hidden="true"
    >
        <div
            class="delete-modal"
            role="dialog"
            aria-modal="true"
            aria-labelledby="deleteModalTitle"
        >
            <button
                type="button"
                class="delete-modal-close"
                onclick="closeDeleteModal()"
                aria-label="Tutup"
                title="Tutup"
            >
                <i class="fas fa-xmark"></i>
            </button>

            <div class="delete-modal-icon" aria-hidden="true">
                <i class="fas fa-trash-can"></i>
            </div>

            <div class="delete-modal-content">
                <p class="delete-modal-eyebrow">Konfirmasi Hapus</p>
                <h2 id="deleteModalTitle">Hapus Paket?</h2>

                <p class="delete-modal-message">
                    Paket <strong id="deletePackageName">ini</strong> akan dihapus secara permanen.
                    Data yang sudah dihapus tidak dapat dikembalikan.
                </p>

                <div class="delete-modal-actions">
                    <button
                        type="button"
                        class="delete-cancel"
                        onclick="closeDeleteModal()"
                    >
                        Batal
                    </button>

                    <button
                        type="button"
                        class="delete-confirm"
                        id="confirmDeleteButton"
                    >
                        <i class="fas fa-trash"></i>
                        Hapus Paket
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchPaket');
            const clearSearchButton = document.getElementById('clearSearchPaket');
            const filterTarget = document.getElementById('filterTarget');
            const perPageSelect = document.getElementById('perPage');

            const rows = Array.from(document.querySelectorAll('.paket-row'));
            const visibleFrom = document.getElementById('visibleFrom');
            const visibleTo = document.getElementById('visibleTo');
            const totalCount = document.getElementById('totalCount');
            const paginationWrap = document.getElementById('paginationWrap');
            const paginationControls = document.getElementById('paginationControls');

            let currentPage = 1;

            function normalize(value) {
                return String(value ?? '').toLowerCase().trim();
            }

            function updateSearchClear() {
                if (!clearSearchButton) return;
                clearSearchButton.style.display =
                    searchInput?.value?.trim() ? 'flex' : 'none';
            }

            function getFilteredRows() {
                const keyword = normalize(searchInput?.value);
                const target = normalize(filterTarget?.value);

                return rows.filter(function (row) {
                    const nama = normalize(row.dataset.nama);
                    const kategori = normalize(row.dataset.target);

                    return (
                        nama.includes(keyword) &&
                        (target === 'all' || kategori === target)
                    );
                });
            }

            function createPageButton(label, page, options = {}) {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'page-button' + (options.active ? ' active' : '');
                button.textContent = label;
                button.disabled = !!options.disabled;

                if (options.ariaLabel) {
                    button.setAttribute('aria-label', options.ariaLabel);
                }

                if (!button.disabled) {
                    button.addEventListener('click', function () {
                        currentPage = page;
                        renderPagination();
                    });
                }

                paginationControls.appendChild(button);
            }

            function buildPagination(totalPages) {
                if (!paginationControls) return;

                paginationControls.innerHTML = '';

                createPageButton(
                    '‹',
                    Math.max(1, currentPage - 1),
                    {
                        disabled: currentPage === 1,
                        ariaLabel: 'Halaman sebelumnya'
                    }
                );

                const maxButtons = 5;
                let start = Math.max(1, currentPage - 2);
                let end = Math.min(totalPages, start + maxButtons - 1);

                if (end - start < maxButtons - 1) {
                    start = Math.max(1, end - maxButtons + 1);
                }

                if (start > 1) {
                    createPageButton('1', 1, {
                        active: currentPage === 1,
                        ariaLabel: 'Halaman 1'
                    });

                    if (start > 2) {
                        const ellipsis = document.createElement('span');
                        ellipsis.className = 'page-ellipsis';
                        ellipsis.textContent = '…';
                        paginationControls.appendChild(ellipsis);
                    }
                }

                for (let page = start; page <= end; page++) {
                    if (page === 1 && start > 1) continue;

                    createPageButton(String(page), page, {
                        active: page === currentPage,
                        ariaLabel: 'Halaman ' + page
                    });
                }

                if (end < totalPages) {
                    if (end < totalPages - 1) {
                        const ellipsis = document.createElement('span');
                        ellipsis.className = 'page-ellipsis';
                        ellipsis.textContent = '…';
                        paginationControls.appendChild(ellipsis);
                    }

                    createPageButton(String(totalPages), totalPages, {
                        active: currentPage === totalPages,
                        ariaLabel: 'Halaman ' + totalPages
                    });
                }

                createPageButton(
                    '›',
                    Math.min(totalPages, currentPage + 1),
                    {
                        disabled: currentPage === totalPages,
                        ariaLabel: 'Halaman berikutnya'
                    }
                );
            }

            function renderPagination() {
                const filteredRows = getFilteredRows();
                const total = filteredRows.length;
                const perPage = Number(perPageSelect?.value || 10);
                const totalPages = Math.max(1, Math.ceil(total / perPage));

                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }

                const startIndex = (currentPage - 1) * perPage;
                const endIndex = Math.min(startIndex + perPage, total);

                rows.forEach(function (row) {
                    row.style.display = 'none';
                });

                filteredRows.slice(startIndex, endIndex).forEach(function (row) {
                    row.style.display = '';
                });

                const from = total === 0 ? 0 : startIndex + 1;
                const to = total === 0 ? 0 : endIndex;

                if (visibleFrom) visibleFrom.textContent = from;
                if (visibleTo) visibleTo.textContent = to;
                if (totalCount) totalCount.textContent = total;

                const hasMultiplePages = total > perPage;

                if (paginationWrap) {
                    paginationWrap.hidden = !hasMultiplePages;
                }

                if (paginationControls) {
                    paginationControls.style.display = hasMultiplePages ? 'flex' : 'none';
                }

                buildPagination(totalPages);
                updateSearchClear();
            }

            function resetToFirstPage() {
                currentPage = 1;
                renderPagination();
            }

            if (searchInput) {
                searchInput.addEventListener('input', resetToFirstPage);
            }

            if (clearSearchButton) {
                clearSearchButton.addEventListener('click', function () {
                    if (!searchInput) return;

                    searchInput.value = '';
                    searchInput.focus();
                    resetToFirstPage();
                });
            }

            if (filterTarget) {
                filterTarget.addEventListener('change', resetToFirstPage);
            }

            if (perPageSelect) {
                perPageSelect.addEventListener('change', resetToFirstPage);
            }

            window.openDeleteModal = function (id, name) {
                const backdrop = document.getElementById('deleteModalBackdrop');
                const nameTarget = document.getElementById('deletePackageName');
                const confirmButton = document.getElementById('confirmDeleteButton');

                if (!backdrop || !confirmButton) return;

                if (nameTarget) {
                    nameTarget.textContent = name || 'ini';
                }

                confirmButton.onclick = function () {
                    const form = document.getElementById('deleteForm' + id);
                    if (form) form.submit();
                };

                backdrop.classList.add('show');
                backdrop.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');
            };

            window.closeDeleteModal = function () {
                const backdrop = document.getElementById('deleteModalBackdrop');

                if (!backdrop) return;

                backdrop.classList.remove('show');
                backdrop.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
            };

            const backdrop = document.getElementById('deleteModalBackdrop');

            if (backdrop) {
                backdrop.addEventListener('click', function (event) {
                    if (event.target === backdrop) {
                        window.closeDeleteModal();
                    }
                });
            }

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    window.closeDeleteModal();
                }
            });

            renderPagination();
        });
    </script>

</body>

</html>
