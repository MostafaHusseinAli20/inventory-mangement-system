<?php

namespace App\Http\Resources\Admin\InvItemCard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvItemCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'barcode' => $this->barcode,
            'item_type' => $this->item_type,
            'inv_item_card_category_id' => $this->inv_item_card_category_id,
            'parent_inv_item_card_id' => $this->parent_inv_item_card_id,
            'inv_uom_id' => $this->inv_uom_id,
            'inv_retail_uom_id' => $this->inv_retail_uom_id,
            'does_has_retailunit' => $this->does_has_retailunit,
            'retail_uom_quntToParent' => (float) $this->retail_uom_quntToParent,
            'price_uom' => (float) $this->price_uom,
            'half_gomla_price_uom' => (float) $this->half_gomla_price_uom,
            'gomla_price_uom' => (float) $this->gomla_price_uom,
            'price_retail' => (float) $this->price_retail,
            'half_gomla_price_retail' => (float) $this->half_gomla_price_retail,
            'gomla_price_retail' => (float) $this->gomla_price_retail,
            'cost_price' => (float) $this->cost_price,
            'cost_price_retail' => (float) $this->cost_price_retail,
            'has_fixed_price' => $this->has_fixed_price,
            'quantity' => $this->quantity,
            'quantity_retail' => $this->quantity_retail,
            'quantity_all_retails' => $this->quantity_all_retails,
            'active' => $this->active,
            'image' => $this->image ? asset('uploads/' . $this->image) : null,
            'uom_name' => $this->inv_uom_id ? $this->uom->name : null,
            'retail_uom_name' => $this->inv_retail_uom_id ? $this->retail_uom->name : null,
            'item_code' => $this->item_code,
            'parent_inv_name' => $this->parent_inv_item_card_id ? $this->parentItemCard->name : null,
            'category_name' => $this->inv_item_card_category_id ? $this->category->name : null,
        ];
    }
}
