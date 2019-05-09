@extends('adminlte::page')

@section('title', 'FMDB')

@section('content')
<style>
label {
    font-weight: 500;
}
.select-img:hover {
    opacity: 0.5
}
</style>
<section class="content">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-pencil"></i> Add Material</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                            <div class="">
            <ul class="nav nav-tabs">
            <li class="active"><a href="#panel-initial" class="panel-initial">INITIAL</a></li>
            <li><a href="#panel-basic-data" class="panel-basic-data">MATERIAL INFORMATION</a></li>
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
                                    <select type="text" class="c" name="material_type" id="material_type"  maxlength="10"  required>
                                        
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
                                    <select type="text" class="form-control input-sm" name="dist_channel" id="dist_channel"  maxlength="4" required>
                                        
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
                                    <select type="text" class="form-control input-sm" name="period_ind_for_sle" maxlength="10" id="period_ind_for_sle" required>
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
                                        <input type="text" class="form-control input-sm" name="material_sap"  id="material_sap" maxlength="30"  readonly>
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
                                        <input type="text" class="form-control input-sm" name="gross_weight" id="gross_weight" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="net_weight" class="col-md-3">Net Weight</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="net_weight" id="net_weight" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="volume" class="col-md-3">Volume</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="volume" id="volume" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="size" class="col-md-3">Size/Dimension</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="size" id="size" maxlength="30" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="weight_unit" class="col-md-3">Weight Unit</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="weight_unit" id="weight_unit" maxlength="10" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="volume_unit" class="col-md-3">Volume Unit</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="volume_unit" id="volume_unit" maxlength="10" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="volume_unit" class="col-md-3">Remarks</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control input-sm" name="remarks" id="remarks"></textarea>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="volume_unit" class="col-md-3">Image</label>
                                     <div class="col-md-3">
                                            <div class="form-group hide">
                                        <input type="file" id="files_1" name="files_1" accept='image/*'  OnChange="showImage(1)">
                                        <p class="help-block">*jpg, png</p>
                                        </div>
                                        <img id="material-images-1" style="cursor:pointer" OnClick="openFile(1)" class="img-responsive select-img" src="{{URL::asset('img/default-img.png')}}">
                                    </div> 
                                    <div class="col-md-3">
                                            <div class="form-group hide">
                                        <input type="file" id="files_2" name="files_2" accept='image/*'  OnChange="showImage(2)">
                                        <p class="help-block">*jpg, png</p>
                                        </div>
                                        <img id="material-images-2" style="cursor:pointer" OnClick="openFile(2)" class="img-responsive select-img" src="{{URL::asset('img/default-img.png')}}">
                                    </div> 
                                    <div class="col-md-3">
                                            <div class="form-group hide">
                                        <input type="file" id="files_3" name="files_3"  accept='image/*'  OnChange="showImage(3)">
                                        </div>
                                        <img id="material-images-3" style="cursor:pointer" OnClick="openFile(3)" class="img-responsive select-img" src="{{URL::asset('img/default-img.png')}}">
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
                    var data = jQuery.parseJSON(result);
                    if(data.code == '201'){
                        notify({
                            type:'success',
                            message:data.message
                        });
                        window.location.href = "{{ url('materialrequest') }}";
                    }else{
                        notify({
                            type:'warning',
                            message:data.message
                        });
                    } 
				},
				complete:function(){jQuery('.loading-event').fadeOut();}
			 });
        });

        var material_group = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.get_group_material') !!}')));
        jQuery('#sap_material_group').select2({
            data: material_group,
            width:'100%',
            placeholder: "",
            allowClear: true
        }).on('change', function() {
            jQuery("#group_material").val(jQuery(this).val());
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
      
        var plant = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.plant') !!}')));
        jQuery('#plant').select2({
            data: plant,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        }).on("change", function() {
            var store_location = dataJson("{{ url('materialrequest/store_location/?id=') }}"+jQuery(this).val());
            jQuery('#store_location').select2({
                data: store_location,
                width:'100%',
                placeholder: "",
                allowClear: true
            });
        });

        jQuery("#plant").trigger('change');


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
     
        var material_type = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.material_type') !!}')));
        jQuery('#material_type').select2({
            data:material_type,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });

        var division = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.div') !!}')));
        jQuery('#division').select2({
            data: division,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
       
        var sales_org = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.sales_org') !!}')));
        jQuery('#sales_org').select2({
            data: sales_org,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
       
        var dist_channel = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.dist_channel') !!}')));
        jQuery('#dist_channel').select2({
            data: dist_channel,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
        
        var item_cat = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.item_cat') !!}')));
        jQuery('#general_item_category_group, #item_category_group').select2({
            data: item_cat,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
      
      
        var tax_classification = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.tax_classification') !!}')));
        jQuery('#tax_classification').select2({
            data: tax_classification,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
      

        var account_assign = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.account_assign') !!}')));
        jQuery('#account_assign').select2({
            data: account_assign,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
       
        var availability_check = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.availability_check') !!}')));
        jQuery('#availability_check').select2({
            data: availability_check,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
       
        var transportation_group = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.transportation_group') !!}')));
        jQuery('#transportation_group').select2({
            data: transportation_group,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
    
        var loading_group = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.loading_group') !!}')));
        jQuery('#loading_group').select2({
            data: loading_group,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
      
        var profit_center = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.profit_center') !!}')));
        jQuery('#profit_center').select2({
            data: profit_center,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
       
        var mrp_type = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.mrp_type') !!}')));
        jQuery('#mrp_type').select2({
            data: mrp_type,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
       
        var sle = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.sle') !!}')));
        jQuery('#period_ind_for_sle').select2({
            data: sle,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
      
        jQuery('#cash_discount').select2({
            data: [
                {"id": 0, "text": "No"},
                {"id": 1, "text": "Yes"}
            ],
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });

        jQuery('#form-initial').on('submit', function(e){
            e.preventDefault();
            basicDataPanel();
        });

        jQuery('.attr-material-group').on('change', function(){
            genMaterialNo();
        })

        
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
         $('#group-material-modal').on('hidden.bs.modal', function(event) {

            $('#add-data-modal').off('hidden.bs.modal');
            jQuery('#add-data-modal').modal({backdrop: 'static', keyboard: false});
            jQuery('#add-data-modal').modal('show');
        }).modal('hide');
        //jQuery("#add-data-modal").modal("show");
    }

     function SelectGroup(mat_no) {
        jQuery(".material-group-input").removeClass('has-success');
        jQuery(".attr-material-group").prop("required", false);
        var material_attr = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.group_material_list') !!}?code='+mat_no)));
        
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

        jQuery("#material_sap").val(material_no);
    }

    function initialPanel() {
        jQuery('.panel-initial').attr("data-toggle","tab");
        jQuery('.panel-initial').click();
        jQuery('.panel-basic-data').removeAttr("data-toggle");
        jQuery('.panel-image').removeAttr("data-toggle");
    }
  
    function basicDataPanel() {
        jQuery('.panel-basic-data').attr("data-toggle","tab");
        jQuery('.panel-basic-data').click();

        jQuery('.panel-initial').removeAttr("data-toggle");
        jQuery('.panel-image').removeAttr("data-toggle");
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
        // when image is loaded, set the src of the image where you want to display it
        fr.onload = function(e) { target.src = this.result; };
        fr.readAsDataURL(src.files[0]);
        imgFiles.push(src.files[0]);
    }

    function binEncode(data) {
        var binArray = []
        var datEncode = "";

        for (i=0; i < data.length; i++) {
            binArray.push(data[i].charCodeAt(0).toString(2)); 
        } 
        for (j=0; j < binArray.length; j++) {
            var pad = padding_left(binArray[j], '0', 8);
            datEncode += pad + ' '; 
        }

        function padding_left(s, c, n) { if (! s || ! c || s.length >= n) {
            return s;
        }

        var max = (n - s.length)/c.length;
        for (var i = 0; i < max; i++) {
            s = c + s; } return s;
        }
        return binArray;
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
        }
        return true;
    }

</script>            
@stop