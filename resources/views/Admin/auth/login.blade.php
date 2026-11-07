<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <meta
        name="description"
        content="Login Sistem Noyo Gimbal"
    >

    <meta
        name="author"
        content="Noyo Gimbal"
    >

    <title>
        @yield('title', 'Login | Noyo Gimbal')
    </title>


    {{-- ================================================================
         FAVICON
    ================================================================= --}}

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/logo.png') }}"
    >


    {{-- ================================================================
         GOOGLE FONT
    ================================================================= --}}

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
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- ================================================================
         FONT AWESOME
    ================================================================= --}}

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    >


    <style>
/* =========================================================
   NOYO GIMBAL — LOGIN
   MODERN • ELEGANT • WARM GOLD • RESPONSIVE • READABLE
========================================================= */

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
    --danger:#df9999;

    --white:#ffffff;
    --black:#000000;

    --shadow-soft:0 20px 60px rgba(0,0,0,.40);
    --shadow-hover:0 28px 80px rgba(0,0,0,.50);

    --radius-lg:30px;
    --radius-md:18px;
    --radius-sm:14px;
    --radius-full:999px;

    --transition:.25s cubic-bezier(.4,0,.2,1);
}

/* =========================================================
   RESET
========================================================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    min-height:100%;
    scroll-behavior:smooth;
}

body{
    min-height:100%;
    font-family:'Inter',sans-serif;
    background:var(--bg-primary);
    color:var(--text-primary);
    line-height:1.65;
    overflow-x:hidden;
}

button,
input{
    font-family:inherit;
}

button,
input,
a{
    -webkit-tap-highlight-color:transparent;
}

a{
    color:inherit;
    text-decoration:none;
}

::selection{
    background:rgba(226,201,151,.22);
    color:var(--text-primary);
}

/* =========================================================
   LOGIN BODY
========================================================= */

.login-body{
    min-height:100vh;
    min-height:100dvh;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:30px;

    position:relative;
    overflow:hidden;

    background:
        radial-gradient(
            circle at 10% 5%,
            rgba(226,201,151,.10),
            transparent 30%
        ),
        radial-gradient(
            circle at 92% 95%,
            rgba(184,154,110,.06),
            transparent 32%
        ),
        var(--bg-primary);
}

/* Decorative lights */
.login-body::before,
.login-body::after{
    content:"";
    position:fixed;
    pointer-events:none;
    border-radius:50%;
}

.login-body::before{
    width:420px;
    height:420px;
    top:-250px;
    left:-180px;

    background:rgba(226,201,151,.055);
    filter:blur(90px);
}

.login-body::after{
    width:480px;
    height:480px;
    right:-260px;
    bottom:-280px;

    background:rgba(184,154,110,.045);
    filter:blur(100px);
}

/* =========================================================
   LEGACY BLUR CIRCLES — TETAP DIDUKUNG
========================================================= */

.blur-circle{
    position:fixed;
    border-radius:50%;
    pointer-events:none;
    z-index:0;
    filter:blur(110px);
    opacity:.25;
}

.blur-1{
    width:290px;
    height:290px;
    top:-130px;
    left:-120px;
    background:var(--accent);
}

.blur-2{
    width:360px;
    height:360px;
    right:-170px;
    bottom:-190px;
    background:var(--accent-dark);
}

/* =========================================================
   LOGIN WRAPPER
========================================================= */

.login-wrapper{
    width:min(1260px,100%);
    min-height:min(760px,calc(100dvh - 60px));

    display:grid;
    grid-template-columns:minmax(0,1fr) minmax(0,1fr);

    position:relative;
    z-index:2;

    overflow:hidden;

    border:1px solid var(--border-gold);
    border-radius:var(--radius-lg);

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.045),
            rgba(255,255,255,.015)
        ),
        rgba(18,18,18,.88);

    backdrop-filter:blur(28px) saturate(120%);
    -webkit-backdrop-filter:blur(28px) saturate(120%);

    box-shadow:var(--shadow-soft);
}

