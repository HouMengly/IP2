<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    public function test_a_product_can_be_created(): void
    {
        $category = Category::create(['name' => 'Electronics']);

        $product = Product::create([
            'name' => 'Laptop',
            'category_id' => $category->id,
            'pricing' => 1000,
            'description' => 'A good laptop',
            'images' => [],
        ]);

        $this->assertDatabaseHas('products', ['name' => 'Laptop']);
    }

    public function test_if_we_can_access_get_all_products_api(): void
    {
        $category = Category::create(['name' => 'Electronics']);
        Product::create([
            'name' => 'Sample Product',
            'category_id' => $category->id,
            'pricing' => 100,
            'description' => 'Sample description',
            'images' => [],
        ]);

        $response = $this->get('/api/products');

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'pricing',
                'description',
                'images',
                'category_id',
                'category',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    public function test_get_single_product(): void
    {
        $category = Category::create(['name' => 'Accessories']);

        $product = Product::create([
            'name' => 'Mouse',
            'category_id' => $category->id,
            'pricing' => 25,
            'description' => 'Wireless mouse',
            'images' => [],
        ]);

        $response = $this->get("/api/products/{$product->id}");

        $response->assertJson([
                     'id' => $product->id,
                     'name' => 'Mouse',
                     'pricing' => 25,
                 ]);
    }

    public function test_update_product(): void
    {
        $category = Category::create(['name' => 'Books']);

        $product = Product::create([
            'name' => 'Book 1',
            'category_id' => $category->id,
            'pricing' => 10,
            'description' => 'Some description',
            'images' => [],
        ]);

        $response = $this->patch("/api/products/{$product->id}", [
            'name' => 'Updated Book',
            'pricing' => 15,
        ]);

        $response->assertJsonFragment([
                     'message' => 'Product updated successfully'
                 ]);
    }

    public function test_delete_product(): void
    {
        Storage::fake('public');
        
        $category = Category::create(['name' => 'Clothing']);
        $product = Product::create([
            'name' => 'T-shirt',
            'category_id' => $category->id,
            'pricing' => 20,
            'description' => 'Cotton shirt',
            'images' => ['products/image1.jpg'],
        ]);

        Storage::disk('public')->put('products/image1.jpg', 'dummy content');

        $response = $this->delete("/api/products/{$product->id}");

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        
        Storage::disk('public')->assertMissing('products/image1.jpg');
    }
}