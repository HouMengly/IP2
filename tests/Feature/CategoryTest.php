<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_category_can_be_created(): void
    {
        $category = Category::create(['name' => 'Electronics']);
        $this->assertDatabaseHas('categories', ['name' => 'Electronics']);
    }

    public function test_if_we_can_access_get_all_categories_api(): void
    {
        $category = Category::create(['name' => 'Test Category']);
        
        $response = $this->get('/api/categories');
        
        $response->assertJson([[
                     'id' => $category->id,
                     'name' => 'Test Category'
                 ]]);
    }

    public function test_get_single_category(): void
    {
        $category = Category::create(['name' => 'Books']); 
        $response = $this->get("/api/categories/{$category->id}");
        
        $response->assertJson([
                     'id' => $category->id,
                     'name' => 'Books',
                 ]);
    }
 
    public function test_update_category(): void
    {
        $category = Category::create(['name' => 'Old Name']);
        
        $response = $this->patch("/api/categories/{$category->id}", [
            'name' => 'New Name',
        ]);
        
        $response->assertJson([
                     'message' => 'Category updated successfully',
                     'category' => ['name' => 'New Name'],
                 ]);
        
        $this->assertDatabaseHas('categories', ['name' => 'New Name']);
    }

    public function test_delete_category(): void
    {
        $category = Category::create(['name' => 'To be deleted']);
        
        $response = $this->delete("/api/categories/{$category->id}");
        
        $response->assertJson(['message' => 'Category deleted successfully']);
        
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}