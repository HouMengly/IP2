<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class CategoryController extends Controller
{
    public function getCategories()
    {
        return response()->json('Getting list of categories');
    }

    public function createCategory(Request $request)
    {
        return response()->json('Creating a new category');
    }

    public function getCategory($categoryId)
    {
        return response()->json("Getting category with ID: {$categoryId}");
    }

    public function updateCategory(Request $request, $categoryId)
    {
        return response()->json("Updating category with ID: {$categoryId}");
    }

    public function deleteCategory($categoryId)
    {
        return response()->json("Deleting category with ID: {$categoryId}");
    }
}