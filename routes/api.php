<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * API Route: Create a new task
 */
Route::post('/task', [TaskController::class, 'store']);

/**
 * API Route: View all stored tasks
 */
Route::get('/tasks', [TaskController::class, 'index']);

/**
 * API Route: Update a task
 */
Route::put('/task/{id}', [TaskController::class, 'update']);

/**
 * API Route: View a task
 */
Route::get('/task/{id}', [TaskController::class, 'show']);

/**
 * API Route: Delete a task
 */
Route::delete('/task/{id}', [TaskController::class, 'destroy']);

/**
 * API Route: Create a new profile
 */
Route::post('/profile', [ProfileController::class, 'store']);

/**
 * API Route: View an associated profile
 */
Route::get('/profile/{user_id}', [ProfileController::class, 'show']);

/**
 * API Route: Update an associated profile
 */
Route::put('/profile/{user_id}', [ProfileController::class, 'update']);

/**
 * API Route: View all the user-associated tasks
 */
Route::get('user/{user_id}/tasks', [TaskController::class, 'userTasks']);

/**
 * API Route: View the task-associated user
 */
Route::get('task/{id}/user', [TaskController::class, 'taskUser']);

/**
 * API Route: Add categories to a task
 */
Route::post('/task/{id}/categories', [TaskController::class, 'attachCategory']);
