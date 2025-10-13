<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant
{
    use HasDomains;

    protected $fillable = [
        'data',
    ];

    public function getBusinessNameAttribute()
    {
        return $this->data['business_name'] ?? null;
    }
}