<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'system_name',
        'logo',
        'favicon',
        'address',
        'phone',
        'email',
        'added_by',
        'updated_by',
        'com_code',
        'general_alert'
    ];
}
