<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2026_01_01_xxxxxx_create_event_registrations_table.php
public function up(): void
{
    Schema::create('event_registrations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_id')->constrained()->cascadeOnDelete();
        $table->string('participant_name', 100);
        $table->string('email', 100);
        $table->string('phone', 20)->nullable();
        $table->string('institution', 100)->nullable();
        $table->string('ticket_code', 30)->unique();
        $table->enum('payment_status', ['pending','paid','free'])->default('pending');
        $table->boolean('attended')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
