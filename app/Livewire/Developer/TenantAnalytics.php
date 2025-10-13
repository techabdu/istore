<?php

namespace App\Livewire\Developer;

use App\Models\Tenant;
use App\Models\Product;
use App\Models\Sale;
use Livewire\Component;

class TenantAnalytics extends Component
{
    public $totalTenants = 0;
    public $totalProducts = 0;
    public $totalSalesAmount = 0;

    public function mount()
    {
        $this->totalTenants = Tenant::count();

        $allTenants = Tenant::all();

        foreach ($allTenants as $tenant) {
            $tenant->run(function () {
                $this->totalProducts += Product::count();
                $this->totalSalesAmount += Sale::sum('total_price');
            });
        }
    }

    public function render()
    {
        return view('livewire.developer.tenant-analytics');
    }
}
