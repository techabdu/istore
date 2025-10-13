<?php

namespace App\Livewire\Tenant;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductManager extends Component
{
    use WithPagination;

    public $productId;
    public $name, $category, $ram, $imei, $storage, $condition, $purchase_price, $selling_price, $status, $date, $quantity;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $showProductModal = false;
    public $lowStockThreshold = 5; // Default low stock threshold

    protected $rules = [
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'ram' => 'nullable|string|max:255',
        'imei' => 'nullable|string|max:255|unique:products,imei',
        'storage' => 'nullable|string|max:255',
        'condition' => 'required|string|max:255',
        'purchase_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'status' => 'required|string|max:255',
        'date' => 'required|date',
        'quantity' => 'required|integer|min:0',
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createProduct()
    {
        $this->resetInputFields();
        $this->showProductModal = true;
    }

    public function storeProduct()
    {
        $this->validate();

        Product::create([
            'name' => $this->name,
            'category' => $this->category,
            'ram' => $this->ram,
            'imei' => $this->imei,
            'storage' => $this->storage,
            'condition' => $this->condition,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price,
            'status' => $this->status,
            'date' => $this->date,
            'quantity' => $this->quantity,
        ]);

        session()->flash('message', 'Product created successfully.');
        $this->resetInputFields();
        $this->showProductModal = false;
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->name = $product->name;
        $this->category = $product->category;
        $this->ram = $product->ram;
        $this->imei = $product->imei;
        $this->storage = $product->storage;
        $this->condition = $product->condition;
        $this->purchase_price = $product->purchase_price;
        $this->selling_price = $product->selling_price;
        $this->status = $product->status;
        $this->date = $product->date;
        $this->quantity = $product->quantity;

        $this->showProductModal = true;
    }

    public function updateProduct()
    {
        $this->validate();

        $product = Product::findOrFail($this->productId);
        $product->update([
            'name' => $this->name,
            'category' => $this->category,
            'ram' => $this->ram,
            'imei' => $this->imei,
            'storage' => $this->storage,
            'condition' => $this->condition,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price,
            'status' => $this->status,
            'date' => $this->date,
            'quantity' => $this->quantity,
        ]);

        session()->flash('message', 'Product updated successfully.');
        $this->resetInputFields();
        $this->showProductModal = false;
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Product deleted successfully.');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->category = '';
        $this->ram = '';
        $this->imei = '';
        $this->storage = '';
        $this->condition = '';
        $this->purchase_price = '';
        $this->selling_price = '';
        $this->status = '';
        $this->date = '';
        $this->quantity = '';
        $this->productId = null;
    }

    public function render()
    {
        $products = Product::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('category', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $products->through(function ($product) {
            $product->low_stock = $product->quantity <= $this->lowStockThreshold;
            return $product;
        });

        return view('livewire.tenant.product-manager', [
            'products' => $products,
        ]);
    }
}
