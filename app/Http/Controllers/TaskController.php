<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    /**
     * Display all stored tasks in storage and return a JSON response with status 200 OK.
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
     * Update a stored task in storage by ID and return a JSON response with status 200 OK.
     * 
     * @param App\Http\Requests\UpdateTaskRequest $request
     * @param int $id
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
     * Display a stored task in storage by ID and return a JSON response with status 200 OK.
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $task = Task::findOrFail($id);
        return response()->json($task, 200);
    }

    /**
     * Delete a stored task in storage by ID and return a JSON response
     * with status 204 No Content.
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }

    /**
     * Display the user-associated tasks in storage by user ID and return a JSON response
     * with status 200 OK.
     * 
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function userTasks($user_id): JsonResponse
    {
        $tasks = User::findOrFail($user_id)->tasks;
        return response()->json($tasks, 200);
    }

    /**
     * Display task-associated user by task ID and return a JSON response with status 200 OK.
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function taskUser($id): JsonResponse
    {
        $user = Task::findOrFail($id)->user;
        return response()->json($user, 200);
    }

    /**
     * Attach categories to a task by task ID and return a JSON response with status 200 OK.
     * 
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachCategory(Request $request, $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->categories()->attach($request->category_id);
        return response()->json(['message' => 'Category(s) attached successfully'], 200);
    }
}
