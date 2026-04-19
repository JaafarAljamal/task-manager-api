<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    /**
     * Function to view all stored tasks in storage and return a JSON response
     * with status 200 OK.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    /**
     * Function to store a newly created task in storage and return a JSON response
     * with status 201 Created.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
        ]);

        return response()->json($task, 201);
    }
}
