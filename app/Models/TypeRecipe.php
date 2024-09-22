<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRecipe extends Model
{
    use HasFactory;

    protected $fillable=['type_recipe',];

    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'fk_type_recipe');
    }
}
