@extends('adminlte::page')

@section('title', 'FMDB - Edit material')

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
                    <h3 class="box-title"><i class="fa fa-pencil"></i> Edit Material</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                            <div class="">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#panel-initial" class="panel-initial" data-toggle="tab">INITIAL</a></li>
                <li><a href="#panel-basic-data" class="panel-basic-data" data-toggle="tab">MATERIAL INFORMATION</a></li>
            </ul>
            <div class="tab-content">
            <!-- Font Awesome Icons -->
                <div class="tab-pane active" id="panel-initial">
                    <form id="form-initial"  class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="sap_material_group" class="col-md-3">Material Group</label>
                                <div class="col-md-9">
                                    <input type="test"  class="form-control input-sm" name="sap_material_group" id="sap_material_group" value="{{ $mat_group_name }}" required readonly></select>
                                   <!--  <select  class="form-control input-sm" name="sap_material_group" id="sap_material_group" required readonly></select> -->
                                </div>    
                            </div>
                            <div class="form-group">
                                <label for="plant" class="col-md-3">Plant</label>
                                    <div class="col-md-9">
                                    <input type="text" class="form-control input-sm" name="plant" value="{{ $plant }}" id="plant"  required readonly>
                                </div>    
                            </div>
                            
                            <div class="form-group">
                                <label for="location" class="col-md-3">Location</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control input-sm" name="location" id="location" value="{{$location}}" required readonly>
                                </div>
                            </div>  
                          
                            <div class="form-group">
                                <label for="mrp_controller" class="col-md-3">MRP Controller</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control input-sm" name="mrp_controller" id="mrp_controller"  value="{{ $mrp_controller }}"  required readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="valuation_class" class="col-md-3">Valuation Class</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control input-sm" name="valuation_class"  value="{{ $valuation_class }}"  id="valuation_class" required readonly>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="sector_industry" class="col-md-3">Industri sector</label>
                                    <div class="col-md-9">
                                    <input type="text" class="form-control input-sm" name="industry_sector" id="industry_sector" value="{{ $industry_sector }}" required readonly>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="material_type" class="col-md-3">Material Type</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control input-sm" name="material_type" id="material_type" value="{{ $material_type }}" required readonly>
                                </div>
                            </div> 
                           
                            <div class="form-group">
                                <label for="store_location" class="col-md-3">Store Location</label>
                                    <div class="col-md-9">
                                   <!--  <select class="form-control input-sm" name="store_location" id="store_location" value="{{ $store_loc }}" required readonly></select> -->
                                    <input type="text" class="form-control input-sm" name="store_location" id="store_location" value="{{ $store_loc_name }}" required readonly>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label for="sales_org" class="col-md-3">Sales Org</label>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control input-sm" name="sales_org" id="sales_org"  value="{{ $sales_org }}" required readonly>
                                </div>
                            </div>  
                            
                            <div class="form-group">
                                <label for="dist_channel" class="col-md-3">Distribution Channel</label>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control input-sm" name="dist_channel" id="dist_channel" value="{{ $dist_channel }}" required readonly>
                                </div>
                            </div>    
                           
                            <div class="form-group">
                                <label for="division" class="col-md-3">Division</label>
                                    <div class="col-md-9"> 
                                    <input type="text" class="form-control input-sm" value="{{ $div }}" name="division" id="division"  required readonly>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="general_item_category_group" class="col-md-3">General Item Category Group</label>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control input-sm" name="general_item_category_group" id="general_item_category_group" value="{{ $item_cat }}" required readonly>
                                </div>
                            </div>   
                            <div class="form-group">
                                <label for="cash_discount" class="col-md-3">Cash Discount</label>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control input-sm" name="cash_discount" id="cash_discount"  value="{{ $cash_discount }}"  required readonly>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="tax_classification" class="col-md-3">Tax Classification</label>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control input-sm" name="tax_classification" id="tax_classification" value="{{ $tax_class }}" required readonly>
                                </div>
                            </div>    
                            <div class="form-group">
                                    <label for="account_assign" class="col-md-3">Account Assignment Group</label>
                                    <div class="col-md-9">
                                    <input type="text" class="form-control input-sm" name="account_assign" id="account_assign" value="{{ $account_assign }}" required readonly>
                                </div>
                            </div>   
                            <div class="form-group">
                                <label for="item_category_group" class="col-md-3">Item Category Group</label>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control input-sm" name="item_category_group" id="item_category_group" value="{{ $item_cat }}"   required readonly>
                                </div>
                            </div>     
                            <div class="form-group">
                                <label for="availability_check" class="col-md-3">Availability Check</label>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control input-sm" name="availability_check" id="availability_check" value="{{ $avail_check }}" required readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="transportation_group" class="col-md-3">Transportation Group</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control input-sm" name="transportation_group" value="{{$trans_group }}" id="transportation_group" required readonly>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="loading_group" class="col-md-3">Loading Group</label>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control input-sm" name="loading_group" id="loading_group" value="{{ $loading_group }}"  readonly>
                                </div>
                            </div>            
                            <div class="form-group">
                                <label for="profit_center" class="col-md-3">Profit Center</label>
                                    <div class="col-md-9">
                                    <input type="text" class="form-control input-sm" name="profit_center" id="profit_center" value="{{ $profit_center }}"  required readonly>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="mrp_type" class="col-md-3">MRP Type</label>
                                    <div class="col-md-9"> 
                                    <input type="text" class="form-control input-sm" name="mrp_type" id="mrp_type" value="{{ $mrp_type }}"  required readonly>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="period_ind_for_sle" class="col-md-3">Period Ind. for SLE</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control input-sm" name="period_ind_for_sle" value="{{ $sle }}" id="period_ind_for_sle" required readonly>
                                </div>
                            </div>  
                            <div class="form-group">
                                    <label for="price_unit" class="col-md-3">Price Unit</label>
                                    <div class="col-md-4"> 
                                    <input type="number" class="form-control input-sm" name="price_unit" id="price_unit" value="{{ $price_unit }}" required readonly>
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
                                        <input type="text" class="form-control input-sm" name="group_material" id="group_material" value="{{ $mat_group_name }}" readonly>
                                        <input type="hidden" name="group_material_id" id="group_material_id"  readonly>
                                         <input type="hidden" name="no_material" value="{{ $material->no_material }}">
                                        <span class="input-group-btn hide">
                                            <button type="button" class="btn btn-default btn-flat btn-group-material"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>    
                                <div class="form-group material-group-input" id="input-description">  
                                    
                                    <label for="part_no" class="col-md-3">Description</label>
                                    <div class="col-md-9">  
                                        <input type="text" class="form-control input-sm attr-material-group" value="{{ $material->description }}" name="description" id="description" autocomplete="off">
                                    </div>
                                </div>   
                                <div class="form-group material-group-input" id="input-part-no">
                                    <label for="part_no" class="col-md-3">Part Number</label>
                                        <div class="col-md-9"> 
                                        <input type="text" class="form-control input-sm attr-material-group" value="{{ $material->part_number }}" name="part_no" id="part_no"  autocomplete="off">
                                    </div>
                                </div> 
                                <div class="form-group material-group-input" id="input-specification">
                                    <label for="part_no" class="col-md-3 col-form-label">Spesifikasi</label>
                                    <div class="col-md-9"> 
                                        <input type="text" class="form-control input-sm attr-material-group" value="{{ $material->spec }}" name="specification"  id="specification" >
                                    </div>
                                </div> 
                                <div class="form-group material-group-input" id="input-merk">
                                        <label for="brand" class="col-md-3">Merk</label>
                                            <div class="col-md-4">    
                                        <input type="text" class="form-control input-sm attr-material-group" name="merk"  id="merk" value="{{ $material->merk }}" >
                                    </div>
                                </div> 
                                <div class="form-group ">
                                    <label for="material_sap" class="col-md-3">Material pada SAP</label>
                                        <div class="col-md-9">
                                        <input type="text" class="form-control input-sm" name="material_sap" value="{{ $material->material_name }}"  id="material_sap" maxlength="30"  readonly>
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
                                        <input type="text" class="form-control input-sm" name="gross_weight" id="gross_weight" value="{{ ($material->gross_weight ? $material->gross_weight:0) }}" autocomplete="off" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="net_weight" class="col-md-3">Net Weight</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="net_weight" id="net_weight" value="{{ ($material->net_weight ? $material->net_weight:0) }}" autocomplete="off" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="volume" class="col-md-3">Volume</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="volume" id="volume" onkeypress="return isNumber(event)" value="{{ ($material->volume ? $material->volume:0) }}" autocomplete="off" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="size" class="col-md-3">Size/Dimension</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="size" id="size" maxlength="30" value="{{ ($material->size_dimension ? $material->size_dimension:0) }}" autocomplete="off" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="weight_unit" class="col-md-3">Weight Unit</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="weight_unit" id="weight_unit" value="{{ ($material->weight_unit ? $material->weight_unit:0) }}" autocomplete="off" maxlength="10" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="volume_unit" class="col-md-3">Volume Unit</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control input-sm" name="volume_unit" id="volume_unit" value="{{ ($material->volume_unit ? $material->volume_unit:0) }}" autocomplete="off" maxlength="10" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="volume_unit" class="col-md-3">Remarks</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control input-sm" name="remarks" id="remarks">{{ $material->remarks }}</textarea>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="volume_unit" class="col-md-3">Image</label>
                                    <div  class="col-md-9">
                                         <div id="filesContainer">
                                               
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
    var no_mat = '{{ $material->no_material }}';
    var addFile = 1;
    jQuery(document).ready(function() {
        jQuery(".btn-cancel").on('click', function() {
            window.location.href = "{{ url('editmaterial') }}";
        });

        SelectGroup('{{ $material->mat_group }}');
         jQuery('#form-basic-data').on('submit', function(e) {
            e.preventDefault();
           jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var param = new FormData(this);
            jQuery.ajax({
				url:"{{ url('editmaterial/post') }}",
			    type:"POST",
				data: param,
				contentType:false,
				processData:false,
				cache:false,
				beforeSend:function(){jQuery('.loading-event').fadeIn();},
				success:function(result){
                    if(result.code == '201'){
                        notify({
                            type:'success',
                            message:result.message
                        });
                        window.location.href = "{{ url('editmaterial') }}";
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

        initFiles();

        var uom = dataJson('{!! route('get.uom') !!}');
        jQuery('#uom').select2({
            data: uom,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });

        jQuery('#uom').val('{{ $material->uom }}');
        jQuery('#uom').trigger('change');

        jQuery('#form-initial').on('submit', function(e){
            e.preventDefault();
            basicDataPanel();
        });

        jQuery('.attr-material-group').on('keyup', function(){
            genMaterialNo();
        })

        
        jQuery('#form-basic-data').on('submit', function(e){
            e.preventDefault();
        });

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
            event.preventDefault();
            return false;
            }
        });

    });

    function openFile(id) {
        jQuery("#files_" + id).trigger('click');
    }

    function closeGroupMaterialModal() {
         $('#group-material-modal').on('hidden.bs.modal', function(event) {
            $('#add-data-modal').off('hidden.bs.modal');
            jQuery('#add-data-modal').modal({backdrop: 'static', keyboard: false});
            jQuery('#add-data-modal').modal('show');
        }).modal('hide');
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
            help_material_sap = 'deskripsi material';
            jQuery("#input-description").addClass("has-success");
            jQuery("#description").prop("required",true);
        }
         jQuery(".material-group-input").trigger('change'); 
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
        jQuery('.panel-initial').click();
        topFunction();
    }
  
    function basicDataPanel() {
        jQuery('.panel-basic-data').click();
        topFunction();
    }
    

    function initFiles() {
        var files = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.editmaterialfiles') !!}?no_mat=' + no_mat))); 
        var content = ''; 
        jQuery.each(files, function(key, val) {
            content +='<div class="col-md-4" id="panel-image-' + addFile + '">';
            content +='<div class="form-group hide">';
            content +='<input type="file" id="files_' + addFile + '" name="files_' + addFile + '" accept="image/*"  OnChange="showImage(' + addFile + ')">';
            content +='<input type="hidden" name="file_id_' + addFile + '" id="file_id_' + addFile + '" value="' + val.id + '">';
            content +='<input type="hidden" name="file_deleted_' + addFile + '" id="file_deleted_' + addFile + '">';
            content +='<input type="hidden" name="data_files[]" value="' + addFile + '">';
            content +='<p class="help-block">*jpg, png</p>';
            content +='</div>';
            content +='<div class="image-group">';
            content +='<button type="button" class="btn btn-danger btn-xs btn-flat btn-add-file-image btn-remove-image' + addFile + ' " OnClick="removeImage(' + addFile + ')"><i class="fa fa-trash"></i></button>';
            content +='<img id="material-images-' + addFile + '" title="click to change image"  data-status="0" style="cursor:pointer" OnClick="openFile(' + addFile + ')" class="img-responsive select-img" src="' + val.file_image + '">';
            content +='</div>'; 
            content +='</div>'; 
            addFile++;
        });
        jQuery('#filesContainer').append(content);
        genAddFile();
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
        var file_id = jQuery("#file_id_" + id).val();

        if(file_id) {
            jQuery('#panel-image-' + id).addClass('hide');
            jQuery('#file_deleted_' + id).val(1);
        } else {
            jQuery('#panel-image-' + id).remove();
        }
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
            content +='<input type="hidden" name="file_id_' + addFile + '" id="file_id_' + addFile + '" value="">';
            content +='<input type="hidden" name="file_deleted_' + addFile + '" id="file_deleted_' + addFile + '">';
            content +='<input type="hidden" name="data_files[]" value="' + addFile + '">';
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

</script>            
@stop