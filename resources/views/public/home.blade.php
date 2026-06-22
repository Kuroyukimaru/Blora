<!DOCTYPE html>
<html lang="id">

<head>

    <!-- META -->
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <!-- TITLE -->
    <title>
        Noyo Gimbal | Tourism of Blora
    </title>

    <!-- DESCRIPTION -->
    <meta name="description"
          content="Wisata alam dan budaya khas Blora dengan pengalaman modern, tenang, dan berkesan.">

    <!-- THEME -->
    <meta name="theme-color"
          content="#0a0a0a">

    <!-- FAVICON -->
    <link rel="icon"
          href="{{ asset('favicon.ico') }}">

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

<body>

    <!-- LOADER -->
    <div class="travel-loader"></div>

    <!-- WRAPPER -->
    <main class="travel-wrapper">

        <!-- NAVBAR -->
        @include('public.partials.navbar')

        <!-- HERO -->
        @include('public.partials.hero')

        <!-- ABOUT -->
        @include('public.partials.about')

        <!-- PAKET MAKAN -->
        @include('public.partials.paketmakan')

        <!-- TIKET WAHANA -->
        @include('public.partials.tiketwahana')

        <!-- ULASAN -->
        @include('public.partials.ulasan')

        <!-- FOOTER -->
        @include('public.partials.footer')

    </main>

    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>