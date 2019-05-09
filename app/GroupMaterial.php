<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMaterial extends Model
{
    protected $fillable = [
        'id','name', 'description'
    ];
}
