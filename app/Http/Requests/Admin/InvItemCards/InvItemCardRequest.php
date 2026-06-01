<?php

namespace App\Http\Requests\Admin\InvItemCards;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvItemCardRequest extends FormRequest
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
        if($this->method() == 'post') {
            return [
                'name' => ['required', 'string', 'max:255'],
                'barcode' => [
                    Rule::unique('inv_item_cards', 'barcode')
                        ->where('com_code', $com_code)
                ],
                'item_code' => [
                    Rule::unique('inv_item_cards', 'item_code')
                        ->where('com_code', $com_code)
                ],
                'item_type' => ['required'],
                'inv_item_card_category_id' => [
                    'required',
                    'numeric',
                    'exists:inv_item_card_categories,id',
                ],
                'inv_uom_id' => [
                    'required',
                    'numeric',
                    'exists:inv_uoms,id',
                ],
                'does_has_retailunit' => [
                    'required',
                    'boolean',
                ],
                'inv_retail_uom_id' => [
                    'required_if:does_has_retailunit,1',
                    'numeric',
                    'exists:inv_uoms,id',
                ],
                'retail_uom_quntToParent' => [
                    'required_if:does_has_retailunit,1',
                    'numeric',
                ],
                'price_uom' => [
                    'required',
                    'numeric',
                ],
                'half_gomla_price_uom' => [
                    'required',
                    'numeric',
                ],
                'gomla_price_uom' => [
                    'required',
                    'numeric',
                ],
                'price_retail' => [
                    'required_with:inv_retail_uom_id',
                    'numeric',
                ],
                'half_gomla_price_retail' => [
                    'required_with:inv_retail_uom_id',
                    'numeric',
                ],
                'gomla_price_retail' => [
                    'required_with:inv_retail_uom_id',
                    'numeric',
                ],
                'cost_price' => [
                    'required',
                    'numeric',
                ],
                'cost_price_retail' => [
                    'required_with:inv_retail_uom_id',
                    'numeric',
                ],
                'has_fixed_price' => [
                    'required',
                    'boolean',
                ],
                'active' => [
                    'required',
                    'boolean',
                ],
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                'parent_inv_item_card_id' => [
                    'nullable',
                    'numeric',
                    'exists:inv_item_cards,id',
                    Rule::notIn([$this->route('id')])
                ]
            ];
        }
        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الصنف مطلوب',
            
            'item_type.required' => 'نوع الصنف مطلوب',
            
            'inv_item_card_category_id.required' => 'نوع الصنف مطلوب',
            'inv_item_card_category_id.numeric' => 'نوع الصنف يجب ان يكون رقم',
            'inv_item_card_category_id.exists' => 'نوع الصنف غير موجود',
            
            'inv_uom_id.required' => 'وحدة القياس مطلوبة',
            'inv_uom_id.numeric' => 'وحدة القياس يجب ان يكون رقم',
            'inv_uom_id.exists' => 'وحدة القياس غير موجودة',
            
            'does_has_retailunit.required' => 'هل يوجد وحدة تجزئة مطلوبة',
            
            'inv_retail_uom_id.required_if' => 'وحدة التجزئة مطلوبة',
            'inv_retail_uom_id.numeric' => 'وحدة التجزئة يجب ان يكون رقم',
            'inv_retail_uom_id.exists' => 'وحدة التجزئة غير موجودة',

            'retail_uom_quntToParent.required_if' => 'عدد وحدات التجزئة مطلوبة',
            'retail_uom_quntToParent.numeric' => 'عدد وحدات التجزئة يجب ان تكون رقم',

            'price_uom.required' => 'سعر القطاعي لوحدة الاساسية مطلوب',
            'price_uom.numeric' => 'سعر القطاعي لوحدة الاساسية يجب ان يكون رقم',

            'half_gomla_price_uom.required' => 'سعر النص جملة بوحدة الأب مطلوب',
            'half_gomla_price_uom.numeric' => 'سعر النص جملة بوحدة الأب يجب ان يكون رقم',

            'gomla_price_uom.required' => 'سعر الجملة بوحدة الأب مطلوب',
            'gomla_price_uom.numeric' => 'سعر الجملة بوحدة الأب يجب ان يكون رقم',

            'price_retail.required_with' => 'سعر القطاعي لوحدة التجزئة مطلوب',
            'price_retail.numeric' => 'سعر القطاعي لوحدة التجزئة يجب ان يكون رقم',

            'half_gomla_price_retail.required_with' => 'سعر النص جملة بوحدة التجزئة مطلوب',
            'half_gomla_price_retail.numeric' => 'سعر النص جملة بوحدة التجزئة يجب ان يكون رقم',

            'gomla_price_retail.required_with' => 'سعر الجملة بوحدة التجزئة مطلوب',
            'gomla_price_retail.numeric' => 'سعر الجملة بوحدة التجزئة يجب ان يكون رقم',

            'cost_price.required' => 'سعر التكلفة لوحدة الاب مطلوبة',
            'cost_price.numeric' => 'سعر التكلفة لوحدة الاب يجب ان يكون رقم',

            'cost_price_retail.required_with' => 'سعر التكلفة لوحدة التجزئة مطلوب',
            'cost_price_retail.numeric' => 'سعر التكلفة لوحدة التجزئة يجب ان تكون رقم',

            'has_fixed_price.required' => 'هل يوجد سعر ثابت مطلوب',
            'has_fixed_price.boolean' => 'هل يوجد سعر ثابت يجب ان يكون صحيح',

            'active.required' => 'حالة الصنف مطلوبة',
            'active.boolean' => 'حالة الصنف يجب ان تكون صحيحة',

            'image.mimes' => 'صورة الصنف يجب ان تكون صورة',
            'image.max' => 'صورة الصنف يجب ان تكون اقل من 2 ميغا',

            'parent_inv_item_card_id.numeric' => 'الصنف الاب يجب ان يكون رقم',
            'parent_inv_item_card_id.exists' => 'الصنف الاب يجب ان يكون موجود'
        ];
    }
}
