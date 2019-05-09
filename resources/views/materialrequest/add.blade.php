@extends('adminlte::page')

@section('title', 'FMDB - Material Request')

@section('content')
<style>
label {
    font-weight: 500;
}
.select-img:hover {
    opacity: 0.5
}
.select2-selection .select2-selection--single > .select2-default { 
    background-color: #00f !important; 
}
</style>
<section class="content">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-plus"></i> Material Request</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                            <div class="">
            <ul class="nav nav-tabs">
            <li class="active"><a href="#panel-initial" class="panel-initial">INITIAL</a></li>
            <li><a href="#panel-basic-data" class="panel-basic-data" disabled>MATERIAL INFORMATION</a></li>
            </ul>
            <div class="tab-content">
            <!-- Font Awesome Icons -->
                <div class="tab-pane active" id="panel-initial">
                    <form id="form-initial"  class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="sap_material_group" class="col-md-3">Material Group</label>
                                <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="sap_material_group" id="sap_material_group" required>
                                        
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label for="plant" class="col-md-3">Plant</label>
                                    <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="plant" id="plant" maxlength="4" required>

                                    </select>
                                </div>    
                            </div>
                            
                            <div class="form-group">
                                <label for="location" class="col-md-3">Location</label>
                                <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="location" id="location"  maxlength="10" required>
                                        
                                    </select>
                                </div>
                            </div>  
                          
                            <div class="form-group">
                                <label for="mrp_controller" class="col-md-3">MRP Controller</label>
                                <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="mrp_controller" id="mrp_controller"  maxlength="3"  required>
                                        
                                    </select>
                                </div>
                            </div>  
                            
                            <div class="form-group">
                                <label for="valuation_class" class="col-md-3">Valuation Class</label>
                                <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="valuation_class"  maxlength="10"  id="valuation_class" required>
                                        
                                    </select>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="sector_industry" class="col-md-3">Industri sector</label>
                                    <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="industry_sector" id="industry_sector" maxlength="20" required >
                                        
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="material_type" class="col-md-3">Material Type</label>
                                <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="material_type" id="material_type"  maxlength="10"  required>
                                        
                                    </select>
                                </div>
                            </div> 
                           
                            <div class="form-group">
                                <label for="store_location" class="col-md-3">Store Location</label>
                                    <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="store_location" id="store_location"  maxlength="4" required>
                                    </select>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label for="sales_org" class="col-md-3">Sales Org</label>
                                <div class="col-md-9"> 
                                    <select type="text" class="form-control input-sm" name="sales_org" id="sales_org"  maxlength="4" required>
                                    </select>
                                </div>
                            </div>  
                            
                            <div class="form-group">
                                <label for="dist_channel" class="col-md-3">Distribution Channel</label>
                                <div class="col-md-9"> 
                                    <select type="text" class="form-control input-sm select2-default" name="dist_channel" id="dist_channel"  maxlength="4" required>
                                        
                                    </select>
                                </div>
                            </div>    
                           
                            <div class="form-group">
                                <label for="division" class="col-md-3">Division</label>
                                    <div class="col-md-9"> 
                                    <select type="text" class="form-control input-sm" name="division" id="division"  maxlength="30" required>
                                        
                                    </select>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="general_item_category_group" class="col-md-3">General Item Category Group</label>
                                <div class="col-md-9"> 
                                    <select type="text" class="form-control input-sm" name="general_item_category_group" id="general_item_category_group" maxlength="4" required>
                                        
                                    </select>
                                </div>
                            </div>   
                            <div class="form-group">
                                <label for="cash_discount" class="col-md-3">Cash Discount</label>
                                <div class="col-md-9"> 
                                    <select type="text" class="form-control input-sm" name="cash_discount" id="cash_discount"  maxlength="1"  required></select>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="tax_classification" class="col-md-3">Tax Classification</label>
                                <div class="col-md-9"> 
                                    <select type="text" class="form-control input-sm" name="tax_classification" id="tax_classification" maxlength="1" required>
                                        
                                    </select>
                                </div>
                            </div>    
                            <div class="form-group">
                                    <label for="account_assign" class="col-md-3">Account Assignment Group</label>
                                    <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="account_assign" id="account_assign" maxlength="2" required>
                                        
                                    </select>
                                </div>
                            </div>   
                            <div class="form-group">
                                <label for="item_category_group" class="col-md-3">Item Category Group</label>
                                <div class="col-md-9"> 
                                    <select type="text" class="form-control input-sm" name="item_category_group" id="item_category_group" maxlength="30" required>
                                        
                                    </select>
                                </div>
                            </div>     
                            <div class="form-group">
                                <label for="availability_check" class="col-md-3">Availability Check</label>
                                <div class="col-md-9"> 
                                    <select type="text" class="form-control input-sm" name="availability_check" id="availability_check" maxlength="2" required>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="transportation_group" class="col-md-3">Transportation Group</label>
                                <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="transportation_group" maxlength="4" id="transportation_group" required>
                                        
                                    </select>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="loading_group" class="col-md-3">Loading Group</label>
                                <div class="col-md-9"> 
                                    <select type="text" class="form-control input-sm" name="loading_group" id="loading_group" maxlength="4" required>
                                        
                                    </select>
                                </div>
                            </div>            
                            <div class="form-group">
                                <label for="profit_center" class="col-md-3">Profit Center</label>
                                    <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="profit_center" id="profit_center" maxlength="4"  required>
                                        
                                    </select>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="mrp_type" class="col-md-3">MRP Type</label>
                                    <div class="col-md-9"> 
                                    <select type="text" class="form-control input-sm" name="mrp_type" id="mrp_type" maxlength="4"  required>
                                        
                                    </select>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="period_ind_for_sle" class="col-md-3">Period Ind. for SLE</label>
                                <div class="col-md-9">
                                    <select type="text" class="form-control input-sm" name="period_ind_for_sle" maxlength="10" id="period_ind_for_sle" style="background-color: #e8e8e8;" required>
                                    </select>
                                </div>
                            </div>  
                            <div class="form-group">
                                    <label for="price_unit" class="col-md-3">Price Unit</label>
                                    <div class="col-md-4"> 
                                    <input type="number" class="form-control input-sm" name="price_unit" id="price_unit" value="1" required>
                                </div>
                            </div>   
                        </div>
                        <div class="box-footer clearfix">
                            <button type="button" class="btn btn-default btn-flat hide pull-right" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-flat pull-right" style="margin-right: 5px;">Next</button>
                            <button type="button" class="btn btn-danger btn-flat btn-cancel pull-right" style="margin-right: 5px;">Cancel</button>
                        </div> 
                    </form>
                    
                </div>
                <!-- /#fa-icons -->

                <!-- glyphicons-->
                <div class="tab-pane" id="panel-basic-data">
                        <form id="form-basic-data" enctype="multipart/form-data" class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                        <label for="group_material" class="col-md-3">Group Material</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control input-sm" name="group_material" id="group_material" readonly>
                                        <input type="hidden" name="group_material_id" id="group_material_id" readonly>
                                        <span class="input-group-btn hide">
                                            <button type="button" class="btn btn-default btn-flat btn-group-material"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>    
                                <div class="form-group material-group-input" id="input-description">  
                                    
                                    <label for="part_no" class="col-md-3">Description</label>
                                    <div class="col-md-9">  
                                        <input type="text" class="form-control input-sm attr-material-group" name="description" id="description" autocomplete="off">
                                    </div>
                                </div>   
                                <div class="form-group material-group-input" id="input-part-no">
                                    <label for="part_no" class="col-md-3">Part Number</label>
                                        <div class="col-md-9"> 
                                        <input type="text" class="form-control input-sm attr-material-group" name="part_no" id="part_no"  autocomplete="off">
                                    </div>
                                </div> 
                                <div class="form-group material-group-input" id="input-specification">
                                    <label for="part_no" class="col-md-3 col-form-label">Spesifikasi</label>
                                    <div class="col-md-9"> 
                                        <input type="text" class="form-control input-sm attr-material-group" name="specification"  id="specification" >
                                    </div>
                                </div> 
                                <div class="form-group material-group-input" id="input-merk">
                                        <label for="brand" class="col-md-3">Merk</label>
                                            <div class="col-md-4">    
                                        <input type="text" class="form-control input-sm attr-material-group" name="merk"  id="merk"  >
                                    </div>
                                </div> 
                                <div class="form-group ">
                                    <label for="material_sap" class="col-md-3">Material pada SAP</label>
                                        <div class="col-md-9">
                                        <input type="text" class="form-control input-sm" name="material_sap"  id="material_sap" maxlength="40"  readonly>
                                        <span class="help-block" id="help_material_sap"></span>
                                    </div>
                                </div> 
                                <div class="form-group">    
                                    <label for="uom" class="col-md-3">Base Unit of Measure</label>
                                        <div class="col-md-9">
                                        <select class="form-control input-sm" name="uom" id="uom" ></select>
                                    </div>
                                </div> 
                                <h5><b>DIMENSI</b></h5>
                                <div class="form-group">
                                    <label for="gross_weight" class="col-md-3">Gross Weight</label>
                                    <div class="col-md-4">   
                                        <input type="text" class="form-control input-sm" name="gross_weight" id="gross_weight" value="0" autocomplete="off" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="net_weight" class="col-md-3">Net Weight</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="net_weight" id="net_weight" value="0" autocomplete="off" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="volume" class="col-md-3">Volume</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="volume" id="volume" value="0" autocomplete="off" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="size" class="col-md-3">Size/Dimension</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="size" id="size" maxlength="30" value="0" autocomplete="off" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="weight_unit" class="col-md-3">Weight Unit</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="weight_unit" id="weight_unit" maxlength="10" value="0" autocomplete="off" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="volume_unit" class="col-md-3">Volume Unit</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="volume_unit" id="volume_unit" maxlength="10" value="0" autocomplete="off" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="volume_unit" class="col-md-3">Estimate price</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="price_estimate" id="price_estimate" maxlength="13" value="0" autocomplete="off" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false" required>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="volume_unit" class="col-md-3">Catatan</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control input-sm" name="remarks" id="remarks"></textarea>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="volume_unit" class="col-md-3">Image</label>
                                    <div  class="col-md-9">
                                         <div id="filesContainer">
                                                <div class="col-md-4" id="panel-image-1">
                                                    <div class="form-group hide">
                                                        <input type="file" id="files_1" name="files_1" accept='image/*'  OnChange="showImage(1)">
                                                        <p class="help-block">*jpg, png</p>
                                                        </div>
                                                        <div class="image-group">
                                                            <button type="button" class="btn btn-danger btn-xs btn-flat btn-add-file-image btn-remove-image1 hide" OnClick="removeImage(1)"><i class="fa fa-trash"></i></button>
                                                            <img id="material-images-1" data-status="0" style="cursor:pointer" title="click to change image" OnClick="openFile(1)" class="img-responsive select-img" src="{{URL::asset('img/add-img.png')}}">
                                                        </div>
                                                    </div> 
                                        </div>
                                    </div>
                                    
                                </div> 
                            </div>
                              <div class="box-footer clearfix">
                                <button type="button" class="btn btn-default btn-flat pull-right" onClick="initialPanel()">Back</button>
                                <button type="submit" class="btn btn-success btn-flat pull-right" style="margin-right: 5px;">Submit</button>
                                <button type="button" class="btn btn-danger btn-flat btn-cancel pull-right" style="margin-right: 5px;">Cancel</button>
                            </div> 
                        </form>
                </div>

            <!-- /#ion-icons -->

            </div>
            <!-- /.tab-content -->
        </div>
                </div>
            </div>    
        <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>     
