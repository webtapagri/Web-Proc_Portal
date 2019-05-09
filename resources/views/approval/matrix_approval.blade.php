@extends('adminlte::page')
@section('title', 'FMDB - Matrix Approval')
@section('content')

<section class="content">
    <div class="row">
        <div class="col-xs-4">
            <span style="font-size:24px">Matrix Approval</span>
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
                                <th>MRP</th>
                                <th>Material Group</th>
                                <th>Role</th>
                                <th>Sequence</th>
                                <th>Operation</th>
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
                            <label class="control-label" for="name">MRP</label>
                            <select class="form-control" name='mrp' id="mrp" requried>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Material Group</label>
                            <input type="hidden" name='edit_id' id="edit_id">
                            <select class="form-control" name='mat_group' id="mat_group" requried>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Role</label>
                            <select class="form-control" name='role_id' id="role_id" requried>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <label class="control-label" for="name">Sequence</label>
                            <input type="text" class="form-control" name='sequence' id="sequence" requried="required" maxlength="2" onkeypress="return isNumber(event)" onpaste="return false" ondrop="return false">
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Operation</label>
                            <select class="form-control" name='operation' id="operation" requried>
                                <option></option>
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
            ajax: '{!! route("get.matrixapproval_grid") !!}',
            columns: [
                {
                  "render": function(data, type, row) {
                      return (row.mrp == "ALL" ? "ALL":row.mrp + (row.mrp_controller_name ? ' - ' + row.mrp_controller_name:''));
                  }
                },
                {
                     "render": function(data, type, row) {
                         return row.mat_group + (row.material_group_name ? ' - ' + row.material_group_name:'') ;
                     }
                },
                {
                    "render": function(data, type, row) {
                         return row.role_id + (row.role_name ? ' - ' + row.role_name:'') ;
                     }
                },
                {
                    data: 'seq',
                    name: 'seq'
                },
                {
                    data: 'operation',
                    name: 'operation'
                },
                {
                    "render": function(data, type, row) {
                        var content = '<button class="btn btn-flat btn-xs btn-success btn-action btn-edit {{ (isset($access['UPDATE']) ? '':'hide') }}" title="edit data ' + row.mat_group + '" onClick="edit(\'' + row.id + '\')"><i class="fa fa-pencil"></i></button>';
                        content += '<button class="btn btn-flat btn-xs btn-danger btn-action btn-activated {{ (isset($access['DELETE']) ? '':'hide ') }}" style="margin-left:5px"  onClick="inactive(\'' + row.id + '\')"><i class="fa fa-trash"></i></button>';
                        return content;
                    }
                }
            ],
            columnDefs: [{
                targets: [5],
                className: 'text-center',
                orderable: false
            }, ]
        });

        var mat_group = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'mat_group'
        });

        jQuery('#mat_group').select2({
            data: mat_group,
            width: '100%',
            placeholder: ' ',
            allowClear: true
        })

        var plant = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'plant'
        });

        jQuery('#plant').select2({
            data: plant,
            width: '100%',
            placeholder: ' ',
            allowClear: true
        });

        var mrp_controller = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'mrp_controller'
        });

        jQuery('#mrp').select2({
            data: mrp_controller,
            width: '100%',
            placeholder: ' ',
            allowClear: true
        });

        var role = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.select_role') !!}')));
        jQuery('#role_id').select2({
            data: role,
            width: '100%',
            placeholder: ' ',
            allowClear: true
        });
        
        jQuery('#operation').select2({
            data: [
                {id:'AND', text: 'AND'},
                {id:'OR', text: 'OR'},
            ],
            width: '100%',
            placeholder: ' ',
            allowClear: true
        });

        jQuery('.btn-add').on('click', function() {
            clearForm();
            jQuery('#code').prop('disabled', false);
            jQuery("#edit_id").val("");
            jQuery("#add-data-modal").modal({
                backdrop: 'static',
                keyboard: false
            });
            jQuery("#add-data-modal .modal-title").html("<i class='fa fa-plus'></i> Create new data");
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
                url: "{{ url('matrixapproval/post') }}",
                method: "POST",
                data: param,
                beforeSend: function() {
                    jQuery('.loading-event').fadeIn();
                },
                success: function(result) {
                    if (result.status) {
                        jQuery("#add-data-modal").modal("hide");
                        jQuery("#data-table").DataTable().ajax.reload();
                        notify({
                            type: 'success',
                            message: result.message
                        });
                    } else {
                        notify({
                            type: 'warning',
                            message: result.message
                        });
                    }
                },
                complete: function() {
                    jQuery('.loading-event').fadeOut();
                }
            });
        })
    });

    function edit(id) {
        clearForm();
        jQuery("#edit_id").val(id);
        jQuery('#code').prop('disabled', true);
        var result = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('matrixapproval/edit/?id=') }}" + id)));
        jQuery("#sequence").val(result[0].seq);

        jQuery('#mat_group').val(result[0].mat_group);
        jQuery('#mat_group').trigger('change');

        jQuery('#mrp').val(result[0].mrp);
        jQuery('#mrp').trigger('change');

        jQuery('#role_id').val(result[0].role_id);
        jQuery('#role_id').trigger('change');

        jQuery('#operation').val(result[0].operation);
        jQuery('#operation').trigger('change');

        jQuery("#add-data-modal .modal-title").html("<i class='fa fa-edit'></i> Update data " + result[0].plant);
        jQuery("#add-data-modal").modal("show");
    }

    function clearForm() {
        document.getElementById("data-form").reset();
        jQuery('#mat_group').val('');
        jQuery('#mat_group').trigger('change');
        jQuery('#mrp').val('');
        jQuery('#mrp').trigger('change');
        jQuery('#role_id').val('');
        jQuery('#role_id').trigger('change');
        jQuery('#operation').val('');
        jQuery('#operation').trigger('change');
        jQuery("#edit_id").val("");
    }

    function inactive(id) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "{{ url('matrixapproval/inactive') }}",
            method: "POST",
            data: {
                id: id
            },
            beforeSend: function() {
                jQuery('.loading-event').fadeIn();
            },
            success: function(result) {
                if (result.status) {
                    jQuery("#data-table").DataTable().ajax.reload();
                    notify({
                        type: 'success',
                        message: result.message
                    });
                } else {
                    notify({
                        type: 'warning',
                        message: result.message
                    });
                }
            },
            complete: function() {
                jQuery('.loading-event').fadeOut();
            }
        });
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