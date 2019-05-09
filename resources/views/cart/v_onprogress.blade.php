{{-- resources/views/cart/v_cart.blade.php --}}

@extends('adminlte::page')

@section('title', @$title)

@section('content_header')
<span class="label" style="font-weight:bold;font-size:20px;color:#F44336"><i class="fa fa-shopping-cart"></i> MY ORDER</span>
@stop

@section('content')

<!-- TABLE: LATEST ORDERS -->
<div class="box box-danger">
<div class="box-header with-border">
  <h3 class="box-title">On Progress</h3>
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
	  <tr align="center">
		<th>NO ORDER</th>
		<th>NO PO</th>
		<th>ITEM</th>
		<th>TOTAL HARGA (RP.)</th>
		<th>STATUS</th>
	  </tr>
	  </thead>
	  <tbody>
	  
	  <?php 
	  
		$l = '';
		if(!empty($data))
		{
			$total_harga = 0;
			foreach( $data as $k => $v )
			{
				$total_harga = @$v->quantity*$v->harga_satuan;
				$l .= '  <tr>
							<td>'.$v->id_order.'</td>
							<td>'.$v->po_order.'</td>
							<td><a href="#">'.$v->material_name.'</a></td>
							<td align="right">'.number_format(@$total_harga,0,',',',').'</td>
							<td><span class="label label-warning">'.$v->status.'</span></td>
						  </tr>';
			}
			
		}
		echo $l;
	  
	  ?>
	  </tbody>
	</table>
	
	<?php echo '<div style="clear:both"></div><center>'.$data->links().'</center>'; ?>
  </div>
  <!-- /.table-responsive -->
</div>
<!-- /.box-body -->
<div class="box-footer clearfix"></div>
<!-- /.box-footer -->
</div>

<div class="modal fade" id="modalbuatpesanan" xtabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 class="modal-title" id="myModalLabel">Konfirmasi Buat Pesanan ?</h3>
			</div>
			<form id="form-detil" name="form-detil" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				<div class="modal-body">
				
					  <div class="table-responsive">
							<table class="table no-margin">
							  <thead>
							  <tr>
								<th>Item</th>
								<th>Harga Satuan</th>
								<th>Kuantitas</th>
								<th>Total Harga</th>
							  </tr>
							  </thead>
							  <tbody>
							  <tr>

								<td><a href="#">SHELL,PALM (CANGKANG)</a></td>
								<td>Rp. 10,000</td>
								<td>
								  <span class="xlabel" style="font-size:20px">3</span>
								</td>
								<td>Rp. 30,000</td>
							  </tr>
							  <tr>

								<td><a href="#">CRUDE PALM OIL</a></td>
								<td>Rp. 20,000</td>
								<td>
								  <span class="xlabel" style="font-size:20px">2</span>
								</td>
								<td>Rp. 40,000</td>
							  </tr>
							  <tr>

								<td><a href="#">FIBER (FIBRE)</a></td>
								<td>Rp. 10,000</td>
								<td>
								  <span class="xlabel" style="font-size:20px">3</span>
								</td>
								<td>Rp. 30,000</td>
							  </tr>
							  <tr>
								<td><a href="#">TSHELL,PALM (CANGKANG)</a></td>
								<td>Rp. 15,000</td>
								<td>
								  <span class="xlabel" style="font-size:20px">2</span>
								</td>
								<td>Rp. 30,000</td>
							  </tr>
							  <tr>
								<td><a href="#">FFB-FRESH FRUIT BUNCH</a></td>
								<td>Rp. 30,000</td>
								<td>
								  <span class="xlabel" style="font-size:20px">4</span>
								</td>
								<td>Rp. 120,000</td>
							  </tr>
							  <tr style="font-weight:bold">
								<td colspan="3" align="right"><span class="label label-success" style="font-weight:bold;font-size:18px">TOTAL HARGA</span></td>
								<td align="left"><span class="label label-success" style="font-weight:bold;font-size:18px">Rp. 250,000</span></td>
							  </tr>
							   <tr style="font-weight:bold">
								<td colspan="3" align="right"><span class="label label-success" style="font-weight:bold;font-size:18px">PPN</span></td>
								<td align="left"><span class="label label-success" style="font-weight:bold;font-size:18px">Rp. 20,000</span></td>
							  </tr>
							  <tr style="font-weight:bold">
								<td colspan="3" align="right"><span class="label label-success" style="font-weight:bold;font-size:18px">TOTAL</span></td>
								<td align="left"><span class="label label-success" style="font-weight:bold;font-size:18px">Rp. 270,000</span></td>
							  </tr>
							  </tbody>
							</table>
						  </div>
						  <!-- /.table-responsive -->

				</div>

				<div class="modal-footer">
					<button class="btn btn-flat btn-lg btn-info" data-dismiss="modal" aria-hidden="true">Cancel</button>
					<button class="btn btn-flat btn-lg btn-danger" data-dismiss="modal" aria-hidden="true" id="yesorder">Yes, Order Now</button>
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
$("#yesorder").click(function(){
	var redirectToURL = '/myorder/on-progress';
	window.location.href = redirectToURL;
});
</script>
@stop 