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
        Schema::create('badges', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('badge_name')->nullable(false); // Badge name, not null
            $table->text('badge_description')->nullable(); // Badge description, nullable
            $table->string('badge_icon_url')->nullable(); // Badge icon URL, nullable
            $table->enum('badge_type', ['visit', 'points', 'event', 'social', 'custom'])->nullable(false); // Badge type
            $table->integer('milestone'); // Milestone, int(11)
            $table->integer('badge_points_threshold'); // Points threshold, int(11)
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
