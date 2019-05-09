<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tm_material extends Model
{
	protected $table = 'tm_material';
    protected $fillable = array(
    	'no_material',
    	'industri_sector',
    	'plant',
    	'store_loc',
    	'sales_org',
    	'dist_channel',
    	'mat_group',
    	'part_number',
    	'spec',
    	'merk',
    	'material_name',
    	'uom',
    	'division',
    	'item_cat_group',
    	'gross_weight',
    	'net_weight',
    	'volume',
    	'size_dimension',
    	'weight_unit',
        'volume_unit',
		'locat',
		'mrp_controller',
		'valuation_class',
		'tax_classification',
		'account_assign',
		'general_item',
		'avail_check',
		'transportation_group',
		'loading_group',
		'profit_center',
		'mrp_type',
		'period_sle',
		'cash_discount',
		'price_unit',
		'created_at',
		'update_at',
		'description',
		'material_type',
		'remarks',
		'created_by',
		'updated_by',
		'price_estimate',
		'supplier_code',
		'supplier_name'
   	);
	protected $primaryKey = 'no_material'; //JIKA TIDAK ADA ID
    //protected $hidden = ['updated_at','created_at'];
}
