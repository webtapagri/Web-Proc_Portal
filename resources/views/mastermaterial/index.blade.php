@extends('adminlte::page')

@section('title', 'FMDB - Master Material')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
             <table id="data-table" class="table table-condensed" style="background-color:white">
                    <thead>
                        <tr role="row" class="heading">
                            <th width="25%">Item list</th>
                            <th></th>
                        </tr>
                        <tr role="row" class="filter">
                            <td colspan="2">
                                 <div class="input-group" style="width:100%">
                                    <input type="text" class="form-control form-filter" id="search_material" name="search_material"  placeholder="search material" >
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-flat btn-success btn-flat hide"><i class="fa fa-search"></i></button>
                                        <button type="button" class="btn btn-flat btn-danger btn-flat btn-clear-filter hide"><i class="fa fa-filter"></i></button>
                                        <button type="button" class="btn btn-flat btn-success btn-flat btn-add {{ (isset($access['CREATE']) ? '':'hide') }}" style="display:none"><i class="glyphicon glyphicon-plus" title="Request new material"></i> Request</button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
          </div>
        </div>
      </div>
</section>
<div id="detail-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">	
				<h4 class="modal-title">Detil Material</h4>
			</div>
			<div class="modal-body">	
				<div class="row">
                    <div id="show-aterial-detail"></div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-flat btn-default btn-close-group-material-modal" data-dismiss="modal">Close</button>
			</div>
		</div>
    </div>
