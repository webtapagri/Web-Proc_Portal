@extends('adminlte::page')
@section('title', 'FMDB - Mapping MRP')
@section('content')

<section class="content">
    <div class="row">
        <div class="col-xs-4">
            <span style="font-size:24px">Mapping Plant</span>
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
                                <th>Locat</th>
                                <th>Store Loc</th>
                                <th>Sales Org</th>
                                <th>Profit Center</th>
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
                            <label class="control-label" for="name">Locat</label>
                            <input type="hidden" name='edit_id' id="edit_id">
                            <select class="form-control" name='locat' id="locat" requried>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Store Loc</label>
                            <select class="form-control" name='store_loc' id="store_loc" requried>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Sales ORG</label>
                            <select class="form-control" name='sales_org' id="sales_org" requried>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <label class="control-label" for="name">Profit Center</label>
                            <select class="form-control" name='profit_center' id="profit_center" requried>
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
            ajax: '{!! route("get.mappingplant_grid") !!}',
            columns: [{
                   "render": function(data, type, row) {
                         return row.plant + (row.plant_name ? ' - ' + row.plant_name:'') ;
                     }
                },
                {
                    data: 'locat_name',
                    name: 'locat_name'
                },
                {
                    data: 'store_loc_name',
                    name: 'store_loc_name'
                },
                {
                    data: 'sales_org_name',
                    name: 'sales_org_name'
                },
                {
                    data: 'profit_center_name',
                    name: 'profit_center_name'
                },
                {
                    "render": function(data, type, row) {
                        var content = '<button class="btn btn-flat btn-xs btn-success btn-action btn-edit {{ (isset($access['UPDATE']) ? '':'hide ') }}" title="edit data ' + row.plant_name + '" onClick="edit(\'' + row.plant  +'\')"><i class="fa fa-pencil"></i></button>';
                        content += '<button class="btn btn-flat btn-xs btn-danger btn-action btn-activated {{ (isset($access['DELETE']) ? '':'hide ') }}" style="margin-left:5px"  onClick="inactive(\'' + row.plant  +'\')"><i class="fa fa-trash"></i></button>';
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

        var locat = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'location'
        });

        jQuery('#locat').select2({
            data: locat,
            width: '100%',
            placeholder: ' ',
            allowClear: true
        });

        var plant = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'plant'
        });

        jQuery('#plant').select2({
            data: plant,
            width: '100%',
            placeholder: ' ',
            allowClear: true
        }).on('change', function() {
              var store_location = dataJson("{{ url('materialrequest/store_location/?id=') }}"+jQuery(this).val());
            jQuery('#store_loc').select2({
                data: store_location,
                width:'100%',
                placeholder: "",
                allowClear: true
            });
        })

        var sales_org = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'sales_org'
        });

        jQuery('#sales_org').select2({
            data: sales_org,
            width: '100%',
            placeholder: ' ',
            allowClear: true
        });

        var profit_center = makeSelectFromgeneralData({
            url: "{{ url('/select2') }}",
            code: 'profit_center'
        });

        jQuery('#profit_center').select2({
            data: profit_center,
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
                url: "{{ url('mappingplant/post') }}",
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
        var result = jQuery.parseJSON(JSON.stringify(dataJson("{{ url('mappingplant/edit/?id=') }}" + id)));
        jQuery("#edit_id").val(result[0].plant);
        

        jQuery('#plant').val(result[0].plant);
        jQuery('#plant').trigger('change');
        
        jQuery('#sales_org').trigger('change');
        jQuery('#store_loc').val(result[0].store_loc);
        jQuery('#store_loc').trigger('change');
        jQuery('#profit_center').val(result[0].profit_center);
        jQuery('#profit_center').trigger('change');
        jQuery('#locat').val(result[0].locat);
        jQuery('#locat').trigger('change');

        jQuery("#add-data-modal .modal-title").html("<i class='fa fa-edit'></i> Update data " + result[0].plant);
        jQuery("#add-data-modal").modal("show");
    }

    function clearForm() {
        document.getElementById("data-form").reset();
        jQuery('#plant').val('');
        jQuery('#plant').trigger('change');
        jQuery('#sales_org').val('');
        jQuery('#sales_org').trigger('change');
        jQuery('#store_loc').val('');
        jQuery('#store_loc').trigger('change');
        jQuery('#profit_center').val('');
        jQuery('#profit_center').trigger('change');
        jQuery('#locat').val('');
        jQuery('#locat').trigger('change');
        jQuery("#edit_id").val("");
    }

    function inactive(id) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "{{ url('mappingplant/inactive') }}",
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