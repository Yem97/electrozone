<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'shipping_address',
        'customer_name',
        'customer_email',
        'customer_phone',
        'first_name',
        'last_name',
        'email',
        'phone',
        'city',
        'postal_code',
        'payment_method',
    ];

    //
    public function items()
{
    return $this->hasMany(OrderItem::class);
}
public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}