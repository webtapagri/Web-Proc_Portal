@extends('adminlte::page')

@section('title', 'FMDB - Verifikasi')

@section('content_header')
<!-- <h1>Outstanding</h1> -->
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Verifikasi</h3>
                <div class="box-tools hide">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-hover table-condensed table-responsive table-responsive no-padding" id="data-table">
                    <thead>
                       <tr>
                            <th width="20%">No Document</th>
                            <th width="8%">Date</th>
                            <th width="20%">Material Name</th>
                            <th width="40%">Description</th>
                            <th width="8%"></th>
                       </tr>
                    </thead>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<!-- /.content -->
</div>
<div id="detail-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="show-aterial-detail">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-approve btn-success">Approve</button>
                <button type="button" class="btn btn-flat btn-reject btn-danger">Reject</button>
                <button type="button" class="btn btn-flat btn-default btn-close-group-material-modal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    var appr_id;
    var doc_no;
    jQuery(document).ready(function() {
        jQuery('#data-table').DataTable({
            ajax: '{!! route('get.verifikasi_grid') !!}',
            columns: [
                {
                    "render": function (data, type, row) {
                        var content = '<a href="javascript:;" onClick="detail(\'' + row.no_document + '\',\'' + row.approval_id + '\',)"><b>' + row.no_document + '</b></a>';
                        return content;
                    }
                }, 
                { 
                    "render": function (data, type, row) {
                       var date = new Date(row.created_on);
                        
                        return date.getDate() + '/' + date.getMonth() + '/' +date.getFullYear();
                    }
                },
                { data: 'material_name', name: 'material_name' },
                {
                     "render": function (data, type, row) {
                        return (row.description.length > 120 ? row.description.substring(0,120) + '...':row.description );
                    }
                },
                {
                    "render": function (data, type, row) {
                        var content = '<button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="detail(\'' + row.no_document + '\',\'' + row.approval_id + '\',)"><i class="fa fa-search"></i></button>';
                            content += '<button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="verif(\'' + row.approval_id + '\',\'' + row.no_document + '\',1)"><i class="fa fa-check"></i></button>';
                        
                        return content;
                    }
                } 
            ],
             columnDefs: [
                { targets: [4], className: 'text-center', orderable: false},
                { targets: [3], orderable: false},
            ]
        }); 

        jQuery('.btn-approve').on('click', function() {
            verif(appr_id, doc_no, 1);
        });

        jQuery('.btn-reject').on('click', function() {
            verif(appr_id, doc_no, 2);
        });
    });

    function verif(approval_id, no_document, status) {
         var param = {
             approval_id: approval_id,
             no_document: no_document,
             status: status
         };

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        jQuery.ajax({
            url:"{{ url('verifikasi/post') }}",
            method:"POST",
            data: param,
            beforeSend:function(){ jQuery('.loading-event').fadeIn();},
            success:function(result){
                if(result.status){
                    jQuery("#detail-modal").modal("hide");
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

    function detail(no_document, approval_id) {
        appr_id = approval_id;
        doc_no = no_document;
        var content = '<div class="col-md-6">';
            content += '<div class="sp-wrap text-center">';

            var img_list = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.get_image_detail') !!}?no_document=' + no_document)));

            if(img_list.length>0) {
                 jQuery.each(img_list, function(key, val){
                    content += '<a href="' + val.file_image + '"><img src="' + val.file_image + '" alt="" class="img-responsive" style="width:100%"></a>';
                });
            } else {
                content += '<a href="{{URL::asset('img/default-img.png')}}"><img src="{{URL::asset('img/default-img.png')}}" alt="" class="img-responsive"></a>';
            }   
            content +='</div></div>';
            var detail= jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.tr_material') !!}?search=' + no_document)));

            content +='<div class="col-md-6">';
            content += '<table class="table table-condensed">';
            content += '<tr>';
            content += '    <td widh="180px"><b>Number</b></td>';
            content += '    <td>' + detail[0].no_material + '</td>'
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Name</b></td>';
            content += '    <td>' + detail[0].material_name + '</td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Merk</b></td>';
            content += '    <td>' + (detail[0].merk ? detail[0].merk :'')+ '</td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Part number</b></td>';
            content += '    <td>' + (detail[0].part_number ? detail[0].part_number :'')+ '</td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Satuan</b></td>';
            content += '    <td>' + detail[0].weight_unit + '</td>';
            content += '</td>';
            content += '<tr>';
            content += '    <td><b>Keterangan:</b></td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td colspan="2">' + (detail[0].remarks ? detail[0].remarks:'') + '</td>';
            content += '</tr>';
            content += '</table>';
            content +='</div>';
        
        jQuery('#show-aterial-detail').html(content);
        jQuery('.sp-wrap').smoothproducts();
        jQuery("#detail-modal .modal-title").html("Detail " + detail[0].material_name );	
        jQuery("#detail-modal").modal({
            backdrop: 'static',
            keyboard: false
        });
        jQuery("#detail-modal").modal("show");
    }
</script>
@stop 