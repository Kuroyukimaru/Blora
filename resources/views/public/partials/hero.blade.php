<!-- HERO -->
<section id="home"
         class="position-relative vh-100 overflow-hidden d-flex align-items-center hero-travel">

    <!-- VIDEO BACKGROUND -->
    <video autoplay
           muted
           loop
           playsinline
           class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">

        <source src="{{ asset('video/noyo.mp4') }}"
                type="video/mp4">

    </video>

    <!-- DARK OVERLAY -->
    <div class="position-absolute top-0 start-0 w-100 h-100"
         style="
            background:
                linear-gradient(
                    to bottom,
                    rgba(0,0,0,.35),
                    rgba(0,0,0,.82)
                );
            z-index:1;
         ">
    </div>

    <!-- GRADIENT LIGHT -->
    <div class="position-absolute top-0 start-0 w-100 h-100"
         style="
            background:
                radial-gradient(
                    circle at top right,
                    rgba(216,185,138,.18),
                    transparent 35%
                );
            z-index:2;
         ">
    </div>

    <!-- CONTENT -->
    <div class="container-custom position-relative"
         style="z-index:5;">

        <div class="hero-content text-center mx-auto">

            <!-- SUBTITLE -->
            <span class="d-inline-block mb-4 fw-semibold"
                  style="
                    color:var(--accent);
                    letter-spacing:5px;
                    font-size:14px;
                  ">

                WISATA ALAM • BLORA

            </span>

            <!-- TITLE -->
            <h1 class="fw-black text-uppercase lh-1 mb-4"
                style="
                    font-size:clamp(60px,10vw,130px);
                    color:var(--text-primary);
                    font-weight:900;
                 ">

                Explore
                <span style="color:var(--accent);">

                    Noyo Gimbal

                </span>

            </h1>

            <!-- DESCRIPTION -->
            <p class="mx-auto"
               style="
                    max-width:760px;
                    color:var(--text-secondary);
                    line-height:2;
                    font-size:18px;
                ">

                Nikmati keindahan alam, budaya lokal,
                dan suasana khas Blora dalam pengalaman
                wisata yang modern, tenang, dan berkesan.

            </p>

        </div>

    </div>

    <!-- SCROLL INDICATOR -->
    <div class="position-absolute start-50 translate-middle-x"
         style="
            bottom:35px;
            z-index:10;
         ">

        <div style="
                width:2px;
                height:70px;
                background:
                    linear-gradient(
                        transparent,
                        var(--accent)
                    );
                animation:scrollDown 2s infinite;
             ">
        </div>

    </div>

</section>

<style>

    @keyframes scrollDown{

        0%{
            opacity:0;
            transform:translateY(-10px);
        }

        50%{
            opacity:1;
        }

        100%{
            opacity:0;
            transform:translateY(10px);
        }

    }

</style>