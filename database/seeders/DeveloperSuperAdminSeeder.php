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
        $developerRole = Role::where('name', 'developer')->first();

        User::create([
            'name' => 'Developer Super Admin',
            'email' => 'dev@istore.com',
            'password' => Hash::make('password'),
            'is_developer' => true,
            'role_id' => $developerRole->id,
        ]);
    }
}
