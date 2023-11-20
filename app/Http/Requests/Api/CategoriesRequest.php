<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
        $rules = [
           'name'=>'required|string|min:3|max:255|unique:categories,name',
              'img_category'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if(in_array($this->method(), ['PUT', 'PATCH'])){


            $rules['name'] = ['nullable', 'string', 'max:20','min:3','unique:categories,name,'.$this->category];
            $rules['img_category'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
        }
        return $rules;

    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response= response()->apiError($validator->errors()->first(), 1, 422);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