/* =========================================================
   LEFT SIDE
========================================================= */

.login-left{
    position:relative;

    display:flex;
    flex-direction:column;
    justify-content:center;

    min-width:0;

    padding:72px 72px 66px;

    background:
        radial-gradient(
            circle at 12% 6%,
            rgba(226,201,151,.035),
            transparent 33%
        );
}

.login-left::before{
    content:"";
    position:absolute;

    top:0;
    right:0;
    bottom:0;

    width:1px;

    background:linear-gradient(
        to bottom,
        transparent,
        rgba(226,201,151,.12),
        transparent
    );

    pointer-events:none;
}

/* =========================================================
   LOGO
========================================================= */

.login-logo{
    position:absolute;

    top:30px;
    left:32px;

    display:inline-flex;
    align-items:center;
    gap:9px;

    color:var(--text-primary);

    font-family:'Playfair Display',Georgia,serif;
    font-size:20px;
    font-weight:800;
    letter-spacing:.9px;

    white-space:nowrap;
}

.login-logo::before{
    content:"NG";

    width:35px;
    height:35px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid rgba(226,201,151,.28);
    border-radius:10px;

    background:rgba(226,201,151,.07);
    color:var(--accent);

    font-family:'Inter',sans-serif;
    font-size:11px;
    font-weight:800;
    letter-spacing:.2px;
}

/* =========================================================
   CONTENT
========================================================= */

.login-content{
    width:100%;
    max-width:510px;

    margin:0 0 30px;
}

.login-subtitle{
    display:inline-flex;
    align-items:center;
    gap:9px;

    color:var(--accent);

    font-size:12px;
    font-weight:800;
    line-height:1.2;
    letter-spacing:2.8px;

    text-transform:uppercase;
}

.login-subtitle::before{
    content:"";
    width:24px;
    height:1px;
    flex:0 0 24px;

    background:var(--accent);
    opacity:.8;
}

.login-content h1{
    margin:13px 0 14px;

    color:var(--text-primary);

    font-family:'Playfair Display',Georgia,serif;
    font-size:clamp(42px,4.6vw,60px);
    font-weight:700;
    line-height:1.05;
    letter-spacing:-1.3px;
}

.login-content p{
    max-width:500px;

    color:var(--text-muted);
    font-size:16px;
    line-height:1.8;
}

/* =========================================================
   ALERTS
========================================================= */

.login-alert,
.login-success{
    width:100%;
    max-width:510px;

    display:flex;
    align-items:flex-start;
    gap:12px;

    margin-bottom:20px;
    padding:15px 17px;

    border-radius:var(--radius-sm);

    font-size:14px;
    line-height:1.65;
}

.login-alert{
    color:#efa2a2;
    background:rgba(213,138,138,.06);
    border:1px solid rgba(213,138,138,.17);
}

.login-success{
    color:var(--success);
    background:rgba(155,201,167,.055);
    border:1px solid rgba(155,201,167,.16);
}

.login-alert i,
.login-success i{
    margin-top:3px;
    flex-shrink:0;
}

.login-alert span,
.login-success span{
    min-width:0;
}

/* =========================================================
   FORM
========================================================= */

.login-form{
    width:100%;
    max-width:510px;
}

.form-group{
    margin-bottom:19px;
}

.form-group label{
    display:block;
    margin-bottom:9px;

    color:var(--text-secondary);

    font-size:15px;
    font-weight:700;
    line-height:1.4;
}

/* =========================================================
   INPUT
========================================================= */

.input-custom{
    width:100%;
    height:60px;

    display:flex;
    align-items:center;
    gap:13px;

    padding:0 18px;

    border:1px solid rgba(255,255,255,.08);
    border-radius:16px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.025),
            rgba(255,255,255,.008)
        ),
        var(--bg-card);

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.018);

    transition:
        border-color var(--transition),
        box-shadow var(--transition),
        background var(--transition);
}

