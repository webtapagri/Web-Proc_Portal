{{-- resources/views/cart/v_cart.blade.php --}}

@extends('adminlte::page')

@section('title', @$title)

@section('content_header')
<h1>Create Order</h1><br/>
<input class="form-control" id="fnama-material" name="fnama-material" type="text" name="s" autocomplete="on" placeholder="Cari Material">

@stop

@section('content')

<form action="{{ url(('/checkout')) }}" method="post" id="form-cart">
	
	{!! csrf_field() !!}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
	<!-- TABLE: LATEST ORDERS -->
	<div class="box box-info">

	@if(Session::has('message'))
		<div class='box box-alert' id="box-alert">
			<p class="alert {{ Session::get('alert-class', 'alert-success') }}"> <i class="fa fa-success"></i> {{ Session::get('message') }}</p>
		</div>
	@endif

	<div class="box-header with-border">
	  <h3 class="box-title">Latest Orders</h3>
	  <?php /* <button class="btn btn-success pull-right" xstyle="margin-top: -15px;"><i class="fa fa-cart-plus"></i> CREATE ORDER </button> */ ?>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<div class="table-responsive">
		
			<?php 
				//echo "<pre>"; print_r($data); die(); 
				
				
					$no = 1;
					$all_total = 0;
					
					$l = '<table class="table no-margin" id="table-cart">
							  <thead>
							  <tr>
								<th><input type="checkbox" id="icheckall" name="icheckall" /></th>
								<th>MATERIAL ID</th>
								<th>MATERIAL DESCRIPTION</th>
								<th>VENDOR</th>
								<th nowrap="nowrap">HARGA SATUAN (RP)</th>
								<th nowrap="nowrap">KUANTITAS</th>
								<th nowrap="nowrap">TOTAL HARGA (RP)</th>
								<th>AKSI</th>
							  </tr>
							  </thead>
							  <tbody>';
				if( $data )
				{
					foreach( $data as $k => $v )
					{						
						$franco = !empty($v->franco) ? 'HO' : 'JAKARTA'; 
						$v->quantity = str_replace('.00','',$v->quantity);
						$v->harga_satuan = str_replace('.00','',$v->harga_satuan); 					
						$total_harga = $v->quantity*$v->harga_satuan;
						$all_total += $total_harga;
						
						if( $v->checklist == 1 )
						{
							$checked = " checked='checked' "; 
						}
						else
						{
							$checked = " "; 
						}
						
						$l .= "
							<tr class='MyClass'>
								<td>
									<input type='hidden' id='noid{$no}' name='noid{$no}' value='{$v->supplier_code}'/>
									<input type='hidden' id='nomat{$no}' name='nomat{$no}' value='{$v->no_material}'/>
									<input type='checkbox' id='{$no}' name='no_material[]' value='{$v->no_material}_{$v->supplier_code}' {$checked} />
								</td>
								<td>{$v->no_material}</td>
								<td><a href='#'>{$v->material_name}</a></td>
								<td>{$v->supplier_name} {$franco}</td>
								<td align='right'>{$v->harga_satuan}</td>
								<td nowrap='nowrap'>
									<button type='button' class='min' idcontent='{$no}' valsatuanharga='{$v->harga_satuan}'>-</button>
									<input type='text' name='qty{$no}' id='qty{$no}' maxlength='12' size='1' value='{$v->quantity}' readonly='1'/>
									<button type='button' class='plus' idcontent='{$no}' valsatuanharga='{$v->harga_satuan}'>+</button>
								</td>
								<td align='right'><span id='total_harga{$no}'>{$total_harga}<span></td>
								<td nowrap='nowrap'>
									<!--a href='#' idcontent='' xclass='btn btn-icon-toggle' title='Lihat Detail' data-toggle='modal' data-target='#mymodal_detil'>Ubah</a>
								| --><a href='#' id='delete-data' idcontent='{$v->no_material}' class='btn btn-icon-toggle' title='Delete Data' data-toggle='modal' data-target='#mymodal_detil_delete'>
								<i class='fa fa-trash'></i></a>
								</td>
							</tr>
						";
						$no++;
					}
					//die();
				
					$l .= '<tr style="font-weight:bold">
			<td colspan="6" align="right"><span class="label label-success">TOTAL (RP)</span></td>
			<td colspan="1" align="right"><span class="all-total">'.$all_total.'</span></td>
			<td></td>
		  </tr>';
				}else{
					$l .= '<tr><td colspan="8" align="center"><h3><span class="label label-danger">Keranjang Belanja Anda Kosong</span></h3></td></tr>';
				}
					$l .= '	</tbody>
							</table>';
					
					echo $l; 
				
				
			?>
		
		</div>
		<!-- /.table-responsive -->
	</div>
	<!-- /.box-body -->
	<div class="box-footer clearfix">
		<?php /* <a href="/" class="btn btn-sm btn-info btn-flat pull-left"><i class="fa fa-backward"></i> Back</a> */ ?>
		<button type="submit" class="btn btn-danger pull-right"><i class="fa fa-opencart"></i> CHECK OUT</button>
	</div>
	<!-- /.box-footer -->
