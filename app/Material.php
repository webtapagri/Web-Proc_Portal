<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'id', 
        'material_no', 
        'description', 
        'sector_industry', 
        'group_material', 
        'part_no', 
        'specification',
        'brand',
        'material_sap',
        'uom',
        'status',
        'created_at',
        'updated_at',
    ];
}