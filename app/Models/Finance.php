<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'total_asset',
        'total_expenses',
        'total_debt',
        'total_cash',
        'capital',
        'profit',
    ];
}
