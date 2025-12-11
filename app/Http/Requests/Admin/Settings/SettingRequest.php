<?php

namespace App\Http\Requests\Admin\Settings;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
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
        $setting = Setting::where('com_code', auth()->guard('admin')->user()->com_code)->first();

        return [
            'system_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:png,jpg,svg', 'max:2048'],
            'address' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'regex:/^(010|011|012|015)[0-9]{8}$/'],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('settings', 'email')->ignore($setting->id)
            ],
            'added_by' => ['sometimes', 'required', 'numeric', 'exists:admins,id'],
            'updated_by' => ['sometimes', 'required', 'numeric', 'exists:admins,id'],
            'com_code' => ['sometimes', 'required', 'numeric', 'exists:admins,com_code'],
            'active' => ['sometimes', 'required', 'boolean'],
            'general_alert' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'system_name.required' => 'اسم الشركة مطلوب',
            'logo.image' => 'لوجو الشركة يجب ان تكون صورة من الانواع jpeg, png, jpg',
            'logo.mimes' => 'لوجو الشركة يجب أن تكون من نوع: jpeg, png, jpg فقط.',
            'logo.max' => 'لوجو الشركة يجب ان تكون اقل من 2 ميغابايت',
            'address.required' => 'عنوان الشركة مطلوب',
            'phone.required' => 'رقم الهاتف مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.email' => 'البريد الالكتروني غير صحيح',
            'email.unique' => 'البريد الالكتروني موجود بالفعل',
            'phone.numeric' => 'رقم الهاتف يجب ان يكون رقم',
            'added_by.required' => 'مسؤول الشركة مطلوب',
            'updated_by.required' => 'مسؤول التحديث مطلوب',
            'com_code.required' => 'كود الشركة مطلوب',
            'general_alert.required' => 'تنبيه عام مطلوب',
            'active.required' => 'حالة الشركة مطلوب',
            'active.boolean' => 'حالة الشركة يجب ان تكون صحيحة',
            'phone.regex' => 'رقم الهاتف غير صحيح',
        ];
    }
}
