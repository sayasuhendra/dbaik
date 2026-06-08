<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="DBAIK Digital Agency — Silicon Valley Level AI, Software House, and Digital Automation partner based in Indonesia." />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DBAIK Digital Agency — Silicon Valley Level AI & Technology Partner')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <!-- Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Back to Top Button */
        #back-to-top {
            position: fixed;
            bottom: 104px;
            right: 38px;
            width: 48px;
            height: 48px;
            background: var(--gold-500);
            color: black;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1), background 0.2s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        #back-to-top:hover {
            background: var(--gold-400);
            transform: translateY(-5px) !important;
        }

        #back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Reveal Animations */
        .reveal,
        .reveal-left,
        .reveal-right {
            opacity: 0;
            will-change: transform, opacity;
        }

        .reveal {
            transform: translateY(30px);
        }

        .reveal-left {
            transform: translateX(-50px);
        }

        .reveal-right {
            transform: translateX(50px);
        }
    </style>

    @livewireStyles
    @stack('styles')
</head>

<body>
    <!-- Global Elements -->
    <div id="progress-bar"></div>
    @if(!request()->routeIs('client.*'))
        <div id="particles"></div>
        <div id="back-to-top" title="Go to top">↑</div>

        <!-- Floating WA -->
        @include('layouts.partials.wa-float')
    @endif

    <!-- Navbar -->
    @include('layouts.partials.navbar')

    <!-- Main Content -->
    <main @if(request()->routeIs('client.*')) class="pt-20 md:pt-24 px-4 sm:px-6 lg:px-8" @endif>
        {{ $slot }}
    </main>

    <!-- Footer -->
    @if(request()->routeIs('client.*'))
        <footer class="py-8 border-t border-white/5 bg-[#030712] relative z-10">
            <div class="container mx-auto px-6 max-w-7xl flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <div>&copy; {{ date('Y') }} DBAIK Digital Agency. All rights reserved.</div>
                <div class="flex gap-6">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Website Beranda</a>
                    <a href="{{ route('home') }}#contact" class="hover:text-white transition-colors">Kontak Support</a>
                </div>
            </div>
        </footer>
    @else
        @include('layouts.partials.footer')
    @endif

    <!-- Scripts -->

    @livewireScripts
    @stack('scripts')

    <script>
        // Global logic moved to app.js
    </script>
</body>

</html>
