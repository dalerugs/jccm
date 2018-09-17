@extends('layout.adminlte')

@section('css')

@endsection

@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Files Data</h3>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <button style="margin-bottom:20px" id="addNewBtn" class="btn btn-default pull-right" >
        <i style="margin-right:5px" class="fa fa-plus" aria-hidden="true"></i><b>ADD NEW FILE</b>
      </button>
      <table id="dataTable" style="margin-top:50px" class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>NAME</th>
            <th>DESCRIPTION</th>
            <th width="5%">ACTION</th>
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
          <div id="fileFieldView" class="form-group">
              <label>File</label>
              <input class="form-control" type="file" name="file">
              <div style="width: 100px" id="thumb-output"></div>
          </div>
          <div class="form-group">
            <label>Name</label>
            <input class="form-control" type="text" name="name" placeholder="Enter File Name" />
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" rows="5" name="description"></textarea>
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
           url: "{{ route('readFiles') }}",
           success:function(data) {
             $("#loader").hide();
             var html = "";
             $.each( data, function( key, file ) {
                var filepath = "{{asset('files')}}/"+file.filename;
                html +=
                "<tr>" +
                  "<td>"+file.name+"</td>" +
                  "<td>"+file.description+"</td>" +
                  "<td>" +
                  "<a href='"+filepath+"' download='"+file.name+"' target='_blank' class='btn btn-primary btn-block'>Download</a>" +
                  "<button onclick='editBtn("+file.id+")' class='btn btn-info btn-block'>Edit</button>" +
                  "<button onclick='deleteBtn("+file.id+")' class='btn btn-danger btn-block'>Delete</button>" +
                  "</td>" +
                "</tr>";
                });
                $("#tableBody").html(html);
                $('#dataTable').DataTable();
           }
       });
    });


    $( "#addNewBtn" ).click(function() {
      $("#modalTitle").text("Add New File");
      $( "#saveNewBtn" ).show();
      $( "#saveEditBtn" ).hide();
      $( "#fileFieldView" ).show();
      $('input[name="id"]').hide();
      $('input[name="file"]').val("");
      $('input[name="name"]').val("");
      $('input[name="description"]').val("");
      $( "#saveNewBtn").show();
      $( "#saveEditBtn").hide();
      $( "#formModal" ).modal('show');
    });

    $( "#saveNewBtn" ).click(function() {
      $("#loader").show();
      $.ajax({
           url: "{{ route('createFile') }}",
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

    function editBtn(id){
      $("#loader").show();
      $.ajax({
           url: "{{ url('api/showFile') }}/"+id,
           success:function(data) {
             $("#loader").hide();
             console.log(data);
             $('input[name="id"]').show();
             $('input[name="id"]').val(data.id);
             $('input[name="name"]').val(data.name);
             $('textarea[name="description"]').val(data.description);
             $("#modalTitle").text("Edit File");
             $( "#saveEditBtn" ).show();
             $( "#saveNewBtn" ).hide();
             $( "#fileFieldView" ).hide();
             $( "#formModal" ).modal('show');
           }
       });

    }

    $( "#saveEditBtn" ).click(function() {
      $("#loader").show();
      $.ajax({
           url: "{{ route('updateFile') }}",
           type: 'POST',
           dataType: 'json',
           data: $("#dataForm").serialize(),
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
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          $("#loader").show();
          $.ajax({
               url: "{{ url('api/deleteFile') }}/"+id,
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
