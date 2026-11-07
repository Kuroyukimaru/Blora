<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Oleh-Oleh</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
            --shadow-soft:0 20px 60px rgba(0,0,0,.4);
            --shadow-hover:0 25px 70px rgba(0,0,0,.5);
            --radius-lg:28px;
            --radius-md:16px;
            --radius-full:999px;
            --transition:.25s cubic-bezier(.4,0,.2,1);
        }

        *{box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{
            margin:0;
            font-family:'Inter',sans-serif;
            background:
                radial-gradient(circle at 88% 4%,rgba(226,201,151,.055),transparent 30%),
                radial-gradient(circle at 4% 96%,rgba(226,201,151,.025),transparent 28%),
                var(--bg-primary);
            color:var(--text-primary);
            overflow-x:hidden;
            line-height:1.65;
            font-size:15px;
        }
        button,input,select{font:inherit}
        ::selection{background:rgba(226,201,151,.25);color:var(--text-primary)}

        .container-custom{
            width:calc(100% - 270px) !important;
            max-width:none !important;
            margin-left:270px !important;
            margin-right:0 !important;
            padding:48px 46px 64px !important;
            min-height:100vh;
        }

        
        .container-custom > div:first-child{
            margin-bottom:30px !important;
            align-items:flex-end !important;
            gap:28px !important;
        }
        .container-custom > div:first-child p:first-child{
            margin-bottom:8px !important;
            color:var(--text-muted) !important;
            font-size:13px !important;
            font-weight:700 !important;
            letter-spacing:1.8px !important;
        }
        .container-custom h1{
            margin:0 !important;
            font-family:'Playfair Display','Inter',serif !important;
            font-size:clamp(38px,4vw,58px) !important;
            font-weight:700 !important;
            line-height:1.08 !important;
            letter-spacing:-1px !important;
        }
        .container-custom > div:first-child p:last-child{
            margin-top:10px !important;
            color:var(--text-muted) !important;
            font-size:16px !important;
            line-height:1.7 !important;
        }

        .text-gradient{
            background:linear-gradient(135deg,var(--accent) 0%,#f8f4ed 50%,var(--accent-dark) 100%) !important;
            -webkit-background-clip:text !important;
            -webkit-text-fill-color:transparent !important;
            background-clip:text !important;
        }

        
        .btn-primary-travel{
            min-height:56px;
            padding:0 24px !important;
            border-radius:var(--radius-full) !important;
            background:linear-gradient(135deg,var(--accent),var(--accent-hover)) !important;
            color:var(--bg-primary) !important;
            font-size:15px !important;
            font-weight:800 !important;
            letter-spacing:.1px !important;
            box-shadow:0 10px 28px rgba(0,0,0,.22);
            transition:all var(--transition);
            white-space:nowrap;
        }
        .btn-primary-travel:hover{
            background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark)) !important;
            transform:translateY(-3px);
            box-shadow:var(--shadow-hover);
        }
        .btn-secondary-travel{
            min-width:46px;
            min-height:46px;
            padding:0 14px !important;
            border:1px solid var(--border-gold) !important;
            border-radius:13px !important;
            background:rgba(226,201,151,.055) !important;
            color:var(--text-secondary) !important;
            font-size:15px !important;
            font-weight:700 !important;
            backdrop-filter:blur(12px);
            transition:all var(--transition);
        }
        .btn-secondary-travel:hover{
            background:rgba(226,201,151,.12) !important;
            border-color:rgba(226,201,151,.48) !important;
            color:var(--accent) !important;
            transform:translateY(-2px);
        }

        
        .container-custom .glass-effect{
            border:1px solid var(--border-gold) !important;
            background:rgba(255,255,255,.035) !important;
            backdrop-filter:blur(24px);
            box-shadow:var(--shadow-soft);
        }
        .container-custom > .glass-effect{
            border-radius:var(--radius-lg) !important;
        }

        
        .container-custom > div:nth-of-type(5){
            padding:30px !important;
        }

        
        #searchOlehOleh,
        #filterJenis{
            min-height:58px;
            padding:0 18px !important;
            border-radius:14px !important;
            border:1px solid var(--border-soft) !important;
            background:rgba(255,255,255,.035) !important;
            color:var(--text-primary) !important;
            font-size:15px !important;
            line-height:1.5;
            transition:all var(--transition);
        }
        #searchOlehOleh{
            min-width:260px !important;
        }
        #filterJenis{
            min-width:220px !important;
        }
        #searchOlehOleh::placeholder{color:var(--text-dim)}
        #searchOlehOleh:focus,
        #filterJenis:focus{
            outline:none;
            border-color:rgba(226,201,151,.58) !important;
            background:rgba(226,201,151,.045) !important;
            box-shadow:0 0 0 3px rgba(226,201,151,.075);
        }
        #filterJenis option{background:#171717;color:var(--text-primary)}

        
        .container-custom table{
            width:100%;
            border-collapse:separate !important;
            border-spacing:0;
            min-width:900px;
        }
        .container-custom thead th{
            padding:18px 20px !important;
            color:var(--text-muted) !important;
            font-size:13px !important;
            font-weight:800 !important;
            letter-spacing:.35px;
            text-transform:uppercase;
            white-space:nowrap;
        }
        .container-custom tbody td{
            padding:20px !important;
            color:var(--text-secondary);
            font-size:15px !important;
            vertical-align:middle;
        }
        .container-custom tbody tr{
            transition:background var(--transition),transform var(--transition);
        }
        .container-custom tbody tr:hover{
            background:rgba(226,201,151,.035);
        }
        .container-custom tbody tr:last-child td{border-bottom:0 !important}
        .container-custom tbody strong{
            color:var(--text-primary);
            font-size:15px !important;
            font-weight:700 !important;
        }
        .container-custom tbody td span{
            font-size:14px !important;
        }
        .container-custom tbody td img{
            width:76px !important;
            height:76px !important;
            border-radius:16px !important;
            border:1px solid var(--border-soft);
        }

        
        .container-custom tbody td span[style*="6EE7B7"]{
            color:#8fe6bd !important;
            font-size:14px !important;
            font-weight:700 !important;
        }
        .container-custom tbody td span[style*="F87171"]{
            color:#f29a9a !important;
            font-size:14px !important;
            font-weight:700 !important;
        }

        
        .container-custom tbody td[colspan]{
            padding:70px 20px !important;
            color:var(--text-muted) !important;
            font-size:15px !important;
        }
        .container-custom tbody td[colspan] div{
            color:var(--accent) !important;
            font-size:48px !important;
        }

        @media (min-width:1400px){
            .container-custom{
                margin-left:285px !important;
                width:calc(100% - 285px) !important;
                padding:54px 58px 72px !important;
            }
            .container-custom > div:first-child{
                margin-bottom:34px !important;
            }
            .container-custom > div:nth-of-type(5){
                padding:34px !important;
            }
        }

        @media (min-width:901px) and (max-width:1100px){
            .container-custom{
                margin-left:255px !important;
                width:calc(100% - 255px) !important;
                padding:40px 28px 54px !important;
            }
            .container-custom h1{font-size:40px !important}
            .container-custom > div:first-child p:last-child{font-size:15px !important}
        }

        @media (max-width:900px){
            .container-custom{
                width:100% !important;
                margin-left:0 !important;
                padding:90px 26px 48px !important;
            }
            .container-custom > div:first-child{
                flex-direction:column !important;
                align-items:flex-start !important;
                margin-bottom:26px !important;
                gap:16px !important;
            }
            .container-custom h1{font-size:44px !important}
            .container-custom > div:first-child p:last-child{font-size:15px !important}
            .btn-primary-travel{width:auto;min-height:56px}
            .container-custom > div:nth-of-type(5){padding:26px !important}
        }

        @media (max-width:600px){
            .container-custom{
                padding:78px 15px 36px !important;
            }
            .container-custom h1{
                font-size:38px !important;
                letter-spacing:-.6px !important;
            }
            .container-custom > div:first-child p:first-child{
                font-size:12px !important;
                letter-spacing:1.4px !important;
            }
            .container-custom > div:first-child p:last-child{
                margin-top:8px !important;
                font-size:14px !important;
                line-height:1.7 !important;
            }
            .btn-primary-travel{
                width:100%;
                min-height:56px;
                font-size:15px !important;
            }
            .container-custom > .glass-effect{
                padding:18px !important;
                border-radius:22px !important;
            }
            #searchOlehOleh,
            #filterJenis{
                width:100% !important;
                min-width:0 !important;
                min-height:56px;
                font-size:15px !important;
            }
            .container-custom table{min-width:900px}
            .container-custom thead th{font-size:13px !important}
            .container-custom tbody td{font-size:15px !important}
            .container-custom tbody td img{
                width:68px !important;
                height:68px !important;
            }
        }

        @media (max-width:380px){
            .container-custom{padding-left:12px !important;padding-right:12px !important}
            .container-custom h1{font-size:34px !important}
            .container-custom > .glass-effect{padding:14px !important}
            .container-custom > div:nth-of-type(5){padding:20px !important}
        }

        @media (prefers-reduced-motion:reduce){
            *,*::before,*::after{
                scroll-behavior:auto !important;
                transition:none !important;
                animation:none !important;
            }
        }

