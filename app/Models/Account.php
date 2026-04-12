<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;
    protected $table = 'accounts';
    protected $fillable = [
        'name',
        'account_type_id',
        'is_parent',
        'parent_account_number',
        'account_number',
        'start_balance_status',
        'start_balance',
        'current_balance',
        'date',
        'other_table_FK',
        'notes',
        'added_by',
        'updated_by',
        'com_code',
        'active',
    ];

    public function account_type()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    public function parent_account()
    {
        return $this->belongsTo(Account::class, 'parent_account_number');
    }

    public function added_by()
    {
        return $this->belongsTo(Admin::class, 'added_by');
    }

    public function updated_by()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
