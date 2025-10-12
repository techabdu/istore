<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DeveloperSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Developer Super Admin',
            'email' => 'dev@istore.com',
            'password' => Hash::make('password'),
            'role' => 'developer_super_admin',
        ]);
    }
}
