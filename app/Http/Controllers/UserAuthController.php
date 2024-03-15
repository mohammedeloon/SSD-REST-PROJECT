<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuth\UserLoginRequest;
use App\Http\Requests\UserAuth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registered Successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
        ], 201);
    }

    public function login(UserLoginRequest $request)
    {
        $user = $request->authenticate();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in Successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out Successfully'], 200);
    }
}
