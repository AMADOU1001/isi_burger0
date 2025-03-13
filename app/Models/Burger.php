<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés massivement.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',       // Nom du burger
        'price',      // Prix du burger
        'description', // Description du burger
        'image',      // Image du burger
        'stock',      // Stock du burger
        'is_published',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity'); // Un burger peut être dans plusieurs commandes
    }
}
