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
                    'brand_1' => 'DBAIK',
                    'brand_2' => 'DIGITAL AGENCY',
                    'menu_1' => 'Portofolio',
                    'menu_2' => 'Layanan',
                    'menu_3' => 'Testimoni',
                    'menu_cta' => 'Konsultasi Gratis',
                ],
                'portfolio_detail' => [
                    'desc_label' => 'Deskripsi Proyek',
                    'gallery_label' => 'Galeri Showcase',
                    'work_label' => 'Detail Pekerjaan',
                    'related_label' => 'Proyek Inovatif Lainnya',
                    'wa_button' => '💬 Diskusikan Solusi Serupa',
                ],
                'hero' => [
                    'btn_primary' => 'Konsultasi Gratis',
                    'btn_secondary' => 'Lihat Portfolio',
                ],
                'marquee' => [
                    'AI SOLUTIONS 🤖',
                    'WEBSITE DEVELOPMENT 💻',
                    'SOFTWARE DEVELOPMENT 🚀',
                    'MOBILE APP DEVELOPMENT 📱',
                    'BUSINESS AUTOMATION ⚡',
                    'AI AUTOMATION 🧠',
                    'GAME DEVELOPMENT 🎮',
                    'TECHNOLOGY CONSULTING 🔮',
                ],
                'portfolio' => [
                    'label' => 'Karya Unggulan',
                    'title' => 'Digital Product Showcase',
                    'subtitle' => 'Jelajahi portofolio proyek enterprise dan startup modern yang kami rancang dengan teknologi terdepan.',
                ],
                'services' => [
                    'label' => 'Layanan & Solusi',
                    'title' => 'Layanan Teknologi Masa Depan',
                    'subtitle' => 'Mulai dari otomatisasi alur kerja, kecerdasan buatan, hingga game multi-platform, kami menghadirkan masa depan hari ini.',
                ],
                'showcase' => [
                    'label' => 'Mengapa DBAIK',
                    'title' => 'Kenapa Berpartner <br /> dengan DBAIK?',
                    'features' => [
                        ['icon' => '🎯', 'title' => 'Fokus Solusi Nyata', 'desc' => 'Setiap produk dan automasi AI kami rancang untuk memberikan dampak bisnis konkret dan ROI positif.'],
                        ['icon' => '💻', 'title' => 'Teknologi Modern', 'desc' => 'Menggunakan tech stack modern yang cepat, aman, dan siap scale-up kapan saja bisnis Anda berkembang.'],
                        ['icon' => '⚡', 'title' => 'AI-Driven Workflow', 'desc' => 'Proses riset, desain, hingga development yang efisien memanfaatkan integrasi kecerdasan buatan.'],
                    ],
                    'badges' => [
                        ['label' => 'Proyek Sukses', 'value' => '120+'],
                        ['label' => 'Client Satisfaction', 'value' => '100%'],
                    ],
                ],
                'testimonials' => [
                    'label' => 'Testimoni Klien',
                    'title' => 'Dipercaya oleh Bisnis & Startup Inovatif',
                ],
                'cta' => [
                    'label' => 'Mulai Transformasi',
                    'title' => 'Siap Membawa Bisnis Anda <br /> ke Level Berikutnya?',
                    'subtitle' => 'Konsultasikan kebutuhan AI, website, software, automation, atau mobile app Anda bersama DBAIK.',
                    'button_text' => 'Jadwalkan Meeting',
                ],
                'gallery' => [
                    'label' => 'Kategori Layanan',
                    'subtitle' => 'Lihat bagaimana kami menerapkan standar tertinggi teknologi pada setiap vertikal industri.',
                    'empty_text' => 'Belum ada proyek dalam kategori ini.',
                ],
                'other_categories' => [
                    'label' => 'Layanan Premium Lainnya',
                    'title' => 'Temukan solusi spesifik lainnya untuk mendigitalisasi bisnis Anda.',
                ],
                'footer' => [
                    'brand_name' => 'DBAIK Digital Agency',
                    'brand_desc' => 'Silicon Valley level AI, Software House, and Digital Automation partner based in Indonesia.',
                ],
            ]
        );
    }
}
