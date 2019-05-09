@extends('adminlte::page')
@section('title', 'FMDB - 404')
@section('content')
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-green"> 404</h2>
        <br>
        <div class="error-content">
          <h3><i class="fa fa-warning text-green"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="{{ url('/') }}" class="text-green">return to dashboard</a>.
          </p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
@stop
@section('js')
@stop