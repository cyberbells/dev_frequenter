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
        Schema::create('contest_submissions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('contest_id'); // Foreign key to contests table
            $table->unsignedBigInteger('customer_id'); // Foreign key to users table
            $table->text('submission_text')->notNullable();
            $table->integer('votes')->default(0);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('contest_id')
                  ->references('id')
                  ->on('contests')
                  ->onDelete('cascade');

            $table->foreign('customer_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_submissions');
    }
};
