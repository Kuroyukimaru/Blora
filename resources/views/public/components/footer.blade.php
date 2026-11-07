{{-- ============================================================
     NOYO GIMBAL
     PUBLIC FOOTER
     MODERN / ELEGANT / ACCESSIBLE
     DARK CHARCOAL + CHAMPAGNE GOLD
     ============================================================ --}}

<footer class="public-footer" aria-label="Footer Noyo Gimbal">

    <div class="footer-shell">

        <div class="footer-main">

            {{-- BRAND --}}
            <div class="footer-brand">
                <a
                    href="{{ route('public.home') }}"
                    class="footer-logo"
                    aria-label="Kembali ke halaman utama Noyo Gimbal"
                >
                    <span class="footer-logo-mark">NG</span>

                    <span class="footer-logo-text">
                        <strong class="footer-logo-name">Noyo Gimbal</strong>
                        <span class="footer-logo-tagline">Wisata &amp; Kuliner Blora</span>
                    </span>
                </a>

                <p class="footer-description">
                    Temukan berbagai pilihan kuliner, wahana, oleh-oleh,
                    paket bundling, dan event menarik di Noyo Gimbal.
                </p>

                <a
                    href="{{ route('public.home') }}"
                    class="footer-home-button"
                >
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

            {{-- JELAJAHI --}}
            <div class="footer-column">
                <h2 class="footer-heading">Jelajahi</h2>

                <ul class="footer-links">
                    <li>
                        <a href="{{ route('public.home') }}">
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.menu.index') }}">
                            <span>Menu</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.tiket-wahana.index') }}">
                            <span>Wahana</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.oleholeh.index') }}">
                            <span>Oleh-Oleh</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.paketbundling.index') }}">
                            <span>Paket Bundling</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.event.index') }}">
                            <span>Event</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- INFORMASI --}}
            <div class="footer-column">
                <h2 class="footer-heading">Informasi</h2>

                <ul class="footer-links">
                    <li>
                        <a href="{{ route('public.menu.index') }}">
                            <span>Pilihan Menu</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.tiket-wahana.index') }}">
                            <span>Tiket Wahana</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.paketbundling.index') }}">
                            <span>Paket Pilihan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.event.index') }}">
                            <span>Agenda Event</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        {{-- SMALL BRAND ORNAMENT --}}
        <div class="footer-ornament" aria-hidden="true">
            <span></span>
            <strong>NG</strong>
            <span></span>
        </div>

        {{-- BOTTOM --}}
        <div class="footer-bottom">
            <p class="footer-copyright">
                © {{ date('Y') }} Noyo Gimbal. All rights reserved.
            </p>

            <p class="footer-bottom-note">
                Dibuat untuk pengalaman wisata yang lebih mudah.
            </p>
        </div>

    </div>
</footer>

<style>
/* ============================================================
   NOYO GIMBAL — MODERN FOOTER
   DARK CHARCOAL + CHAMPAGNE GOLD
   Nyaman untuk desktop, laptop, tablet, dan HP
   Ukuran teks dibuat ramah pengguna termasuk orang tua
   ============================================================ */

.public-footer {
    --footer-bg: #0a0a0a;
    --footer-surface: #121212;
    --footer-surface-soft: #151515;
    --footer-text: #f8f4ed;
    --footer-secondary: #d4c9b5;
    --footer-muted: #a89988;
    --footer-dim: #7a6f62;
    --footer-gold: #e2c997;
    --footer-gold-hover: #d4b384;
    --footer-gold-dark: #b89a6e;
    --footer-border: rgba(255,255,255,.07);
    --footer-border-gold: rgba(226,201,151,.16);
    --footer-shadow: 0 20px 60px rgba(0,0,0,.38);
    --footer-radius-lg: 28px;
    --footer-radius-md: 18px;
    --footer-radius-full: 999px;
    --footer-transition: .25s cubic-bezier(.4,0,.2,1);

    position: relative;
    width: 100%;
    margin-top: clamp(48px, 7vw, 88px);
    background:
        radial-gradient(circle at 82% 12%, rgba(226,201,151,.075), transparent 26%),
        radial-gradient(circle at 8% 85%, rgba(226,201,151,.035), transparent 24%),
        var(--footer-bg);
    color: var(--footer-text);
    overflow: hidden;
    isolation: isolate;
}

.public-footer::before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: min(460px, 45vw);
    height: min(460px, 45vw);
    border-radius: 50%;
    background: rgba(226,201,151,.025);
    filter: blur(50px);
    pointer-events: none;
    z-index: -1;
}

.public-footer .footer-shell {
    width: min(1280px, calc(100% - 64px));
    margin-inline: auto;
}

