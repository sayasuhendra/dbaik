<?php 
use Livewire\Volt\Component;
use App\Models\SiteSetting;
use App\Models\Project;

new class extends Component {
    public $project;
    public $relatedProjects;
    public $settings;
    public $ft;

    public function mount($id) {
        try {
            $this->project = Project::findOrFail($id);
            $this->relatedProjects = Project::where('id', '!=', $id)->latest()->take(3)->get();
            $this->settings = SiteSetting::first() ?? new SiteSetting(['whatsapp_number' => '6281212345678']);
            $this->ft = \App\Models\FrontendText::first();
        } catch (\Exception $e) {
            abort(404);
        }
    }
};
?>

<div>
    @section('title', $project->title . ' — Portofolio Faris Jaya Aluminium')

    <style>
        .project-hero {
            position: relative;
            min-height: 50vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 120px 24px 60px;
            overflow: hidden;
            background: linear-gradient(to bottom, rgba(10, 10, 10, 0.4), rgba(10, 10, 10, 1)), url('{{ asset($project->photos[0] ?? "") }}') center/cover no-repeat;
        }

        .project-hero-content {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }

        .project-breadcrumb {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gold-400);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .project-title {
            font-size: clamp(32px, 7vw, 64px);
            font-weight: 900;
            letter-spacing: -.04em;
            line-height: 1.1;
            margin-bottom: 24px;
        }

        .project-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .project-badge {
            background: rgba(184, 144, 31, 0.15);
            border: 1px solid rgba(184, 144, 31, 0.3);
            border-radius: 100px;
            padding: 4px 14px;
            font-size: 11px;
            font-weight: 700;
            color: var(--gold-300);
            text-transform: uppercase;
        }

        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .project-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 48px;
            padding: 60px 0 100px;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .photo-item {
            border-radius: var(--radius-md);
            overflow: hidden;
            aspect-ratio: 4/3;
            background: #1c1c1e;
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-lg);
            padding: 28px;
            margin-bottom: 24px;
        }

        @media (max-width: 900px) {
            .project-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="project-hero">
        <div class="project-hero-content">
            <nav class="project-breadcrumb">
                <a href="{{ route('home') }}" style="color: rgba(255,255,255,0.5); text-decoration: none;">BERANDA</a>
                <span>/</span>
                <span>PORTOFOLIO</span>
            </nav>
            <h1 class="project-title">{{ $project->title }}</h1>
            <div class="project-meta-row">
                <span class="project-badge">{{ is_array($project->category) ? implode(', ', $project->category) : $project->category }}</span>
                <span style="color: rgba(255,255,255,0.5); font-size: 14px;">📍 {{ $project->location }}</span>
                <span style="color: rgba(255,255,255,0.5); font-size: 14px;">📅 {{ $project->year }}</span>
            </div>
        </div>
    </div>

    <div class="page-container">
        <div class="project-layout">
            <div class="project-main">
                <section class="description-section" style="margin-bottom: 48px;">
                    <h3
                        style="font-size: 11px; font-weight: 700; letter-spacing: .15em; color: var(--gold-400); margin-bottom: 20px; text-transform: uppercase;">
                        {{ $ft->portfolio_detail['desc_label'] ?? 'Deskripsi Proyek' }}</h3>
                    <div style="font-size: 16px; color: rgba(255,255,255,0.7); line-height: 1.8;">
                        @foreach($project->description ?? [] as $p)
                            <p style="margin-bottom: 16px;">{{ is_array($p) ? ($p['line'] ?? '') : $p }}</p>
                        @endforeach
                    </div>
                </section>

                <section class="gallery-section">
                    <h3
                        style="font-size: 11px; font-weight: 700; letter-spacing: .15em; color: var(--gold-400); margin-bottom: 24px; text-transform: uppercase;">
                        {{ $ft->portfolio_detail['gallery_label'] ?? 'Galeri Foto' }}</h3>
                    <div class="photo-grid">
                        @foreach($project->photos as $photo)
                            @php
                                $photoUrl = str_starts_with($photo, 'img/') ? asset($photo) : asset('storage/' . $photo);
                            @endphp
                            <a href="{{ $photoUrl }}" class="glightbox photo-item">
                                <img src="{{ $photoUrl }}" alt="{{ $project->title }}" loading="lazy">
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>

            <aside class="sidebar">
                <div class="sidebar-card">
                    <h4
                        style="font-size: 11px; font-weight: 700; letter-spacing: .1em; color: var(--gold-400); margin-bottom: 20px; text-transform: uppercase;">
                        {{ $ft->portfolio_detail['work_label'] ?? 'Detail Pekerjaan' }}</h4>
                    <div
                        style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <span style="color: rgba(255,255,255,0.5); font-size: 14px;">Tipe</span>
                        <span style="font-weight: 700; font-size: 14px;">{{ $project->type }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 12px 0;">
                        <span style="color: rgba(255,255,255,0.5); font-size: 14px;">Status</span>
                        <span style="color: var(--gold-300); font-weight: 700; font-size: 14px;">Selesai</span>
                    </div>

                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}" target="_blank"
                        class="btn-whatsapp"
                        style="margin-top: 24px; width: 100%; display: flex; justify-content: center; text-decoration: none;">
                        {{ $ft->portfolio_detail['wa_button'] ?? '💬 Tanya Proyek Serupa' }}
                    </a>
                </div>

                <div class="sidebar-card">
                    <h4
                        style="font-size: 11px; font-weight: 700; letter-spacing: .1em; color: var(--gold-400); margin-bottom: 20px; text-transform: uppercase;">
                        {{ $ft->portfolio_detail['related_label'] ?? 'Proyek Lainnya' }}</h4>
                    @foreach($relatedProjects as $rel)
                        <a href="{{ route('portfolio.detail', $rel->id) }}"
                            style="display: flex; gap: 12px; align-items: center; text-decoration: none; margin-bottom: 16px;">
                            <div
                                style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; flex-shrink: 0; background: #2c2c2e;">
                                @php
                                    $firstPhoto = $rel->photos[0] ?? "";
                                    $relPhotoUrl = str_starts_with($firstPhoto, 'img/') ? asset($firstPhoto) : asset('storage/' . $firstPhoto);
                                @endphp
                                <img src="{{ $relPhotoUrl }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                <div style="color: white; font-weight: 700; font-size: 13px;">{{ $rel->title }}</div>
                                <div style="color: rgba(255,255,255,0.4); font-size: 11px;">{{ $rel->location }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', () => {
                const lightbox = GLightbox({ selector: '.glightbox' });
            });
        </script>
    @endpush
</div>