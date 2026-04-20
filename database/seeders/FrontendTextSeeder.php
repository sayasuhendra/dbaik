<?php

namespace Database\Seeders;

use App\Models\FrontendText;
use Illuminate\Database\Seeder;

class FrontendTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FrontendText::updateOrCreate(
            ['id' => 1],
            [
                'navbar' => [
                    'brand_1' => 'FARIS JAYA',
                    'brand_2' => 'ALUMINIUM',
                    'menu_1' => 'Portofolio',
                    'menu_2' => 'Produk',
                    'menu_3' => 'Testimoni',
                    'menu_cta' => 'Konsultasi Gratis',
                ],
                'portfolio_detail' => [
                    'desc_label' => 'Deskripsi Proyek',
                    'gallery_label' => 'Galeri Foto',
                    'work_label' => 'Detail Pekerjaan',
                    'related_label' => 'Proyek Lainnya',
                    'wa_button' => '💬 Tanya Proyek Serupa',
                ],
                'hero' => [
                    'btn_primary' => 'Konsultasi Gratis',
                    'btn_secondary' => 'Lihat Portfolio',
                ],
                'marquee' => [
                    'BERPENGALAMAN SEJAK 2015',
                    'BAHAN ALUMINIUM GRADE A',
                    'PENGIRIMAN SELURUH INDONESIA',
                    'GARANSI PEMASANGAN'
                ],
                'portfolio' => [
                    'label' => 'Karya Terbaru',
                    'title' => 'Portfolio Proyek',
                    'subtitle' => 'Beberapa hasil pengerjaan terbaik kami untuk klien residensial dan komersial.',
                ],
                'services' => [
                    'label' => 'Layanan Kami',
                    'title' => 'Solusi Aluminium',
                    'subtitle' => 'Kami menyediakan berbagai macam produk aluminium berkualitas tinggi untuk kebutuhan Anda.',
                ],
                'showcase' => [
                    'label' => 'Standar Kualitas',
                    'title' => 'Mengapa Memilih <br /> Faris Jaya?',
                    'features' => [
                        ['icon' => '✓', 'title' => 'Presisi & Akurasi', 'desc' => 'Pemotongan dan perakitan menggunakan alat modern.'],
                        ['icon' => '✓', 'title' => 'Bahan Anti Korosi', 'desc' => 'Aluminium kualitas tinggi tahan cuaca ekstrem.'],
                        ['icon' => '✓', 'title' => 'Tim Profesional', 'desc' => 'Teknisi berpengalaman dalam proyek perumahan & gedung.'],
                    ],
                    'badges' => [
                        ['label' => 'Proyek Selesai', 'value' => '500+'],
                        ['label' => 'Kepuasan Klien', 'value' => '99%'],
                    ]
                ],
                'testimonials' => [
                    'label' => 'Apa Kata Mereka',
                    'title' => 'Testimoni Klien',
                ],
                'cta' => [
                    'label' => 'Mulai Sekarang',
                    'title' => 'Siap Mewujudkan <br /> Hunian Impian?',
                    'subtitle' => 'Konsultasikan kebutuhan aluminium Anda sekarang juga. Tim kami siap membantu!',
                    'button_text' => 'Konsultasi Sekarang',
                ],
                'gallery' => [
                    'label' => 'Kategori Produk',
                    'subtitle' => 'Berikut adalah koleksi pengerjaan kami untuk kategori ini. Kami mengutamakan kualitas material dan ketelitian pengerjaan.',
                    'empty_text' => 'Belum ada foto dalam kategori ini.',
                ],
                'other_categories' => [
                    'label' => 'Katalog Produk Lainnya',
                    'title' => 'Lihat kategori produk aluminium premium kami yang lain.',
                ],
                'footer' => [
                    'brand_name' => 'Faris Jaya Aluminium',
                    'brand_desc' => 'Solusi aluminium kualitas premium untuk hunian dan bangunan Anda.',
                ]
            ]
        );
    }
}
