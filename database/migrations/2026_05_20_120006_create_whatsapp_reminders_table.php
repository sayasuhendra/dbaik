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
        Schema::create('whatsapp_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->nullable()->constrained()->onDelete('set null');
            $table->string('recipient_number');
            $table->text('message_body');
            $table->string('status')->default('simulated'); // simulated, sent, failed
            $table->text('response_meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_reminders');
    }
};
