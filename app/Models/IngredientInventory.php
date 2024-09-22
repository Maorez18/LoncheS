<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientInventory extends Model
{
    use HasFactory;
    protected $fillable = ['quantity', 'fk_ingredient', 'fk_unit', 'fk_inventory'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'fk_ingredient');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'fk_unit');
    }

}
