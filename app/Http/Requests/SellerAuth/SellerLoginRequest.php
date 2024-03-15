<?php

namespace App\Http\Requests\SellerAuth;

use App\Http\Requests\LoginRequest;
use App\Models\Seller;
use Illuminate\Foundation\Http\FormRequest;

class SellerLoginRequest extends LoginRequest
{
    protected function guardProviderModelClass(): string
    {
        return Seller::class;
    }
}
