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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('ingredient', 80);
            $table->float('calories')->nullable();
            $table->float('protein')->nullable();
            $table->float('carbohydrates')->nullable();
            $table->float('fiber')->nullable();
            $table->float('sodium')->nullable();
            $table->float('saturated_fat')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('fk_category');
            $table->foreign('fk_category')->references('id')->on('category_ingredients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
