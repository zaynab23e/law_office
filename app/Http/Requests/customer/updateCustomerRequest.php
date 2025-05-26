<?php

namespace App\Http\Requests\customer;

use Illuminate\Foundation\Http\FormRequest;

class updateCustomerRequest extends FormRequest
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
            'name'                 => 'nullable|string',
            'email'                => 'nullable|email|unique:customers,email',
            'phone'                => 'nullable|string',
            'address'              => 'nullable|string',
            'ID_number'            => 'nullable|string',
            'nationality'          => 'nullable|string',
            'company_name'         => 'nullable|string',
            'notes'                => 'nullable|string',
            'customer_category_id' => 'nullable|exists:customer_categories,id'

        ];
    }
}
