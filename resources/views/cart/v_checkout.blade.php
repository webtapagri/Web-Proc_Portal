{{-- resources/views/cart/v_cart.blade.php --}}

@extends('adminlte::page')

@section('title', @$title)

@section('content_header')
<h1>Order Summary</h1>
@stop

@section('content')

<!-- TABLE: LATEST ORDERS -->
<div class="box box-info">
<div class="box-header with-border">
  <span class="label" style="font-weight:bold;font-size:20px;color:#F44336"><i class="fa fa-warning"></i> Periksa kembali belanjaan Anda</span>
  <?php /* <div class="box-tools pull-right">
	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	</button>
	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
  </div> */ ?>
</div>
<!-- /.box-header -->
<div class="box-body">
  <div class="">
	  
	  <?php 
		$l = '';
		
		if(!empty($data))
		{
			//echo "<pre>"; print_r($data);die();

			foreach($data as $k => $v)
			{
				$l .= "<div class=''>
					<div class='col-md-6 col-xs-12' align='left'>
						Order Id : </br>
						Incoterm : 
					</div>
					<div class='col-md-6 col-xs-12' align='right'>
						Vendor : <b class='text-success'>$v[supplier_name]</b> <br/>
						Order Date : 
					</div>
				</div>";

				$l .= "
					<div class='container-fluid'>
						<table class='table table-responsive table-striped'/>
						<thead>
						<tr>
							<th>NO</th>
							<th>MATERIAL ID</th>
							<th>MATERIAL DESCRIPTION</th>
							<th>VENDOR</th>
							<th align='right'>QTY</th>
							<th align='right'>NEW PRICE (IDR)</th>
							<th align='right'>TOTAL (IDR)</th>
						</tr>
						</thead>
						<tbody>
				";

				if(!empty($v['detail_order']))
				{
					$no = 1;
					$ppn = 25000;
					$all_harga = 0;
					$total_ppn = 0;
					
					foreach( $v['detail_order'] as $kk => $vv )
					{
						$l .= '<input type="hidden" name="get_no_material" value="'.$vv->no_material.'" ';
				
						$total_harga = $vv->quantity*$vv->harga_satuan;
						$quantity = str_replace(".00","",$vv->quantity);
						$harga_satuan = str_replace(".00","",$vv->harga_satuan);

						$l .= "<tr>
							<td>$no</td>
							<td>$vv->no_material</td>
							<td>$vv->material_name</td>
							<td>$vv->supplier_name ($vv->franco)</td>
							<td align='right'>".number_format($quantity,0,',','.')."</td>
							<td align='right'>".number_format($harga_satuan,0,',','.')."</td>
							<td align='right'>".number_format($total_harga,0,',','.')."</td>
						</tr>";
						$no++;
						$all_harga += $total_harga;
					}

					$total_ppn = $ppn+$all_harga;
				}

				$l .= "</tbody></table></div>";

				$l .= "<div class='' align='right'>
						Sub Total : <b class='text-success'>".number_format($all_harga,0,',','.')."</b> <br/>
						PPN : <b class='text-success'>".number_format($ppn,0,',','.')."</b> <br/> 
						Total : <b class='text-success'>".number_format($total_ppn,0,',','.')."</b>
				</div><hr/>";

				//echo "<pre>"; print_r($v);
					/*
					Array
					(
					    [0] => Array
					        (
					            [supplier_code] => 23000001764    
					            [supplier_name] => CENTA BRASINDO ABADI, PT
					            [detail_order] => Array
					                (
					                    [0] => stdClass Object
					                        (
					                            [no_material] => 101010009
					                            [material_name] => METIL METSULFURON 20 WP META PRIMA
					                            [quantity] => 1.00
					                            [harga_satuan] => 7000.00
					                            [supplier_code] => 23000001764    
					                            [supplier_name] => CENTA BRASINDO ABADI, PT
					                            [franco] => RO SAMPIT
					                        )

					                )

					        )

					)
					*/
				
			}
			//die();
			
		}
		else
		{
			$l .= '<center><h3><span class="label label-danger">Anda belum memilih produk</span></h3></center>';
		}
		
		echo $l;
	?>

	


  </div>
  <!-- /.table-responsive -->
