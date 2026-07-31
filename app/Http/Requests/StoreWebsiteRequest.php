<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWebsiteRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
             'name' => 'required|string|max:255',
             'slug' => 'required|string|max:255|unique:websites,slug',
             'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
             'favicon' => 'nullable|image|mimes:jpg,jpeg,png,ico|max:512',
             'language' => 'required|string|max:10',
             'theme' => 'nullable|string|max:100',
             'domain' => 'nullable|string|max:255',
             'status' => 'nullable|boolean',
        ];
    }
}
