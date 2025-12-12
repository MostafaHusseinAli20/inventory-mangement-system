<?php

namespace App\Http\Requests\Admin\Stores;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
                'name' => ['required', 'string', 'max:255', 
                Rule::unique('stores', 'name')
                    ->where('com_code', auth()->guard('admin')->user()->com_code)
            ],
                'active' => ['required', 'boolean'],
                'com_code' => ['nullable', 'numeric', 'exists:admins,com_code'],
                'address' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'numeric', 'regex:/^(010|011|012|015)[0-9]{8}$/'],
            ];
        } elseif($this->isMethod('put')) {
            return [
                'name' => ['required', 'string', 'max:255', 
                Rule::unique('stores', 'name')
                ->where('com_code', auth()->guard('admin')->user()->com_code)
                ->ignore($this->id)
            ],
                'active' => ['nullable', 'boolean'],
                'com_code' => ['nullable', 'numeric', 'exists:admins,com_code'],
                'address' => ['nullable', 'string', 'max:255'],
                'phone' => ['nullable', 'numeric', 'regex:/^(010|011|012|015)[0-9]{8}$/'],
            ];
        }
        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'يرجى ادخال اسم المخزن',
            'name.unique' => 'اسم المخزن موجود مسبقا',
            'active.boolean' => 'حقل الحالة يجب ان يكون اما true او false',
            'com_code.numeric' => 'حقل الشركة يجب ان يكون رقم',
            'com_code.exists' => 'حقل الشركة غير موجود',
            'address.string' => 'حقل العنوان يجب ان يكون نص',
            'address.max' => 'حقل العنوان يجب ان يكون اقل من 255 حرف',
            'phone.required' => 'يرجى ادخال رقم الهاتف',
            'address.required' => 'يرجى ادخال العنوان',
            'active.required' => 'يرجى ادخال حالة المخزن',
            'name.string' => 'حقل الاسم يجب ان يكون نص',
            'name.max' => 'حقل الاسم يجب ان يكون اقل من 255 حرف',
            'phone.numeric' => 'حقل الهاتف يجب ان يكون رقم',
            'phone.regex' => 'حقل الهاتف غير صحيح',
        ];
    }
}