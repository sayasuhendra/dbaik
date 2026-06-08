<footer id="footer">
    <div class="footer-inner">
        @php
            $ft = \App\Models\FrontendText::first();
        @endphp
        <div class="footer-brand" style="max-width: 400px;">
            <h3>{{ $ft->footer['brand_name'] ?? 'DBAIK DIGITAL AGENCY' }}</h3>
            <p>{{ $ft->footer['brand_desc'] ?? 'Silicon Valley level AI, Software House, and Digital Automation partner based in Indonesia.' }}</p>
        </div>
        <ul class="footer-links">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('home') }}#products">Layanan</a></li>
            <li><a href="{{ route('home') }}#projects">Portofolio</a></li>
            <li><a href="#contact">Kontak</a></li>
        </ul>
    </div>
    <div class="footer-copy">
        &copy; {{ date('Y') }} DBAIK Digital Agency. All rights reserved.
    </div>
</footer>