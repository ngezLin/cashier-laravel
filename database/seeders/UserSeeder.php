<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

//user seeder

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if the users table exists
        if (!Schema::hasTable('users')) {
            return;
        }

        // Insert a default user if no users exist
        if (DB::table('users')->count() === 0) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('test123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
