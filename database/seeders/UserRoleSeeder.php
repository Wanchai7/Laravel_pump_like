<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find roles
        $ownerRole = Role::where('name', 'owner')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        // Create owner user
        if ($ownerRole) {
            $owner = User::create([
                'name' => 'Owner User',
                'email' => 'owner@example.com',
                'password' => Hash::make('password'),
            ]);
            $owner->roles()->attach($ownerRole);
        }

        // Create admin user
        if ($adminRole) {
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
            $admin->roles()->attach($adminRole);
        }

        // Create regular user
        if ($userRole) {
            $user = User::create([
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
            ]);
            $user->roles()->attach($userRole);
        }
    }
}
