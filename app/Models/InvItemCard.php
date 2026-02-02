<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvItemCard extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'inv_item_cards';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(InvItemCardCategory::class, 'inv_item_card_category_id');
    }

    public function uom()
    {
        return $this->belongsTo(InvUom::class, 'inv_uom_id')->where('is_master', 1);
    }

    public function retail_uom()
    {
        return $this->belongsTo(InvUom::class, 'inv_retail_uom_id')->where('is_master', 0);
    }

    public function parentItemCard()
    {
        return $this->belongsTo(InvItemCard::class, 'parent_inv_item_card_id');
    }
}