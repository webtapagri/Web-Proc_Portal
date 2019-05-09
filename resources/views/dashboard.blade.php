{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', @$title)

@section('content_header')
<!-- <h1>Dashboard</h1> -->
@stop

@section('content')

<style>
.info-box{
	border:1px solid #E0E0E0;
	background-color:#FAFAFA;
	padding:10px;
}
.box-title{
	color:#757575;
	font-weight:bold;
}
</style>

<!-- /.row -->
<div class="row">
    <div class="col-xs-12" style="margin-top:-1%">
        <div class="box">
			
			<form action="{{ url(('/search')) }}" method="post">
				{!! csrf_field() !!}
				<div class="box-header">
					<h3 class="box-title">List of Product</h3>
					<div class="box-tools">
						<div class="input-group input-group-sm">
							<input type="text" id="isearch" name="isearch" class="form-control pull-right" placeholder="Cari material atau supplier">
							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-header -->
			</form>
		
			
            <div class="box-body">
			
				@if(Session::has('message'))
					<div class='col-md-12 col-sm-12 col-xs-12' id="box-alert">
						<p class="alert {{ Session::get('alert-class', 'alert-success') }}"> <i class="fa fa-success"></i> {{ Session::get('message') }}</p>
					</div>
				@endif
			
				<?php 
					//echo "<pre>"; print_r($data);die();
					//echo "<pre>"; print_r(session()->all());
					
					if(count($data) != 0)
					{
						$l = '';
						foreach($data as $k => $v)
						{		
							$price = !empty($v->price_estimate) ? number_format($v->price_estimate,0,',','.') : 0;
							$no_material = base64_encode($v->no_material);
							
							$l .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
							$l .= "
									<div class='info-box text-center'>
										<span class='info-box-text'>Material : </span>
										<span class='info-box-number'>{$v->material_name} </span>
										<span class='info-box-text'>Price : <b>Rp. {$price}</b> </span>
										<span class='info-box-text'>Incoterm : <b>FRC (HO)</b>  </span>
										<span class='info-box-text'>Plant : <b>{$v->plant}</b> </span>
										<span class='info-box-text'>Vendor : <b>{$v->supplier_name}</b> </span>
										<span class='info-box-text'>Franco : <b>{$v->franco}</b> </span>
										<br/>
										
										<a href='cart/add/{$no_material}'><i class='fa fa-2x fa-cart-plus ' aria-hidden='true'></i></a>
									</div>
							";
							$l .= "</div>";
						}
						$l .= '<br/>';
						
						$l .= '<div style="clear:both"></div><center>'.$data->links().'</center>';
						
						echo $l;
					}else{
						echo '<div class="callout callout-danger"><h4>Alert!</h4><p>Data not found.</p></div>';
					}
				?>

			
			</div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style></style>
@stop

@section('js')
<script></script>
@stop 