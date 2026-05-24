<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Show all tasks associated with a given category ID.
     * Returns 200 OK with tasks list or 404 if no tasks attached with category.
     */
    public function getCategoryTasks(int $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $tasks = $category->tasks;

        if ($category->tasks->isEmpty()) {
            return response()->json(['message' => 'No tasks found for this category'], 404);
        }

        return response()->json($tasks, 200);
    }
}
