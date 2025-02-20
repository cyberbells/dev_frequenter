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
        Schema::create('collaborations', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('creator_business_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('partner_business_id')->constrained('users')->onDelete('cascade');
            $table->string('target_business_type', 50)->nullable();
            $table->text('description');
            $table->timestamp('start_time')->useCurrent(); // Defaults to current timestamp
            $table->dateTime('end_time')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborations');
    }
};
