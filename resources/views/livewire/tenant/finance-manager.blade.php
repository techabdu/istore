<div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Overview</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div>
            <x-input-label for="startDate" value="{{ __('Start Date') }}" />
            <x-text-input wire:model.live="startDate" id="startDate" class="block mt-1 w-full" type="date" />
        </div>
        <div>
            <x-input-label for="endDate" value="{{ __('End Date') }}" />
            <x-text-input wire:model.live="endDate" id="endDate" class="block mt-1 w-full" type="date" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
            <h4 class="font-semibold text-gray-700">Total Sales (Period)</h4>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($this->totalSales, 2) }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
            <h4 class="font-semibold text-gray-700">Total Expenses (Period)</h4>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($this->totalExpenses, 2) }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
            <h4 class="font-semibold text-gray-700">Operational Profit (Period)</h4>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($this->profit, 2) }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
            <h4 class="font-semibold text-gray-700">Total Asset Value</h4>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($this->totalAsset, 2) }}</p>
        </div>
    </div>

    <h3 class="text-lg font-medium text-gray-900 mt-8 mb-4">Update Financial Records</h3>

    <form wire:submit.prevent="updateFinance">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <x-input-label for="capital" value="{{ __('Business Capital') }}" />
                <x-text-input wire:model="capital" id="capital" class="block mt-1 w-full" type="number" step="0.01" required />
                <x-input-error :messages="$errors->get('capital')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="totalDebt" value="{{ __('Total Debt') }}" />
                <x-text-input wire:model="totalDebt" id="totalDebt" class="block mt-1 w-full" type="number" step="0.01" required />
                <x-input-error :messages="$errors->get('totalDebt')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="totalCash" value="{{ __('Total Cash') }}" />
                <x-text-input wire:model="totalCash" id="totalCash" class="block mt-1 w-full" type="number" step="0.01" required />
                <x-input-error :messages="$errors->get('totalCash')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button type="submit">
                {{ __('Update Finance') }}
            </x-primary-button>
        </div>
    </form>
</div>