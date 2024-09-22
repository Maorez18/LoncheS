<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = ['fk_user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_inventories', 'fk_inventory', 'fk_ingredient')
            ->withPivot('quantity', 'fk_unit');
    }

}
