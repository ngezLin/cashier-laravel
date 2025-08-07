<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionItemSeeder extends Seeder
{
    public function run(): void
    {
        $productIds = DB::table('products')->pluck('id')->toArray();
        $transactionIds = DB::table('transactions')->pluck('id')->toArray();

        if (empty($productIds) || empty($transactionIds)) {
            return;
        }

        $items = [];

        foreach ($transactionIds as $transactionId) {
            $itemCount = rand(1, 5);
            $selectedProducts = array_rand(array_flip($productIds), $itemCount);

            foreach ((array) $selectedProducts as $productId) {
                $quantity = rand(1, 5);
                $product = DB::table('products')->where('id', $productId)->first();

                $items[] = [
                    'transaction_id' => $transactionId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->sell_price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('transaction_items')->insert($items);
    }
}
