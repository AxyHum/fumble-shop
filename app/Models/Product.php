<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $id
 * @property mixed $price
 */
class Product extends Model
{
    use HasFactory;


    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'product_id', 'id');
    }
}
