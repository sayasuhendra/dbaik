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
        $this->categories = ProductCategory::all();
        $this->settings = SiteSetting::first() ?? new SiteSetting([
            'hero_title' => 'Membangun Masa Depan Digital dengan AI & Teknologi',
            'hero_subtitle' => 'DBAIK membantu bisnis dan organisasi berkembang melalui solusi AI, website, software, mobile app, automation, dan game development.',
            'whatsapp_number' => '628170200885',
            'office_hours' => 'Senin–Sabtu, 08.00 – 17.00 WIB',
            'location_text' => 'Bandung, Indonesia.'
        ]);
        $this->testimonials = Testimonial::where('is_active', true)->get();
        $this->frontendText = \App\Models\FrontendText::first();
    }
};

?>

<div x-data="{ activeCategory: 'all' }">
    @section('title', 'DBAIK Digital Agency — Silicon Valley Level AI & Technology Partner')

    <!-- ======================== 1. HERO SECTION ======================== -->
    <section id="hero" aria-label="Hero section">
        <div class="hero-bg"></div>
        <div class="hero-grid"></div>

        <div id="particles" class="particles"></div>

        <div class="container relative z-10 mx-auto max-w-7xl px-6">
            <div class="reveal text-center">
                <div class="hero-badge">
                    <span>{{ $settings->location_text ?? 'Bandung, Indonesia' }}</span>
                </div>
                <h1 class="hero-title mx-auto">
                    <span
                        class="gradient-text">{!! $settings->hero_title ?? 'Membangun Masa Depan Digital<br />dengan AI & Teknologi' !!}</span>
                </h1>
                <p class="hero-sub">
                    {{ $settings->hero_subtitle ?? 'DBAIK membantu bisnis dan organisasi berkembang melalui solusi AI, website, software, mobile app, automation, dan game development.' }}
                </p>

                <div class="hero-actions mb-16">
                    <a href="https://wa.me/{{ $settings->whatsapp_number ?? '628170200885' }}" class="btn-primary">
                        <span>{{ $frontendText->hero['btn_primary'] ?? 'Konsultasi Gratis' }}</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                    </a>
                    <a href="#projects" class="btn-secondary"
                        x-on:click.prevent="gsap.to(window, {duration: 1.2, scrollTo: {y: '#projects', offsetY: 80}})">{{ $frontendText->hero['btn_secondary'] ?? 'Lihat Portfolio' }}</a>
                </div>

                <!-- Floating Dashboard Mockup & AI Cards -->
                {{-- <div
                    class="relative mx-auto mt-12 max-w-5xl rounded-2xl border border-white/10 bg-slate-900/60 p-4 shadow-2xl backdrop-blur-2xl reveal">
                    <!-- Glow Accents Behind Mockup -->
                    <div class="absolute -top-12 -left-12 h-64 width-64 rounded-full bg-blue-500/10 blur-[80px]"></div>
                    <div class="absolute -bottom-12 -right-12 h-64 width-64 rounded-full bg-purple-500/10 blur-[80px]">
                    </div>

                    <div class="rounded-xl border border-white/5 bg-slate-950/80 p-2 md:p-6 overflow-hidden">
                        <!-- Top Chrome Bar -->
                        <div class="flex items-center justify-between border-b border-white/5 pb-4 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-rose-500/80"></span>
                                <span class="h-3 w-3 rounded-full bg-amber-500/80"></span>
                                <span class="h-3 w-3 rounded-full bg-emerald-500/80"></span>
                            </div>
                            <div class="hidden sm:block text-xs font-semibold tracking-wider text-slate-500">
                                DBAIK_AI_ENGINE_v2.0_STABLE</div>
                            <div class="h-4 w-4 rounded bg-slate-800"></div>
                        </div>

                        <!-- Inner Layout -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                            <div class="md:col-span-2 rounded-lg border border-white/5 bg-slate-900/40 p-6">
                                <h3 class="text-sm font-bold tracking-widest text-cyan-400 mb-4">✦ REAL-TIME PREDICTIONS
                                </h3>
                                <div
                                    class="h-36 rounded-md bg-slate-950/60 p-4 flex items-end gap-2 border border-white/5 relative">
                                    <!-- Simple SVG Chart -->
                                    <svg viewBox="0 0 300 100"
                                        class="absolute inset-0 h-full w-full p-2 text-blue-500/20"
                                        preserveAspectRatio="none">
                                        <path d="M0,80 Q50,40 100,70 T200,30 T300,10" fill="none" stroke="currentColor"
                                            stroke-width="4"></path>
                                        <path d="M0,80 Q50,40 100,70 T200,30 T300,10 L300,100 L0,100 Z"
                                            fill="rgba(59, 130, 246, 0.05)"></path>
                                    </svg>
                                    <svg viewBox="0 0 300 100" class="absolute inset-0 h-full w-full p-2 text-cyan-400"
                                        preserveAspectRatio="none">
                                        <path d="M0,90 Q50,60 100,80 T200,40 T300,20" fill="none" stroke="currentColor"
                                            stroke-width="3" stroke-linecap="round"></path>
                                    </svg>
                                    <div class="absolute top-4 right-4 flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                                        <span class="text-[10px] font-bold text-slate-400 tracking-wider">LIVE DATA
                                            FEED</span>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div
                                    class="rounded-lg border border-white/5 bg-slate-900/40 p-4 relative overflow-hidden">
                                    <div class="absolute top-0 right-0 h-16 w-16 bg-purple-500/5 rounded-bl-full"></div>
                                    <p class="text-[10px] font-bold text-slate-400 tracking-widest">AGENT STATUS</p>
                                    <h4 class="text-xl font-black text-white mt-1">99.9% ACCURACY</h4>
                                    <p class="text-xs text-slate-500 mt-2">Multi-modal AI pipeline active</p>
                                </div>
                                <div class="rounded-lg border border-white/5 bg-slate-900/40 p-4">
                                    <p class="text-[10px] font-bold text-slate-400 tracking-widest">AUTOMATIONS ACTIVE
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-lg font-bold text-cyan-400">14,204/hr</span>
                                        <span
                                            class="text-xs text-emerald-400 font-bold bg-emerald-950/50 px-2 py-0.5 rounded border border-emerald-900/20">+12.4%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        <div class="hero-scroll-indicator">
            <span>Gulir untuk Eksplorasi</span>
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- ======================== 2. TRUST / STATS SECTION ======================== -->
    <section id="stats" class="relative z-10 py-24">
        <div class="container mx-auto max-w-7xl px-6">
            <div class="reveal text-center mb-16">
                <p class="section-label">PERFORMA DAN KREDIBILITAS</p>
                <h2 class="section-title">Hasil Nyata yang Terukur</h2>
                <p class="section-sub mx-auto">Kami berfokus pada efisiensi operasional dan peningkatan konversi bisnis
                    Anda melalui arsitektur software masa kini.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number" data-target="120">0</span>
                    <span class="stat-label">Proyek Selesai</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="100">0</span>
                    <span class="stat-label">Kepuasan Klien</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="8">0</span>
                    <span class="stat-label">Tahun Pengalaman</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="50">0</span>
                    <span class="stat-label">Solusi AI Sukses</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================== 3. SERVICES SECTION ======================== -->
    <section id="products" class="relative z-10 py-32 bg-slate-900/20">
        <div class="container mx-auto max-w-7xl px-6">
            <div class="reveal mb-16">
                <p class="section-label">{{ $frontendText->services['label'] ?? 'Layanan Kami' }}</p>
                <h2 class="section-title">{!! $frontendText->services['title'] ?? 'Layanan Teknologi Masa Depan' !!}
                </h2>
                <p class="section-sub">
                    {{ $frontendText->services['subtitle'] ?? 'Kami menghadirkan ekosistem teknologi modern mulai dari kecerdasan buatan, pengembangan software, hingga game development.' }}
                </p>
            </div>

            <div class="products-grid">
                <!-- 1. AI Solutions -->
                <div class="product-card reveal"
                    x-on:click="window.location='{{ route('product.gallery', 'ai-solutions') }}'">
                    <div>
                        <div class="product-icon text-cyan-400">🤖</div>
                        <h3 class="product-name">AI Solutions</h3>
                        <p class="product-desc">Integrasi kecerdasan buatan ke sistem bisnis Anda, analisis data tingkat
                            lanjut, pengenalan gambar, serta kecerdasan adaptif.</p>
                    </div>
                    <div class="flex flex-col gap-4 mt-6">
                        <div class="product-tag">TensorFlow • OpenAI • PyTorch</div>
                        <div class="product-arrow">→</div>
                    </div>
                </div>

                <!-- 2. Website Development -->
                <div class="product-card reveal"
                    x-on:click="window.location='{{ route('product.gallery', 'website-development') }}'">
                    <div>
                        <div class="product-icon text-blue-400">💻</div>
                        <h3 class="product-name">Website Development</h3>
                        <p class="product-desc">Platform web modern yang responsif, berkecepatan tinggi, SEO-friendly,
                            dengan desain UX eksklusif standar Awwwards.</p>
                    </div>
                    <div class="flex flex-col gap-4 mt-6">
                        <div class="product-tag">Next.js • Laravel • Tailwind</div>
                        <div class="product-arrow">→</div>
                    </div>
                </div>

                <!-- 3. Software Development -->
                <div class="product-card reveal"
                    x-on:click="window.location='{{ route('product.gallery', 'software-development') }}'">
                    <div>
                        <div class="product-icon text-purple-400">🚀</div>
                        <h3 class="product-name">Software Development</h3>
                        <p class="product-desc">Sistem SaaS kustom, portal ERP/CRM perusahaan, core platform berskala
                            enterprise dengan keandalan tinggi.</p>
                    </div>
                    <div class="flex flex-col gap-4 mt-6">
                        <div class="product-tag">Node.js • Python • PostgreSQL</div>
                        <div class="product-arrow">→</div>
                    </div>
                </div>

                <!-- 4. Mobile App Development -->
                <div class="product-card reveal"
                    x-on:click="window.location='{{ route('product.gallery', 'mobile-app-development') }}'">
                    <div>
                        <div class="product-icon text-indigo-400">📱</div>
                        <h3 class="product-name">Mobile App Development</h3>
                        <p class="product-desc">Aplikasi mobile native dan cross-platform dengan interaksi antarmuka
                            yang sangat mulus dan ramah pengguna.</p>
                    </div>
                    <div class="flex flex-col gap-4 mt-6">
                        <div class="product-tag">Flutter • React Native • Swift</div>
                        <div class="product-arrow">→</div>
                    </div>
                </div>

                <!-- 5. AI Automation -->
                <div class="product-card reveal"
                    x-on:click="window.location='{{ route('product.gallery', 'ai-automation') }}'">
                    <div>
                        <div class="product-icon text-emerald-400">🧠</div>
                        <h3 class="product-name">AI Automation</h3>
                        <p class="product-desc">Penerapan AI Agents otonom untuk merevolusi efisiensi divisi internal
                            Anda tanpa keterlibatan manual konstan.</p>
                    </div>
                    <div class="flex flex-col gap-4 mt-6">
                        <div class="product-tag">LangChain • n8n • AutoGPT</div>
                        <div class="product-arrow">→</div>
                    </div>
                </div>

                <!-- 6. Business Automation -->
                <div class="product-card reveal"
                    x-on:click="window.location='{{ route('product.gallery', 'business-automation') }}'">
                    <div>
                        <div class="product-icon text-amber-400">⚡</div>
                        <h3 class="product-name">Business Automation</h3>
                        <p class="product-desc">Automasi alur data, integrasi API sistem lama dengan platform cloud
                            modern untuk mempercepat proses birokrasi bisnis.</p>
                    </div>
                    <div class="flex flex-col gap-4 mt-6">
                        <div class="product-tag">Make • Zapier • Custom APIs</div>
                        <div class="product-arrow">→</div>
                    </div>
                </div>

                <!-- 7. Game Development -->
                <div class="product-card reveal"
                    x-on:click="window.location='{{ route('product.gallery', 'game-development') }}'">
                    <div>
                        <div class="product-icon text-rose-400">🎮</div>
                        <h3 class="product-name">Game Development</h3>
                        <p class="product-desc">Menciptakan game 2D & 3D interaktif untuk tujuan edukasi, brand
                            activations, gamifikasi, serta pasar global.</p>
                    </div>
                    <div class="flex flex-col gap-4 mt-6">
                        <div class="product-tag">Unity • Unreal Engine • WebGL</div>
                        <div class="product-arrow">→</div>
                    </div>
                </div>

                <!-- 8. Technology Consulting -->
                <div class="product-card reveal"
                    x-on:click="window.location='{{ route('product.gallery', 'technology-consulting') }}'">
                    <div>
                        <div class="product-icon text-sky-400">🔮</div>
                        <h3 class="product-name">Technology Consulting</h3>
                        <p class="product-desc">Riset arsitektur sistem, audit keamanan siber, strategi transformasi
                            digital untuk korporasi dan institusi pendidikan.</p>
                    </div>
                    <div class="flex flex-col gap-4 mt-6">
                        <div class="product-tag">Enterprise System • Cybersecurity</div>
                        <div class="product-arrow">→</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================== 4. AI SOLUTIONS SHOWCASE ======================== -->
    {{-- <section id="ai-showcase" class="relative z-10 py-32 overflow-hidden bg-slate-950">
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-[500px] w-[500px] rounded-full bg-cyan-500/5 blur-[120px] pointer-events-none">
        </div>

        <div class="container mx-auto max-w-7xl px-6">
            <div class="reveal text-center mb-20">
                <p class="section-label">AI SOLUTIONS SHOWCASE</p>
                <h2 class="section-title">Masa Depan AI Agents Terintegrasi</h2>
                <p class="section-sub mx-auto">Lihat bagaimana modul kecerdasan buatan otonom kami menyatu ke dalam
                    sistem bisnis Anda dengan representasi dasbor modern.</p>
            </div>

            <!-- Interactive AI Tabbed Showcase Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center" x-data="{ currentAiTab: 0 }">
                <!-- Left Sidebar Nav -->
                <div class="lg:col-span-4 space-y-3">
                    <button class="w-full text-left p-6 rounded-2xl border transition-all duration-300"
                        :class="currentAiTab === 0 ? 'bg-slate-900/80 border-cyan-500/40 shadow-[0_0_20px_rgba(6,182,212,0.1)]' : 'bg-transparent border-white/5 hover:border-white/10'"
                        x-on:click="currentAiTab = 0">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl" :class="currentAiTab === 0 ? 'scale-110' : ''">💬</span>
                            <div>
                                <h4 class="font-bold text-white text-base">AI Chatbot & CS Agent</h4>
                                <p class="text-xs text-slate-400 mt-1">Mengotomatiskan dukungan 24/7 dengan bahasa
                                    alami.</p>
                            </div>
                        </div>
                    </button>
                    <button class="w-full text-left p-6 rounded-2xl border transition-all duration-300"
                        :class="currentAiTab === 1 ? 'bg-slate-900/80 border-purple-500/40 shadow-[0_0_20px_rgba(168,85,247,0.1)]' : 'bg-transparent border-white/5 hover:border-white/10'"
                        x-on:click="currentAiTab = 1">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl" :class="currentAiTab === 1 ? 'scale-110' : ''">📊</span>
                            <div>
                                <h4 class="font-bold text-white text-base">AI Data Analysis</h4>
                                <p class="text-xs text-slate-400 mt-1">Prediksi perilaku pengguna & analitis cerdas.</p>
                            </div>
                        </div>
                    </button>
                    <button class="w-full text-left p-6 rounded-2xl border transition-all duration-300"
                        :class="currentAiTab === 2 ? 'bg-slate-900/80 border-blue-500/40 shadow-[0_0_20px_rgba(59,130,246,0.1)]' : 'bg-transparent border-white/5 hover:border-white/10'"
                        x-on:click="currentAiTab = 2">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl" :class="currentAiTab === 2 ? 'scale-110' : ''">✍️</span>
                            <div>
                                <h4 class="font-bold text-white text-base">AI Content Generator</h4>
                                <p class="text-xs text-slate-400 mt-1">Pembuatan konten marketing & blog instan.</p>
                            </div>
                        </div>
                    </button>
                    <button class="w-full text-left p-6 rounded-2xl border transition-all duration-300"
                        :class="currentAiTab === 3 ? 'bg-slate-900/80 border-emerald-500/40 shadow-[0_0_20px_rgba(16,185,129,0.1)]' : 'bg-transparent border-white/5 hover:border-white/10'"
                        x-on:click="currentAiTab = 3">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl" :class="currentAiTab === 3 ? 'scale-110' : ''">🧠</span>
                            <div>
                                <h4 class="font-bold text-white text-base">AI Agent Workflows</h4>
                                <p class="text-xs text-slate-400 mt-1">Otomasi rantai kerja logistik & supply chain.</p>
                            </div>
                        </div>
                    </button>
                </div>

                <!-- Right Simulated Interface Display (Holographic mockup feeling) -->
                <div
                    class="lg:col-span-8 rounded-3xl border border-white/10 bg-slate-900/40 p-6 md:p-8 relative min-h-[400px] flex flex-col justify-between overflow-hidden shadow-2xl backdrop-blur-2xl">
                    <!-- Glow background -->
                    <div class="absolute inset-0 bg-gradient-to-tr opacity-10 pointer-events-none"
                        :class="currentAiTab === 0 ? 'from-cyan-500 to-blue-500' : currentAiTab === 1 ? 'from-purple-500 to-rose-500' : currentAiTab === 2 ? 'from-blue-500 to-indigo-500' : 'from-emerald-500 to-cyan-500'">
                    </div>

                    <!-- Screen Content 0: AI Chatbot -->
                    <div x-show="currentAiTab === 0" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" class="space-y-6">
                        <div class="flex items-center justify-between border-b border-white/5 pb-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="h-10 w-10 rounded-full bg-cyan-950 flex items-center justify-center text-cyan-400 border border-cyan-800/40 font-bold">🤖</span>
                                <div>
                                    <h4 class="text-sm font-bold text-white">DBAIK Support Agent v2</h4>
                                    <p class="text-[10px] text-emerald-400 font-bold flex items-center gap-1"><span
                                            class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-ping"></span> ONLINE
                                        • SYNCED</p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-500">Latency: 28ms</span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex gap-3 max-w-[80%]">
                                <div
                                    class="h-8 w-8 rounded-full bg-slate-800 flex-shrink-0 flex items-center justify-center text-xs">
                                    👤</div>
                                <div class="bg-slate-800/60 p-4 rounded-2xl rounded-tl-none border border-white/5">
                                    <p class="text-xs text-white">Bagaimana saya bisa mengintegrasikan sistem inventaris
                                        toko kami dengan website yang baru?</p>
                                </div>
                            </div>
                            <div class="flex gap-3 max-w-[80%] ml-auto justify-end">
                                <div
                                    class="bg-cyan-950/40 border border-cyan-800/30 p-4 rounded-2xl rounded-tr-none text-right">
                                    <p class="text-xs text-cyan-100">Tentu! DBAIK AI Agent dapat terhubung langsung ke
                                        API ERP inventaris Anda. Kami menyediakan modul sinkronisasi otonom yang
                                        memperbarui stok secara real-time setiap kali transaksi terjadi di e-commerce.
                                    </p>
                                </div>
                                <div
                                    class="h-8 w-8 rounded-full bg-cyan-500/20 flex-shrink-0 flex items-center justify-center text-xs border border-cyan-500/40">
                                    🤖</div>
                            </div>
                        </div>
                    </div>

                    <!-- Screen Content 1: AI Data Analysis -->
                    <div x-show="currentAiTab === 1" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" class="space-y-6">
                        <div class="flex items-center justify-between border-b border-white/5 pb-4">
                            <div>
                                <h4 class="text-sm font-bold text-white">Predictive Sales Analysis Dashboard</h4>
                                <p class="text-[10px] text-slate-500">PROJECTIONS FOR Q3 2026</p>
                            </div>
                            <span
                                class="text-xs font-bold text-purple-400 bg-purple-950/50 px-2 py-0.5 rounded border border-purple-800/30">CONFIDENCE:
                                96%</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="p-4 rounded-xl bg-slate-950/60 border border-white/5">
                                <p class="text-[10px] text-slate-500 tracking-wider">PROJECTED REVENUE</p>
                                <p class="text-xl font-black text-white mt-1">$482.4K</p>
                                <p class="text-[10px] text-emerald-400 font-bold mt-1">↑ +24% vs last quarter</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-950/60 border border-white/5">
                                <p class="text-[10px] text-slate-500 tracking-wider">USER CHURN PROBABILITY</p>
                                <p class="text-xl font-black text-white mt-1">1.8%</p>
                                <p class="text-[10px] text-emerald-400 font-bold mt-1">↓ -8% optimization</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-950/60 border border-white/5">
                                <p class="text-[10px] text-slate-500 tracking-wider">AI EFFICIENCY ROI</p>
                                <p class="text-xl font-black text-white mt-1">3.4x</p>
                                <p class="text-[10px] text-purple-400 font-bold mt-1">Fully optimized pipeline</p>
                            </div>
                        </div>
                        <div
                            class="h-28 rounded-lg bg-slate-950/80 border border-white/5 p-4 flex items-end justify-between relative overflow-hidden">
                            <!-- Glowing lines represent predictive future chart -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-xs font-semibold text-slate-600 tracking-widest">ANALYSIS PATTERN
                                    GRAPH</span>
                            </div>
                        </div>
                    </div>

                    <!-- Screen Content 2: AI Content Generator -->
                    <div x-show="currentAiTab === 2" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" class="space-y-6">
                        <div class="flex items-center justify-between border-b border-white/5 pb-4">
                            <div>
                                <h4 class="text-sm font-bold text-white">AI Content Engine & Copywriter</h4>
                                <p class="text-[10px] text-slate-500">CAMPAIGN CONTEXT: SAAS LAUNCH</p>
                            </div>
                            <span
                                class="text-xs text-blue-400 font-bold bg-blue-950/30 px-3 py-1 rounded-full border border-blue-900/30">Ad
                                Copy Mode</span>
                        </div>
                        <div class="space-y-4">
                            <div class="p-4 rounded-xl bg-slate-950/60 border border-white/5 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] text-cyan-400 font-bold">VARIANT A - Visionary Tone</span>
                                    <span class="text-[10px] text-slate-500">Copied</span>
                                </div>
                                <p class="text-xs text-slate-300 italic">"Jangan biarkan birokrasi manual menghambat
                                    pertumbuhan bisnis Anda. Saatnya beralih ke otomatisasi AI cerdas DBAIK. Hemat
                                    waktu, scale up instan."</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-950/60 border border-white/5 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] text-purple-400 font-bold">VARIANT B - ROI-Focused
                                        Tone</span>
                                    <span class="text-[10px] text-slate-500">Unused</span>
                                </div>
                                <p class="text-xs text-slate-300 italic">"Pangkas biaya operasional tim dukungan Anda
                                    hingga 70% dengan AI CS Agent modular dari DBAIK. Tingkatkan rasio penyelesaian
                                    dalam 24 jam."</p>
                            </div>
                        </div>
                    </div>

                    <!-- Screen Content 3: AI Agent Workflows -->
                    <div x-show="currentAiTab === 3" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" class="space-y-6">
                        <div class="flex items-center justify-between border-b border-white/5 pb-4">
                            <div>
                                <h4 class="text-sm font-bold text-white">Logistics & Supply Chain Orchestration</h4>
                                <p class="text-[10px] text-slate-500">AUTONOMOUS MULTI-AGENT STATE</p>
                            </div>
                            <span
                                class="text-xs text-emerald-400 font-bold bg-emerald-950/30 px-3 py-1 rounded-full border border-emerald-900/30">Active</span>
                        </div>
                        <div class="space-y-3">
                            <div
                                class="flex items-center justify-between p-3 rounded-lg bg-slate-950/60 border border-white/5">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="h-6 w-6 rounded-full bg-emerald-950 flex items-center justify-center text-xs text-emerald-400">✓</span>
                                    <span class="text-xs text-slate-300">Agent Alpha: Scan incoming cargo manifest &
                                        verify serials</span>
                                </div>
                                <span class="text-[10px] text-emerald-400 font-bold">Completed</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 rounded-lg bg-slate-950/60 border border-white/5">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="h-6 w-6 rounded-full bg-emerald-950 flex items-center justify-center text-xs text-emerald-400">✓</span>
                                    <span class="text-xs text-slate-300">Agent Beta: Recalculate optimal shipping paths
                                        based on weather data</span>
                                </div>
                                <span class="text-[10px] text-emerald-400 font-bold">Completed</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 rounded-lg bg-slate-950/60 border border-white/5">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="h-6 w-6 rounded-full bg-blue-950 flex items-center justify-center text-xs text-blue-400 animate-spin">⟳</span>
                                    <span class="text-xs text-slate-300">Agent Gamma: Dispatch automated dispatch
                                        invoices to vendor partners</span>
                                </div>
                                <span class="text-[10px] text-blue-400 font-bold">Processing</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- ======================== 5. PORTFOLIO SECTION ======================== -->
    <section id="projects" class="relative z-10 py-32 bg-slate-900/10">
        <div class="container mx-auto max-w-7xl px-6">
            <div class="reveal">
                <p class="section-label">{{ $frontendText->portfolio['label'] ?? 'Karya Unggulan' }}</p>
                <h2 class="section-title">{{ $frontendText->portfolio['title'] ?? 'Digital Product Showcase' }}</h2>
                <p class="section-sub">
                    {{ $frontendText->portfolio['subtitle'] ?? 'Jelajahi portofolio proyek enterprise dan startup modern yang kami rancang dengan teknologi terdepan.' }}
                </p>
            </div>

            <!-- Categories Tabs -->
            <div class="flex flex-wrap items-center gap-4 mb-12 reveal">
                <button class="px-8 py-3 rounded-full text-sm font-bold transition-all border"
                    :class="activeCategory === 'all' ? 'bg-cyan-500 text-slate-950 border-cyan-400 font-extrabold shadow-[0_0_15px_rgba(6,182,212,0.3)]' : 'bg-transparent text-slate-300 border-white/10 hover:border-white/20'"
                    x-on:click="activeCategory = 'all'">Semua Proyek</button>
                <button class="px-8 py-3 rounded-full text-sm font-bold transition-all border"
                    :class="activeCategory === 'AI Systems' ? 'bg-cyan-500 text-slate-950 border-cyan-400 font-extrabold shadow-[0_0_15px_rgba(6,182,212,0.3)]' : 'bg-transparent text-slate-300 border-white/10 hover:border-white/20'"
                    x-on:click="activeCategory = 'AI Systems'">AI Systems</button>
                <button class="px-8 py-3 rounded-full text-sm font-bold transition-all border"
                    :class="activeCategory === 'SaaS Platforms' ? 'bg-cyan-500 text-slate-950 border-cyan-400 font-extrabold shadow-[0_0_15px_rgba(6,182,212,0.3)]' : 'bg-transparent text-slate-300 border-white/10 hover:border-white/20'"
                    x-on:click="activeCategory = 'SaaS Platforms'">SaaS Platforms</button>
                <button class="px-8 py-3 rounded-full text-sm font-bold transition-all border"
                    :class="activeCategory === 'Mobile Apps' ? 'bg-cyan-500 text-slate-950 border-cyan-400 font-extrabold shadow-[0_0_15px_rgba(6,182,212,0.3)]' : 'bg-transparent text-slate-300 border-white/10 hover:border-white/20'"
                    x-on:click="activeCategory = 'Mobile Apps'">Mobile Apps</button>
                <button class="px-8 py-3 rounded-full text-sm font-bold transition-all border"
                    :class="activeCategory === 'Game Projects' ? 'bg-cyan-500 text-slate-950 border-cyan-400 font-extrabold shadow-[0_0_15px_rgba(6,182,212,0.3)]' : 'bg-transparent text-slate-300 border-white/10 hover:border-white/20'"
                    x-on:click="activeCategory = 'Game Projects'">Game Projects</button>
            </div>

            <div class="projects-grid">
                @forelse($projects as $project)
                    <div class="project-card reveal"
                        x-show="activeCategory === 'all' || activeCategory === '{{ $project->category }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translateY(20px)"
                        x-on:click="window.location='{{ route('portfolio.detail', $project->id) }}'"
                        style="display: flex; flex-direction: column;">
                        <div class="project-img-wrapper">
                            @php
                                $pPhoto = (is_array($project->photos) && isset($project->photos[0])) ? $project->photos[0] : null;
                                $pPhotoUrl = $pPhoto ? (str_starts_with($pPhoto, 'http') || str_starts_with($pPhoto, 'img/') ? $pPhoto : asset('storage/' . $pPhoto)) : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80';
                            @endphp
                            <img src="{{ $pPhotoUrl }}" alt="{{ $project->title }}" loading="lazy">
                            <div
                                class="absolute top-4 left-4 bg-slate-950/80 border border-white/15 px-4 py-2 rounded-full text-[10px] font-bold tracking-widest text-cyan-400 uppercase">
                                {{ $project->type }}
                            </div>
                        </div>
                        <div class="project-info flex-grow flex flex-col justify-between">
                            <div>
                                <p class="project-category">{{ $project->category }}</p>
                                <h3 class="project-title">{{ $project->title }}</h3>
                            </div>
                            <div class="border-t border-white/10 w-full" style="margin-bottom: 6px;">
                                <div class="flex items-center justify-between pt-6 w-full">
                                    <div>
                                        <span class="project-location text-sm">📍 {{ $project->location }}</span>
                                        <span class="text-sm font-bold text-slate-400">{{ $project->year }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="reveal col-span-3 text-center" style="color: rgba(255,255,255,0.4);">Belum ada proyek yang
                        ditampilkan.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ======================== 6. PROCESS SECTION ======================== -->
    <section id="process" class="relative z-10 py-32 bg-slate-950">
        <div class="container mx-auto max-w-7xl px-6">
            <div class="reveal text-center mb-20">
                <p class="section-label">FLOW WORKFLOW</p>
                <h2 class="section-title">Bagaimana Kami Bekerja</h2>
                <p class="section-sub mx-auto">Kami mengadopsi metodologi pengembangan iteratif yang transparan untuk
                    merealisasikan visi digital Anda secara presisi.</p>
            </div>

            <div class="process-steps">
                <!-- Step 1 -->
                <div class="process-step reveal">
                    <span class="step-number">01</span>
                    <div class="step-icon">🔍</div>
                    <h3 class="step-title">Discovery</h3>
                    <p class="step-desc">Riset awal mendalam, wawancara pemangku kepentingan, dan analisis kebutuhan
                        bisnis spesifik Anda.</p>
                </div>
                <!-- Step 2 -->
                <div class="process-step reveal">
                    <span class="step-number">02</span>
                    <div class="step-icon">🎯</div>
                    <h3 class="step-title">Strategy</h3>
                    <p class="step-desc">Pemilihan stack teknologi, estimasi arsitektur scalable, dan penyusunan peta
                        jalan (roadmap) detail.</p>
                </div>
                <!-- Step 3 -->
                <div class="process-step reveal">
                    <span class="step-number">03</span>
                    <div class="step-icon">🎨</div>
                    <h3 class="step-title">Design</h3>
                    <p class="step-desc">Prototyping interaktif resolusi tinggi, desain antarmuka modern (UI), dan
                        pengujian alur pengguna (UX).</p>
                </div>
                <!-- Step 4 -->
                <div class="process-step reveal">
                    <span class="step-number">04</span>
                    <div class="step-icon">💻</div>
                    <h3 class="step-title">Development</h3>
                    <p class="step-desc">Koding bersih dengan arsitektur bersih, integrasi API pihak ketiga, dan
                        implementasi modul AI.</p>
                </div>
                <!-- Step 5 -->
                <div class="process-step reveal">
                    <span class="step-number">05</span>
                    <div class="step-icon">🧪</div>
                    <h3 class="step-title">Testing</h3>
                    <p class="step-desc">Pengujian otomatis komprehensif, uji beban, audit keamanan siber, dan
                        penyesuaian fungsional.</p>
                </div>
                <!-- Step 6 -->
                <div class="process-step reveal">
                    <span class="step-number">06</span>
                    <div class="step-icon">🚀</div>
                    <h3 class="step-title">Launch</h3>
                    <p class="step-desc">Penyebaran (deployment) aman ke server cloud premium, konfigurasi SSL, dan
                        go-live produksi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================== 7. WHY CHOOSE DBAIK ======================== -->
    <section id="why-choose" class="relative z-10 py-32 bg-slate-900/10">
        <div class="container mx-auto max-w-7xl px-6">
            <div class="reveal text-center mb-20">
                <p class="section-label">MENGAPA KAMI BEDA</p>
                <h2 class="section-title">Solusi Berorientasi Bisnis</h2>
                <p class="section-sub mx-auto">Kami tidak sekadar menulis baris kode, kami merancang instrumen digital
                    untuk akselerasi pertumbuhan korporasi Anda.</p>
            </div>

            <div class="why-choose-grid">
                <!-- Feature 1 -->
                <div class="p-8 rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-md reveal">
                    <div class="text-3xl mb-4">🎯</div>
                    <h4 class="text-lg font-bold text-white mb-2">Fokus Solusi Nyata</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Setiap fitur AI dan software kami arahkan untuk
                        meningkatkan konversi dan efisiensi waktu.</p>
                </div>
                <!-- Feature 2 -->
                <div class="p-8 rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-md reveal">
                    <div class="text-3xl mb-4">👥</div>
                    <h4 class="text-lg font-bold text-white mb-2">Tim Berpengalaman</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Insinyur software dan desainer kami telah melayani
                        ratusan korporasi & startup multinasional.</p>
                </div>
                <!-- Feature 3 -->
                <div class="p-8 rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-md reveal">
                    <div class="text-3xl mb-4">⚙️</div>
                    <h4 class="text-lg font-bold text-white mb-2">Teknologi Modern</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Mengadopsi ekosistem Next.js, Docker, Laravel, dan
                        GraphQL untuk ketahanan performa optimal.</p>
                </div>
                <!-- Feature 4 -->
                <div class="p-8 rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-md reveal">
                    <div class="text-3xl mb-4">🧠</div>
                    <h4 class="text-lg font-bold text-white mb-2">AI-Driven Workflow</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Pengembangan super cepat memanfaatkan alur
                        otomatis kecerdasan buatan otonom.</p>
                </div>
                <!-- Feature 5 -->
                <div class="p-8 rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-md reveal">
                    <div class="text-3xl mb-4">🌐</div>
                    <h4 class="text-lg font-bold text-white mb-2">Scalable Architecture</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Sistem siap menampung jutaan hit harian tanpa
                        kendala performa berkat arsitektur modern.</p>
                </div>
                <!-- Feature 6 -->
                <div class="p-8 rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-md reveal">
                    <div class="text-3xl mb-4">🛠️</div>
                    <h4 class="text-lg font-bold text-white mb-2">Support & Maintenance</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Layanan purna jual prima dengan SLAs bergaransi
                        dan pembaruan berkala sistem Anda.</p>
                </div>
                <!-- Feature 7 -->
                <div class="p-8 rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-md reveal">
                    <div class="text-3xl mb-4">⚡</div>
                    <h4 class="text-lg font-bold text-white mb-2">Fast Development</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Kami menerapkan metodologi Agile ketat untuk
                        merilis MVP Anda dalam waktu singkat.</p>
                </div>
                <!-- Feature 8 -->
                <div class="p-8 rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-md reveal">
                    <div class="text-3xl mb-4">📈</div>
                    <h4 class="text-lg font-bold text-white mb-2">Business-Oriented</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Kami tidak sekadar berfokus pada estetika visual,
                        tapi juga konversi bisnis riil Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================== 8. TECHNOLOGY STACK ======================== -->
    <section id="tech-stack" class="relative z-10 py-32 bg-slate-950">
        <div class="container mx-auto max-w-7xl px-6">
            <div class="reveal text-center mb-20">
                <p class="section-label">EKOSISTEM MODERN</p>
                <h2 class="section-title">Teknologi yang Kami Gunakan</h2>
                <p class="section-sub mx-auto">Kami memadukan stack teknologi termutakhir untuk performa aplikasi
                    secepat kilat dan aman dari celah siber.</p>
            </div>

            <!-- Glowing Tech Grid -->
            <div class="tech-grid reveal">
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-cyan-500/30 hover:bg-slate-900/60">
                    <span class="text-2xl">⚡</span>
                    <span class="text-sm font-bold text-white">Next.js</span>
                    <span class="text-[10px] text-slate-500">React Framework</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-rose-500/30 hover:bg-slate-900/60">
                    <span class="text-2xl">🔥</span>
                    <span class="text-sm font-bold text-white">Laravel</span>
                    <span class="text-[10px] text-slate-500">PHP Framework</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-blue-500/30 hover:bg-slate-900/60">
                    <span class="text-2xl">⚛️</span>
                    <span class="text-sm font-bold text-white">React</span>
                    <span class="text-[10px] text-slate-500">Component Library</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-emerald-500/30 hover:bg-slate-900/60">
                    <span class="text-2xl">🟢</span>
                    <span class="text-sm font-bold text-white">Node.js</span>
                    <span class="text-[10px] text-slate-500">JS Runtime</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-amber-500/30 hover:bg-slate-900/60">
                    <span class="text-2xl">🐍</span>
                    <span class="text-sm font-bold text-white">Python</span>
                    <span class="text-[10px] text-slate-500">AI / ML Language</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-sky-500/30 hover:bg-slate-900/60">
                    <span class="text-2xl">📱</span>
                    <span class="text-sm font-bold text-white">Flutter</span>
                    <span class="text-[10px] text-slate-500">Mobile SDK</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-emerald-400/30 hover:bg-slate-900/60">
                    <span class="text-2xl">⚡</span>
                    <span class="text-sm font-bold text-white">Supabase</span>
                    <span class="text-[10px] text-slate-500">Open Source Firebase</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-orange-500/30 hover:bg-slate-900/60">
                    <span class="text-2xl">🔥</span>
                    <span class="text-sm font-bold text-white">Firebase</span>
                    <span class="text-[10px] text-slate-500">Google Backend Service</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-violet-500/30 hover:bg-slate-900/60">
                    <span class="text-2xl">🧠</span>
                    <span class="text-sm font-bold text-white">OpenAI</span>
                    <span class="text-[10px] text-slate-500">Large Language Model</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-blue-400/30 hover:bg-slate-900/60">
                    <span class="text-2xl">🐳</span>
                    <span class="text-sm font-bold text-white">Docker</span>
                    <span class="text-[10px] text-slate-500">Containerisation</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-indigo-400/30 hover:bg-slate-900/60">
                    <span class="text-2xl">🐘</span>
                    <span class="text-sm font-bold text-white">PostgreSQL</span>
                    <span class="text-[10px] text-slate-500">Relational Database</span>
                </div>
                <div
                    class="p-6 rounded-2xl border border-white/5 bg-slate-900/30 flex flex-col items-center justify-center gap-3 text-center transition-all duration-300 hover:border-cyan-400/30 hover:bg-slate-900/60">
                    <span class="text-2xl">🎮</span>
                    <span class="text-sm font-bold text-white">WebGL / Three.js</span>
                    <span class="text-[10px] text-slate-500">3D Web Framework</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================== 9. TESTIMONIAL SECTION ======================== -->
    <section id="testimonials" class="relative z-10 py-32 bg-slate-900/20">
        <div class="container mx-auto max-w-7xl px-6">
            <div class="reveal text-center mb-16">
                <p class="section-label">{{ $frontendText->testimonials['label'] ?? 'Testimoni' }}</p>
                <h2 class="section-title">{{ $frontendText->testimonials['title'] ?? 'Apa Kata Klien Kami?' }}</h2>
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
                    <div class="testimonial-card reveal col-span-3">
                        <div class="testimonial-quote">"</div>
                        <div class="testimonial-stars">★★★★★</div>
                        <p class="testimonial-text">"Website corporate dan platform SaaS kami dikerjakan dengan sangat
                            profesional, futuristik, dan performa yang sangat cepat. Klien-klien kami sangat terkesan."</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">A</div>
                            <div class="author-info">
                                <h5>Amanda Wijaya</h5>
                                <p>CEO of Prima Finance</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ======================== 10. CONSULTATION CTA ======================== -->
    <section id="contact" class="relative z-10 py-32">
        <div class="cta-container reveal mx-auto max-w-5xl">
            <p class="section-label" style="margin-bottom:16px">{{ $frontendText->cta['label'] ?? 'Konsultasi Gratis' }}
            </p>
            <h2 class="cta-title">
                {!! $frontendText->cta['title'] ?? 'Siap Membawa Bisnis Anda<br />ke Level Berikutnya?' !!}
            </h2>
            <p class="cta-sub">
                {{ $frontendText->cta['subtitle'] ?? 'Konsultasikan kebutuhan AI, website, software, automation, atau mobile app Anda bersama DBAIK.' }}
            </p>

            <div class="cta-actions flex flex-wrap justify-center gap-4">
                <a href="https://wa.me/{{ $settings->whatsapp_number ?? '628170200885' }}" class="btn-whatsapp"
                    target="_blank" rel="noopener noreferrer">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    {{ $frontendText->cta['button_text'] ?? 'Hubungi Kami' }}
                </a>
                <a href="https://calendly.com" target="_blank" rel="noopener noreferrer" class="btn-secondary">
                    📅 Jadwalkan Meeting
                </a>
            </div>

            <div class="cta-info-cards" style="margin-top: 64px;">
                <div class="info-card reveal">
                    <div class="info-card-icon">📍</div>
                    <div class="info-card-title">Lokasi</div>
                    <div class="info-card-value">
                        @if(!empty($settings->location_url))
                            <a href="{{ $settings->location_url }}" target="_blank" rel="noopener noreferrer"
                                style="color: inherit; text-decoration: none; border-bottom: 1px dashed rgba(255,255,255,0.4); padding-bottom: 2px;">{{ $settings->location_text ?? 'Jakarta, Indonesia' }}</a>
                        @else
                            {{ $settings->location_text ?? 'Jakarta, Indonesia' }}
                        @endif
                    </div>
                </div>
                <div class="info-card reveal">
                    <div class="info-card-icon">🕙</div>
                    <div class="info-card-title">Jam Kerja</div>
                    <div class="info-card-value">{{ $settings->office_hours ?? 'Senin–Sabtu, 08.00 – 17.00 WIB' }}</div>
                </div>
                <div class="info-card reveal">
                    <div class="info-card-icon">📱</div>
                    <div class="info-card-title">WhatsApp</div>
                    <div class="info-card-value">+{{ $settings->whatsapp_number ?? '628170200885' }}</div>
                </div>
            </div>
        </div>
    </section>
</div>