<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900">Total Tenants</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalTenants }}</p>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900">Total Products Across All Tenants</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalProducts }}</p>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900">Total Sales Across All Tenants</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">${{ number_format($totalSalesAmount, 2) }}</p>
    </div>
</div>