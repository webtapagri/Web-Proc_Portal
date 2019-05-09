@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="loading-event"></div>
        <button onclick="topFunction()" id="scrToTop" title="Go to top"><i class="fa fa-chevron-up"></i></button>
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu dropdown">

                    <ul class="nav navbar-nav">
						<li class="dropdown notifications-menu">
							<a href="{{ url(('/cart')) }}" class="dropdown-toggle" xdata-toggle="dropdown">
								{!! csrf_field() !!}
								<i class="fa fa-cart-plus"></i>
								<span class="label label-danger">{{ @$totalcartnotif }}</span>
							</a>
					  
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Separated link</a></li>
						  </ul>
						 </li>
					
                        <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                            @else
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                                <!-- <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;"> -->
                                <form id="logout-form" action="{{ url('ldaplogout') }}" method="POST" style="display: none;">
                                    @if(config('adminlte.logout_method'))
                                        {{ method_field(config('adminlte.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li>
						
						
						
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                 <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset('img/user-default.png') }}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                    <p>{{ strtoupper(Session::get('fullname')) }}</p>
                    <a href="#">{{ strtoupper(Session::get('role')) }}</a>
                    </div>
                </div>
                <!-- search form -->
                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    <!-- @each('adminlte::partials.menu-item', $adminlte->menu(), 'item') -->
                    <?php /* 
					<li class="{{ (url('/') == url()->current() ? 'active':'') }}">
						<a style="border-top:1px solid #182225" href="{{ url('/') }}"><i class="fa fa-bar-chart"></i> <span>Dashboard</span></a>
					</li>
                    <li class="treeview menu-open {{ AccessRight::menu() ? '':'hide'}}">
                        <a href="#">
                            <i class="fa fa-th"></i> <span>Main Menu</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" style="display:block">
                             @foreach(AccessRight::menu() as $row) 
                                <li class="{{ (str_replace(url('/').'/','', url()->current()) == $row->url ? 'active':'') }}">
                                    <a href="{{ url(($row->url ? $row->url:'/')) }}">
                                        <i class="fa fa-fw fa-caret-right"></i>
                                        <span>{{ $row->name }}</span>
                                    </a>
                                </li>
                            @endforeach 
                        </ul>
                    </li>
					
                    <li class="{{ (Session::get('role') == 'GUEST' ? 'hide':'') }}  {{ (str_replace(url('/').'/','', url()->current()) == 'profile'? 'active':'') }}">
						<a style="border-top:1px solid #182225" href="{{ url('profile') }}"><i class="fa fa-user"></i> <span>Profile</span></a>
					</li>
                    <li><a href="#" OnClick="logOut()"><i class="fa fa-power-off text-red"></i> <span>Log out</span></a></li>
                    <li><a href=""><i class="fa fa-question text-green"></i> <span>Help</span></a></li>
					*/ ?>
					<li class="{{ (url('/') == url()->current() ? 'active':'') }}">
						<a style="border-top:1px solid #182225" href="{{ url('/') }}"><i class="fa fa-opencart"></i> <span>Item List</span></a>
					</li>
					
					<li class="treeview active">
					  <a href="#">
						<i class="fa fa-cart-arrow-down"></i> <span>My Order</span>
						<i class="fa fa-angle-left pull-right"></i>
					  </a>
					  <ul class="treeview-menu">
						  <li class="<?php echo @$conprogress; ?>"><a href="{{ url('/myorder/on-progress') }}"><i class="fa fa-angle-double-right"></i> On Progress</a></li> 
						  <li class="<?php echo @$cdelivered; ?>"><a href=""><i class="fa fa-angle-double-right"></i> Delivered</a></li>               
					  </ul>
					</li>
					
					<li class="treeview">
					  <a href="#">
						<i class="fa fa-cart-arrow-down"></i> <span>My History</span>
						<i class="fa fa-angle-left pull-right"></i>
					  </a>

					</li>
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js') 
@stop
