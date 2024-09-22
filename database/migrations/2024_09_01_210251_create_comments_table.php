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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment', 280);  // Para registrar cuántas veces el usuario ha hecho la receta
            $table->unsignedBigInteger('fk_user');
            $table->unsignedBigInteger('fk_recipe');
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fk_recipe')->references('id')->on('recipes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
