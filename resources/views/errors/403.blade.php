@extends('adminlte::page')
@section('title', 'FMDB - 403')
@section('content')
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-green"> 403</h2>
        <br>
        <div class="error-content">
          <h3><i class="fa fa-warning text-green"></i> Oops! Unauthorized.</h3>

          <p>
            Access s danied due to invalid credential.
            You do not have permission to view this page using the credentials that you supplied, you may <a href="{{ url('/') }}" class="text-green">return to dashboard</a>.
          </p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
@stop
@section('js')
@stop