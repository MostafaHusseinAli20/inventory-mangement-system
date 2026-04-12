<?php

namespace App\Http\Requests\Admin\Accounts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
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
        $com_code = auth()->guard('admin')->user()->com_code;
        if($this->method() == 'POST') {
            return [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('accounts', 'name')
                        ->where('com_code', $com_code)
                ],
                'account_type_id' => [
                    'required',
                    'numeric',
                    Rule::exists('account_types', 'id')
                        ->where('com_code', $com_code)
                ],
                'account_number' => [
                    'required',
                    'numeric',
                    'max:255',
                    Rule::unique('accounts', 'account_number')
                        ->where('com_code', $com_code)
                ],
                'is_parent' => ['required', 'boolean'],
                'start_balance_status' => ['required', 'boolean'],
                'current_balance' => ['required', 'numeric'],
                'notes' => ['nullable', 'string', 'max:255'],
                'added_by' => ['nullable', 'string', 'exists:admins,id'],
                'active' => ['required', 'boolean'],
                'com_code' => ['nullable', 'numeric', 'exists:admins,com_code'],
            ];
        } elseif($this->method() == 'PUT') {
            return [];
        }
        return [];
    }
}
