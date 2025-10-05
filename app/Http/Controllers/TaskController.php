<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Catigory;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //View all tasks with Authentication
    public function index()
    {
        $tasks = Auth::user()->tasks;
        //$task = Task::all();
        return response()->json($tasks, 200);
    }
    //get all tasks only for user admin
    public function getAllTasks()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }
    public function getTasksByPriority(String $sort)
    {
        try {
            if ($sort == "DESC")
                $tasks = Auth::user()->tasks()->orderByRaw("FIELD(Priority,'high','medium','low')")->get();
            elseif ($sort == "ASC")
                $tasks = Auth::user()->tasks()->orderByRaw("FIELD(Priority,'low','medium','high')")->get();
            return response()->json($tasks, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => "Please insert DESC or ASC in request",
                'details' => $e->getMessage()
            ], 400);
        }
    }
    public function addToFavorites($taskId)
    {
        Task::findOrFail($taskId);
        Auth::user()->favoritesTask()->syncWithoutDetaching($taskId);
        return response()->json(['message' => "Favorite Attached Successfully"], 201);
    }
    public function removeFromFavorites($taskId)
    {
        Task::findOrFail($taskId);
        Auth::user()->favoritesTask()->detach($taskId);
        return response()->json(['message' => "Favorite removed Successfully"], 200);
    }
    public function getFavoriteTasks()
    {
        $favorites = Auth::user()->favoritesTask;
        return response()->json($favorites, 200);
    }



    //View all tasks witout Authentication
    // public function index()
    // {
    //     $task = Task::all();
    //     return response()->json($task, 200);
    // }

    // public function store(Request $request)
    //{
    //Store with validation
    //      $validatedData = $request->validate([
    //     'title' => 'required | string |max:40',
    //     'descryption' => 'nullable|string',
    //     'Priority' => 'required|integer | between:1,5'
    // ]);
    // $task = Task::create($validatedData);
    // return response()->json($task, 201);

    //store without validation
    // $task = Task::create([
    //     'title' => $request->title,
    //     'descryption' => $request->descryption,
    //     'Priority' => $request->Priority
    // ]);
    //return response()->json($task, 201);

    //Another way to store task's data without validation:
    // $task = new Task;
    // $task->title = $request->title;
    // $task->descryption = $request->descryption;
    // $task->Priority = $request->Priority;
    // $task->save();
    // return response()->json($task, 201);
    // }

    //Store with validation using form request
    // public function store(StoreTaskRequest $request)
    // {
    //     $task = Task::create($request->validated());
    //     return response()->json($task, 201);
    // }

    //Store with Authentication Sanctum
    public function store(StoreTaskRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        $task = Task::create($validatedData);
        return response()->json($task, 201);
    }

    //public function update(Request $request, $id)
    // {
    //Update with validation
    // $task = Task::findOrFail($id);
    // $validatedData = $request->validate([
    //     'title' => 'sometimes |string|max:40',
    //     'descryption' => 'nullable|string',
    //     'Priority' => 'integer | between:1,5'
    // ]);
    // $task->update($validatedData);
    // $task = Task::findOrFail($id);
    // return response()->json($task, 200);


    //Update without validation
    // $task = Task::findOrFail($id);
    // $task->update($request->all());
    // //$task->update($request->only('title', 'descryption', 'Priority'));
    // $task = Task::find($id);
    // return response()->json($task, 200);
    //}

    //Update with validation using form request
    // public function update(UpdateTaskRequest $request, $id)
    // {
    //     $task = Task::findOrFail($id);
    //     $task->update($request->validated());
    //     $task = Task::findOrFail($id);
    //     return response()->json($task, 200);
    // }
    //Update Wiht Authentication
    public function update(UpdateTaskRequest $request, $id)
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);
        if ($task->user_id != $user_id) {
            return response()->json([
                'message' => "UnAuthorized"
            ], 403);
        }
        $task->update($request->validated());
        $task = Task::findOrFail($id);
        return response()->json($task, 200);
    }


    //show without authenticaion
    // public function show($id)
    // {
    //     $task = Task::find($id);
    //     return response()->json($task, 200);
    // }

    //Show with authentication
    public function show($id)
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);
        if ($task->user_id != $user_id) {
            return response()->json([
                'message' => "UnAuthorized"
            ], 403);
        }
        return response()->json($task, 200);
    }
    //delete without authentication
    // public function destroy($id)
    // {
    //     $task = Task::findOrFail($id);
    //     $task->delete();
    //     return response()->json(null, 204);
    // }

    //delete with authentication
    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        try {
            $task = Task::findOrFail($id);
            if ($task->user_id != $user_id) {
                return response()->json([
                    'message' => "UnAuthorized"
                ], 403);
            }
            $task->delete();
            return response()->json("Task Deleted Successfully", 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => "Task Not found",
                'details' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => "Something went wrong while deleting the Task",
                'details' => $e->getMessage()
            ], 404);
        }
    }
    // public function updateorcreate()
    // {
    //     $task = Task::updateorcreate(
    //         ['title' => 'learn laravel 22', 'descryption' => 'learn CRUD 23'],
    //         ['Priority' => 25]
    //     );
    //     return response()->json($task, 200);
    // }
    public function getTaskUser($id)
    {
        $user = Task::findOrFail($id)->user;
        return response()->json($user, 200);
    }
    public function addCatigoriesToTask(Request $request, $taskId)
    {
        $user_id = Auth::user()->id;
        try {
            $task = Task::findOrFail($taskId);
            if ($task->user_id != $user_id) {
                return response()->json([
                    'message' => "UnAuthorized"
                ], 403);
            }
            $task->catigories()->attach($request->catigory_id);
            return response()->json("Catigory attached successfully", 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => "Task not found",
                'details' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => "Something went wrong while add categories to this task",
                'details' => $e->getMessage()
            ], 400);
        }
    }
    public function getTaskCatigories($taskId)
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($taskId);
        if ($task->user_id != $user_id) {
            return response()->json([
                'message' => "UnAuthorized"
            ], 403);
        }
        $catigories = $task->catigories;
        return response()->json($catigories, 200);
    }
    public function getCatigoriesTasks($catigoryId)
    {
        $tasks = Catigory::findOrFail($catigoryId)->tasks;
        return response()->json($tasks, 200);
    }
}
