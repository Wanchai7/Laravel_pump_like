<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $owner = User::factory()->create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
        ]);
        $owner->roles()->attach(Role::where('name', 'owner')->first());

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $admin->roles()->attach(Role::where('name', 'admin')->first());

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
        ]);
        $user->roles()->attach(Role::where('name', 'user')->first());

        $this->call(ProductSeeder::class);
    }
}
