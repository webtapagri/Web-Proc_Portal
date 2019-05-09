@extends('adminlte::page')

@section('title', 'FMDB - Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Outstanding</h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>No Document</th>
                        <th>Requester</th>
                        <th>Date</th>
                        <th>Material Name</th>
                        <th>Ket</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td><a href="javascript:;" OnClick="detail()" class="text-green">2019/03/TAP/0001</a></td>
                        <td>SITI AMINAH</td>
                        <td>8 maret 2019</td>
                        <td>ROUNDUP 486L @ 20LTR</td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="detail()"><i class="fa fa-search"></i></button>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="edit"><i class="fa fa-check"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="javascript:;" OnClick="detail()" class="text-green">2019/03/TAP/0001</a></td>
                        <td>SITI AMINAH</td>
                        <td>8 maret 2019</td>
                        <td>ROUNDUP 486L @ 20LTR</td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="detail()"><i class="fa fa-search"></i></button>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="edit)"><i class="fa fa-check"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="javascript:;" OnClick="detail()" class="text-green">2019/03/TAP/0001</a></td>
                        <td>SITI AMINAH</td>
                        <td>8 maret 2019</td>
                        <td>ROUNDUP 486L @ 20LTR</td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="detail()"><i class="fa fa-search"></i></button>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="edit)"><i class="fa fa-check"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="javascript:;" OnClick="detail()" class="text-green">2019/03/TAP/0001</a></td>
                        <td>SITI AMINAH</td>
                        <td>8 maret 2019</td>
                        <td>ROUNDUP 486L @ 20LTR</td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="detail()"><i class="fa fa-search"></i></button>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="edit)"><i class="fa fa-check"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="javascript:;" OnClick="detail()" class="text-green">2019/03/TAP/0001</a></td>
                        <td>SITI AMINAH</td>
                        <td>8 maret 2019</td>
                        <td>ROUNDUP 486L @ 20LTR</td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="detail()"><i class="fa fa-search"></i></button>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="edit)"><i class="fa fa-check"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="javascript:;" OnClick="detail()" class="text-green">2019/03/TAP/0001</a></td>
                        <td>SITI AMINAH</td>
                        <td>8 maret 2019</td>
                        <td>ROUNDUP 486L @ 20LTR</td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="detail()"><i class="fa fa-search"></i></button>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="edit)"><i class="fa fa-check"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="javascript:;" OnClick="detail()" class="text-green">2019/03/TAP/0001</a></td>
                        <td>SITI AMINAH</td>
                        <td>8 maret 2019</td>
                        <td>ROUNDUP 486L @ 20LTR</td>
                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        <td>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="detail()"><i class="fa fa-search"></i></button>
                            <button class="btn btn-flat btn-xs btn-default btn-action" title="edit data" onClick="edit)"><i class="fa fa-check"></i></button>
                        </td>
                    </tr>
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
<div id="detail-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">2019/03/TAP/0001 - ROUNDUP 486L @ 20LTR</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="show-aterial-detail">
                        <div class="col-md-6">
                            <div class="sp-wrap text-center sp-non-touch" style="display: inline-block;">
                                <div class="sp-large"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td widh="180px"><b>Material No</b></td>
                                        <td>101010001</td>
                                    </tr>
                                    <tr>
                                        <td><b>Nama Material</b></td>
                                        <td>TREADIMENOL</td>
                                    </tr>
                                    <tr>
                                        <td><b>Merk</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><b>Part number</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><b>Satuan</b></td>
                                        <td>KG</td>
                                    </tr>
                                    <tr>
                                        <td><b>Keterangan:</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat btn-success">Approve</button>
                <button type="button" class="btn btn-flat btn-default btn-close-group-material-modal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    jQuery(document).ready(function() {

    });

    function detail() {

        jQuery("#detail-modal").modal({
            backdrop: 'static',
            keyboard: false
        });
        jQuery("#detail-modal").modal("show");
    }
</script>
@stop 