.footer-main {
    display: grid;
    grid-template-columns: minmax(0, 1.45fr) minmax(190px, .75fr) minmax(190px, .75fr);
    gap: clamp(40px, 6vw, 88px);
    padding: clamp(64px, 8vw, 96px) 0 clamp(48px, 6vw, 72px);
}

.footer-brand,
.footer-column {
    min-width: 0;
}

.footer-brand {
    max-width: 560px;
}

.footer-logo {
    display: inline-flex;
    align-items: center;
    gap: 14px;
    color: var(--footer-text);
    text-decoration: none;
    border-radius: var(--footer-radius-md);
}

.footer-logo-mark {
    width: 56px;
    height: 56px;
    display: grid;
    place-items: center;
    flex: 0 0 auto;
    border: 1px solid var(--footer-border-gold);
    border-radius: 17px;
    background: linear-gradient(145deg, rgba(226,201,151,.14), rgba(255,255,255,.025));
    color: var(--footer-gold);
    font-family: "Playfair Display", Georgia, serif;
    font-size: 18px;
    font-weight: 700;
    letter-spacing: .04em;
    box-shadow: inset 0 0 22px rgba(226,201,151,.025), 0 10px 28px rgba(0,0,0,.24);
    transition: transform var(--footer-transition), border-color var(--footer-transition), background var(--footer-transition);
}

.footer-logo:hover .footer-logo-mark,
.footer-logo:focus-visible .footer-logo-mark {
    transform: translateY(-2px);
    border-color: rgba(226,201,151,.48);
    background: linear-gradient(145deg, rgba(226,201,151,.20), rgba(226,201,151,.04));
}

.footer-logo:focus-visible,
.footer-links a:focus-visible,
.footer-home-button:focus-visible {
    outline: 3px solid rgba(226,201,151,.48);
    outline-offset: 4px;
}

.footer-logo-text {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.footer-logo-name {
    color: var(--footer-text);
    font-family: "Playfair Display", Georgia, serif;
    font-size: clamp(20px, 2vw, 27px);
    font-weight: 600;
    line-height: 1.1;
    letter-spacing: -.02em;
}

.footer-logo-tagline {
    margin-top: 5px;
    color: var(--footer-gold-dark);
    font-size: 12px;
    font-weight: 700;
    line-height: 1.3;
    letter-spacing: .11em;
    text-transform: uppercase;
}

.footer-description {
    max-width: 520px;
    margin: 24px 0 0;
    color: var(--footer-secondary);
    font-size: clamp(15px, 1.15vw, 17px);
    line-height: 1.85;
}

.footer-home-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 11px;
    min-height: 52px;
    margin-top: 24px;
    padding: 0 21px;
    border: 1px solid var(--footer-border-gold);
    border-radius: var(--footer-radius-full);
    background: rgba(226,201,151,.07);
    color: var(--footer-secondary);
    text-decoration: none;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.2;
    transition: transform var(--footer-transition), background var(--footer-transition), border-color var(--footer-transition), color var(--footer-transition), box-shadow var(--footer-transition);
}

.footer-home-button:hover {
    transform: translateY(-2px);
    background: rgba(226,201,151,.13);
    border-color: rgba(226,201,151,.34);
    color: var(--footer-gold);
    box-shadow: 0 14px 34px rgba(0,0,0,.26);
}

.footer-home-button span:last-child {
    transition: transform var(--footer-transition);
}

.footer-home-button:hover span:last-child {
    transform: translateX(4px);
}

.footer-heading {
    margin: 4px 0 22px;
    color: var(--footer-text);
    font-size: 18px;
    font-weight: 800;
    line-height: 1.3;
}

.footer-heading::after {
    content: "";
    display: block;
    width: 34px;
    height: 2px;
    margin-top: 10px;
    border-radius: var(--footer-radius-full);
    background: var(--footer-gold);
    opacity: .75;
}

.footer-links {
    display: flex;
    flex-direction: column;
    gap: 4px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.footer-links a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    min-height: 44px;
    padding: 4px 0;
    color: var(--footer-muted);
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    line-height: 1.45;
    transition: color var(--footer-transition), transform var(--footer-transition);
}

.footer-links a:hover {
    color: var(--footer-gold);
    transform: translateX(4px);
}

.footer-ornament {
    display: flex;
    align-items: center;
    gap: 18px;
    width: 100%;
}

.footer-ornament > span {
    flex: 1;
    height: 1px;
    background: rgba(226,201,151,.10);
}

.footer-ornament strong {
    width: 44px;
    height: 44px;
    display: grid;
    place-items: center;
    flex: 0 0 auto;
    border: 1px solid rgba(226,201,151,.20);
    border-radius: 50%;
    background: var(--footer-bg);
    color: var(--footer-gold-dark);
    font-family: "Playfair Display", Georgia, serif;
    font-size: 12px;
    letter-spacing: .04em;
}

.footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    padding: 22px 0 30px;
}

