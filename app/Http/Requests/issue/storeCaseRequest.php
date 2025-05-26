<?php

namespace App\Http\Requests\issue;

use Illuminate\Foundation\Http\FormRequest;

class storeCaseRequest extends FormRequest
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
        'opponent_name'    => 'required|string',
        'opponent_type'    => 'required|string',
        'opponent_phone'   => 'required|string',
        'opponent_nation'  => 'required|string',
        'opponent_address' => 'nullable|string',
        'opponent_lawyer'  => 'required|string',
        'lawyer_phone'     => 'required|string',
        'court_name'       => 'required|string',
        'circle'           => 'required|string',
        'judge_name'       => 'required|string',
        'case_number'      => 'required|string',
        'attorney_number'  => 'required|string',
        'register_date'    => 'required|date',
        'case_title'       => 'nullable|string',
        'contract_price'   => 'required|integer',
        'notes'            => 'nullable|string',
        'case_category_id' => 'required|exists:case_categories,id',
    ];
    }
}
