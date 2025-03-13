<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés massivement.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_status'
    ];

    /**
     * Relation avec le modèle User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le modèle Burger (via la table pivot burger_order).
     */
    public function burgers()
    {
        return $this->belongsToMany(Burger::class)->withPivot('quantity');
    }
}
