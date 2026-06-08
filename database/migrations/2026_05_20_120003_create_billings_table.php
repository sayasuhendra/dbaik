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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->decimal('amount', 15, 2);
            $table->string('billing_cycle')->default('monthly'); // one-time, monthly, yearly
            $table->string('status')->default('pending'); // pending, paid, overdue, cancelled
            $table->date('due_date');
            $table->boolean('recurring_billing')->default(true);
            $table->string('whatsapp_number')->nullable();
            $table->timestamp('last_reminder_sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
