<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Fish;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShoppingCartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Produkta pievienošana grozam
     */
    public function test_user_can_add_product_to_cart()
    {
        $user = User::factory()->create();
        $fish = Fish::factory()->create([
            'name' => 'Lasis',
            'price' => 12.99,
            'stock_quantity' => 50
        ]);

        $response = $this->actingAs($user)->post('/cart', [
            'fish_id' => $fish->id,
            'quantity' => 2
        ]);

        // Pārbaudām, ka produkts tika pievienots grozam
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'fish_id' => $fish->id,
            'quantity' => 2
        ]);
    }

    /**
     * Test 2: Viesim nav piekļuves grozam
     */
    public function test_guest_cannot_add_to_cart()
    {
        $fish = Fish::factory()->create();

        $response = $this->post('/cart', [
            'fish_id' => $fish->id,
            'quantity' => 1
        ]);

        // Pārbaudām, ka tika pāradresēts uz login
        $response->assertRedirect('/login');
    }

    /**
     * Test 3: Pievienot grozam vairāk produktu nekā pieejams noliktavā
     */
    public function test_cannot_add_more_than_stock_quantity()
    {
        $user = User::factory()->create();
        $fish = Fish::factory()->create([
            'stock_quantity' => 10
        ]);

        $response = $this->actingAs($user)->post('/cart', [
            'fish_id' => $fish->id,
            'quantity' => 15
        ]);

        // Pārbaudām, ka tika atgriezts kļūdas ziņojums
        $response->assertSessionHasErrors('quantity');
    }

    /**
     * Test 4: Groza kopējās summas aprēķins
     */
    public function test_cart_total_calculation()
    {
        $user = User::factory()->create();
        
        $fish1 = Fish::factory()->create(['price' => 10.00]);
        $fish2 = Fish::factory()->create(['price' => 15.00]);

        CartItem::create([
            'user_id' => $user->id,
            'fish_id' => $fish1->id,
            'quantity' => 2
        ]);

        CartItem::create([
            'user_id' => $user->id,
            'fish_id' => $fish2->id,
            'quantity' => 1
        ]);

        $response = $this->actingAs($user)->get('/cart');

        // Kopējā summa: (10 * 2) + (15 * 1) = 35.00
        $response->assertSee('35.00');
    }

    /**
     * Test 5: Produkta noņemšana no groza
     * Sagaidāmais rezultāts: Produkts tiek izdzēsts no groza
     */
    public function test_user_can_remove_item_from_cart()
    {
        $user = User::factory()->create();
        $fish = Fish::factory()->create();
        
        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'fish_id' => $fish->id,
            'quantity' => 2
        ]);

        $response = $this->actingAs($user)->delete("/cart/{$cartItem->id}");

        // Pārbaudām, ka produkts tika noņemts
        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id
        ]);
    }

    /**
     * Test 6: Daudzuma atjaunināšana grozā
     */
    public function test_user_can_update_cart_item_quantity()
    {
        $user = User::factory()->create();
        $fish = Fish::factory()->create(['stock_quantity' => 100]);
        
        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'fish_id' => $fish->id,
            'quantity' => 2
        ]);

        $response = $this->actingAs($user)->put("/cart/{$cartItem->id}", [
            'quantity' => 5
        ]);

        // Pārbaudām, ka daudzums tika atjaunināts
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 5
        ]);
    }

    /**
     * Test 7: Tukša groza skatīšana
     */
    public function test_empty_cart_shows_message()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/cart');

        $response->assertStatus(200);
        $response->assertSee('Jūsu grozs ir tukšs');
    }
}
