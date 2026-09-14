<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_a_product_with_a_success_status(): void
    {
        $product = Product::factory()->create();

        $this->getJson('/api/products/'.$product->id)
            ->assertOk()
            ->assertJsonPath('id', $product->id);
    }

    public function test_an_authenticated_user_can_update_a_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->putJson('/api/products/'.$product->id, [
                'name' => 'Producto actualizado',
                'description' => 'Nueva descripcion',
                'category' => 'Limpieza',
                'price' => 25.50,
                'stock' => 10,
            ])
            ->assertOk()
            ->assertJsonPath('name', 'Producto actualizado');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Producto actualizado',
        ]);
    }

    public function test_product_listing_rejects_invalid_sorting_and_page_size(): void
    {
        $this->getJson('/api/products?sort_by=password&sort_order=drop&per_page=101')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['sort_by', 'sort_order', 'per_page']);
    }
}
