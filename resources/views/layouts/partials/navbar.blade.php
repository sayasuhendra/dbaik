<nav id="navbar" role="navigation" aria-label="Main navigation">
    <a href="{{ route('home') }}" class="nav-logo" aria-label="Faris Jaya Aluminium home">
        @php
            $settings = \App\Models\SiteSetting::first();
        @endphp
        <div class="nav-logo-text" style="display: flex; align-items: center; gap: 12px;">
            @if($settings && $settings->horizontal_logo)
                <img src="{{ asset('storage/' . $settings->horizontal_logo) }}" alt="Faris Jaya Aluminium Logo"
                    style="max-height: 64px; width: auto; object-fit: contain;">
            @else
                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"
                    style="height: 32px; width: 32px; color: var(--gold-400);">
                    <rect x="10" y="10" width="80" height="80" rx="10" stroke="currentColor" stroke-width="6" />
                    <path d="M30 30h25M30 48h18M30 30v40" stroke="currentColor" stroke-width="6" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M70 30v30c0 5.5-4.5 10-10 10" stroke="currentColor" stroke-width="6" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            @endif
            <div style="display: flex; flex-direction: column; align-items: flex-start; line-height: 1.1;">
                <span style="font-size: 18px; font-weight: 800; letter-spacing: 0.5px;">FARIS JAYA</span>
                <span
                    style="font-size: 12px; font-weight: 600; color: var(--gold-400); letter-spacing: 2px;">ALUMINIUM</span>
            </div>
        </div>
    </a>
    <ul class="nav-links">
        <li><a href="{{ Request::is('/') ? '#projects' : route('home') . '#projects' }}">Portofolio</a></li>
        <li><a href="{{ Request::is('/') ? '#products' : route('home') . '#products' }}">Produk</a></li>
        <li><a href="{{ route('home') }}#testimonials">Testimoni</a></li>
        <li><a href="#contact" class="nav-cta" id="nav-konsultasi">Konsultasi Gratis</a></li>
    </ul>
    <button class="nav-burger" id="burger-toggle" aria-label="Buka menu navigasi" aria-expanded="false">
        <svg id="burger-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="2" y="5" width="16" height="1.8" rx="0.9" fill="white" />
            <rect x="5" y="9.1" width="10" height="1.8" rx="0.9" fill="white" opacity="0.7" />
            <rect x="2" y="13.2" width="16" height="1.8" rx="0.9" fill="white" />
        </svg>
    </button>
</nav>

<!-- Mobile Nav -->
<nav class="mobile-nav" id="mobile-nav" aria-label="Mobile navigation">
    <a href="{{ route('home') }}#projects" class="mobile-link">Portofolio</a>
    <a href="{{ route('home') }}#products" class="mobile-link">Produk</a>
    <a href="{{ route('home') }}#testimonials" class="mobile-link">Testimoni</a>
    <a href="#contact" class="mobile-link" style="color:var(--gold-300)">Konsultasi Gratis →</a>
</nav>