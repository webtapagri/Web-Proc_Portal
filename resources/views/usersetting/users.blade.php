@extends('adminlte::page')
@section('title', 'FMDB - Users')
@section('content')
<section class="content">
       <div class="row">
        <div class="col-xs-4">
            <span style="font-size:24px">Users</span>
        </div>
        <div class="col-xs-8" align="right">
            <span href="#" class="btn btn-flat btn-sm btn-flat btn-success btn-add {{ (isset($access['CREATE']) ? '':'hide') }}">&nbsp;<i class="glyphicon glyphicon-plus" title="Add new data"></i>&nbsp; Add</span>
        </div>
    </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
             <div class="box-body">
                <table id="data-table" class="table table-bordered table-hover table-condensed" width="100%">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Job Code</th>
                            <th>NIK</th>
                            <th>Area Code</th>
                            <th width="10%">Active</th>
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
                            <label class="control-label" for="name">Username</label> 
                            <input type="text" class="form-control" name="username" id="username" maxlength="50" required>
                            <input type="hidden" name='edit_id' id="edit_id">
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Nama</label> 
                            <input class="form-control" name='name' id="name" maxlength="200" requried>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Email</label> 
                            <input type="email" class="form-control"  name='email' id="email" maxlength="250">
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Job Code</label> 
                            <input type="text" class="form-control"  name='job_code' id="job_code" maxlength="150">
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">NIK</label> 
                            <input type="text" class="form-control"  name='nik' id="nik" maxlength="80">
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Area Code</label> 
                            <select class="form-control"  name='area_code[]' id="area_code" multiple="multiple" maxlength="200" required="reqreuid">

                            </select>
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
            ajax: '{!! route('get.grid_tr_user') !!}',
            columns: [
                { data: 'username', name: 'username' },
                { data: 'nama', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'job_code', name: 'job_code' },
                { data: 'nik', name: 'nik' },
                { data: 'area_code', name: 'area_code' },
                {  
                    "render": function (data, type, row) {
                        if(row.fl_active == 1) {
                            var content = '<span class="badge bg-green">Y</span>';
                        } else{
                            var content = '<span class="badge bg-grey">N</span>';
                        }    
                        return content;
                    } 
                },
                {
                    "render": function (data, type, row) {
                        var content = '<button class="btn btn-flat btn-flat btn-xs btn-success btn-action btn-edit {{ (isset($access['UPDATE']) ? '':'hide') }}" title="edit data ' + row.mat_group + '" onClick="edit(' + row.id + ')"><i class="fa fa-pencil"></i></button>';
                            content += '<button class="btn btn-flat btn-flat btn-xs btn-danger btn-action btn-activated {{ (isset($access['DELETE']) ? '':'hide') }} ' + (row.fl_active == 1 ? '' : 'hide') + '" style="margin-left:5px" onClick="inactive(' + row.id + ')"><i class="fa fa-trash"></i></button>';
                            content += '<button class="btn btn-flat btn-flat btn-xs btn-success btn-action btn-inactivated {{ (isset($access['DELETE']) ? '':'hide') }} ' + (row.fl_active == 0 ? '': 'hide') + '" style="margin-left:5px"  onClick="active(' + row.id + ')"><i class="fa fa-check"></i></button>';
                        
                        return content;
                    }
                } 
            ],
             columnDefs: [
                { targets: [7], className: 'text-center', orderable: false},
                { targets: [6], className: 'text-center'}
            ]
        }); 

        var plant = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'plant'
        });
        
        jQuery('#area_code').select2({
            data:plant,
            width:'100%',
            placeholder: ' ',
            allowClear: true
        })

        jQuery('.btn-add').on('click', function() {
            document.getElementById("data-form").reset();
            jQuery("#area_code").val('');
            jQuery("#area_code").trigger('change');
            jQuery('#username').prop("readonly", false);
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
				url:"{{ url('users/post') }}",
				method:"POST",
				data: param,
				beforeSend:function(){ jQuery('.loading-event').fadeIn();},
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
				complete:function(){ jQuery('.loading-event').fadeOut();}
			 }); 
            
            
        })
    });

    function edit(id) {
        document.getElementById("data-form").reset();
        jQuery("#area_code").val('');
        jQuery("#area_code").trigger('change');

        jQuery("#edit_id").val(id);
        jQuery('#username').prop("readonly", true);
        var result = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('users/edit/?id=') }}"+id)));
        jQuery("#edit_id").val(result.id);
        jQuery("#username").val(result.username);
        jQuery("#name").val(result.nama);
        jQuery("#email").val(result.email);
        jQuery("#job_code").val(result.job_code);
        jQuery("#nik").val(result.nik);
        var area_code = result.area_code;
        jQuery("#area_code").val(area_code.split(','));
        jQuery("#area_code").trigger('change');

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
            url:"{{ url('users/inactive') }}",
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
    
    function active(id) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url:"{{ url('users/active') }}",
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
</script>            
@stop