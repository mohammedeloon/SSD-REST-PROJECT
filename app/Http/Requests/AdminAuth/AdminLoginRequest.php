<?php

namespace App\Http\Requests\AdminAuth;

use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends LoginRequest
{
    protected function guardProviderModelClass(): string
    {
        return Admin::class;
    }
}
