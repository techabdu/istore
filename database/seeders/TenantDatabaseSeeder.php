<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default roles for the tenant
        Role::firstOrCreate(['name' => 'SuperAdmin']);
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Staff']);

        // Create a default SuperAdmin user for the tenant
        $superAdminRole = Role::where('name', 'SuperAdmin')->first();

        if ($superAdminRole) {
            User::firstOrCreate(
                ['email' => 'admin@tenant.com'],
                [
                    'name' => 'Tenant Super Admin',
                    'password' => Hash::make('password'),
                    'role_id' => $superAdminRole->id,
                ]
            );
        }
    }
}
