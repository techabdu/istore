<?php

namespace App\Livewire\Developer;

use App\Models\Tenant;
use Livewire\Component;
use Livewire\WithPagination;

class TenantsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'asc';

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

    public function activateTenant($tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        $tenant->put('status', 'active');
        $tenant->save();
        session()->flash('message', 'Tenant activated successfully.');
    }

    public function deactivateTenant($tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        $tenant->put('status', 'inactive');
        $tenant->save();
        session()->flash('message', 'Tenant deactivated successfully.');
    }

    public function deleteTenant($tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        $tenant->delete();
        session()->flash('message', 'Tenant deleted successfully.');
    }

    public function render()
    {
        $tenants = Tenant::query()
            ->where('id', 'like', '%' . $this->search . '%')
            ->orWhere('data->business_name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.developer.tenants-table', [
            'tenants' => $tenants,
        ]);
    }
}
