<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'inv_id',
        'type',
        'quantity_before',
        'quantity',
        'quantity_after',
        'amount',
        'remarks',
        'user_id',
        'is_paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
