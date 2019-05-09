@extends('adminlte::page')
@section('title', 'FMDB - Mapping Material Group')
@section('content')

<section class="content">
    <div class="row">
        <div class="col-xs-4">
            <span style="font-size:24px">Mapping Material Group</span>
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
                                <th width="">Mat Group</th>
                                <th width="">Valuation Class</th>
                                <th>Material Type</th>
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
                            <label class="control-label" for="name">Material Group</label>
                            <input type="hidden" name='edit_id' id="edit_id">
                            <select class="form-control" name='mat_group' id="mat_group" requried>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Valuation Class</label>
                            <select class="form-control" name='valuation_class' id="valuation_class" requried>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Material Type</label>
                            <select class="form-control" name='material_type' id="material_type" requried>
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
            ajax: '{!! route("get.mappingmatgroup_grid") !!}',
            columns: [{
                    data: 'mat_group_name',
                    name: 'mat_group_name'
                },
                {
                    data: 'valuation_class_name',
                    name: 'valuation_class_name'
                },
                {
                    data: 'material_type_name',
                    name: 'material_type_name'
                },
                {
                    "render": function(data, type, row) {
                        var content = '<button class="btn btn-flat btn-xs btn-success btn-action btn-edit {{ (isset($access['UPDATE']) ? '':'hide ') }}" title="edit data ' + row.mat_group + '" onClick="edit(\'' + row.mat_group + '/'+ row.valuation_class + '/' + row.material_type +'\')"><i class="fa fa-pencil"></i></button>';
                        content += '<button class="btn btn-flat btn-xs btn-danger btn-action btn-activated {{ (isset($access['DELETE']) ? '':'hide ') }}" style="margin-left:5px"  onClick="inactive(\'' + row.mat_group + '/'+ row.valuation_class + '/' + row.material_type +'\')"><i class="fa fa-trash"></i></button>';
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

        var plant = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'mat_group'
        });

        jQuery('#mat_group').select2({
            data: plant,
            width: '100%',
            placeholder: ' ',
            allowClear: true
        })
       
        var plant = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'material_type'
        });

        jQuery('#material_type').select2({
            data: plant,
            width: '100%',
            placeholder: ' ',
            allowClear: true
        });
        var plant = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'valuation_class'
        });

        jQuery('#valuation_class').select2({
            data: plant,
            width: '100%',
            placeholder: ' ',
            allowClear: true
        });

        jQuery('.btn-add').on('click', function() {
            clearForm();
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
                url: "{{ url('mappingmatgroup/post') }}",
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
        var param = id.split('/');
        jQuery("#edit_id").val(id);
        var result = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('mappingmatgroup/edit/?id=') }}" + param[0])));
       
        jQuery('#mat_group').val(result[0].mat_group);
        jQuery('#mat_group').trigger('change');

        jQuery('#valuation_class').val(result[0].valuation_class);
        jQuery('#valuation_class').trigger('change');
        jQuery('#material_type').val(result[0].material_type);
        jQuery('#material_type').trigger('change');

        jQuery("#add-data-modal .modal-title").html("<i class='fa fa-edit'></i> Update data " + result[0].mat_group);
        jQuery("#add-data-modal").modal("show");
    }

    function clearForm() {
        document.getElementById("data-form").reset();
        jQuery('#mat_group').val('');
        jQuery('#mat_group').trigger('change');
        jQuery('#valuation_class').val('');
        jQuery('#valuation_class').trigger('change');
        jQuery('#material_type').val('');
        jQuery('#material_type').trigger('change');
        jQuery("#edit_id").val("");
    }

    function inactive(id) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "{{ url('mappingmatgroup/inactive') }}",
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