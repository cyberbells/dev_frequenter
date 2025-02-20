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
        Schema::create('contests', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('business_id')->constrained('users')->onDelete('cascade');
            $table->text('question')->notNullable();
            $table->timestamp('start_time')->useCurrent(); // Defaults to current timestamp
            $table->dateTime('end_time')->notNullable();
            $table->enum('reward_tier', ['basic', 'premium', 'exclusive'])->default('basic');
            $table->unsignedBigInteger('target_city_id'); // Foreign key to cities table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contests');
    }
};
