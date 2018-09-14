@extends('layout.default')

@section('css')
<link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="loginPage" class="container-fluid" >
  <div class="row">
    <div class="col-md-6">
      <div class="style-2 white title">
        JCCM
      </div>
      <div class="style-2 white subtitle">
        Jesus The Cornerstone Christian Ministries
      </div>
    </div>
    <div class="col-md-5">
      <div class="login-form-container">
        <form>
          <div class="form-group member-login">
            Sign In
          </div>
          <div class="form-group member-login">
            <p style="display:none" id="loginErrorsView" class="center alert alert-danger body-text"></p>
          </div>
          <div class="form-group">
            <input id="login" type="text" name="login" class="form-control" placeholder="Username" />
          </div>
          <div class="form-group">
            <input id="password" type="password" name="password" class="form-control" placeholder="• • • • • •" />
          </div>
          <div class="form-group">
            <button onclick="signInButton()" class="btn btn-primary btn-block"><b>SIGN IN</b></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')

@endsection
