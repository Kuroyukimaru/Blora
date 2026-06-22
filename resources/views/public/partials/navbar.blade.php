<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top navbar-travel">

    <div class="container-custom navbar-container">

        <!-- LOGO -->
        <a href="/"
           class="travel-logo">

            NOYO GIMBAL

        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#travel-nav"
                aria-controls="travel-nav"
                aria-expanded="false"
                aria-label="Toggle navigation">

            <i class="fas fa-bars-staggered"></i>

        </button>

        <!-- COLLAPSE -->
        <div class="collapse navbar-collapse justify-content-end"
             id="travel-nav">

            <!-- MENU -->
            <ul class="navbar-nav align-items-lg-center travel-menu">

                <!-- HOME -->
                <li class="nav-item">

                    <a href="/#home"
                       class="travel-link active">

                        Home

                    </a>

                </li>

                <!-- ABOUT -->
                <li class="nav-item">

                    <a href="/#about"
                       class="travel-link">

                        About

                    </a>

                </li>

                <!-- PAKET MAKAN -->
                <li class="nav-item">

                    <a href="/#paket-makan"
                       class="travel-link">

                        Paket Makan

                    </a>

                </li>

                <!-- TIKET WAHANA -->
<li class="nav-item">

    <a href="/#tiket-wahana"
       class="travel-link">

        Tiket Wahana

    </a>

</li>

                <!-- ULASAN -->
                <li class="nav-item">

                    <a href="/#ulasan"
                       class="travel-link">

                        Ulasan

                    </a>

                </li>



                <!-- BUTTON -->
                <li class="nav-item">

                    <a href="https://wa.me/6281234567890"
                       target="_blank"
                       class="btn-primary-travel navbar-btn">

                        Booking Now

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>

<style>

/* =========================
   NAVBAR
========================= */

.navbar-travel{

    padding:24px 0;

    background:transparent;

    transition:all var(--transition);

    z-index:999;
}

.navbar-travel.scrolled{

    background:
        rgba(10,10,10,.82);

    backdrop-filter:
        blur(18px);

    border-bottom:
        1px solid var(--border-soft);
}

/* CONTAINER */

.navbar-container{

    display:flex;

    align-items:center;

    justify-content:space-between;
}

/* LOGO */

.travel-logo{

    color:var(--text-primary);

    text-decoration:none;

    font-size:28px;

    font-weight:900;

    letter-spacing:1px;

    transition:all var(--transition);
}

.travel-logo:hover{

    color:var(--accent);
}

/* MENU */

.travel-menu{

    display:flex;

    align-items:center;

    gap:34px;
}

/* LINK */

.travel-link{

    position:relative;

    color:var(--text-secondary);

    text-decoration:none;

    font-size:14px;

    font-weight:600;

    letter-spacing:.5px;

    transition:all var(--transition);
}

.travel-link:hover,
.travel-link.active{

    color:var(--text-primary);
}

.travel-link::after{

    content:'';

    position:absolute;

    left:0;

    bottom:-8px;

    width:0%;

    height:2px;

    border-radius:999px;

    background:var(--accent);

    transition:all var(--transition);
}

.travel-link:hover::after,
.travel-link.active::after{

    width:100%;
}

/* BUTTON */

.navbar-btn{

    margin-left:10px;

    padding:14px 28px !important;

    font-size:14px !important;
}

/* TOGGLER */

.navbar-toggler{

    display:none;
}

.navbar-toggler:focus{

    box-shadow:none;
}

.navbar-toggler i{

    color:var(--text-primary);

    font-size:22px;
}

/* MOBILE */

@media(max-width:991px){

    .navbar-toggler{

        display:block;
    }

    .navbar-collapse{

        background:
            rgba(10,10,10,.96);

        padding:30px;

        border-radius:24px;

        margin-top:20px;

        border:
            1px solid var(--border-soft);
    }

    .travel-menu{

        flex-direction:column;

        align-items:flex-start;

        gap:22px;

        margin-top:20px;
    }

    .navbar-btn{

        margin-left:0;

        margin-top:10px;
    }

}

</style>