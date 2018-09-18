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
                var filepath = "{{asset('files_upload')}}/"+file.filename;
                html +=
                "<tr>" +
                  "<td>"+file.name+"</td>" +
                  "<td>"+file.description+"</td>" +
                  "<td>" +
                  "<a href='"+filepath+"' download='"+file.name+"' target='_blank' class='btn btn-primary btn-block'>Download</a>" +
                  "</td>" +
                "</tr>";
                });
                $("#tableBody").html(html);
                $('#dataTable').DataTable();
           }
       });
    });

</script>

@endsection
