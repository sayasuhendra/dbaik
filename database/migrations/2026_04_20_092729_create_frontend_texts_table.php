<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('frontend_texts', function (Blueprint $table) {
            $table->id();
            $table->json('marquee')->nullable(); // holds array of texts
            $table->json('portfolio')->nullable(); // holds label, title, subtitle
            $table->json('services')->nullable(); // holds label, title, subtitle
            $table->json('showcase')->nullable(); // holds label, title, features, badges
            $table->json('testimonials')->nullable(); // holds label, title
            $table->json('cta')->nullable(); // holds label, title, subtitle, button_text
            $table->json('gallery')->nullable(); // holds label, subtitle, empty_text
            $table->json('other_categories')->nullable(); // holds label, title
            $table->json('footer')->nullable(); // holds brand name, desc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frontend_texts');
    }
};
