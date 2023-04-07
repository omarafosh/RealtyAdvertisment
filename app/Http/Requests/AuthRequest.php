<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "name"     =>"required",
            "email"    =>"required|string|email|unique:users",
            "password" =>"required|string|confirmed|min:8",
            "password_confirmation" => "required|string|min:8",
        ];
    }
    public function messages()
    {
        return [
            "name.required" =>"Please The Field Required",
            "email.required" =>"Please The Field Required",
            "email.unique" =>"Please The Email is Exists",
            "email.email" =>"Please The Email is Wronge",
            "password.required" =>"Please The Email is Wronge",
            "password.confirmed" =>"Please The Confirm Password is Wronge",
            "password.min" =>"Please The Password is Most Great Than 8 Charecters",
        ];
    }
}
