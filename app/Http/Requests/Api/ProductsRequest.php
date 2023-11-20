<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
       $Rules = [
            'name' => 'required|string',
            'price' => 'required|numeric',
           'discount' => 'nullable|numeric',
            'description' => 'required|string',
            'image' => 'required|array|min:3|max:3',
           'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           'status' => 'required|in:available,unavailable',
            'market_id' => 'required|exists:users,id',


        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])){
            $Rules['name'] = 'nullable|string';
            $Rules['price'] = 'nullable|numeric';
            $Rules['discount'] = 'nullable|numeric';
            $Rules['description'] = 'nullable|string';
            $Rules['status'] = 'nullable|in:available,unavailable';
            $Rules['market_id'] = 'nullable|exists:users,id';
            $Rules['images'] = 'nullable|array|min:3|max:3';
            $Rules['images.*'] ='image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }


        return $Rules ;
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response= response()->apiError($validator->errors()->first(), 1, 422);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
