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
        Schema::create('ingredient_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('quantity', 10);
            $table->unsignedBigInteger('fk_inventory');
            $table->unsignedBigInteger('fk_ingredient');
            $table->unsignedBigInteger('fk_unit');
            $table->foreign('fk_unit')->references('id')->on('units');
            $table->foreign('fk_ingredient')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreign('fk_inventory')->references('id')->on('inventories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_inventories');
    }
};
