<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900">Total Sales</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">${{ number_format($totalSales, 2) }}</p>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900">Total Expenses</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">${{ number_format($totalExpenses, 2) }}</p>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900">Stock Count</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stockCount }}</p>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900">Profit Summary</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">${{ number_format($profit, 2) }}</p>
    </div>
</div>