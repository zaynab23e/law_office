<?php

namespace App\Http\Requests\issue;

use Illuminate\Foundation\Http\FormRequest;

class updateCaseRequest extends FormRequest
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
            'opponent_name'    => 'nullable|string',
            'opponent_type'    => 'nullable|string',
            'opponent_phone'   => 'nullable|string',
            'opponent_nation'  => 'nullable|string',
            'opponent_address' => 'nullable|string',
            'opponent_lawyer'  => 'nullable|string',
            'lawyer_phone'     => 'nullable|string',
            'court_name'       => 'nullable|string',
            'circle'           => 'nullable|string',
            'judge_name'       => 'nullable|string',
            'case_number'      => 'nullable|string',
            'attorney_number'  => 'nullable|string',
            'register_date'    => 'nullable | date',
            'case_title'       => 'nullable|string',
            'contract_price'   => 'nullable|integer',
            'notes'            => 'nullable|string',
            'case_category_id' => 'nullable|exists:case_categories,id',
        ];
    }
}
