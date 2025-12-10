<?php

namespace App\Http\Requests\Admin\Treasuries;

use Illuminate\Foundation\Http\FormRequest;

class TreasuryDeliveryRequest extends FormRequest
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
            'treasury_id' => ['required', 'numeric', 'exists:treasuries,id'],
            'treasury_can_delivery_id' => ['required', 'numeric', 'exists:treasuries,id'],
            'added_by' => ['nullable', 'numeric', 'exists:admins,id'],
            'updated_by' => ['nullable', 'numeric', 'exists:admins,id'],
            'com_code' => ['nullable', 'numeric', 'exists:admins,com_code'],
            'active' => ['nullable', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'treasury_id.required' => 'صندوق الدفع مطلوب',
            'treasury_id.numeric' => 'يجب ان يكون صندوق الدفع رقم',
            'treasury_id.exists' => 'يجب ان يكون صندوق الدفع موجود',
            'treasury_can_delivery_id.required' => 'صندوق التسليم مطلوب',
            'treasury_can_delivery_id.numeric' => 'يجب ان يكون صندوق التسليم رقم',
            'treasury_can_delivery_id.exists' => 'يجب ان يكون صندوق التسليم موجود',
        ];
    }
}
