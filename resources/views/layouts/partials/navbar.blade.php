<nav id="navbar" class="{{ request()->routeIs('client.*') ? 'scrolled client-navbar' : '' }}" role="navigation"
    aria-label="Main navigation">
    <a href="{{ route('home') }}" class="nav-logo" aria-label="Faris Jaya Aluminium home">
        @php
            $settings = \App\Models\SiteSetting::first();
            $ft = \App\Models\FrontendText::first();
        @endphp
        <div class="nav-logo-text" style="display: flex; align-items: center; gap: 12px;">
            @if($settings && $settings->horizontal_logo)
                <img src="{{ asset('storage/' . $settings->horizontal_logo) }}" alt="Faris Jaya Aluminium Logo"
                    style="max-height: 64px; width: auto; object-fit: contain;">
            @else
                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"
                    style="height: 36px; width: 36px; color: var(--gold-400);">
                    <rect x="15" y="15" width="70" height="70" rx="18" stroke="currentColor" stroke-width="6"
                        stroke-linejoin="round" />
                    <circle cx="35" cy="35" r="7" fill="currentColor" />
                    <circle cx="65" cy="35" r="7" fill="currentColor" />
                    <circle cx="50" cy="65" r="7" fill="currentColor" />
                    <path d="M35 35 L65 35 L50 65 Z" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            @endif
            <div style="display: flex; flex-direction: column; align-items: flex-start; line-height: 1.1;">
                <span
                    style="font-size: 18px; font-weight: 900; letter-spacing: 0.5px;">{{ $ft->navbar['brand_1'] ?? 'DBAIK' }}</span>
                <span
                    style="font-size: 10px; font-weight: 800; color: var(--gold-400); letter-spacing: 2px;">{{ $ft->navbar['brand_2'] ?? 'DIGITAL AGENCY' }}</span>
            </div>
        </div>
    </a>
    @if(request()->routeIs('client.*'))
        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="text-xs font-bold text-slate-400 hover:text-white transition-colors">←
                    Beranda Website</a></li>
        </ul>
    @else
        <ul class="nav-links">
            {{-- <li><a href="{{ Request::is('/') ? '#projects' : route('home') . '#projects' }}">{{ $ft->navbar['menu_1']
                    ?? 'Portofolio' }}</a></li> --}}
            <li><a
                    href="{{ Request::is('/') ? '#products' : route('home') . '#products' }}">{{ $ft->navbar['menu_2'] ?? 'Layanan' }}</a>
            </li>
            <li><a href="{{ route('home') }}#testimonials">{{ $ft->navbar['menu_3'] ?? 'Testimoni' }}</a></li>
            @auth
                <li><a href="{{ route('client.portal') }}" style="color: var(--gold-400); font-weight: 700;">Client Portal</a>
                </li>
            @else
                <li><a href="{{ route('client.login') }}" style="color: var(--gold-400); font-weight: 700;">Client Area</a></li>
            @endauth
            <li><a href="#contact" class="nav-cta"
                    id="nav-konsultasi">{{ $ft->navbar['menu_cta'] ?? 'Konsultasi Gratis' }}</a></li>
        </ul>
    @endif
    @if(!request()->routeIs('client.*'))
        <button class="nav-burger" id="burger-toggle" aria-label="Buka menu navigasi" aria-expanded="false">
            <svg id="burger-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="2" y="5" width="16" height="1.8" rx="0.9" fill="white" />
                <rect x="5" y="9.1" width="10" height="1.8" rx="0.9" fill="white" opacity="0.7" />
                <rect x="2" y="13.2" width="16" height="1.8" rx="0.9" fill="white" />
            </svg>
        </button>
    @endif
</nav>

<!-- Mobile Nav -->
<nav class="mobile-nav" id="mobile-nav" aria-label="Mobile navigation">
    @if(request()->routeIs('client.*'))
        <a href="{{ route('home') }}" class="mobile-link">← Beranda Website</a>
    @else
        <a href="{{ route('home') }}#projects" class="mobile-link">{{ $ft->navbar['menu_1'] ?? 'Portofolio' }}</a>
        <a href="{{ route('home') }}#products" class="mobile-link">{{ $ft->navbar['menu_2'] ?? 'Layanan' }}</a>
        <a href="{{ route('home') }}#testimonials" class="mobile-link">{{ $ft->navbar['menu_3'] ?? 'Testimoni' }}</a>
        @auth
            <a href="{{ route('client.portal') }}" class="mobile-link" style="color:var(--gold-400)">Client Portal</a>
        @else
            <a href="{{ route('client.login') }}" class="mobile-link" style="color:var(--gold-400)">Client Area</a>
        @endauth
        <a href="#contact" class="mobile-link"
            style="color:var(--gold-300)">{{ $ft->navbar['menu_cta'] ?? 'Konsultasi Gratis' }} →</a>
    @endif
</nav>