@php
    use Illuminate\Support\Facades\Route;
    $orders = $pesanans ?? ($orders ?? collect());
    $search = request('search', '');
    $statusAktif = request('status', 'Menunggu');

    $verifyRouteExists = Route::has('kasir.oleholeh.orders.verify');
    $stockRouteExists = Route::has('kasir.oleholeh.stock');

    $kasir = auth('admin')->user();
    $namaKasir = $kasir?->nama ?? 'Kasir';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pesanan Oleh-Oleh - Noyo Gimbal
    </title>

    
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
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >

    
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    @stack('styles')

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
            --border-soft:rgba(255,255,255,.08);
            --border-gold:rgba(226,201,151,.18);
            --white:#ffffff;
            --black:#000000;
            --green:#7fb98e;
            --yellow:#e2c16f;
            --blue:#8baed1;
            --red:#d98279;
            --shadow-soft:0 20px 60px rgba(0,0,0,.4);
            --shadow-hover:0 25px 70px rgba(0,0,0,.5);
            --radius-lg:28px;
            --radius-md:16px;
            --radius-sm:12px;
            --radius-full:999px;
            --transition:.25s cubic-bezier(.4,0,.2,1);
        }

        *{box-sizing:border-box}

        html{scroll-behavior:smooth}

        body{
            margin:0;
            min-width:320px;
            color:var(--text-primary);
            background:var(--bg-primary);
            font-family:'DM Sans',Arial,sans-serif;
            font-size:16px;
            line-height:1.65;
            overflow-x:hidden;
        }

        body.ko-modal-open{overflow:hidden}

        button,input,select{font:inherit}

        a,button,input,select{transition:all var(--transition)}

        button:focus-visible,
        a:focus-visible,
        select:focus-visible,
        input:focus-visible{
            outline:3px solid var(--accent);
            outline-offset:3px;
        }

        .ko-main{
            min-height:100vh;
            margin-left:252px;
            background:
                radial-gradient(circle at 85% 0%,rgba(226,201,151,.055),transparent 30%),
                var(--bg-primary);
        }

        .ko-topbar{
            position:sticky;
            top:0;
            z-index:900;
            min-height:78px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            padding:0 42px;
            background:rgba(10,10,10,.88);
            border-bottom:1px solid var(--border-soft);
            backdrop-filter:blur(22px);
            -webkit-backdrop-filter:blur(22px);
        }

        .ko-topbar-left,
        .ko-topbar-user{
            display:flex;
            align-items:center;
        }

        .ko-topbar-left{gap:16px}

        .ko-mobile-button{
            width:46px;
            height:46px;
            display:none;
            align-items:center;
            justify-content:center;
            color:var(--text-primary);
            background:var(--bg-secondary);
            border:1px solid var(--border-gold);
            border-radius:12px;
            cursor:pointer;
            font-size:18px;
        }

        .ko-mobile-button:hover{
            color:var(--accent);
            border-color:var(--accent);
            background:var(--bg-soft);
        }

        .ko-breadcrumb{
            display:flex;
            align-items:center;
            gap:10px;
            color:var(--text-muted);
            font-size:14px;
            font-weight:500;
        }

        .ko-breadcrumb i{font-size:10px;color:var(--text-dim)}
        .ko-breadcrumb .current{color:var(--text-primary);font-weight:700}

        .ko-topbar-user{gap:12px}

        .ko-topbar-user-text{text-align:right}

        .ko-topbar-user-text strong{
            display:block;
            color:var(--text-primary);
            font-size:15px;
            font-weight:700;
        }

        .ko-topbar-user-text span{
            display:block;
            margin-top:2px;
            color:var(--text-muted);
            font-size:13px;
        }

        .ko-topbar-avatar{
            width:44px;
            height:44px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:var(--bg-primary);
            background:linear-gradient(135deg,var(--accent),var(--accent-dark));
            border-radius:13px;
            font-size:16px;
            font-weight:800;
            box-shadow:0 8px 24px rgba(226,201,151,.12);
        }

        .ko-content{
            width:min(calc(100% - 84px),1400px);
            margin:0 auto;
            padding:44px 0 56px;
        }

        .ko-page-header{
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:28px;
            margin-bottom:28px;
        }

        .ko-page-eyebrow{
            display:block;
            margin-bottom:8px;
            color:var(--accent);
            font-size:13px;
            line-height:1.2;
            font-weight:800;
            letter-spacing:2px;
            text-transform:uppercase;
        }

        .ko-page-header h1{
            margin:0;
            color:var(--text-primary);
            font-family:'Playfair Display',Georgia,serif;
            font-size:clamp(30px,3vw,44px);
            line-height:1.15;
            font-weight:700;
        }

        .ko-page-header p{
            max-width:720px;
            margin:12px 0 0;
            color:var(--text-muted);
            font-size:16px;
            line-height:1.7;
        }

        .ko-stock-link{
            min-height:48px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            padding:0 20px;
            flex-shrink:0;
            color:var(--bg-primary);
            background:linear-gradient(135deg,var(--accent),var(--accent-hover));
            border:1px solid var(--accent);
            border-radius:var(--radius-full);
            font-size:14px;
            font-weight:800;
            text-decoration:none;
            white-space:nowrap;
            box-shadow:0 10px 28px rgba(226,201,151,.10);
        }

        .ko-stock-link:hover{
            color:var(--bg-primary);
            background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark));
            transform:translateY(-2px);
            box-shadow:var(--shadow-hover);
        }

        .ko-panel{
            overflow:hidden;
            background:linear-gradient(180deg,rgba(255,255,255,.035),rgba(255,255,255,.018));
            border:1px solid var(--border-gold);
            border-radius:var(--radius-lg);
            box-shadow:var(--shadow-soft);
        }

        .ko-toolbar{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:18px;
            padding:22px 24px;
            background:rgba(255,255,255,.018);
            border-bottom:1px solid var(--border-soft);
        }

        .ko-search-form{
            position:relative;
            width:min(100%,620px);
        }

        .ko-search-icon{
            position:absolute;
            left:17px;
            top:50%;
            transform:translateY(-50%);
            color:var(--text-dim);
            font-size:15px;
            pointer-events:none;
        }

        .ko-search-input{
            width:100%;
            min-height:50px;
            padding:0 92px 0 48px;
            color:var(--text-primary);
            background:var(--bg-secondary);
            border:1px solid var(--border-soft);
            border-radius:14px;
            outline:none;
            font-size:15px;
        }

        .ko-search-input::placeholder{color:var(--text-dim)}

        .ko-search-input:focus{
            border-color:var(--accent);
            box-shadow:0 0 0 4px rgba(226,201,151,.10);
        }

        .ko-search-button{
            position:absolute;
            right:5px;
            top:5px;
            min-height:40px;
            padding:0 16px;
            color:var(--bg-primary);
            background:var(--accent);
            border:0;
            border-radius:10px;
            font-size:14px;
            font-weight:800;
            cursor:pointer;
        }

        .ko-search-button:hover{background:var(--accent-hover)}

        .ko-order-count{
            color:var(--text-muted);
            font-size:14px;
            white-space:nowrap;
        }

        .ko-toolbar-controls{
            display:flex;
            align-items:center;
            justify-content:flex-end;
            flex-wrap:wrap;
            gap:12px;
            min-width:0;
        }

        .ko-main,.ko-content,.ko-panel,.ko-modal-card{min-width:0}

        .ko-customer-name,
        .ko-info-box strong{overflow-wrap:anywhere}

        .ko-status-filter{
            min-height:46px;
            min-width:210px;
            padding:0 14px;
            color:var(--text-primary);
            background:var(--bg-secondary);
            border:1px solid var(--border-soft);
            border-radius:12px;
            outline:none;
            font-size:14px;
            font-weight:600;
            cursor:pointer;
        }

        .ko-status-filter:focus{
            border-color:var(--accent);
            box-shadow:0 0 0 4px rgba(226,201,151,.10);
        }

        .ko-table-wrapper{
            width:100%;
            overflow-x:auto;
            scrollbar-width:thin;
            scrollbar-color:var(--accent-dark) var(--bg-secondary);
        }

        .ko-table{
            width:100%;
            min-width:960px;
            border-collapse:collapse;
        }

        .ko-table th{
            padding:17px 22px;
            color:var(--text-muted);
            background:rgba(255,255,255,.018);
            border-bottom:1px solid var(--border-soft);
            font-size:12px;
            line-height:1.3;
            font-weight:800;
            letter-spacing:.8px;
            text-align:left;
            text-transform:uppercase;
            white-space:nowrap;
        }

        .ko-table td{
            padding:19px 22px;
            color:var(--text-secondary);
            border-bottom:1px solid var(--border-soft);
            font-size:14px;
            line-height:1.5;
            vertical-align:middle;
        }

        .ko-table tbody tr{transition:background var(--transition)}
        .ko-table tbody tr:hover{background:rgba(226,201,151,.035)}
        .ko-table tbody tr:last-child td{border-bottom:0}

        .ko-order-code{
            color:var(--accent);
            font-size:14px;
            font-weight:800;
            white-space:nowrap;
        }

        .ko-customer-name{
            display:block;
            color:var(--text-primary);
            font-size:15px;
            font-weight:700;
        }

        .ko-customer-wa{
            display:block;
            margin-top:4px;
            color:var(--text-dim);
            font-size:13px;
        }

        .ko-item-badge{
            display:inline-flex;
            align-items:center;
            gap:7px;
            padding:7px 10px;
            color:var(--accent);
            background:rgba(226,201,151,.09);
            border:1px solid rgba(226,201,151,.12);
            border-radius:10px;
            font-size:13px;
            font-weight:700;
            white-space:nowrap;
        }

        .ko-status{
            display:inline-flex;
            align-items:center;
            gap:7px;
            padding:8px 11px;
            border-radius:var(--radius-full);
            font-size:13px;
            line-height:1.2;
            font-weight:700;
            white-space:nowrap;
        }

        .ko-status.waiting{color:var(--yellow);background:rgba(226,193,111,.11)}
        .ko-status.process{color:var(--blue);background:rgba(139,174,209,.11)}
        .ko-status.done{color:var(--green);background:rgba(127,185,142,.11)}
        .ko-status.cancel{color:var(--red);background:rgba(217,130,121,.11)}

        .ko-status-dot{
            width:7px;
            height:7px;
            flex-shrink:0;
            border-radius:50%;
            background:currentColor;
        }

        .ko-total{
            color:var(--text-primary);
            font-size:15px;
            font-weight:800;
            white-space:nowrap;
        }

        .ko-detail-button{
            min-height:40px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:0 13px;
            color:var(--accent);
            background:rgba(226,201,151,.08);
            border:1px solid rgba(226,201,151,.16);
            border-radius:10px;
            font-size:13px;
            font-weight:800;
            cursor:pointer;
        }

        .ko-detail-button:hover{
            color:var(--bg-primary);
            background:var(--accent);
            transform:translateY(-2px);
        }

        .ko-empty{
            display:flex;
            align-items:center;
            flex-direction:column;
            padding:78px 24px;
            text-align:center;
        }

        .ko-empty-icon{
            width:68px;
            height:68px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-bottom:16px;
            color:var(--accent);
            background:rgba(226,201,151,.08);
            border:1px solid var(--border-gold);
            border-radius:20px;
            font-size:24px;
        }

        .ko-empty h3{
            margin:0 0 7px;
            color:var(--text-primary);
            font-size:20px;
            font-weight:800;
        }

        .ko-empty p{
            max-width:480px;
            margin:0;
            color:var(--text-muted);
            font-size:15px;
            line-height:1.7;
        }

        .ko-pagination{
            display:flex;
            justify-content:flex-end;
            padding:18px 22px;
            background:rgba(255,255,255,.015);
            border-top:1px solid var(--border-soft);
        }

        .ko-pagination nav{color:var(--text-secondary)}
        .ko-pagination a,
        .ko-pagination span{
            color:var(--text-secondary) !important;
        }

        .ko-modal{
            position:fixed;
            inset:0;
            z-index:2000;
            display:none;
            align-items:center;
            justify-content:center;
            padding:24px;
            background:rgba(0,0,0,.76);
            backdrop-filter:blur(10px);
            -webkit-backdrop-filter:blur(10px);
        }

        .ko-modal.show{
            display:flex;
            visibility:visible;
            opacity:1;
            animation:koModalFade .18s ease;
        }

        .ko-modal[aria-hidden="true"]{visibility:hidden}
        .ko-modal[aria-hidden="false"]{visibility:visible}

        .ko-modal-card{
            width:min(760px,100%);
            max-height:min(90vh,820px);
            overflow-y:auto;
            color:var(--text-primary);
            background:var(--bg-secondary);
            border:1px solid var(--border-gold);
            border-radius:22px;
            box-shadow:0 30px 100px rgba(0,0,0,.65);
            animation:koModalUp .20s ease;
        }

        .ko-modal-header{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:18px;
            padding:24px 26px 20px;
            background:linear-gradient(135deg,rgba(226,201,151,.07),transparent);
            border-bottom:1px solid var(--border-soft);
        }

        .ko-modal-eyebrow{
            display:block;
            margin-bottom:6px;
            color:var(--accent);
            font-size:12px;
            font-weight:800;
            letter-spacing:1.6px;
            text-transform:uppercase;
        }

        .ko-modal-header h2{
            margin:0;
            color:var(--text-primary);
            font-family:'Playfair Display',Georgia,serif;
            font-size:25px;
            line-height:1.25;
        }

        .ko-modal-close{
            width:42px;
            height:42px;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-shrink:0;
            color:var(--text-secondary);
            background:var(--bg-soft);
            border:1px solid var(--border-soft);
            border-radius:12px;
            cursor:pointer;
            font-size:17px;
        }

        .ko-modal-close:hover{
            color:var(--accent);
            border-color:var(--border-gold);
        }

        .ko-modal-body{padding:24px 26px 26px}

        .ko-info-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:12px;
            margin-bottom:22px;
        }

        .ko-info-box{
            padding:15px 16px;
            background:rgba(255,255,255,.025);
            border:1px solid var(--border-soft);
            border-radius:13px;
        }

        .ko-info-box span{
            display:block;
            margin-bottom:5px;
            color:var(--text-dim);
            font-size:12px;
        }

        .ko-info-box strong{
            display:block;
            color:var(--text-primary);
            font-size:15px;
            line-height:1.45;
            font-weight:700;
        }

        .ko-detail-heading{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            margin-bottom:10px;
        }

        .ko-detail-heading h3{
            margin:0;
            color:var(--text-primary);
            font-size:17px;
            font-weight:800;
        }

        .ko-detail-heading span{
            color:var(--text-muted);
            font-size:13px;
        }

        .ko-items-box{
            overflow:hidden;
            border:1px solid var(--border-soft);
            border-radius:14px;
        }

        .ko-item-row{
            display:grid;
            grid-template-columns:minmax(0,1fr) auto auto auto;
            align-items:center;
            gap:16px;
            padding:15px 16px;
            border-bottom:1px solid var(--border-soft);
        }

        .ko-item-row:last-child{border-bottom:0}

        .ko-item-name{min-width:0}

        .ko-item-name strong{
            display:block;
            overflow:hidden;
            color:var(--text-primary);
            font-size:14px;
            font-weight:700;
            text-overflow:ellipsis;
            white-space:nowrap;
        }

        .ko-item-name span{
            display:block;
            margin-top:4px;
            color:var(--text-muted);
            font-size:12px;
        }

        .ko-item-meta{
            color:var(--text-muted);
            font-size:13px;
            white-space:nowrap;
        }

        .ko-item-status{
            padding:6px 9px;
            color:var(--text-muted);
            background:rgba(255,255,255,.05);
            border-radius:8px;
            font-size:12px;
            font-weight:700;
            white-space:nowrap;
        }

        .ko-item-status.done{
            color:var(--green);
            background:rgba(127,185,142,.10);
        }

        .ko-item-subtotal{
            color:var(--text-primary);
            font-size:14px;
            font-weight:800;
            white-space:nowrap;
        }

        .ko-total-box{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:15px;
            margin-top:14px;
            padding:17px 18px;
            color:var(--text-primary);
            background:linear-gradient(135deg,rgba(226,201,151,.14),rgba(226,201,151,.05));
            border:1px solid var(--border-gold);
            border-radius:13px;
        }

        .ko-total-box span{
            color:var(--text-secondary);
            font-size:14px;
        }

        .ko-total-box strong{
            color:var(--accent);
            font-size:20px;
            font-weight:800;
        }

        .ko-warning{
            display:flex;
            align-items:flex-start;
            gap:10px;
            margin-top:14px;
            padding:13px 14px;
            color:#e2c98c;
            background:rgba(226,193,111,.08);
            border:1px solid rgba(226,193,111,.16);
            border-radius:11px;
            font-size:13px;
            line-height:1.6;
        }

        .ko-warning i{
            margin-top:3px;
            flex-shrink:0;
        }

        .ko-modal-footer{
            display:flex;
            align-items:center;
            justify-content:flex-end;
            gap:10px;
            margin-top:18px;
        }

        .ko-button-secondary,
        .ko-button-primary{
            min-height:46px;
            padding:0 18px;
            border-radius:11px;
            font-family:inherit;
            font-size:14px;
            font-weight:800;
            cursor:pointer;
        }

        .ko-button-secondary{
            color:var(--text-secondary);
            background:var(--bg-soft);
            border:1px solid var(--border-soft);
        }

        .ko-button-secondary:hover{
            color:var(--text-primary);
            border-color:var(--border-gold);
        }

        .ko-button-primary{
            color:var(--bg-primary);
            background:var(--accent);
            border:1px solid var(--accent);
        }

        .ko-button-primary:hover{
            background:var(--accent-hover);
            transform:translateY(-1px);
        }

        .ko-button-primary:disabled{
            opacity:.5;
            cursor:not-allowed;
            transform:none;
        }

        @keyframes koModalFade{
            from{opacity:0}
            to{opacity:1}
        }

        @keyframes koModalUp{
            from{opacity:0;transform:translateY(12px) scale(.985)}
            to{opacity:1;transform:translateY(0) scale(1)}
        }

        @media (max-width:1200px){
            .ko-main{margin-left:232px}
            .ko-content{width:min(calc(100% - 56px),1180px)}
            .ko-topbar{padding:0 30px}
            .ko-table{min-width:900px}
        }

        @media (max-width:992px){
            .ko-main{margin-left:0}
            .ko-mobile-button{display:flex}
            .ko-topbar{
                min-height:72px;
                padding:0 24px;
            }
            .ko-content{
                width:calc(100% - 48px);
                padding:36px 0 48px;
            }
        }

        @media (max-width:768px){
            .ko-topbar{
                padding:0 18px;
            }

            .ko-breadcrumb{font-size:13px}

            .ko-topbar-user-text{display:none}

            .ko-topbar-avatar{
                width:42px;
                height:42px;
            }

            .ko-content{
                width:calc(100% - 32px);
                padding:28px 0 40px;
            }

            .ko-page-header{
                align-items:stretch;
                flex-direction:column;
                gap:18px;
                margin-bottom:22px;
            }

            .ko-page-header h1{font-size:32px}
            .ko-page-header p{font-size:15px}

            .ko-stock-link{width:100%;min-height:50px}

            .ko-toolbar{
                align-items:stretch;
                flex-direction:column;
                padding:18px;
            }

            .ko-search-form{width:100%}

            .ko-toolbar-controls{
                display:grid;
                grid-template-columns:minmax(0,1fr) auto;
                width:100%;
                align-items:center;
            }

            .ko-status-filter{
                width:100%;
                min-width:0;
            }

            .ko-info-grid{grid-template-columns:1fr}

            .ko-modal{padding:14px}

            .ko-modal-header,
            .ko-modal-body{
                padding-left:20px;
                padding-right:20px;
            }

            .ko-item-row{
                grid-template-columns:minmax(0,1fr) auto;
                gap:10px 14px;
            }

            .ko-item-meta{display:none}
            .ko-item-status{justify-self:end}
            .ko-item-subtotal{justify-self:end}
        }

        @media (max-width:576px){
            body{font-size:15px}

            .ko-topbar{
                min-height:66px;
                padding:0 14px;
            }

            .ko-mobile-button{
                width:42px;
                height:42px;
            }

            .ko-breadcrumb span:not(.current){display:none}
            .ko-breadcrumb i{display:none}

            .ko-content{
                width:calc(100% - 24px);
                padding-top:22px;
            }

            .ko-page-header h1{font-size:28px}
            .ko-page-header p{font-size:14px}

            .ko-search-input{
                min-height:52px;
                padding-left:44px;
                padding-right:82px;
                font-size:14px;
            }

            .ko-search-button{
                min-height:42px;
                font-size:13px;
            }

            .ko-toolbar-controls{
                grid-template-columns:1fr;
            }

            .ko-order-count{
                text-align:right;
            }

            .ko-panel{border-radius:20px}

            .ko-empty{padding:60px 18px}

            .ko-modal{
                align-items:flex-end;
                padding:8px;
            }

            .ko-modal-card{
                width:100%;
                max-height:94vh;
                border-radius:20px;
            }

            .ko-modal-header,
            .ko-modal-body{
                padding-left:16px;
                padding-right:16px;
            }

            .ko-modal-header h2{font-size:21px}

            .ko-item-row{
                grid-template-columns:1fr;
                gap:8px;
            }

            .ko-item-status,
            .ko-item-subtotal{justify-self:start}

            .ko-total-box{
                align-items:flex-start;
                flex-direction:column;
                gap:5px;
            }

            .ko-modal-footer{
                flex-direction:column-reverse;
            }

            .ko-button-secondary,
            .ko-button-primary,
            .ko-verify-form{
                width:100%;
            }

            .ko-button-secondary,
            .ko-button-primary{
                justify-content:center;
            }
        }

        @media (prefers-reduced-motion:reduce){
            *,
            *::before,
            *::after{
                animation:none !important;
                transition:none !important;
                scroll-behavior:auto !important;
            }
        }
    </style>
