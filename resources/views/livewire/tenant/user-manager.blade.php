<div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <input wire:model.live="search" type="text" placeholder="Search users..." class="form-input rounded-md shadow-sm mt-1 block w-1/3">
        <x-primary-button wire:click="createUser">Add New User</x-primary-button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
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
                        <a href="#" wire:click.prevent="sortBy('email')">Email</a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="#" wire:click.prevent="sortBy('role_id')">Role</a>
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
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->role->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($user->status) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <x-secondary-button wire:click="editUser({{ $user->id }})" class="mr-2">Edit</x-secondary-button>
                            <x-danger-button wire:click="deleteUser({{ $user->id }})" class="mr-2">Delete</x-danger-button>
                            <x-secondary-button wire:click="resetUserPassword({{ $user->id }})" class="mr-2">Reset Password</x-secondary-button>
                            @if ($user->status === 'active')
                                <x-danger-button wire:click="deactivateUser({{ $user->id }})">Deactivate</x-danger-button>
                            @else
                                <x-primary-button wire:click="deactivateUser({{ $user->id }})">Activate</x-primary-button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <x-modal wire:model.live="showUserModal">
        <form wire:submit.prevent="{{ $userId ? 'updateUser' : 'storeUser' }}">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $userId ? 'Edit User' : 'Create New User' }}</h3>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <x-input-label for="name" value="{{ __('Name') }}" />
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="email" value="{{ __('Email') }}" />
                    <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="role_id" value="{{ __('Role') }}" />
                    <select wire:model="role_id" id="role_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                </div>
                @if (!$userId)
                    <div>
                        <x-input-label for="password" value="{{ __('Password') }}" />
                        <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                @endif
            </div>

            <div class="mt-4 flex justify-end">
                <x-secondary-button wire:click="$set('showUserModal', false)" class="mr-2">Cancel</x-secondary-button>
                <x-primary-button type="submit">{{ $userId ? 'Update' : 'Create' }}</x-primary-button>
            </div>
        </form>
    </x-modal>
</div>