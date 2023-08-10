<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Store;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_stores(): void
    {
        $user = User::factory()->create();

        Store::factory(10)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->getJson(route('store.all'));

        $response->assertStatus(200);
    }

    public function test_add_store(): void
    {
        $user = User::factory()->create();

        $store = Store::factory()->make([
            'user_id' => $user->id,
        ]);
        
        $storeParams = [
            'name' => $store->name,
            'address' => $store->address,
            'description' => $store->description,
            'is_online' => $store->is_online,
            'user_id' => $store->user_id
        ];

        $response = $this->actingAs($user)->postJson(route('store.add'),$storeParams);

        $this->assertDatabaseHas('stores', [
            'name' => $store->name,
            'address' => $store->address,
            'description' => $store->description,
            'is_online' => $store->is_online,
            'user_id' => $store->user_id
        ]);

        $response->assertStatus(200);
    }    

    public function test_update_store(): void
    {
        $user = User::factory()->create();

        $store = Store::factory()->create([
            'user_id' => $user->id,
        ]);
        
        $storeParams = [
            'name' => 'new name',
            'address' => 'new address',
            'description' => 'new description',
            'is_online' => "false"
        ];

        $response = $this->actingAs($user)->putJson(route('store.update',['id' => $store->id]),$storeParams);

        $this->assertDatabaseHas('stores', [
            'name' => 'new name',
            'address' => 'new address',
            'description' => 'new description',
            'is_online' => "false"
        ]);

        $response->assertStatus(200);
    }  

    public function test_user_cant_update_store_not_in_list(): void
    {
        $user = User::factory()->create();

        $store = Store::factory()->create([
            'user_id' => $user->id,
        ]);

        $another_user = User::factory()->create();
        
        $storeParams = [
            'name' => 'new name',
            'address' => 'new address',
            'description' => 'new description',
            'is_online' => "false"
        ];

        $response = $this->actingAs($another_user)->putJson(route('store.update',['id' => $store->id]),$storeParams);

        $response->assertStatus(404);
    }  

    public function test_unauthenticated_user_cant_make_any_action(): void
    {
        $response = $this->getJson(route('store.all'));

        $response->assertStatus(401);

        $response = $this->postJson(route('store.add'));

        $response->assertStatus(401);

        $response = $this->putJson(route('store.update',['id' => 0]));

        $response->assertStatus(401);        
    }
}
