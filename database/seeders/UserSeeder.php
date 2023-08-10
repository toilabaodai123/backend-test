<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(100)->create()->each(function ($user) {
            Store::factory(rand(1, 20))->create(['user_id' => $user->id])->each(function ($store) {
                Product::factory(10)->create(['store_id' => $store->id,]);
            });
        });
    }
}
