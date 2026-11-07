<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Tiket Wahana — Admin Panel</title>

    {{-- ==========================================================
         FONT
    =========================================================== --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >

    {{-- ==========================================================
         FONT AWESOME
    =========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

    {{-- ==========================================================
         VITE
    =========================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <style>

        /* =========================================================
           ROOT
        ========================================================= */

        :root {

            --bg-primary: #0a0a0a;
            --bg-secondary: #151515;
            --bg-soft: #1a1a1a;
            --bg-card: #121212;

            --text-primary: #f8f4ed;
            --text-secondary: #d4c9b5;
            --text-muted: #a89988;
            --text-dim: #7a6f62;

            --accent: #e2c997;
            --accent-hover: #d4b384;
            --accent-dark: #b89a6e;

            --border-soft: rgba(255,255,255,.06);
            --border-gold: rgba(226,201,151,.15);

            --danger: #ef7676;
            --success: #72d39a;

            --shadow-soft:
                0 20px 60px rgba(0,0,0,.4);

            --shadow-hover:
                0 25px 70px rgba(0,0,0,.5);

            --radius-lg: 28px;
            --radius-md: 16px;
            --radius-full: 999px;

            --transition:
                .25s cubic-bezier(.4,0,.2,1);
        }


        /* =========================================================
           RESET
        ========================================================= */

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {

            min-height: 100vh;

            overflow-x: hidden;

            font-family:
                'Inter',
                sans-serif;

            line-height: 1.65;

            color:
                var(--text-primary);

            background:
                radial-gradient(
                    circle at 85% 5%,
                    rgba(226,201,151,.055),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 10% 85%,
                    rgba(226,201,151,.035),
                    transparent 30%
                ),
                var(--bg-primary);
        }


        a {
            color: inherit;
        }


        button,
        input,
        textarea,
        select {
            font: inherit;
        }


        /* =========================================================
           MAIN
        ========================================================= */

        .admin-main {

            min-height: 100vh;

            margin-left: 290px;

            padding:
                52px 54px 70px;
        }


        /* =========================================================
           PAGE HEADER
        ========================================================= */

        .page-header {

            display: flex;

            flex-direction: column;

            align-items: flex-start;

            margin-bottom: 36px;
        }


        .page-title {

            display: block;

            width: 100%;

            margin:
                0 0 12px;

            font-family:
                'Playfair Display',
                serif;

            font-size:
                clamp(38px, 4vw, 58px);

            line-height:
                1.08;

            font-weight:
                700;

            letter-spacing:
                -1.4px;

            background:
                linear-gradient(
                    135deg,
                    #fff 0%,
                    var(--accent) 68%,
                    var(--accent-dark) 100%
                );

            -webkit-background-clip:
                text;

            -webkit-text-fill-color:
                transparent;

            background-clip:
                text;
        }


        .page-description {

            display: block;

            width: 100%;

            max-width: 720px;

            margin: 0;

            color:
                var(--text-muted);

            font-size:
                16px;

            line-height:
                1.75;
        }


        /* =========================================================
           MOBILE MENU
        ========================================================= */

        .admin-mobile-menu-button {

            display: none;

            position: fixed !important;

            top: 18px !important;

            left: 18px !important;

            right: auto !important;

            z-index: 99999 !important;

            width: 48px;

            height: 48px;

            padding: 0;

            align-items: center;

            justify-content: center;

            flex-direction: column;

            gap: 5px;

            border:
                1px solid
                var(--border-gold);

            border-radius:
                14px;

            background:
                rgba(18,18,18,.96);

            color:
                var(--accent);

            box-shadow:
                0 14px 35px
                rgba(0,0,0,.45);

            backdrop-filter:
                blur(18px);

            cursor:
                pointer;
        }


        .admin-mobile-menu-button span {

            display: block;

            width: 20px;

            height: 2px;

            border-radius: 99px;

            background:
                currentColor;

            transition:
                var(--transition);
        }


        .admin-mobile-menu-button:hover {

            border-color:
                var(--accent);

            background:
                rgba(226,201,151,.10);

            transform:
                translateY(-1px);
        }


        /* =========================================================
           ALERT
        ========================================================= */

        .alert-box {

            display: flex;

            align-items: flex-start;

            gap: 15px;

            margin-bottom: 24px;

            padding:
                18px 20px;

            border:
                1px solid
                var(--border-soft);

            border-radius:
                var(--radius-md);

            background:
                rgba(255,255,255,.025);

            backdrop-filter:
                blur(18px);
        }


        .alert-box.error {

            border-color:
                rgba(239,118,118,.24);

            background:
                rgba(239,118,118,.045);
        }


        .alert-box.success {

            border-color:
                rgba(114,211,154,.24);

            background:
                rgba(114,211,154,.045);
        }


        .alert-icon {

            width: 42px;

            height: 42px;

            flex:
                0 0 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius:
                13px;

            background:
                rgba(255,255,255,.05);

            color:
                var(--accent);

            font-size:
                17px;
        }


        .alert-box.error
        .alert-icon {

            color:
                var(--danger);
        }


        .alert-box.success
        .alert-icon {

            color:
                var(--success);
        }


        .alert-title {

            display: block;

            margin-bottom: 4px;

            font-size: 14px;

            font-weight: 800;
        }


        .alert-content ul {

            margin: 0;

            padding-left: 19px;

            color:
                var(--text-secondary);

            font-size:
                14px;
        }


        .alert-message {

            color:
                var(--text-secondary);

            font-size:
                14px;
        }


        /* =========================================================
           CONTENT
        ========================================================= */

        .content-grid {

            display: grid;

            grid-template-columns:
                minmax(0, 1fr);

            gap:
                30px;

            align-items:
                start;
        }


        /* =========================================================
           CARD
        ========================================================= */

        .card {

            border:
                1px solid
                var(--border-soft);

            border-radius:
                var(--radius-lg);

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.035),
                    rgba(255,255,255,.012)
                );

            box-shadow:
                var(--shadow-soft);

            backdrop-filter:
                blur(22px);
        }


        .form-card {

            padding:
                34px;
        }


        /* =========================================================
           CARD HEADING
        ========================================================= */

        .card-heading {

            display: flex;

            align-items: center;

            gap:
                14px;

            margin-bottom:
                30px;

            padding-bottom:
                22px;

            border-bottom:
                1px solid
                var(--border-soft);
        }


        .card-heading-icon {

            width:
                46px;

            height:
                46px;

            flex:
                0 0 46px;

            display: flex;

            align-items: center;

            justify-content: center;

            border:
                1px solid
                var(--border-gold);

            border-radius:
                14px;

            background:
                rgba(226,201,151,.08);

            color:
                var(--accent);

            font-size:
                18px;
        }


        .card-heading h2 {

            margin:
                0 0 3px;

            font-size:
                20px;

            font-weight:
                800;
        }


        .card-heading p {

            margin:
                0;

            color:
                var(--text-muted);

            font-size:
                14px;
        }


        /* =========================================================
           TICKET ID
        ========================================================= */

        .ticket-id-badge {

            margin-left:
                auto;

            min-width:
                105px;

            padding:
                9px 13px;

            border:
                1px solid
                var(--border-gold);

            border-radius:
                12px;

            background:
                rgba(226,201,151,.055);

            text-align:
                center;
        }


        .ticket-id-badge span {

            display: block;

            margin-bottom:
                2px;

            color:
                var(--text-muted);

            font-size:
                10px;

            font-weight:
                700;

            letter-spacing:
                1px;

            text-transform:
                uppercase;
        }


        .ticket-id-badge strong {

            color:
                var(--accent);

            font-size:
                14px;

            font-weight:
                800;
        }


        /* =========================================================
           FORM
        ========================================================= */

        .form-group {

            margin-bottom:
                25px;
        }


        .form-label {

            display: flex;

            align-items: center;

            gap:
                5px;

            margin-bottom:
                10px;

            color:
                var(--text-secondary);

            font-size:
                15px;

            font-weight:
                700;
        }


        .required {

            color:
                var(--danger);
        }


        /* =========================================================
           INPUT
        ========================================================= */

        .input-wrap {

            position:
                relative;
        }


        .input-icon {

            position:
                absolute;

            top:
                50%;

            left:
                18px;

            z-index:
                2;

            transform:
                translateY(-50%);

            color:
                var(--accent-dark);

            font-size:
                16px;

            pointer-events:
                none;
        }


        .currency-symbol {

            position:
                absolute;

            top:
                50%;

            left:
                18px;

            z-index:
                2;

            transform:
                translateY(-50%);

            color:
                var(--accent);

            font-size:
                13px;

            font-weight:
                800;

            pointer-events:
                none;
        }


        .form-input,
        .form-select,
        .form-textarea {

            width:
                100%;

            border:
                1px solid
                var(--border-soft);

            outline:
                none;

            color:
                var(--text-primary);

            background:
                rgba(255,255,255,.025);

            transition:
                var(--transition);
        }


        .form-input,
        .form-select {

            height:
                58px;

            padding:
                0 48px;

            border-radius:
                14px;

            font-size:
                15px;
        }


        .form-input::placeholder,
        .form-textarea::placeholder {

            color:
                #68645d;
        }


        .form-input:hover,
        .form-select:hover,
        .form-textarea:hover {

            border-color:
                rgba(255,255,255,.12);
        }


        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {

            border-color:
                var(--accent);

            background:
                rgba(226,201,151,.025);

            box-shadow:
                0 0 0 4px
                rgba(226,201,151,.07);
        }


        .form-select {

            padding-right:
                48px;

            appearance:
                none;

            cursor:
                pointer;
        }


        .form-select option {

            background:
                #171717;

            color:
                #fff;
        }


        .select-arrow {

            position:
                absolute;

            top:
                50%;

            right:
                18px;

            transform:
                translateY(-50%);

            color:
                var(--accent-dark);

            pointer-events:
                none;
        }


        #harga {

            padding-left:
                50px;
        }


        /* =========================================================
           TEXTAREA
        ========================================================= */

        .form-textarea {

            min-height:
                155px;

            padding:
                17px 18px;

            border-radius:
                14px;

            resize:
                vertical;

            font-size:
                15px;

            line-height:
                1.7;
        }


        /* =========================================================
           HELP TEXT
        ========================================================= */

        .field-helper {

            display:
                flex;

            justify-content:
                space-between;

            gap:
                12px;

            margin-top:
                9px;

            color:
                var(--text-muted);

            font-size:
                13px;
        }


        .field-helper i {

            margin-right:
                5px;

            color:
                var(--accent-dark);
        }


        .field-error {

            display:
                block;

            margin-top:
                8px;

            color:
                var(--danger);

            font-size:
                13px;
        }


        /* =========================================================
           IMAGE + KETENTUAN
        ========================================================= */

        .form-two-column {

            display:
                grid;

            grid-template-columns:
                minmax(0,.9fr)
                minmax(0,1.1fr);

            gap:
                28px;

            align-items:
                start;
        }


        .form-two-column
        .form-group {

            margin-bottom:
                25px;
        }


        /* =========================================================
           UPLOAD
        ========================================================= */

        .upload-box {

            position:
                relative;

            min-height:
                300px;

            overflow:
                hidden;

            border:
                1px dashed
                rgba(226,201,151,.32);

            border-radius:
                18px;

            background:
                linear-gradient(
                    145deg,
                    rgba(226,201,151,.045),
                    rgba(255,255,255,.015)
                );

            cursor:
                pointer;

            transition:
                var(--transition);
        }


        .upload-box:hover {

            border-color:
                var(--accent);

            background:
                rgba(226,201,151,.065);

            box-shadow:
                0 0 0 4px
                rgba(226,201,151,.055);
        }


        .upload-placeholder {

            min-height:
                300px;

            padding:
                30px;

            display:
                flex;

            flex-direction:
                column;

            align-items:
                center;

            justify-content:
                center;

            text-align:
                center;
        }


        .upload-icon {

            width:
                66px;

            height:
                66px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            margin-bottom:
                16px;

            border:
                1px solid
                var(--border-gold);

            border-radius:
                18px;

            background:
                rgba(226,201,151,.09);

            color:
                var(--accent);

            font-size:
                25px;
        }


        .upload-title {

            margin-bottom:
                7px;

            font-size:
                16px;

            font-weight:
                800;
        }


        .upload-description {

            max-width:
                430px;

            color:
                var(--text-muted);

            font-size:
                14px;

            line-height:
                1.65;
        }


        .upload-format {

            margin-top:
                13px;

            color:
                var(--accent-dark);

            font-size:
                12px;

            font-weight:
                800;

            letter-spacing:
                .5px;
        }


        .upload-preview {

            position:
                absolute;

            inset:
                0;

            display:
                none;
        }


        .upload-preview.show {

            display:
                block;
        }


        .upload-preview img {

            width:
                100%;

            height:
                100%;

            object-fit:
                cover;
        }


        .upload-overlay {

            position:
                absolute;

            inset:
                0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            opacity:
                0;

            background:
                rgba(0,0,0,.58);

            transition:
                var(--transition);
        }


        .upload-box:hover
        .upload-overlay {

            opacity:
                1;
        }


        .upload-overlay span {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                8px;

            padding:
                11px 16px;

            border-radius:
                11px;

            background:
                rgba(0,0,0,.72);

            color:
                #fff;

            font-size:
                13px;

            font-weight:
                700;
        }


        .remove-image {

            position:
                absolute;

            right:
                13px;

            bottom:
                13px;

            z-index:
                5;

            display:
                none;

            align-items:
                center;

            gap:
                7px;

            height:
                38px;

            padding:
                0 14px;

            border:
                1px solid
                rgba(239,118,118,.3);

            border-radius:
                10px;

            background:
                rgba(15,15,15,.9);

            color:
                #ff9292;

            cursor:
                pointer;

            font-size:
                13px;
        }


        .remove-image.show {

            display:
                inline-flex;
        }


        /* =========================================================
           ACTION
        ========================================================= */

        .form-divider {

            width:
                100%;

            height:
                1px;

            margin:
                8px 0 25px;

            background:
                var(--border-soft);
        }


        .form-actions {

            display:
                flex;

            align-items:
                center;

            justify-content:
                flex-end;

            gap:
                12px;

            margin-top:
                12px;
        }


        .btn {

            min-height:
                56px;

            padding:
                0 22px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                9px;

            border-radius:
                14px;

            font-size:
                15px;

            font-weight:
                800;

            text-decoration:
                none;

            cursor:
                pointer;

            transition:
                var(--transition);
        }


        .btn-back {

            border:
                1px solid
                var(--border-soft);

            background:
                rgba(255,255,255,.025);

            color:
                var(--text-secondary);
        }


        .btn-back:hover {

            border-color:
                var(--accent);

            color:
                var(--text-primary);

            transform:
                translateY(-2px);
        }


        .btn-save {

            border:
                0;

            background:
                linear-gradient(
                    135deg,
                    var(--accent),
                    var(--accent-hover)
                );

            color:
                #17130c;
        }


        .btn-save:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 14px 30px
                rgba(226,201,151,.18);
        }


        .btn-save:disabled {

            opacity:
                .65;

            cursor:
                not-allowed;

            transform:
                none;
        }


        /* =========================================================
           LOADING
        ========================================================= */

        .loading-spinner {

            width:
                17px;

            height:
                17px;

            border:
                2px solid
                rgba(0,0,0,.25);

            border-top-color:
                #17130c;

            border-radius:
                50%;

            animation:
                spin .7s linear infinite;
        }


        @keyframes spin {

            to {
                transform:
                    rotate(360deg);
            }
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1280px) {

            .admin-main {

                margin-left:
                    270px;

                padding:
                    42px 40px 60px;
            }

        }


        @media (max-width: 1024px) {

            .admin-main {

                margin-left:
                    0;

                padding:
                    90px 30px 50px;
            }


            .admin-mobile-menu-button {

                display:
                    flex !important;
            }


            .form-two-column {

                grid-template-columns:
                    1fr;
            }

        }


        @media (max-width: 900px) {

            .form-two-column {

                grid-template-columns:
                    1fr;

                gap:
                    0;
            }


            .upload-box,
            .upload-placeholder {

                min-height:
                    250px;
            }


            .form-textarea {

                min-height:
                    220px;
            }

        }


        @media (max-width: 768px) {

            .admin-main {

                padding:
                    82px 20px 45px;
            }


            .page-title {

                font-size:
                    38px;

                letter-spacing:
                    -.8px;
            }


            .page-description {

                font-size:
                    15px;
            }


            .form-card {

                padding:
                    26px 21px;
            }


            .form-label {

                font-size:
                    15px;
            }


            .form-input,
            .form-select {

                height:
                    56px;

                font-size:
                    15px;
            }


            .field-helper {

                font-size:
                    12px;

                flex-wrap:
                    wrap;
            }

        }


        @media (max-width: 576px) {

            .admin-main {

                padding:
                    78px 14px 35px;
            }


            .admin-mobile-menu-button {

                top:
                    14px !important;

                left:
                    14px !important;

                width:
                    46px;

                height:
                    46px;
            }


            .page-title {

                font-size:
                    32px;
            }


            .page-description {

                font-size:
                    14px;
            }


            .alert-box {

                padding:
                    15px;

                gap:
                    11px;
            }


            .alert-icon {

                width:
                    38px;

                height:
                    38px;

                flex-basis:
                    38px;
            }


            .form-card {

                padding:
                    22px 17px;
            }


            .card-heading {

                align-items:
                    flex-start;

                margin-bottom:
                    24px;
            }


            .card-heading-icon {

                width:
                    42px;

                height:
                    42px;

                flex-basis:
                    42px;
            }


            .ticket-id-badge {

                min-width:
                    90px;
            }


            .upload-box,
            .upload-placeholder {

                min-height:
                    230px;
            }


            .upload-placeholder {

                padding:
                    22px;
            }


            .upload-description {

                font-size:
                    13px;
            }


            .form-actions {

                justify-content:
                    flex-end;

                flex-wrap:
                    wrap;
            }


            .btn {

                width:
                    100%;
            }

        }


        @media (max-width: 420px) {

            .admin-main {

                padding:
                    76px 12px 30px;
            }


            .form-card {

                padding:
                    20px 15px;
            }


            .page-title {

                font-size:
                    30px;
            }


            .card-heading {

                gap:
                    11px;
            }


            .card-heading h2 {

                font-size:
                    18px;
            }


            .ticket-id-badge {

                margin-left:
                    0;

                margin-top:
                    8px;
            }


            .card-heading {

                flex-wrap:
                    wrap;
            }

        }


        /* =========================================================
           REDUCE MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {

                scroll-behavior:
                    auto !important;

                transition:
                    none !important;

                animation:
                    none !important;
            }
        }

    </style>



<style>
/* =========================================================
   SIDEBAR HP / TABLET — FLOATING GLASS SESUAI REFERENSI
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

    body.admin-sidebar-open{
        overflow:hidden !important;
    }

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


    {{-- ==========================================================
         SIDEBAR
    =========================================================== --}}

    @include('Admin.partials.sidebar')


    {{-- ==========================================================
         MAIN
    =========================================================== --}}

    <main class="admin-main">


        {{-- ======================================================
             MOBILE MENU
        ======================================================= --}}

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


        {{-- ======================================================
             PAGE HEADER
        ======================================================= --}}

        <header class="page-header">

            <h1 class="page-title">
                Edit Tiket Wahana
            </h1>

            <p class="page-description">
                Perbarui informasi tiket wahana yang sudah tersimpan,
                mulai dari nama wahana, tarif, ketentuan penggunaan,
                status ketersediaan, hingga gambar wahana.
            </p>

        </header>


        {{-- ======================================================
             VALIDATION ERROR
        ======================================================= --}}

        @if ($errors->any())

            <div class="alert-box error">

                <div class="alert-icon">

                    <i class="fa-solid fa-circle-exclamation"></i>

                </div>


                <div class="alert-content">

                    <span class="alert-title">
                        Gagal memperbarui data
                    </span>

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        {{-- ======================================================
             SUCCESS
        ======================================================= --}}

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


        {{-- ======================================================
             ERROR
        ======================================================= --}}

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


        {{-- ======================================================
             CONTENT
        ======================================================= --}}

        <div class="content-grid">


            <section class="card form-card">


                {{-- ==================================================
                     CARD HEADING
                =================================================== --}}

                <div class="card-heading">

                    <div class="card-heading-icon">

                        <i class="fa-solid fa-ticket"></i>

                    </div>


                    <div>

                        <h2>
                            Informasi Tiket
                        </h2>

                        <p>
                            Perbarui data tiket wahana di bawah ini.
                        </p>

                    </div>  

                </div>


                {{-- ==================================================
                     FORM
                =================================================== --}}

                <form
                    id="tiketForm"
                    action="{{ route('admin.tiket-wahana.update', $tiketWahana->id_tiket_wahana) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf

                    @method('PUT')


                    {{-- ==================================================
                         NAMA WAHANA
                    =================================================== --}}

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="nama_wahana"
                        >

                            Nama Wahana

                            <span class="required">
                                *
                            </span>

                        </label>


                        <div class="input-wrap">

                            <i
                                class="fa-solid fa-ticket input-icon"
                                aria-hidden="true"
                            ></i>

                            <input
                                type="text"
                                name="nama_wahana"
                                id="nama_wahana"
                                class="form-input"
                                value="{{ old('nama_wahana', $tiketWahana->nama_wahana) }}"
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


                    {{-- ==================================================
                         HARGA
                    =================================================== --}}

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="harga"
                        >

                            Harga Tiket

                            <span class="required">
                                *
                            </span>

                        </label>


                        <div class="input-wrap">

                            <span
                                class="currency-symbol"
                                aria-hidden="true"
                            >
                                Rp
                            </span>

                            <input
                                type="number"
                                name="harga"
                                id="harga"
                                class="form-input"
                                value="{{ old('harga', $tiketWahana->harga) }}"
                                placeholder="25000"
                                min="0"
                                step="1"
                                inputmode="numeric"
                                autocomplete="off"
                                required
                            >

                        </div>


                        <div class="field-helper">

                            <span>

                                <i class="fa-solid fa-circle-info"></i>

                                Masukkan harga tiket dalam rupiah.

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


                    {{-- ==================================================
                         STATUS
                    =================================================== --}}

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="status"
                        >

                            Status Ketersediaan

                            <span class="required">
                                *
                            </span>

                        </label>


                        <div class="input-wrap">

                            <i
                                class="fa-solid fa-toggle-on input-icon"
                                aria-hidden="true"
                            ></i>

                            <select
                                name="status"
                                id="status"
                                class="form-select"
                                required
                            >

                                <option
                                    value="Tersedia"
                                    {{ old('status', $tiketWahana->status) === 'Tersedia' ? 'selected' : '' }}
                                >
                                    Tersedia
                                </option>

                                <option
                                    value="Tidak Tersedia"
                                    {{ old('status', $tiketWahana->status) === 'Tidak Tersedia' ? 'selected' : '' }}
                                >
                                    Tidak Tersedia
                                </option>

                            </select>


                            <i
                                class="fa-solid fa-chevron-down select-arrow"
                                aria-hidden="true"
                            ></i>

                        </div>


                        @error('status')

                            <small class="field-error">

                                <i class="fa-solid fa-circle-exclamation"></i>

                                {{ $message }}

                            </small>

                        @enderror

                    </div>


                    {{-- ==================================================
                         GAMBAR + KETENTUAN
                    =================================================== --}}

                    <div class="form-two-column">


                        {{-- ==================================================
                             KETENTUAN
                        =================================================== --}}

                        <div>

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
                                    rows="8"
                                    maxlength="1000"
                                    placeholder="Contoh: Minimal tinggi 120 cm. Anak-anak wajib didampingi orang dewasa."
                                >{{ old('ketentuan', $tiketWahana->ketentuan) }}</textarea>


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


                        {{-- ==================================================
                             GAMBAR
                        =================================================== --}}

                        <div>

                            <div class="form-group">

                                <label
                                    class="form-label"
                                    for="gambar"
                                >
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
                                        style="
                                            display:block;
                                            width:100%;
                                            height:100%;
                                            cursor:pointer;
                                        "
                                    >


                                        {{-- ==================================
                                             PLACEHOLDER
                                        =================================== --}}

                                        <div
                                            class="upload-placeholder"
                                            id="uploadPlaceholder"
                                            style="{{ $tiketWahana->gambar ? 'display:none;' : '' }}"
                                        >

                                            <div class="upload-icon">

                                                <i class="fa-solid fa-cloud-arrow-up"></i>

                                            </div>


                                            <div class="upload-title">
                                                Upload Gambar Wahana
                                            </div>


                                            <div class="upload-description">

                                                Klik untuk memilih gambar
                                                baru atau ganti gambar
                                                yang sedang digunakan.

                                            </div>


                                            <div class="upload-format">

                                                JPG / JPEG / PNG / WEBP
                                                • Maksimal 2 MB

                                            </div>

                                        </div>


                                        {{-- ==================================
                                             PREVIEW
                                        =================================== --}}

                                        <div
                                            class="upload-preview {{ $tiketWahana->gambar ? 'show' : '' }}"
                                            id="uploadPreview"
                                        >

                                            <img
                                                src="{{ $tiketWahana->gambar
                                                    ? asset('storage/' . $tiketWahana->gambar)
                                                    : '' }}"
                                                alt="{{ $tiketWahana->nama_wahana }}"
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


                                    {{-- ==================================
                                         REMOVE
                                    =================================== --}}

                                    <button
                                        type="button"
                                        class="remove-image {{ $tiketWahana->gambar ? 'show' : '' }}"
                                        id="removeImage"
                                    >

                                        <i class="fa-solid fa-trash"></i>

                                        Hapus gambar baru

                                    </button>

                                </div>


                                <div class="field-helper">

                                    <span>

                                        <i class="fa-solid fa-circle-info"></i>

                                        @if($tiketWahana->gambar)
                                            Gambar saat ini sedang digunakan.
                                        @else
                                            Belum ada gambar.
                                        @endif

                                    </span>


                                    <span>
                                        Maks. <strong>2 MB</strong>
                                    </span>

                                </div>


                                <span
                                    id="fileName"
                                    style="
                                        display:block;
                                        margin-top:8px;
                                        color:var(--text-secondary);
                                        font-size:13px;
                                    "
                                >

                                    @if($tiketWahana->gambar)

                                        Gambar saat ini digunakan

                                    @else

                                        Belum memilih gambar baru

                                    @endif

                                </span>


                                @error('gambar')

                                    <small class="field-error">

                                        <i class="fa-solid fa-circle-exclamation"></i>

                                        {{ $message }}

                                    </small>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================
                         DIVIDER
                    =================================================== --}}

                    <div class="form-divider"></div>


                    {{-- ==================================================
                         ACTION
                    =================================================== --}}

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
                            class="btn btn-save"
                            id="saveButton"
                        >

                            <span id="saveButtonContent">

                                <i class="fa-solid fa-floppy-disk"></i>

                                Simpan Perubahan

                            </span>

                        </button>

                    </div>


                </form>

            </section>

        </div>

    </main>


    {{-- ==============================================================
         JAVASCRIPT
    ============================================================== --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {


                /* =====================================================
                   ELEMENT
                ====================================================== */

                const openAdminSidebar =
                    document.getElementById(
                        'openAdminSidebar'
                    );


                const form =
                    document.getElementById(
                        'tiketForm'
                    );


                const namaInput =
                    document.getElementById(
                        'nama_wahana'
                    );


                const hargaInput =
                    document.getElementById(
                        'harga'
                    );


                const statusInput =
                    document.getElementById(
                        'status'
                    );


                const ketentuanInput =
                    document.getElementById(
                        'ketentuan'
                    );


                const gambarInput =
                    document.getElementById(
                        'gambar'
                    );


                const uploadBox =
                    document.getElementById(
                        'uploadBox'
                    );


                const uploadPlaceholder =
                    document.getElementById(
                        'uploadPlaceholder'
                    );


                const uploadPreview =
                    document.getElementById(
                        'uploadPreview'
                    );


                const imagePreview =
                    document.getElementById(
                        'imagePreview'
                    );


                const removeImage =
                    document.getElementById(
                        'removeImage'
                    );


                const fileName =
                    document.getElementById(
                        'fileName'
                    );


                const counter =
                    document.getElementById(
                        'counter'
                    );


                const saveButton =
                    document.getElementById(
                        'saveButton'
                    );


                const saveButtonContent =
                    document.getElementById(
                        'saveButtonContent'
                    );


                /* =====================================================
                   MOBILE SIDEBAR
                ====================================================== */

                if (openAdminSidebar) {

                    openAdminSidebar.addEventListener(
                        'click',
                        function () {

                            if (
                                typeof window.openAdminSidebar ===
                                'function'
                            ) {

                                window.openAdminSidebar();

                                return;
                            }


                            const sidebar =
                                document.getElementById(
                                    'adminSidebar'
                                );


                            const overlay =
                                document.getElementById(
                                    'sidebarOverlay'
                                );


                            if (sidebar) {

                                sidebar.classList.add(
                                    'open',
                                    'active'
                                );

                            }


                            if (overlay) {

                                overlay.classList.add(
                                    'show',
                                    'active'
                                );

                            }


                            document.body.classList.add(
                                'sidebar-open'
                            );


                            openAdminSidebar.setAttribute(
                                'aria-expanded',
                                'true'
                            );

                        }
                    );

                }


                /* =====================================================
                   IMAGE VALIDATION
                ====================================================== */

                function validateImage(file) {

                    if (!file) {
                        return false;
                    }


                    const maxSize =
                        2 * 1024 * 1024;


                    if (file.size > maxSize) {

                        alert(
                            'Ukuran gambar maksimal 2 MB.'
                        );

                        return false;
                    }


                    const allowedTypes = [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                        'image/webp'
                    ];


                    if (
                        !allowedTypes.includes(
                            file.type
                        )
                    ) {

                        alert(
                            'Format gambar harus JPG, JPEG, PNG, atau WEBP.'
                        );

                        return false;
                    }


                    return true;
                }


                /* =====================================================
                   SHOW IMAGE
                ====================================================== */

                function showImage(file) {

                    if (!file) {
                        return;
                    }


                    const reader =
                        new FileReader();


                    reader.onload =
                        function (event) {

                            if (imagePreview) {

                                imagePreview.src =
                                    event.target.result;

                            }


                            if (uploadPreview) {

                                uploadPreview.classList.add(
                                    'show'
                                );

                            }


                            if (uploadPlaceholder) {

                                uploadPlaceholder.style.display =
                                    'none';

                            }


                            if (removeImage) {

                                removeImage.classList.add(
                                    'show'
                                );

                            }


                            if (fileName) {

                                fileName.textContent =
                                    file.name;

                            }

                        };


                    reader.readAsDataURL(
                        file
                    );
                }


                /* =====================================================
                   IMAGE CHANGE
                ====================================================== */

                if (gambarInput) {

                    gambarInput.addEventListener(
                        'change',
                        function () {

                            const file =
                                this.files[0];


                            if (!file) {
                                return;
                            }


                            if (
                                !validateImage(
                                    file
                                )
                            ) {

                                this.value =
                                    '';

                                return;
                            }


                            showImage(
                                file
                            );

                        }
                    );

                }


                /* =====================================================
                   REMOVE IMAGE
                ====================================================== */

                if (removeImage) {

                    removeImage.addEventListener(
                        'click',
                        function (event) {

                            event.preventDefault();

                            event.stopPropagation();


                            if (gambarInput) {

                                gambarInput.value =
                                    '';

                            }


                            /*
                             * Kembalikan ke gambar lama
                             * apabila memang masih ada.
                             */

                            const existingImage =
                                @json(
                                    $tiketWahana->gambar
                                        ? asset('storage/' . $tiketWahana->gambar)
                                        : null
                                );


                            if (
                                existingImage &&
                                imagePreview
                            ) {

                                imagePreview.src =
                                    existingImage;

                                if (uploadPreview) {

                                    uploadPreview.classList.add(
                                        'show'
                                    );

                                }

                                if (uploadPlaceholder) {

                                    uploadPlaceholder.style.display =
                                        'none';

                                }

                                if (fileName) {

                                    fileName.textContent =
                                        'Gambar saat ini digunakan';

                                }

                            } else {

                                if (uploadPreview) {

                                    uploadPreview.classList.remove(
                                        'show'
                                    );

                                }

                                if (uploadPlaceholder) {

                                    uploadPlaceholder.style.display =
                                        'flex';

                                }

                                if (imagePreview) {

                                    imagePreview.src =
                                        '';

                                }

                                if (fileName) {

                                    fileName.textContent =
                                        'Belum memilih gambar baru';

                                }

                            }


                            removeImage.classList.remove(
                                'show'
                            );

                        }
                    );

                }


                /* =====================================================
                   DRAG & DROP
                ====================================================== */

                if (uploadBox) {

                    [
                        'dragenter',
                        'dragover'
                    ].forEach(
                        function (eventName) {

                            uploadBox.addEventListener(
                                eventName,
                                function (event) {

                                    event.preventDefault();

                                    event.stopPropagation();

                                    uploadBox.classList.add(
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
                        function (eventName) {

                            uploadBox.addEventListener(
                                eventName,
                                function (event) {

                                    event.preventDefault();

                                    event.stopPropagation();

                                    uploadBox.classList.remove(
                                        'dragging'
                                    );

                                }
                            );

                        }
                    );


                    uploadBox.addEventListener(
                        'drop',
                        function (event) {

                            const files =
                                event.dataTransfer.files;


                            if (
                                !files ||
                                !files.length
                            ) {

                                return;
                            }


                            const file =
                                files[0];


                            if (
                                !validateImage(
                                    file
                                )
                            ) {

                                return;
                            }


                            try {

                                const dataTransfer =
                                    new DataTransfer();


                                dataTransfer.items.add(
                                    file
                                );


                                gambarInput.files =
                                    dataTransfer.files;

                            } catch (error) {

                                /*
                                 * Browser lama mungkin tidak
                                 * mengizinkan assignment files.
                                 */

                            }


                            showImage(
                                file
                            );

                        }
                    );

                }


                /* =====================================================
                   CHARACTER COUNTER
                ====================================================== */

                function updateCounter() {

                    if (
                        !ketentuanInput ||
                        !counter
                    ) {

                        return;
                    }


                    const length =
                        ketentuanInput.value.length;


                    counter.textContent =
                        `${length} / 1000`;

                }


                if (ketentuanInput) {

                    ketentuanInput.addEventListener(
                        'input',
                        updateCounter
                    );


                    updateCounter();

                }


                /* =====================================================
                   PRICE
                ====================================================== */

                if (hargaInput) {

                    hargaInput.addEventListener(
                        'input',
                        function () {

                            if (
                                this.value !== '' &&
                                Number(this.value) < 0
                            ) {

                                this.value =
                                    0;

                            }

                        }
                    );

                }


                /* =====================================================
                   FORM SUBMIT
                ====================================================== */

                if (
                    form &&
                    saveButton
                ) {

                    form.addEventListener(
                        'submit',
                        function () {

                            saveButton.disabled =
                                true;


                            if (saveButtonContent) {

                                saveButtonContent.innerHTML = `

                                    <span class="loading-spinner"></span>

                                    <span>
                                        Menyimpan...
                                    </span>

                                `;

                            }

                        }
                    );

                }


                /* =====================================================
                   ALERT AUTO HIDE
                ====================================================== */

                const alerts =
                    document.querySelectorAll(
                        '.alert-box'
                    );


                alerts.forEach(
                    function (alert) {

                        setTimeout(
                            function () {

                                alert.style.opacity =
                                    '0';

                                alert.style.transform =
                                    'translateY(-8px)';


                                setTimeout(
                                    function () {

                                        alert.remove();

                                    },
                                    300
                                );

                            },
                            5000
                        );

                    }
                );


            }
        );

    </script>


</body>

</html>