<?php

namespace App\Http\Requests\expense;

use Illuminate\Foundation\Http\FormRequest;

class update extends FormRequest
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
            'name'        => 'nullable|string',
            'amount'      => 'nullable|numeric',
            'method'      => 'nullable|string',
            'date'        => 'nullable|date',
            'note'        => 'nullable|string',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:expense_categories,id',
        ];
    }
}
