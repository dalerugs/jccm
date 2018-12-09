@extends('layout.default')

@section('css')
<link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
<style>
#loginPage{
  background-color: #c22327;
}

</style>
@endsection

@section('content')
<div id="loginPage" class="container-fluid" >
  <div class="row">
    <div class="col-md-12">
      <div class="style-2 white title">
        <i class="fa fa-share-alt"></i> ShareHub
      </div>
      <div style="margin-top:-25px" class="style-2 white subtitle">
        ShareHub is a web community of sharing God's Revelation to everyone. <br /> Coming Soon this 2019.
      </div>
    </div>

  </div>
</div>

<div class="container-fluid" >

</div>

@endsection

@section('js')

@endsection
