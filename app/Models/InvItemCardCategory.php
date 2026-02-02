<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvItemCardCategory extends Model
{
    protected $table = 'inv_item_card_categories';
    protected $fillable = [
        'name',
        'added_by',
        'updated_by',
        'com_code',
        'active',
    ];
}