</div>
</form>

<div class="modal fade" id="mymodal_detil_delete" xtabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 class="modal-title" id="myModalLabel">Delete Order ?</h3>
    </div>
    <form id="form-detil" name="form-detil" class="form-horizontal" method="POST" action="{{ url('/cart/delete') }}" enctype="multipart/form-data">
	
		{!! csrf_field() !!}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
        <div class="modal-body">
		
			<input type="hidden" class="form-control" id="no_material" name="no_material"/>
        	
        	<div class="form-group">
                <label class="control-label col-xs-3" >Item</label>
                <div class="col-xs-8">
                    <input type="text" class="form-control" id="item" name="item" value="" readonly="readonly" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-3" >Harga Satuan</label>
                <div class="col-xs-8">
                    <input type="text" class="form-control" id="harga-satuan" name="harga-satuan" value="" readonly="readonly" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-3" >Kuantitas</label>
                <div class="col-xs-8">
                    <input type="text" class="form-control" id="kuantitas" name="kuantitas" value="" readonly="readonly" />
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <?php /* <button class="btn btn-flat btn-danger" data-dismiss="modal" aria-hidden="true">Delete</button> */ ?>
			<button class="btn btn-flat btn-lg btn-info" data-dismiss="modal" aria-hidden="true">Cancel</button>
			<input type="submit" class="btn btn-flat btn-lg btn-danger" id="" value="Delete">
        </div>
    </form>
    </div>
    </div>
</div>

<div class="modal fade" id="mymodal_detil" xtabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 class="modal-title" id="myModalLabel">Detail Order</h3>
			</div>
			<form id="form-detil" name="form-detil" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				<div class="modal-body">
				
					<input type="hidden" class="form-control" id="id" name="id"/>
					
					<div class="form-group">
						<label class="control-label col-xs-3" >Item</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="item" name="item" value="SHELL,PALM (CANGKANG)" readonly="readonly" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3" >Harga Satuan</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="harga-satuan" name="harga-satuan" value="10.000" readonly="readonly" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3" >Kuantitas</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="category" name="category" value="1" xreadonly="readonly" />
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-flat btn-success" data-dismiss="modal" aria-hidden="true">Update</button>
				</div>
			</form>
		</div>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script type="text/javascript">

get_total_harga();

$('#icheckall').click(function(e)
{
    var table= $(e.target).closest('table');
    $('td input:checkbox',table).attr('checked',e.target.checked);
});

var j = jQuery; //Just a variable for using jQuery without conflicts
var addInput = '#qty'; //This is the id of the input you are changing
var n = 1; //n is equal to 1

//Set default value to n (n = 1)
j(addInput).val(n);

//On click add 1 to n
j('.plus').on('click', function()
{
	var id = $(this).attr("idcontent");	
	var nowvalue = $("#qty"+id).val();
	var valsatuanharga = $(this).attr("valsatuanharga");
	var totalharga = (parseInt(nowvalue)+1)*parseInt(valsatuanharga);
	j("#total_harga"+id).text(totalharga);
	j("#qty"+id).val(++nowvalue);
	total_harga_sekarang = $(".all-total").text();
	ths = replace_nilai(total_harga_sekarang);
	total_harga_now = parseInt(ths)+parseInt(valsatuanharga);
	$(".all-total").text(rupiah(total_harga_now));
	var nomat = $("#nomat"+id).val();
	var noid = $("#noid"+id).val();
	plusmindata(nomat,noid,'plus');
})

