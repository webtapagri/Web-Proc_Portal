@extends('adminlte::page')

@section('title', 'FMDB - Master Material')

@section('content')
<style>
    .select-img:hover {
        opacity: 0.5;
        cursor: pointer
    }

	.page {
		padding: 5px 30px 30px 30px;
		max-width: 800px;
		margin: 0 auto;
		font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
		background: #fff;
		color: #555;
	}
	img {
		border: none;
	}
	a:link,
	a:visited {
		color: #00a853;
	}
	a:hover {
		color: #8C0B0E;
	}
	ul {
		overflow: hidden;
	}
	pre {
		background: #333;
		padding: 10px;
		overflow: auto;
		color: #BBB7A9;
	}
	.button {
		text-decoration: none;
		color: #F0353A;
		border: 2px solid #F0353A;
		padding: 6px 10px;
		display: inline-block;
		font-size: 18px;
	}
	.button:hover {
		background: #F0353A;
		color: #fff;
	}
	.demo {
		text-align: center;
		padding: 30px 0
	}
    
	.clear {
		clear: both;
	}

    .sp-lightbox {
        z-index: 9999;
    }

    .sp-wrap {
        max-width: 100% !important;
        background: none !important;
        border:none !important;
        float:none !important;
    }

    #search_material {
        text-transform: uppercase;
    }

    #datatable-loader {
        border: 8px solid #008d4c;
        border-radius: 50%;
        border-top: 8px solid #00a65a;
        width: 45px;
        height: 45px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 0.8s linear infinite;
        margin:auto;
    }   
    @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
    }

    .panel {
      /*   margin-bottom: 20px; */
        background-color: transparent;
         border: none;
        /* border-radius: 4px; */
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .material-status {
        position: fixed;
        margin: 5px;
    }
</style>
<section class="content">
       <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form id="search-form" class="form-horizontal">
                <div class="input-group">
                    <input type="text" class="form-control" id="search_material" placeholder="search material" >
                    <span class="input-group-btn">
                <button type="submit" class="btn btn-flat btn-success btn-flat"><i class="fa fa-search"></i></button>

                <button type="button" class="btn btn-flat btn-success btn-flat btn-add {{ (isset($access['CREATE']) ? '':'hide') }}" style="display:none"><i class="glyphicon glyphicon-plus" title="Request new material"></i> Request</button>
                <button type="button" class="btn btn-flat btn-danger btn-flat btn-clear-filter hide"><i class="fa fa-filter"></i></button>
            </span>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
             <table id="data-table" class="table table-condensed" style="background-color:white" width="100%">
                <thead>
                    <tr>
                        <th width="25%"></th>
                        <th></th>
                        <!-- <th width="10%"></th> -->
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
				<h4 class="modal-title">Group Material</h4>
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

        jQuery("#search_material").autocomplete({
            source: function (request, response) {
                if(jQuery('#search_material').val()) {
                    var search = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.auto_sugest') !!}?param=' + jQuery('#search_material').val())));
                    response (search)
                }
            },
            minLength: 3
        });


        initData();  
        
        jQuery('.btn-add').on('click', function() {
            window.location.href = "{{ url('materialrequest/create') }}";
        });

         jQuery('#search-form').on('submit', function(e) {
            e.preventDefault();
            searchData();
        });

       jQuery("#search_material").on('change', function() {
            if(jQuery(this).val()) {
                  jQuery('.btn-clear-filter').removeClass('hide');
            } else {
                jQuery('.btn-clear-filter').addClass('hide');
            }
        });

        jQuery('.btn-clear-filter').on('click', function() {
            jQuery('#search_material').val('');
            jQuery('#search_material').trigger('change');
            initData();
        })
    });

    function initData(param) {
        if ( jQuery.fn.DataTable.isDataTable('#data-table') ) {
            jQuery('#data-table').DataTable().destroy();
        }

        if(param) {
            var api = '{!! route('get.mastermaterial_grid_search') !!}';
        } else {
            var api = '{!! route('get.mastermaterial_grid') !!}';
        }

        var table =   jQuery('#data-table').DataTable({
            "pageLength": 10,
        "searching": false,
        "sort": false,
        "lengthChange": false,
        oLanguage: {
            sProcessing: "<div id='datatable-loader'></div>Memuat data...",
            sEmptyTable: "Data tidak di temukan",
            sLoadingRecords: ""
        },
        processing: true,
        ajax: {
            url: api + '?search=' + (param ? param:''),
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
        columns: [
            {  
                "render": function (data, type, row) {
                    var content = '';
                    if(row.src === '1') {
                        content += '<div class="material-status"><span class="badge bg-yellow">REQUESTED</span></div>';
                    }

                    if(row.file_image) {
                        var key = (row.src === '0' ? row.no_material:row.no_document);
  
                        content += '<img src="' + row.file_image + '" class="img-responsive select-img" title="show detail ' + row.material_name + '"  OnClick="showDetail(\'' + key + '\',\'' + row.src + '\')">';
                    } else{
                        content += '';
                    }    

                    return content;
                } 
            },
            { 
                "render": function (data, type, row) {
                    var key = (row.src === '0' ? row.no_material:row.no_document);
                    var content  = '<div class="row" style="padding-left:30px;padding-right:30px;padding-bottom:30px">';
                        content += '<div class="row">';
                        content += '    <div class="col-md-4"><b>' + (row.src === '0' ? 'Material No': 'Document No') + '</b></div>';
                        content += '    <div class="col-md-8">' + row.no_material + '</div>'
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
        columnDefs: [
            { targets: [1]},
        ],
      });
    }

    function searchData() {
        jQuery('.loading-event').fadeIn();
        var param = jQuery('#search_material').val();
        initData(param);
        jQuery('.loading-event').fadeOut()
    }

    function showDetail(no_document, status) {
        jQuery('.loading-event').fadeIn();
        var content = '<div class="col-md-6">';
            content += '<div class="sp-wrap text-center">';

            var img_list = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.get_image_detail') !!}?no_document=' + no_document)));    
            jQuery.each(img_list, function(key, val){
                content += '<a href="' + val.file_image + '"><img src="' + val.file_image + '" alt=""></a>';
            });
            content +='</div></div>';
            if(status === '0') {
                var detail= jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.tm_material') !!}?search=' + no_document)));
            }else{
                var detail= jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.tr_material') !!}?search=' + no_document)));
            }

            content +='<div class="col-md-6">';
            content += '<table class="table table-condensed">';
            content += '<tr>';
            content += '    <td widh="180px"><b>' + (status === '0' ? 'Material No': 'Document No') + '</b></td>';
            content += '    <td>' + detail.no_material + '</td>'
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Nama Material</b></td>';
            content += '    <td>' + detail.material_name + '</td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Merk</b></td>';
            content += '    <td>' + (detail.merk ? detail.merk :'')+ '</td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Part number</b></td>';
            content += '    <td>' + (detail.part_number ? detail.part_number :'')+ '</td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Satuan</b></td>';
            content += '    <td>' + detail.weight_unit + '</td>';
            content += '</td>';
            content += '<tr>';
            content += '    <td><b>Keterangan:</b></td>';
            content += '    <td>' + (detail.remarks ? detail.remarks:'') + '</td>';
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
        jQuery("#detail-modal .modal-title").html(no_document + " - " + detail.material_name );	
        jQuery("#detail-modal").modal({backdrop:'static', keyboard:false});			
        jQuery("#detail-modal").modal("show");	
        jQuery('.loading-event').fadeOut()	
    }
</script>            
@stop