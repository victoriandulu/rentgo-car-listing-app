<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ── SEO (pages can override with @section('title'), @section('meta_description'), etc.) ── --}}
    <title>@yield('title', 'WeSellGaris | Buy & Import Quality Used Cars in Kenya')</title>
    <meta name="description" content="@yield('meta_description', 'Buy quality used cars in Kenya with WeSellGaris. Browse verified local cars and imports from Japan, South Africa and Dubai, with transparent pricing, documentation and ongoing support.')">
    <meta name="keywords" content="@yield('meta_keywords', 'cars for sale Kenya, used cars Kenya, car imports Kenya, buy car Nairobi, sell my car Kenya, Toyota Prado Kenya, WeSellGaris')">
    <meta name="author" content="WeSellGaris">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large')">
    <meta name="theme-color" content="#3A2920">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph (Facebook, WhatsApp, LinkedIn) --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="WeSellGaris">
    <meta property="og:locale" content="en_KE">
    <meta property="og:title" content="@yield('title', 'WeSellGaris | Buy & Import Quality Used Cars in Kenya')">
    <meta property="og:description" content="@yield('meta_description', 'Quality cars. Fair prices. Delivered to you. Browse verified local cars and imports from Japan, South Africa and Dubai.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">
    <meta property="og:image:alt" content="WeSellGaris logo">

    {{-- Twitter / X --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'WeSellGaris | Buy & Import Quality Used Cars in Kenya')">
    <meta name="twitter:description" content="@yield('meta_description', 'Quality cars. Fair prices. Delivered to you.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo.png'))">

    {{-- Logo / favicon (browser tab icon) --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}?v=1">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    {{-- Structured data: tells Google who you are (shows logo + business info in search) --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context'    => 'https://schema.org',
        '@type'       => 'AutoDealer',
        'name'        => 'WeSellGaris',
        'url'         => url('/'),
        'logo'        => asset('images/logo.png'),
        'image'       => asset('images/logo.png'),
        'description' => 'Quality used cars in Kenya, including imports from Japan, South Africa and Dubai.',
        'areaServed'  => 'KE',
        'slogan'      => 'Quality cars. Fair prices. Delivered to you.',
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}
    </script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Page-specific head content (fonts, extra meta, JSON-LD) pushed from views via @push('head') --}}
    @stack('head')
</head>
<body>
    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Optional page scripts via @push('scripts') --}}
    @stack('scripts')
</body>
</html>
