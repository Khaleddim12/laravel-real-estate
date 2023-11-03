<?php

namespace App\Http\Requests\Estate;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "address" => "required|string|min:5",
            "price" => "required|numeric",
            "available" => "required|boolean",
            "estate_image" => "required|mimes:png,jpg,jpeg"
        ];
    }
}
