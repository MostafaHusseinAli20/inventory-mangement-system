<?php

namespace App\Http\Resources\Admin\Accounts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowAccountResource extends JsonResource
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
            'account_type_id' => $this->account_type_id,
            'is_parent' => $this->is_parent,
            'account_number' => $this->account_number,
            'start_balance_status' => $this->start_balance_status,
            'start_balance' => $this->start_balance,
            'current_balance' => $this->current_balance,
            'notes' => $this->notes,
            'updated_by' => $this->updated_by,
            'com_code' => $this->com_code,
            'active' => $this->active,

            'account_type' => [
                'id' => $this->account_type?->id,
                'name' => $this->account_type?->name,
                'relatediternalaccounts' => $this->account_type?->relatediternalaccounts
            ],

            'parent_account_number' => $this->parent_account_number,
        ];
    }
}
