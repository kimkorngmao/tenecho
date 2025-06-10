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

<body class="min-h-screen flex flex-col bg-white">
<!-- Top utility bar -->
    <div class="bg-black text-white text-xs py-1.5 border-b border-gray-800" role="marquee" aria-label="Live updates">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-2" aria-live="polite">
                    <div class="w-2 h-2 bg-green-400 rounded-full live-indicator" aria-hidden="true"></div>
                    <span class="font-medium">LIVE</span>
                </div>
                <span class="text-gray-300">Latest Tech Updates</span>
                <time class="hidden lg:inline text-gray-400" id="live-time" datetime="{{ now()->toIso8601String() }}"></time>
            </div>
            <nav class="flex items-center space-x-6" aria-label="Utility navigation">
                <div class="hidden md:flex items-center space-x-4 text-gray-300">
                    @foreach ($siteSettings->where('key', 'nav-top') as $item)
                        <x-site-setting-item :item="$item" class="font-medium text-gray-600 hover:text-gray-300 transition-colors" />
                    @endforeach
                </div>
                @auth
                    <span class="text-gray-300">Welcome, <span class="text-white">{{ auth()->user()->username }}</span></span>
                @endauth
            </nav>
        </div>
    </div>

    <header class="sticky top-0 z-50 bg-white border-b border-gray-100" role="banner">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Top bar -->
            <div class="flex items-center justify-between h-16 border-b border-gray-100">
                <div class="hidden md:flex items-center space-x-3" aria-label="Current date and time">
                    <div class="grid grid-cols-4 gap-1">
                        <div class="date-box text-white px-2 py-1 text-center min-w-[48px]">
                            <div class="text-[10px] font-light opacity-80">{{ strtoupper(substr(date('l'), 0, 3)) }}</div>
                            <div class="text-xs font-bold">{{ date('j') }}</div>
                        </div>
                        <div class="date-box text-white px-2 py-1 text-center min-w-[48px]">
                            <div class="text-[10px] font-light opacity-80">{{ strtoupper(substr(date('F'), 0, 3)) }}</div>
                            <div class="text-xs font-bold">{{ date('Y') }}</div>
                        </div>
                        <div class="tech-accent text-white px-2 py-1 text-center min-w-[48px]">
                            <div class="text-[10px] font-light opacity-90" id="current-hour" datetime="{{ now()->toIso8601String() }}">{{ date('H') }}</div>
                            <div class="text-xs font-bold" id="current-minute" datetime="{{ now()->toIso8601String() }}">{{ date('i') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center" aria-label="Homepage">
                    <svg width="96" height="20" viewBox="0 0 96 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M96 0V20H84V0H96ZM88.5 16.129H91.5V3.87097H88.5V16.129Z" fill="#FF4242" />
                        <path d="M68 0V3.87097H60.5V16.129H68V20H56V0H68Z" fill="#2B2B2B" />
                        <path d="M74.5 0V8.12888H77.5V0H82V20H77.5V11.9998H74.5V20H70V0H74.5Z" fill="#2B2B2B" />
                        <path d="M54 0V3.87097H46.5V16.129H54V20H42V0H54ZM53 8V12H46.5V8H53Z" fill="#2B2B2B" />
                        <path d="M32.5 0L35.5 8.12888V0H40V20H35.5L32.5 11.9998V20H28V0H32.5Z" fill="#2B2B2B" />
                        <path d="M26 0V3.87097H18.5V16.129H26V20H14V0H26ZM25 8V12H18.5V8H25Z" fill="#2B2B2B" />
                        <path d="M8 0V20H3.43478V3.87097H0V0H8Z" fill="#FF4242" />
                        <path d="M12 4V0H9V4H12Z" fill="#2B2B2B" />
                    </svg>
                </a>

                <!-- Search and Actions -->
                <div class="flex items-center space-x-6">
                    <form action="{{ route('search') }}" method="GET" class="hidden md:flex items-center" role="search">
                        <label for="search-input" class="sr-only">Search</label>
                        <input type="text" id="search-input" name="query" placeholder="Search" autocomplete="off"
                            class="w-48 h-9 border-b border-gray-200 text-sm focus:outline-none focus:border-black transition-colors pl-0">
                        <button type="submit" class="ml-2 text-gray-400 hover:text-black transition-colors" aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>

                    @auth
                        @if (auth()->user()->hasPermission('admin.dashboard'))
                            <a href="{{ route('admin.dashboard') }}"
                                class="hidden lg:inline-flex text-sm border border-black px-4 py-2 hover:bg-black hover:text-white transition-colors">
                                Dashboard
                            </a>
                        @endif
                    @endauth

                    <a href="{{ route('search') }}" class="md:hidden text-gray-700 hover:text-black" aria-label="Search">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Main Navigation -->
            <nav class="h-12" aria-label="Main navigation">
                <ul class="flex items-end h-full space-x-8">
                    <li>
                        <a href="{{ route('home') }}"
                            class="@if (request()->routeIs('home')) text-black border-black @else text-gray-600 border-transparent @endif flex items-center text-sm font-medium hover:text-black border-b-2 pb-3 transition-all">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('articles.latest') }}"
                            class="@if (request()->routeIs('articles.latest')) text-black border-black @else text-gray-600 border-transparent @endif flex items-center text-sm font-medium hover:text-black border-b-2 pb-3 transition-all">
                            Latest
                        </a>
                    </li>
                    @foreach ($categories as $category)
                        @php
                            $isActive =
                                request()->is("categories/{$category->slug}") ||
                                $category->children
                                    ->pluck('slug')
                                    ->contains(fn($slug) => request()->is("categories/$slug"));
                        @endphp
                        <li class="relative group">
                            <a href="{{ route('categories.show', $category->slug) }}"
                                class="{{ $isActive ? 'text-black border-black' : 'text-gray-600 border-transparent' }} flex items-center text-sm font-medium hover:text-black border-b-2 pb-3 transition-all">
                                {{ $category->name }}
                                @if ($category->children->count() > 0)
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-3 w-3 ml-1 transition-transform group-hover:rotate-180"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                @endif
                            </a>

                            @if ($category->children->count() > 0)
                                <ul class="category-dropdown absolute left-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible transform translate-y-2 group-hover:translate-y-0 transition-all duration-200 mt-1 bg-white border border-gray-100 shadow-md min-w-[200px] z-50"
                                    aria-label="Submenu for {{ $category->name }}">
                                    @foreach ($category->children as $child)
                                        <li>
                                            <a href="{{ route('categories.show', $child->slug) }}"
                                                class="block font-semibold px-4 py-2 text-sm text-gray-600 hover:text-black hover:bg-gray-50 border-b border-gray-50 last:border-b-0 transition-colors">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </header>

    <!-- Latest news banner -->
    @if ($latestNews)
        <div class="hidden bg-gradient-to-r from-red-600 to-red-700 text-white py-3 shadow-lg" id="breaking-news">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span
                            class="bg-white text-red-600 px-3 py-1 text-xs font-bold uppercase tracking-wide">Latest</span>
                        <a href="{{ route('articles.show', $latestNews->slug) }}" class="text-sm font-medium line-clamp-1 hover:underline">
                            {{ $latestNews->title }}
                        </a>
                    </div>
                    <button onclick="closeBreakingNews()" class="text-white hover:text-gray-200 p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <main class="flex-grow max-w-7xl mx-auto w-full px-4 py-8">
        @yield('content')
    </main> 

    <footer class="bg-white border-t-1 border-gray-100 mt-16" role="contentinfo">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <!-- Main footer content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="">
                    <div class="text-2xl font-bold text-black mb-4">
                        <a href="{{ route('home') }}" aria-label="Home">
                            <svg width="96" height="20" viewBox="0 0 96 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M96 0V20H84V0H96ZM88.5 16.129H91.5V3.87097H88.5V16.129Z" fill="#FF4242" />
                                <path d="M68 0V3.87097H60.5V16.129H68V20H56V0H68Z" fill="#2B2B2B" />
                                <path d="M74.5 0V8.12888H77.5V0H82V20H77.5V11.9998H74.5V20H70V0H74.5Z" fill="#2B2B2B" />
                                <path d="M54 0V3.87097H46.5V16.129H54V20H42V0H54ZM53 8V12H46.5V8H53Z" fill="#2B2B2B" />
                                <path d="M32.5 0L35.5 8.12888V0H40V20H35.5L32.5 11.9998V20H28V0H32.5Z" fill="#2B2B2B" />
                                <path d="M26 0V3.87097H18.5V16.129H26V20H14V0H26ZM25 8V12H18.5V8H25Z" fill="#2B2B2B" />
                                <path d="M8 0V20H3.43478V3.87097H0V0H8Z" fill="#FF4242" />
                                <path d="M12 4V0H9V4H12Z" fill="#2B2B2B" />
                            </svg>
                        </a>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed mb-4">{!! $siteSettings->where('key', 'site-description')->first()->value ?? '' !!}</p>
                    <div class="text-xs text-gray-500">
                        © {{ date('Y') }} Tenecho. All rights reserved.
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 w-full">
                    <nav class="md:col-span-2" aria-label="Site sections">
                        <h3 class="text-black font-semibold text-sm mb-4 uppercase tracking-wide">Sections</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('home') }}"
                                    class="text-gray-700 hover:text-black hover:underline">Home</a></li>
                            <li><a href="{{ route('articles.latest') }}"
                                    class="text-gray-700 hover:text-black hover:underline">Latest</a></li>
                            @foreach ($siteSettings->where('key', 'footer-sections') as $item)
                                <x-site-setting-item :item="$item" class="text-gray-700 hover:text-black hover:underline" wrapper="li" />
                            @endforeach
                        </ul>
                    </nav>

                    <nav aria-label="Company information">
                        <h3 class="text-black font-semibold text-sm mb-4 uppercase tracking-wide">Company</h3>
                        <ul class="space-y-2 text-sm">
                            @foreach ($siteSettings->where('key', 'footer-company') as $item)
                                <x-site-setting-item :item="$item" class="text-gray-700 hover:text-black hover:underline" wrapper="li" />
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Bottom footer -->
            <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <nav class="flex flex-wrap space-x-4 mb-4 md:mb-0" aria-label="Legal links">
                    @foreach ($siteSettings->where('key', 'footer-bottom') as $item)
                        <x-site-setting-item :item="$item" class="hover:text-black hover:underline text-gray-600" />
                    @endforeach
                </nav>
                <nav class="flex space-x-4" aria-label="Social media links">
                    @foreach ($siteSettings->where('key', 'social-links')->sortBy('order') as $item)
                        <a href="{{ $item->url ?? '#' }}" class="text-gray-400 hover:text-black transition-colors"
                            aria-label="{{ $item->description ?? $item->title ?? 'Social link' }}" 
                            rel="noopener noreferrer">
                            {!! $item->value !!}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </footer>

    @yield('scripts')

    <div id="cookie-banner" class="fixed bottom-0 left-0 right-0 bg-gray-900 text-white py-4 px-4 shadow-lg transform transition-transform duration-300 translate-y-full z-50">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm">
                @foreach ($siteSettings->where('key', 'cookie-consent') as $item)
                    <p>{!! $item->value !!}</p>
                @endforeach
            </div>
            <div class="flex gap-3">
                <button onclick="acceptCookies()" class="bg-white text-gray-900 px-4 py-2 text-sm font-medium hover:bg-gray-100 transition-colors">
                    Accept
                </button>
                <button onclick="declineCookies()" class="border border-white px-4 py-2 text-sm font-medium hover:bg-gray-800 transition-colors">
                    Decline
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update live time
            function updateTime() {
                const now = new Date();
                const timeElement = document.getElementById('live-time');
                const hourElement = document.getElementById('current-hour');
                const minuteElement = document.getElementById('current-minute');

                if (timeElement) {
                    timeElement.textContent = now.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
                if (hourElement) {
                    hourElement.textContent = now.getHours().toString().padStart(2, '0');
                }
                if (minuteElement) {
                    minuteElement.textContent = now.getMinutes().toString().padStart(2, '0');
                }
            }

            // Update time immediately and then every second
            updateTime();
            setInterval(updateTime, 1000);

            // Enhanced dropdown functionality
            const categoryItems = document.querySelectorAll('.group');
            categoryItems.forEach(item => {
                const dropdown = item.querySelector('.category-dropdown');
                if (dropdown) {
                    let hoverTimeout;

                    // Show on hover
                    item.addEventListener('mouseenter', function() {
                        clearTimeout(hoverTimeout);
                        dropdown.classList.remove('opacity-0', 'invisible');
                        dropdown.classList.add('opacity-100', 'visible');
                    });

                    // Hide when leaving
                    item.addEventListener('mouseleave', function() {
                        hoverTimeout = setTimeout(() => {
                            dropdown.classList.remove('opacity-100', 'visible');
                            dropdown.classList.add('opacity-0', 'invisible');
                        }, 150);
                    });
                }
            });

            const cookieConsent = localStorage.getItem('cookieConsent');
            if (!cookieConsent) {
                setTimeout(() => {
                    const banner = document.getElementById('cookie-banner');
                    banner.classList.remove('translate-y-full');
                }, 1000);
            }
        });

        function acceptCookies() {
            localStorage.setItem('cookieConsent', 'accepted');
            hideCookieBanner();
        }

        function declineCookies() {
            localStorage.setItem('cookieConsent', 'declined');
            hideCookieBanner();
        }

        function hideCookieBanner() {
            const banner = document.getElementById('cookie-banner');
            banner.classList.add('translate-y-full');
        }

        // Check if the banner was closed within the last 15 minutes
        function shouldShowBanner() {
            const bannerClosedAt = localStorage.getItem('bannerClosedAt');
            if (!bannerClosedAt) return true;

            const now = new Date().getTime();
            const fifteenMinutes = 15 * 60 * 1000; // 15 minutes in milliseconds

            return (now - parseInt(bannerClosedAt)) > fifteenMinutes;
        }

        // Hide banner if it was recently closed
        if (shouldShowBanner()) {
            document.getElementById('breaking-news').classList.remove('hidden');
        }

        // Function to close the breaking news banner and remember the time
        function closeBreakingNews() {
            document.getElementById('breaking-news').classList.add('hidden');
            localStorage.setItem('bannerClosedAt', new Date().getTime());
        }
    </script>
</body>

</html>