.footer-copyright,
.footer-bottom-note {
    margin: 0;
    font-size: 14px;
    line-height: 1.6;
}

.footer-copyright {
    color: var(--footer-dim);
}

.footer-bottom-note {
    color: var(--footer-secondary);
    text-align: right;
}

/* ============================================================
   LARGE DESKTOP
   ============================================================ */
@media (min-width: 1440px) {
    .public-footer .footer-shell {
        width: min(1320px, calc(100% - 80px));
    }

    .footer-main {
        gap: 96px;
    }
}

/* ============================================================
   LAPTOP / SMALL DESKTOP
   ============================================================ */
@media (max-width: 1180px) {
    .public-footer .footer-shell {
        width: min(1080px, calc(100% - 52px));
    }

    .footer-main {
        grid-template-columns: minmax(0, 1.25fr) minmax(170px, .8fr) minmax(170px, .8fr);
        gap: 44px;
    }
}

/* ============================================================
   TABLET LANDSCAPE
   ============================================================ */
@media (max-width: 900px) {
    .public-footer .footer-shell {
        width: min(760px, calc(100% - 40px));
    }

    .footer-main {
        grid-template-columns: 1fr 1fr;
        gap: 38px 30px;
        padding-top: 56px;
        padding-bottom: 42px;
    }

    .footer-brand {
        grid-column: 1 / -1;
        max-width: 700px;
    }

    .footer-description {
        max-width: 680px;
    }
}

/* ============================================================
   TABLET PORTRAIT / HP BESAR
   ============================================================ */
@media (max-width: 700px) {
    .public-footer {
        margin-top: 46px;
    }

    .public-footer .footer-shell {
        width: calc(100% - 30px);
    }

    .footer-main {
        grid-template-columns: 1fr 1fr;
        gap: 32px 24px;
        padding: 48px 0 38px;
    }

    .footer-brand {
        grid-column: 1 / -1;
    }

    .footer-logo-mark {
        width: 52px;
        height: 52px;
        border-radius: 16px;
    }

    .footer-logo-name {
        font-size: 23px;
    }

    .footer-logo-tagline {
        font-size: 11px;
    }

    .footer-description {
        margin-top: 21px;
        font-size: 15.5px;
        line-height: 1.8;
    }

    .footer-home-button {
        min-height: 52px;
        font-size: 15px;
    }

    .footer-heading {
        font-size: 17px;
        margin-bottom: 19px;
    }

    .footer-links a {
        min-height: 45px;
        font-size: 15px;
    }

    .footer-bottom {
        align-items: flex-start;
        flex-direction: column;
        gap: 7px;
        padding: 20px 0 26px;
    }

    .footer-copyright,
    .footer-bottom-note {
        font-size: 13.5px;
        text-align: left;
    }
}

/* ============================================================
   HP 430 / 414 / 400
   ============================================================ */
@media (max-width: 430px) {
    .public-footer .footer-shell {
        width: calc(100% - 24px);
    }

    .footer-main {
        grid-template-columns: 1fr;
        gap: 29px;
        padding: 42px 0 34px;
    }

    .footer-brand {
        grid-column: auto;
    }

    .footer-logo {
        gap: 12px;
    }

    .footer-logo-mark {
        width: 50px;
        height: 50px;
    }

    .footer-logo-name {
        font-size: 22px;
    }

    .footer-description {
        font-size: 15px;
    }

    .footer-home-button {
        width: 100%;
    }

    .footer-heading {
        margin-bottom: 17px;
    }

    .footer-links a {
        min-height: 46px;
        padding: 4px 0;
        font-size: 15px;
    }

    .footer-ornament {
        gap: 12px;
    }

    .footer-ornament strong {
        width: 40px;
        height: 40px;
    }
}

/* ============================================================
   HP KECIL
   ============================================================ */
@media (max-width: 360px) {
    .public-footer .footer-shell {
        width: calc(100% - 20px);
    }

    .footer-main {
        gap: 27px;
        padding-top: 38px;
    }

    .footer-logo-mark {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        font-size: 16px;
    }

    .footer-logo-name {
        font-size: 20px;
    }

    .footer-logo-tagline {
        font-size: 10px;
    }

    .footer-description {
        font-size: 14px;
    }

    .footer-links a {
        font-size: 14px;
    }

    .footer-copyright,
    .footer-bottom-note {
        font-size: 13px;
    }
}

@media (hover: none) {
    .footer-links a:hover,
    .footer-home-button:hover,
    .footer-logo:hover .footer-logo-mark {
        transform: none;
    }
}

@media (prefers-reduced-motion: reduce) {
    .public-footer *,
    .public-footer *::before,
    .public-footer *::after {
        scroll-behavior: auto !important;
        transition-duration: .01ms !important;
        animation-duration: .01ms !important;
        animation-iteration-count: 1 !important;
    }
}
</style>
