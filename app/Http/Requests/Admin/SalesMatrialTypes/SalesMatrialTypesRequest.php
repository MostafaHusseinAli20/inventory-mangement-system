<?php

namespace App\Http\Requests\Admin\SalesMatrialTypes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalesMatrialTypesRequest extends FormRequest
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
        if($this->isMethod('post')) {
            return [
                'name' => ['required', 'string', 'max:255', 'unique:sales_matrial_types,name'],
                'active' => ['nullable', 'boolean'],
                'com_code' => ['nullable', 'numeric', 'exists:admins,com_code'],
            ];
        } elseif($this->isMethod('put')) {
            return [
                'name' => ['required', 'string', 'max:255', Rule::unique('sales_matrial_types', 'name')->ignore($this->id)],
                'active' => ['nullable', 'boolean'],
                'com_code' => ['nullable', 'numeric', 'exists:admins,com_code'],
            ];
        }
        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'يرجي ادخال الاسم',
            'name.string' => 'يرجي ادخال الاسم بشكل صحيح',
            'name.max' => 'يرجي ادخال الاسم بشكل صحيح',
            'name.unique' => 'الاسم موجود مسبقا',
        ];
    }
}
