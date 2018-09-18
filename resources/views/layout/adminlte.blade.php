<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'JCCM') }} | {{$page_title}}</title>

    <link rel="icon" href="{{ asset('img/fav1.jpg') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('img/fav1.jpg') }}" type="image/x-icon"/>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('css/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('css/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap3-wysihtml5.min.css') }}">
    <!-- Google Font -->

    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/global.css') }}" rel="stylesheet" type="text/css">
    @yield('css')
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div style="display:none" id="loader" class="overlay">
      <div style="margin-top:15%" class="row">
          <div class="col-md-12">
              <img width="400px" class="center-block" src="{{asset('img/loader.gif')}}">
          </div>
      </div>
  </div>
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{route('dashboard')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>JCCM</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>JCCM TONDO</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('dp/'.$profile_picture) }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{{Auth::user()->first_name." ".Auth::user()->last_name}}}</p>
          <a href="{{route('logout')}}"><i class="fa fa-sign-out text-danger"></i> Sign out</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN MENU</li>
    <li id="dashboardNav" >
      <a href="{{route('dashboard')}}">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>
    @if(Auth::user()->type=="NET_LEAD")
		<li id="networksNav" >
      <a href="#">
        <i class="fa fa-sitemap"></i> <span>My Network</span>
      </a>
    </li>
    @endif
		<li id="membersNav" >
      <a href="{{route('members')}}">
        <i class="fa fa-users"></i> <span>Members</span>
      </a>
    </li>
		<li id="pepsolNav" >
      <a href="{{route('pepsol')}}">
        <i class="fa fa-line-chart"></i> <span>PEPSOL Report</span>
      </a>
    </li>
		<li id="filesNav" >
      <a href="{{route('files')}}">
        <i class="fa fa-files-o"></i> <span>Files</span>
      </a>
    </li>
    @if(Auth::user()->type=="ADMIN")
    <li id="adminNav" >
      <a href="{{route('admin')}}">
        <i class="fa fa-lock"></i> <span>Admin</span>
      </a>
    </li>
    @endif
  </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$page_title}}
        <small>{{$page_description}}</small>
      </h1>
    </section>

<!-- Main content -->
<section class="content">
@yield('content')

</section>
   <!-- /.content -->
 </div>
 <!-- /.content-wrapper -->
 <footer class="main-footer">
   <div class="pull-right hidden-xs">
     <b>Version</b> 1.0
   </div>
   <strong>Copyright &copy; 2018 <a href="{{route('dashboard')}}">JCCM Members Management System</a>.</strong> All rights
   reserved.
 </footer>
</div>
<!-- ./wrapper -->




<!-- jQuery 3 -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{asset('js/raphael.min.js')}}"></script>
<script src="{{asset('js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('js/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{asset('js/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('js/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('js/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('js/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('js/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('js/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/js/demo.js')}}"></script>

<script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

<script src="{{asset('/js/jquery.dataTables.min.js')}}"></script>

<script>
    $('#'+"{{$active}}").addClass("active");
</script>

@yield('js')

</body>

</html>
