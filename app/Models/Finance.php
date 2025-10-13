<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Finance extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'total_asset',
        'total_expenses',
        'total_debt',
        'total_cash',
        'capital',
        'profit',
    ];
}
