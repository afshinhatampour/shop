<?php

namespace App\Http\Requests\Api\V1\Manage\Product;

use App\Enums\ProductEnums;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'title'   => 'required|string|max:512',
            'content' => 'required|string|max:2048',
            'status'  => 'required|string|in:' . implode(',', array_values(ProductEnums::STATUS))
        ];
    }
}
