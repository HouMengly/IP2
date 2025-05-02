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

    /**
     * Test ID: PRO-001
     * Test Name: Product Creation Test
     * Description: Verifies that a product can be successfully created and stored in the database.
     * Test Case:
     *   - Creates a category
     *   - Creates a product with required fields
     *   - Asserts the product exists in database
     */
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

    /**
     * Test ID: PRO-002
     * Test Name: Get All Products API Test
     * Description: Verifies the products API endpoint returns all products with correct structure.
     * Test Case:
     *   - Creates a test product
     *   - Makes GET request to /api/products
     *   - Asserts 200 status code
     *   - Verifies response JSON structure matches expected format
     */
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

        $response->assertStatus(200);
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

    /**
     * Test ID: PRO-003
     * Test Name: Get Single Product Test
     * Description: Verifies that a single product can be retrieved by its ID.
     * Test Case:
     *   - Creates a test product
     *   - Makes GET request to product's endpoint
     *   - Asserts 200 status code
     *   - Verifies returned product matches created product
     */
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

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $product->id,
                     'name' => 'Mouse',
                     'pricing' => 25,
                 ]);
    }

    /**
     * Test ID: PRO-004
     * Test Name: Product Update Test
     * Description: Verifies that a product can be successfully updated.
     * Test Case:
     *   - Creates a test product
     *   - Makes PATCH request to update product
     *   - Asserts 200 status code
     *   - Verifies success message in response
     */
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

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'message' => 'Product updated successfully'
                 ]);
    }

    /**
     * Test ID: PRO-005
     * Test Name: Product Deletion Test
     * Description: Verifies that a product can be permanently deleted.
     * Test Case:
     *   - Creates a test product with mock image
     *   - Mocks storage to expect image deletion
     *   - Makes DELETE request to product endpoint
     *   - Asserts:
     *     - 200 status code
     *     - Success message in response
     *     - Product is removed from database
     *     - Associated image is deleted from storage
     */
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

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Product deleted successfully']);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        
        Storage::disk('public')->assertMissing('products/image1.jpg');
    }
}