<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->pluck('id')->toArray();

        if (empty($users)) {
            // Jangan lanjutkan jika tidak ada user
            return;
        }

        $transactions = [];

        for ($i = 1; $i <= 10; $i++) {
            $total = rand(5000, 100000);
            $customerAmount = $total + rand(0, 20000);
            $change = $customerAmount - $total;

            $transactions[] = [
                'user_id' => $users[array_rand($users)],
                'total' => $total,
                'customer_amount' => $customerAmount,
                'change' => $change,
                'is_refunded' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('transactions')->insert($transactions);
    }
}
