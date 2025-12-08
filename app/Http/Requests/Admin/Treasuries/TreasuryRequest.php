<?php

namespace App\Http\Requests\Admin\Treasuries;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TreasuryRequest extends FormRequest
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
        if ($this->method() == 'post') {
            return [
                'name' => ['required', 'string', 'max:255', 'unique:treasuries,name'],
                'is_master' => ['required', 'boolean'],
                'last_recipt_exchange' => ['required', 'integer', 'min:0'],
                'last_recipt_collect' => ['required', 'integer', 'min:0'],
                'added_by' => ['nullable', 'numeric', 'exists:admins,id'],
                'updated_by' => ['nullable', 'numeric', 'exists:admins,id'],
                'com_code' => ['nullable', 'numeric', 'exists:admins,com_code'],
                'active' => ['required', 'boolean'],
                'date' => ['nullable', 'date'],
            ];
        } elseif ($this->method() == 'put') {
            return [
                'name' => [
                    'sometimes', 
                    'required', 
                    'string', 
                    'max:255', 
                    Rule::unique('treasuries', 'name')->ignore($this->id)
                ],
                'is_master' => ['sometimes', 'required', 'boolean'],
                'last_recipt_exchange' => ['sometimes', 'required', 'integer', 'min:0'],
                'last_recipt_collect' => ['sometimes', 'required', 'integer', 'min:0'],
                'added_by' => ['nullable', 'required', 'numeric', 'exists:admins,id'],
                'updated_by' => ['nullable', 'required', 'numeric', 'exists:admins,id'],
                'com_code' => ['nullable', 'required', 'numeric', 'exists:admins,com_code'],
                'active' => ['sometimes', 'required', 'boolean'],
                'date' => ['nullable', 'required', 'date'],
            ];
        }
        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الصندوق مطلوب',
            'name.unique' => 'اسم الصندوق موجود مسبقا',
            'is_master.required' => 'حالة الخزنة الرئيسية مطلوبة',
            'is_master.boolean' => 'حالة الخزنة الرئيسية يجب ان تكون صحيحة',
            'last_recipt_exchange.required' => 'اخر ايصال صرف للصندوق مطلوب',
            'last_recipt_collect.required' => 'اخر ايصال تحصيل للصندوق مطلوب',
            'added_by.required' => 'مسؤول الصندوق مطلوب',
            'updated_by.required' => 'مسؤول التحديث مطلوب',
            'com_code.required' => 'كود شركة الصندوق',
            'active.required' => 'حالة الصندوق مطلوب',
            'active.boolean' => 'حالة الصندوق يجب ان تكون صحيحة',
            'date.required' => 'تاريخ الصندوق مطلوب',
        ];
    }
}