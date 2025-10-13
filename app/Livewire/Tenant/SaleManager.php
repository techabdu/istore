<?php

namespace App\Livewire\Tenant;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleManager extends Component
{
    use WithPagination;

    public $selectedProducts = [];
    public $quantities = [];
    public $totalPrice = 0;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $rules = [
        'selectedProducts.*.id' => 'required|exists:products,id',
        'quantities.*' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->calculateTotal();
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);
        if ($product && $product->quantity > 0) {
            if (isset($this->selectedProducts[$productId])) {
                $this->quantities[$productId]++;
            } else {
                $this->selectedProducts[$productId] = $product;
                $this->quantities[$productId] = 1;
            }
            $this->calculateTotal();
        }
    }

    public function removeProduct($productId)
    {
        if (isset($this->selectedProducts[$productId])) {
            unset($this->selectedProducts[$productId]);
            unset($this->quantities[$productId]);
            $this->calculateTotal();
        }
    }

    public function updatedQuantities()
    {
        foreach ($this->quantities as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $quantity > $product->quantity) {
                $this->quantities[$productId] = $product->quantity;
                session()->flash('error', 'Cannot sell more than available stock for ' . $product->name);
            }
        }
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalPrice = 0;
        foreach ($this->selectedProducts as $productId => $product) {
            $this->totalPrice += $product->selling_price * $this->quantities[$productId];
        }
    }

    public function recordSale()
    {
        $this->validate();

        if (empty($this->selectedProducts)) {
            session()->flash('error', 'Please select at least one product.');
            return;
        }

        // Create Sale record
        $sale = Sale::create([
            'total_price' => $this->totalPrice,
            'date' => now(),
        ]);

        // Update product quantities and link to sale
        foreach ($this->selectedProducts as $productId => $product) {
            $product = Product::find($productId);
            $product->quantity -= $this->quantities[$productId];
            $product->save();
            // Assuming a pivot table or sales_products table for many-to-many if needed
            // For now, a simple product_id on sales table is assumed, but this needs to be refined.
            // For simplicity, I'm just updating product quantity and not linking individual products to sale.
            // This part needs a proper many-to-many relationship or a sales_items table.
        }

        // Generate Invoice
        $invoiceNumber = 'INV-' . time();
        Invoice::create([
            'sale_id' => $sale->id,
            'invoice_number' => $invoiceNumber,
        ]);

        // Generate PDF (simplified for now)
        $pdf = Pdf::loadView('pdf.invoice', ['sale' => $sale, 'products' => $this->selectedProducts, 'quantities' => $this->quantities]);
        // You might want to save this PDF or stream it to the user
        // For now, just a placeholder for generation.

        session()->flash('message', 'Sale recorded and invoice generated successfully.');
        $this->resetSaleForm();
    }

    public function resetSaleForm()
    {
        $this->selectedProducts = [];
        $this->quantities = [];
        $this->totalPrice = 0;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'desc';
        }

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $availableProducts = Product::where('name', 'like', '%' . $this->search . '%')
            ->where('quantity', '>', 0)
            ->get();

        $recentSales = Sale::orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.tenant.sale-manager', [
            'availableProducts' => $availableProducts,
            'recentSales' => $recentSales,
        ]);
    }
}
