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
        Schema::create('actor_film', function (Blueprint $table) {
            $table->unsignedBigInteger('actor_id');
            $table->unsignedBigInteger('film_id');
            $table->timestamp('created_at')->nullable();

            //pour empecher les doublons

            $table->primary(['actor_id', 'film_id']);
        
            $table->foreign('actor_id')
                ->references('id')
                ->on('actors')
                ->onDelete('cascade');
        
            $table->foreign('film_id')
                ->references('id')
                ->on('films')
                ->onDelete('cascade');       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_film');
    }
};
