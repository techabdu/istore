<div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <input wire:model.live="search" type="text" placeholder="Search tenants..." class="form-input rounded-md shadow-sm mt-1 block w-1/3">
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
                        <a href="#" wire:click.prevent="sortBy('business_name')">Business Name</a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="#" wire:click.prevent="sortBy('id')">Domain</a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="#" wire:click.prevent="sortBy('created_at')">Created At</a>
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
                @foreach ($tenants as $tenant)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->business_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach ($tenant->domains as $domain)
                                {{ $domain->domain }}
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($tenant->status) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if ($tenant->status === 'pending' || $tenant->status === 'inactive')
                                <button wire:click="activateTenant('{{ $tenant->id }}')" class="text-green-600 hover:text-green-900 mr-2">Activate</button>
                            @endif
                            @if ($tenant->status === 'active')
                                <button wire:click="deactivateTenant('{{ $tenant->id }}')" class="text-yellow-600 hover:text-yellow-900 mr-2">Deactivate</button>
                            @endif
                            <button wire:click="deleteTenant('{{ $tenant->id }}')" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tenants->links() }}
    </div>
</div>