\n        
        .display-control{
            display:flex;
            align-items:center;
            gap:9px;
            color:var(--text-muted);
            font-size:13px;
            white-space:nowrap;
        }

        .select-wrapper.small{
            width:88px;
            flex-shrink:0;
        }

        .table-footer{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            padding:10px 4px;
            border-top:0;
            background:transparent;
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

        @media(max-width:900px){
            .table-footer{
                align-items:flex-start;
                flex-direction:column;
            }

            .pagination{
                width:100%;
                justify-content:flex-start;
                flex-wrap:wrap;
            }
        }

        @media(max-width:600px){
            .table-footer{
                padding:15px;
            }

            .pagination-info{
                font-size:13px;
                white-space:normal;
            }

            .pagination{
                justify-content:center;
            }

            .pagination-button{
                min-width:40px;
                height:40px;
            }
        }

        
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
            box-shadow:0 12px 35px rgba(0,0,0,.25);
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
            font-family:'Playfair Display','Inter',serif;
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
            font-weight:700;
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
            font-family:'Inter',sans-serif;
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

        .delete-confirm i{
            margin-right:7px;
        }

        body.modal-open{
            overflow:hidden;
        }

        @media(max-width:600px){
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

        @media(prefers-reduced-motion:reduce){
            .delete-modal-backdrop,
            .delete-modal{
                transition:none !important;
            }
        }


        

        .container-custom{
            width:100% !important;
            max-width:none !important;
            margin-left:0 !important;
            padding:50px 54px 70px !important;
            min-height:100vh;
        }

        .container-custom > div:first-child{
            max-width:1500px;
            margin:0 auto 34px !important;
            padding:0 !important;
            align-items:flex-end !important;
        }

        .container-custom > div:first-child p:first-child{
            display:none !important;
        }

        .container-custom h1{
            font-size:clamp(40px,4vw,58px) !important;
            letter-spacing:-1.2px !important;
        }

        .container-custom > div:first-child p:last-child{
            max-width:650px;
            font-size:16px !important;
            color:var(--text-muted) !important;
        }

        .modern-toolbar{
            display:grid;
            grid-template-columns:minmax(280px,1fr) auto auto;
            align-items:center;
            gap:12px;
            margin-bottom:18px;
            padding:13px;
            border:1px solid rgba(255,255,255,.07);
            border-radius:20px;
            background:
                linear-gradient(145deg,rgba(255,255,255,.045),rgba(255,255,255,.018)),
                rgba(18,18,18,.92);
            box-shadow:0 18px 55px rgba(0,0,0,.28);
        }

        .toolbar-search{
            position:relative;
            min-width:0;
        }

        .toolbar-search input{
            width:100%;
            height:54px;
            padding:0 58px;
            border:1px solid rgba(255,255,255,.07);
            border-radius:15px;
            outline:none;
            background:rgba(255,255,255,.035);
            color:var(--text-primary);
            font-size:15px;
            transition:all var(--transition);
        }

        .toolbar-search input::placeholder{
            color:var(--text-dim);
        }

        .toolbar-search input:focus{
            border-color:rgba(226,201,151,.5);
            background:rgba(226,201,151,.045);
            box-shadow:0 0 0 4px rgba(226,201,151,.06);
        }

        .search-icon-modern{
            position:absolute;
            top:50%;
            left:18px;
            z-index:2;
            color:var(--text-dim);
            transform:translateY(-50%);
            pointer-events:none;
        }

        .clear-search-modern{
            position:absolute;
            top:50%;
            right:10px;
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
        }

        .clear-search-modern:hover{
            color:var(--accent);
            background:rgba(226,201,151,.09);
        }

        
        .toolbar-search input#searchOlehOleh{
            padding-left:56px !important;
            padding-right:52px !important;
        }

        .toolbar-search .search-icon-modern{
            left:18px !important;
            width:20px;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .toolbar-search .search-icon-modern i{
            display:block;
            line-height:1;
        }

        .toolbar-filter,
        .toolbar-per-page{
            min-height:54px;
            display:flex;
            align-items:center;
            gap:9px;
            padding:0 13px;
            border:1px solid rgba(255,255,255,.07);
            border-radius:15px;
            background:rgba(255,255,255,.025);
        }

        .toolbar-label{
            color:var(--text-muted);
            font-size:13px;
            font-weight:700;
            white-space:nowrap;
        }

        .toolbar-filter .toolbar-label{
            display:inline-flex;
            align-items:center;
            gap:7px;
        }

        .toolbar-filter .toolbar-label i{
            color:var(--accent);
            font-size:12px;
        }

        .modern-select-wrap{
            position:relative;
            min-width:175px;
        }

        .modern-select-wrap.compact{
            min-width:70px;
        }

        .modern-select-wrap select{
            width:100%;
            height:42px;
            appearance:none;
            padding:0 34px 0 13px;
            border:1px solid rgba(226,201,151,.12);
            border-radius:11px;
            outline:none;
            background:#181818;
            color:var(--text-primary);
            font-size:14px;
            font-weight:700;
            cursor:pointer;
        }

        .modern-select-wrap select:focus{
            border-color:rgba(226,201,151,.5);
            box-shadow:0 0 0 3px rgba(226,201,151,.06);
        }

        .modern-select-wrap i{
            position:absolute;
            top:50%;
            right:12px;
            color:var(--text-dim);
            font-size:11px;
            pointer-events:none;
            transform:translateY(-50%);
        }

        .table-scroll{
            overflow:auto;
            border:1px solid rgba(255,255,255,.055);
            border-radius:20px;
            background:#101010;
            scrollbar-width:thin;
            scrollbar-color:rgba(226,201,151,.3) transparent;
        }

        .table-scroll::-webkit-scrollbar{height:7px}
        .table-scroll::-webkit-scrollbar-track{background:transparent}
        .table-scroll::-webkit-scrollbar-thumb{
            background:rgba(226,201,151,.3);
            border-radius:999px;
        }

        .modern-table{
            width:100%;
            min-width:920px;
            border-collapse:separate !important;
            border-spacing:0;
        }

        .modern-table thead{
            background:
                linear-gradient(180deg,rgba(226,201,151,.055),rgba(255,255,255,.018));
        }

        .modern-table thead th{
            padding:17px 20px !important;
            border-bottom:1px solid rgba(226,201,151,.13);
            color:#9e9486 !important;
            font-size:11px !important;
            font-weight:800 !important;
            letter-spacing:1.3px;
        }

        .modern-table tbody tr{
            background:rgba(255,255,255,.008);
            transition:background .2s ease;
        }

        .modern-table tbody tr:hover{
            background:rgba(226,201,151,.035);
        }

        .modern-table tbody td{
            padding:17px 20px !important;
            border-bottom:1px solid rgba(255,255,255,.045);
            font-size:15px !important;
        }

        .modern-table tbody tr:last-child td{
            border-bottom:0 !important;
        }

        .modern-table tbody td img{
            width:68px !important;
            height:68px !important;
            border-radius:16px !important;
            border:1px solid rgba(226,201,151,.12);
            box-shadow:0 8px 24px rgba(0,0,0,.22);
            display:block;
            object-fit:cover;
        }

        .table-product-image{
            position:relative;
            width:68px;
            height:68px;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            border-radius:16px;
            background:rgba(255,255,255,.025);
            border:1px solid rgba(226,201,151,.12);
            box-shadow:0 8px 24px rgba(0,0,0,.22);
        }

        .table-product-image .table-product-image-fallback{
            position:absolute;
            inset:0;
            display:none;
            align-items:center;
            justify-content:center;
            color:rgba(226,201,151,.42);
            font-size:18px;
            background:
                radial-gradient(circle at 50% 25%,rgba(226,201,151,.09),transparent 45%),
                #151515;
        }

        .modern-table tbody strong{
            font-size:15px !important;
            font-weight:750 !important;
        }

        .modern-table tbody td span{
            font-size:13px !important;
            line-height:1.55;
        }

        .btn-secondary-travel{
            width:42px;
            min-width:42px;
            height:42px;
            min-height:42px;
            padding:0 !important;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border-radius:12px !important;
        }

        .modern-table .btn-secondary-travel:first-child:hover{
            background:rgba(226,201,151,.1) !important;
        }

        .modern-table .btn-secondary-travel i{
            font-size:14px;
        }

        .modern-table-footer{
            min-height:54px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:18px;
            padding:8px 4px 0;
            border:0;
            border-radius:0 0 20px 20px;
            background:transparent;
        }

        .pagination-summary{
            display:flex;
            align-items:center;
            gap:8px;
            min-width:0;
            opacity:.58;
        }

        .summary-icon{
            width:25px;
            height:25px;
            display:flex;
            align-items:center;
            justify-content:center;
            flex:0 0 25px;
            border:0;
            border-radius:8px;
            background:rgba(255,255,255,.025);
            color:var(--text-dim);
            font-size:10px;
        }

        .summary-label{
            display:block;
            margin-bottom:0;
            color:rgba(168,153,136,.62);
            font-size:9px;
            line-height:1.15;
            font-weight:700;
            letter-spacing:1px;
            text-transform:uppercase;
        }

        .pagination-info{
            color:rgba(212,201,181,.62);
            font-size:10px;
            line-height:1.35;
            font-weight:600;
        }

        .modern-pagination{
            display:flex;
            align-items:center;
            gap:6px;
        }

        .page-numbers{
            display:flex;
            align-items:center;
            gap:5px;
        }

        .pagination-nav,
        .pagination-button{
            width:40px;
            height:40px;
            min-width:40px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:0;
            border:1px solid rgba(255,255,255,.07);
            border-radius:11px;
            background:rgba(255,255,255,.035);
            color:var(--text-muted);
            font-size:13px;
            font-weight:800;
            cursor:pointer;
            transition:all var(--transition);
        }

        .pagination-nav:hover:not(:disabled),
        .pagination-button:hover:not(:disabled){
            border-color:rgba(226,201,151,.35);
            background:rgba(226,201,151,.08);
            color:var(--accent);
            transform:translateY(-1px);
        }

        .pagination-button.active{
            border-color:rgba(226,201,151,.55);
            background:linear-gradient(135deg,var(--accent),var(--accent-hover));
            color:#111;
            box-shadow:0 7px 20px rgba(226,201,151,.12);
        }

        .pagination-nav:disabled{
            opacity:.28;
            cursor:not-allowed;
        }

        .pagination-dots{
            width:30px;
            height:40px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            color:var(--text-dim);
            font-size:13px;
        }

        @media(min-width:1400px){
            .container-custom{
                padding:58px 68px 76px !important;
            }
        }

        @media(max-width:1100px){
            .container-custom{
                padding:42px 28px 55px !important;
            }

            .modern-toolbar{
                grid-template-columns:1fr 1fr;
            }

            .toolbar-search{
                grid-column:1 / -1;
            }

            .toolbar-filter,
            .toolbar-per-page{
                width:100%;
            }
        }

        @media(max-width:900px){
            .container-custom{
                padding:92px 24px 48px !important;
            }

            .container-custom > div:first-child{
                align-items:flex-start !important;
                margin-bottom:28px !important;
            }

            .modern-toolbar{
                grid-template-columns:1fr;
                padding:12px;
            }

            .toolbar-search{
                grid-column:auto;
            }

            .modern-select-wrap{
                flex:1;
            }
        }

        @media(max-width:600px){
            .container-custom{
                padding:80px 15px 35px !important;
            }

            .container-custom h1{
                font-size:38px !important;
            }

            .container-custom > div:first-child p:last-child{
                font-size:14px !important;
            }

            .btn-primary-travel{
                width:100%;
                min-height:56px;
            }

            .container-custom > .glass-effect{
                padding:16px !important;
                border-radius:23px !important;
            }

            .modern-toolbar{
                border-radius:18px;
            }

            .toolbar-filter,
            .toolbar-per-page{
                min-height:56px;
            }

            .modern-select-wrap select{
                height:46px;
            }

            .modern-table-footer{
                align-items:center;
                flex-direction:column;
                gap:10px;
                padding:8px 2px 0;
            }

            .modern-pagination{
                justify-content:center;
                width:100%;
            }

            .pagination-nav,
            .pagination-button{
                width:42px;
                height:42px;
                min-width:42px;
            }

            .pagination-summary{
                justify-content:center;
            }
        }

        @media(max-width:380px){
            .container-custom{
                padding-left:12px !important;
                padding-right:12px !important;
            }

            .container-custom h1{
                font-size:34px !important;
            }

            .modern-table{
                min-width:880px;
            }
        }

        

        .admin-mobile-menu-button{
            position:fixed;
            top:max(16px, env(safe-area-inset-top));
            left:max(16px, env(safe-area-inset-left));
            z-index:1205;

            width:48px;
            height:48px;

            display:none;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            gap:5px;

            padding:0;

            border:1px solid rgba(226,201,151,.20);
            border-radius:14px;

            background:
                linear-gradient(
                    145deg,
                    rgba(226,201,151,.12),
                    rgba(255,255,255,.035)
                ),
                rgba(12,12,12,.94);

            color:var(--accent);

            box-shadow:
                0 12px 35px rgba(0,0,0,.38),
                inset 0 1px 0 rgba(255,255,255,.05);

            backdrop-filter:blur(16px);
            -webkit-backdrop-filter:blur(16px);

            cursor:pointer;

            transition:
                transform var(--transition),
                background var(--transition),
                border-color var(--transition),
                opacity var(--transition);
        }

        .admin-mobile-menu-button:hover{
            transform:translateY(-2px);
            border-color:rgba(226,201,151,.42);
            background:
                linear-gradient(
                    145deg,
                    rgba(226,201,151,.18),
                    rgba(255,255,255,.05)
                ),
                rgba(18,18,18,.96);
        }

        .admin-mobile-menu-button:active{
            transform:scale(.96);
        }

        .admin-mobile-menu-button:focus-visible{
            outline:2px solid rgba(226,201,151,.72);
            outline-offset:3px;
        }

        .admin-mobile-menu-button span{
            display:block;
            width:20px;
            height:2px;
            border-radius:999px;
            background:var(--accent);
            transition:
                transform .25s ease,
                opacity .25s ease;
        }

        body.admin-sidebar-open .admin-mobile-menu-button{
            opacity:0;
            pointer-events:none;
            transform:translateY(-8px);
        }

        
        @media (min-width:901px) and (max-width:1199px){
            .container-custom{
                width:calc(100% - 270px) !important;
                margin-left:270px !important;
            }
        }

        
        @media (min-width:1200px) and (max-width:1399px){
            .container-custom{
                width:calc(100% - 280px) !important;
                margin-left:280px !important;
            }
        }

        
        @media (min-width:1400px){
            .container-custom{
                width:calc(100% - 290px) !important;
                margin-left:290px !important;
            }
        }

        
        @media (max-width:900px){
            .admin-mobile-menu-button{
                display:flex;
            }

            .container-custom{
                width:100% !important;
                margin-left:0 !important;
                padding-top:92px !important;
            }
        }

        @media (max-width:600px){
            .admin-mobile-menu-button{
                top:max(12px, env(safe-area-inset-top));
                left:max(12px, env(safe-area-inset-left));
                width:46px;
                height:46px;
                border-radius:13px;
            }

            .admin-mobile-menu-button span{
                width:19px;
            }

            .container-custom{
                padding-top:80px !important;
            }
        }

        @media (prefers-reduced-motion:reduce){
            .admin-mobile-menu-button,
            .admin-mobile-menu-button span{
                transition:none !important;
            }
        }

    </style>



<style id="noyo-gimbal-sidebar-reference">


@media (max-width:900px){
    html,body{
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
                rgba(19,19,19,.93) 0%,
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

        transform:translate3d(calc(-100% - 28px),0,0) !important;
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
    }

    .admin-sidebar-close-button:hover{
        background:rgba(226,201,151,.09) !important;
        border-color:rgba(226,201,151,.40) !important;
        color:#f8f4ed !important;
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
        transition:background .2s ease,border-color .2s ease,color .2s ease,transform .2s ease !important;
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
        background:linear-gradient(135deg,rgba(226,201,151,.095),rgba(226,201,151,.025)) !important;
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
        background:linear-gradient(180deg,rgba(0,0,0,.12),rgba(0,0,0,.28)) !important;
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

    .admin-sidebar-overlay{
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

    .admin-sidebar-overlay.show{
        opacity:1 !important;
        pointer-events:auto !important;
    }

    body.admin-sidebar-open{
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
        background:linear-gradient(145deg,rgba(226,201,151,.10),rgba(255,255,255,.025)),rgba(12,12,12,.94) !important;
        color:#e2c997 !important;
        box-shadow:0 12px 35px rgba(0,0,0,.34),inset 0 1px 0 rgba(255,255,255,.045) !important;
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

    body.admin-sidebar-open .admin-mobile-menu-button{
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
    .admin-mobile-menu-button,
    .admin-nav-link,
    .admin-sidebar-close-button{
        transition:none !important;
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

<main
    class="container-custom"
>

    

    <div
        style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:40px;
            gap:30px;
        "
    >

        <div>

            <h1
                class="text-gradient"
                style="
                    font-size:3rem;
                    font-weight:800;
                    margin:0;
                "
            >
                Kelola Oleh-Oleh
            </h1>

            <p
                style="
                    color:var(--text-secondary);
                    margin-top:10px;
                "
            >
                Kelola berbagai produk oleh-oleh khas Blora.
            </p>

        </div>


        

        <a
            href="{{ route('admin.oleholeh.create') }}"
            class="btn-primary-travel"
        >
            <i class="fas fa-plus"></i>
            &nbsp;
            Tambah Oleh-Oleh
        </a>

    </div>


    

    @if(session('success'))

        <div
            class="glass-effect"
            style="
                padding:20px;
                border-radius:20px;
                margin-bottom:25px;
                color:#90ee90;
            "
        >
            <i class="fas fa-check-circle"></i>
            &nbsp;
            {{ session('success') }}
        </div>

    @endif


    

    @if(session('error'))

        <div
            class="glass-effect"
            style="
                padding:20px;
                border-radius:20px;
                margin-bottom:25px;
                color:#F87171;
            "
        >
            <i class="fas fa-exclamation-circle"></i>
            &nbsp;
            {{ session('error') }}
        </div>

    @endif


    

    @if($errors->any())

        <div
            class="glass-effect"
            style="
                padding:20px;
                border-radius:20px;
                margin-bottom:25px;
                color:#F87171;
            "
        >

            <strong>
                Terdapat kesalahan:
            </strong>

            <ul style="margin-top:10px;padding-left:20px;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    

    <div
        class="glass-effect"
        style="
            padding:30px;
            border-radius:28px;
        "
    >

        

        <div class="modern-toolbar">

            <div class="toolbar-search">
                <div class="search-icon-modern">
                    <i class="fas fa-magnifying-glass"></i>
                </div>

                <input
                    type="text"
                    id="searchOlehOleh"
                    placeholder="Cari nama oleh-oleh..."
                    autocomplete="off"
                    aria-label="Cari oleh-oleh"
                >

                <button
                    type="button"
                    class="clear-search-modern"
                    id="clearSearch"
                    aria-label="Hapus pencarian"
                    title="Hapus pencarian"
                >
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <div class="toolbar-filter">
                <span class="toolbar-label">
                    <i class="fas fa-sliders"></i>
                    Jenis
                </span>

                <div class="modern-select-wrap">
                    <select id="filterJenis" aria-label="Filter jenis oleh-oleh">
                        <option value="all">Semua Jenis</option>
                        <option value="totebag">Totebag</option>
                        <option value="baju">Baju</option>
                        <option value="celana">Celana</option>
                        <option value="topi">Topi</option>
                        <option value="gantungan kunci">Gantungan Kunci</option>
                        <option value="ikat rambut">Ikat Rambut</option>
                        <option value="kacamata">Kacamata</option>
                        <option value="daster">Daster</option>
                        <option value="sandal">Sandal</option>
                        <option value="pajangan tumbuhan">Pajangan Tumbuhan</option>
                        <option value="barongan">Barongan</option>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>

            <div class="toolbar-per-page">
                <span class="toolbar-label">
                    Tampilkan
                </span>

                <div class="modern-select-wrap compact">
                    <select
                        id="perPage"
                        aria-label="Jumlah data per halaman"
                    >
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>

                <span class="toolbar-label">
                    data
                </span>
            </div>

        </div>

        

        <div class="table-scroll">

            <table class="modern-table">

                <thead>

                    <tr
                        style="
                            border-bottom:1px solid var(--border-gold);
                        "
                    >

                        <th
                            style="
                                padding:20px;
                                text-align:left;
                            "
                        >
                            Gambar
                        </th>

                        <th
                            style="
                                padding:20px;
                                text-align:left;
                            "
                        >
                            Nama
                        </th>

                        <th
                            style="
                                padding:20px;
                                text-align:left;
                            "
                        >
                            Jenis
                        </th>

                        <th
                            style="
                                padding:20px;
                                text-align:left;
                            "
                        >
                            Harga
                        </th>

                        <th
                            style="
                                padding:20px;
                                text-align:left;
                            "
                        >
                            Stok
                        </th>

                        <th
                            style="
                                padding:20px;
                                text-align:left;
                            "
                        >
                            Status
                        </th>

                        <th
                            style="
                                padding:20px;
                                text-align:center;
                            "
                        >
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($olehOleh as $item)

                        <tr
                            class="souvenir-row"
                            data-nama="{{ strtolower($item->nama) }}"
                            data-jenis="{{ strtolower($item->jenis) }}"
                            style="
                                border-bottom:1px solid var(--border-soft);
                            "
                        >

                            

                            <td style="padding:20px;">

                                <div class="table-product-image">
                                    @if(!empty($item->gambar))
                                        <img
                                            src="{{ asset('storage/' . ltrim($item->gambar, '/')) }}"
                                            alt="Gambar {{ $item->nama }}"
                                            width="90"
                                            height="90"
                                            loading="lazy"
                                            decoding="async"
                                            onerror="this.onerror=null;this.hidden=true;this.nextElementSibling.style.display='flex';"
                                        >
                                    @endif
                                    <span
                                        class="table-product-image-fallback"
                                        aria-hidden="true"
                                        style="{{ !empty($item->gambar) ? 'display:none;' : 'display:flex;' }}"
                                    >
                                        <i class="fas fa-image"></i>
                                    </span>
                                </div>

                            </td>


                            

                            <td style="padding:20px;">

                                <strong>
                                    {{ $item->nama }}
                                </strong>

                                @if($item->deskripsi)

                                    <br>

                                    <span
                                        style="
                                            color:var(--text-muted);
                                            font-size:0.9rem;
                                        "
                                    >
                                        {{ Str::limit($item->deskripsi, 60) }}
                                    </span>

                                @endif

                            </td>


                            

                            <td style="padding:20px;">

                                {{ $item->jenis }}

                            </td>


                            

                            <td style="padding:20px;">

                                {{ $item->formatted_harga }}

                            </td>


                            

                            <td style="padding:20px;">

                                <strong>
                                    {{ number_format($item->stok, 0, ',', '.') }}
                                </strong>

                            </td>


                            

                            <td style="padding:20px;">

                                @if($item->status === 'Tersedia')

                                    <span
                                        style="
                                            color:#6EE7B7;
                                            font-weight:600;
                                        "
                                    >
                                        <i class="fas fa-check-circle"></i>
                                        Tersedia
                                    </span>

                                @else

                                    <span
                                        style="
                                            color:#F87171;
                                            font-weight:600;
                                        "
                                    >
                                        <i class="fas fa-times-circle"></i>
                                        Tidak Tersedia
                                    </span>

                                @endif

                            </td>


                            

                            <td
                                style="
                                    padding:20px;
                                    text-align:center;
                                    white-space:nowrap;
                                "
                            >

                                

                                <a
                                    href="{{ route(
                                        'admin.oleholeh.edit',
                                        $item->id_oleh_oleh
                                    ) }}"
                                    class="btn-secondary-travel"
                                    title="Edit Oleh-Oleh"
                                >
                                    <i class="fas fa-pen"></i>
                                </a>


                                

                                <form
                                    action="{{ route(
                                        'admin.oleholeh.destroy',
                                        $item->id_oleh_oleh
                                    ) }}"
                                    method="POST"
                                    style="
                                        display:inline-block;
                                        margin-left:5px;
                                    "
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="button"
                                        class="btn-secondary-travel"
                                        title="Hapus Oleh-Oleh"
                                        id="deleteForm{{ $item->id_oleh_oleh }}"
                                        onclick="openDeleteModal('{{ $item->id_oleh_oleh }}', @js($item->nama))"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                style="
                                    padding:60px 20px;
                                    text-align:center;
                                    color:var(--text-muted);
                                "
                            >

                                <div
                                    style="
                                        font-size:3rem;
                                        margin-bottom:15px;
                                        opacity:.5;
                                    "
                                >
                                    <i class="fas fa-box-open"></i>
                                </div>

                                <strong>
                                    Belum ada data oleh-oleh.
                                </strong>

                                <p style="margin-top:8px;">
                                    Silakan tambahkan produk oleh-oleh terlebih dahulu.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="modern-table-footer" id="tableFooter">

            <div class="pagination-summary">
                <span class="summary-icon">
                    <i class="fas fa-layer-group"></i>
                </span>

                <div>
                    <span class="summary-label">Data ditampilkan</span>
                    <strong id="paginationInfo">Menampilkan 0 data</strong>
                </div>
            </div>

            <div class="modern-pagination" id="pagination">

                <button
                    type="button"
                    id="prevPage"
                    class="pagination-nav"
                    aria-label="Halaman sebelumnya"
                    title="Halaman sebelumnya"
                >
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div id="pageNumbers" class="page-numbers"></div>

                <button
                    type="button"
                    id="nextPage"
                    class="pagination-nav"
                    aria-label="Halaman berikutnya"
                    title="Halaman berikutnya"
                >
                    <i class="fas fa-chevron-right"></i>
                </button>

            </div>

        </div>

</main>



<div class="delete-modal-backdrop" id="deleteModal" aria-hidden="true">
    <div class="delete-modal" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">
        <button type="button" class="delete-modal-close" onclick="closeDeleteModal()" aria-label="Tutup">
            <i class="fas fa-xmark"></i>
        </button>

        <div class="delete-modal-icon">
            <i class="fas fa-trash-can"></i>
        </div>

        <div class="delete-modal-content">
            <p class="delete-modal-eyebrow">Konfirmasi Penghapusan</p>
            <h2 id="deleteModalTitle">Hapus oleh-oleh ini?</h2>
            <p class="delete-modal-message">
                Kamu akan menghapus
                <strong id="deleteItemName">produk ini</strong>.
                Data yang sudah dihapus tidak dapat dikembalikan.
            </p>
        </div>

        <div class="delete-modal-actions">
            <button type="button" class="delete-cancel" onclick="closeDeleteModal()">
                Batal
            </button>
            <button type="button" class="delete-confirm" id="confirmDeleteButton">
                <i class="fas fa-trash-can"></i>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>




<script>
(function () {
    let activeDeleteForm = null;

    function getDeleteModalElements() {
        return {
            modal: document.getElementById('deleteModal'),
            itemName: document.getElementById('deleteItemName'),
            confirmButton: document.getElementById('confirmDeleteButton')
        };
    }

    window.openDeleteModal = function (id, name) {
        const elements = getDeleteModalElements();
        const deleteButton = document.getElementById('deleteForm' + id);

        if (!elements.modal || !deleteButton) {
            return;
        }

        activeDeleteForm = deleteButton.closest('form');

        if (elements.itemName) {
            elements.itemName.textContent = name || 'produk ini';
        }

        elements.modal.classList.add('show');
        elements.modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');

        if (elements.confirmButton) {
            elements.confirmButton.focus();
        }
    };

    window.closeDeleteModal = function () {
        const elements = getDeleteModalElements();

        if (!elements.modal) {
            return;
        }

        elements.modal.classList.remove('show');
        elements.modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');

        activeDeleteForm = null;
    };

    document.addEventListener('DOMContentLoaded', function () {
        const elements = getDeleteModalElements();

        if (!elements.modal) {
            return;
        }

        elements.confirmButton?.addEventListener('click', function () {
            if (activeDeleteForm) {
                if (typeof activeDeleteForm.requestSubmit === 'function') {
                    activeDeleteForm.requestSubmit();
                } else {
                    activeDeleteForm.submit();
                }
            }
        });

        elements.modal.addEventListener('click', function (event) {
            if (event.target === elements.modal) {
                window.closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (
                event.key === 'Escape' &&
                elements.modal.classList.contains('show')
            ) {
                window.closeDeleteModal();
            }
        });
    });
})();
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchOlehOleh');
    const clearSearch = document.getElementById('clearSearch');
    const filterJenis = document.getElementById('filterJenis');
    const perPageSelect = document.getElementById('perPage');

    const paginationInfo = document.getElementById('paginationInfo');
    const pagination = document.getElementById('pagination');
    const pageNumbers = document.getElementById('pageNumbers');
    const prevPage = document.getElementById('prevPage');
    const nextPage = document.getElementById('nextPage');

    const rows = Array.from(document.querySelectorAll('.souvenir-row'));

    let currentPage = 1;
    let perPage = Number(perPageSelect?.value || 10);
    let filteredRows = [...rows];

    function updateClearButton() {
        if (!clearSearch) return;
        clearSearch.style.display =
            searchInput && searchInput.value.trim()
                ? 'flex'
                : 'none';
    }

    function filterData() {
        const keyword = (searchInput?.value || '').trim().toLowerCase();
        const jenis = (filterJenis?.value || 'all').trim().toLowerCase();

        filteredRows = rows.filter(row => {
            const nama = (row.dataset.nama || '').toLowerCase();
            const kategori = (row.dataset.jenis || '').toLowerCase();

            return nama.includes(keyword) &&
                (jenis === 'all' || kategori === jenis);
        });

        currentPage = 1;
        updateClearButton();
        renderTable();
    }

    function renderTable() {
        const total = filteredRows.length;
        const totalPages = Math.ceil(total / perPage);

        rows.forEach(row => {
            row.style.display = 'none';
        });

        if (total === 0) {
            paginationInfo.textContent = 'Tidak ada data yang sesuai';
            pagination.style.display = 'none';
            pageNumbers.innerHTML = '';
            prevPage.disabled = true;
            nextPage.disabled = true;
            return;
        }

        if (currentPage > totalPages) {
            currentPage = totalPages;
        }

        const start = (currentPage - 1) * perPage;
        const end = Math.min(start + perPage, total);

        filteredRows.slice(start, end).forEach(row => {
            row.style.display = '';
        });

        paginationInfo.textContent =
            `Menampilkan ${start + 1}–${end} dari ${total} data`;

        pagination.style.display =
            totalPages > 1 ? 'flex' : 'none';

        prevPage.disabled = currentPage === 1;
        nextPage.disabled = currentPage === totalPages;

        renderPageNumbers(totalPages);
    }

    function renderPageNumbers(totalPages) {
        pageNumbers.innerHTML = '';

        const maxVisible = 5;

        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);

        if (endPage - startPage + 1 < maxVisible) {
            startPage = Math.max(1, endPage - maxVisible + 1);
        }

        if (startPage > 1) {
            addPageButton(1);
            if (startPage > 2) addEllipsis();
        }

        for (let page = startPage; page <= endPage; page++) {
            addPageButton(page);
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) addEllipsis();
            addPageButton(totalPages);
        }
    }

    function addPageButton(page) {
        const button = document.createElement('button');

        button.type = 'button';
        button.className = 'pagination-button';
        button.textContent = page;
        button.setAttribute('aria-label', `Halaman ${page}`);

        if (page === currentPage) {
            button.classList.add('active');
            button.setAttribute('aria-current', 'page');
        }

        button.addEventListener('click', () => {
            currentPage = page;
            renderTable();
            scrollToTable();
        });

        pageNumbers.appendChild(button);
    }

    function addEllipsis() {
        const span = document.createElement('span');
        span.className = 'pagination-dots';
        span.textContent = '…';
        pageNumbers.appendChild(span);
    }

    function scrollToTable() {
        const table = document.querySelector('.table-scroll');
        if (!table) return;

        const top = table.getBoundingClientRect().top + window.scrollY - 110;

        window.scrollTo({
            top: Math.max(0, top),
            behavior: 'smooth'
        });
    }

    searchInput?.addEventListener('input', filterData);
    filterJenis?.addEventListener('change', filterData);

    clearSearch?.addEventListener('click', () => {
        if (!searchInput) return;
        searchInput.value = '';
        filterData();
        searchInput.focus();
    });

    perPageSelect?.addEventListener('change', () => {
        perPage = Math.max(1, Number(perPageSelect.value || 10) || 10);
        currentPage = 1;
        renderTable();
    });

    prevPage?.addEventListener('click', () => {
        if (currentPage <= 1) return;
        currentPage--;
        renderTable();
        scrollToTable();
    });

    nextPage?.addEventListener('click', () => {
        const totalPages = Math.ceil(filteredRows.length / perPage);
        if (currentPage >= totalPages) return;
        currentPage++;
        renderTable();
        scrollToTable();
    });

    renderTable();
    updateClearButton();
});
</script>

</body>
</html>