</head>

<body>

    

    @include('kasir.partials.sidebar')

    

    <main class="ko-main">

        

        <header class="ko-topbar">

            <div class="ko-topbar-left">

                <button
                    type="button"
                    class="ko-mobile-button"
                    id="openKasirSidebar"
                    aria-label="Buka menu"
                >
                    <i class="fas fa-bars"></i>
                </button>

                <div class="ko-breadcrumb">
                    <span>Kasir</span>

                    <i class="fas fa-chevron-right"></i>

                    <span class="current">
                        Pesanan Oleh-Oleh
                    </span>
                </div>

            </div>

            <div class="ko-topbar-user">

                <div class="ko-topbar-user-text">

                    <strong>
                        {{ $namaKasir }}
                    </strong>

                    <span>
                        Kasir Oleh-Oleh
                    </span>

                </div>

                <div class="ko-topbar-avatar">
                    {{ strtoupper(
                        mb_substr(
                            trim($namaKasir),
                            0,
                            1
                        )
                    ) }}
                </div>

            </div>

        </header>

        

        <div class="ko-content">

            

            <section class="ko-page-header">

                <div>

                    <span class="ko-page-eyebrow">
                        Transaksi
                    </span>

                    <h1>
                        Pesanan Oleh-Oleh
                    </h1>

                    <p>
                        Kelola pembayaran dan verifikasi pengambilan
                        pesanan oleh-oleh oleh pelanggan.
                    </p>

                </div>

                @if($stockRouteExists)

                    <a
                        href="{{ route('kasir.oleholeh.stock') }}"
                        class="ko-stock-link"
                    >
                        <i class="fas fa-boxes-stacked"></i>
                        Kelola Stok
                    </a>

                @else

                    <a
                        href="{{ url('/kasir-oleholeh/stok') }}"
                        class="ko-stock-link"
                    >
                        <i class="fas fa-boxes-stacked"></i>
                        Kelola Stok
                    </a>

                @endif

            </section>

            

            <section class="ko-panel">

                

                <div class="ko-toolbar">

                    <form
                        method="GET"
                        action="{{ url()->current() }}"
                        class="ko-search-form"
                    >

                        <input type="hidden" name="status" value="{{ $statusAktif }}">

                        <i class="fas fa-search ko-search-icon"></i>

                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            class="ko-search-input"
                            placeholder="Cari kode pesanan, nama pelanggan, atau nomor WhatsApp..."
                            autocomplete="off"
                        >

                        <button
                            type="submit"
                            class="ko-search-button"
                        >
                            Cari
                        </button>

                    </form>

                    <div class="ko-toolbar-controls">

                        <select
                            class="ko-status-filter"
                            aria-label="Filter status"
                            id="koStatusFilter"
                        >
                            <option value="Menunggu" {{ $statusAktif === 'Menunggu' ? 'selected' : '' }}>
                                Menunggu / Perlu Diproses
                            </option>
                            <option value="Menunggu Pembayaran" {{ $statusAktif === 'Menunggu Pembayaran' ? 'selected' : '' }}>
                                Menunggu Pembayaran
                            </option>
                            <option value="Menunggu Pengambilan" {{ $statusAktif === 'Menunggu Pengambilan' ? 'selected' : '' }}>
                                Menunggu Pengambilan
                            </option>
                            <option value="Selesai" {{ $statusAktif === 'Selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="Batal" {{ $statusAktif === 'Batal' ? 'selected' : '' }}>
                                Batal
                            </option>
                        </select>

                        <span class="ko-order-count">
                            @if(method_exists($orders, 'total'))
                                {{ $orders->total() }}
                            @else
                                {{ $orders->count() }}
                            @endif
                            pesanan
                        </span>

                    </div>

                </div>

                

                @if($orders->count() > 0)

                    <div class="ko-table-wrapper">

                        <table class="ko-table">

                            <thead>

                                <tr>

                                    <th>
                                        Kode Pesanan
                                    </th>

                                    <th>
                                        Pelanggan
                                    </th>

                                    <th>
                                        Item Oleh-Oleh
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Total
                                    </th>

                                    <th>
                                        Aksi
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($orders as $order)

                                    @php

                                        $details =
                                            $order->details
                                                ? $order->details->whereNotNull('id_oleh_oleh')
                                                : collect();

                                        $totalQty =
                                            $details->sum('qty');

                                        $totalOlehOleh =
                                            $details->sum(function ($detail) {
                                                return (int) ($detail->subtotal ?? 0);
                                            });

                                        $status =
                                            $order->status
                                                ?? 'Menunggu Pembayaran';

                                        $statusClass = match ($status) {

                                            'Selesai'
                                                => 'done',

                                            'Batal'
                                                => 'cancel',

                                            'Menunggu Pengambilan'
                                                => 'process',

                                            default
                                                => 'waiting',

                                        };

                                        $modalId =
                                            'koModal-' . $order->id_pesanan;

                                        $hasPendingItems =
                                            $details
                                                ->where(
                                                    'status_item',
                                                    '!=',
                                                    'Selesai'
                                                )
                                                ->count() > 0;

                                    @endphp

                                    <tr>

                                        

                                        <td>

                                            <span class="ko-order-code">
                                                {{ $order->kode_pesanan ?? '-' }}
                                            </span>

                                        </td>

                                        

                                        <td>

                                            <span class="ko-customer-name">
                                                {{ $order->nama_pelanggan ?? '-' }}
                                            </span>

                                            <span class="ko-customer-wa">
                                                {{ $order->no_wa ?? '-' }}
                                            </span>

                                        </td>

                                        

                                        <td>

                                            <span class="ko-item-badge">

                                                <i class="fas fa-bag-shopping"></i>

                                                {{ $totalQty }}

                                                item

                                            </span>

                                        </td>

                                        

                                        <td>

                                            <span
                                                class="ko-status {{ $statusClass }}"
                                            >

                                                <span class="ko-status-dot"></span>

                                                {{ $status }}

                                            </span>

                                        </td>

                                        

                                        <td>

                                            <span class="ko-total">

                                                Rp
                                                {{ number_format(
                                                    $totalOlehOleh,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </span>

                                        </td>

                                        

                                        <td>

                                            <button
                                                type="button"
                                                class="ko-detail-button"
                                                data-open-modal="{{ $modalId }}"
                                            >

                                                <i class="fas fa-eye"></i>

                                                Detail

                                            </button>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>
                    </div>

                    

                    @foreach($orders as $order)

                        @php
                            $details = $order->details
                                ? $order->details->whereNotNull('id_oleh_oleh')
                                : collect();

                            $totalQty = $details->sum('qty');

                            $totalOlehOleh = $details->sum(function ($detail) {
                                return (int) ($detail->subtotal ?? 0);
                            });

                            $status = $order->status ?? 'Menunggu Pembayaran';

                            $modalId = 'koModal-' . $order->id_pesanan;

                            $hasPendingItems = $details
                                ->where('status_item', '!=', 'Selesai')
                                ->count() > 0;
                        @endphp

                                    <div
                                        class="ko-modal"
                                        id="{{ $modalId }}"
                                        aria-hidden="true"
                                    >

                                        <div
                                            class="ko-modal-card"
                                            role="dialog"
                                            tabindex="-1"
                                            aria-modal="true"
                                            aria-labelledby="{{ $modalId }}-title"
                                        >

                                            

                                            <div class="ko-modal-header">

                                                <div>

                                                    <span class="ko-modal-eyebrow">
                                                        Detail Transaksi
                                                    </span>

                                                    <h2 id="{{ $modalId }}-title">
                                                        {{ $order->kode_pesanan ?? '-' }}
                                                    </h2>

                                                </div>

                                                <button
                                                    type="button"
                                                    class="ko-modal-close"
                                                    data-close-modal="{{ $modalId }}"
                                                    aria-label="Tutup detail"
                                                >
                                                    <i class="fas fa-xmark"></i>
                                                </button>

                                            </div>

                                            

                                            <div class="ko-modal-body">

                                                

                                                <div class="ko-info-grid">

                                                    <div class="ko-info-box">

                                                        <span>
                                                            Nama Pelanggan
                                                        </span>

                                                        <strong>
                                                            {{ $order->nama_pelanggan ?? '-' }}
                                                        </strong>

                                                    </div>

                                                    <div class="ko-info-box">

                                                        <span>
                                                            Nomor WhatsApp
                                                        </span>

                                                        <strong>
                                                            {{ $order->no_wa ?? '-' }}
                                                        </strong>

                                                    </div>

                                                    <div class="ko-info-box">

                                                        <span>
                                                            Metode Pembayaran
                                                        </span>

                                                        <strong>
                                                            {{ $order->metode_pembayaran ?? '-' }}
                                                        </strong>

                                                    </div>

                                                    <div class="ko-info-box">

                                                        <span>
                                                            Status Pesanan
                                                        </span>

                                                        <strong>
                                                            {{ $status }}
                                                        </strong>

                                                    </div>

                                                </div>

                                                

                                                <div class="ko-detail-heading">

                                                    <h3>
                                                        Item Oleh-Oleh
                                                    </h3>

                                                    <span>
                                                        {{ $totalQty }} item
                                                    </span>

                                                </div>

                                                

                                                <div class="ko-items-box">

                                                    @forelse($details as $detail)

                                                        @php

                                                            $product =
                                                                $detail->olehOleh;

                                                            $productName =
                                                                $product?->nama
                                                                    ?? 'Produk Oleh-Oleh';

                                                            $productType =
                                                                $product?->jenis
                                                                    ?? '-';

                                                            $qty =
                                                                (int) (
                                                                    $detail->qty
                                                                        ?? 0
                                                                );

                                                            $price =
                                                                (int) (
                                                                    $detail->harga
                                                                        ?? 0
                                                                );

                                                            $subtotal =
                                                                (int) (
                                                                    $detail->subtotal
                                                                        ?? (
                                                                            $price
                                                                            * $qty
                                                                        )
                                                                );

                                                            $itemStatus =
                                                                $detail->status_item
                                                                    ?? 'Menunggu';

                                                        @endphp

                                                        <div class="ko-item-row">

                                                            <div class="ko-item-name">

                                                                <strong>
                                                                    {{ $productName }}
                                                                </strong>

                                                                <span>
                                                                    {{ $productType }}
                                                                </span>

                                                            </div>

                                                            <div class="ko-item-meta">

                                                                {{ $qty }}
                                                                ×
                                                                Rp
                                                                {{ number_format(
                                                                    $price,
                                                                    0,
                                                                    ',',
                                                                    '.'
                                                                ) }}

                                                            </div>

                                                            <span
                                                                class="ko-item-status
                                                                {{ $itemStatus === 'Selesai' ? 'done' : '' }}"
                                                            >
                                                                {{ $itemStatus }}
                                                            </span>

                                                            <div class="ko-item-subtotal">

                                                                Rp
                                                                {{ number_format(
                                                                    $subtotal,
                                                                    0,
                                                                    ',',
                                                                    '.'
                                                                ) }}

                                                            </div>

                                                        </div>

                                                    @empty

                                                        <div class="ko-empty">

                                                            <div class="ko-empty-icon">
                                                                <i class="fas fa-bag-shopping"></i>
                                                            </div>

                                                            <h3>
                                                                Tidak Ada Item Oleh-Oleh
                                                            </h3>

                                                            <p>
                                                                Pesanan ini tidak memiliki
                                                                detail oleh-oleh.
                                                            </p>

                                                        </div>

                                                    @endforelse

                                                </div>

                                                

                                                <div class="ko-total-box">

                                                    <span>
                                                        Total Oleh-Oleh
                                                    </span>

                                                    <strong>

                                                        Rp
                                                        {{ number_format(
                                                            $totalOlehOleh,
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) }}

                                                    </strong>

                                                </div>

                                                

                                                @if(
                                                    $status === 'Menunggu Pembayaran'
                                                    && $hasPendingItems
                                                )

                                                    <div class="ko-warning">

                                                        <i class="fas fa-money-bill-wave"></i>

                                                        <span>
                                                            Pesanan masih menunggu verifikasi
                                                            pembayaran bagian Oleh-Oleh.
                                                            Verifikasi ini hanya untuk bagian
                                                            Oleh-Oleh dan tidak mengubah bagian
                                                            Menu atau Wahana.
                                                        </span>

                                                    </div>

                                                @elseif(
                                                    $status === 'Menunggu Pengambilan'
                                                    && $hasPendingItems
                                                )

                                                    <div class="ko-warning">

                                                        <i class="fas fa-circle-info"></i>

                                                        <span>
                                                            Pastikan jumlah barang yang
                                                            diserahkan sudah sesuai.
                                                            Setelah pengambilan diverifikasi,
                                                            item Oleh-Oleh akan ditandai selesai
                                                            dan stok akan dikurangi oleh sistem.
                                                        </span>

                                                    </div>

                                                @endif

                                                

                                                <div class="ko-modal-footer">

                                                    <button
                                                        type="button"
                                                        class="ko-button-secondary"
                                                        data-close-modal="{{ $modalId }}"
                                                    >
                                                        Tutup
                                                    </button>

                                                    @if(
                                                        $verifyRouteExists
                                                        && in_array($status, ['Menunggu Pembayaran', 'Menunggu Pengambilan'], true)
                                                        && $hasPendingItems
                                                    )

                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'kasir.oleholeh.orders.verify',
                                                                $order->id_pesanan
                                                            ) }}"
                                                            class="ko-verify-form"
                                                        >

                                                            @csrf

                                                            <input
                                                                type="hidden"
                                                                name="confirmation"
                                                                value="1"
                                                            >

                                                            <button
                                                                type="submit"
                                                                class="ko-button-primary"
                                                            >

                                                                @if($status === 'Menunggu Pembayaran')
                                                                    <i class="fas fa-money-check-dollar"></i>
                                                                    Verifikasi Pembayaran
                                                                @else
                                                                    <i class="fas fa-circle-check"></i>
                                                                    Verifikasi Pengambilan
                                                                @endif

                                                            </button>

                                                        </form>

                                                    @elseif($status === 'Selesai')

                                                        <button
                                                            type="button"
                                                            class="ko-button-primary"
                                                            disabled
                                                        >
                                                            <i class="fas fa-check"></i>
                                                            Sudah Selesai
                                                        </button>

                                                    @elseif($status === 'Menunggu Pembayaran')

                                                        <button
                                                            type="button"
                                                            class="ko-button-primary"
                                                            disabled
                                                        >
                                                            <i class="fas fa-clock"></i>
                                                            Menunggu Pembayaran
                                                        </button>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                    @endforeach

                    

                    @if(method_exists($orders, 'links'))

                        <div class="ko-pagination">

                            {{ $orders->withQueryString()->links() }}

                        </div>

                    @endif

                @else

                    

                    <div class="ko-empty">

                        <div class="ko-empty-icon">
                            <i class="fas fa-receipt"></i>
                        </div>

                        <h3>
                            Belum Ada Pesanan
                        </h3>

                        <p>
                            Pesanan oleh-oleh yang masuk akan tampil
                            di halaman ini.
                        </p>

                    </div>

                @endif

            </section>

        </div>

    </main>

    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let activeTrigger = null;

            function openModal(id, trigger) {
                const modal = document.getElementById(id);

                if (!modal) return;

                activeTrigger = trigger || document.activeElement;
                modal.classList.add('show');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('ko-modal-open');

                const firstFocusable = modal.querySelector(
                    'button:not([disabled]), a[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
                );

                (firstFocusable || modal.querySelector('.ko-modal-card'))?.focus();
            }

            function closeModal(id) {
                const modal = document.getElementById(id);

                if (!modal) return;

                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');

                if (!document.querySelector('.ko-modal.show')) {
                    document.body.classList.remove('ko-modal-open');
                    activeTrigger?.focus();
                    activeTrigger = null;
                }
            }

            document.addEventListener('click', function (event) {
                const openButton = event.target.closest('[data-open-modal]');

                if (openButton) {
                    event.preventDefault();
                    openModal(openButton.getAttribute('data-open-modal'), openButton);
                    return;
                }

                const closeButton = event.target.closest('[data-close-modal]');

                if (closeButton) {
                    event.preventDefault();
                    closeModal(closeButton.getAttribute('data-close-modal'));
                    return;
                }

                const modal = event.target.closest('.ko-modal');

                if (modal && event.target === modal) {
                    closeModal(modal.id);
                }
            });

            document.addEventListener('keydown', function (event) {
                const activeModal = document.querySelector('.ko-modal.show');

                if (!activeModal) return;

                if (event.key === 'Escape') {
                    event.preventDefault();
                    closeModal(activeModal.id);
                    return;
                }

                if (event.key === 'Tab') {
                    const focusable = Array.from(activeModal.querySelectorAll(
                        'button:not([disabled]), a[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
                    )).filter(element => element.offsetParent !== null);

                    if (!focusable.length) {
                        event.preventDefault();
                        activeModal.querySelector('.ko-modal-card')?.focus();
                        return;
                    }

                    const first = focusable[0];
                    const last = focusable[focusable.length - 1];

                    if (event.shiftKey && document.activeElement === first) {
                        event.preventDefault();
                        last.focus();
                    } else if (!event.shiftKey && document.activeElement === last) {
                        event.preventDefault();
                        first.focus();
                    }
                }
            });

            const statusFilter = document.getElementById('koStatusFilter');

            if (statusFilter) {
                statusFilter.addEventListener('change', function () {
                    const url = new URL(window.location.href);
                    url.searchParams.set('status', this.value);

                    const currentSearch = @json($search);

                    if (currentSearch) {
                        url.searchParams.set('search', currentSearch);
                    } else {
                        url.searchParams.delete('search');
                    }

                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                });
            }

            document.addEventListener('submit', function (event) {
                const form = event.target.closest('.ko-verify-form');

                if (!form) return;

                const button = form.querySelector('button[type="submit"]');

                if (!button || button.dataset.submitted === '1') {
                    event.preventDefault();
                    return;
                }

                button.dataset.submitted = '1';
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Memproses...';
            });
        });
    </script>

</body>
</html>