</div>
<!-- /.box-body -->


<div class="box-footer clearfix">
	<a href="{{ url('/cart') }}" class="btn btn-sm btn-info btn-flat pull-left"><i class="fa fa-backward"></i> Back to Cart</a>
	<?php if(!empty($data)){ ?>
	<a href="#" data-toggle="modal" data-target="#modalbuatpesanan"><button class="btn btn-danger pull-right"><i class="fa fa-opencart"></i> PROCESS</button></a>
	<?php } ?>
</div>
<!-- /.box-footer -->


</div>

<div class="modal fade" id="modalbuatpesanan" xtabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 class="modal-title" id="myModalLabel">Konfirmasi Order ?</h3>
			</div>
			
			<form id="form-cart-detil" name="form-cart-detil" class="form-horizontal" method="POST" action="{{ url('/create_order') }}">
				{!! csrf_field() !!}
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
				<div class="modal-body">
					<div class="table-responsive">
							<?php 
		$l = '';
		
		if(!empty($data))
		{
			//echo "<pre>"; print_r($data);die();

			foreach($data as $k => $v)
			{
				$l .= "<div class=''>
					<div class='col-md-6 col-xs-12' align='left'>
						Order Id : </br>
						Incoterm : 
					</div>
					<div class='col-md-6 col-xs-12' align='right'>
						Vendor : <b class='text-success'>$v[supplier_name]</b> <br/>
						Order Date : 
					</div>
				</div>";

				$l .= "
					<div class='container-fluid'>
						<table class='table table-responsive table-striped'/>
						<thead>
						<tr>
							<th>NO</th>
							<th>MATERIAL ID</th>
							<th>MATERIAL DESCRIPTION</th>
							<th>VENDOR</th>
							<th align='right'>QTY</th>
							<th align='right'>NEW PRICE</th>
							<th align='right'>TOTAL</th>
						</tr>
						</thead>
						<tbody>
				";

				if(!empty($v['detail_order']))
				{
					$no = 1;
					$ppn = 25000;
					$all_harga = 0;
					$total_ppn = 0;
					
					foreach( $v['detail_order'] as $kk => $vv )
					{
						$l .= '<input type="hidden" name="get_no_material[]" value="'.$vv->no_material.'" ';
				
						$total_harga = $vv->quantity*$vv->harga_satuan;
						$quantity = str_replace(".00","",$vv->quantity);
						$harga_satuan = str_replace(".00","",$vv->harga_satuan);

						$l .= "<tr>
							<td>$no</td>
							<td>$vv->no_material</td>
							<td>$vv->material_name</td>
							<td>$vv->supplier_name ($vv->franco)</td>
							<td align='right'>$quantity</td>
							<td align='right'>$harga_satuan</td>
							<td align='right'>$total_harga</td>
						</tr>";
						$no++;
						$all_harga += $total_harga;
					}

					$total_ppn = $ppn+$all_harga;
				}

				$l .= "</tbody></table></div>";

				$l .= "<div class='' align='right'>
						Sub Total : <b class='text-success'>".number_format($all_harga,0,',','.')."</b> <br/>
						PPN : <b class='text-success'>".number_format($ppn,0,',','.')."</b> <br/> 
						Total : <b class='text-success'>".number_format($total_ppn,0,',','.')."</b>
				</div><hr/>";

				//echo "<pre>"; print_r($v);
					/*
					Array
					(
					    [0] => Array
					        (
					            [supplier_code] => 23000001764    
					            [supplier_name] => CENTA BRASINDO ABADI, PT
					            [detail_order] => Array
					                (
					                    [0] => stdClass Object
					                        (
					                            [no_material] => 101010009
					                            [material_name] => METIL METSULFURON 20 WP META PRIMA
					                            [quantity] => 1.00
					                            [harga_satuan] => 7000.00
					                            [supplier_code] => 23000001764    
					                            [supplier_name] => CENTA BRASINDO ABADI, PT
					                            [franco] => RO SAMPIT
					                        )

					                )

					        )

					)
					*/
				
			}
			//die();
			
		}
		else
		{
			$l .= '<center><h3><span class="label label-danger">Anda belum memilih produk</span></h3></center>';
		}
		
		echo $l;
	?>
					</div>
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