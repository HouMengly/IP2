<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /*
     * Test ID: Category-001
     * Description: Check if we can access the get all categories api
     * Precondition: None
     * Test Steps: 
     *   1. Hit the get all categories api
     *   2. Check if the response status is 200
     * Test Data: None
     * Expected Result: The response status should be 200
     * Actual Result: The response status is 200
     * Status: Passed
     * Remark: None
     */
    public function test_get_all_categories()
    {
        $response = $this->get('/api/categories');
        $response->assertStatus(200);
    }
}
