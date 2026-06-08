<?php

use function Livewire\Volt\{state, layout, mount};
use App\Models\ProductCategory;

layout('layouts.app');

state([
    'category' => null,
    'images' => [],
    'otherCategories' => [],
    'ft' => null
]);

mount(function ($slug) {
    $this->category = ProductCategory::where('slug', $slug)->where('is_active', true)->firstOrFail();
    $this->images = $this->category->images()->orderBy('sort_order')->get();
    $this->otherCategories = ProductCategory::where('id', '!=', $this->category->id)->where('is_active', true)->get();
    $this->ft = \App\Models\FrontendText::first();
});

?>

<div>
    @section('title', $category->name . ' — DBAIK Digital Agency')

    <style>
        .container-gallery { max-width: 1200px; margin: 0 auto; padding: 40px 24px; }
        
        /* Header */
        .header { margin-top: 80px; text-align: center; margin-bottom: 60px; }
        .header-cat { font-size: 13px; font-weight: 700; color: var(--gold-400); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 12px; }
        .header-title { font-size: 48px; font-weight: 900; letter-spacing: -1.5px; }
        .header-sub { color: rgba(255,255,255,0.4); max-width: 600px; margin: 20px auto 0; line-height: 1.6; }

        /* Photo Grid */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .photo-item {
            position: relative; border-radius: var(--radius-md); overflow: hidden;
            background: rgba(255,255,255,0.03); aspect-ratio: 4/3;
            cursor: pointer; display: block;
        }
        .photo-item img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .photo-item:hover img { transform: scale(1.05); }
        .photo-overlay {
            position: absolute; inset: 0; background: rgba(0,0,0,0.3);
            opacity: 0; transition: opacity 0.3s; display: flex; align-items: center; justify-content: center;
        }
        .photo-item:hover .photo-overlay { opacity: 1; }
        .zoom-icon { padding: 12px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 50%; }

        @media (max-width: 768px) {
            .photo-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .header-title { font-size: 36px; }
        }
        @media (max-width: 480px) {
            .photo-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div class="container-gallery">
        <div class="header">
            <div class="header-cat">{{ $ft->gallery['label'] ?? 'Kategori Layanan' }}</div>
            <h1 class="header-title">{{ $category->name }}</h1>
            <p class="header-sub">{{ $ft->gallery['subtitle'] ?? 'Kami menghadirkan standar kualitas teknologi terbaik untuk melayani kebutuhan bisnis dan operasional perusahaan Anda.' }}</p>
        </div>

        @if($images->count() > 0)
        <div class="photo-grid" id="photo-grid">
            @foreach($images as $image)
            @php
                $imgUrl = str_starts_with($image->path, 'img/') ? asset($image->path) : asset('storage/' . $image->path);
            @endphp
            <div class="photo-item">
                <img src="{{ $imgUrl }}" alt="{{ $category->name }} {{ $loop->iteration }}" loading="lazy" />
                <div class="photo-overlay" style="flex-direction: column; gap: 16px;">
                    <a href="{{ $imgUrl }}" class="glightbox zoom-icon" data-gallery="product-cat">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </a>
                    @if($image->link)
                    <a href="{{ $image->link }}" target="_blank" class="btn-primary px-6 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-transform hover:scale-105" onclick="event.stopPropagation()">
                        {{ $image->link_label ?? 'Kunjungi Link' }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state" style="text-align: center; padding: 100px 0; color: rgba(255,255,255,0.2);">
            <span style="font-size: 80px; display: block; margin-bottom: 20px;">📂</span>
            {{ $ft->gallery['empty_text'] ?? 'Belum ada data dalam kategori ini.' }}
        </div>
        @endif

        <div class="other-categories" style="margin-top: 100px; padding-top: 60px; border-top: 1px solid rgba(255,255,255,0.06);">
            <div class="oc-header" style="text-align: center; margin-bottom: 40px;">
                <h2 class="oc-title" style="font-size: 28px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 12px;">{{ $ft->other_categories['label'] ?? 'Layanan Premium Lainnya' }}</h2>
                <p class="oc-sub" style="color: rgba(255,255,255,0.4); font-size: 14px;">{{ $ft->other_categories['title'] ?? 'Lihat kategori layanan premium kami yang lain.' }}</p>
            </div>
            
            <div class="category-grid">
                @foreach($otherCategories as $other)
                <div class="category-card reveal" onclick="window.location='{{ route('product.gallery', $other->slug) }}'">
                    <div class="category-image">
                        @php
                            $catThumb = $other->thumbnail ?? 'img/placeholder.png';
                            $catThumbUrl = str_starts_with($catThumb, 'img/') ? asset($catThumb) : asset('storage/' . $catThumb);
                        @endphp
                        <img src="{{ $catThumbUrl }}" alt="{{ $other->name }}" loading="lazy">
                        <div class="category-overlay">
                            <span class="category-badge">{{ $other->images->count() }} Foto</span>
                        </div>
                    </div>
                    <div class="category-info">
                        <h3 class="category-name">{{ $other->name }}</h3>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:navigated', () => {
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true
            });

            gsap.from(".photo-item", {
                y: 40, opacity: 0, duration: 0.8, stagger: 0.1, ease: "power3.out"
            });
        });
    </script>
    @endpush
</div>
