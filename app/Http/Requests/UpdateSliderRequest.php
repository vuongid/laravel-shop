<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest  extends FormRequest
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
            'title' => 'required|between:5,255',
            'url'  => 'required',
            'image'  => 'image',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Tên không được rỗng',
            'title.between'  => 'Tên có độ dài từ :min đến :max ký tự',
            'url.required'   => 'URL không được rỗng',
            'image.image'    => 'Ảnh đuôi file không phù hợp',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
}
