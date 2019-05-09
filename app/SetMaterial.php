<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetMaterial extends Model
{
    protected $table = 'tr_material';
    protected $guarded = ['id'];
    protected $hidden = array('id');
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'no_document',
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
        'div',
        'item_cat_group',
        'gross_weight',
        'net_weight',
        'volume',
        'size_dimension',
        'weight_unit',
        'volume_unit',
        'created_at',
        'update_at',
        'no_material',
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
        'locat',
    ];
}
