<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Smartwatch Apple Watch 2.5',
            'price' => 243.58,
            'length' => 12.6,
            'width' => 2.34,
            'height' => 1.73,
            'weight' => 0.62,
            'image' => 'product-5.jpg',
            'category_id' => 2
        ]);
        DB::table('products')->insert([
            'name' => 'Airpods Bitsound',
            'price' => 157.42,
            'length' => 2,
            'width' => 0.94,
            'height' => 3.12,
            'weight' => 0.3,
            'image' => 'product-1.jpg',
            'category_id' => 2
        ]);
        DB::table('products')->insert([
            'name' => 'Timex Unissex',
            'price' => 205.99,
            'length' => 12.6,
            'width' => 2.34,
            'height' => 1.73,
            'weight' => 0.62,
            'image' => 'product-4.jpg',
            'category_id' => 2
        ]);
        DB::table('products')->insert([
            'name' => 'Air Jordan Red',
            'price' => 399.99,
            'length' => 24.5,
            'width' => 8.2,
            'height' => 5.67,
            'weight' => 0.9,
            'image' => 'product-2.jpg',
            'category_id' => 3
        ]);
        DB::table('products')->insert([
            'name' => 'Nike air max 95',
            'price' => 336.95,
            'length' => 24.5,
            'width' => 8.2,
            'height' => 5.67,
            'weight' => 0.9,
            'image' => 'product-6.jpg',
            'category_id' => 3
        ]);
        DB::table('products')->insert([
            'name' => 'Cyan cotton t-shirt',
            'price' => 89.99,
            'length' => 32.66,
            'width' => 0.1,
            'height' => 80,
            'weight' => 0.3,
            'image' => 'product-3.jpg',
            'category_id' => 1
        ]);
    }
}
