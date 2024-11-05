<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:8',
            'role' => 'required|in:admin,teacher,student',
            'provider' => 'nullable|string',
            'provider_id' => 'nullable|string',
            'avatar' => 'nullable|url',
        ];
    }
}
