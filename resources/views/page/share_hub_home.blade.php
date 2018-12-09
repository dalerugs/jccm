@extends('layout.default')

@section('css')
<link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
<style>
body{
  background: #c22327 !important;
}

@media only screen and (max-width: 600px) {
  .title{
    font-size: 50px;
    margin-top: 50%;
  }
  .subtitle{
    font-size: 20px;
  }

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
      <br />
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
