<?php

namespace App\Http\Requests\attachment;

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
            'file'  => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:2048',
            'title' => 'required|string|max:255',
        ];
    }
}
