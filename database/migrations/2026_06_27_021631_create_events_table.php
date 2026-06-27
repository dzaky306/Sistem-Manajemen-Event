<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2026_01_01_xxxxxx_create_events_table.php
public function up(): void
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title', 200);
        $table->text('description')->nullable();
        $table->string('category', 50)->nullable();
        $table->date('event_date');
        $table->time('event_time')->nullable();
        $table->string('venue', 200);
        $table->integer('capacity');
        $table->decimal('price', 10, 2)->default(0);
        $table->string('organizer', 100)->nullable();
        $table->string('contact', 100)->nullable();
        $table->string('poster')->nullable();
        $table->enum('status', ['draft','published','ongoing','done','cancelled'])->default('draft');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
