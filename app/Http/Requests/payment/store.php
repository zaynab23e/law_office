<?php

namespace App\Http\Requests\payment;

use Illuminate\Foundation\Http\FormRequest;

class store extends FormRequest
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
        return 
        [
            'title'  => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date'   => 'required|date',
            'method' => 'nullable|string|max:255',       
        ];
    }
}
