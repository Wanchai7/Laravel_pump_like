<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop',
            'description' => 'A powerful laptop for all your needs.',
            'price' => 1200.50
        ]);

        Product::create([
            'name' => 'Smartphone',
            'description' => 'A smartphone with a great camera.',
            'price' => 800.00
        ]);

        Product::create([
            'name' => 'Headphones',
            'description' => 'Noise-cancelling headphones.',
            'price' => 150.75
        ]);
    }
}
