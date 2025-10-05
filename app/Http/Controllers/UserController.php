<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password) //تشفير كلمة السر قبل تخزينها في قاعدة البيانات
        ]);
        Mail::to($user->email)->send(new WelcomeMail($user));
        return response()->json(
            [
                'message' => "User created successfully",
                'user' => $user
            ],
            201
        );
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        //ضمن الشرط نختار الأوث ذي المسار التالي :use Illuminate\Support\Facades\Auth
        if (!Auth::attempt($request->only('email', 'password'))) //التحقق من وجود إيميل و كلمة سر بقاعدة البيانات مطابقة لما تم إدخاله
        { //في حال لم يجد ايميل و كلمة سر مطابقة ينفذ التالي
            return response()->json([
                'message' => "invalid email or password"
            ], 401);
        };
        $user = User::where('email', $request->email)->FirstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken; //مابين قوسين اسم التوكن و يمكن تسميتها أي أسم
        return response()->json([
            'message' => 'Login Successfull',
            'user' => $user,
            'Token' => $token
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout Successfull',
        ], 200);
    }






    public function getProfile($id)
    {
        $profile = User::find($id)->profile; //البروفايل أسم التابع المحوط بقلب اليوزر موديل
        return response()->json($profile, 200);
    }
    public function getUserTasks($id)
    {
        $tasks = User::findOrFail($id)->tasks; //التاسكس أسم التابع المحوط بقلب اليوزر موديل
        if ($tasks->isEmpty()) {
            return response()->json([

                'message' => "No Tasks for this user",
            ], 404);
        } else {
            return response()->json($tasks, 200);
        }
    }
    public function getUser()
    {
        $user_id = Auth::user()->id;
        $userData = User::with('profile')->findOrFail($user_id); //with('Name of function that shows relation between user and profile')
        return new UserResource($userData);
    }
    public function getAllUsers()
    {
        $usersData = User::with('profile')->get();
        return UserResource::collection($usersData);
    }
}
