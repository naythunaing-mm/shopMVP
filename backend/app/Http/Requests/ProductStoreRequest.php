<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * User must have admin role
     * User must have at least one shop
     * User must have at least one category
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

        // Allow admin users to create products
        if ($user->hasRole('admin')) {
            return true;
        }

        // Allow shop owners with shops and categories
        return $user->hasRole('admin') && $user->shop && $user->shop->categories->count() > 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'pics' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video' => 'nullable|url',
            'types' => 'nullable|string',
            'colors' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ];

        // Admin users must specify shop_id
        if (auth()->user()->hasRole('admin')) {
            $rules['shop_id'] = 'required|exists:shops,id';
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Set discount to 0 if it's empty or null
        if (empty($this->discount)) {
            $this->merge([
                'discount' => 0
            ]);
        }
    }
}
