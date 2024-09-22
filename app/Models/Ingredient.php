<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = [
        'ingredient',
        'fk_category',
        'calories',
        'protein',
        'carbohydrates',
        'fiber',
        'sodium',
        'saturated_fat',
        'photo',
    ];

    public function category(){
        return $this->belongsTo(CategoryIngredient::class, 'fk_category');
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'ingredient_recipes', 'fk_ingredient', 'fk_recipe')
            ->withPivot('quantity', 'fk_unit', 'created_at', 'updated_at');
    }

    public function inventories()
    {
        return $this->belongsToMany(Inventory::class, 'ingredient_inventories', 'fk_ingredient', 'fk_inventory')
            ->withPivot('quantity', 'fk_unit', 'created_at', 'updated_at');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'fk_unit');
    }

}
