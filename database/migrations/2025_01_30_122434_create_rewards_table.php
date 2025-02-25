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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('business_id')->constrained('users')->onDelete('cascade');
            $table->string('reward_name', 255);
            $table->integer('points_required');
            $table->boolean('is_exclusive')->default(1);
            $table->timestamp('valid_from')->default(now());
            $table->dateTime('valid_until')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
