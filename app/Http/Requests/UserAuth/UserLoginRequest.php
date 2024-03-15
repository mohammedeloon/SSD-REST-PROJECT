<?php

namespace App\Http\Requests\UserAuth;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends LoginRequest
{
    protected function guardProviderModelClass(): string
    {
        return User::class;
    }
}
