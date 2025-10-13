<div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <input wire:model.live="search" type="text" placeholder="Search products..." class="form-input rounded-md shadow-sm mt-1 block w-1/3">
        <x-primary-button wire:click="createProduct">Add New Product</x-primary-button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="mt-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="#" wire:click.prevent="sortBy('id')">ID</a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="#" wire:click.prevent="sortBy('name')">Name</a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="#" wire:click.prevent="sortBy('category')">Category</a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="#" wire:click.prevent="sortBy('purchase_price')">Purchase Price</a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="#" wire:click.prevent="sortBy('selling_price')">Selling Price</a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="#" wire:click.prevent="sortBy('status')">Status</a>
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->category }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($product->purchase_price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($product->selling_price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <x-secondary-button wire:click="editProduct({{ $product->id }})" class="mr-2">Edit</x-secondary-button>
                            <x-danger-button wire:click="deleteProduct({{ $product->id }})">Delete</x-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

    <x-modal wire:model.live="showProductModal">
        <form wire:submit.prevent="{{ $productId ? 'updateProduct' : 'storeProduct' }}">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $productId ? 'Edit Product' : 'Create New Product' }}</h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <x-input-label for="name" value="{{ __('Name') }}" />
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="category" value="{{ __('Category') }}" />
                    <x-text-input wire:model="category" id="category" class="block mt-1 w-full" type="text" required />
                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="ram" value="{{ __('RAM') }}" />
                    <x-text-input wire:model="ram" id="ram" class="block mt-1 w-full" type="text" />
                    <x-input-error :messages="$errors->get('ram')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="imei" value="{{ __('IMEI') }}" />
                    <x-text-input wire:model="imei" id="imei" class="block mt-1 w-full" type="text" />
                    <x-input-error :messages="$errors->get('imei')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="storage" value="{{ __('Storage') }}" />
                    <x-text-input wire:model="storage" id="storage" class="block mt-1 w-full" type="text" />
                    <x-input-error :messages="$errors->get('storage')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="condition" value="{{ __('Condition') }}" />
                    <x-text-input wire:model="condition" id="condition" class="block mt-1 w-full" type="text" required />
                    <x-input-error :messages="$errors->get('condition')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="purchase_price" value="{{ __('Purchase Price') }}" />
                    <x-text-input wire:model="purchase_price" id="purchase_price" class="block mt-1 w-full" type="number" step="0.01" required />
                    <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="selling_price" value="{{ __('Selling Price') }}" />
                    <x-text-input wire:model="selling_price" id="selling_price" class="block mt-1 w-full" type="number" step="0.01" required />
                    <x-input-error :messages="$errors->get('selling_price')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="status" value="{{ __('Status') }}" />
                    <x-text-input wire:model="status" id="status" class="block mt-1 w-full" type="text" required />
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="date" value="{{ __('Date') }}" />
                    <x-text-input wire:model="date" id="date" class="block mt-1 w-full" type="date" required />
                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <x-secondary-button wire:click="$set('showProductModal', false)" class="mr-2">Cancel</x-secondary-button>
                <x-primary-button type="submit">{{ $productId ? 'Update' : 'Create' }}</x-primary-button>
            </div>
        </form>
    </x-modal>
</div>