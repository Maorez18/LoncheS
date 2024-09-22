<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'time', 'description', 'preparation', 'photo', 'fk_type_recipe', 'fk_creator_recipe'];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipes', 'fk_recipe', 'fk_ingredient')
            ->withPivot('quantity', 'fk_unit', 'created_at', 'updated_at');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'lunches', 'fk_recipe', 'fk_user')
            ->withPivot('is_favorite', 'times_made')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'fk_recipe');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'fk_creator_recipe');
    }

    public function type()
    {
        return $this->belongsTo(TypeRecipe::class, 'fk_type_recipe');
    }
}
