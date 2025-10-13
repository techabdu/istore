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

    public function getStatusAttribute()
    {
        return $this->data['status'] ?? null;
    }

    public function getFullNameAttribute()
    {
        return $this->data['full_name'] ?? null;
    }

    public function getBusinessCapitalAttribute()
    {
        return $this->data['business_capital'] ?? null;
    }

    public function getAddressAttribute()
    {
        return $this->data['address'] ?? null;
    }

    public function getPhoneNumberAttribute()
    {
        return $this->data['phone_number'] ?? null;
    }
}