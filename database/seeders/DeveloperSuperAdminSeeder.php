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
        // Find the Developer role.
        $developerRole = Role::where('name', 'Developer')->first();

        // If the role exists, create the user with the correct role_id.
        if ($developerRole) {
            User::create([
                'name' => 'Developer Super Admin',
                'email' => 'dev@istore.com',
                'password' => Hash::make('password'),
                'role_id' => $developerRole->id, // Use the numeric ID here
            ]);
        }
    }
}
