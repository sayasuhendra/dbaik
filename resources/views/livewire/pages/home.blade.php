<?php

use Livewire\Volt\Component;
use App\Models\Project;
use App\Models\ProductCategory;
use App\Models\SiteSetting;
use App\Models\Testimonial;

new class extends Component {
    public $projects;
    public $categories;
    public $settings;
    public $testimonials;

    public function mount()
    {
        $this->projects = Project::latest()->get();
        $this->categories = ProductCategory::withCount('images')->get();
        $this->settings = SiteSetting::first() ?? new SiteSetting([
            'hero_title' => 'Keindahan & Ketahanan Tanpa Kompromi',
            'hero_subtitle' => 'Kusen, pintu, jendela, kaca & plafond alumunium berkualitas premium.',
            'whatsapp_number' => '6281212345678',
            'office_hours' => '08.00 - 17.00 WIB',
            'location_text' => 'Jakarta & Sekitarnya'
        ]);
        $this->testimonials = Testimonial::where('is_active', true)->get();
    }
};

?>

<div x-data>
    @section('title', 'Spesialis Aluminium Premium — Faris Jaya Aluminium')

    <!-- ======================== SECTION 1: HERO ======================== -->
    <section id="hero" aria-label="Hero section">
        <div class="hero-bg"></div>
        <div class="hero-grid"></div>

        <div id="particles" class="particles"></div>

        <div class="container relative z-10">
            <div class="reveal">
                <div class="hero-badge">
                    <span>{{ $settings->location_text ?? 'Jakarta & Sekitarnya' }}</span>
                </div>
                <h1 class="hero-title">
                    <span
                        class="gradient-text">{{ $settings->hero_title ?? 'Keindahan & Ketahanan Tanpa Kompromi' }}</span>
                </h1>
                <p class="hero-sub">
                    {{ $settings->hero_subtitle ?? 'Kusen, pintu, jendela, kaca & plafond alumunium berkualitas premium.' }}
                </p>

                <div class="hero-actions">
                    <a href="https://wa.me/{{ $settings->whatsapp_number ?? '6281212345678' }}" class="btn-primary">
                        <span>Konsultasi Gratis</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                    </a>
                    <a href="#projects" class="btn-secondary"
                        x-on:click.prevent="gsap.to(window, {duration: 1, scrollTo: '#projects'})">Lihat Portfolio</a>
                </div>
            </div>
        </div>

        <div class="hero-scroll-indicator">
            <span>Scroll untuk eksplorasi</span>
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- ======================== SECTION 2: STATS MARQUEE ======================== -->
    <section id="marquee-section">
        <div class="marquee-track">
            @for ($i = 0; $i < 4; $i++)
                <div class="marquee-item">
                    <span class="marquee-icon">✦</span>
                    <span>BERPENGALAMAN SEJAK 2015</span>
                    <span class="marquee-dot"></span>
                    <span>BAHAN ALUMINIUM GRADE A</span>
                    <span class="marquee-dot"></span>
                    <span>PENGIRIMAN SELURUH INDONESIA</span>
                    <span class="marquee-dot"></span>
                    <span>GARANSI PEMASANGAN</span>
                </div>
            @endfor
        </div>
    </section>

    <!-- ======================== SECTION 3: PORTFOLIO ======================== -->
    <section id="projects">
        <div class="reveal">
            <p class="section-label">Karya Terbaru</p>
            <h2 class="section-title">Portfolio Proyek</h2>
            <p class="section-sub">Beberapa hasil pengerjaan terbaik kami untuk klien residensial dan komersial.</p>
        </div>

        <div class="projects-grid">
            @forelse($projects as $project)
                <a href="{{ route('portfolio.detail', $project->id) }}" class="project-card reveal" wire:navigate
                    style="display: block; text-decoration: none;">
                    <div class="project-img-wrapper">
                        <img src="{{ (is_array($project->photos) && isset($project->photos[0])) ? url('storage/' . $project->photos[0]) : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80' }}"
                            alt="{{ $project->title }}">
                    </div>
                    <div class="project-info">
                        <p class="project-category">{{ $project->category }}</p>
                        <h3 class="project-title">{{ $project->title }}</h3>
                        <p class="project-location">{{ $project->location }}</p>
                    </div>
                </a>

            @empty
                <p class="reveal" style="color: rgba(255,255,255,0.4);">Belum ada proyek yang ditampilkan.</p>
            @endforelse
        </div>
    </section>

    <!-- ======================== SECTION 3: PRODUCTS ======================== -->
    <section id="products">
        <div class="reveal">
            <p class="section-label">Layanan Kami</p>
            <h2 class="section-title">Solusi Aluminium <br /> Untuk Hunian Modern</h2>
            <p class="section-sub">Kualitas premium dengan desain minimalis yang meningkatkan estetika bangunan Anda.
            </p>
        </div>

        <div class="products-grid">
            @forelse($categories as $category)
                <a href="{{ route('product.gallery', $category->slug) }}" class="product-card reveal" wire:navigate>
                    <div class="product-icon">
                        @if($category->thumbnail)
                            <img src="{{ url('storage/' . $category->thumbnail) }}" alt="{{ $category->name }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;">
                        @else
                            <span>✦</span>
                        @endif
                    </div>
                    <h3 class="product-name">{{ $category->name }}</h3>
                    <p class="product-desc">{{ $category->images_count }} Koleksi Desain Terupdate</p>
                    <div class="product-tag">Premium Quality</div>
                    <div class="product-arrow">→</div>
                </a>
            @empty
                <div class="product-card reveal">
                    <div class="product-icon">✦</div>
                    <h3 class="product-name">Kusen & Pintu</h3>
                    <p class="product-desc">Beragam pilihan kusen aluminium dengan presisi tinggi dan desain elegan.</p>
                    <div class="product-tag">Best Seller</div>
                    <div class="product-arrow">→</div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- ======================== SECTION 4: SHOWCASE ======================== -->
    <section id="showcase">
        <div class="showcase-inner">
            <div class="showcase-container">
                <div class="showcase-visual reveal-left">
                    <div class="showcase-card-main">
                        <div class="showcase-logo-display">
                            <span style="color: var(--gold-400); font-weight: 800;">FJA</span>
                        </div>

                        <div class="showcase-floating-card top-right">
                            <p class="floating-card-label">PROYEK SELESAI</p>
                            <p class="floating-card-value">500+</p>
                        </div>
                        <div class="showcase-floating-card bottom-left">
                            <p class="floating-card-label">KEPUASAN</p>
                            <p class="floating-card-value">100%</p>
                        </div>
                    </div>
                </div>

                <div class="showcase-content reveal-right">
                    <p class="section-label">Standar Kualitas</p>
                    <h2 class="section-title">Mengapa Memilih <br /> Faris Jaya?</h2>

                    <ul class="showcase-features">
                        <li class="showcase-feature">
                            <div class="feature-icon">✓</div>
                            <div class="feature-text">
                                <h4>Presisi & Akurasi</h4>
                                <p style="color: rgba(255,255,255,0.4); font-size: 14px;">Pemotongan dan perakitan
                                    menggunakan alat modern.</p>
                            </div>
                        </li>
                        <li class="showcase-feature">
                            <div class="feature-icon">✓</div>
                            <div class="feature-text">
                                <h4>Bahan Anti Korosi</h4>
                                <p style="color: rgba(255,255,255,0.4); font-size: 14px;">Aluminium kualitas tinggi
                                    tahan cuaca ekstrem.</p>
                            </div>
                        </li>
                        <li class="showcase-feature">
                            <div class="feature-icon">✓</div>
                            <div class="feature-text">
                                <h4>Tim Profesional</h4>
                                <p style="color: rgba(255,255,255,0.4); font-size: 14px;">Teknisi berpengalaman dalam
                                    proyek perumahan & gedung.</p>
                            </div>
                        </li>
                    </ul>

                    <div style="margin-top: 48px;">
                        <a href="https://wa.me/{{ $settings->whatsapp_number ?? '6281212345678' }}"
                            class="btn-primary">Minta Penawaran</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ======================== SECTION 6: TESTIMONIALS ======================== -->
    <section id="testimonials" style="padding: 120px 24px; max-width: 1200px; margin: 0 auto;">
        <div class="reveal" style="text-align: center; margin-bottom: 64px;">
            <p class="section-label">Testimoni</p>
            <h2 class="section-title">Apa Kata Mereka?</h2>
        </div>

        <div class="testimonials-slider">
            @forelse($testimonials as $testi)
                <div class="testimonial-card reveal">
                    <div class="testimonial-quote">"</div>
                    <div class="testimonial-stars">{{ str_repeat('★', $testi->stars) }}</div>
                    <p class="testimonial-text">"{{ $testi->content }}"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">{{ $testi->avatar_char }}</div>
                        <div class="author-info">
                            <h5>{{ $testi->name }}</h5>
                            <p>{{ $testi->location }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="testimonial-card reveal">
                    <div class="testimonial-quote">"</div>
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">"Pengerjaan sangat rapi dan tepat waktu. Hasilnya sesuai ekspektasi!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">P</div>
                        <div class="author-info">
                            <h5>Klien Faris Jaya</h5>
                            <p>Home Owner</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- ======================== SECTION 7: CTA ======================== -->
    <section id="contact">
        <div class="cta-container reveal">
            <p class="section-label" style="margin-bottom:16px">Mulai Sekarang</p>
            <h2 class="cta-title">Siap Wujudkan<br />Rumah Impian Anda?</h2>
            <p class="cta-sub">Konsultasikan kebutuhan aluminium Anda secara gratis dengan tim ahli kami. Dapatkan
                estimasi harga terbaik hari ini juga!</p>

            <div class="cta-actions">
                <a href="https://wa.me/{{ $settings->whatsapp_number ?? '6281212345678' }}" class="btn-whatsapp"
                    target="_blank" rel="noopener noreferrer">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Chat WhatsApp
                </a>
            </div>

            <div class="cta-info-cards" style="margin-top: 64px;">
                <div class="info-card reveal">
                    <div class="info-card-icon">📍</div>
                    <div class="info-card-title">Lokasi</div>
                    <div class="info-card-value">Jl. Aluminium Raya No. 1<br />Kota Anda</div>
                </div>
                <div class="info-card reveal">
                    <div class="info-card-icon">🕙</div>
                    <div class="info-card-title">Jam Operasional</div>
                    <div class="info-card-value">Senin–Sabtu<br />08.00 – 17.00 WIB</div>
                </div>
                <div class="info-card reveal">
                    <div class="info-card-icon">📱</div>
                    <div class="info-card-title">WhatsApp</div>
                    <div class="info-card-value">+{{ $settings->whatsapp_number ?? '62 812 1234 5678' }}</div>
                </div>
            </div>
        </div>
    </section>
</div>