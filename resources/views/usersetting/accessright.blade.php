@extends('adminlte::page')
@section('title', 'FMDB - Access right')
@section('content')
<section class="content">
       <div class="row">
        <div class="col-xs-4">
            <span style="font-size:24px">Access Right</span>
        </div>
        <div class="col-xs-8" align="right">
            <span href="#" class="btn btn-sm btn-flat btn-success btn-add {{ (isset($access['CREATE']) ? '':'hide') }}">&nbsp;<i class="glyphicon glyphicon-plus" title="Add new data"></i>&nbsp; Add</span>
        </div>
    </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
             <div class="box-body">
                <table id="data-table" class="table table-bordered table-hover table-condensed" width="100%">
                    <thead>
                        <tr>
                            <th width="30%">Role</th>
                            <th>Menu</th>
                            <th>Operation</th>
                            <th>Description</th>
                            <th width="8%">Action</th>
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
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Role</label> 
                             <select class="form-control select2" name='role_id' id="role_id" requried>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Menu</label> 
                            <select class="form-control select2" name='menu' id="menu" maxlength="200" requried>
                                <option></option>
                            </select>
                             <input type="hidden" name='edit_id' id="edit_id">
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Operation</label> 
                            <select class="form-control select2" name='operation' id="operation" required>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Description</label> 
                            <textarea class="form-control" name='description' id="description"  requried></textarea>
                        </div>
                    </div>	 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-flat btn-success" style="margin-right: 5px;">Submit</button>
                </div>
            </form>
		</div>
    </div>
</div>
@stop
@section('js')
<script>
    var attribute = [];
    jQuery(document).ready(function() {
         jQuery('#data-table').DataTable({
            ajax: '{!! route('get.accessright_grid') !!}',
            columns: [
                { data: 'role_name', name: 'role_name' },
                { data: 'menu_name', name: 'menu_name' },
                { data: 'operation', name: 'operation' },
                { data: 'description', name: 'description' },
                {
                    "render": function (data, type, row) {
                        var content = '<button class="btn btn-flat btn-xs btn-success btn-action btn-edit {{ (isset($access['UPDATE']) ? '':'hide') }}" title="edit data ' + row.id + '" onClick="edit(\'' + row.id_role +"-"+ row.menu_code+ '-' + row.operation + '\')"><i class="fa fa-pencil"></i></button>';
                            content += '<button class="btn btn-flat btn-xs btn-danger btn-action btn-activated {{ (isset($access['DELETE']) ? '':'hide') }}" style="margin-left:5px"  onClick="inactive(\'' + row.id_role +"-"+ row.menu_code+ '-' + row.operation + '\')"><i class="fa fa-trash"></i></button>';
                        
                        return content;
                    }
                } 
            ],
             columnDefs: [
                { targets: [4], className: 'text-center', orderable: false},
            ]
        });

        var role = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.select_role') !!}')));
        jQuery('#role_id').select2({
            data: role,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        }); 
       
        var menu = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.select_menu') !!}')));
        jQuery('#menu').select2({
            data: menu,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        }); 
       
        jQuery('#operation').select2({
            data: [
                {id: 'CREATE', text: 'CREATE'},
                {id: 'READ', text: 'READ'},
                {id: 'UPDATE', text: 'UPDATE'},
                {id: 'DELETE', text: 'DELETE'}
            ],
            width:'100%',
            placeholder: ' ',
            allowClear: true
        }); 

        jQuery('.btn-add').on('click', function() {
            document.getElementById("data-form").reset();
            jQuery('#menu').select2('val', '');
            jQuery('#menu').trigger('change');
            jQuery('#role_id').select2('val', '');
            jQuery('#role_id').trigger('change');
            jQuery('#operation').select2('val', '');
            jQuery('#operation').trigger('change');

            jQuery('#role_id').prop('disabled',false);
            jQuery("#edit_id").val("");
            jQuery("#add-data-modal").modal({backdrop:'static', keyboard:false});		
            jQuery("#add-data-modal .modal-title").html("<i class='fa fa-plus'></i> Create new data");		
            jQuery("#add-data-modal").modal("show");		
        });
        
        jQuery('.btn-edit').on('click', function() {
            jQuery("#add-data-modal").modal({backdrop:'static', keyboard:false});		
            jQuery("#add-data-modal .modal-title").html("<i class='fa fa-pencil'></i> Edit data");		
            jQuery("#add-data-modal").modal("show");		
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
				url:"{{ url('accessright/post') }}",
				method:"POST",
				data: param,
				beforeSend:function(){ jQuery('.loading-event').fadeIn();},
				success:function(result){
                    if(result.status){
                        if(result.exist) {
                             notify({
                                type:'warning',
                                message:result.message
                            });
                        }else{
                            jQuery("#add-data-modal").modal("hide");
                            jQuery("#data-table").DataTable().ajax.reload();
                            notify({
                                type:'success',
                                message:result.message
                            });
                        }
                    }else{
                        notify({
                            type:'warning',
                            message:result.message
                        });
                    } 
				},
				complete:function(){ jQuery('.loading-event').fadeOut();}
			 }); 
        })
    });

    function edit(row) {
        document.getElementById("data-form").reset();
        var result = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('accessright/edit/?id=') }}"+row)));
        console.log(result);
        jQuery("#edit_id").val(row);
        jQuery('#menu').select2('val', result.menu_code);
        jQuery('#menu').trigger('change');
        jQuery('#role_id').select2('val', result.id_role);
        jQuery('#role_id').trigger('change');
        jQuery('#operation').select2('val', result.operation);
        jQuery('#operation').trigger('change');
        jQuery('#description').val(result.description);

        jQuery("#add-data-modal .modal-title").html("<i class='fa fa-edit'></i> Update data " + result.role_name);			
        jQuery("#add-data-modal").modal("show");
    }

    function inactive(id) {
        var conf = confirm("anda yakin mau menghapus data ini?");
		if (conf == true) { 
             jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url:"{{ url('accessright/inactive') }}",
            method:"POST",
            data: {id:id},
            beforeSend:function(){ jQuery('.loading-event').fadeIn();},
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
            complete:function(){ jQuery('.loading-event').fadeOut();}
        });   
        } 
    }


</script>            
@stop