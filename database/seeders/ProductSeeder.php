<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [];

        for ($i = 1; $i <= 20; $i++) {
            $buyPrice = rand(1000, 10000);
            $sellPrice = $buyPrice + rand(500, 5000);

            $products[] = [
                'product_name' => 'Produk test ' . Str::random(5),
                'buy_price' => $buyPrice,
                'sell_price' => $sellPrice,
                'stock' => rand(10, 200),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}
