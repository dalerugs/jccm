@extends('layout.adminlte')

@section('css')

@endsection

@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Summarized Report</h3>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <table id="dataTableAll" class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>BATCH</th>
            @foreach(App\Constants::$TRAININGS as $t => $value)
            <th>{{$t}}</th>
            @endforeach
            <th>COMPLETION RATE</th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_pepsol['report'] as $batch)
          @if($batch['PRE']>0)
          <tr>
            <td><b>{{$batch->no." - ".$batch->name}}</b></td>
            @foreach(App\Constants::$TRAININGS as $t => $value)
            <td>{{$batch[$t]}}</td>
            @endforeach
            <td>{{$batch->total}}<span style="font-size: 12px">%</span></td>
          </tr>
          @endif
          @endforeach
          @if($all_pepsol['total']['PRE']>0)
          <tr>
            <td><b>TOTAL</b></td>
            @foreach(App\Constants::$TRAININGS as $t => $value)
            <td>{{$all_pepsol['total'][$t]}}</td>
            @endforeach
            <td>{{$all_pepsol['total']['total']}}<span style="font-size: 12px">%</span></td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Detailed Report</h3>
  </div>
  <div class="box-body">
    <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Filter By Network:</label>
            <select name="filter_network" style="margin-bottom:20px" class="form-control">
              <option disabled selected style="display:none" >Select Network</option>
              @foreach ($networks as $network)
                  <option value="{{$network->id}}" >{{$network->first_name." ".$network->last_name}}</option>
              @endforeach
            </select>
          </div>
        </div>
    </div>
    <div style="display:none" id="networkReportView">
      <div class="table-responsive">
        <table id="dataTable" class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>BATCH</th>
              @foreach(App\Constants::$TRAININGS as $t => $value)
              <th>{{$t}}</th>
              @endforeach
              <th>COMPLETION RATE</th>
            </tr>
          </thead>
          <tbody id="tableBody">
          </tbody>
        </table>
      </div>

      <div style="margin-top:20px;" class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Filter By Level:</label>
              <select name="filter_level" style="margin-bottom:20px" class="form-control">
                <option value="" >All Levels</option>
                @for($i=1;$i<=App\Constants::$MAX_LEVEL;$i++)
                <option value="{{pow(12,$i)}}">{{pow(12,$i)}}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Filter By Leader:</label>
              <select name="filter_leader" style="margin-bottom:20px" class="form-control">
                <option value="" >All Leaders</option>
              </select>
            </div>
          </div>
      </div>
      <div class="table-responsive">
        <table id="dataTableMember" class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>MEMBER</th>
              <th>LEADER</th>
              <th>LEVEL</th>
              <th>BATCH</th>
              @foreach(App\Constants::$TRAININGS as $t => $value)
              <th>{{$t}}</th>
              @endforeach
            </tr>
          </thead>
          <tbody id="tableBodyMember">
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js')

<script>

    var trainings = [
      @foreach(App\Constants::$TRAININGS as $t => $value)
      "{{$t}}",
      @endforeach
    ];

    var trainings_column = [
      @foreach(App\Constants::$TRAININGS as $t => $value)
      "{{$value}}",
      @endforeach
    ];

    var leaders = [];

    $( document ).ready(function() {
      $('#dataTableAll').DataTable({
          "bFilter": false,
          "bInfo": false,
          "ordering": false,
          "paging": false,
          "responsive": true,
      });
      dataTable = $('#dataTable').DataTable({
          "bFilter": false,
          "bInfo": false,
          "ordering": false,
          "paging": false,
          "responsive": true,
      });
      dataTableMember = $('#dataTableMember').DataTable();
    });

    $( "select[name='filter_network']" ).change(function() {
      $("#networkReportView").slideUp();
      $("#loader").show();
      $.ajax({
           url: "{{ url('api/pepsolReport') }}/"+this.value,
           success:function(data) {

             console.log(data);
             var html = "";
             $.each( data.report, function( key, batch ) {
               if(batch['PRE']>0){
                 html +=
                 "<tr>" +
                   "<td><b>"+batch.no+" - "+batch.name+"</b></td>";
                   $.each( trainings, function( key, tr ) {
                     html += "<td>"+batch[tr]+"</td>";
                   });
                 html +="<td>"+batch.total+"<span style='font-size: 12px'>%</span></td>" +
                 "</tr>";
               }
             });
             if(data.total['PRE']>0){
               html +=
               "<tr>" +
                 "<td><b>TOTAL</b></td>";
                 $.each( trainings, function( key, tr ) {
                   html += "<td><b>"+data.total[tr]+"</b></td>";
                 });
               html +="<td>"+data.total.total+"<span style='font-size: 12px'>%</span></td>" +
               "</tr>";
             }

             dataTable.destroy();
             $('#tableBody').html(html);
             dataTable = $('#dataTable').DataTable({
                 "bFilter": false,
                 "bInfo": false,
                 "ordering": false,
                 "paging": false,
                 "responsive": true,
             });

             html = "";



             $.each( data.members, function( key, member ) {
               html +=
               "<tr>" +
                 "<td>"+member.first_name+"  "+member.last_name+"</td>"+
                 "<td>"+member.leader+"</td>"+
                 "<td>"+Math.pow(12,member.level)+"</td>"+
                 "<td>"+member.no+" - "+member.name+"</td>";
                 $.each( trainings_column, function( key, tr ) {
                   html += "<td>"+(member[tr]==1?"<i class='fa fa-check' aria-hidden='true'></i>":"")+"</td>";
                 });
             });

             dataTableMember.destroy();
             $('#tableBodyMember').html(html);
             dataTableMember = $('#dataTableMember').DataTable();

             leaders = data.leaders;
             html = "<option value='' >All Leaders</option>";
             $.each( data.leaders, function( key, leader ) {
               html += "<option value='"+key+"' >"+leader.first_name+" "+leader.last_name+"</option>"
             });
             $("select[name='filter_leader']").html(html);

             $("#loader").hide();
             $("#networkReportView").slideDown();
           }
       });
    });

    $("select[name='filter_level']").change(function() {
      dataTableMember.column(2).search( this.value ).draw();
    });

    $("select[name='filter_leader']").change(function() {
      var leaderName = "";
      if (this.value) {
        var leader = leaders[this.value];
        leaderName = leader.first_name+" "+leader.last_name;
      }
      dataTableMember.column(1).search(leaderName).draw();
      $("select[name='filter_level']").val(Math.pow(12,leader.level+1));
    });



</script>

@endsection
