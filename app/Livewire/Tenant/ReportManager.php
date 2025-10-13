<?php

namespace App\Livewire\Tenant;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Expense;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportManager extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->endOfMonth()->toDateString();
    }

    public function updatedStartDate()
    {
        $this->render();
    }

    public function updatedEndDate()
    {
        $this->render();
    }

    public function getMonthlySalesProperty()
    {
        return Sale::whereBetween('date', [$this->startDate, $this->endDate])->get();
    }

    public function getTopSellingProductsProperty()
    {
        // This needs a proper sales_items table to accurately track product sales.
        // For now, we'll just return products with highest selling price as a placeholder.
        // In a real scenario, you'd join sales_items with products and group by product_id.
        return Product::orderByDesc('selling_price')->limit(5)->get();
    }

    public function exportPdf()
    {
        $monthlySales = $this->monthlySales;
        $topSellingProducts = $this->topSellingProducts;
        $totalSalesAmount = $this->monthlySales->sum('total_price');
        $totalExpensesAmount = Expense::whereBetween('date', [$this->startDate, $this->endDate])->sum('amount');
        $profit = $totalSalesAmount - $totalExpensesAmount;

        $pdf = Pdf::loadView('pdf.reports', compact('monthlySales', 'topSellingProducts', 'totalSalesAmount', 'totalExpensesAmount', 'profit', 'startDate', 'endDate'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'sales_report_' . now()->format('Ymd_His') . '.pdf');
    }

    public function render()
    {
        $monthlySales = $this->monthlySales;
        $topSellingProducts = $this->topSellingProducts;
        $totalSalesAmount = $monthlySales->sum('total_price');
        $totalExpensesAmount = Expense::whereBetween('date', [$this->startDate, $this->endDate])->sum('amount');
        $profit = $totalSalesAmount - $totalExpensesAmount;

        return view('livewire.tenant.report-manager', [
            'monthlySales' => $monthlySales,
            'topSellingProducts' => $topSellingProducts,
            'totalSalesAmount' => $totalSalesAmount,
            'totalExpensesAmount' => $totalExpensesAmount,
            'profit' => $profit,
        ]);
    }
}
