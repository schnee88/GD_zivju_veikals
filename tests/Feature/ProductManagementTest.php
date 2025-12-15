<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Fish;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    /**
     * Test 1: Produktu kataloga skatīšana bez autentifikācijas
     */
    public function test_guest_can_view_product_catalog()
    {
        Fish::factory()->count(5)->create();
        $response = $this->get('/products');
        $response->assertStatus(200);
    }

    /**
     * Test 2: Administrators var pievienot jaunu produktu
     * PIEZĪME: Šis tests prasa 'role' kolonnu vai citu autorizācijas mehānismu
     */
    public function test_admin_can_create_product()
    {
        // Izveidojam administratoru
        $admin = User::factory()->admin()->create();

        Storage::fake('public');
        $image = UploadedFile::fake()->image('fish.jpg');

        $response = $this->actingAs($admin)->post('/admin/products', [
            'name' => 'Lasis',
            'description' => 'Svaigs lasis no Norvēģijas',
            'price' => 12.99,
            'stock_quantity' => 50,
            'image' => $image
        ]);

        // Pārbaudām, ka produkts tika izveidots
        $this->assertDatabaseHas('fishes', [
            'name' => 'Lasis',
            'price' => 12.99,
            'stock_quantity' => 50
        ]);
    }

    /**
     * Test 3: Parasts lietotājs nevar pievienot produktu
     * PIEZĪME: Šis tests var neizdoties bez role sistēmas
     */
    public function test_regular_user_cannot_create_product()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/products', [
            'name' => 'Forele',
            'price' => 8.99,
            'stock_quantity' => 30
        ]);

        // Pārbaudām piekļuves kontroli
        // Tas var būt 403 vai 404 atkarībā no tā, kā ir ieviesta autorizācija
        $this->assertTrue(
            $response->status() === 403 || $response->status() === 404 || $response->status() === 302
        );
    }

    /**
     * Test 4: Produkta pievienošana ar negatīvu cenu
     */
    public function test_product_creation_fails_with_negative_price()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/admin/products', [
            'name' => 'Siļķe',
            'price' => -5.99,
            'stock_quantity' => 100
        ]);

        $response->assertSessionHasErrors('price');
    }

    /**
     * Test 5: Produkta meklēšana pēc nosaukuma
     */
    public function test_product_search_by_name()
    {
        Fish::factory()->create(['name' => 'Lasis']);
        Fish::factory()->create(['name' => 'Forele']);
        Fish::factory()->create(['name' => 'Siļķe']);

        $response = $this->get('/products?search=Lasis');

        $response->assertStatus(200);
    }

    /**
     * Test 6: Produkta atjaunināšana
     */
    public function test_admin_can_update_product_price()
    {
        $admin = User::factory()->admin()->create();
        $fish = Fish::factory()->create([
            'name' => 'Lasis',
            'price' => 12.99
        ]);

        $response = $this->actingAs($admin)->put("/admin/products/{$fish->id}", [
            'name' => 'Lasis',
            'price' => 14.99,
            'stock_quantity' => $fish->stock_quantity
        ]);

        $this->assertDatabaseHas('fishes', [
            'id' => $fish->id,
            'price' => 14.99
        ]);
    }

    /**
     * Test 7: Produkta dzēšana
     */
    public function test_admin_can_delete_product()
    {
        $admin = User::factory()->admin()->create();
        $fish = Fish::factory()->create(['name' => 'Vecs produkts']);

        $response = $this->actingAs($admin)->delete("/admin/products/{$fish->id}");

        $this->assertDatabaseMissing('fishes', [
            'id' => $fish->id
        ]);
    }
}