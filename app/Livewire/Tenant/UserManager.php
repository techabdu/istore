<?php

namespace App\Livewire\Tenant;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManager extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'asc';

    public $showUserModal = false;
    public $editingUser = null;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role_id;

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Password::defaults()],
        'role_id' => ['required', 'exists:roles,id'],
    ];

    protected $messages = [
        'role_id.required' => 'The role field is required.',
        'role_id.exists' => 'The selected role is invalid.',
    ];

    public function mount()
    {
        $this->role_id = Role::where('name', 'Admin')->first()->id; // Default to Admin role
    }

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

    public function createUser()
    {
        $this->resetValidation();
        $this->showUserModal = true;
        $this->editingUser = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role_id = Role::where('name', 'Admin')->first()->id; // Default to Admin role
    }

    public function storeUser()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $this->role_id,
        ]);

        session()->flash('message', 'User created successfully.');
        $this->showUserModal = false;
        $this->resetPage();
        return redirect()->route('tenant.admin.dashboard');
    }

    public function editUser(User $user)
    {
        $this->resetValidation();
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->showUserModal = true;
    }

    public function updateUser()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->editingUser->id],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $this->editingUser->update([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ]);

        session()->flash('message', 'User updated successfully.');
        $this->showUserModal = false;
        return redirect()->route('tenant.admin.dashboard');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->where('role_id', Role::where('name', 'Admin')->first()->id) // Only show Admin users
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $roles = Role::all(); // Fetch all roles for the dropdown

        return view('livewire.tenant.user-manager', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}