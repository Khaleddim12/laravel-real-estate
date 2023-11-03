<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VendorRegisterRequest extends FormRequest
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
            "first_name" => "required|string|min:2|max:15",
            "last_name" => "required|string|min:2|max:15",
            "username" => "required|string|min:2|max:15|unique:users,username",
            'phone_number' => 'required|regex:/^[0-9]{10,}$/|unique:users,phone_number',
            "address" => "required|string|min:5",
            "password" => "required|min:6|confirmed",
            'profile_picture'=>'mimes:png,jpg,jpeg',
            'email' => 'required|email|unique:users,email',
        ];
    }
}
