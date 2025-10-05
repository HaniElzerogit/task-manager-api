<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/tasks', [TaskController::class, 'index']);
// Route::post('/tasks', [TaskController::class, 'store']);
// Route::put('/tasks/{id}', [TaskController::class, 'update']);
// Route::get('/tasks/{id}', [TaskController::class, 'show']);
// Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
//Route::put('/tasks', [TaskController::class, 'updateorcreate']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/tasks', TaskController::class);
    Route::get('/task/{id}/user', [TaskController::class, 'getTaskUser']);
    Route::post('/task/{taskId}/catigories', [TaskController::class, 'addCatigoriesToTask']);
    Route::get('/task/{taskId}/catigories', [TaskController::class, 'getTaskCatigories']);
    Route::get('/catigory/{catigoryId}/tasks', [TaskController::class, 'getCatigoriesTasks']);

    Route::prefix('/profile')->group(function () {
        Route::post('', [ProfileController::class, 'store']);
        Route::get('/{id}', [ProfileController::class, 'show']);
        Route::put('/{id}', [ProfileController::class, 'update']);
    });

    Route::get('/user/{id}/profile', [UserController::class, 'getProfile']);
    Route::get('/user/{id}/tasks', [UserController::class, 'getUserTasks']);
    Route::get('/user', [UserController::class, 'getUser']);
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('task/all', [TaskController::class, 'getAllTasks'])->middleware('CheckUser');

    Route::get('task/ordered/{sort}', [TaskController::class, 'getTasksByPriority']);
    Route::post('/task/{id}/favorite', [TaskController::class, 'addToFavorites']);
    Route::delete('/task/{id}/favorite', [TaskController::class, 'removeFromFavorites']);
    Route::get('/task/favorite', [TaskController::class, 'getFavoriteTasks']);
});
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
