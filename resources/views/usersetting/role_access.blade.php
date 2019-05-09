@extends('adminlte::page')
@section('title', 'FMDB')
@section('content')
<section class="content">
       <div class="row">
        <div class="col-xs-4">
            <span style="font-size:24px">Role Access</span>
        </div>
        <div class="col-xs-8" align="right">
            <span href="#" class="btn btn-sm btn-flat btn-success btn-save">&nbsp;<i class="fa fa-check" title="Add new data"></i>&nbsp; Save</span>
        </div>
    </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
             <div class="box-body">
                 <div class="row">
                    <div class="col-md-4">
                        <label class="control-label" for="name">Role ID</label> 
                        <select class="form-control" name='role_id' id="role_id" maxlength="2" requried>
                            <option></option>
                        </select>
                    </div>
                 </div>
                 <div class="row">
                     <div class="col-md-12">
                         <div id="data" class="demo"></div>
                     </div>
                 </div>
            </div>
            <!-- /.box-body -->
            </div>
          </div>
        </div>
      </div>
</section>

@stop
@section('js')
<script>

    jQuery(document).ready(function() {
        jQuery(document).ready(function() {
            var role = jQuery.parseJSON(JSON.stringify(dataJson('{!! route('get.select_role') !!}')));
            jQuery('#role_id').select2({
                data: role,
                width:'100%',
                placeholder: ' ',
                allowClear: true
            });

            jQuery('#data').jstree({
                'core' : {
                    'data' : [
                        { "text" : "Root node", "children" : [
                                { "text" : "Child node 1" },
                                { "text" : "Child node 2" }
                        ]}
                    ]
                },
                "checkbox" : {
                    "keep_selected_style" : false
                },
                "plugins" : [ "checkbox" ]
            });
        });

        jQuery('.btn-save').on('click', function() {
            save();
        })
    });

    function save() {
        var v = $('#data').jstree(true).get_json('#', {flat:true})
        var mytext = JSON.stringify(v);
        console.log(mytext);
    }

</script>            
@stop