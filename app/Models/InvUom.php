<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvUom extends Model
{
    protected $table = 'inv_uoms';
    protected $fillable = [
        'name',
        'is_master',
        'added_by',
        'updated_by',
        'com_code',
        'active',
    ];
}
