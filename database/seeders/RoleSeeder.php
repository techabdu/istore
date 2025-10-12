<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'developer', 'description' => 'System Developer'],
            ['name' => 'super_admin', 'description' => 'Overall Super Administrator'],
            ['name' => 'admin', 'description' => 'Tenant Administrator'],
            ['name' => 'customer', 'description' => 'Regular Customer'],
        ]);
    }
}
