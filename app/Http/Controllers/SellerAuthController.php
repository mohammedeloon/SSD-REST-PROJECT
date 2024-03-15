<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerAuth\SellerLoginRequest;
use App\Http\Requests\SellerAuth\SellerRegisterRequest;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerAuthController extends Controller
{
    public function register(SellerRegisterRequest $request){

        $user = Seller::create($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registered successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
        ], 201);
    }

    public function login(SellerLoginRequest $request){

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