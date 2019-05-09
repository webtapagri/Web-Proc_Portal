<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'tr_role_user';
    protected $guarded = ['id'];
    protected $hidden = array('id');
    protected $primaryKey = 'ID_USER_ROLE';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'USER_ID',
        'USERNAME',
        'ROLE_ID',
        'USER_ROLE_ACTIVE',
        'CREATED_AT',
        'CREATED_BY',
        'UPDATED_AT',
        'UPDATED_BY',
    ];
}