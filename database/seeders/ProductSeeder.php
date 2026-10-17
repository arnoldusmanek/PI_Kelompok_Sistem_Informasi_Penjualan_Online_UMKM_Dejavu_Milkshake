<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Chocolate Oreo',
                'description' => 'Milkshake cokelat dengan perpaduan biskuit Oreo.',
                'price' => 18000,
                'image' => 'images/products/choco-oreo.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Strawberry Milkshake',
                'description' => 'Milkshake stroberi dengan rasa manis dan segar.',
                'price' => 18000,
                'image' => 'images/products/strawberry.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Vanilla Milkshake',
                'description' => 'Milkshake vanilla yang lembut dan creamy.',
                'price' => 16000,
                'image' => 'images/products/vanilla.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Taro Milkshake',
                'description' => 'Milkshake taro dengan rasa khas yang nikmat.',
                'price' => 18000,
                'image' => 'images/products/taro.jpg',
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
