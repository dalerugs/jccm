@extends('layout.default')

@section('css')
<link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
@endsection

@section('content')
<div id="loginPage" class="container-fluid" >
  <div class="row">
    <div class="col-md-6">
      <div class="style-2 white title">
        JCCM
      </div>
      <div class="style-2 white subtitle">
        Jesus The Cornerstone Christian Ministries <br /> Members Management System
      </div>
    </div>
    <div class="col-md-5">
      <div class="login-form-container">
        <form action="{{route('doLogin')}}" method="POST">
          {{ csrf_field() }}
          <div class="form-group member-login">
            Sign In
          </div>
          @if($errors->any())
            <p class="text text-danger center">Invalid username or password.</p>
          @endif
          <div class="form-group member-login">
            <p style="display:none" id="loginErrorsView" class="center alert alert-danger body-text"></p>
          </div>
          <div class="form-group">
            <input id="login" type="text" name="username" class="form-control" placeholder="Username" required />
          </div>
          <div class="form-group">
            <input id="password" type="password" name="password" class="form-control" placeholder="• • • • • •" required />
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-block"><b>SIGN IN</b></button>
          </div>
          <!-- <div style="font-size:15px;text-align:center" class="form-group member-login">
            Or
          </div>
          <div class="form-group">
            <a class="btn btn-danger btn-block" href="{{route('sharehub')}}">
              <b>Go To <i class="fa fa-share-alt"></i>&nbsp;ShareHub</b></a>
          </div> -->
        </form>
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
