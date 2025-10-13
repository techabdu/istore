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

    public $userId;
    public $name, $email, $password, $password_confirmation, $role_id;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $showUserModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => ['required', 'confirmed', Password::defaults()],
        'role_id' => 'required|exists:roles,id',
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

    public function createUser()
    {
        $this->resetInputFields();
        $this->showUserModal = true;
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
        $this->resetInputFields();
        $this->showUserModal = false;
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;

        $this->showUserModal = true;
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->userId,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ]);

        session()->flash('message', 'User updated successfully.');
        $this->resetInputFields();
        $this->showUserModal = false;
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function resetUserPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make('password'); // Reset to a default password
        $user->save();
        session()->flash('message', 'User password reset to 'password'.');
    }

    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'inactive']); // Assuming a status column in users table
        session()->flash('message', 'User deactivated successfully.');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role_id = '';
        $this->userId = null;
    }

    public function render()
    {
        $users = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $roles = Role::all();

        return view('livewire.tenant.user-manager', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
