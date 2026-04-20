<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="Faris Jaya Aluminium — Spesialis Kusen, Pintu, Jendela, Kaca & Plafond berkualitas premium." />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Faris Jaya Aluminium — Premium Aluminium Specialist')</title>

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
    <div id="particles"></div>
    <div id="back-to-top" title="Go to top">↑</div>

    <a href="https://wa.me/{{ $settings->whatsapp_number ?? '6281212345678' }}?text=Halo%20Faris%20Jaya%20Aluminium%2C%20saya%20ingin%20konsultasi%20mengenai%20produk%20aluminium"
        id="wa-float" aria-label="Chat WhatsApp" target="_blank" rel="noopener noreferrer">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="white" aria-hidden="true">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
        </svg>
    </a>

    <!-- Navbar -->
    @include('layouts.partials.navbar')

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Floating WA -->



    <!-- Scripts -->

    @livewireScripts
    @stack('scripts')

    <script>
        // Global logic moved to app.js
    </script>
</body>

</html>