@extends('layout.adminlte')

@section('css')

@endsection

@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Users Data</h3>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <button style="margin-bottom:20px" id="addNewUserBtn" class="btn btn-default pull-right" >
        <i style="margin-right:5px" class="fa fa-plus" aria-hidden="true"></i><b>ADD NEW USER</b>
      </button>
      <table id="dataTable" style="margin-top:50px" class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>FIRST NAME</th>
            <th>LAST NAME</th>
            <th>USERNAME</th>
            <th>TYPE</th>
            <th width="5%">ACTION</th>
          </tr>
        </thead>
        <tbody id="tableBody"></tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="userModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id='modalTitle' class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p class="alert alert-danger" id="errorMsg" style="display:none"></p>
        <form id="userForm">
          <input style="display:none" type="hidden" name='id' />
          <div class="form-group">
            <label>First Name</label>
            <input class="form-control" type="text" name="first_name" placeholder="Enter First Name" />
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input class="form-control" type="text" name="last_name" placeholder="Enter Last Name" />
          </div>
          <div class="form-group">
            <label>Type</label>
            <select class="form-control" name="type">
                <option value="ADMIN">Admin</option>
                <option value="NET_LEAD">Network Leader</option>
            </select>
          </div>
          <div id="networkView" style="display:none" class="form-group">
            <label>Network</label>
            <select class="form-control" name="network">

            </select>
          </div>
          <div class="form-group">
            <label>Username</label>
            <input class="form-control" type="text" name="username" placeholder="Enter Username" />
          </div>
          <div class="form-group">
            <label>Password</label>
            <input class="form-control" type="password" name="password" placeholder="• • • • • •" />
          </div>
          <div class="form-group">
            <label>Confirm Password</label>
            <input class="form-control" type="password" name="password_confirmation" placeholder="• • • • • •" />
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button style="display:none" id="saveNewUserBtn" type="button" class="btn btn-primary" >Save</button>
        <button style="display:none" id="saveEditUserBtn" type="button" class="btn btn-primary" >Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js')

<script>

    $( document ).ready(function() {
      $("#loader").show();
      $.ajax({
           url: "{{ route('readUsers') }}",
           success:function(data) {
             $("#loader").hide();
             var html = "";
             $.each( data, function( key, user ) {
                html +=
                "<tr>" +
                  "<td>"+user.first_name+"</td>" +
                  "<td>"+user.last_name+"</td>" +
                  "<td>"+user.username+"</td>" +
                  "<td>"+(user.type=="ADMIN"?"Admin":"Network Leader")+"</td>" +
                  "<td>" +
                  "<button onclick='editUserBtn("+user.id+")' class='btn btn-info btn-block'>Edit</button>" +
                  "<button onclick='deleteUserBtn("+user.id+")' class='btn btn-danger btn-block'>Delete</button>" +
                  "</td>" +
                "</tr>";
                });
                $("#tableBody").html(html);
                $('#dataTable').DataTable();
           }
       });
    });


    $( "#addNewUserBtn" ).click(function() {
      $("#modalTitle").text("Add New User");
      $( "#saveNewUserBtn" ).show();
      $( "#saveEditUserBtn" ).hide();
      $('input[name="id"]').hide();
      $('input[name="first_name"]').val("");
      $('input[name="last_name"]').val("");
      $('select[name="type"]').val("ADMIN").change();
      $('input[name="username"]').val("");
      $( "#userModal" ).modal('show');

    });

    $("select[name='type']").on('change', function() {
        if(this.value == "NET_LEAD"){
          $("#networkView").fadeIn();
        }else {
          $("#networkView").fadeOut();
          $("select[name='network']").val("");
        }
    });

    $( "#saveNewUserBtn" ).click(function() {
      $("#loader").show();
      $.ajax({
           url: "{{ route('createUser') }}",
           type: 'POST',
           dataType: 'json',
           data: $("#userForm").serialize(),
           encode:true,
           success:function(data) {
             $("#loader").hide();
             if (data.success) {
               swal({
                 title: "Success!",
                 text: "Data was succesfully saved.",
                 type:
                 "success"
               }).then(function(){
                  location.reload();
                  }
               );
             }
             else{
               var html = "";
               $.each( data.errors, function( key, value ) {
                   html += "• "+value+"<br />";
               });
               $("#errorMsg").html(html);
               $("#errorMsg").fadeIn().delay(3000).fadeOut();
             }
           }
       });
    });

    function editUserBtn(id){
      $("#loader").show();
      $.ajax({
           url: "{{ url('api/showUser') }}/"+id,
           success:function(data) {
             $("#loader").hide();
             console.log(data);
             $('input[name="id"]').show();
             $('input[name="id"]').val(data.id);
             $('input[name="first_name"]').val(data.first_name);
             $('input[name="last_name"]').val(data.last_name);
             $('select[name="type"]').val(data.type).change();
             $('input[name="username"]').val(data.username);
             $("#modalTitle").text("Edit User");
             $( "#saveEditUserBtn" ).show();
             $( "#saveNewUserBtn" ).hide();
             $( "#userModal" ).modal('show');
           }
       });

    }

    $( "#saveEditUserBtn" ).click(function() {
      $("#loader").show();
      $.ajax({
           url: "{{ route('updateUser') }}",
           type: 'POST',
           dataType: 'json',
           data: $("#userForm").serialize(),
           encode:true,
           success:function(data) {
             $("#loader").hide();
             if (data.success) {
               swal({
                 title: "Success!",
                 text: "Data was succesfully saved.",
                 type:
                 "success"
               }).then(function(){
                  location.reload();
                  }
               );
             }
             else{
               var html = "";
               $.each( data.errors, function( key, value ) {
                   html += "• "+value+"<br />";
               });
               $("#errorMsg").html(html);
               $("#errorMsg").fadeIn().delay(3000).fadeOut();
             }
           }
       });
    });

    function deleteUserBtn(id){
      const swalWithBootstrapButtons = swal.mixin({
        confirmButtonClass: 'btn btn-success margin-10',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
      });

      swalWithBootstrapButtons({
        title: 'Are you sure?',
        text: "You won't be able to revert this action!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          $("#loader").show();
          $.ajax({
               url: "{{ url('api/deleteUser') }}/"+id,
               success:function(data) {
                 $("#loader").hide();
                 swalWithBootstrapButtons(
                   'Deleted!',
                   'Data has been deleted.',
                   'success'
                 ).then(function(){
                    location.reload();
                    }
                 );
               }
           });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons(
            'Cancelled',
            '',
            'error'
          );
        }
      });
    }

</script>

@endsection
