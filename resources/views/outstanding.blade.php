@extends('adminlte::page')

@section('title', 'Outstanding - My Order | Procurement')

@section('content_header')
<h1>Outstanding Order</h1>
@stop

@section('content')

<style>
    @media screen and (min-width: 0px) and (max-width: 700px) {
      .box{overflow: auto;}
    }
</style>

<?php 

$m_vendor = "<option value=''>Pilih</option>";

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-alert small">
             <div class="box-body">
                
                <table id="grid-data" class="table table-bordered table-striped table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>NO</th>
                        <th>MATERIAL ID</th>
                        <th>MATERIAL NAME</th>
                        <th>VENDOR</th>
                        <th>PLANT</th>
                        <th>QTY</th>
                        <th>PRICE</th>
                        <th>TOTAL</th>
                    </tr>
                    </thead>
                    <tbody></tbody>                 
                </table>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

</section>
<!-- /.content -->
</div>

@stop
@section('js')
<script>
$(document).ready(function() 
{
    var table = $('#grid-data').DataTable(
    {
        aaSorting: [[0, 'desc']],
        bPaginate: true,
        bFilter: true,
        bInfo: true,
        bSortable: true,
        bRetrieve: true,
        iDisplayLength: 10,
        aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        pageLength: 10,
        processing: true,
        serverside: true,
        ajax: {
            url : "{{ url('/outstanding/grid') }}",
            type : "GET"
        },
        orderCellsTop: true,
        fixedHeader: true,
    });

    // Setup - add a text input to each footer cell
    $('#grid-data thead tr').clone(true).appendTo( '#grid-data thead' );
    $('#grid-data thead tr:eq(1) th').each( function (i) 
    {
        var title = $(this).text();
        if( title != 'NO')
        {
            $(this).html( '<input class="form-control" type="text" placeholder="Search '+title+'" />' );
        }
        else
        {
             $(this).html( '' );
        }

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

});
</script>
@stop 