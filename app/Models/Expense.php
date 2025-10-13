<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Expense extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'title',
        'description',
        'amount',
        'date',
    ];
}
