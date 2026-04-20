<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Project;
use Illuminate\Database\Seeder;

class CategoryProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Product Categories and Images
        $categories = [
            "Canopy" => ["name" => "Canopy", "slug" => "Canopy", "images" => [], "thumbnail" => null],
            "Jendela" => ["name" => "Jendela", "slug" => "Jendela", "images" => ["img/products/Jendela/jendela1.png", "img/products/Jendela/sekolah.png"], "thumbnail" => "img/products/Jendela/jendela1.png"],
            "Kaca_Sudut" => ["name" => "Kaca Sudut", "slug" => "Kaca_Sudut", "images" => [], "thumbnail" => null],
            "Partisi" => ["name" => "Partisi", "slug" => "Partisi", "images" => ["img/products/Partisi/puskesmas.png"], "thumbnail" => "img/products/Partisi/puskesmas.png"],
            "Pintu_Kaca" => ["name" => "Pintu Kaca", "slug" => "Pintu_Kaca", "images" => ["img/products/Pintu_Kaca/masjid1.png"], "thumbnail" => "img/products/Pintu_Kaca/masjid1.png"],
            "Pintu_Kamar_Mandi" => ["name" => "Pintu Kamar Mandi", "slug" => "Pintu_Kamar_Mandi", "images" => [], "thumbnail" => null],
            "Pintu_Lipat" => ["name" => "Pintu Lipat", "slug" => "Pintu_Lipat", "images" => ["img/products/Pintu_Lipat/rumah1.png"], "thumbnail" => "img/products/Pintu_Lipat/rumah1.png"],
            "Pintu_Sliding" => ["name" => "Pintu Sliding", "slug" => "Pintu_Sliding", "images" => ["img/products/Pintu_Sliding/rumah.png", "img/products/Pintu_Sliding/sliding1.png"], "thumbnail" => "img/products/Pintu_Sliding/rumah.png"],
            "Pintu_Swing" => ["name" => "Pintu Swing", "slug" => "Pintu_Swing", "images" => ["img/products/Pintu_Swing/masjid.png", "img/products/Pintu_Swing/swing1.png"], "thumbnail" => "img/products/Pintu_Swing/masjid.png"],
            "Railing" => ["name" => "Railing", "slug" => "Railing", "images" => [], "thumbnail" => null],
            "Sunblast" => ["name" => "Sunblast", "slug" => "Sunblast", "images" => [], "thumbnail" => null]
        ];

        foreach ($categories as $key => $data) {
            $cat = ProductCategory::create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'thumbnail' => $data['thumbnail']
            ]);

            foreach ($data['images'] as $index => $path) {
                ProductImage::create([
                    'product_category_id' => $cat->id,
                    'path' => $path,
                    'sort_order' => $index
                ]);
            }
        }

        // 2. Seed Projects
        $projects = [
            [
                'title' => "Masjid An-Nur",
                'category' => "🕌 Fasilitas Publik",
                'location' => "Jakarta Timur",
                'year' => "2024",
                'type' => "Pintu Swing & Kusen Aluminium",
                'description' => [
                    "Pengerjaan menyeluruh untuk area pintu masuk utama dan jendela masjid menggunakan aksen gold premium.",
                    "Material menggunakan profil aluminium berkualitas tinggi dengan daya tahan cuaca ekstrem untuk kenyamanan jamaah."
                ],
                'photos' => [
                    "img/products/Pintu_Swing/masjid.png",
                    "img/products/Pintu_Swing/swing1.png"
                ],
                'is_featured' => true
            ],
            [
                'title' => "Gedung Sekolah Nasional",
                'category' => "🏫 Fasilitas Pendidikan",
                'location' => "Bekasi",
                'year' => "2023",
                'type' => "Jendela Casement & Kusen",
                'description' => [
                    "Instalasi jendela casement pada gedung belajar 3 lantai untuk sirkulasi udara yang optimal.",
                    "Proyek diselesaikan dengan standar keamanan tinggi untuk lingkungan pendidikan."
                ],
                'photos' => [
                    "img/products/Jendela/sekolah.png",
                    "img/products/Jendela/jendela1.png"
                ],
                'is_featured' => true
            ],
            [
                'title' => "Rumah Minimalis Modern",
                'category' => "🏠 Hunian Pribadi",
                'location' => "Tangerang",
                'year' => "2024",
                'type' => "Pintu Sliding & Jendela",
                'description' => [
                    "Penerapan sistem pintu sliding aluminium untuk memaksimalkan ruang pada hunian minimalis.",
                    "Desain modern yang menyatu dengan estetika arsitektur rumah kekinian."
                ],
                'photos' => [
                    "img/products/Pintu_Sliding/rumah.png"
                ],
                'is_featured' => true
            ]
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }
    }
}
