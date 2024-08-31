<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'Wholesaler', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'Retailer', 'guard_name' => 'api']);
    }
}
