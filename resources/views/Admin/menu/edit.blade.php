

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Menu | Admin</title>


    

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
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

            --border-soft:rgba(255,255,255,.07);
            --border-gold:rgba(226,201,151,.18);

            --white:#ffffff;
            --black:#000000;

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
            font-family:'Inter',sans-serif;
            background:
                radial-gradient(circle at 88% 4%,rgba(226,201,151,.055),transparent 30%),
                radial-gradient(circle at 4% 96%,rgba(226,201,151,.025),transparent 28%),
                var(--bg-primary);
            color:var(--text-primary);
            overflow-x:hidden;
            line-height:1.65;
        }

        a{
            color:inherit;
            text-decoration:none;
        }

        button,
        input,
        textarea,
        select{
            font:inherit;
        }

        button,
        a,
        input,
        textarea,
        select{
            -webkit-tap-highlight-color:transparent;
        }

        ::selection{
            background:rgba(226,201,151,.25);
            color:var(--text-primary);
        }

        .page-wrapper{
            min-height:100vh;
            width:100%;
        }

        .main-content{
            width:calc(100% - var(--sidebar-width));
            min-height:100vh;
            margin-left:var(--sidebar-width);
            padding:48px 46px 64px;
        }

        .page-header{
            width:100%;
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:28px;
            margin-bottom:30px;
        }

        .page-title-wrapper{
            min-width:0;
        }

        .page-title{
            margin:0;
            color:var(--text-primary);
            font-family:'Playfair Display','Inter',serif;
            font-size:42px;
            font-weight:700;
            line-height:1.12;
            letter-spacing:-.7px;
        }

        .page-description{
            max-width:760px;
            margin-top:11px;
            color:var(--text-muted);
            font-size:15px;
            line-height:1.75;
        }

        .back-button{
            min-height:48px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:9px;
            padding:0 20px;
            border:1px solid var(--border-gold);
            border-radius:var(--radius-full);
            background:rgba(226,201,151,.055);
            color:var(--text-secondary);
            font-size:14px;
            font-weight:700;
            white-space:nowrap;
            transition:all var(--transition);
        }

        .back-button:hover{
            border-color:rgba(226,201,151,.45);
            background:rgba(226,201,151,.11);
            color:var(--accent);
            transform:translateY(-2px);
            box-shadow:var(--shadow-soft);
        }

        .back-icon{
            font-size:16px;
            line-height:1;
        }

        .alert{
            width:100%;
            margin:0 auto 22px;
            padding:16px 18px;
            border:1px solid rgba(239,110,110,.24);
            border-radius:var(--radius-md);
            background:rgba(239,110,110,.075);
            color:#ffd2d2;
            font-size:14px;
            line-height:1.65;
            box-shadow:0 12px 35px rgba(0,0,0,.18);
        }

        .alert strong{
            color:#ffe4e4;
        }

        .alert ul{
            margin:7px 0 0 20px;
        }

        .alert li{
            margin-bottom:3px;
        }

        .form-card{
            width:100%;
            overflow:hidden;
            border:1px solid var(--border-soft);
            border-radius:var(--radius-lg);
            background:
                linear-gradient(145deg,rgba(255,255,255,.035),rgba(255,255,255,.012)),
                var(--bg-card);
            box-shadow:var(--shadow-soft);
        }

        .form-card-header{
            padding:28px 30px;
            border-bottom:1px solid var(--border-soft);
            background:rgba(255,255,255,.012);
        }

        .form-card-title{
            color:var(--text-primary);
            font-size:19px;
            font-weight:700;
        }

        .form-card-subtitle{
            margin-top:6px;
            color:var(--text-muted);
            font-size:14px;
            line-height:1.65;
        }

        .form-card-body{
            padding:34px 30px;
        }

        .form-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:28px 24px;
        }

        .form-group{
            min-width:0;
        }

        .form-group.full{
            grid-column:1/-1;
        }

        .description-image-group{
            align-self:stretch;
        }

        .description-image-group .textarea{
            min-height:235px;
        }

        .form-label{
            display:block;
            margin-bottom:9px;
            color:var(--text-secondary);
            font-size:14px;
            font-weight:700;
        }

        .required{
            margin-left:2px;
            color:var(--accent);
        }

        .optional{
            margin-left:6px;
            color:var(--text-dim);
            font-size:12px;
            font-weight:400;
        }

        .input,
        .select,
        .textarea{
            width:100%;
            border:1px solid var(--border-soft);
            border-radius:var(--radius-sm);
            outline:none;
            background:rgba(255,255,255,.035);
            color:var(--text-primary);
            font-size:15px;
            transition:all var(--transition);
        }

        .input,
        .select{
            height:54px;
            padding:0 16px;
        }

        .textarea{
            min-height:155px;
            padding:14px 16px;
            resize:vertical;
            line-height:1.75;
        }

        .input::placeholder,
        .textarea::placeholder{
            color:var(--text-dim);
        }

        .input:hover,
        .select:hover,
        .textarea:hover{
            border-color:rgba(226,201,151,.24);
            background:rgba(255,255,255,.045);
        }

        .input:focus,
        .select:focus,
        .textarea:focus{
            border-color:rgba(226,201,151,.58);
            background:rgba(226,201,151,.045);
            box-shadow:0 0 0 3px rgba(226,201,151,.075);
        }

        .select-wrapper,
        .price-wrapper{
            position:relative;
        }

        .select{
            appearance:none;
            padding-right:46px;
            cursor:pointer;
        }

        .select option{
            background:#171717;
            color:var(--text-primary);
        }

        .select-arrow{
            position:absolute;
            right:16px;
            top:50%;
            transform:translateY(-50%);
            color:var(--text-muted);
            font-size:14px;
            pointer-events:none;
        }

        .price-prefix{
            position:absolute;
            left:16px;
            top:50%;
            z-index:2;
            transform:translateY(-50%);
            color:var(--accent);
            font-size:14px;
            font-weight:700;
            pointer-events:none;
        }

        .price-input{
            padding-left:45px;
        }

        .field-help{
            margin-top:8px;
            color:var(--text-dim);
            font-size:12px;
            line-height:1.6;
        }

        .status-options{
            display:flex;
            gap:11px;
            flex-wrap:wrap;
        }

        .status-option{
            position:relative;
        }

        .status-option input{
            position:absolute;
            opacity:0;
            pointer-events:none;
        }

        .status-label{
            min-width:138px;
            height:50px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:9px;
            padding:0 18px;
            border:1px solid var(--border-soft);
            border-radius:var(--radius-full);
            background:rgba(255,255,255,.035);
            color:var(--text-muted);
            font-size:14px;
            font-weight:700;
            cursor:pointer;
            transition:all var(--transition);
        }

        .status-label:hover{
            border-color:var(--border-gold);
            background:rgba(226,201,151,.055);
            color:var(--text-secondary);
        }

        .status-dot{
            width:8px;
            height:8px;
            flex:0 0 8px;
            border-radius:50%;
            background:#777;
            transition:all var(--transition);
        }

        .status-option input:checked + .status-label{
            border-color:rgba(226,201,151,.58);
            background:rgba(226,201,151,.10);
            color:var(--accent);
            box-shadow:0 8px 24px rgba(0,0,0,.18);
        }

        .status-option input:checked + .status-label .status-dot{
            background:var(--accent);
            box-shadow:0 0 9px rgba(226,201,151,.45);
        }

        .current-image-wrapper{
            margin-bottom:14px;
            padding:14px;
            border:1px solid var(--border-gold);
            border-radius:var(--radius-md);
            background:rgba(226,201,151,.035);
        }

        .current-image-label{
            margin-bottom:9px;
            color:var(--text-muted);
            font-size:12px;
            font-weight:600;
        }

        .current-image{
            width:100%;
            height:165px;
            object-fit:cover;
            display:block;
            border-radius:12px;
            border:1px solid var(--border-soft);
            background:var(--bg-soft);
        }

        .image-upload{
            position:relative;
            width:100%;
            min-height:235px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1.5px dashed rgba(226,201,151,.26);
            border-radius:var(--radius-md);
            background:
                linear-gradient(145deg,rgba(226,201,151,.045),rgba(255,255,255,.018));
            cursor:pointer;
            transition:all var(--transition);
        }

        .image-upload:hover{
            border-color:rgba(226,201,151,.58);
            background:rgba(226,201,151,.065);
            transform:translateY(-1px);
        }

        .image-upload.dragover{
            border-color:var(--accent);
            background:rgba(226,201,151,.09);
            box-shadow:0 0 0 4px rgba(226,201,151,.055);
        }

        .image-upload-content{
            padding:25px;
            text-align:center;
        }

        .upload-icon{
            width:56px;
            height:56px;
            margin:0 auto 14px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid var(--border-gold);
            border-radius:16px;
            background:rgba(226,201,151,.08);
            color:var(--accent);
            font-size:24px;
        }

        .upload-icon i{
            line-height:1;
        }

        .upload-title{
            color:var(--text-primary);
            font-size:15px;
            font-weight:700;
        }

        .upload-description{
            margin-top:7px;
            color:var(--text-muted);
            font-size:13px;
            line-height:1.7;
        }

        .image-input{
            display:none;
        }

        .image-preview-wrapper{
            display:none;
            position:relative;
            width:100%;
            min-height:235px;
            overflow:hidden;
            border:1px solid var(--border-gold);
            border-radius:var(--radius-md);
            background:var(--bg-soft);
        }

        .image-preview-wrapper.show{
            display:block;
        }

        .image-preview{
            display:block;
            width:100%;
            height:235px;
            object-fit:cover;
        }

        .remove-image{
            position:absolute;
            top:13px;
            right:13px;
            width:42px;
            height:42px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(255,255,255,.15);
            border-radius:50%;
            background:rgba(0,0,0,.74);
            color:#fff;
            cursor:pointer;
            font-size:17px;
            transition:all var(--transition);
        }

        .remove-image:hover{
            background:#000;
            color:var(--accent);
            transform:scale(1.05);
        }

        .remove-image i{
            line-height:1;
        }

        .error-message{
            margin-top:8px;
            color:#ffaaaa;
            font-size:12px;
            line-height:1.55;
        }

        .input-error{
            border-color:rgba(239,110,110,.68)!important;
        }

        .input-error:focus{
            box-shadow:0 0 0 3px rgba(239,110,110,.09)!important;
        }

        .form-card-footer{
            padding:22px 30px;
            border-top:1px solid var(--border-soft);
            background:rgba(255,255,255,.018);
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:18px;
        }

        .footer-note{
            color:var(--text-dim);
            font-size:12px;
        }

        .form-actions{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .button{
            min-height:50px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:0 21px;
            border-radius:var(--radius-full);
            font-size:14px;
            font-weight:700;
            cursor:pointer;
            transition:all var(--transition);
        }

        .button-secondary{
            border:1px solid var(--border-soft);
            background:rgba(255,255,255,.035);
            color:var(--text-secondary);
        }

        .button-secondary:hover{
            border-color:var(--border-gold);
            background:rgba(226,201,151,.07);
            color:var(--accent);
            transform:translateY(-2px);
        }

        .button-primary{
            border:1px solid var(--accent);
            background:linear-gradient(135deg,var(--accent),var(--accent-hover));
            color:var(--bg-primary);
            box-shadow:0 10px 28px rgba(0,0,0,.22);
        }

        .button-primary:hover{
            background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark));
            transform:translateY(-3px);
            box-shadow:var(--shadow-hover);
        }

        .button-primary:active,
        .button-secondary:active{
            transform:translateY(-1px);
        }

        .admin-mobile-menu-button{
            display:none;
            position:fixed;
            top:18px;
            left:18px;
            z-index:1200;
            width:52px;
            height:52px;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            gap:5px;
            padding:0;
            border:1px solid rgba(226,201,151,.27);
            border-radius:14px;
            background:rgba(18,18,18,.96);
            color:var(--accent);
            box-shadow:0 14px 35px rgba(0,0,0,.40);
            backdrop-filter:blur(16px);
            cursor:pointer;
            transition:all var(--transition);
        }

        .admin-mobile-menu-button span{
            display:block;
            width:24px;
            height:2px;
            border-radius:999px;
            background:var(--accent);
        }

        .admin-mobile-menu-button:hover{
            border-color:rgba(226,201,151,.48);
            background:rgba(226,201,151,.09);
            transform:translateY(-1px);
        }

        :focus-visible{
            outline:2px solid rgba(226,201,151,.78);
            outline-offset:3px;
        }

        @media (min-width:1400px){
            .main-content{
                margin-left:285px;
                width:calc(100% - 285px);
                padding:54px 58px 72px;
            }

            .page-title{
                font-size:46px;
            }

            .form-card-body{
                padding:38px 34px;
            }
        }

        @media (min-width:1101px) and (max-width:1399px){
            .main-content{
                padding:46px 40px 62px;
            }

            .page-title{
                font-size:40px;
            }
        }

        @media (min-width:901px) and (max-width:1100px){
            .main-content{
                margin-left:255px;
                width:calc(100% - 255px);
                padding:40px 28px 54px;
            }

            .page-title{
                font-size:36px;
            }

            .form-card-body{
                padding:30px 25px;
            }

            .form-card-header,
            .form-card-footer{
                padding-left:25px;
                padding-right:25px;
            }
        }

        @media (max-width:900px){
            .admin-mobile-menu-button{
                display:flex;
            }

            .main-content{
                width:100%;
                margin-left:0;
                padding:90px 26px 48px;
            }

            .page-header{
                align-items:flex-start;
                flex-direction:column;
                gap:12px;
                margin-bottom:26px;
            }

            .page-title{
                font-size:36px;
            }

            .page-description{
                font-size:14px;
            }

            .back-button{
                width:auto;
            }

            .form-grid{
                grid-template-columns:1fr;
                gap:24px;
            }

            .form-group.full{
                grid-column:auto;
            }

            .description-image-group .textarea{
                min-height:190px;
            }

            .description-image-group .image-upload,
            .description-image-group .image-preview-wrapper{
                min-height:215px;
            }
        }

        @media (max-width:600px){
            .admin-mobile-menu-button{
                top:14px;
                left:14px;
                width:48px;
                height:48px;
            }

            .main-content{
                padding:78px 15px 36px;
            }

            .page-title{
                font-size:30px;
                letter-spacing:-.4px;
            }

            .page-description{
                margin-top:8px;
                font-size:14px;
                line-height:1.7;
            }

            .back-button{
                width:100%;
                min-height:50px;
            }

            .alert{
                padding:14px;
                font-size:13px;
            }

            .form-card{
                border-radius:20px;
            }

            .form-card-header{
                padding:23px 19px;
            }

            .form-card-title{
                font-size:18px;
            }

            .form-card-subtitle{
                font-size:13px;
            }

            .form-card-body{
                padding:26px 19px;
            }

            .form-label{
                font-size:14px;
            }

            .input,
            .select{
                height:54px;
                font-size:15px;
            }

            .textarea{
                min-height:145px;
                font-size:15px;
            }

            .status-options{
                flex-direction:column;
            }

            .status-label{
                width:100%;
                min-width:0;
                height:52px;
            }

            .current-image{
                height:210px;
            }

            .image-upload{
                min-height:200px;
            }

            .image-preview{
                height:220px;
            }

            .form-card-footer{
                padding:20px 19px;
                align-items:stretch;
                flex-direction:column;
            }

            .footer-note{
                font-size:12px;
            }

            .form-actions{
                width:100%;
            }

            .form-actions .button{
                flex:1;
                min-height:52px;
            }
        }

        @media (max-width:380px){
            .main-content{
                padding-left:12px;
                padding-right:12px;
            }

            .page-title{
                font-size:27px;
            }

            .page-description{
                font-size:13px;
            }

            .form-card-body{
                padding:23px 16px;
            }

            .form-card-header,
            .form-card-footer{
                padding-left:16px;
                padding-right:16px;
            }

            .form-actions{
                flex-direction:column;
            }

            .form-actions .button{
                width:100%;
            }
        }

        @media (prefers-reduced-motion:reduce){
            *,
            *::before,
            *::after{
                scroll-behavior:auto!important;
                transition:none!important;
                animation:none!important;
            }
        }
    
        /* Typography alignment: disamakan dengan halaman Tambah Tiket Wahana */
        .page-title{
            margin:0 0 12px;
            font-family:'Playfair Display','Inter',serif;
            font-size:clamp(38px,4vw,58px);
            line-height:1.08;
            font-weight:700;
            letter-spacing:-1.4px;
            background:linear-gradient(135deg,#fff 0%,var(--accent) 68%,var(--accent-dark) 100%);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            background-clip:text;
        }

        .page-description{
            max-width:760px;
            margin:0;
            color:var(--text-muted);
            font-size:16px;
            line-height:1.75;
        }

        .back-button{
            min-height:56px;
            padding:0 22px;
            border-radius:14px;
            font-size:15px;
            font-weight:800;
        }

        .form-card-title{
            font-size:20px;
            font-weight:800;
            line-height:1.3;
        }

        .form-card-subtitle{
            margin-top:3px;
            font-size:14px;
            line-height:1.65;
        }

        .form-label{
            margin-bottom:10px;
            font-size:15px;
            font-weight:700;
            line-height:1.4;
        }

        .optional{
            font-size:12px;
        }

        .input,
        .select,
        .textarea{
            font-size:15px;
            border-radius:14px;
        }

        .input,
        .select{
            height:58px;
            padding:0 16px;
        }

        .textarea{
            min-height:155px;
            padding:17px 18px;
            font-size:15px;
            line-height:1.7;
        }

        .select-arrow{
            right:18px;
            font-size:14px;
        }

        .price-prefix{
            font-size:15px;
            font-weight:700;
        }

        .field-help{
            font-size:12px;
            line-height:1.6;
        }

        .status-label{
            height:56px;
            min-width:145px;
            padding:0 18px;
            border-radius:14px;
            font-size:15px;
            font-weight:700;
        }

        .current-image-label{
            font-size:12px;
            font-weight:800;
        }

        .upload-title{
            font-size:16px;
            font-weight:800;
            line-height:1.4;
        }

        .upload-description{
            font-size:14px;
            line-height:1.65;
        }

        .error-message{
            font-size:12px;
            line-height:1.55;
        }

        .footer-note{
            font-size:12px;
        }

        .button{
            min-height:56px;
            padding:0 22px;
            border-radius:14px;
            font-size:15px;
            font-weight:800;
        }

        @media (min-width:1400px){
            .page-title{font-size:58px;}
        }

        @media (min-width:1101px) and (max-width:1399px){
            .page-title{font-size:52px;}
        }

        @media (min-width:901px) and (max-width:1100px){
            .page-title{font-size:44px;}
        }

        @media (max-width:900px){
            .page-title{
                font-size:38px;
                letter-spacing:-.8px;
            }

            .page-description{
                font-size:15px;
            }

            .form-card-title{
                font-size:20px;
            }

            .form-label{
                font-size:15px;
            }

            .input,
            .select{
                height:56px;
                font-size:15px;
            }

            .button{
                min-height:56px;
                font-size:15px;
            }
        }

        @media (max-width:600px){
            .page-title{
                font-size:32px;
                letter-spacing:-.8px;
            }

            .page-description{
                font-size:14px;
            }

            .form-card-title{
                font-size:20px;
            }

            .form-card-subtitle{
                font-size:14px;
            }

            .form-label{
                font-size:15px;
            }

            .input,
            .select{
                height:56px;
                font-size:15px;
            }

            .textarea{
                min-height:145px;
                font-size:15px;
            }

            .status-label{
                height:56px;
                font-size:15px;
            }

            .upload-title{
                font-size:16px;
            }

            .upload-description{
                font-size:13px;
            }

            .button{
                min-height:56px;
                font-size:15px;
            }
        }

        @media (max-width:380px){
            .page-title{
                font-size:32px;
            }

            .page-description{
                font-size:14px;
            }

            .form-card-title{
                font-size:20px;
            }

            .form-label{
                font-size:15px;
            }

            .input,
            .select,
            .textarea{
                font-size:15px;
            }
        }

</style>



<style id="noyo-gimbal-sidebar-reference-final">
/* =========================================================
   NOYO GIMBAL SIDEBAR — FLOATING GLASS
   Tampilan mengikuti screenshot referensi
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
       BRAND HEADER
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
       CLOSE BUTTON
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

    /* Active menu */
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

    /* Hilangkan hamburger ketika drawer terbuka */
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
   HP SANGAT KECIL
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

<div class="page-wrapper">


    

    @include('admin.partials.sidebar')


    

    <main class="main-content">


        

        <div class="page-header">

            <div class="page-title-wrapper">

                <h1 class="page-title">
                    Edit Menu
                </h1>

                <p class="page-description">
                    Perbarui informasi menu yang sudah tersimpan pada sistem.
                </p>

            </div>

        </div>


        

        @if ($errors->any())

            <div class="alert alert-error">

                <strong>
                    Terdapat beberapa kesalahan:
                </strong>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        

        <form
            action="{{ route('admin.menu.update', $menu->id_menu) }}"
            method="POST"
            enctype="multipart/form-data"
            class="form-card"
            id="menuForm"
        >

            @csrf

            @method('PUT')


            

            <div class="form-card-header">

                <h2 class="form-card-title">
                    Informasi Menu
                </h2>

                <p class="form-card-subtitle">
                    Ubah informasi menu sesuai data terbaru.
                </p>

            </div>


            

            <div class="form-card-body">

                <div class="form-grid">


                    

                    <div class="form-group">

                        <label
                            for="nama_menu"
                            class="form-label"
                        >

                            Nama Menu

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="nama_menu"
                            name="nama_menu"
                            class="input @error('nama_menu') input-error @enderror"
                            value="{{ old('nama_menu', $menu->nama_menu) }}"
                            placeholder="Contoh: Nasi Goreng Spesial"
                            maxlength="255"
                            required
                        >


                        @error('nama_menu')

                            <div class="error-message">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    

                    <div class="form-group">

                        <label
                            for="kategori"
                            class="form-label"
                        >

                            Kategori

                            <span class="required">
                                *
                            </span>

                        </label>


                        <div class="select-wrapper">

                            <select
                                id="kategori"
                                name="kategori"
                                class="select @error('kategori') input-error @enderror"
                                required
                            >

                                <option value="">
                                    Pilih kategori
                                </option>


                                <option
                                    value="Paket Kenyang"
                                    {{ old('kategori', $menu->kategori) === 'Paket Kenyang' ? 'selected' : '' }}
                                >
                                    Paket Kenyang
                                </option>


                                <option
                                    value="Minuman"
                                    {{ old('kategori', $menu->kategori) === 'Minuman' ? 'selected' : '' }}
                                >
                                    Minuman
                                </option>


                                <option
                                    value="Sambal"
                                    {{ old('kategori', $menu->kategori) === 'Sambal' ? 'selected' : '' }}
                                >
                                    Sambal
                                </option>


                                <option
                                    value="Lainnya"
                                    {{ old('kategori', $menu->kategori) === 'Lainnya' ? 'selected' : '' }}
                                >
                                    Lainnya
                                </option>

                            </select>


                            <span class="select-arrow">
                                ▾
                            </span>

                        </div>


                        @error('kategori')

                            <div class="error-message">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    

                    <div class="form-group">

                        <label
                            for="harga"
                            class="form-label"
                        >

                            Harga

                            <span class="required">
                                *
                            </span>

                        </label>


                        <div class="price-wrapper">

                            <span class="price-prefix">
                                Rp
                            </span>


                            <input
                                type="text"
                                id="harga"
                                name="harga"
                                class="input price-input @error('harga') input-error @enderror"
                                value="{{ old('harga', number_format($menu->harga, 0, ',', '.')) }}"
                                placeholder="3.000"
                                inputmode="numeric"
                                autocomplete="off"
                                maxlength="9"
                                required
                            >

                        </div>


                        <div class="field-help">
                            Masukkan harga minimal Rp3.000 dan maksimal Rp1.000.000.
                        </div>


                        @error('harga')

                            <div class="error-message">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    

                    <div class="form-group">

                        <label class="form-label">

                            Status

                            <span class="required">
                                *
                            </span>

                        </label>


                        <div class="status-options">


                            

                            <div class="status-option">

                                <input
                                    type="radio"
                                    id="status_tersedia"
                                    name="status"
                                    value="Tersedia"

                                    {{
                                        old(
                                            'status',
                                            $menu->status
                                        ) === 'Tersedia'
                                            ? 'checked'
                                            : ''
                                    }}
                                >


                                <label
                                    for="status_tersedia"
                                    class="status-label"
                                >

                                    <span class="status-dot"></span>

                                    Tersedia

                                </label>

                            </div>


                            

                            <div class="status-option">

                                <input
                                    type="radio"
                                    id="status_habis"
                                    name="status"
                                    value="Habis"

                                    {{
                                        old(
                                            'status',
                                            $menu->status
                                        ) === 'Habis'
                                            ? 'checked'
                                            : ''
                                    }}
                                >


                                <label
                                    for="status_habis"
                                    class="status-label"
                                >

                                    <span class="status-dot"></span>

                                    Habis

                                </label>

                            </div>

                        </div>


                        @error('status')

                            <div class="error-message">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    

                    <div class="form-group description-image-group">

                        <label
                            for="deskripsi"
                            class="form-label"
                        >

                            Deskripsi

                            <span class="optional">
                                Opsional
                            </span>

                        </label>


                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            class="textarea @error('deskripsi') input-error @enderror"
                            placeholder="Tuliskan deskripsi singkat mengenai menu..."
                        >{{ old('deskripsi', $menu->deskripsi) }}</textarea>


                        @error('deskripsi')

                            <div class="error-message">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    

                    <div class="form-group description-image-group">

                        <label class="form-label">

                            Gambar Menu

                            <span class="optional">
                                Opsional
                            </span>

                        </label>


                        

                        @if ($menu->gambar)

                            <div class="current-image-wrapper">

                                <div class="current-image-label">
                                    Gambar saat ini
                                </div>


                                <img
                                    src="{{ asset('storage/' . ltrim($menu->gambar, '/')) }}"
                                    alt="{{ $menu->nama_menu }}"
                                    class="current-image"
                                    id="currentImage"
                                >

                            </div>

                        @endif


                        

                        <label
                            for="gambar"
                            class="image-upload"
                            id="imageUpload"
                        >

                            <div
                                class="image-upload-content"
                                id="uploadContent"
                            >

                                <div class="upload-icon">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                </div>


                                <div class="upload-title">
                                    Ganti gambar menu
                                </div>


                                <div class="upload-description">

                                    Klik untuk memilih gambar
                                    atau drag & drop di sini

                                    <br>

                                    JPG, JPEG, PNG atau WEBP

                                </div>

                            </div>


                            <input
                                type="file"
                                id="gambar"
                                name="gambar"
                                class="image-input"
                                accept="image/jpeg,image/png,image/webp"
                            >

                        </label>


                        

                        <div
                            class="image-preview-wrapper"
                            id="imagePreviewWrapper"
                        >

                            <img
                                src=""
                                alt="Preview gambar menu"
                                class="image-preview"
                                id="imagePreview"
                            >


                            <button
                                type="button"
                                class="remove-image"
                                id="removeImage"
                                title="Batalkan gambar baru"
                                aria-label="Batalkan gambar baru"
                            >
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </button>

                        </div>


                        @error('gambar')

                            <div class="error-message">
                                {{ $message }}
                            </div>

                        @enderror


                        <div class="field-help">

                            Kosongkan jika tidak ingin mengganti gambar.
                            Maksimal ukuran gambar 5 MB.

                        </div>

                    </div>

                </div>

            </div>


            

            <div class="form-card-footer">


                <div class="footer-note">

                    <span class="required">
                        *
                    </span>

                    Wajib diisi

                </div>


                <div class="form-actions">


                    <a
                        href="{{ route('admin.menu.index') }}"
                        class="button button-secondary"
                    >

                        Batal

                    </a>


                    <button
                        type="submit"
                        class="button button-primary"
                    >

                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </form>

    </main>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButton = document.getElementById('openAdminSidebar');
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (!menuButton) {
            return;
        }

        menuButton.addEventListener('click', function () {
            if (typeof window.openAdminSidebar === 'function') {
                window.openAdminSidebar();
                return;
            }

            if (sidebar) {
                sidebar.classList.add('open');
            }

            if (overlay) {
                overlay.classList.add('show');
            }

            document.body.classList.add('sidebar-open');
            menuButton.setAttribute('aria-expanded', 'true');
        });
    });
