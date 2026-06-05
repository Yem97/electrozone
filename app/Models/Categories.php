<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
     protected $fillable = ['name'];

    public function equipment()
    {
        return $this->hasMany(equipments::class,'category_id');
    }
}
