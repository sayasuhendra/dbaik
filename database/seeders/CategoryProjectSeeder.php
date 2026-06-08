<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class CategoryProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Site Settings
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'hero_title' => 'Membangun Masa Depan Digital dengan AI & Teknologi',
                'hero_subtitle' => 'DBAIK membantu bisnis dan organisasi berkembang melalui solusi AI, website, software, mobile app, automation, dan game development.',
                'whatsapp_number' => '628111513335',
                'office_hours' => 'Senin–Sabtu, 08.00 – 17.00 WIB',
                'location_text' => 'Bandung, Indonesia',
                'location_url' => 'https://maps.app.goo.gl/u361grgLFw6Emzso9',
                'horizontal_logo' => null,
                'square_logo' => null,
            ]
        );

        // Clear existing to avoid unique/slug collision or duplicate images
        ProductCategory::query()->delete();
        ProductImage::query()->delete();
        Project::query()->delete();
        Testimonial::query()->delete();

        // 2. Seed Services (Product Categories)
        $categories = [
            'AI Solutions' => [
                'name' => 'AI Solutions',
                'slug' => 'ai-solutions',
                'thumbnail' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1677442136019-21780efad99a?auto=format&fit=crop&q=80&w=800',
                ],
            ],
            'Website Development' => [
                'name' => 'Website Development',
                'slug' => 'website-development',
                'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&q=80&w=800',
                ],
            ],
            'Software Development' => [
                'name' => 'Software Development',
                'slug' => 'software-development',
                'thumbnail' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&q=80&w=800',
                ],
            ],
            'Mobile App Development' => [
                'name' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'thumbnail' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1522542550221-31fd19575a2d?auto=format&fit=crop&q=80&w=800',
                ],
            ],
            'AI Automation' => [
                'name' => 'AI Automation',
                'slug' => 'ai-automation',
                'thumbnail' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=800',
                ],
            ],
            'Business Automation' => [
                'name' => 'Business Automation',
                'slug' => 'business-automation',
                'thumbnail' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=800',
                ],
            ],
            'Game Development' => [
                'name' => 'Game Development',
                'slug' => 'game-development',
                'thumbnail' => 'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&q=80&w=800',
                ],
            ],
            'Technology Consulting' => [
                'name' => 'Technology Consulting',
                'slug' => 'technology-consulting',
                'thumbnail' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&q=80&w=800',
                ],
            ],
        ];

        foreach ($categories as $key => $data) {
            $cat = ProductCategory::create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'thumbnail' => $data['thumbnail'],
            ]);

            // Seed associated ProductImages for subpage gallery
            foreach ($data['images'] as $idx => $imgPath) {
                ProductImage::create([
                    'product_category_id' => $cat->id,
                    'path' => $imgPath,
                    'sort_order' => $idx + 1,
                ]);
            }
        }

        // 3. Seed Projects
        $projects = [
            [
                'title' => 'AI-Driven Enterprise CRM',
                'category' => 'AI Systems',
                'location' => 'Jakarta, Indonesia',
                'year' => '2025',
                'type' => 'AI Automation',
                'description' => [
                    'Sistem CRM mutakhir berbasis kecerdasan buatan untuk mengotomatiskan interaksi pelanggan, analisis sentimen, dan segmentasi prospek otomatis.',
                    'Arsitektur dirancang menggunakan microservices yang sangat scalable dengan respon latensi rendah.',
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800',
                ],
                'is_featured' => true,
            ],
            [
                'title' => 'Fintech SaaS Platform',
                'category' => 'SaaS Platforms',
                'location' => 'Singapore',
                'year' => '2025',
                'type' => 'Software Development',
                'description' => [
                    'Platform SaaS pembukuan keuangan dan tagihan otomatis untuk UMKM dan perusahaan menengah dengan grafik analitis real-time.',
                    'Terintegrasi dengan payment gateway terkemuka dan bank transfer otomatis dengan enkripsi tingkat tinggi.',
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&q=80&w=800',
                ],
                'is_featured' => true,
            ],
            [
                'title' => 'Smart Logistics Mobile App',
                'category' => 'Mobile Apps',
                'location' => 'Silicon Valley, USA',
                'year' => '2024',
                'type' => 'Mobile App Development',
                'description' => [
                    'Aplikasi pelacakan armada ekspedisi real-time yang didukung optimasi rute otomatis menggunakan algoritma AI.',
                    'Membantu memangkas konsumsi bahan bakar hingga 25% dan meningkatkan akurasi jadwal pengiriman.',
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1512428559087-560fa5ceab42?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1522542550221-31fd19575a2d?auto=format&fit=crop&q=80&w=800',
                ],
                'is_featured' => true,
            ],
            [
                'title' => 'NeoQuest - Interactive 3D RPG',
                'category' => 'Game Projects',
                'location' => 'Bandung, Indonesia',
                'year' => '2026',
                'type' => 'Game Development',
                'description' => [
                    'Sebuah game petualangan multipemain 3D inovatif dengan mekanik pertarungan real-time dan arsitektur server scalable.',
                    'Menghadirkan gameplay yang seru dan detail visual modern yang dioptimalkan untuk mobile dan PC.',
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?auto=format&fit=crop&q=80&w=800',
                ],
                'is_featured' => true,
            ],
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }

        // 4. Seed Testimonials
        $testimonials = [
            [
                'name' => 'Rian Pratama',
                'location' => 'Founder of TechPulse',
                'content' => 'Bekerja sama dengan DBAIK adalah keputusan terbaik untuk startup kami. Sistem AI Customer Service yang mereka bangun memangkas waktu respon kami hingga 80%!',
                'avatar_char' => 'R',
                'stars' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Amanda Wijaya',
                'location' => 'CEO of Prima Finance',
                'content' => 'Website corporate dan platform SaaS kami dikerjakan dengan sangat profesional, futuristik, dan performa yang sangat cepat. Klien-klien kami sangat terkesan.',
                'avatar_char' => 'A',
                'stars' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Hendra Kusuma',
                'location' => 'COO of IndoLogistik',
                'content' => 'Sistem otomasi bisnis yang dirancang DBAIK berhasil meningkatkan efisiensi operasional pabrik kami secara signifikan. Tim mereka sangat ahli dan berorientasi pada solusi.',
                'avatar_char' => 'H',
                'stars' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testiData) {
            Testimonial::create($testiData);
        }
    }
}
