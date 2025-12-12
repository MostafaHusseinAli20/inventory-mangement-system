<?php

namespace App\Http\Requests\Admin\InvUoms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvUomRequest extends FormRequest
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
        if ($this->method() == 'POST') {
            return [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('inv_uoms', 'name')
                        ->where('com_code', auth()->guard('admin')->user()->com_code)
                ],
                'is_master' => ['required', 'boolean'],
                'com_code' => ['nullable', 'numeric', 'exists:admins,com_code'],
                'active' => ['required', 'boolean'],
            ];
        } else if ($this->method() == 'PUT') {
            return [
                'name' => ['sometimes', 'required', 'string', 'max:255', 
                Rule::unique('inv_uoms', 'name')
                ->where('com_code', auth()->guard('admin')->user()->com_code)
                ->ignore($this->id)
            ],
                'is_master' => ['sometimes', 'required', 'boolean'],
                'com_code' => ['nullable', 'numeric', 'exists:admins,com_code'],
                'active' => ['required', 'boolean'],
            ];
        }
        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.unique' => 'الاسم موجود مسبقا',
            'is_master.required' => 'نوع الوحدة مطلوبة',
            'active.required' => 'حالة الوحدة مطلوبة',
            'active.boolean' => 'حالة الوحدة يجب ان تكون صحيحة',
        ];
    }
}