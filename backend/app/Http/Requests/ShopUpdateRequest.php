<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();
        // Only admin with an existing shop can update
        return $user && $user->hasRole('admin') && $user->shop !== null;
    }

    public function rules(): array
    {
        return [
            'description' => 'nullable|string|max:255',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'social_links' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'postal_code' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ];
    }
}
