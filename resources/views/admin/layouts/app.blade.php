<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $siteSettings->where('key', 'site-title')->first()->value ?? 'Tenecho')@hasSection('title') - {{$siteSettings->where('key', 'site-title')->first()->value ?? 'Tenecho'}} @endif</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @yield('head')
</head>

<body class="flex overflow-x-hidden">
    <aside class="w-64 flex-shrink-0 h-screen bg-white sticky top-0 left-0 flex flex-col justify-between border-r border-gray-100 z-50">
        <div class="text-gray-900 w-full">
            <div class="h-14 flex items-center px-8 border-b border-gray-100">
                <a href="{{ route('admin.dashboard') }}">
                    <svg width="96" height="20" viewBox="0 0 96 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M96 0V20H84V0H96ZM88.5 16.129H91.5V3.87097H88.5V16.129Z" fill="#FF4242"/>
                        <path d="M68 0V3.87097H60.5V16.129H68V20H56V0H68Z" fill="#2B2B2B"/>
                        <path d="M74.5 0V8.12888H77.5V0H82V20H77.5V11.9998H74.5V20H70V0H74.5Z" fill="#2B2B2B"/>
                        <path d="M54 0V3.87097H46.5V16.129H54V20H42V0H54ZM53 8V12H46.5V8H53Z" fill="#2B2B2B"/>
                        <path d="M32.5 0L35.5 8.12888V0H40V20H35.5L32.5 11.9998V20H28V0H32.5Z" fill="#2B2B2B"/>
                        <path d="M26 0V3.87097H18.5V16.129H26V20H14V0H26ZM25 8V12H18.5V8H25Z" fill="#2B2B2B"/>
                        <path d="M8 0V20H3.43478V3.87097H0V0H8Z" fill="#FF4242"/>
                        <path d="M12 4V0H9V4H12Z" fill="#2B2B2B"/>
                    </svg>
                </a>
            </div>
            <ul class="mt-5 p-4 flex flex-col gap-2">
                @if (auth()->user()->hasPermission('admin.dashboard'))
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-2 px-4 py-3 rounded-md hover:bg-gray-50 duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 font-medium' : '' }}">
                            <!-- Dashboard SVG icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="19" cy="5" r="2.5" />
                                    <path stroke-linecap="round"
                                        d="M21.25 10v5.25a6 6 0 0 1-6 6h-6.5a6 6 0 0 1-6-6v-6.5a6 6 0 0 1 6-6H14" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m7.27 15.045l2.205-2.934a.9.9 0 0 1 1.197-.225l2.151 1.359a.9.9 0 0 0 1.233-.261l2.214-3.34" />
                                </g>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasPermission('admin.articles.index'))
                    <li>
                        <a href="{{ route('admin.articles.index') }}"
                            class="flex items-center gap-2 px-4 py-3 rounded-md hover:bg-gray-50 duration-200 {{ request()->routeIs('admin.articles.*') ? 'bg-blue-50 font-medium' : '' }}">
                            <!-- Articles SVG icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 256">
                                <path fill="currentColor"
                                    d="M216 40H40a16 16 0 0 0-16 16v160a8 8 0 0 0 11.58 7.15L64 208.94l28.42 14.21a8 8 0 0 0 7.16 0L128 208.94l28.42 14.21a8 8 0 0 0 7.16 0L192 208.94l28.42 14.21A8 8 0 0 0 232 216V56a16 16 0 0 0-16-16Zm0 163.06l-20.42-10.22a8 8 0 0 0-7.16 0L160 207.06l-28.42-14.22a8 8 0 0 0-7.16 0L96 207.06l-28.42-14.22a8 8 0 0 0-7.16 0L40 203.06V56h176ZM136 112a8 8 0 0 1 8-8h48a8 8 0 0 1 0 16h-48a8 8 0 0 1-8-8Zm0 32a8 8 0 0 1 8-8h48a8 8 0 0 1 0 16h-48a8 8 0 0 1-8-8Zm-72 24h48a8 8 0 0 0 8-8V96a8 8 0 0 0-8-8H64a8 8 0 0 0-8 8v64a8 8 0 0 0 8 8Zm8-64h32v48H72Z" />
                            </svg>
                            <span>Articles</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasPermission('admin.categories.index'))
                    <li>
                        <a href="{{ route('admin.categories.index') }}"
                            class="flex items-center gap-2 px-4 py-3 rounded-md hover:bg-gray-50 duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 font-medium' : '' }}">
                            <!-- Categories SVG icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5">
                                    <circle cx="17" cy="7" r="3" />
                                    <circle cx="7" cy="17" r="3" />
                                    <path
                                        d="M14 14h6v5a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-5ZM4 4h6v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4Z" />
                                </g>
                            </svg>
                            <span>Categories</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasPermission('admin.users.index'))
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-2 px-4 py-3 rounded-md hover:bg-gray-50 duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 font-medium' : '' }}">
                            <!-- Users SVG icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="9" cy="9" r="2" />
                                    <path d="M13 15c0 1.105 0 2-4 2s-4-.895-4-2s1.79-2 4-2s4 .895 4 2Z" />
                                    <path stroke-linecap="round"
                                        d="M22 12c0 3.771 0 5.657-1.172 6.828C19.657 20 17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172C2 17.657 2 15.771 2 12c0-3.771 0-5.657 1.172-6.828C4.343 4 6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172c.47.47.751 1.054.92 1.828M19 12h-4m4-3h-5m5 6h-3" />
                                </g>
                            </svg>
                            <span>Users</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasPermission('admin.roles.index'))
                    <li>
                        <a href="{{ route('admin.roles.index') }}"
                            class="flex items-center gap-2 px-4 py-3 rounded-md hover:bg-gray-50 duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-blue-50 font-medium' : '' }}">
                            <!-- Roles SVG icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="m318.458 50.945l-39.323-16.557l-17.44 41.42l-5.246-1.141l-171.115 37.281V236.22l.273 11.328c4.7 96.674 69.051 154.562 117.399 184.636l2.524 1.503l-11.675 27.243l39.217 16.807L341.816 224h-96.223zm-95.94 343.103l54.592-127.381h-95.777l61.178-145.296L128 146.32v89.385l.248 10.264c3.812 74.235 51.889 120.97 94.27 148.079m62.472 52.062l7.42-3.863l15.418-8.92l11.037-7.124c48.792-32.968 108.311-93.445 107.75-192.113l-.119-22.879l-.05-83.956l.221-15.532l-87.553-19.06l-16.842 39.999l61.519 13.393l.037 65.181l.011 2.097h.913l-.902 2.104l.099 18.896c.377 66.311-32.759 111.562-68.818 141.448z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Roles</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasPermission('admin.site-settings.index'))
                    <li>
                        <a href="{{ route('admin.site-settings.index') }}"
                            class="flex items-center gap-2 px-4 py-3 rounded-md hover:bg-gray-50 duration-200 {{ request()->routeIs('admin.site-settings.*') ? 'bg-blue-50 font-medium' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M19.9 12.66a1 1 0 0 1 0-1.32l1.28-1.44a1 1 0 0 0 .12-1.17l-2-3.46a1 1 0 0 0-1.07-.48l-1.88.38a1 1 0 0 1-1.15-.66l-.61-1.83a1 1 0 0 0-.95-.68h-4a1 1 0 0 0-1 .68l-.56 1.83a1 1 0 0 1-1.15.66L5 4.79a1 1 0 0 0-1 .48L2 8.73a1 1 0 0 0 .1 1.17l1.27 1.44a1 1 0 0 1 0 1.32L2.1 14.1a1 1 0 0 0-.1 1.17l2 3.46a1 1 0 0 0 1.07.48l1.88-.38a1 1 0 0 1 1.15.66l.61 1.83a1 1 0 0 0 1 .68h4a1 1 0 0 0 .95-.68l.61-1.83a1 1 0 0 1 1.15-.66l1.88.38a1 1 0 0 0 1.07-.48l2-3.46a1 1 0 0 0-.12-1.17ZM18.41 14l.8.9l-1.28 2.22l-1.18-.24a3 3 0 0 0-3.45 2L12.92 20h-2.56L10 18.86a3 3 0 0 0-3.45-2l-1.18.24l-1.3-2.21l.8-.9a3 3 0 0 0 0-4l-.8-.9l1.28-2.2l1.18.24a3 3 0 0 0 3.45-2L10.36 4h2.56l.38 1.14a3 3 0 0 0 3.45 2l1.18-.24l1.28 2.22l-.8.9a3 3 0 0 0 0 3.98Zm-6.77-6a4 4 0 1 0 4 4a4 4 0 0 0-4-4Zm0 6a2 2 0 1 1 2-2a2 2 0 0 1-2 2Z" />
                            </svg>
                            <span>Site Settings</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="h-12 flex items-center px-4 border-t border-gray-100">
            @auth
                <form action="{{ route('auth.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="cursor-pointer text-red-600 hover:text-red-700 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M13.53 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72H20a.75.75 0 0 0 0-1.5h-8.19l1.72-1.72a.75.75 0 0 0 0-1.06"
                                opacity=".5" />
                            <path fill="currentColor"
                                d="M9.768 3.25h2.464c.813 0 1.469 0 2 .043c.546.045 1.026.14 1.47.366a3.75 3.75 0 0 1 1.64 1.639c.226.444.32.924.365 1.47c.043.531.043 1.187.043 2V9a.75.75 0 0 1-1.5 0v-.2c0-.852 0-1.447-.038-1.91c-.038-.453-.107-.714-.207-.911a2.25 2.25 0 0 0-.983-.984c-.198-.1-.459-.17-.913-.207c-.462-.037-1.056-.038-1.909-.038H9.8c-.852 0-1.447 0-1.91.038c-.453.037-.714.107-.911.207a2.25 2.25 0 0 0-.984.984c-.1.197-.17.458-.207.912c-.037.462-.038 1.057-.038 1.909v6.4c0 .852 0 1.447.038 1.91c.037.453.107.714.207.912c.216.423.56.767.984.983c.197.1.458.17.912.207c.462.037 1.057.038 1.909.038h2.4c.853 0 1.447 0 1.91-.038c.453-.038.714-.107.912-.207c.423-.216.767-.56.983-.983c.1-.198.17-.459.207-.913c.037-.462.038-1.057.038-1.909V15a.75.75 0 0 1 1.5 0v.232c0 .813 0 1.469-.043 2c-.045.546-.14 1.026-.366 1.47a3.75 3.75 0 0 1-1.639 1.64c-.444.226-.924.32-1.47.365c-.531.043-1.187.043-2 .043H9.768c-.813 0-1.469 0-2-.043c-.546-.045-1.026-.14-1.47-.366a3.75 3.75 0 0 1-1.64-1.639c-.226-.444-.32-.924-.365-1.47c-.043-.531-.043-1.187-.043-2V8.768c0-.813 0-1.469.043-2c.045-.546.14-1.026.366-1.47a3.75 3.75 0 0 1 1.639-1.64c.444-.226.924-.32 1.47-.365c.531-.043 1.187-.043 2-.043" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            @endauth
        </div>
    </aside>

    <main class="flex-1 min-w-0 overflow-x-auto">
        <header
            class="bg-white sticky top-0 h-14 w-full px-8 flex justify-between items-center border-b border-gray-100 z-40">
            <div>Dashboard</div>
            <div class="flex items-center gap-5">
                <a href="{{ route('home') }}" target="_blank" class="text-gray-600 hover:text-gray-800 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 14 14"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M7 13.5a6.5 6.5 0 1 0 0-13a6.5 6.5 0 0 0 0 13M.5 7h13"/><path d="M9.5 7A11.22 11.22 0 0 1 7 13.5A11.22 11.22 0 0 1 4.5 7A11.22 11.22 0 0 1 7 .5A11.22 11.22 0 0 1 9.5 7"/></g></svg>
                </a>

                <div class="relative">
                    <button id="profile-button" class="flex items-center gap-2 focus:outline-none cursor-pointer">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->username) }}&background=random&color=fff&size=28"
                            alt="{{ auth()->user()->name }}" class="rounded-full w-7 h-7">
                    </button>

                    <div id="profile-dropdown"
                        class="absolute hidden right-0 mt-2 w-56 bg-white rounded shadow-sm ring-1 ring-gray-100 ring-opacity-5 z-50">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->username) }}&background=random&color=fff&size=40"
                                    alt="{{ auth()->user()->name }}" class="rounded-full w-9 h-9">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your
                            Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <form action="{{ route('auth.logout') }}" method="post">
                            @csrf
                            <button type="submit"
                                class="cursor-pointer block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <div class="p-4">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileButton = document.getElementById('profile-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            // Toggle dropdown on button click
            profileButton.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });

            // Close dropdown when pressing Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    profileDropdown.classList.add('hidden');
                }
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
