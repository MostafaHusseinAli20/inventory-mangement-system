<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreasuryDelivery extends Model
{
    protected $fillable = [
        'treasury_id',
        'treasury_can_delivery_id',
        'added_by',
        'updated_by',
        'com_code',
        'active',
    ];
}
