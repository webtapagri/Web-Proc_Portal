@extends('adminlte::page')

@section('title', 'FMDB')

@section('content')
<style>
    .select-img:hover {
        opacity: 0.5
    }
</style>
<section class="content">
       <div class="row">
              <div class="col-md-9 col-md-offset-1">
                    <div class="input-group">
                        <input type="text" class="form-control" onChange="searchData()" id="search_material" placeholder="search material">
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-flat btn-success btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                    </div>
                </div>
                <div class="col-md-1" align="left">
                    <span href="#" class="btn btn-flat btn-sm btn-success btn-add" style="display:none">&nbsp;<i class="glyphicon glyphicon-plus" title="Request new material"></i>&nbsp;Add</span>
                </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
             <table id="data-table" class="table table-condensed" style="background-color:white" width="100%">
                <thead>
                    <tr>
                        <th width="18%">Material list</th>
                        <th></th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                    <tbody></tbody>
                </table>
          </div>
        </div>
      </div>
</section>
<div id="add-data-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">	
				<h4 class="modal-title"></h4>
			</div>

                	<div class="modal-body">	
                        <div class="row">
                                <div class="col-xs-12">
                                <div class="">
                                    <ul class="nav nav-tabs">
                                    <li class="active"><a href="#panel-initial" class="panel-initial">INITIAL</a></li>
                                    <li><a href="#panel-basic-data" class="panel-basic-data" disabled>MATERIAL INFORMATION</a></li>
                                    </ul>
                                    <div class="tab-content">
                                    <!-- Font Awesome Icons -->
                                        <div class="tab-pane active" id="panel-initial">
                                            <form id="form-initial">
                                               <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="sap_material_group">Material Group</label>
                                                                <select type="text" class="form-control" name="sap_material_group" id="sap_material_group" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="plant">Plant</label>
                                                                <select type="text" class="form-control" name="plant" id="plant" maxlength="4" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">  
                                                            <div class="form-group">
                                                                <label for="location">Location</label>
                                                                <select type="text" class="form-control" name="location" id="location"  maxlength="10" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="mrp_controller">MRP Controller</label>
                                                                <select type="text" class="form-control" name="mrp_controller" id="mrp_controller"  maxlength="3"  required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="valuation_class">Valuation Class</label>
                                                                <select type="text" class="form-control" name="valuation_class"  maxlength="10"  id="valuation_class" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>  
                                                         <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="sector_industry">Industri sector</label>
                                                                <select type="text" class="form-control" name="industry_sector" id="industry_sector" maxlength="20" required >
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  <div class="row">
                                                         <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="material_type">Material Type</label>
                                                                <select type="text" class="c" name="material_type" id="material_type"  maxlength="10"  required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div> 
                                                         <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="store_location">Store Location</label>
                                                                <select type="text" class="form-control" name="store_location" id="store_location"  maxlength="4" required>
                                                                </select>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="sales_org">Sales Org</label>
                                                                <select type="text" class="form-control" name="sales_org" id="sales_org"  maxlength="4" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>  
                                                  </div>
                                                    <div class="row">
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="dist_channel">Distribution Channel</label>
                                                                <select type="text" class="form-control" name="dist_channel" id="dist_channel"  maxlength="4" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="division">Division</label>
                                                                <select type="text" class="form-control" name="division" id="division"  maxlength="30" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="general_item_category_group">General Item Category Group</label>
                                                                <select type="text" class="form-control" name="general_item_category_group" id="general_item_category_group" maxlength="4" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>    
                                                    </div>  
                                                    <div class="row">
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="cash_discount">Cash Discount</label>
                                                                <select type="text" class="form-control" name="cash_discount" id="cash_discount"  maxlength="1"  required></select>
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="tax_classification">Tax Classification</label>
                                                                <select type="text" class="form-control" name="tax_classification" id="tax_classification" maxlength="1" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="account_assign">Account Assignment Group</label>
                                                                <select type="text" class="form-control" name="account_assign" id="account_assign" maxlength="2" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>    
                                                     </div>  
                                                    <div class="row">
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="item_category_group">Item Category Group</label>
                                                                <select type="text" class="form-control" name="item_category_group" id="item_category_group" maxlength="30" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="availability_check">Availability Check</label>
                                                                <select type="text" class="form-control" name="availability_check" id="availability_check" maxlength="2" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="transportation_group">Transportation Group</label>
                                                                <select type="text" class="form-control" name="transportation_group" maxlength="4" id="transportation_group" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="loading_group">Loading Group</label>
                                                                <select type="text" class="form-control" name="loading_group" id="loading_group" maxlength="4" required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="profit_center">Profit Center</label>
                                                                <select type="text" class="form-control" name="profit_center" id="profit_center" maxlength="4"  required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="mrp_type">MRP Type</label>
                                                                <select type="text" class="form-control" name="mrp_type" id="mrp_type" maxlength="4"  required>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="period_ind_for_sle">Period Ind. for SLE</label>
                                                                <select type="text" class="form-control" name="period_ind_for_sle" maxlength="10" id="period_ind_for_sle" required>
                                                                </select>
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4"> 
                                                            <div class="form-group">
                                                                <label for="price_unit">Price Unit</label>
                                                                <input type="number" class="form-control" name="price_unit" id="price_unit" value="1" required>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                               </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success btn-flat" style="margin-right: 5px;">Next</button>
                                                </div> 
                                            </form>
                                         
                                        </div>
                                        <!-- /#fa-icons -->

                                        <!-- glyphicons-->
                                        <div class="tab-pane" id="panel-basic-data">
                                              <form id="form-basic-data" enctype="multipart/form-data">
                                                  <div class="box-body">
                                                      <div class="row">
                                                        <div class="col-md-4">
                                                                <label for="group_material" >Group Material</label>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" name="group_material" id="group_material" readonly>
                                                                    <input type="hidden" name="group_material_id" id="group_material_id" readonly>
                                                                    <span class="input-group-btn hide">
                                                                        <button type="button" class="btn btn-default btn-flat btn-group-material"><i class="fa fa-search"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>     
                                                        <div class="col-md-4">
                                                            <div class="form-group material-group-input" id="input-description">    
                                                                <label for="part_no">Description</label>
                                                                <input type="text" class="form-control attr-material-group" name="description" id="description" autocomplete="off">
                                                            </div>
                                                        </div>   
                                                        <div class="col-md-4"> 
                                                            <div class="form-group material-group-input" id="input-part-no">
                                                                <label for="part_no">Part Number</label>
                                                                <input type="text" class="form-control attr-material-group" name="part_no" id="part_no"  autocomplete="off">
                                                            </div>
                                                        </div> 
                                                      </div>
                                                      <div class="row">
                                                        <div class="col-md-4">  
                                                         <div class="form-group material-group-input" id="input-specification">
                                                            <label for="part_no" class="col-md-3 col-form-label">Spesifikasi</label>
                                                                <input type="text" class="form-control attr-material-group" name="specification"  id="specification" >
                                                            </div>
                                                        </div> 
                                                        <div class="col-sm-4">
                                                            <div class="form-group material-group-input" id="input-merk">
                                                                 <label for="brand">Merk</label>
                                                                <input type="text" class="form-control attr-material-group" name="merk"  id="merk"  >
                                                            </div>
                                                        </div> 
                                                        <div class="form-group ">
                                                            <div class="col-md-4">
                                                                <label for="material_sap">Material pada SAP</label>
                                                                <input type="text" class="form-control" name="material_sap"  id="material_sap" maxlength="30"  readonly>
                                                                <span class="help-block" id="help_material_sap"></span>
                                                            </div>
                                                        </div> 
                                                      </div>
                                                       <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">    
                                                                    <label for="uom">Base Unit of Measure</label>
                                                                    <select class="form-control" name="uom" id="uom" ></select>
                                                                </div>
                                                            </div> 
                                                      </div>
                                                      <h5>DIMENSI</h5>
                                                       <div class="row">
                                                         <div class="col-md-4">   
                                                            <div class="form-group">
                                                                <label for="gross_weight">Gross Weight</label>
                                                                <input type="text" class="form-control" name="gross_weight" id="gross_weight" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                                            </div>
                                                        </div> 
                                                         <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="net_weight">Net Weight</label>
                                                                <input type="text" class="form-control" name="net_weight" id="net_weight" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                            <label for="volume">Volume</label>
                                                                <input type="text" class="form-control" name="volume" id="volume" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                                            </div>
                                                        </div> 
                                                      </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="size">Size/Dimension</label>
                                                                   <input type="text" class="form-control" name="size" id="size" maxlength="30" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="weight_unit">Weight Unit</label>
                                                                    <input type="text" class="form-control" name="weight_unit" id="weight_unit" maxlength="10" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                 <label for="volume_unit">Volume Unit</label>
                                                                    <input type="text" class="form-control" name="volume_unit" id="volume_unit" maxlength="10" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                                                </div>
                                                            </div> 
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                 <label for="volume_unit">Remarks</label>
                                                                    <textarea type="text" class="form-control" name="remarks" id="remarks"></textarea>
                                                                </div>
                                                            </div> 
                                                      </div>    
                                                       <h5>IMAGE</h5>
                                                       <div class="row">
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
                                                   <div class="modal-footer">
                                                        <button type="button" class="btn btn-default btn-flat" onClick="initialPanel()">Back</button>
                                                        <button type="submit" class="btn btn-success btn-flat" style="margin-right: 5px;">Submit</button>
                                                    </div> 
                                              </form>
                                        </div>
                        
                                    <!-- /#ion-icons -->

                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- /.nav-tabs-custom -->
                                </div>
                                <!-- /.col -->
                            </div>     
                    </div>
		</div>
    </div>
