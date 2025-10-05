<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user@example.com')->first();

        Product::create([
            'name' => 'Laptop',
            'description' => 'A powerful laptop for all your needs.',
            'price' => 1200.50,
            'image_path' => 'https://via.placeholder.com/150',
            'user_id' => $user->id
        ]);

        Product::create([
            'name' => 'Smartphone',
            'description' => 'A smartphone with a great camera.',
            'price' => 800.00,
            'image_path' => 'https://via.placeholder.com/150',
            'user_id' => $user->id
        ]);

        Product::create([
            'name' => 'Headphones',
            'description' => 'Noise-cancelling headphones.',
            'price' => 150.75,
            'image_path' => 'https://via.placeholder.com/150',
            'user_id' => $user->id
        ]);

        Product::create([
            'name' => 'Keyboard',
            'description' => 'A mechanical keyboard.',
            'price' => 100.00,
            'image_path' => 'https://via.placeholder.com/150',
            'user_id' => $user->id
        ]);

        Product::create([
            'name' => 'Mouse',
            'description' => 'A wireless mouse.',
            'price' => 50.00,
            'image_path' => 'https://via.placeholder.com/150',
            'user_id' => $user->id
        ]);
    }
}
