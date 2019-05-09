{{-- resources/views/cart/v_cart.blade.php --}}

@extends('adminlte::page')

@section('title', @$title)

@section('content_header')
<span class="label" style="font-weight:bold;font-size:20px;color:#F44336"><i class="fa fa-warning"></i> Periksa kembali belanjaan Anda</span>
@stop

@section('content')

<!-- TABLE: LATEST ORDERS -->
<div class="box box-info">
<div class="box-header with-border">
  <h3 class="box-title">Order Summary</h3>
  <?php /* <div class="box-tools pull-right">
	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	</button>
	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
  </div> */ ?>
</div>
<!-- /.box-header -->
<div class="box-body">
  <div class="table-responsive">

	<table class="table no-margin">
	  <thead>
	  <tr>
		<th>VENDOR</th>
		<th>FRANCO</th>
		<th>ITEM</th>
		<th nowrap="nowrap">HARGA SATUAN (RP)</th>
		<th nowrap="nowrap">KUANTITAS</th>
		<th nowrap="nowrap">TOTAL HARGA (RP)</th>
	  </tr>
	  </thead>
	  <tbody>
	  
	  <?php 
		$l = '';
		$ppn = 25000;
		$all_harga = 0;
		$total_ppn = 0;
		
		if(!empty($data))
		{
			foreach($data as $k => $v)
			{
				$l .= '<input type="hidden" name="get_no_material" value="'.$v->no_material.'" ';
				
				$total_harga = $v->quantity*$v->harga_satuan;
				$quantity = str_replace(".00","",$v->quantity);
				$harga_satuan = str_replace(".00","",$v->harga_satuan);
				//echo "<pre>"; print_r($v);
				$l .= '<tr>
				<td>'.$v->supplier_name.'</td>
					<td>'.$v->franco.'</td>
					<td><a href="#">'.$v->material_name.'</a></td>
					<td align="right">'.$harga_satuan.'</td>
					<td align="right">'.$quantity.'</td>
					<td align="right">'.$total_harga.'</td>
				  </tr>';
				  
				$all_harga += $total_harga;
			}
			//die();
			$total_ppn = $ppn+$all_harga;
		}
		else
		{
			$l .= '<tr><td colspan="6" align="center"><h3><span class="label label-danger">Anda belum memilih produk</span></h3></td></tr>';
		}
		
		echo $l;
	?>
		<?php if(!empty($data)){ ?>
		<tr style="font-weight:bold">
		<td colspan="5" align="right"><span class="label label-success" style="font-weight:bold;font-size:15px">TOTAL HARGA</span></td>
		<td align="right"><span class="label label-default" style="font-weight:bold;font-size:15px">{{number_format($all_harga,0,',',',')}}</span></td>
	  </tr>
	   <tr style="font-weight:bold">
		<td colspan="5" align="right"><span class="label label-success" style="font-weight:bold;font-size:15px">PPN</span></td>
		<td align="right"><span class="label label-default" style="font-weight:bold;font-size:15px">{{number_format($ppn,0,',',',')}}</span></td>
	  </tr>
	  <tr style="font-weight:bold">
		<td colspan="5" align="right"><span class="label label-success" style="font-weight:bold;font-size:15px">TOTAL (RP)</span></td>
		<td align="right"><span class="label label-default" style="font-weight:bold;font-size:15px">{{number_format($total_ppn,0,',',',')}}</span></td>
	  </tr>
		<?php } ?>
	
	  </tbody>
	</table>

  </div>
  <!-- /.table-responsive -->
</div>
<!-- /.box-body -->


<div class="box-footer clearfix">
	<a href="/cart" class="btn btn-sm btn-info btn-flat pull-left"><i class="fa fa-backward"></i> Back to Cart</a>
	<?php if(!empty($data)){ ?>
	<a href="#" data-toggle="modal" data-target="#modalbuatpesanan"><button class="btn btn-danger pull-right"><i class="fa fa-opencart"></i> BUAT PESANAN</button></a>
	<?php } ?>
