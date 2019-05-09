<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrUser extends Model
{
    protected $table = 'tr_user';
    protected $guarded = ['id'];
    protected $hidden = array('id');
    protected $primaryKey = 'USER_ID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'USER_ID',
        'USERNAME',
        'NAMA',
        'EMAIL',
        'JOB_CODE',
        'NIK',
        'AREA_CODE',
        'FL_ACTIVE',
        'CREATED_AT',
        'UPDATED_AT',
    ];
}