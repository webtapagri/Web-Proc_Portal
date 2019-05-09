@extends('adminlte::page')
@section('title', 'FMDB - Mapping MRP')
@section('content')

<section class="content">
    <div class="row">
        <div class="col-xs-4">
            <span style="font-size:24px">Mapping MRP</span>
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
                                <th>Plant</th>
                                <th>Material Group</th>
                                <th>MRP Controller</th>
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
                            <label class="control-label" for="name">Plant</label>
                            <select class="form-control" name='plant' id="plant" requried>
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
                            <label class="control-label" for="name">MRP Controller</label>
                            <select class="form-control" name='mrp_controller' id="mrp_controller" requried>
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
            ajax: '{!! route("get.mappingmrp_grid") !!}',
            columns: [{
                    data: 'plant_name',
                    name: 'plant_name'
                },
                {
                    data: 'material_group_name',
                    name: 'material_group_name'
                },
                {
                    data: 'mrp_controller_name',
                    name: 'mrp_controller_name'
                },
                {
                    "render": function(data, type, row) {
                        var content = '<button class="btn btn-flat btn-xs btn-success btn-action btn-edit {{ (isset($access['UPDATE']) ? '':'hide ') }}" title="edit data ' + row.mat_group + '" onClick="edit(\'' + row.plant + '/'+ row.mat_group +'\')"><i class="fa fa-pencil"></i></button>';
                        content += '<button class="btn btn-flat btn-xs btn-danger btn-action btn-activated {{ (isset($access['DELETE']) ? '':'hide ') }}" style="margin-left:5px"  onClick="inactive(\'' + row.plant + '/'+ row.mat_group + '/' + row.mrp_controller +'\')"><i class="fa fa-trash"></i></button>';
                        return content;
                    }
                }
            ],
            columnDefs: [{
                targets: [3],
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

        jQuery('#mrp_controller').select2({
            data: mrp_controller,
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
                url: "{{ url('mappingmrp/post') }}",
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
        var result = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('mappingmrp/edit/?id=') }}" + id)));
        jQuery("#edit_id").val(result.menu_code);
        
        jQuery('#mat_group').val(result[0].mat_group);
        jQuery('#mat_group').trigger('change');

        jQuery('#plant').val(result[0].plant);
        jQuery('#plant').trigger('change');
        jQuery('#mrp_controller').val(result[0].mrp_controller);
        jQuery('#mrp_controller').trigger('change');

        jQuery("#add-data-modal .modal-title").html("<i class='fa fa-edit'></i> Update data " + result[0].plant);
        jQuery("#add-data-modal").modal("show");
    }

    function clearForm() {
        document.getElementById("data-form").reset();
        jQuery('#mat_group').val('');
        jQuery('#mat_group').trigger('change');
        jQuery('#plant').val('');
        jQuery('#plant').trigger('change');
        jQuery('#mrp_controller').val('');
        jQuery('#mrp_controller').trigger('change');
        jQuery("#edit_id").val("");
    }

    function inactive(id) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "{{ url('mappingmrp/inactive') }}",
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
</script>
@stop 