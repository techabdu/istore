<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'sale_id',
        'invoice_number',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
