<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipments extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'unit_price',
        'partner_unit_price',
        'initial_quantity',
        'available_quantity',
        'used_quantity',
        'returned_quantity',
        'unic_code',
        'image',
        
    ];
    
   
    
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

   

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


}
