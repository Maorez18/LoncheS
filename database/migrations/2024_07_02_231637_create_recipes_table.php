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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('time');
            $table->text('description');
            $table->text('preparation');
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('fk_type_recipe');
            $table->unsignedBigInteger('fk_creator_recipe');
            $table->foreign('fk_type_recipe')->references('id')->on('type_recipes')->onDelete('cascade');
            $table->foreign('fk_creator_recipe')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
