<?php

namespace App\Livewire\Tenant;

use App\Models\Expense;
use App\Models\Finance;
use App\Models\Product;
use App\Models\Sale;
use Livewire\Component;
use Stancl\Tenancy\Facades\Tenancy;

class DashboardMetrics extends Component

{

    public $totalSales = 0;

    public $totalExpenses = 0;

    public $stockCount = 0;

    public $profit = 0;

    public $tenantId;



    public function mount($tenantId = null)

    {

        $this->tenantId = $tenantId;

    }



    public function boot()

    {

        if ($this->tenantId) {

            tenancy()->initializeById($this->tenantId);

            tenancy()->tenant->run(function () {

                $this->totalSales = Sale::sum('total_price');

                $this->totalExpenses = Expense::sum('amount');

                $this->stockCount = Product::where('status', 'In Stock')->count();



                $finance = Finance::latest()->first();

                if ($finance) {

                    $this->profit = $finance->profit;

                }

            });

        }

    }            public function render()
            {
                return view('livewire.tenant.dashboard-metrics');
            }
        }
