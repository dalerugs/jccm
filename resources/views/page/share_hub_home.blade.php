@extends('layout.default')

@section('css')
<link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="loginPage" class="container-fluid" >
  <div class="row">
    <div class="col-md-12">
      <div class="style-2 white title">
        ShareHub
      </div>
      <div class="style-2 white subtitle">
        ShareHub is a web community of sharing God's Revelation to everyone. <br /> Coming Soon this 2019.
      </div>
    </div>

  </div>
  <!-- <div class="row">
    <div class="col-md-1 col-md-offset-11 hidden-xs">
      <div id="footer" class="style-2 white subtitle">
        {{getHostByName(getHostName())}}
      </div>
    </div>
  </div> -->
</div>

<div class="container-fluid" >

</div>

@endsection

@section('js')

@endsection
