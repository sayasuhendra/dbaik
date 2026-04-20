<nav id="navbar" role="navigation" aria-label="Main navigation">
    <a href="{{ route('home') }}" class="nav-logo" aria-label="Faris Jaya Aluminium home">
        <div class="nav-logo-text">
            FARIS JAYA
            <span>ALUMINIUM</span>
        </div>
    </a>
    <ul class="nav-links">
        <li><a href="{{ Request::is('/') ? '#projects' : route('home').'#projects' }}">Portofolio</a></li>
        <li><a href="{{ Request::is('/') ? '#products' : route('home').'#products' }}">Produk</a></li>
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
    <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Tutup menu">×</button>
    <a href="{{ route('home') }}#projects" class="mobile-link">Portofolio</a>
    <a href="{{ route('home') }}#products" class="mobile-link">Produk</a>
    <a href="{{ route('home') }}#testimonials" class="mobile-link">Testimoni</a>
    <a href="#contact" class="mobile-link" style="color:var(--gold-300)">Konsultasi Gratis →</a>
</nav>
