<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Product extends Model
{
    use BelongsToTenant;

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
