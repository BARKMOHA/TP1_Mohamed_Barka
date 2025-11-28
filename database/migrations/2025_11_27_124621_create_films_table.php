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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
    
            $table->string('release_year', 4)->nullable();
    
            $table->unsignedBigInteger('language_id');
            $table->integer('length');
            $table->string('rating', 10);
    
            $table->string('special_features', 255)->nullable();
            $table->string('image', 40)->nullable();
    
            $table->timestamp('created_at')->nullable();
    
            $table->foreign('language_id')
                  ->references('id')
                  ->on('languages')
                  ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