</div>
@stop
@section('js')
<script>
    var imgFiles = [];    
    var addFile = 2;
    jQuery(document).ready(function() {
        jQuery(".btn-cancel").on('click', function() {
            window.location.href = "{{ url('materialrequest') }}";
        });

        SelectGroup();
        jQuery('#form-basic-data').on('submit', function(e) {
            e.preventDefault();
           jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = jQuery('#form-initial').find('input, select, textarea').appendTo('#form-basic-data');
            var param = new FormData(this);
            jQuery.ajax({
				url:"{{ url('materialrequest/post') }}",
			    type:"POST",
				data: param,
				contentType:false,
				processData:false,
				cache:false,
				beforeSend:function(){jQuery('.loading-event').fadeIn();},
				success:function(result){
                    if(result.status){
                        notify({
                            type:'success',
                            message:result.message
                        });
                        window.location.href = "{{ url('mastermaterial') }}";
                    }else{
                        notify({
                            type:'warning',
                            message:result.message
                        });
                    } 
				},
				complete:function(){jQuery('.loading-event').fadeOut();}
			 });
        });

        var mat_group = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'mat_group'
        });
        jQuery('#sap_material_group').select2({
            data: mat_group,
            width:'100%',
            placeholder: "",
            allowClear: true
        }).on('change', function() {
            var data = jQuery(this).select2('data');
            jQuery("#group_material").val(data[0].text);
            mappingMRP();
            mappingMatGroup(data[0].id);
            SelectGroup(jQuery(this).val());
        });

        jQuery('#sap_material_group').trigger('change');

        var uom = dataJson('{!! route('get.uom') !!}');
        jQuery('#uom').select2({
            data: uom,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });

        jQuery('#uom').val('UN');
        jQuery('#uom').trigger('change');
      
        var plant = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.plant') !!}')));
        jQuery('#plant').select2({
            data: plant,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        }).on("change", function() {
           mappingPlant(jQuery(this).val());
           mappingMRP();
        });

         jQuery('#store_location').select2({
            width:'100%',
            placeholder: "",
            allowClear: true
        });
      
        var location = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.location') !!}')));
        jQuery('#location').select2({
            data: location,
            width:'100%',
            placeholder: "",
            allowClear: true
        });
      
        var mrp_controller = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.mrp_controller') !!}')));
        jQuery('#mrp_controller').select2({
            data: mrp_controller,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
       
        var valuation_class = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.valuation_class') !!}')));
        jQuery('#valuation_class').select2({
            data: valuation_class,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });

        var industry_sector = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.industry_sector') !!}')));
        jQuery('#industry_sector').select2({
            data:industry_sector,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
         jQuery("#industry_sector").val('B');
        jQuery("#industry_sector").trigger('change');
     
        var material_type = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.material_type') !!}')));
        jQuery('#material_type').select2({
            data:material_type,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        jQuery("#material_type").val('63SE');
        jQuery("#material_type").trigger('change');

        var division = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.div') !!}')));
        jQuery('#division').select2({
            data: division,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        jQuery("#division").val('20');
        jQuery("#division").trigger('change');
       
        var sales_org = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.sales_org') !!}')));
        jQuery('#sales_org').select2({
            data: sales_org,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });

        jQuery("#sales_org").val('63SE');
        jQuery("#sales_org").trigger('change');
       
        var dist_channel = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.dist_channel') !!}')));
        jQuery('#dist_channel').select2({
            data: dist_channel,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });

        jQuery("#dist_channel").val('20');
        jQuery("#dist_channel").trigger('change');
        
        
        var item_cat = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.item_cat') !!}')));
        jQuery('#general_item_category_group, #item_category_group').select2({
            data: item_cat,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
      
        jQuery("#general_item_category_group, #item_category_group").val('NORM');
        jQuery("#general_item_category_group, #item_category_group").trigger('change');
      
        var tax_classification = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.tax_classification') !!}')));
        jQuery('#tax_classification').select2({
            data: tax_classification,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });

        jQuery("#tax_classification").val(1);
        jQuery("#tax_classification").trigger('change');
      

        var account_assign = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.account_assign') !!}')));
        jQuery('#account_assign').select2({
            data: account_assign,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        jQuery("#account_assign").val(10);
        jQuery("#account_assign").trigger('change');
        
       
        var availability_check = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.availability_check') !!}')));
        jQuery('#availability_check').select2({
            data: availability_check,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        jQuery("#availability_check").val('KP');
        jQuery("#availability_check").trigger('change');
       
        var transportation_group = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.transportation_group') !!}')));
        jQuery('#transportation_group').select2({
            data: transportation_group,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        jQuery("#transportation_group").val(3000);
        jQuery("#transportation_group").trigger('change');
        
        var loading_group = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.loading_group') !!}')));
        jQuery('#loading_group').select2({
            data: loading_group,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        jQuery("#loading_group").val(1000);
        jQuery("#loading_group").trigger('change');
      
        var profit_center = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.profit_center') !!}')));
        jQuery('#profit_center').select2({
            data: profit_center,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        jQuery("#profit_center").val('Z');
        jQuery("#profit_center").trigger('change');
       
        var mrp_type = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.mrp_type') !!}')));
        jQuery('#mrp_type').select2({
            data: mrp_type,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        jQuery("#mrp_type").val('ND');
        jQuery("#mrp_type").trigger('change');
       
        var sle = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.sle') !!}')));
        jQuery('#period_ind_for_sle').select2({
            data: sle,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        jQuery("#period_ind_for_sle").val('D');
        jQuery("#period_ind_for_sle").trigger('change');
      
        jQuery('#cash_discount').select2({
            data: [
                {"id": 0, "text": "No"},
                {"id": 1, "text": "Yes"}
            ],
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        jQuery("#cash_discount").val(1);
        jQuery("#cash_discount").trigger('change');
        jQuery("#cash_discount").css('background-color','#d2d6de');

        jQuery("#plant").trigger('change');

        jQuery('#form-initial').on('submit', function(e){
            e.preventDefault();
            basicDataPanel();
        });

        jQuery('.attr-material-group').on('keyup', function(){
            genMaterialNo();
        });
        
        jQuery('#form-basic-data').on('submit', function(e){
            e.preventDefault();
            imagePanel();
        });

    });

    function openFile(id) {
        jQuery("#files_" + id).trigger('click');
    }

    function closeGroupMaterialModal() {
        // jQuery('#group-material-modal').modal('hide');
        jQuery('#group-material-modal').on('hidden.bs.modal', function(event) {

            $('#add-data-modal').off('hidden.bs.modal');
            jQuery('#add-data-modal').modal({backdrop: 'static', keyboard: false});
            jQuery('#add-data-modal').modal('show');
        }).modal('hide');
        //jQuery("#add-data-modal").modal("show");
    }

    function SelectGroup(mat_no) {
        jQuery(".material-group-input").removeClass('has-success');
        jQuery(".attr-material-group").prop("required", false);
        var material_attr = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('setmaterial/edit/?id=') }}" + mat_no)));
        if(material_attr.length > 0) {
            var attr = material_attr[0].description;
            var data = attr.split(',');
            var help_material_sap = "";

            selected_material_group = attr;
            var no = 1;
            jQuery.each(data, function(key, val) {
                if(no > 1 ) {
                help_material_sap += "-";
                }
                help_material_sap += val.replace("-", " ");
                if(val == 'part-number') {
                    jQuery("#input-part-no").addClass("has-success");
                    jQuery("#part_no").prop("required",true);

                }else if(val == 'deskripsi-material'){
                    jQuery("#input-description").addClass("has-success");
                    jQuery("#description").prop("required",true);

                }else if(val == 'spesifikasi'){
                    jQuery("#input-specification").addClass("has-success");
                    jQuery("#specification").prop("required",true);

                }else if(val == 'merk'){
                    jQuery("#input-merk").addClass("has-success");
                    jQuery("#merk").prop("required",true);
                }
                no++;
            });
        }else{
            selected_material_group = 'deskripsi-material';
            help_material_sap = "Deskripsi material";
            jQuery("#material_sap").val('01');
            jQuery("#input-description").addClass("has-success");
            jQuery("#description").prop("required",true);
        }
       
        jQuery("#help_material_sap").text('Pattern: ' + help_material_sap);
    }

    function genMaterialNo(){
         var data = selected_material_group.split(',');
         var material_no = "";
        var no = 1;
        jQuery.each(data, function(key, val) {
            if(no > 1 ) {
               material_no += "-";
            }
            if(val == 'part-number') {
                material_no += jQuery("#part_no").val();
            }else if(val == 'deskripsi-material'){
                material_no += jQuery("#description").val();
            }else if(val == 'spesifikasi'){
                material_no += jQuery("#specification").val();
            }else if(val == 'merk'){
                material_no += jQuery("#merk").val();
            }
            no++;
        });

        var mat_sap = material_no.substring(0,39);
        jQuery("#material_sap").val(mat_sap.toUpperCase());
    }

    function initialPanel() {
        jQuery('.panel-initial').attr("data-toggle","tab");
        jQuery('.panel-initial').click();
        jQuery('.panel-basic-data').removeAttr("data-toggle");
        jQuery('.panel-image').removeAttr("data-toggle");

        topFunction();
    }
  
    function basicDataPanel() {
        jQuery('.panel-basic-data').attr("data-toggle","tab");
        jQuery('.panel-basic-data').click();

        jQuery('.panel-initial').removeAttr("data-toggle");
        jQuery('.panel-image').removeAttr("data-toggle");
        topFunction();
    }
  
    function imagePanel() {
        jQuery('.panel-image').attr("data-toggle","tab");
        jQuery('.panel-image').click();

        jQuery('.panel-initial').removeAttr("data-toggle");
        jQuery('.panel-basic-data').removeAttr("data-toggle");
    }

    function showImage(id) {
         var src = document.getElementById("files_" + id);
        var target = document.getElementById("material-images-" + id);
        var fr=new FileReader();
        fr.onload = function(e) { target.src = this.result; };
        fr.readAsDataURL(src.files[0]);
        imgFiles.push(src.files[0]);
        jQuery('.btn-remove-image' + id).removeClass('hide');
        var status = jQuery('#material-images-' + id).data('status');

        if(status === 0) {
            genAddFile();
            jQuery('#material-images-' + id).data('status', 1);
        }
    }

    function removeImage(id) {
        var input = jQuery( "input:file");
        jQuery('#panel-image-' + id).remove();
    }


    function genAddFile() {
         var input = jQuery( "input:file");
        if (input.length == 10) {
            notify({
                type: 'warning',
                message: "max file image is 10"
            });
        } else {
            var content = '';
            content +='<div class="col-md-4" id="panel-image-' + addFile + '">';
            content +='<div class="form-group hide">';
            content +='<input type="file" id="files_' + addFile + '" name="files_' + addFile + '" accept="image/*"  OnChange="showImage(' + addFile + ')">';
            content +='<p class="help-block">*jpg, png</p>';
            content +='</div>';
            content +='<div class="image-group">';
            content +='<button type="button" class="btn btn-danger btn-xs btn-flat btn-add-file-image btn-remove-image' + addFile + ' hide" OnClick="removeImage(' + addFile + ')"><i class="fa fa-trash"></i></button>';
            content +='<img id="material-images-' + addFile + '" title="click to change image"  data-status="0" style="cursor:pointer" OnClick="openFile(' + addFile + ')" class="img-responsive select-img" src="{{URL::asset('img/add-img.png')}}">';
            content +='</div>'; 
            content +='</div>'; 

            jQuery('#filesContainer').append(content);
            addFile++;
        }
    }

    function mappingMatGroup(id) {
        var result = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('mappingmatgroup/edit/?id=') }}" + id)));
        if(result.length > 0) {
            jQuery('#material_type').val(result[0].material_type);
            jQuery('#material_type').trigger('change');
        
            jQuery('#valuation_class').val(result[0].valuation_class);
            jQuery('#valuation_class').trigger('change');   
        } else {
            jQuery('#material_type').val('');
            jQuery('#material_type').trigger('change');
        
            jQuery('#valuation_class').val('');
            jQuery('#valuation_class').trigger('change');   
        }
    }

    function mappingPlant(id) {
        var result = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('mappingplant/edit/?id=') }}" + id)));
        if(result.length > 0) {
             var store_location = dataJson("{{ url('materialrequest/store_location/?id=') }}" + result[0].plant);
            jQuery('#store_location').select2({
                data: store_location,
                width:'100%',
                placeholder: "",
                allowClear: true
            });

            jQuery('#store_location').val(result[0].store_loc);
            jQuery('#store_location').trigger('change');

            jQuery('#location').val(result[0].locat);
            jQuery('#location').trigger('change');
           
            jQuery('#profit_center').val(result[0].profit_center);
            jQuery('#profit_center').trigger('change');
           
            jQuery('#sales_org').val(result[0].sales_org);
            jQuery('#sales_org').trigger('change');
        } else {
            jQuery('#store_location').val('');
            jQuery('#store_location').trigger('change');

            jQuery('#location').val('');
            jQuery('#location').trigger('change');
           
            jQuery('#profit_center').val('');
            jQuery('#profit_center').trigger('change');
           
            jQuery('#sales_org').val('');
            jQuery('#sales_org').trigger('change');
        }
    }

    function mappingMRP() {
        var plant = jQuery('#plant').val();
        var mat_group = jQuery('#sap_material_group').val();
        if(plant && mat_group) {
             var result = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('mappingmrp/edit/?id=') }}" + plant +'/'+ mat_group )));
            if(result.length > 0) { 
                jQuery('#mrp_controller').val(result[0].mrp_controller);
                jQuery('#mrp_controller').trigger('change');
            } else {
                jQuery('#mrp_controller').val('');
                jQuery('#mrp_controller').trigger('change');
            }
        }
    }


</script>            
@stop