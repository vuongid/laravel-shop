<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleCategoryRequest  extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|between:5,255',
            'slug'  => [
                'nullable',
                'regex:/^[a-zA-Z0-9-]+$/',
                Rule::unique('article_categories', 'slug')->ignore($this->route('articleCategory')),

            ],
            'status' => 'required',
            'parent_id' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
}
