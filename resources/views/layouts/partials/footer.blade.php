<footer id="footer">
    <div class="footer-inner">
        @php
            $ft = \App\Models\FrontendText::first();
        @endphp
        <div class="footer-brand" style="max-width: 400px;">
            <h3>{{ $ft->footer['brand_name'] ?? 'FARIS JAYA ALUMINIUM' }}</h3>
            <p>{{ $ft->footer['brand_desc'] ?? 'Premium Aluminium Specialist — Sejak 2018' }}</p>
        </div>
        <ul class="footer-links">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('home') }}#products">Produk</a></li>
            <li><a href="{{ route('home') }}#projects">Portofolio</a></li>
            <li><a href="#contact">Kontak</a></li>
        </ul>
    </div>
    <div class="footer-copy">
        &copy; {{ date('Y') }} Faris Jaya Aluminium. All rights reserved.
    </div>
</footer>