.input-custom:focus-within{
    border-color:rgba(226,201,151,.60);

    background:
        linear-gradient(
            145deg,
            rgba(226,201,151,.035),
            rgba(255,255,255,.01)
        ),
        var(--bg-card);

    box-shadow:
        0 0 0 4px rgba(226,201,151,.055),
        inset 0 1px 0 rgba(255,255,255,.02);
}

.input-custom .icon-left{
    flex:0 0 19px;

    color:var(--accent);
    font-size:16px;
    text-align:center;
}

.input-custom input{
    min-width:0;
    width:100%;
    height:100%;

    border:0;
    outline:0;

    background:transparent;

    color:var(--text-primary);

    font-family:'Inter',sans-serif;
    font-size:16px;
    font-weight:500;
}

.input-custom input::placeholder{
    color:var(--text-dim);
    opacity:1;
}

.toggle-password{
    flex:0 0 21px;

    color:var(--accent);
    font-size:16px;

    cursor:pointer;
    opacity:.92;

    transition:opacity var(--transition);
}

.toggle-password:hover{
    opacity:1;
}

.toggle-password:focus-visible{
    outline:2px solid rgba(226,201,151,.7);
    outline-offset:3px;
    border-radius:6px;
}

/* Autofill */
.input-custom input:-webkit-autofill,
.input-custom input:-webkit-autofill:hover,
.input-custom input:-webkit-autofill:focus,
.input-custom input:-webkit-autofill:active{
    -webkit-text-fill-color:var(--text-primary) !important;

    -webkit-box-shadow:
        0 0 0 1000px var(--bg-card) inset !important;

    box-shadow:
        0 0 0 1000px var(--bg-card) inset !important;

    transition:background-color 5000s ease-in-out 0s;
}

.text-danger{
    display:block;
    margin-top:7px;

    color:#e9a0a0;

    font-size:13px;
    line-height:1.55;
}

/* =========================================================
   OPTIONS
========================================================= */

.login-options{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:18px;

    margin:3px 0 23px;
}

.remember-box{
    display:flex;
    align-items:center;
    gap:10px;

    color:var(--text-muted);

    font-size:14px;
    font-weight:600;

    cursor:pointer;
    user-select:none;
}

.remember-box input{
    width:18px;
    height:18px;

    accent-color:var(--accent);

    cursor:pointer;
}

.forgot-password{
    color:var(--accent);

    font-size:14px;
    font-weight:600;

    opacity:.82;
}

/* =========================================================
   LOGIN BUTTON
========================================================= */

.login-btn{
    width:100%;
    min-height:58px;

    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;

    padding:0 22px;

    border:1px solid rgba(226,201,151,.55);
    border-radius:16px;

    background:
        linear-gradient(
            135deg,
            var(--accent) 0%,
            var(--accent-hover) 100%
        );

    color:var(--bg-primary);

    font-size:16px;
    font-weight:800;
    letter-spacing:.15px;

    cursor:pointer;

    box-shadow:
        0 12px 35px rgba(0,0,0,.20);

    transition:
        transform var(--transition),
        box-shadow var(--transition),
        filter var(--transition);
}

.login-btn:hover{
    transform:translateY(-2px);

    box-shadow:
        var(--shadow-hover);

    filter:brightness(1.03);
}

.login-btn:active{
    transform:translateY(0);
}

.login-btn:focus-visible{
    outline:2px solid rgba(226,201,151,.78);
    outline-offset:4px;
}

.login-btn.loading{
    pointer-events:none;
    opacity:.72;
}

.loading-icon{
    display:none;
}

.login-btn.loading .login-icon{
    display:none;
}

.login-btn.loading .loading-icon{
    display:inline-block;
}

/* =========================================================
   RIGHT IMAGE
========================================================= */

.login-right{
    position:relative;
    min-width:0;

    padding:16px;
}

