<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CentralUser;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DeveloperSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developerRole = Role::where('name', 'Developer')->first();

        if ($developerRole) {
            CentralUser::create([
                'name' => 'Developer Super Admin',
                'email' => 'dev@istore.com',
                'password' => Hash::make('password'),
                'role_id' => $developerRole->id,
            ]);
        }
    }
}