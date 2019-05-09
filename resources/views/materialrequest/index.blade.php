@extends('adminlte::page')

@section('title', 'FMDB - Search Material request')

@section('content')
<section class="content">
       <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form id="search-form" class="form-horizontal">
                    <div class="input-group">
                            <input type="text" class="form-control" id="search_material" placeholder="search material" >
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-flat btn-success btn-flat"><i class="fa fa-search"></i></button>
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
                        <th width="18%">Material Request</th>
                        <th></th>
                        <th width="10%"></th>
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
				<button type="button" class="btn btn-default btn-close-group-material-modal" data-dismiss="modal">Close</button>
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
                    var search = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.editmaterialrequest_auto_sugest') !!}?search=' + jQuery('#search_material').val())));
                    response (search)
                }
            },
            minLength: 3
        });


        jQuery('#search-form').on('submit', function(e) {
            e.preventDefault();
            var param = jQuery('#search_material').val();
             if(param) {
                initData(param);
            } else {
                var table = jQuery('#data-table').DataTable();
                table
                    .clear()
                    .draw();
            }

            if(param) {
                  jQuery('.btn-clear-filter').removeClass('hide');
            } else {
                jQuery('.btn-clear-filter').addClass('hide');
            }
        });

        jQuery('.btn-clear-filter').on('click', function() {
            jQuery('#search_material').val('');
            jQuery('#search_material').trigger('change');
            initData();
        });

    });

    function initData(param) {
        if ( jQuery.fn.DataTable.isDataTable('#data-table') ) {
            jQuery('#data-table').DataTable().destroy();
        }

        if(param) {
            var api = "{!! route('get.editmaterialrequest_grid') !!}?search=" + param;
            console.log(api);
            var table =   jQuery('#data-table').DataTable({
                ajax: {
                    url: api,
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
                            if(row.image) {
                                var key = row.no_document;
        
                                var content = '<img src="' + row.image + '" class="img-responsive select-img" title="show detail ' + row.material_name + '"  OnClick="showDetail(\'' + key + '\',\'' + row.src + '\')">';
                            } else{
                                var content = '';
                            }    
                            return content;
                        } 
                    },
                    { 
                        "render": function (data, type, row) {
                            var key = row.no_document;

                            var content  = '<div class="row" style="padding-left:30px;padding-right:30px;padding-bottom:30px">';
                                content += '<div class="row">';
                                content += '    <div class="col-md-4"><b>Material Number</b></div>';
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
                    { 
                        "render": function (data, type, row) {
                            var content = '<button OnClick="edit(this)" data-no_document="' + row.no_document + '" class="btn btn-flat btn-success btn-flat btn-block "><i class="fa fa-pencil"></i> Edit</button>';
                            return content;
                        } 
                    }
                ],
                columnDefs: [
                    { targets: [1]},
                ],
                "pageLength": 10,
                "searching": false,
                "sort": false,
                "lengthChange": false,
            });
        } else {

        }
    }

    function edit(param) {
        var no_document = jQuery(param).data('no_document');
        window.location.href = "{{ url('editmaterialrequest') }}/" + no_document;
    }

    function searchData() {
        jQuery('.loading-event').fadeIn();
        var param = jQuery('#search_material').val();
        initData(param);
        jQuery('.loading-event').fadeOut()
    }

    function searchDataTable() {
        // Declare variables 
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search_material");
        filter = input.value.toUpperCase();
        table = document.getElementById("data-table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            } 
        }
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
           var detail= jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.tr_material') !!}?search=' + no_document)));

            content +='<div class="col-md-6">';
            content += '<table class="table table-condensed">';
            content += '<tr>';
            content += '    <td widh="180px"><b>Material Number</b></td>';
            content += '    <td>' + detail[0].no_material + '</td>'
            content += '</tr>';
            content += '<tr>';
            content += '    <td><b>Nama Material</b></td>';
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
            content += '    <td>' + (detail[0].remarks ? detail[0].remarks:'') + '</td>';
            content += '</tr>';
            content += '<tr>';
            content += '    <td colspan="2"><button OnClick="edit(this)" data-no_document="' + no_document + '" class="btn btn-flat btn-success btn-flat btn-block"><i class="fa fa-pencil"></i> Edit</button></td>';
            content += '</tr>';
            content += '</table>';
            content +='</div>';
        
        jQuery('#show-aterial-detail').html(content);
        jQuery('.sp-wrap').smoothproducts();
        jQuery("#detail-modal .modal-title").html("Detail " + detail[0].material_name );	
        jQuery("#detail-modal").modal({backdrop:'static', keyboard:false});			
        jQuery("#detail-modal").modal("show");	
        jQuery('.loading-event').fadeOut()	
    }
</script>            
@stop