</div>
@stop
@section('js')
<script>
    var imgFiles = [];    
    jQuery(document).ready(function() {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var grid = new Datatable();
        grid.init({
            src: jQuery("#data-table"),
            onSuccess: function (grid) {},
            onError: function (grid) {},
            onDataLoad: function(grid) {},
            loadingMessage: 'Loading...',
            dataTable: {
                "dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
                "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                "lengthMenu": [
                    [10, 20, 50, 100, 150],
                    [10, 20, 50, 100, 150]
                ],
                "pageLength": 10,
                "ajax": {
                    "url": '{!! route('mastermaterial.grid') !!}',
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
                "sort": false,
                columns: [
                {  
                    "render": function (data, type, row) {
                        var content = '<div class="image-item-material">';
                        if(row.src === '1') {
                            content += '<span class="badge bg-yellow">REQUESTED</span>';
                        }
                        var key = (row.src === '0' ? row.no_material:row.no_document);
                            content += '<img src="' + (row.file_image ? row.file_image:'{{URL::asset('img/default-img.png')}}') + '" class="img-responsive select-img" title="show detail ' + row.material_name + '"  OnClick="showDetail(\'' + key + '\',\'' + row.src + '\')">';
                         content += '</div>';
                        return content;
                    } 
                },
                { 
                    "render": function (data, type, row) {
                        var key = (row.src === '0' ? row.no_material:row.no_document);
                        var content  = '<div class="row" style="padding-left:30px;padding-right:30px;padding-bottom:30px">';
                            content += '<div class="row">';
                            content += '    <div class="col-md-4"><b>' + (row.src === '0' ? 'Material No': 'Document No') + '</b></div>';
                            content += '    <div class="col-md-8">' + (row.src === '0' ? row.no_material: row.no_document) + '</div>'
                            content += '</div>';
                            content += '<div class="row">';
                            content += '    <div class="col-md-4"><b>Nama Material</b></div>';
                            content += '    <div class="col-md-8"><a href="#" onClick="showDetail(\'' + key + '\',\'' + row.src + '\')" title="show detail ' + row.material_name + '">' + row.material_name + '</a></div>';
                            content += '</div>';
                            content += '<div class="row">';
                            content += '    <div class="col-md-4"><b>Merk</b></div>';
                            content += '    <div class="col-md-8">' + (row.merk ? row.merk :'')+ '</div>';
                            content += '</div>';
                            content += '<div class="row">';
                            content += '    <div class="col-md-4"><b>Part Number</b></div>';
                            content += '    <div class="col-md-8">' + (row.part_number ? row.part_number:'') + '</div>';
                            content += '</div>';
                            content += '<div class="row">';
                            content += '    <div class="col-md-4"><b>Satuan</b></div>';
                            content += '    <div class="col-md-8">' + row.weight_unit + '</div>';
                            content += '</div>';
                            content += '<div class="row">';
                            content += '    <div class="col-md-4"><b>Keterangan:</b></div>';
                            content += '    <div class="col-md-12" style="font-size:11px;">' + (row.remarks ? row.remarks:'') + '</div>';
                            content += '</div>';
                            content += '</div>';

                        return content;
                    } 
                },
            ],
            oLanguage: {
                sProcessing: "<div id='datatable-loader'></div>",
                sEmptyTable: "Data tidak di temukan",
                sLoadingRecords: ""
            },
            "order": [],
            }
        });

        jQuery("#search_material").autocomplete({
            source: function (request, response) {
                if(jQuery('#search_material').val()) {
                    var search = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.auto_sugest') !!}?param=' + jQuery('#search_material').val())));
                    response (search)
                }
            },
            minLength: 3,
        }).on('change', function (e) {
             $(".ui-menu-item").hide();          
        });
        
        jQuery('.btn-add').on('click', function() {
            window.location.href = "{{ url('materialrequest/create') }}";
        });

       jQuery("#search_material").on('change', function() {
           var search = jQuery(this).val();
            if(search) {
                jQuery('.btn-clear-filter').removeClass('hide');
            } else {
                jQuery('.btn-clear-filter').addClass('hide');
            }
        });

        jQuery('.btn-clear-filter').on('click', function() {
            jQuery('#search_material').val('');
            jQuery('#search_material').trigger('change');
        });
    });

    function showDetail(no_document, status) {
        jQuery('.loading-event').fadeIn();
        var content = '<div class="col-md-6">';
            content += '<div class="sp-wrap text-center">';

            var img_list = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.get_image_detail') !!}?no_document=' + no_document)));

            if(img_list.length>0) {
                 jQuery.each(img_list, function(key, val){
                    content += '<a href="' + val.file_image + '"><img src="' + val.file_image + '" alt=""></a>';
                });
            } else {
                content += '<a href="{{URL::asset('img/default-img.png')}}"><img src="{{URL::asset('img/default-img.png')}}" alt=""></a>';
            }   
           
            content +='</div></div>';
            if(status === '0') {
                var detail= jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.tm_material') !!}?search=' + no_document)));
            }else{
                var detail= jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.tr_material') !!}?search=' + no_document)));
            }

            content +='<div class="col-md-6">';
            content += '<table class="table table-condensed">';
            content += '<tr>';
            content += '    <td widh="200px"><b>' + (status === '0' ? 'Material No': 'Document No') + '</b></td>';
            content += '    <td>' + no_document + '</td>'
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Nama Material</b></td>';
            content += '    <td>' + (status === '0' ? (detail.material_name ? detail.material_name:''):(detail[0].material_name ? detail[0].material_name:''))  + '</td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Merk</b></td>';
            content += '    <td>' + (status === '0' ? (detail.merk ? detail.merk:''):(detail[0].merk ? detail[0].merk:'')) + '</td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Part number</b></td>';
            content += '    <td>' + (status === '0' ? (detail.part_number ? detail.part_number:''):(detail[0].part_number ? detail[0].part_number:'')) + '</td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Satuan</b></td>';
            content += '    <td>' + (status === '0' ? (detail.weight_unit ? detail.weight_unit:''):(detail[0].weight_unit ? detail[0].weight_unit:'')) + '</td>';
            content += '</td>';
            content += '<tr>';
            content += '    <td><b>Keterangan:</b></td>';
            content += '    <td></td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td colspan="2">' + (status === '0' ? (detail.remarks ? detail.remarks:''):(detail[0].remarks ? detail[0].remarks:'')) + '</td>';
            content += '</tr>';
            content += '<tr>';
          /*   if(status === '1') {
                content += '    <td colspan="2"><span class="label label-warning">Requested</span></td>';
            } else {
                 content += '<td colspan="2">';
                if(status === '0') {
                    content += '<button type="button" OnClick="extend(this)" data-no_document="' + no_document + '" class="btn btn-flat btn-sm btn-default btn-block">Extend</button>';
                    content +='<button type="button" class="btn btn-flat btn-sm btn-default btn-block ">Read to PO</button>';
                }else{
                    content += '<span class="label label-warning">Requested</span>';
                }
                 content += '<td>';
            }    */
            content += '</tr>';
            content += '</table>';
            content +='</div>';
        
        jQuery('#show-aterial-detail').html(content);
        jQuery('.sp-wrap').smoothproducts();
        jQuery("#detail-modal .modal-title").html(no_document + " - " +  (status === '0' ? detail.material_name:detail[0].material_name) );	
        jQuery("#detail-modal").modal({backdrop:'static', keyboard:false});			
        jQuery("#detail-modal").modal("show");	
        jQuery('.loading-event').fadeOut()	
    }
</script>            
@stop