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
        // Hardcode the role_id to 3 for Developer to remove all doubt.
        User::create([
            'name' => 'Developer Super Admin',
            'email' => 'dev@istore.com',
            'password' => Hash::make('password'),
            'role_id' => 3, // Hardcoded to ID 3 for Developer
        ]);
    }
}