<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'email' => 'guess@yahoo.com',
        ],[
            'name' => 'guess',
            'password' => Hash::make('password')
        ]);

        Store::factory(100)->create([
            'user_id' => $user->id
        ])->each(function ($store){
            Product::factory(20)->create([
                'store_id' => $store->id
            ]);
        });
    }
}