.image-wrapper{
    width:100%;
    height:100%;

    position:relative;

    overflow:hidden;

    border:1px solid rgba(226,201,151,.10);
    border-radius:22px;

    background:var(--bg-soft);
}

.image-wrapper img{
    width:100%;
    height:100%;

    display:block;

    object-fit:cover;

    transition:transform .8s ease;
}

.image-wrapper:hover img{
    transform:scale(1.025);
}

.image-overlay{
    position:absolute;
    inset:0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,.90) 0%,
            rgba(0,0,0,.38) 58%,
            rgba(0,0,0,.08) 100%
        );
}

/* =========================================================
   RIGHT CONTENT
========================================================= */

.right-content{
    position:absolute;

    left:58px;
    right:58px;
    bottom:58px;

    z-index:5;
}

.right-content::before{
    content:"NOYO GIMBAL";

    display:inline-flex;
    align-items:center;

    margin-bottom:13px;
    padding:7px 11px;

    border:1px solid rgba(226,201,151,.18);
    border-radius:var(--radius-full);

    background:rgba(10,10,10,.36);

    color:var(--accent);

    font-size:11px;
    font-weight:800;
    line-height:1;
    letter-spacing:1.6px;

    backdrop-filter:blur(8px);
}

.right-content h2{
    margin-bottom:10px;

    color:var(--text-primary);

    font-family:'Playfair Display',Georgia,serif;
    font-size:42px;
    font-weight:700;
    line-height:1.15;
    letter-spacing:-.7px;
}

.right-content p{
    max-width:470px;

    color:rgba(248,244,237,.76);

    font-size:15px;
    line-height:1.85;
}

/* =========================================================
   TABLET
========================================================= */

@media (max-width:1100px){

    .login-body{
        padding:22px;
    }

    .login-wrapper{
        width:min(620px,100%);
        min-height:auto;

        display:block;

        border-radius:26px;
    }

    .login-right{
        display:none;
    }

    .login-left{
        min-height:auto;
        padding:86px 52px 50px;

        background:
            radial-gradient(
                circle at 12% 5%,
                rgba(226,201,151,.045),
                transparent 38%
            );
    }

    .login-left::before{
        display:none;
    }

    .login-logo{
        top:26px;
        left:29px;
    }

    .login-content h1{
        font-size:48px;
    }

    .login-content p{
        font-size:16px;
    }

    .form-group label{
        font-size:15px;
    }

    .input-custom{
        height:60px;
    }

    .login-btn{
        min-height:60px;
    }
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width:600px){

    .login-body{
        align-items:flex-start;

        padding:
            max(14px,env(safe-area-inset-top))
            14px
            max(14px,env(safe-area-inset-bottom));
    }

    .login-wrapper{
        width:100%;
        margin:auto 0;

        border-radius:22px;
    }

    .login-left{
        padding:82px 22px 28px;
    }

    .login-logo{
        top:23px;
        left:22px;

        font-size:18px;
    }

    .login-logo::before{
        width:33px;
        height:33px;
        border-radius:9px;
        font-size:10px;
    }

    .login-content{
        margin-bottom:25px;
    }

    .login-subtitle{
        font-size:11px;
        letter-spacing:2.2px;
    }

    .login-content h1{
        margin-top:11px;
        font-size:38px;
        letter-spacing:-.8px;
    }

    .login-content p{
        margin-top:3px;
        font-size:15px;
        line-height:1.75;
    }

    .login-alert,
    .login-success{
        font-size:14px;
        padding:14px;
        margin-bottom:18px;
    }

    .form-group{
        margin-bottom:17px;
    }

    .form-group label{
        margin-bottom:8px;
        font-size:15px;
    }

    .input-custom{
        height:58px;
        padding:0 16px;
        border-radius:15px;
    }

    .input-custom input{
        font-size:16px;
    }

    .login-options{
        flex-direction:column;
        align-items:flex-start;
        gap:12px;

        margin-bottom:20px;
    }

    .remember-box,
    .forgot-password{
        font-size:14px;
    }

    .login-btn{
        min-height:58px;
        border-radius:15px;
        font-size:16px;
    }
}

