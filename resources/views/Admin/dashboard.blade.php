<!DOCTYPE html>
<html lang="id">

<head>

    <!-- META -->
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <!-- TITLE -->
    <title>

        Dashboard Admin

    </title>

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- VITE -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body style="background:var(--bg-primary);">

    <!-- SIDEBAR -->
    @include('admin.partials.sidebar')

    <!-- MAIN -->
    <main class="admin-main">

        <!-- TOPBAR -->
        <div class="d-flex justify-content-between
                    align-items-center
                    flex-wrap
                    gap-4
                    mb-5">

            <!-- LEFT -->
            <div>

                <span class="dashboard-subtitle">

                    ADMIN PANEL

                </span>

                <h1 class="dashboard-title">

                    Dashboard

                </h1>

                <p class="dashboard-desc">

                    Selamat datang kembali,
                    {{ auth('admin')->user()->name }}

                </p>

            </div>

            <!-- PROFILE -->
            <div class="glass-effect d-flex align-items-center gap-3 px-4 py-3 rounded-pill">

                <!-- ICON -->
                <div class="profile-icon">

                    <i class="fas fa-user"></i>

                </div>

                <!-- NAME -->
                <div>

                    <h6 class="m-0 fw-semibold">

                        {{ auth('admin')->user()->name }}

                    </h6>

                    <small style="color:var(--text-muted);">

                        Administrator

                    </small>

                </div>

            </div>

        </div>

        <!-- STATS -->
        <div class="row g-4">

            <!-- CARD -->
            <div class="col-lg-4">

                <div class="dashboard-card">

                    <!-- ICON -->
                    <div class="dashboard-card-icon">

                        <i class="fas fa-utensils"></i>

                    </div>

                    <!-- CONTENT -->
                    <div>

                        <p class="dashboard-card-label">

                            Total Menu

                        </p>

                        <h2 class="dashboard-card-value">

                            12

                        </h2>

                    </div>

                </div>

            </div>

            <!-- CARD -->
            <div class="col-lg-4">

                <div class="dashboard-card">

                    <!-- ICON -->
                    <div class="dashboard-card-icon">

                        <i class="fas fa-wallet"></i>

                    </div>

                    <!-- CONTENT -->
                    <div>

                        <p class="dashboard-card-label">

                            Pembayaran

                        </p>

                        <h2 class="dashboard-card-value">

                            8

                        </h2>

                    </div>

                </div>

            </div>

            <!-- CARD -->
            <div class="col-lg-4">

                <div class="dashboard-card">

                    <!-- ICON -->
                    <div class="dashboard-card-icon">

                        <i class="fas fa-star"></i>

                    </div>

                    <!-- CONTENT -->
                    <div>

                        <p class="dashboard-card-label">

                            Total Ulasan

                        </p>

                        <h2 class="dashboard-card-value">

                            120

                        </h2>

                    </div>

                </div>

            </div>

        </div>

        <!-- WELCOME SECTION -->
        <section class="glass-effect welcome-box">

            <div class="row align-items-center g-5">

                <!-- LEFT -->
                <div class="col-lg-7">

                    <span class="dashboard-subtitle">

                        NOYO GIMBAL

                    </span>

                    <h2 class="welcome-title">

                        Welcome To
                        Admin Dashboard

                    </h2>

                    <p class="welcome-desc">

                        Kelola menu makanan,
                        informasi pembayaran,
                        profile wisata,
                        dan seluruh konten website
                        Noyo Gimbal dengan tampilan
                        modern dan elegant.

                    </p>

                </div>

                <!-- RIGHT -->
                <div class="col-lg-5 text-center">

                    <div class="welcome-circle">

                        <i class="fas fa-mountain-city"></i>

                    </div>

                </div>

            </div>

        </section>

    </main>

</body>

</html>

<style>

    /*
    |--------------------------------------------------------------------------
    | MAIN
    |--------------------------------------------------------------------------
    */

    .admin-main{

        margin-left:290px;

        padding:45px;

        min-height:100vh;

    }

    /*
    |--------------------------------------------------------------------------
    | TITLE
    |--------------------------------------------------------------------------
    */

    .dashboard-subtitle{

        display:inline-block;

        margin-bottom:14px;

        color:var(--accent);

        letter-spacing:4px;

        font-size:13px;

        font-weight:700;

    }

    .dashboard-title{

        font-size:clamp(42px,5vw,72px);

        font-weight:900;

        color:var(--text-primary);

        line-height:1;

        margin-bottom:16px;

    }

    .dashboard-desc{

        color:var(--text-secondary);

        font-size:16px;

    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    .profile-icon{

        width:50px;

        height:50px;

        border-radius:50%;

        display:flex;

        align-items:center;

        justify-content:center;

        background:
            linear-gradient(
                135deg,
                var(--accent),
                var(--accent-hover)
            );

        color:var(--bg-primary);

    }

    /*
    |--------------------------------------------------------------------------
    | CARD
    |--------------------------------------------------------------------------
    */

    .dashboard-card{

        background:var(--bg-card);

        border:
            1px solid var(--border-soft);

        border-radius:30px;

        padding:34px;

        display:flex;

        align-items:center;

        gap:24px;

        transition:all var(--transition);

        height:100%;

    }

    .dashboard-card:hover{

        transform:translateY(-6px);

        box-shadow:var(--shadow-hover);

        border-color:var(--border-gold);

    }

    /*
    |--------------------------------------------------------------------------
    | CARD ICON
    |--------------------------------------------------------------------------
    */

    .dashboard-card-icon{

        width:72px;

        height:72px;

        border-radius:24px;

        display:flex;

        align-items:center;

        justify-content:center;

        background:
            linear-gradient(
                135deg,
                rgba(226,201,151,.15),
                rgba(226,201,151,.05)
            );

        color:var(--accent);

        font-size:28px;

    }

    /*
    |--------------------------------------------------------------------------
    | CARD TEXT
    |--------------------------------------------------------------------------
    */

    .dashboard-card-label{

        margin-bottom:8px;

        color:var(--text-muted);

        font-size:15px;

    }

    .dashboard-card-value{

        margin:0;

        color:var(--text-primary);

        font-size:42px;

        font-weight:900;

    }

    /*
    |--------------------------------------------------------------------------
    | WELCOME
    |--------------------------------------------------------------------------
    */

    .welcome-box{

        margin-top:40px;

        border-radius:36px;

        padding:60px;

    }

    .welcome-title{

        font-size:clamp(38px,5vw,68px);

        font-weight:900;

        line-height:1.1;

        margin-bottom:24px;

        color:var(--text-primary);

    }

    .welcome-desc{

        color:var(--text-secondary);

        line-height:2;

        max-width:650px;

    }

    /*
    |--------------------------------------------------------------------------
    | CIRCLE
    |--------------------------------------------------------------------------
    */

    .welcome-circle{

        width:260px;

        height:260px;

        margin:auto;

        border-radius:50%;

        display:flex;

        align-items:center;

        justify-content:center;

        background:
            radial-gradient(
                circle,
                rgba(226,201,151,.15),
                transparent 70%
            );

        border:
            1px solid var(--border-gold);

    }

    .welcome-circle i{

        font-size:90px;

        color:var(--accent);

    }

    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE
    |--------------------------------------------------------------------------
    */

    @media(max-width:991px){

        .admin-main{

            margin-left:0;

            padding:24px;

        }

    }

</style>