<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

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
     * @param App\Http\Requests\StoreTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    /**
     * Function to update a stored task in storage by id and return 
     * a JSON response with status 200 OK.
     * 
     * @param App\Http\Requests\UpdateTaskRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $validated = $request->validated();
        $task->updateOrFail($validated);
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

    /**
     * Function to delete a stored task in storage by id and return 
     * a JSON response with status 204 No Content .
     */
    public function destroy($id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }
}
