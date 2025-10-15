<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DeveloperSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, find the SuperAdmin role.
        $superAdminRole = Role::where('name', 'SuperAdmin')->first();

        // If the role exists, create the user with the correct role_id.
        if ($superAdminRole) {
            User::create([
                'name' => 'Developer Super Admin',
                'email' => 'dev@istore.com',
                'password' => Hash::make('password'),
                'role_id' => $superAdminRole->id, // Use the numeric ID here
            ]);
        }
    }
}