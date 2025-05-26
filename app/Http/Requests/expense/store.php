<?php

namespace App\Http\Requests\expense;

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
        return [
            'name'        => 'required|string',
            'amount'      => 'required|numeric',
            'method'      => 'required|string',
            'date'        => 'required|date',
            'notes'       => 'nullable|string',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:expense_categories,id',
        ];
    }
}
