<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">

    <!-- Primary Meta Tags -->
    <title>
        @yield('title', $siteSettings->where('key', 'site-title')->first()->value ?? 'Tenecho')@hasSection('title')
            - {{ $siteSettings->where('key', 'site-title')->first()->value ?? 'Tenecho' }}
        @endif
    </title>
    <meta name="description" content="@yield('meta_description', $siteSettings->where('key', 'site-description')->first()->value ?? 'Technology moves fast. We keep you faster.')">
    <meta name="keywords" content="@yield('meta_keywords', 'Tenecho, Technologies, news, ai')">
    <meta name="author" content="Tenecho Team">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('meta_og_type', 'website')">
    <meta property="og:url" content="@yield('meta_og_url', url()->current())">
    <meta property="og:title" content="@yield('title', $siteSettings->where('key', 'site-title')->first()->value ?? 'Tenecho')@hasSection('title') - {{ $siteSettings->where('key', 'site-title')->first()->value ?? 'Tenecho' }}@endif">
    <meta property="og:description" content="@yield('meta_description', $siteSettings->where('key', 'site-description')->first()->value ?? 'Technology moves fast. We keep you faster.')">
    <meta property="og:image" content="@yield('meta_og_image', asset('images/tenecho-og-image.png'))">
    <meta property="og:site_name" content="@yield('meta_og_site_name', 'Tenecho')">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="@yield('meta_twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('title', $siteSettings->where('key', 'site-title')->first()->value ?? 'Tenecho')@hasSection('title') - {{ $siteSettings->where('key', 'site-title')->first()->value ?? 'Tenecho' }}@endif">
    <meta name="twitter:description" content="@yield('meta_description', $siteSettings->where('key', 'site-description')->first()->value ?? 'Technology moves fast. We keep you faster.')">
    <meta name="twitter:image" content="@yield('meta_og_image', asset('images/tenecho-og-image.png'))">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @yield('content')
</body>

</html>
