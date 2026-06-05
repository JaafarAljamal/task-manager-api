<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachCategoryRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display all stored tasks in storage and return a JSON response with status 200 OK.
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();

        return response()->json($tasks, 200);
    }

    /**
     * Function to store a newly created task in storage and return a JSON response
     * with status 201 Created.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $user_id = Auth::user()->id;
        $validated = $request->validated();
        $validated['user_id'] = $user_id;
        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    /**
     * Update a stored task in storage by ID and return a JSON response with status 200 OK.
     *
     * @param  int  $id
     */
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);
        if ($task->user_id != $user_id) {
            return response()->json(['message' => 'You cannot update this task!'], 403);
        }
        $validated = $request->validated();
        $task->updateOrFail($validated);

        return response()->json($task, 200);
    }

    /**
     * Display a stored task in storage by ID and return a JSON response with status 200 OK.
     *
     * @param  int  $id
     */
    public function show($id): JsonResponse
    {
        $user_id = Auth::user()->id;

        $task = Task::findOrFail($id);

        if ($task->user_id != $user_id) {
            return response()->json(['message' => 'You cannot view this task!'], 403);
        }

        return response()->json($task, 200);
    }

    /**
     * Delete a stored task in storage by ID and return a JSON response
     * with status 204 No Content.
     *
     * @param  int  $id
     */
    public function destroy($id): JsonResponse
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);
        if ($task->user_id != $user_id) {
            return response()->json(['message' => 'You cannot delete this task!'], 403);
        }
        $task->delete();

        return response()->json(null, 204);
    }

    /**
     * Display the user-associated tasks in storage by authenticated user ID and return a JSON response
     * with status 200 OK.
     */
    public function userTasks(): JsonResponse
    {
        $tasks = Auth::user()->tasks;

        return response()->json($tasks, 200);
    }

    /**
     * Return all tasks for the authenticated user ordered by priority (high → medium → low).
     */
    public function getTasksByPriority(): JsonResponse
    {
        $tasks = Auth::user()->tasks()->orderByRaw("CASE priority 
                WHEN 'high' THEN 1 
                WHEN 'medium' THEN 2 
                WHEN 'low' THEN 3 
            END")->get();

        return response()->json($tasks, 200);
    }

    /**
     * Display task-associated user by task ID and return a JSON response with status 200 OK.
     */
    public function taskUser(int $id): JsonResponse
    {
        $user = Task::findOrFail($id)->user;

        return response()->json($user, 200);
    }

    /**
     * Attach categories to a task by task ID and return a JSON response with status 200 OK.
     */
    public function attachCategory(AttachCategoryRequest $request, int $id): JsonResponse
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);
        if ($task->user_id != $user_id) {
            return response()->json(['message' => 'You cannot do this action!'], 403);
        }
        $task->categories()->syncWithoutDetaching($request->category_id);

        return response()->json(['message' => 'Category(s) attached successfully'], 200);
    }

    /**
     * Return categories attached to the authenticated user's task.
     */
    public function getTaskCategories(int $id): JsonResponse
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        $categories = $task->categories;

        return response()->json($categories, 200);
    }
}
