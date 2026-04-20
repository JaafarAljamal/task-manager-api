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

    /**
     * Function to update a stored task in storage by id and return 
     * a JSON response with status 200 OK.
     * 
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return response()->json($task, 200);
    }

    /**
     * Function to view a stored task in storage by id and return 
     * a JSON response with status 200 OK.
     * 
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $task = Task::findOrFail($id);
        return response()->json($task, 200);
    }
}
