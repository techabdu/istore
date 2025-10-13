<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'ram',
        'imei',
        'storage',
        'condition',
        'purchase_price',
        'selling_price',
        'status',
        'date',
        'quantity',
    ];
}
