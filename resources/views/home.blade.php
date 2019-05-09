@extends('adminlte::page')

@section('title', 'PROCUREMENT PORTAL - Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<style>
   
</style>

<p>You are logged in!</p>
<div class="alert alert-danger alert-dismissible" style="display:{{ (Session::get('role') == 'GUEST' ? 'show':'none') }}">
    <h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
    Anda belum memiliki hak akses, silahkan menghubungi technical support untuk mendapat akses dari aplikasi ini.
</div>
@stop
@section('js')

@stop 