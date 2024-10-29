<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'telephone' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:255',
            'password_confirmation' => 'required|string|min:8|confirmed',
        ];
    }
}
