<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test ID: CAT-001
     * Test Name: Category Creation Test
     * Description: Verifies that a category can be successfully created and stored in the database
     * Test Steps:
     *   1. Create a new category with name 'Electronics'
     *   2. Verify the category exists in the database
     * Expected Result: The category should be present in the database
     * Actual Result: The category is successfully created
     * Status: Passed
     */
    public function test_a_category_can_be_created(): void
    {
        $category = Category::create(['name' => 'Electronics']);
        $this->assertDatabaseHas('categories', ['name' => 'Electronics']);
    }

    /**
     * Test ID: CAT-002
     * Test Name: Get All Categories API Test
     * Description: Verifies the categories API endpoint returns all categories with correct structure
     * Test Steps:
     *   1. Create a test category
     *   2. Make GET request to /api/categories
     *   3. Verify response status and structure
     * Expected Result:
     *   - HTTP 200 status code
     *   - Response contains the created category data
     * Actual Result: API returns categories in expected format
     * Status: Passed
     */
    public function test_if_we_can_access_get_all_categories_api(): void
    {
        $category = Category::create(['name' => 'Test Category']);
        
        $response = $this->get('/api/categories');
        
        $response->assertStatus(200)
                 ->assertJson([[
                     'id' => $category->id,
                     'name' => 'Test Category'
                 ]]);
    }

    /**
     * Test ID: CAT-003
     * Test Name: Get Single Category Test
     * Description: Verifies that a single category can be retrieved by its ID
     * Test Steps:
     *   1. Create a test category
     *   2. Make GET request to the category's endpoint
     *   3. Verify response contains correct category data
     * Expected Result:
     *   - HTTP 200 status code
     *   - Response contains the category details
     * Actual Result: API returns the requested category
     * Status: Passed
     */
    public function test_get_single_category(): void
    {
        $category = Category::create(['name' => 'Books']);
        $response = $this->get("/api/categories/{$category->id}");
        
        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $category->id,
                     'name' => 'Books',
                 ]);
    }

    /**
     * Test ID: CAT-004
     * Test Name: Category Update Test
     * Description: Verifies that a category can be successfully updated
     * Test Steps:
     *   1. Create a test category
     *   2. Make PATCH request to update the category
     *   3. Verify response and database update
     * Expected Result:
     *   - HTTP 200 status code
     *   - Success message in response
     *   - Category name updated in database
     * Actual Result: Category is successfully updated
     * Status: Passed
     */
    public function test_update_category(): void
    {
        $category = Category::create(['name' => 'Old Name']);
        
        $response = $this->patch("/api/categories/{$category->id}", [
            'name' => 'New Name',
        ]);
        
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Category updated successfully',
                     'category' => ['name' => 'New Name'],
                 ]);
        
        $this->assertDatabaseHas('categories', ['name' => 'New Name']);
    }

    /**
     * Test ID: CAT-005
     * Test Name: Category Deletion Test
     * Description: Verifies that a category can be permanently deleted
     * Test Steps:
     *   1. Create a test category
     *   2. Make DELETE request to category endpoint
     *   3. Verify response and database removal
     * Expected Result:
     *   - HTTP 200 status code
     *   - Success message in response
     *   - Category removed from database
     * Actual Result: Category is permanently deleted
     * Status: Passed
     */
    public function test_delete_category(): void
    {
        $category = Category::create(['name' => 'To be deleted']);
        
        $response = $this->delete("/api/categories/{$category->id}");
        
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Category deleted successfully']);
        
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /**
     * Test ID: CAT-006
     * Test Name: Category Creation via API Test
     * Description: Verifies that a category can be created through the API
     * Test Steps:
     *   1. Make POST request to create a new category
     *   2. Verify response and database entry
     * Expected Result:
     *   - HTTP 200 status code
     *   - Success message in response
     *   - New category exists in database
     * Actual Result: Category is successfully created via API
     * Status: Passed
     */
    public function test_create_category_via_api(): void
    {
        $response = $this->post('/api/categories', [
            'name' => 'Clothing',
        ]);
        
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Creating a new category',
                     'category' => ['name' => 'Clothing'],
                 ]);
        
        $this->assertDatabaseHas('categories', ['name' => 'Clothing']);
    }
}