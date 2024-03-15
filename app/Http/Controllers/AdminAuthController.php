<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminAuth\AdminLoginRequest;
use App\Http\Requests\AdminAuth\AdminRegisterRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function register(AdminRegisterRequest $request){

        $user = Admin::create($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registered successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
        ], 201);
    }

    public function login(AdminLoginRequest $request){

        $user = $request->authenticate();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
            ]);
    }

    public function logout(Request $request){
       $request->user()->currentAccessToken()->delete();
       return response(['message' => 'Logged out']);
    }

}

