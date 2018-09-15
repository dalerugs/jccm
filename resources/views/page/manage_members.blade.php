@extends('layout.adminlte')

@section('css')

@endsection

@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Members Data</h3>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <button style="margin-bottom:20px" id="addNewBtn" class="btn btn-default pull-right" >
        <i style="margin-right:5px" class="fa fa-plus" aria-hidden="true"></i><b>ADD NEW MEMBER</b>
      </button>
      <table id="dataTable" style="margin-top:50px" class="table table-hover table-bordered">
        <thead>
          <tr>
            <th></th>
            <th>NAME</th>
            <th>NETWORK</th>
            <th>LEADER</th>
            <th>LEVEL</th>
            <th>STATUS</th>
            <th>ACTION</th>
          </tr>
        </thead>
        <tbody id="tableBody"></tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="formModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id='modalTitle' class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p class="alert alert-danger" id="errorMsg" style="display:none"></p>
        <form id="dataForm" enctype="multipart/form-data">
          <input style="display:none" type="hidden" name='id' />
          <div class="col-md-6">
            <div class="form-group">
              <h4><b>INFORMATION</b></h4>
            </div>
            <div class="form-group">
              <label>First Name</label>
              <input class="form-control" type="text" name="first_name" placeholder="Enter First Name" />
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input class="form-control" type="text" name="last_name" placeholder="Enter Last Name" />
            </div>
            <div class="form-group">
              <label>Birth Date</label>
              <input class="form-control" type="date" name="birth_date" />
            </div>
            <div class="form-group">
              <label>Sex</label>
              <select class="form-control choose" name="sex">
                  <option selected value disabled value="">Select Sex</option>
                  <option value="MALE">Male</option>
                  <option value="FEMALE">Female</option>
              </select>
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea class="form-control" rows="2" name="address"></textarea>
            </div>
            <div class="form-group">
              <label>Level</label>
              <select class="form-control choose" name="level">
                  <option value="" disabled selected value>Select Level</option>
                  @for($i=1;$i<=5;$i++)
                  <option value="{{$i}}">{{pow(12,$i)}}</option>
                  @endfor
              </select>
            </div>
            <div id="networkLeaderView" style="display:none" class="form-group">
              <label>Network Leader</label>
              <select class="form-control choose" name="network_id">
                  <option value="" disabled selected value>Select Network Leader</option>
              </select>
            </div>
            <div id="leaderView" style="display:none" class="form-group">
              <label>Leader</label>
              <select class="form-control choose" name="leader_id">
                  <option value="" disabled selected value>Select Leader</option>
              </select>
            </div>
            <div class="form-group">
                <label>Picture</label>
                <input class="form-control" accept="image/*" type="file" name="picture">
                <div style="width: 100px" id="thumb-output"></div>
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">
              <h4><b>PEPSOL / BAPTISM</b></h4>
            </div>
            <div class="form-group">
              <label>Batch</label>
              <select class="form-control choose" name="batch">
                  <option value="" disabled selected value>Select Batch</option>
                  @foreach ($batches as $batch)
                      <option value="{{$batch->id}}" >{{$batch->no." - ".$batch->name}}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Pre Encounter</label>
              <select class="form-control" name="pre_encounter">
                  <option value="0" >Not yet completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>Encounter</label>
              <select class="form-control" name="encounter">
                  <option value="0" >Not yet completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>Post Encounter</label>
              <select class="form-control" name="post_encounter">
                  <option value="0" >Not yet completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>SOL 1</label>
              <select class="form-control" name="sol1">
                  <option value="0" >Not yet completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>SOL 2</label>
              <select class="form-control" name="sol2">
                  <option value="0" >Not yet completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>Re Encounter</label>
              <select class="form-control" name="re_encounter">
                  <option value="0" >Not yet completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>SOL 3</label>
              <select class="form-control" name="sol3">
                  <option value="0" >Not yet completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>Baptism</label>
              <select class="form-control" name="baptism">
                  <option value="" disabled selected value>Select Baptism Year</option>
              </select>
            </div>
          </div>

        </form>
      </div>
      <div style="border:none" class="modal-footer">
        <button style="display:none" id="saveNewBtn" type="button" class="btn btn-primary" >Save</button>
        <button style="display:none" id="saveEditBtn" type="button" class="btn btn-primary" >Save</button>
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
           url: "{{ route('readMembers') }}",
           success:function(data) {
             $("#loader").hide();
             var html = "";
             $.each( data, function( key, user ) {
                html +=
                "<tr>" +
                  "<td><img width='80px' src='{{ asset('dp') }}/"+user.dp_filename+"' /></td>" +
                  "<td>"+user.first_name+" "+user.last_name+"</td>" +
                  "<td>"+user.network_leader+"</td>" +
                  "<td>"+user.leader+"</td>" +
                  "<td>"+Math.pow(12, user.level)+"</td>" +
                  "<td>"+(user.inactive?"Inactive":"Active")+"</td>" +
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


    $( "#addNewBtn" ).click(function() {
      $("#modalTitle").text("Add New Member");
      $( "#saveNewBtn" ).show();
      $( "#saveEditBtn" ).hide();
      $('input[name="id"]').hide();
      $('input[name="first_name"]').val("");
      $('input[name="last_name"]').val("");
      $('input[name="birth_date"]').val("");
      $('select[name="sex"]').val("").change();
      $('textarea[name="address"]').val("");
      $('select[name="level"]').val("").change();
      $('select[name="network_id"]').val("").change();
      $('select[name="leader_id"]').val("").change();
      $('input[name="picture"]').val("").change();
      $('select[name="batch"]').val("").change();
      $('select[name="pre_encounter"]').val("0").change();
      $('select[name="encounter"]').val("0").change();
      $('select[name="post_encounter"]').val("0").change();
      $('select[name="sol1"]').val("0").change();
      $('select[name="sol2"]').val("0").change();
      $('select[name="re_encounter"]').val("0").change();
      $('select[name="sol3"]').val("0").change();
      $('select[name="baptism"]').val("").change();

      $( "#formModal" ).modal('show');
    });

    $("select[name='level']").on('change', function() {
        if(this.value > "1"){
          $("#networkLeaderView").fadeIn();
        }else {
          $("#networkLeaderView").fadeOut();
        }

        if(this.value > "2"){
          $("#leaderView").fadeIn();
        }else {
          $("#leaderView").fadeOut();
        }
    });

    $( "#saveNewBtn" ).click(function() {
      $("#loader").show();
      $.ajax({
           url: "{{ route('createMember') }}",
           type: 'POST',
           data: new FormData($("#dataForm")[0]),
           processData: false,
           contentType: false,
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
