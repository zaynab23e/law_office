<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class storeUserRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'phone'       => 'required|string|max:13',
            'email'       => 'required|email|unique:users,email',
            'image'       => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'password'    => 'required|string|min:8',
            'card_number' => 'required|numeric|unique:users,card_number',

        ];
    }
}