/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width:380px){

    .login-left{
        padding:78px 18px 24px;
    }

    .login-logo{
        top:20px;
        left:18px;
        font-size:17px;
    }

    .login-content h1{
        font-size:34px;
    }

    .login-content p{
        font-size:14.5px;
    }

    .input-custom{
        height:57px;
        padding:0 14px;
    }

    .input-custom input{
        font-size:15.5px;
    }

    .login-btn{
        min-height:57px;
    }
}

/* =========================================================
   LARGE MONITOR
========================================================= */

@media (min-width:1500px){

    .login-wrapper{
        width:min(1340px,calc(100vw - 80px));
    }

    .login-left{
        padding-left:84px;
        padding-right:84px;
    }

    .login-logo{
        left:38px;
        top:34px;
    }

    .right-content{
        left:66px;
        right:66px;
        bottom:66px;
    }
}

/* =========================================================
   ACCESSIBILITY / REDUCED MOTION
========================================================= */

:focus-visible{
    outline:2px solid rgba(226,201,151,.78);
    outline-offset:3px;
}

@media (prefers-reduced-motion:reduce){

    html{
        scroll-behavior:auto;
    }

    *,
    *::before,
    *::after{
        transition:none !important;
        animation:none !important;
    }
}

/* =========================================================
   PRINT / NOISE CONTROL
========================================================= */

@media print{
    .blur-circle,
    .login-body::before,
    .login-body::after{
        display:none !important;
    }
}
    </style>

</head>


