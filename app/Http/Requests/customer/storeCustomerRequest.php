<?php

namespace App\Http\Requests\customer;

use Illuminate\Foundation\Http\FormRequest;

class storeCustomerRequest extends FormRequest
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
            'name'                 => 'required|string',
            'email'                => 'required|email|unique:customers,email',
            'phone'                => 'required|string',
            'address'              => 'required|string',
            'ID_number'            => 'required|string',
            'nationality'          => 'required|string',
            'company_name'         => 'nullable|string',
            'notes'                => 'nullable|string',
            'customer_category_id' => 'required|exists:customer_categories,id'
        ];
    }
}
