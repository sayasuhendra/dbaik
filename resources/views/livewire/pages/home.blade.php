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
    public $frontendText;

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
        $this->frontendText = \App\Models\FrontendText::first();
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
                @if(!empty($settings->location_url))
                    <a href="{{ $settings->location_url }}" target="_blank" rel="noopener noreferrer" class="hero-badge"
                        style="text-decoration: none; position: relative; z-index: 20; cursor: pointer;">
                        <span>{{ $settings->location_text ?? 'Jakarta & Sekitarnya' }}</span>
                    </a>
                @else
                    <div class="hero-badge">
                        <span>{{ $settings->location_text ?? 'Jakarta & Sekitarnya' }}</span>
                    </div>
                @endif
                <h1 class="hero-title">
                    <span
                        class="gradient-text">{{ $settings->hero_title ?? 'Keindahan & Ketahanan Tanpa Kompromi' }}</span>
                </h1>
                <p class="hero-sub">
                    {{ $settings->hero_subtitle ?? 'Kusen, pintu, jendela, kaca & plafond alumunium berkualitas premium.' }}
                </p>

                <div class="hero-actions">
                    <a href="https://wa.me/{{ $settings->whatsapp_number ?? '6281212345678' }}" class="btn-primary">
                        <span>{{ $frontendText->hero['btn_primary'] ?? 'Konsultasi Gratis' }}</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                    </a>
                    <a href="#projects" class="btn-secondary"
                        x-on:click.prevent="gsap.to(window, {duration: 1, scrollTo: '#projects'})">{{ $frontendText->hero['btn_secondary'] ?? 'Lihat Portfolio' }}</a>
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
                    @foreach($frontendText->marquee ?? [] as $text)
                        <span class="marquee-icon">✦</span>
                        <span>{{ $text }}</span>
                        <span class="marquee-dot"></span>
                    @endforeach
                </div>
            @endfor
        </div>
    </section>

    <!-- ======================== SECTION 3: PORTFOLIO ======================== -->
    <section id="projects">
        <div class="reveal">
            <p class="section-label">{{ $frontendText->portfolio['label'] ?? 'Karya Terbaru' }}</p>
            <h2 class="section-title">{{ $frontendText->portfolio['title'] ?? 'Portfolio Proyek' }}</h2>
            <p class="section-sub">{{ $frontendText->portfolio['subtitle'] ?? 'Beberapa hasil pengerjaan terbaik kami untuk klien residensial dan komersial.' }}</p>
        </div>

        <div class="projects-grid">
            @forelse($projects as $project)
                <a href="{{ route('portfolio.detail', $project->id) }}" class="project-card reveal" wire:navigate
                    style="display: block; text-decoration: none;">
                    <div class="project-img-wrapper">
                        @php
                            $pPhoto = (is_array($project->photos) && isset($project->photos[0])) ? $project->photos[0] : null;
                            $pPhotoUrl = $pPhoto ? (str_starts_with($pPhoto, 'img/') ? asset($pPhoto) : asset('storage/' . $pPhoto)) : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80';
                        @endphp
                        <img src="{{ $pPhotoUrl }}" alt="{{ $project->title }}">
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
            <p class="section-label">{{ $frontendText->services['label'] ?? 'Layanan Kami' }}</p>
            <h2 class="section-title">{!! $frontendText->services['title'] ?? 'Solusi Aluminium <br /> Untuk Hunian Modern' !!}</h2>
            <p class="section-sub">{{ $frontendText->services['subtitle'] ?? 'Kualitas premium dengan desain minimalis yang meningkatkan estetika bangunan Anda.' }}</p>
        </div>

        <div class="products-grid">
            @forelse($categories as $category)
                <a href="{{ route('product.gallery', $category->slug) }}" class="product-card reveal" wire:navigate>
                    <div class="product-icon">
                        @if($category->thumbnail)
                            @php
                                $thumbUrl = str_starts_with($category->thumbnail, 'img/') ? asset($category->thumbnail) : asset('storage/' . $category->thumbnail);
                            @endphp
                            <img src="{{ $thumbUrl }}" alt="{{ $category->name }}"
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
                            @if($settings->square_logo)
                                <img src="{{ asset('storage/' . $settings->square_logo) }}" alt="Faris Jaya Logo"
                                    style="max-height: 300px; max-width: 300px; object-fit: contain;">
                            @else
                                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    style="height: 120px; width: 120px; color: var(--gold-400);">
                                    <rect x="10" y="10" width="80" height="80" rx="10" stroke="currentColor"
                                        stroke-width="5" />
                                    <!-- Elegant F -->
                                    <path d="M30 30h25M30 48h18M30 30v40" stroke="currentColor" stroke-width="5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <!-- Elegant J -->
                                    <path d="M70 30v30c0 5.5-4.5 10-10 10" stroke="currentColor" stroke-width="5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @endif
                        </div>

                        @if(isset($frontendText->showcase['badges']))
                            @foreach($frontendText->showcase['badges'] as $idx => $badge)
                                <div class="showcase-floating-card {{ $idx == 0 ? 'top-right' : 'bottom-left' }}">
                                    <p class="floating-card-label">{{ $badge['label'] ?? '' }}</p>
                                    <p class="floating-card-value">{{ $badge['value'] ?? '' }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="showcase-floating-card top-right">
                                <p class="floating-card-label">PROYEK SELESAI</p>
                                <p class="floating-card-value">500+</p>
                            </div>
                            <div class="showcase-floating-card bottom-left">
                                <p class="floating-card-label">KEPUASAN</p>
                                <p class="floating-card-value">100%</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="showcase-content reveal-right">
                    <p class="section-label">{{ $frontendText->showcase['label'] ?? 'Standar Kualitas' }}</p>
                    <h2 class="section-title">{!! $frontendText->showcase['title'] ?? 'Mengapa Memilih <br /> Faris Jaya?' !!}</h2>

                    <ul class="showcase-features">
                        @if(isset($frontendText->showcase['features']))
                            @foreach($frontendText->showcase['features'] as $feature)
                                <li class="showcase-feature">
                                    <div class="feature-icon">{{ $feature['icon'] ?? '✓' }}</div>
                                    <div class="feature-text">
                                        <h4>{{ $feature['title'] ?? '' }}</h4>
                                        <p style="color: rgba(255,255,255,0.4); font-size: 14px;">{{ $feature['desc'] ?? '' }}</p>
                                    </div>
                                </li>
                            @endforeach
                        @else
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
                        @endif
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
            <p class="section-label">{{ $frontendText->testimonials['label'] ?? 'Testimoni' }}</p>
            <h2 class="section-title">{{ $frontendText->testimonials['title'] ?? 'Apa Kata Mereka?' }}</h2>
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
            <p class="section-label" style="margin-bottom:16px">{{ $frontendText->cta['label'] ?? 'Mulai Sekarang' }}</p>
            <h2 class="cta-title">{!! $frontendText->cta['title'] ?? 'Siap Wujudkan<br />Rumah Impian Anda?' !!}</h2>
            <p class="cta-sub">{{ $frontendText->cta['subtitle'] ?? 'Konsultasikan kebutuhan aluminium Anda secara gratis dengan tim ahli kami. Dapatkan estimasi harga terbaik hari ini juga!' }}</p>

            <div class="cta-actions">
                <a href="https://wa.me/{{ $settings->whatsapp_number ?? '6281212345678' }}" class="btn-whatsapp"
                    target="_blank" rel="noopener noreferrer">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    {{ $frontendText->cta['button_text'] ?? 'Chat WhatsApp' }}
                </a>
            </div>

            <div class="cta-info-cards" style="margin-top: 64px;">
                <div class="info-card reveal">
                    <div class="info-card-icon">📍</div>
                    <div class="info-card-title">Lokasi</div>
                    <div class="info-card-value">
                        @if(!empty($settings->location_url))
                            <a href="{{ $settings->location_url }}" target="_blank" rel="noopener noreferrer"
                                style="color: inherit; text-decoration: none; border-bottom: 1px dashed rgba(255,255,255,0.4); padding-bottom: 2px;">{{ $settings->location_text ?? 'Jl. Aluminium Raya No. 1, Kota Anda' }}</a>
                        @else
                            {{ $settings->location_text ?? 'JI. Pangeran Antasari, Sumber. Cirebon' }}
                        @endif
                    </div>
                </div>
                <div class="info-card reveal">
                    <div class="info-card-icon">🕙</div>
                    <div class="info-card-title">Jam Operasional</div>
                    <div class="info-card-value">{{ $settings->office_hours ?? 'Senin–Sabtu, 08.00 – 17.00 WIB' }}</div>
                </div>
                <div class="info-card reveal">
                    <div class="info-card-icon">📱</div>
                    <div class="info-card-title">WhatsApp</div>
                    <div class="info-card-value">+{{ $settings->whatsapp_number ?? '+628170200885' }}</div>
                </div>
            </div>
        </div>
    </section>
</div>