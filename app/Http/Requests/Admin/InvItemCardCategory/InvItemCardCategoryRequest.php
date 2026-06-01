<?php

namespace App\Http\Requests\Admin\InvItemCardCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvItemCardCategoryRequest extends FormRequest
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
                    Rule::unique('inv_item_card_categories', 'name')
                        ->where('com_code', auth()->guard('admin')->user()->com_code)
                ],

                'active' => ['required', 'boolean'],
            ];
        } else if ($this->method() == 'PUT') {
            return [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('inv_item_card_categories', 'name')
                        ->where('com_code', auth()->guard('admin')->user()->com_code)
                        ->ignore($this->id)
                ],

                'active' => ['required', 'boolean'],
            ];
        }

        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الصنف مطلوب',
            'name.unique' => 'اسم الصنف موجود مسبقا',
            'active.required' => 'حالة تفعيل الصنف مطلوبة',
            'active.boolean' => 'حالة تفعيل الصنف يجب ان تكون صحيحة',
        ];
    }
}