</script>

<script>

    

    const menuForm =
        document.getElementById('menuForm');

    const hargaInput =
        document.getElementById('harga');

    const imageInput =
        document.getElementById('gambar');

    const imageUpload =
        document.getElementById('imageUpload');

    const imagePreviewWrapper =
        document.getElementById('imagePreviewWrapper');

    const imagePreview =
        document.getElementById('imagePreview');

    const removeImage =
        document.getElementById('removeImage');


    

    function formatRupiah(value) {

        let number =
            value
                .toString()
                .replace(/\D/g, '');


        if (!number) {
            return '';
        }


        return number.replace(
            /\B(?=(\d{3})+(?!\d))/g,
            '.'
        );
    }


    

    function getNumericPrice(value) {

        return value
            .toString()
            .replace(/\D/g, '');
    }


    

    if (hargaInput) {

        hargaInput.value =
            formatRupiah(hargaInput.value);

    }


    

    hargaInput.addEventListener(
        'input',
        function () {

            let numericValue =
                getNumericPrice(this.value);


            

            if (
                numericValue &&
                Number(numericValue) > 1000000
            ) {

                numericValue = '1000000';

            }


            this.value =
                formatRupiah(numericValue);

        }
    );


    

    hargaInput.addEventListener(
        'blur',
        function () {

            const numericValue =
                Number(
                    getNumericPrice(this.value)
                );


            if (!numericValue) {
                return;
            }


            if (numericValue < 3000) {

                this.setCustomValidity(
                    'Harga minimal Rp3.000.'
                );

                return;
            }


            if (numericValue > 1000000) {

                this.setCustomValidity(
                    'Harga maksimal Rp1.000.000.'
                );

                return;
            }


            this.setCustomValidity('');

        }
    );


    hargaInput.addEventListener(
        'input',
        function () {

            this.setCustomValidity('');

        }
    );


    

    menuForm.addEventListener(
        'submit',
        function () {

            const numericValue =
                getNumericPrice(
                    hargaInput.value
                );


            if (
                !numericValue ||
                Number(numericValue) < 3000 ||
                Number(numericValue) > 1000000
            ) {

                hargaInput.setCustomValidity(
                    'Harga harus antara Rp3.000 dan Rp1.000.000.'
                );

                hargaInput.reportValidity();

                return;
            }


            hargaInput.setCustomValidity('');


            

            hargaInput.value =
                numericValue;

        }
    );


    

    imageInput.addEventListener(
        'change',
        function () {

            const file =
                this.files[0];


            if (!file) {
                return;
            }


            showPreview(file);

        }
    );


    

    function showPreview(file) {


        

        if (!file.type.startsWith('image/')) {

            alert(
                'File yang dipilih harus berupa gambar.'
            );

            imageInput.value = '';

            return;
        }


        

        if (
            file.size >
            5 * 1024 * 1024
        ) {

            alert(
                'Ukuran gambar maksimal 5 MB.'
            );

            imageInput.value = '';

            return;
        }


        

        const reader =
            new FileReader();


        reader.onload =
            function (event) {

                imagePreview.src =
                    event.target.result;


                imageUpload.style.display =
                    'none';


                imagePreviewWrapper.classList.add(
                    'show'
                );

            };


        reader.readAsDataURL(file);

    }


    

    removeImage.addEventListener(
        'click',
        function () {

            imageInput.value = '';

            imagePreview.src = '';

            imagePreviewWrapper.classList.remove(
                'show'
            );

            imageUpload.style.display =
                'flex';

        }
    );


    

    imageUpload.addEventListener(
        'dragover',
        function (event) {

            event.preventDefault();

            imageUpload.classList.add(
                'dragover'
            );

        }
    );


    

    imageUpload.addEventListener(
        'dragleave',
        function () {

            imageUpload.classList.remove(
                'dragover'
            );

        }
    );


    

    imageUpload.addEventListener(
        'drop',
        function (event) {

            event.preventDefault();

            imageUpload.classList.remove(
                'dragover'
            );


            const files =
                event.dataTransfer.files;


            if (!files.length) {
                return;
            }


            const file =
                files[0];


            

            imageInput.files =
                files;


            showPreview(file);

        }
    );

</script>


</body>

</html>