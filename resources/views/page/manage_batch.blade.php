@extends('layout.adminlte')

@section('css')

@endsection

@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Batch Data</h3>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <button style="margin-bottom:20px" id="addNewBtn" class="btn btn-default pull-right" >
        <i style="margin-right:5px" class="fa fa-plus" aria-hidden="true"></i><b>ADD NEW BATCH</b>
      </button>
      <table id="dataTable" style="margin-top:50px" class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>NO</th>
            <th>NAME</th>
            <th>DESCRIPTION</th>
            <th width="5%"></th>
          </tr>
        </thead>
        <tbody id="tableBody"></tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="formModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id='modalTitle' class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p class="alert alert-danger" id="errorMsg" style="display:none"></p>
        <form id="dataForm">
          <input style="display:none" type="hidden" name='id' />
          <div class="form-group">
            <label>No.</label>
            <input class="form-control" min="1" type="number" name="no" placeholder="Enter Batch No." />
          </div>
          <div class="form-group">
            <label>Name</label>
            <input class="form-control" type="text" name="name" placeholder="Enter Batch Name" />
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" rows="4" name="description"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
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
           url: "{{ route('readBatch') }}",
           success:function(data) {
             $("#loader").hide();
             var html = "";
             $.each( data, function( key, batch ) {
                html +=
                "<tr>" +
                  "<td>"+batch.no+"</td>" +
                  "<td>"+batch.name+"</td>" +
                  "<td>"+batch.description+"</td>" +
                  "<td>" +
                  "<button onclick='editBtn("+batch.id+")' class='btn btn-info btn-block'>Edit</button>" +
                  "<button onclick='deleteBtn("+batch.id+")' class='btn btn-danger btn-block'>Delete</button>" +
                  "</td>" +
                "</tr>";
                });
                $("#tableBody").html(html);
                $('#dataTable').DataTable();
           }
       });
    });


    $( "#addNewBtn" ).click(function() {
      $("#modalTitle").text("Add New Batch");
      $( "#saveNewBtn" ).show();
      $( "#saveEditBtn" ).hide();
      $('input[name="id"]').hide();
      $('input[name="no"]').val("");
      $('input[name="name"]').val("");
      $('textarea[name="description"]').val("");
      $( "#saveNewBtn").show();
      $( "#saveEditBtn").hide();
      $( "#formModal" ).modal({backdrop: 'static', keyboard: false});
    });

    $( "#saveNewBtn" ).click(function() {
      $("#loader").show();
      $.ajax({
           url: "{{ route('createBatch') }}",
           type: 'POST',
           dataType: 'json',
           data: $("#dataForm").serialize(),
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
               $('#formModal').animate({ scrollTop: 0 }, 'slow');
               $("#errorMsg").fadeIn().delay(3000).fadeOut();
             }
           }
       });
    });

    function editBtn(id){
      $("#loader").show();
      $.ajax({
           url: "{{ url('api/showBatch') }}/"+id,
           success:function(data) {
             $("#loader").hide();
             console.log(data);
             $('input[name="id"]').show();
             $('input[name="id"]').val(data.id);
             $('input[name="no"]').val(data.no);
             $('input[name="name"]').val(data.name);
             $('textarea[name="description"]').val(data.description);
             $("#modalTitle").text("Edit Batch");
             $( "#saveEditBtn" ).show();
             $( "#saveNewBtn" ).hide();
             $( "#formModal" ).modal({backdrop: 'static', keyboard: false});
           }
       });

    }

    $( "#saveEditBtn" ).click(function() {
      $("#loader").show();
      $.ajax({
           url: "{{ route('updateBatch') }}",
           type: 'POST',
           dataType: 'json',
           data: $("#dataForm").serialize(),
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
               $('#formModal').animate({ scrollTop: 0 }, 'slow');
               $("#errorMsg").fadeIn().delay(3000).fadeOut();
             }
           }
       });
    });

    function deleteBtn(id){
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
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          $("#loader").show();
          $.ajax({
               url: "{{ url('api/deleteBatch') }}/"+id,
               success:function(data) {
                 $("#loader").hide();
                 swalWithBootstrapButtons(
                   'Success!',
                   '',
                   'success'
                 ).then(function(){
                    location.reload();
                    }
                 );
               }
           });
        }
      });
    }

</script>

@endsection
