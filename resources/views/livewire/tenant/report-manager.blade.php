<div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Sales and Financial Reports</h3>
        <x-primary-button wire:click="exportPdf">Export to PDF</x-primary-button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <x-input-label for="startDate" value="{{ __('Start Date') }}" />
            <x-text-input wire:model.live="startDate" id="startDate" class="block mt-1 w-full" type="date" />
        </div>
        <div>
            <x-input-label for="endDate" value="{{ __('End Date') }}" />
            <x-text-input wire:model.live="endDate" id="endDate" class="block mt-1 w-full" type="date" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
            <h4 class="font-semibold text-gray-700">Total Sales</h4>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($totalSalesAmount, 2) }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
            <h4 class="font-semibold text-gray-700">Total Expenses</h4>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($totalExpensesAmount, 2) }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
            <h4 class="font-semibold text-gray-700">Profit</h4>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($profit, 2) }}</p>
        </div>
    </div>

    <h4 class="font-semibold text-gray-700 mt-6 mb-2">Monthly Sales Report</h4>
    <div class="mt-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($monthlySales as $sale)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $sale->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($sale->total_price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center">No sales data available for this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h4 class="font-semibold text-gray-700 mt-6 mb-2">Top Selling Products (by highest selling price)</h4>
    <div class="mt-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Selling Price</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($topSellingProducts as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($product->selling_price, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 whitespace-nowrap text-center">No top selling products data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h4 class="font-semibold text-gray-700 mt-6 mb-2">Finance Summary Chart (Placeholder)</h4>
    <div class="bg-gray-50 p-4 rounded-lg shadow-sm h-64 flex items-center justify-center">
        <p class="text-gray-500">Chart integration coming soon...</p>
    </div>
</div>