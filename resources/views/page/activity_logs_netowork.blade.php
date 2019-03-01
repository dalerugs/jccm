@extends('layout.adminlte')

@section('css')

@endsection

@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Activity Logs</h3>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <table id="dataTable" style="margin-top:50px" class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>DATE & TIME</th>
            <th>MEMBER</th>
            <th>ACTION</th>
            <th>STATUS</th>
            <th>NOTE</th>
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
           url: "{{ route('readActivityLogs') }}",
           type: 'POST',
           dataType: 'json',
           data: {
             'network_id': '{{Auth::user()->network}}'
           },
           encode:true,
           success:function(data) {
             $("#loader").hide();
             var html = "";
             $.each( data, function( key, logs ) {
               var dateTime = new Date(logs.created_at);
                html +=
                "<tr>" +
                  "<td>"+formatDate(dateTime)+"</td>" +
                  "<td>"+logs.member_name+"</td>" +
                  "<td>"+logs.action+"</td>" +
                  "<td>"+(logs.approved==1?'Approved':'Rejected')+"</td>" +
                  "<td>"+logs.notes+"</td>" +
                "</tr>";
                });
                $("#tableBody").html(html);
                $('#dataTable').dataTable( {
                  "ordering": false,
                  "bPaginate": false,
                });
           }
       });
    });

    function formatDate(date) {
      var hours = date.getHours();
      var minutes = date.getMinutes();
      var ampm = hours >= 12 ? 'pm' : 'am';
      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      minutes = minutes < 10 ? '0'+minutes : minutes;
      var strTime = hours + ':' + minutes + ' ' + ampm;
      return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
    }

</script>

@endsection
