<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>

        Admin Login

    </title>

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- VITE -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="login-body">

    <!-- BLUR -->
    <div class="blur-circle blur-1"></div>
    <div class="blur-circle blur-2"></div>

    <!-- LOGIN CONTAINER -->
    <div class="login-wrapper">

        <!-- LEFT -->
        <div class="login-left">

            <!-- LOGO -->
            <div class="login-logo">

                NOYO GIMBAL

            </div>

            <!-- CONTENT -->
            <div class="login-content">

                <span class="login-subtitle">

                    ADMIN PANEL

                </span>

                <h1>

                    Welcome Back

                </h1>

                <p>

                    Login untuk mengakses dashboard admin
                    dan mengelola seluruh sistem Noyo Gimbal.

                </p>

            </div>

            <!-- ERROR -->
            @if(session('error'))

                <div class="login-alert">

                    <i class="fas fa-circle-exclamation"></i>

                    <span>

                        {{ session('error') }}

                    </span>

                </div>

            @endif

            <!-- FORM -->
            <form action="/admin/login"
                  method="POST"
                  class="login-form">

                @csrf

                <!-- EMAIL -->
                <div class="form-group">

                    <label>

                        Email

                    </label>

                    <div class="input-custom">

                        <i class="fas fa-envelope"></i>

                        <input type="email"
                               name="email"
                               placeholder="example@gmail.com"
                               required>

                    </div>

                </div>

                <!-- PASSWORD -->
                <div class="form-group">

                    <label>

                        Password

                    </label>

                    <div class="input-custom">

                        <i class="fas fa-lock"></i>

                        <input type="password"
                               name="password"
                               placeholder="••••••••"
                               required>

                    </div>

                </div>

                <!-- OPTIONS -->
                <div class="login-options">

                    <label class="remember-box">

                        <input type="checkbox">

                        <span>

                            Remember me

                        </span>

                    </label>

                    <a href="#">

                        Forgot password?

                    </a>

                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="btn-primary-travel login-btn">

                    <i class="fas fa-right-to-bracket"></i>

                    Sign In

                </button>

            </form>

        </div>

        <!-- RIGHT -->
        <div class="login-right">

            <div class="image-wrapper">

                <img src="{{ asset('images/noyo2.jpg') }}"
                     alt="Noyo Gimbal">

                <div class="image-overlay"></div>

            </div>

            <!-- TEXT -->
            <div class="right-content">

                <h2>

                    Elegant Admin Dashboard

                </h2>

                <p>

                    Modern dashboard experience
                    with elegant dark gold design.

                </p>

            </div>

        </div>

    </div>

</body>

</html>

<style>

/*
|--------------------------------------------------------------------------
| BODY
|--------------------------------------------------------------------------
*/

.login-body{

    min-height:100vh;

    display:flex;

    align-items:center;

    justify-content:center;

    background:var(--bg-primary);

    overflow:hidden;

    position:relative;

    padding:30px;
}

/*
|--------------------------------------------------------------------------
| BLUR
|--------------------------------------------------------------------------
*/

.blur-circle{

    position:absolute;

    border-radius:50%;

    filter:blur(120px);

    opacity:.18;
}

.blur-1{

    width:320px;

    height:320px;

    background:var(--accent);

    top:-120px;

    left:-120px;
}

.blur-2{

    width:420px;

    height:420px;

    background:var(--accent-dark);

    bottom:-180px;

    right:-180px;
}

/*
|--------------------------------------------------------------------------
| WRAPPER
|--------------------------------------------------------------------------
*/

.login-wrapper{

    width:100%;

    max-width:1350px;

    min-height:760px;

    display:grid;

    grid-template-columns:1fr 1fr;

    background:rgba(255,255,255,.03);

    border:1px solid var(--border-soft);

    border-radius:40px;

    overflow:hidden;

    backdrop-filter:blur(30px);

    box-shadow:var(--shadow-soft);

    position:relative;

    z-index:2;
}

/*
|--------------------------------------------------------------------------
| LEFT
|--------------------------------------------------------------------------
*/

.login-left{

    padding:70px;

    display:flex;

    flex-direction:column;

    justify-content:center;

    position:relative;
}

/*
|--------------------------------------------------------------------------
| LOGO
|--------------------------------------------------------------------------
*/

