<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

</html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
  <meta charset="utf-8">
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
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/dist/css/AdminLTE.min.css') }}">
  <!-- skin-blue-admin-lte -->
  <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/dist/css/skins/skin-blue.min.css') }}">
  <!--icheck-->
  <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/iCheck/square/blue.css') }}"> 
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <!-- box search -->
  <link rel="stylesheet" href="{{ asset('css/boxsearch.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css')}}">
    <!-- date rangepicker -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  @yield('css')
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body onload="window.print()" >
        <section >      
        @yield('content')
        </section>
 
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
  <script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>
  <!-- iCheck -->
  <script src="{{ asset('bower_components/admin-lte/plugins/iCheck/icheck.min.js') }}"></script>
  <script src="{{asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.js')}}"></script>
  <script src="{{asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
  <script src="{{asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
  <script src="{{asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('bower_components/jquery.maskMoney/dist/jquery.maskMoney.min.js')}}"></script>
  <!-- date-range-picker -->
  <script src="{{asset('bower_components/moment/min/moment.min.js')}}"></script>
  <script src="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>  
  <!-- auto close alert -->
  <script src="{{asset('js/alert.js')}}"></script>
  <!-- checkbox -->
  <script src="{{asset('js/checkbox.js')}}"></script>
  <!-- mask input date, phone -->
  <script src="{{asset('js/maskinput.js')}}"></script>
  <!-- upload image -->
  <script src="{{asset('js/uploadimage.js')}}"></script>
  <!-- upload file -->
  <script src="{{asset('js/uploadfile.js')}}"></script> 
  <!-- box search-->
  <script src="{{asset('js/dropdown.js')}}"></script>
  <!-- select2 init-->
  <script src="{{asset('js/select2.js')}}"></script>
</body>
</html>