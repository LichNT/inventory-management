<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"></html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'HP') }}</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- bootstrap css -->  
  <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome css -->  
  <link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">  
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/dist/css/AdminLTE.min.css') }}">
  <!-- skin-blue-admin-lte -->
  <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/dist/css/skins/skin-purple.min.css') }}">  
  <!--icheck-->
  <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/iCheck/square/green.css') }}">
  <!-- Pace style -->
  <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/pace/pace.min.css')}}">
  <!--all css -->
  <link rel="stylesheet" href="{{ asset('css/all.css') }}">
  @yield('css')
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="skin-purple sidebar-mini sidebar-collapse fixed">
<div class="wrapper">
  <!-- Main Header -->
  @include('layouts.header')
  <!-- Left side column. contains the logo and sidebar -->
  @include('layouts.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">    
    <!-- Main content -->
    <section class="form-detail">
        @yield('content')      
    </section>        
  </div>
  @include('layouts.alert')
  <!-- /.content-wrapper -->  
  @include('layouts.footer');

  <!-- Control Sidebar -->
    @include('layouts.sidebar-dark');
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('bower_components/admin-lte/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{asset('bower_components/jquery.maskMoney/dist/jquery.maskMoney.min.js')}}"></script>
<!-- base js-->
<script src="{{asset('js/min/base.min.js')}}"></script> 
<script src="{{asset('js/downloadexcel.js')}}"></script>
 <!-- PACE -->
 <script src="{{ asset('bower_components/admin-lte/plugins/pace/pace.min.js')}}"></script>
@yield('script')
</body>
</html>