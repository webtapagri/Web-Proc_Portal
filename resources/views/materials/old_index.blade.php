@extends('adminlte::page')

@section('title', 'FMDB')

@section('content')
<section class="content">
       <div class="row">
        <div class="col-xs-4">
            <span style="font-size:24px">&nbsp; Materilas</span>
        </div>
        <div class="col-xs-8" align="right">
            <span href="#" class="btn btn-sm btn-success btn-add">&nbsp;<i class="glyphicon glyphicon-plus" title="Add new data"></i>&nbsp; Add</span>
        </div>
    </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
             <div class="box-body">
                <table id="data-table" class="table table-bordered table-condensed" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center;" width="width:3%">No</th>
                            <th>Material No</th>
                            <th>sector</th>
                            <th>Group</th>
                            <th>Deskripsi</th>
                            <th>Part no</th>
                            <th>Spesifikasi</th>
                            <th>Merek</th>
                            <th>SAP</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th width="8%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- /.box-body -->
            </div>
          </div>
        </div>
      </div>
</section>
<div id="add-data-modal" class="modal fade" role="dialog">
    <div class="modal-dialog" width="900px">
		<div class="modal-content">
			<div class="modal-header">	
				<h4 class="modal-title"></h4>
			</div>
            <form id="data-form">
                	<div class="modal-body">	
                        <div class="box-body">
                            <div class="form-group row">
                                <label for="material_no" class="col-sm-3 col-form-label">Material number</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="material_no" id="material_no" required>
                                    <input type="hidden" name="edit_id" id="edit_id">
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="sector_industry" class="col-sm-3 col-form-label">Industri sector</label>
                                <div class="col-sm-6">
                                    <select type="text" class="form-control" name="sector_industry" id="sector_industry"  ></select>
                                </div>
                            </div> 
                            <br>
                            <h5>MATERIAL INFORMATION</h5>
                        <div class="row">
                                <div class="form-group">
                                <label for="group_material"  class="col-sm-3 col-form-label">Group Material</label>
                                <div class="input-group col-sm-6" style="padding-left:16px">
                                    <input type="text" class="form-control" name="group_material" id="group_material" readonly>
                                    <input type="hidden" name="group_material_id" id="group_material_id" readonly>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-group-material"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                            <div class="form-group row material-group-input" id="input-description">
                                <label for="part_no" class="col-sm-3 col-form-label">Deskripsi Material</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control attr-material-group" name="description" id="description" autocomplete="off">
                                </div>
                            </div> 
                            <div class="form-group row material-group-input" id="input-part-no">
                                <label for="part_no" class="col-sm-3 col-form-label">Part Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control attr-material-group" name="part_no" id="part_no"  autocomplete="off">
                                </div>
                            </div> 
                            <div class="form-group row material-group-input" id="input-specification">
                                <label for="part_no" class="col-sm-3 col-md-3 col-form-label">Spesifikasi</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control attr-material-group" name="specification"  id="specification" >
                                </div>
                            </div> 
                            <div class="form-group row material-group-input" id="input-brand">
                                <label for="brand" class="col-sm-3 col-form-label">Merk</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control attr-material-group" name="brand"  id="brand"  >
                                </div>
                            </div> 
                            <div class="form-group row ">
                                <label for="material_sap" class="col-sm-3 col-form-label">Material pada SAP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="material_sap"  id="material_sap"  readonly>
                                    <span class="help-block" id="help_material_sap"></span>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="uom" class="col-sm-3 col-form-label">Satuan</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="uom" id="uom" ></select>
                                </div>
                            </div> 
                        </div>	 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" style="margin-right: 5px;">Save</button>
                    </div>
            </form>
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
                                <th>Name</th>
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
    var selected_material_group = "";
    jQuery(document).ready(function() {
        jQuery('#data-table').DataTable({
            ajax: '{!! route('get.material') !!}',
            columns: [
                { data: 'no', name: 'no' },
                { data: 'material_no', name: 'material_no' },
                { data: 'sector_industry', name: 'sector_industry' },
                { data: 'group_material', name: 'group_material' },
                { data: 'description', name: 'description' },
                { data: 'part_no', name: 'part_no' },
                { data: 'specification', name: 'specification' },
                { data: 'brand', name: 'brand' },
                { data: 'material_sap', name: 'material_sap' },
                { data: 'uom', name: 'uom' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action' }
            ],
              columnDefs: [
                { targets: [11], className: 'text-center', orderable: false},
                { targets: [0,10], className: 'text-center'}
            ]
        });

        jQuery('#group-material-table').DataTable({
            ajax: '{!! route('get.data_table_group_material') !!}',
            columns: [
                { data: 'no', name: 'no' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'action', name: 'action' }
            ],
              columnDefs: [
                { targets: [3], className: 'text-center', orderable: false},
                { targets: [0], className: 'text-center'}
            ],
            info: false,
            paging: false
        }); 

        jQuery('#uom').select2({
            data: [
                {id:'unt', text:'unit'},
                {id:'bx', text:'Box'},
                {id:'bnd', text:'Bundle'},
                {id:'dz', text:'Dozen'},
                {id:'ctn', text:'Carton'}
            ],
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });
       
        jQuery('#sector_industry').select2({
            data: [
                {id:'Agro Business', text:'Agro Business'},
                {id:'Agro Wisata', text:'Agro Wisata'},
            ],
            width:'100%',
            placeholder: ' ',
            allowClear: true
        });

        jQuery(".attr-material-group").on("keyup", function(){
            genMaterialNo();
        });    

        jQuery('.btn-add').on('click', function() {
            jQuery(".material-group-input").removeClass('has-success');
            jQuery(".attr-material-group").prop("required", false);
            document.getElementById("data-form").reset();
            jQuery("#edit_id").val("");
             jQuery("#add-data-modal .modal-title").html("<i class='fa fa-plus'></i> Create new data");	
            jQuery("#add-data-modal").modal({backdrop:'static', keyboard:false});			
            jQuery("#add-data-modal").modal("show");		
        });
        
        jQuery('.btn-edit').on('click', function() {
            jQuery("#add-data-modal").modal({backdrop:'static', keyboard:false});		
            jQuery("#add-data-modal .modal-title").html("<i class='fa fa-pencil'></i> Edit data");		
            jQuery("#add-data-modal").modal("show");		
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

          jQuery('#data-form').on('submit', function(e) {
            e.preventDefault();
           var param = jQuery(this).serialize();

           jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
				url:"{{ url('materials/post') }}",
				method:"POST",
				data: param,
				beforeSend:function(){},
				success:function(result){
                    if(result.status){
                        jQuery("#add-data-modal").modal("hide");
                        jQuery("#data-table").DataTable().ajax.reload();
                        notify({
                            type:'success',
                            message:result.message
                        });
                    }else{
                        notify({
                            type:'warning',
                            message:result.message
                        });
                    } 
				},
				complete:function(){}
			 });  
        });

    });

    function closeGroupMaterialModal() {
        // jQuery('#group-material-modal').modal('hide');
         $('#group-material-modal').on('hidden.bs.modal', function(event) {

            $('#add-data-modal').off('hidden.bs.modal');
            jQuery('#add-data-modal').modal({backdrop: 'static', keyboard: false});
            jQuery('#add-data-modal').modal('show');
        }).modal('hide');

        	
        //jQuery("#add-data-modal").modal("show");
    }

    function SelectGroup(id, name, attr) {
        jQuery(".material-group-input").removeClass('has-success');
        jQuery(".attr-material-group").prop("required", false);
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
                jQuery("#input-brand").addClass("has-success");
                 jQuery("#brand").prop("required",true);

            }
            no++;
        });
        
        jQuery('#group_material').val(name);
        jQuery('#group_material_id').val(id);
        jQuery("#help_material_sap").text('Pattern: ' + help_material_sap);
        closeGroupMaterialModal();
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
                material_no += jQuery("#brand").val();
            }
            no++;
        });

        jQuery("#material_sap").val(material_no);
    }

    function edit(id) {
        document.getElementById("data-form").reset();

        var result = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('materials/edit/?id=') }}"+id)));
        jQuery.each(result, function(key, val) {
            jQuery("#edit_id").val(val.id);
            jQuery("#material_no").val(val.material_no);
            jQuery("#sector_industry").select2('val',val.sector_industry);
            jQuery("#group_material_id").val(val.group_material_id);
            jQuery("#description").val(val.description);
            jQuery("#part_no").val(val.part_no);
            jQuery("#specification").val(val.specification);
            jQuery("#brand").val(val.brand);
            jQuery("#material_sap").val(val.material_sap);
            jQuery("#unit").select2('val',val.unit);
        });

        var group_material = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('groupmaterials/edit/?id=') }}" + result[0].group_material_id)));
        SelectGroup(group_material[0].id, group_material[0].name, group_material[0].description);
        jQuery("#add-data-modal .modal-title").html("<i class='fa fa-edit'></i> Update data");			
        jQuery("#add-data-modal").modal("show");
    }

      function inactive(id) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url:"{{ url('materials/inactive') }}",
            method:"POST",
            data: {id:id},
            beforeSend:function(){},
            success:function(result){
                if(result.status){
                    jQuery("#data-table").DataTable().ajax.reload();
                    notify({
                        type:'success',
                        message:result.message
                    });
                }else{
                    notify({
                        type:'warning',
                        message:result.message
                    });
                } 
            },
            complete:function(){}
        }); 
    }
    
    function active(id) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url:"{{ url('materials/active') }}",
            method:"POST",
            data: {id:id},
            beforeSend:function(){},
            success:function(result){
                if(result.status){
                    jQuery("#data-table").DataTable().ajax.reload();
                    notify({
                        type:'success',
                        message:result.message
                    });
                }else{
                    notify({
                        type:'warning',
                        message:result.message
                    });
                } 
            },
            complete:function(){}
        }); 
    }

</script>            
@stop