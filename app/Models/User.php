<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname',
        'email',
        'password',
        'name',
        'lastname',
        'birthdate',
        'cant_lunch',
        'fk_type',
        'verification_code',
        'is_active',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    public function typeUser()
    {
        return $this->belongsTo(TypeUser::class, 'fk_type', 'id');
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'lunches', 'fk_user', 'fk_recipe')
            ->withPivot('is_favorite', 'times_made')
            ->withTimestamps();
    }

    public function ingredientInventories()
    {
        return $this->hasManyThrough(IngredientInventory::class, Inventory::class, 'fk_user', 'fk_inventory');
    }

    public function recipesCreator()
    {
        return $this->hasMany(Recipe::class, 'fk_creator_recipe');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'fk_user');
    }


}
