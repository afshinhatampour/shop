<?php

namespace App\Http\Requests\Api\V1\Manage\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'required|string|max:32|confirmed',
            'name'     => 'required|string|max:255',
            'mobile'   => 'required|string|max:32|unique:users,mobile',
            'email'    => 'required|string|email|unique:users,email'
        ];
    }
}
