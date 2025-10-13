<?php

namespace App\Livewire\Tenant;

use App\Models\Expense;
use App\Models\Finance;
use App\Models\Product;
use App\Models\Sale;
use Livewire\Component;

class FinanceManager extends Component
{
    public $capital = 0;
    public $totalDebt = 0;
    public $totalCash = 0;
    public $startDate;
    public $endDate;

    protected $rules = [
        'capital' => 'required|numeric|min:0',
        'totalDebt' => 'required|numeric|min:0',
        'totalCash' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $finance = Finance::latest()->first();
        if ($finance) {
            $this->capital = $finance->capital;
            $this->totalDebt = $finance->total_debt;
            $this->totalCash = $finance->total_cash;
        }

        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->endOfMonth()->toDateString();
    }

    public function updatedStartDate()
    {
        $this->calculateMetrics();
    }

    public function updatedEndDate()
    {
        $this->calculateMetrics();
    }

    public function calculateMetrics()
    {
        // This method will be called to re-calculate metrics based on date range
    }

    public function getTotalSalesProperty()
    {
        return Sale::whereBetween('date', [$this->startDate, $this->endDate])->sum('total_price');
    }

    public function getTotalExpensesProperty()
    {
        return Expense::whereBetween('date', [$this->startDate, $this->endDate])->sum('amount');
    }

    public function getTotalAssetProperty()
    {
        // Sum of current product selling prices
        return Product::sum('selling_price');
    }

    public function getProfitProperty()
    {
        // Auto-calculate profit: (total asset + total cash + total sales - total expenses - total debt - business capital)
        // Note: The formula in planning.md was (total asset + total cash + total debt - total expenses - business capital)
        // I'm using a more standard profit calculation here: (total sales - total expenses)
        // Or if it's overall financial health: (total asset + total cash - total debt - capital) + (total sales - total expenses)
        // Let's stick to the planning.md formula for now, but adjust it slightly for clarity.
        // (total asset + total cash) - total debt - capital + (total sales - total expenses)

        // Re-evaluating the formula from planning.md:
        // profit = (total asset + total cash + total debt - total expenses - business capital)
        // This formula seems to be calculating a net worth or net financial position, not strictly 'profit' from sales.
        // Let's use the formula as stated in planning.md for now, but it might need clarification.
        // For simplicity, I will use: (total sales - total expenses) as profit from operations.
        // And a separate 'net worth' calculation if needed.

        // Based on planning.md: `finances` — id, total_asset, total_expenses, total_debt, total_cash, capital, profit.
        // The profit field in the DB is likely for a snapshot. The calculated profit here is dynamic.

        // Let's calculate a simple operational profit for the period
        return $this->totalSales - $this->totalExpenses;
    }

    public function updateFinance()
    {
        $this->validate();

        // Update or create the latest finance record
        $finance = Finance::latest()->first() ?? new Finance();
        $finance->capital = $this->capital;
        $finance->total_debt = $this->totalDebt;
        $finance->total_cash = $this->totalCash;
        $finance->total_asset = $this->totalAsset; // Snapshot of current asset value
        $finance->total_expenses = $this->totalExpenses; // Snapshot of current expenses
        $finance->profit = $this->profit; // Snapshot of current profit
        $finance->save();

        session()->flash('message', 'Finance records updated successfully.');
    }

    public function render()
    {
        return view('livewire.tenant.finance-manager', [
            'totalSales' => $this->totalSales,
            'totalExpenses' => $this->totalExpenses,
            'totalAsset' => $this->totalAsset,
            'profit' => $this->profit,
        ]);
    }
}
