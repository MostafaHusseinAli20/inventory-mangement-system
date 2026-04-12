<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    protected $table = 'account_types';
    protected $fillable = [
        'name',
        'date',
        'last_update',
        'added_by',
        'updated_by',
        'active',
        'com_code',
        'relatediternalaccounts',
    ];
}
