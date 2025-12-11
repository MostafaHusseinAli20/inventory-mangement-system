<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'stores';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'added_by',
        'updated_by',
        'com_code',
        'date',
        'active',
    ];
}
