<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the category-associated tasks for the given category ID and return 
     * a JSON response with status 200 OK.
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoryTasks($id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $tasks = $category->tasks;
        return response()->json($tasks, 200);
    }
}