j('.min').on('click', function()
{
	var id = $( this ).attr("idcontent");
	var nowvalue = $("#qty"+id).val();
	var valsatuanharga = $(this).attr("valsatuanharga");
	var totalharga = (parseInt(nowvalue)-1)*parseInt(valsatuanharga);
	
	if (nowvalue >= 1) 
	{
		j("#total_harga"+id).text(totalharga);
		j("#qty"+id).val(--nowvalue);
		total_harga_sekarang = $(".all-total").text();
		ths = replace_nilai(total_harga_sekarang);
		total_harga_now = parseInt(ths)-parseInt(valsatuanharga);
		$(".all-total").text(rupiah(total_harga_now));
		var nomat = $("#nomat"+id).val();
		var noid = $("#noid"+id).val();
		plusmindata(nomat,noid,'min');
	} 
});

$('#table-cart').on('click', 'a', function (e) 
{
	var idcontent = $( this ).attr("idcontent");//alert(idcontent);return false;
	$.ajax({
		type: 'GET',
		url: "{{ url('cart/show') }}/"+idcontent+"",
		data: '',
		dataType:'json',
		async: false,
		success: function(datax)
		{			
			var hs = datax.harga_satuan;
			var harga_satuan = hs.replace(".00", "");
			var k = datax.quantity;
			var kuantitas = k.replace(".00", "");
			
			$("#form-detil #no_material").val(idcontent);
			$("#form-detil #item").val(datax.material_name);
			$("#form-detil #harga-satuan").val(harga_satuan);
			$("#form-detil #kuantitas").val(kuantitas);
		},
		error: function(x) {alert("Error: "+ "\r\n\r\n" + x.responseText);}
	});
}); 

var projects = [<?php echo $autocomplete; ?>];
 $("#fnama-material").autocomplete({
    minLength: 0,
    source: function (request, response) {
        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
        var array = $.grep(projects, function (value) {
            return matcher.test(value.id) || matcher.test(value.name) || matcher.test(value.location);
        });
        response(array);
    },
    focus: function (event, ui) {
        $("#fnama-material").val(ui.item.name);
        return false;
    },
    select: function (event, ui) 
    {
    	//alert(ui.item.id);
        $("#fnama-material").val(ui.item.name);
        $("#project-id").val(ui.item.id);
        $("#project-description").html(ui.item.location);

        return false;
    }
}).data("ui-autocomplete")._renderItem = function (ul, item) {
    return $("<li>")
        .append("<a href='cart/add/"+item.id+"'>" + item.name + "<span class='sub-text' style='margin-left:15px;font-size:15px;font-weight:normal;color:red'>" + item.location + " <i class='fa fa-cart-plus'></i> </span></a> ")
        .appendTo(ul);
};

function get_total_harga()
{
	var rows= $('#table-cart tbody tr.MyClass').length;
	var all_total = 0; 
	for(i=1;i<=rows;i++)
	{
		all_total = all_total+parseInt($("#total_harga"+i).text());
		
	}
	$(".all-total").text(rupiah(all_total));
}

function rupiah(angka)
{
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}

function replace_nilai(nil)
{
	var str = nil;
	var res = str.replace(".", "");
	return res;
}

function plusmindata(nomat,noid,act)
{
	//alert(noid); return false;
	var params = $('#form-cart').serialize();
	$.ajax({
		type: 'POST',
		//url: "plusmindata/"+nomat+"/"+noid+"/"+act+"",
		url: "{{ url('plusmindata') }}/"+nomat+"/"+noid+"/"+act+"",
		data: params,
		dataType:'json',
		async: false,
		success: function(datax) {},
		error: function(x) {alert("Error: "+ "\r\n\r\n" + x.responseText);}
	});
}

</script>
@stop 