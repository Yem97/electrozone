<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    //
    protected $fillable = [
        'order_id',
        'equipment_id',
        'quantity',
        'unit_price',
    ];
  
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
     public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipments::class);
    }
}
