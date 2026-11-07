<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @hasSection('title')
            @yield('title') - Noyo Gimbal
        @else
            Noyo Gimbal
        @endif
    </title>

    <meta
        name="description"
        content="@yield('description', 'Noyo Gimbal - Wisata dan Kuliner Blora')"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')

    <style>

        :root {
            --ng-bg: #090909;
            --ng-bg-soft: #111111;
            --ng-card: #151515;
            --ng-card-hover: #1b1b1b;
            --ng-border: rgba(255, 255, 255, 0.10);
            --ng-border-soft: rgba(255, 255, 255, 0.06);
            --ng-white: #ffffff;
            --ng-text: #eeeeee;
            --ng-muted: #999999;
            --ng-muted-2: #707070;
            --ng-accent: #d8a85d;
            --ng-accent-light: #edc98e;
            --ng-radius: 22px;
            --ng-container: 1240px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            padding: 0;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(216, 168, 93, 0.07),
                    transparent 30%
                ),
                var(--ng-bg);

            color: var(--ng-text);

            font-family: 'Poppins', sans-serif;

            min-height: 100vh;

            overflow-x: hidden;
        }

        body,
        button,
        input,
        select,
        textarea {
            font-family: 'Poppins', sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            display: block;
            max-width: 100%;
        }

        button {
            border: 0;
        }

        .public-container {
            width: min(
                calc(100% - 48px),
                var(--ng-container)
            );

            margin-inline: auto;
        }

        .public-page {
            min-height: 70vh;
        }

        .public-muted {
            color: var(--ng-muted);
        }

        .public-surface {
            background: var(--ng-card);
            border: 1px solid var(--ng-border-soft);
            border-radius: var(--ng-radius);
        }

        .public-section {
            padding: 100px 0;
        }

        .public-section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 30px;

            margin-bottom: 40px;
        }

        .public-section-heading {
            max-width: 720px;
        }

        .public-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;

            margin-bottom: 14px;

            color: var(--ng-accent);

            font-size: 12px;
            font-weight: 600;

            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .public-eyebrow::before {
            content: '';

            width: 30px;
            height: 1px;

            background: var(--ng-accent);
        }

        .public-section-title {
            margin: 0;

            color: var(--ng-white);

            font-family: 'Playfair Display', serif;

            font-size: clamp(32px, 4vw, 52px);
            line-height: 1.08;
            font-weight: 700;
        }

        .public-section-description {
            margin: 16px 0 0;

            max-width: 680px;

            color: var(--ng-muted);

            font-size: 15px;
            line-height: 1.8;
        }

        .public-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            min-height: 48px;

            padding: 0 22px;

            border-radius: 999px;

            background: var(--ng-white);
            color: #111111;

            font-size: 13px;
            font-weight: 600;

            transition:
                transform .25s ease,
                background .25s ease,
                color .25s ease;
        }

        .public-button:hover {
            transform: translateY(-2px);

            background: var(--ng-accent);
            color: #111111;
        }

        .public-button-outline {
            background: transparent;
            color: var(--ng-white);

            border: 1px solid rgba(255, 255, 255, .20);
        }

        .public-button-outline:hover {
            background: rgba(255, 255, 255, .08);
            color: var(--ng-white);
        }

        .public-grid {
            display: grid;
            gap: 24px;
        }

        .public-grid-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .public-grid-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .public-grid-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .public-empty {
            padding: 70px 30px;

            text-align: center;

            border: 1px dashed rgba(255, 255, 255, .12);
            border-radius: var(--ng-radius);

            background: rgba(255, 255, 255, .02);
        }

        .public-empty-title {
            margin: 0 0 8px;

            color: var(--ng-white);

            font-family: 'Playfair Display', serif;
            font-size: 28px;
        }

        .public-empty-text {
            margin: 0;

            color: var(--ng-muted);

            font-size: 14px;
        }


        /* =========================================================
           FOCUS
        ========================================================= */

        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 2px solid var(--ng-accent);
            outline-offset: 4px;
        }


        /* =========================================================
           SCROLLBAR
        ========================================================= */

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #090909;
        }

        ::-webkit-scrollbar-thumb {
            background: #333333;
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555555;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1100px) {

            .public-grid-4 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

        }

        @media (max-width: 800px) {

            .public-container {
                width: min(
                    calc(100% - 32px),
                    var(--ng-container)
                );
            }

            .public-section {
                padding: 75px 0;
            }

            .public-section-header {
                display: block;
            }

            .public-section-header .public-button {
                margin-top: 24px;
            }

            .public-grid-3 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

        }

        @media (max-width: 600px) {

            .public-container {
                width: calc(100% - 28px);
            }

            .public-grid-4,
            .public-grid-3,
            .public-grid-2 {
                grid-template-columns: 1fr;
            }

            .public-section {
                padding: 60px 0;
            }

            .public-section-title {
                font-size: 34px;
            }

        }

    </style>

</head>

<body>

    @include('public.components.navbar')

    <main
        id="public-main"
        class="public-page"
    >
        @yield('content')
    </main>

    @include('public.components.footer')

    @stack('scripts')


    <script>

        document.addEventListener('error', function (event) {

            const element = event.target;

            if (
                element &&
                element.tagName === 'IMG'
            ) {

                const fallback =
                    element.dataset.fallback ||
                    "{{ asset('images/no-image.png') }}";

                if (
                    element.src !== fallback &&
                    !element.dataset.fallbackUsed
                ) {

                    element.dataset.fallbackUsed = 'true';

                    element.src = fallback;

                }

            }

        }, true);

    </script>

</body>
</html>