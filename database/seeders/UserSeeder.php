<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all()->keyBy('name');

        $this->seedUsers('Wholesaler', 17, $roles);
        $this->seedUsers('Retailer', 33, $roles);
        $this->seedUsers('Admin', 5, $roles);
    }

    private function seedUsers(string $roleName, int $count, $roles)
    {
        // Ensure the role exists
        if (!$roles->has($roleName)) {
            $this->command->error("Role '{$roleName}' does not exist.");
            return;
        }

        // Create users and assign role
        foreach (range(1, $count) as $index) {
            User::create([
                'name' => "{$roleName} User {$index}",
                'email' => strtolower("{$roleName}User{$index}@example.com"),
                'password' => Hash::make('password'),
            ])->assignRole($roles[$roleName]);
        }

        $this->command->info("Seeded {$count} {$roleName} users.");
    }
}
