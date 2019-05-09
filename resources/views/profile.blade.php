@extends('adminlte::page')
@section('title', 'FMDB - Profile')
@section('content')
<section class="content">

      <div class="row">
        <div class="col-xs-6">
            <!-- Profile Image -->
            <div class="box box-success">
                <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="{{ asset('img/user-default.png') }}" alt="User profile picture">

                <h3 class="profile-username text-center">{{ $profile[0]->nama }}</h3>

                <p class="text-muted text-center">{{ $profile[0]->role_name }}</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                    <b>Username</b> <a class="pull-right">{{ $profile[0]->username }}</a>
                    </li>
                    <li class="list-group-item">
                    <b>Email</b> <a class="pull-right">{{ $profile[0]->email }}</a>
                    </li>
                    <li class="list-group-item">
                    <b>Job Code</b> <a class="pull-right">{{ $profile[0]->job_code }}</a>
                    <li class="list-group-item">
                    <b>NIK</b> <a class="pull-right">{{ $profile[0]->nik }}</a>
                    <li class="list-group-item">
                    <b>Area Code</b> <a class="pull-right">{{ $profile[0]->area_code }}</a>
                    </li>
                </ul>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
      </div>
</section>
@stop
@section('js')
          
@stop