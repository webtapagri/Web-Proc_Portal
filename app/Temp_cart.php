<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp_cart extends Model
{
	protected $table = 'temp_cart';
    protected $fillable = array(
    	'id',
    	'username',
    	'no_material',
    	'material_name',
    	'quantity',
    	'harga_satuan',
    	'supplier_code',
    	'supplier_name'
   	);
	//protected $primaryKey = 'no_material'; //JIKA TIDAK ADA ID
    protected $hidden = ['updated_at','created_at'];
}
