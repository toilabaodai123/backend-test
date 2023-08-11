<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_stores(): void
    {
        $user = User::factory()->create();

        Store::factory(10)->create(['user_id' => $user->id])->each(function ($store) {
            Product::factory(10)->create([
                'store_id' => $store->id,
            ]);
        });

        $response = $this->actingAs($user)->getJson(route('product.all'));

        $response->assertStatus(200);
    }

    public function test_add_product(): void
    {
        $user = User::factory()->create();

        $store = Store::factory()->create([
            'user_id' => $user->id,
        ]);

        $product = Product::factory()->make([
            'store_id' => $store->id,
        ]);

        $response = $this->actingAs($user)->postJson(route('product.add'), $product->toArray());

        $response->assertStatus(200);

        $product->id = Product::latest()->first()->id;

        $this->assertDatabaseHas('products',$product->toArray());
    }

    public function test_update_product(): void
    {
        $user = User::factory()->create();

        $store = Store::factory()->create([
            'user_id' => $user->id,
        ]);

        $product = Product::factory()->create([
            'store_id' => $store->id,
        ]);

        $productParams = [
            'name' => 'new name',
            'description' => 'new description',
            'stock' => 123,
            'price' => 456
        ];

        $response = $this->actingAs($user)->putJson(route('product.update', ['id' => $product->id]), $productParams);

        $response->assertStatus(200);

        $productParams['id'] = $product->id;

        $this->assertDatabaseHas('products', $productParams);
    }

    public function test_user_cant_update_product_not_in_list(): void
    {
        $user = User::factory()->create();

        $store = Store::factory()->create([
            'user_id' => $user->id,
        ]);

        $product = Product::factory()->create([
            'store_id' => $store->id,
        ]);

        $another_user = User::factory()->create();

        $productParams = [
            'name' => 'new name',
            'description' => 'new description',
            'stock' => 123,
            'price' => 456
        ];

        $response = $this->actingAs($another_user)->putJson(route('product.update', ['id' => $product->id]), $productParams);

        $response->assertStatus(404);
    }

    public function test_delete_store(): void
    {
        $user = User::factory()->create();

        $store = Store::factory()->create([
            'user_id' => $user->id,
        ]);

        $product = Product::factory()->create([
            'store_id' => $store->id,
        ]);

        $response = $this->actingAs($user)->deleteJson(route('product.delete', ['id' => $product->id]));

        $response->assertStatus(200);

        $this->assertSoftDeleted('products', [
            'id' => $product->id
        ]);
    }

    public function test_user_cant_delete_product_not_in_list(): void
    {
        $user = User::factory()->create();

        $store = Store::factory()->create([
            'user_id' => $user->id,
        ]);

        $product = Product::factory()->create([
            'store_id' => $store->id,
        ]);        

        $another_user = User::factory()->create();

        $response = $this->actingAs($another_user)->deleteJson(route('product.delete', ['id' => $product->id]));

        $response->assertStatus(404);
    }

    public function test_unauthenticated_user_cant_make_any_action(): void
    {
        $response = $this->getJson(route('product.all'));

        $response->assertStatus(401);

        $response = $this->getJson(route('product.show', ['id' => 0]));

        $response->assertStatus(401);

        $response = $this->postJson(route('product.add'));

        $response->assertStatus(401);

        $response = $this->putJson(route('product.update', ['id' => 0]));

        $response->assertStatus(401);

        $response = $this->deleteJson(route('product.delete', ['id' => 0]));

        $response->assertStatus(401);
    }
}
