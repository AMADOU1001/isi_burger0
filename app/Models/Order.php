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



    public static function getMonthlyOrderStatistics($year)
    {
        return self::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as validated_total')
            ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [$year])
            ->setBindings(['validée', $year]) // Ajoutez le statut "validée" comme paramètre
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                $item->month_name = date('F', mktime(0, 0, 0, $item->month, 10)); // Convertit le numéro du mois en nom
                return $item;
            });
    }
}
