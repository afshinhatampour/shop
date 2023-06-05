<?php

namespace App\Http\Requests\Api\V1\Manage\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name'     => 'string|required|max:256',
            'email'    => 'string|required|email|max:256',
            'mobile'   => 'string|required',
            'password' => 'string|required'
        ];
    }
}