<body class="login-body">


    {{-- ================================================================
         BACKGROUND
    ================================================================= --}}

    <div class="blur-circle blur-1"></div>

    <div class="blur-circle blur-2"></div>


    {{-- ================================================================
         LOGIN CONTAINER
    ================================================================= --}}

    <main class="login-wrapper">


        {{-- ============================================================
             LEFT
        ============================================================= --}}

        <section class="login-left">


            {{-- LOGO --}}

            <div class="login-logo">
                NOYO GIMBAL
            </div>


            {{-- HEADER --}}

            <div class="login-content">

                <span class="login-subtitle">
                    SYSTEM LOGIN
                </span>

                <h1>
                    Welcome Back
                </h1>

                <p>
                    Login untuk mengakses sistem Noyo Gimbal.
                    Sistem akan mengarahkan kamu ke halaman
                    sesuai dengan hak akses akun.
                </p>

            </div>


            {{-- ========================================================
                 SUCCESS
            ========================================================= --}}

            @if (session('success'))

                <div
                    class="login-success"
                    role="alert"
                >

                    <i class="fas fa-circle-check"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            {{-- ========================================================
                 ERROR
            ========================================================= --}}

            @if (session('error'))

                <div
                    class="login-alert"
                    role="alert"
                >

                    <i class="fas fa-circle-exclamation"></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            {{-- ========================================================
                 VALIDATION ERROR
            ========================================================= --}}

            @if ($errors->any())

                <div
                    class="login-alert"
                    role="alert"
                >

                    <i class="fas fa-circle-exclamation"></i>

                    <span>
                        {{ $errors->first() }}
                    </span>

                </div>

            @endif


            {{-- ========================================================
                 LOGIN FORM
            ========================================================= --}}

            <form
                action="{{ url('/login') }}"
                method="POST"
                class="login-form"
                id="loginForm"
            >

                @csrf


                {{-- ====================================================
                     EMAIL
                ===================================================== --}}

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <div class="input-custom">

                        <i class="fas fa-envelope icon-left"></i>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="example@gmail.com"
                            autocomplete="email"
                            autofocus
                            required
                        >

                    </div>


                    @error('email')

                        <small class="text-danger">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- ====================================================
                     PASSWORD
                ===================================================== --}}

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-custom">

                        <i class="fas fa-lock icon-left"></i>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >

                        <i
                            class="fas fa-eye toggle-password"
                            id="togglePassword"
                            title="Tampilkan password"
                            role="button"
                            tabindex="0"
                            aria-label="Tampilkan password"
                        ></i>

                    </div>


                    @error('password')

                        <small class="text-danger">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- ====================================================
                     OPTIONS
                ===================================================== --}}

                <div class="login-options">

                    <label class="remember-box">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            {{ old('remember') ? 'checked' : '' }}
                        >

                        <span>
                            Remember Me
                        </span>

                    </label>


                    <span
                        class="forgot-password"
                        title="Fitur lupa password belum tersedia"
                    >
                        Forgot Password?
                    </span>

                </div>


                {{-- ====================================================
                     LOGIN BUTTON
                ===================================================== --}}

                <button
                    type="submit"
                    class="login-btn"
                    id="loginButton"
                >

                    <i class="fas fa-right-to-bracket login-icon"></i>

                    <i class="fas fa-spinner fa-spin loading-icon"></i>

                    <span id="loginButtonText">
                        Sign In
                    </span>

                </button>

            </form>

        </section>


        {{-- ============================================================
             RIGHT IMAGE
        ============================================================= --}}

        <section class="login-right">

            <div class="image-wrapper">

                <img
                    src="{{ asset('images/noyo2.jpg') }}"
                    alt="Noyo Gimbal"
                    onerror="this.style.display='none';"
                >

                <div class="image-overlay"></div>

            </div>


            <div class="right-content">

                <h2>
                    Noyo Gimbal
                </h2>

                <p>
                    Satu sistem untuk mengelola operasional,
                    pesanan, wahana, menu, oleh-oleh,
                    paket bundling, event, dan kebutuhan
                    operasional Noyo Gimbal.
                </p>

            </div>

        </section>


    </main>


    {{-- ================================================================
         JAVASCRIPT
    ================================================================= --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                /* ======================================================
                   PASSWORD TOGGLE
                ====================================================== */

                const togglePassword =
                    document.getElementById('togglePassword');

                const passwordInput =
                    document.getElementById('password');


                if (
                    togglePassword &&
                    passwordInput
                ) {

                    function togglePasswordVisibility() {

                        const isPassword =
                            passwordInput.type === 'password';


                        passwordInput.type =
                            isPassword
                                ? 'text'
                                : 'password';


                        togglePassword.classList.toggle(
                            'fa-eye',
                            !isPassword
                        );


                        togglePassword.classList.toggle(
                            'fa-eye-slash',
                            isPassword
                        );


                        togglePassword.setAttribute(
                            'title',
                            isPassword
                                ? 'Sembunyikan password'
                                : 'Tampilkan password'
                        );


                        togglePassword.setAttribute(
                            'aria-label',
                            isPassword
                                ? 'Sembunyikan password'
                                : 'Tampilkan password'
                        );

                    }


                    togglePassword.addEventListener(
                        'click',
                        togglePasswordVisibility
                    );


                    togglePassword.addEventListener(
                        'keydown',
                        function (event) {

                            if (
                                event.key === 'Enter' ||
                                event.key === ' '
                            ) {

                                event.preventDefault();

                                togglePasswordVisibility();

                            }

                        }
                    );

                }


                /* ======================================================
                   LOGIN FORM
                ====================================================== */

                const loginForm =
                    document.getElementById('loginForm');

                const loginButton =
                    document.getElementById('loginButton');

                const loginButtonText =
                    document.getElementById('loginButtonText');


                if (
                    loginForm &&
                    loginButton
                ) {

                    loginForm.addEventListener(
                        'submit',
                        function () {

                            loginButton.classList.add(
                                'loading'
                            );


                            loginButton.disabled = true;


                            if (loginButtonText) {

                                loginButtonText.textContent =
                                    'Signing In...';

                            }

                        }
                    );

                }

            }
        );

    </script>


</body>

</html>