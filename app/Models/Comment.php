<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'fk_user',
        'fk_recipe',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'fk_recipe');
    }
}