</div>
<!-- /.box-footer -->


</div>

<div class="modal fade" id="modalbuatpesanan" xtabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 class="modal-title" id="myModalLabel">Konfirmasi Buat Pesanan ?</h3>
			</div>
			
			<form id="form-cart-detil" name="form-cart-detil" class="form-horizontal" method="POST" action="{{ url('/create_order') }}">
				{!! csrf_field() !!}
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
				<div class="modal-body">
					
					
					  <div class="table-responsive">
							<table class="table no-margin">
							  <thead>
							  <tr>
								<th>VENDOR</th>
								<th>FRANCO</th>
								<th>ITEM</th>
								<th nowrap="nowrap">KUANTITAS</th>
								<th nowrap="nowrap">TOTAL HARGA (RP.)</th>
							  </tr>
							  </thead>
							  <tbody>
							  <?php 
									$l = '';
									$ppn = 25000;
									$all_harga = 0;
									$total_ppn = 0;
									
									if(!empty($data))
									{
										foreach($data as $k => $v)
										{
											$l .= '<input type="hidden" name="get_no_material[]" value="'.$v->no_material.'" ';
											
											$total_harga = $v->quantity*$v->harga_satuan;
											$quantity = str_replace(".00","",$v->quantity);
											$harga_satuan = str_replace(".00","",$v->harga_satuan);
											//echo "<pre>"; print_r($v);
											$l .= '<tr>
											<td>'.$v->supplier_name.'</td>
												<td>'.$v->franco.'</td>
												<td><a href="#">'.$v->material_name.'</a></td>
												<td align="right">'.$quantity.'</td>
												<td align="right">'.$total_harga.'</td>
											  </tr>';
											  
											$all_harga += $total_harga;
										}
										//die();
										$total_ppn = $ppn+$all_harga;
									}
									echo $l;
								?>
							  <tr style="font-weight:bold">
								<td colspan="4" align="right"><span class="label label-success" style="font-weight:bold;font-size:15px">TOTAL HARGA</span></td>
								<td align="right"><span class="label label-default" style="font-weight:bold;font-size:15px">{{number_format($all_harga,0,',',',')}}</span></td>
							  </tr>
							   <tr style="font-weight:bold">
								<td colspan="4" align="right"><span class="label label-success" style="font-weight:bold;font-size:15px">PPN</span></td>
								<td align="right"><span class="label label-default" style="font-weight:bold;font-size:15px">{{number_format($ppn,0,',',',')}}</span></td>
							  </tr>
							  <tr style="font-weight:bold">
								<td colspan="4" align="right"><span class="label label-success" style="font-weight:bold;font-size:15px">TOTAL (RP)</span></td>
								<td align="right"><span class="label label-default" style="font-weight:bold;font-size:15px">{{number_format($total_ppn,0,',',',')}}</span></td>
							  </tr>
							  </tbody>
							</table>
						  </div>
						  <!-- /.table-responsive -->

				</div>

				<div class="modal-footer">
					<button class="btn btn-flat btn-lg btn-info" data-dismiss="modal" aria-hidden="true">CANCEL</button>
					<input type="submit" class="btn btn-flat btn-lg btn-danger" xdata-dismiss="modal" xaria-hidden="true" id="yesorder" value="OK">
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
<script>
$("#xyesorder").click(function()
{
	var params = $('#form-cart-detil').serialize();
	//alert(params); return false;
	$.ajax({
		type: 'POST',
		url: "/create_order/",
		data: params,
		dataType:'json',
		async: false,
		success: function(datax) 
		{
			//var redirectToURL = '/myorder/on-progress';
			//window.location.href = redirectToURL;
		},
		error: function(x) {alert("Error: "+ "\r\n\r\n" + x.responseText);}
	});
	
});
</script>
@stop 