</div>
<div id="group-material-modal" class="modal fade" role="dialog">
    <div class="modal-dialog" width="900px">
		<div class="modal-content">
			<div class="modal-header">	
				<h4 class="modal-title">Group Material</h4>
			</div>
			<div class="modal-body">	
				<div class="box-body">
                    <table class="table table-bordered table-condensed" id="group-material-table" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center;" width="width:2%">No</th>
                                <th>Code</th>
                                <th>Attribute</th>
                                <th width="5%" class="text-center">Action</th>
                            </tr>
                            <tbody></tbody>
                        </thead>
                    </table>
				</div>	 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-group-material-modal">Close</button>
			</div>
		</div>
    </div>
</div>
@stop
@section('js')
<script>
    var imgFiles = [];    
    jQuery(document).ready(function() {
      initData();  

      var search = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.auto_sugest') !!}')));
      jQuery("#search_material").autocomplete({
        source: search
      });

        SelectGroup();
         jQuery('#form-basic-data').on('submit', function(e) {
            e.preventDefault();
           jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //var form = jQuery('#form-initial').not(':submit').clone().hide().appendTo('#form-basic-data');

            var form = jQuery('#form-initial').find('input, select, textarea').appendTo('#form-basic-data');
            var param = new FormData(this);
            jQuery.ajax({
				url:"{{ url('materialrequest/post') }}",
			    type:"POST",
				data: param,
				contentType:false,
				processData:false,
				cache:false,
				beforeSend:function(){},
				success:function(result){
                    var data = jQuery.parseJSON(result);
                    if(data.code == '201'){
                        jQuery("#add-data-modal").modal("hide");
                        jQuery("#data-table").DataTable().ajax.reload();
                        notify({
                            type:'success',
                            message:data.message
                        });
                    }else{
                        notify({
                            type:'warning',
                            message:data.message
                        });
                    } 
				},
				complete:function(){}
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


    jQuery('.btn-add').on('click', function() {
        //jQuery(".material-group-input").removeClass('has-success');
        jQuery(".attr-material-group").prop("required", false);
        //document.getElementById("data-form").reset();
        jQuery("#edit_id").val("");
            jQuery("#add-data-modal .modal-title").html("<i class='fa fa-plus'></i> Create Request");	
        jQuery("#add-data-modal").modal({backdrop:'static', keyboard:false});			
        jQuery("#add-data-modal").modal("show");		
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

    jQuery("#search_material").on("change", function(){
        jQuery(".btn-add").removeClass("hide");
    });
    
        jQuery('.btn-group-material').on('click', function() {
            //jQuery('#add-data-modal').modal('hide');

               $('#add-data-modal').on('hidden.bs.modal', function(event) {
                    // Open your second one in here
                    $('#group-material-modal').off('hidden.bs.modal');
                    jQuery('#group-material-modal').modal({backdrop: 'static', keyboard: false});
                    jQuery('#group-material-modal').modal('show');
                    // This will remove ANY event attached to 'hidden.bs.modal' label
                }).modal('hide');

            // jQuery('#group-material-modal').modal({backdrop: 'static', keyboard: false});
            // jQuery('#group-material-modal').modal('show');
        });
        
        jQuery('.btn-close-group-material-modal').on('click', function() {
           closeGroupMaterialModal()

        });    

    });

    function initData(param) {
        if ( jQuery.fn.DataTable.isDataTable('#data-table') ) {
            jQuery('#data-table').DataTable().destroy();
        }

        var table =   jQuery('#data-table').DataTable({
        ajax: {
            url:'{!! route('get.tm_material') !!}' + '?search='+ (param ? param:''),
            dataFilter: function(data){
                var json = jQuery.parseJSON( data );
                json.recordsTotal = json.recordsTotal;
                json.recordsFiltered = json.recordsFiltered;
                json.data = json.list;
                totalData = jQuery.parseJSON(data);
                if(totalData.data.length > 0) {
                    jQuery('.btn-add').hide();
                }else{
                    jQuery('.btn-add').show();
                }

                return data;
            },
        },
        columns: [
            {  
                "render": function (data, type, row) {
                    if(row.img) {
                        var content = '<img src="' + row.img + '" class="img-responsive">';
                    } else{
                        var content = '';
                    }    
                    return content;
                } 
            },
            { 
                "render": function (data, type, row) {
                    var content  = '<div class="row" style="padding-left:30px;padding-right:30px;padding-bottom:30px">';
                        content += '<div class="row">';
                        content += '    <div class="col-md-4"><b>Material Number</b></div>';
                        content += '    <div class="col-md-8">' + row.no_material + '</div>'
                        content += '</div>';
                        content += '<div class="row">';
                        content += '    <div class="col-md-4"><b>Nama Material</b></div>';
                        content += '    <div class="col-md-8">' + row.material_name + '</div>';
                        content += '</div>';
                        content += '<div class="row">';
                        content += '    <div class="col-md-4"><b>Merk</b></div>';
                        content += '    <div class="col-md-8">' + (row.merk ? row.merk :'')+ '</div>';
                        content += '</div>';
                        content += '<div class="row">';
                        content += '    <div class="col-md-4"><b>Satuan</b></div>';
                        content += '    <div class="col-md-8">' + row.weight_unit + '</div>';
                        content += '</div>';
                        content += '<div class="row">';
                        content += '    <div class="col-md-4"><b>Keterangan:</b></div>';
                        //content += '    <div class="col-md-12" style="font-size:11px;"> Generator - Max Power: 5.500 watt - Rated Power: 5.000 watt - Rated Ampere: 22.7 A - Voltage: 220 Volt   Frekuensi: 50 Hz- DC Output: 12 Volt / 8.3 A - Phasa: Single </br> Engine - Type: 4 stroke, OHV, Air Cooled - Engine Model: GX 390 - Displacement: 389 CC - Max. Power Output: 13 HP / 3.600 RPM - Starting System: Electric + Recoil Starting / Engkol Tarik- Fuel: Gasoline- Fuel Tank Capacity: 28 Litre - Oil Engine Capacity: 1.100 ml - Noise Level: 72 dB - Dimension: 77 x 56 x 57 cm - Gross Weight: 97 kg</div>';
                        content += '    <div class="col-md-12" style="font-size:11px;">' + (row.remarks ? row.remarks:'') + '</div>';
                        content += '</div>';
                        content += '</div>';

                    return content;
                } 
            },
            { 
                 "render": function (data, type, row) {
                     if(row.src == 1) {
                        var content = '<span href="#" class="btn btn-flat btn-sm btn-default btn-flat btn-block">Extend</span><span href="#" class="btn btn-flat btn-sm btn-default btn-flat btn-block ">Read to PO</span>';
                     }else{
                        var content = '<span class="label label-warning">Requested</span>';
                     }
                    return content;
                } 
            }
        ],
        columnDefs: [
            { targets: [1]},
        ],
        "pageLength": 8,
        "searching": false,
        "sort": false,
        "lengthChange": false,
      });
    }

    function searchData() {
        var param = jQuery('#search_material').val();
        initData(param);
    }

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

    function searchDataTable() {
        // Declare variables 
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search_material");
        filter = input.value.toUpperCase();
        table = document.getElementById("data-table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            } 
        }
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