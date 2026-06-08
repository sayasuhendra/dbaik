<?php

namespace App\Filament\Resources\FrontendTexts\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class FrontendTextForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Frontend Texts')
                    ->tabs([
                        Tabs\Tab::make('Navigasi & Logo')
                            ->schema([
                                TextInput::make('navbar.brand_1')->label('Nama Brand (Atas)')->default('FARIS JAYA'),
                                TextInput::make('navbar.brand_2')->label('Nama Brand (Bawah)')->default('ALUMINIUM'),
                                TextInput::make('navbar.menu_1')->label('Menu 1')->default('Portofolio'),
                                TextInput::make('navbar.menu_2')->label('Menu 2')->default('Produk'),
                                TextInput::make('navbar.menu_3')->label('Menu 3')->default('Testimoni'),
                                TextInput::make('navbar.menu_cta')->label('Teks Konsultasi (CTA)')->default('Konsultasi Gratis'),
                            ]),
                        Tabs\Tab::make('Detail Portofolio')
                            ->schema([
                                TextInput::make('portfolio_detail.desc_label')->label('Label Deskripsi')->default('Deskripsi Proyek'),
                                TextInput::make('portfolio_detail.gallery_label')->label('Label Galeri')->default('Galeri Foto'),
                                TextInput::make('portfolio_detail.work_label')->label('Label Detail Pekerjaan')->default('Detail Pekerjaan'),
                                TextInput::make('portfolio_detail.related_label')->label('Label Proyek Lain')->default('Proyek Lainnya'),
                                TextInput::make('portfolio_detail.wa_button')->label('Teks Tombol WhatsApp')->default('💬 Tanya Proyek Serupa'),
                            ]),
                        Tabs\Tab::make('Hero')
                            ->schema([
                                TextInput::make('hero.btn_primary')->label('Teks Tombol Utama')->default('Konsultasi Gratis'),
                                TextInput::make('hero.btn_secondary')->label('Teks Tombol Kedua')->default('Lihat Portfolio'),
                            ]),
                        Tabs\Tab::make('Running Text (Marquee)')
                            ->schema([
                                Repeater::make('marquee')
                                    ->simple(TextInput::make('text'))
                                    ->label('List Teks Berjalan')
                                    ->default([
                                        'BERPENGALAMAN SEJAK 2015',
                                        'BAHAN ALUMINIUM GRADE A',
                                        'PENGIRIMAN SELURUH INDONESIA',
                                        'GARANSI PEMASANGAN',
                                    ]),
                            ]),
                        Tabs\Tab::make('Portfolio')
                            ->schema([
                                TextInput::make('portfolio.label')->label('Label Seksi'),
                                TextInput::make('portfolio.title')->label('Judul Besar'),
                                Textarea::make('portfolio.subtitle')->label('Sub-judul'),
                            ]),
                        Tabs\Tab::make('Layanan (Services)')
                            ->schema([
                                TextInput::make('services.label')->label('Label Seksi'),
                                TextInput::make('services.title')->label('Judul Besar'),
                                Textarea::make('services.subtitle')->label('Sub-judul'),
                            ]),
                        Tabs\Tab::make('Kualitas (Showcase)')
                            ->schema([
                                TextInput::make('showcase.label')->label('Label Seksi'),
                                TextInput::make('showcase.title')->label('Judul Besar'),
                                Repeater::make('showcase.features')
                                    ->label('Fitur Unggulan')
                                    ->schema([
                                        TextInput::make('icon')->label('Icon (Emoji/SVG)')->default('✓'),
                                        TextInput::make('title')->label('Nama Fitur'),
                                        Textarea::make('desc')->label('Deskripsi Pendek'),
                                    ])->columns(1),
                                Repeater::make('showcase.badges')
                                    ->label('Status / Badges')
                                    ->schema([
                                        TextInput::make('label')->label('Label'),
                                        TextInput::make('value')->label('Nilai/Angka'),
                                    ])->columns(2),
                            ]),
                        Tabs\Tab::make('Testimoni')
                            ->schema([
                                TextInput::make('testimonials.label')->label('Label Seksi'),
                                TextInput::make('testimonials.title')->label('Judul Besar'),
                            ]),
                        Tabs\Tab::make('CTA (Mulai Sekarang)')
                            ->schema([
                                TextInput::make('cta.label')->label('Label Seksi'),
                                TextInput::make('cta.title')->label('Judul Besar'),
                                Textarea::make('cta.subtitle')->label('Sub-judul'),
                                TextInput::make('cta.button_text')->label('Teks Tombol'),
                            ]),
                        Tabs\Tab::make('Halaman Galeri')
                            ->schema([
                                TextInput::make('gallery.label')->label('Label Kategori'),
                                Textarea::make('gallery.subtitle')->label('Deskripsi Galeri'),
                                TextInput::make('gallery.empty_text')->label('Pesan Jika Kosong'),
                                TextInput::make('other_categories.label')->label('Label Katalog Lain'),
                                TextInput::make('other_categories.title')->label('Judul Katalog Lain'),
                            ]),
                        Tabs\Tab::make('Footer & Brand')
                            ->schema([
                                TextInput::make('footer.brand_name')->label('Nama Brand Footer'),
                                TextInput::make('footer.brand_desc')->label('Slogan/Deskripsi Footer'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
