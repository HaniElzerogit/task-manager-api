<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //Show profile without authentication
    // public function show($id)
    // {
    //     $profile = Profile::where('user_id', $id)->firstOrFail();
    //     return response()->json($profile, 200);
    // }

    //Show profile with authentication
    public function show($id)
    {
        $user_id = Auth::user()->id;
        $profile_user_id = Profile::where('user_id', $id)->firstOrFail()->user_id;
        if ($profile_user_id != $user_id) {
            return response()->json([
                'message' => "UnAuthorized"
            ], 403);
        }
        $profile = Profile::where('user_id', $id)->firstOrFail();
        return response()->json($profile, 200);
    }

    //Store profile without authentication
    // public function store(StoreProfileRequest $request)
    // {
    //     $profile = Profile::create($request->validated());
    //     return response()->json([

    //         'message' => "Profile created successfully",
    //         'profile' => $profile
    //     ], 201);
    // }

    //Store profile with authentication
    public function store(StoreProfileRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('my photo', 'public'); //store('Folder Name' , 'disk Name')
            $validatedData['image'] = $path;
        }
        $profile = Profile::create($validatedData);
        return response()->json([

            'message' => "Profile created successfully",
            'profile' => $profile
        ], 201);
    }

    //Update profile without Authentication
    // public function update(UpdateProfileRequest $request, $id)
    // {
    //     $profile = Profile::where('user_id', $id)->firstOrFail();
    //     $profile->update($request->validated());
    //     //$profile = Profile::findOrFail($id);
    //     return response()->json($profile, 200);
    // }

    //Update profile with Authentication
    public function update(UpdateProfileRequest $request, $id)
    {
        $user_id = Auth::user()->id;
        $profile_user_id = Profile::where('user_id', $id)->firstOrFail()->user_id;
        if ($profile_user_id != $user_id) {
            return response()->json([
                'message' => "UnAuthorized"
            ], 403);
        }
        $profile = Profile::where('user_id', $id)->firstOrFail();
        $profile->update($request->validated());
        //$profile = Profile::findOrFail($id);
        return response()->json($profile, 200);
    }
}
