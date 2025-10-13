<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Invoice extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'sale_id',
        'invoice_number',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