.login-logo{

    position:absolute;

    top:40px;

    left:50px;

    color:var(--text-primary);

    font-size:28px;

    font-weight:900;

    letter-spacing:1px;
}

/*
|--------------------------------------------------------------------------
| CONTENT
|--------------------------------------------------------------------------
*/

.login-content{

    margin-bottom:40px;
}

.login-subtitle{

    color:var(--accent);

    font-size:13px;

    letter-spacing:4px;

    font-weight:700;
}

.login-content h1{

    font-size:72px;

    line-height:1;

    margin:18px 0;

    font-weight:900;

    color:var(--text-primary);
}

.login-content p{

    max-width:520px;

    color:var(--text-secondary);

    line-height:1.9;
}

/*
|--------------------------------------------------------------------------
| ALERT
|--------------------------------------------------------------------------
*/

.login-alert{

    display:flex;

    align-items:center;

    gap:12px;

    margin-bottom:28px;

    padding:18px 22px;

    border-radius:20px;

    background:rgba(220,53,69,.08);

    border:1px solid rgba(220,53,69,.18);

    color:#ff9ca7;
}

/*
|--------------------------------------------------------------------------
| FORM
|--------------------------------------------------------------------------
*/

.login-form{

    max-width:480px;
}

.form-group{

    margin-bottom:24px;
}

.form-group label{

    display:block;

    margin-bottom:12px;

    color:var(--text-primary);

    font-weight:600;
}

/*
|--------------------------------------------------------------------------
| INPUT
|--------------------------------------------------------------------------
*/

.input-custom{

    height:62px;

    display:flex;

    align-items:center;

    gap:14px;

    padding:0 22px;

    border-radius:22px;

    background:rgba(255,255,255,.03);

    border:1px solid var(--border-soft);

    transition:all var(--transition);
}

.input-custom:focus-within{

    border-color:var(--border-gold);

    box-shadow:
        0 0 0 4px rgba(226,201,151,.08);
}

.input-custom i{

    color:var(--accent);

    font-size:16px;
}

.input-custom input{

    width:100%;

    border:none;

    background:transparent;

    outline:none;

    color:var(--text-primary);

    font-size:15px;
}

.input-custom input::placeholder{

    color:var(--text-dim);
}

/*
|--------------------------------------------------------------------------
| OPTIONS
|--------------------------------------------------------------------------
*/

.login-options{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin-bottom:34px;
}

.remember-box{

    display:flex;

    align-items:center;

    gap:10px;

    color:var(--text-secondary);

    font-size:14px;
}

.login-options a{

    color:var(--accent);

    text-decoration:none;

    font-size:14px;
}

/*
|--------------------------------------------------------------------------
| BUTTON
|--------------------------------------------------------------------------
*/

.login-btn{

    width:100%;

    height:62px;

    border:none;

    cursor:pointer;

    gap:12px;
}

/*
|--------------------------------------------------------------------------
| RIGHT
|--------------------------------------------------------------------------
*/

.login-right{

    position:relative;

    padding:40px;
}

/*
|--------------------------------------------------------------------------
| IMAGE
|--------------------------------------------------------------------------
*/

.image-wrapper{

    width:100%;

    height:100%;

    border-radius:32px;

    overflow:hidden;

    position:relative;
}

.image-wrapper img{

    width:100%;

    height:100%;

    object-fit:cover;

    transition:1s;
}

.image-wrapper:hover img{

    transform:scale(1.05);
}

.image-overlay{

    position:absolute;

    inset:0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,.75),
            rgba(0,0,0,.1)
        );
}

/*
|--------------------------------------------------------------------------
| RIGHT CONTENT
|--------------------------------------------------------------------------
*/

.right-content{

    position:absolute;

    bottom:80px;

    left:80px;

    z-index:5;
}

.right-content h2{

    font-size:46px;

    margin-bottom:14px;

    font-weight:800;

    color:var(--white);
}

.right-content p{

    max-width:420px;

    line-height:1.9;

    color:rgba(255,255,255,.72);
}

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media(max-width:1100px){

    .login-wrapper{

        grid-template-columns:1fr;
    }

    .login-right{

        display:none;
    }

    .login-left{

        padding:100px 35px 40px;
    }

    .login-content h1{

        font-size:52px;
    }

}

</style>