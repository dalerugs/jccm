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
          <div class="form-group member-login">
            Create New Password
          </div>
          <p style="font-size:20px;margin-top:-15px" class="form-group member-login text text-info">
            You must change your password to continue.
          </p>
            <p style="display:none" id="errorMsg" class="text text-danger center"></p>
          <div class="form-group member-login">
            <p style="display:none" id="loginErrorsView" class="center alert alert-danger body-text"></p>
          </div>
          <div class="form-group">
            <input id="login" type="password" name="password" class="form-control" placeholder="Password" />
          </div>
          <div class="form-group">
            <input id="password" type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" />
          </div>
          <div class="form-group">
            <button onclick="changePasswordBtn()" class="btn btn-primary btn-block"><b>Proceed</b></button>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid" >

</div>

@endsection

@section('js')
<script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
<script>

function changePasswordBtn(){
  $("#loader").show();
  $.ajax({
       url: "{{ route('changePasswordApi') }}",
       type: 'POST',
       dataType: 'json',
       data: {
         'id' : {{Auth::user()->id}},
         'password' : $('input[name="password"]').val(),
         'password_confirmation' : $('input[name="password_confirmation"]').val(),
       },
       encode:true,
       success:function(data) {
         $("#loader").hide();
         if (data.success) {
           swal({
             title: "Success!",
             text: "",
             type:
             "success"
           }).then(function(){
              window.location.href = "{{route('dashboard')}}";
              }
           );
         }
         else{
           var html = "";
           $.each( data.errors, function( key, value ) {
               html += "• "+value+"<br />";
           });
           $("#errorMsg").html(html);
           $('#formModal').animate({ scrollTop: 0 }, 'slow');
           $("#errorMsg").fadeIn().delay(3000).fadeOut();
         }
       }
   });
}


</script>

@endsection
