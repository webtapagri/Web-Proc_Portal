<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmRole extends Model
{
    protected $table = 'tm_role';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'role_name',
        'role_active',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}