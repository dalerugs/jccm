@extends('layout.adminlte')

@section('css')

@endsection

@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Members Data</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <form id="filterForm">
        <div class="col-md-3">
          <div class="form-group">
            <label>Filter By Network:</label>
            <select name="filter_network" style="margin-bottom:20px" class="form-control">
              <option value="" >All Networks</option>
              @foreach ($networks as $network)
                  <option value="{{$network->id}}" >{{$network->first_name." ".$network->last_name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Filter By Level:</label>
            <select name="filter_level" style="margin-bottom:20px" class="form-control">
              <option value="" >All Levels</option>
              @for($i=1;$i<=5;$i++)
              <option value="{{$i}}">{{pow(12,$i)}}</option>
              @endfor
            </select>
          </div>

        </div>
        <div id='filterLeaderView' style="display:none" class="col-md-3">
          <div class="form-group">
            <label>Filter By Leader:</label>
            <select name="filter_leader" style="margin-bottom:20px" class="form-control">
              <option value="" >All Leaders</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Filter By Status:</label>
            <select name="filter_status" style="margin-bottom:20px" class="form-control">
              <option value="" >All Status</option>
              <option value="0" >Active</option>
              <option value="1" >Inactive</option>
            </select>
          </div>
        </div>
      </form>
    </div>
    <div class="table-responsive">
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

<div id="viewModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View Member</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <img  id="dp"  width='100%' src="" />
          </div>
          <div class="col-md-8">
            <div class="table-responsive">
              <table class="table table-bordered">
                <tr>
                  <th style="text-align:center" colspan="2">INFORMATION</th>
                </tr>
                <tr>
                  <th>Name:</th>
                  <td id="name" ></td>
                </tr>
                <tr>
                  <th>Sex:</th>
                  <td id="sex" ></td>
                </tr>
                <tr>
                  <th>Birth Date:</th>
                  <td id="birthDate" ></td>
                </tr>
                <tr>
                  <th>Age:</th>
                  <td id="age" ></td>
                </tr>
                <tr>
                  <th>Address:</th>
                  <td id="address" ></td>
                </tr>
                <tr>
                  <th>Level:</th>
                  <td id="level" ></td>
                </tr>
                <tr>
                  <th>Network Leader:</th>
                  <td id="networkLeader" ></td>
                </tr>
                <tr>
                  <th>Leader:</th>
                  <td id="leader" ></td>
                </tr>
                <tr>
                  <th style="text-align:center" colspan="2">PEPSOL & BAPTISM</th>
                </tr>
                <tr>
                  <th>Batch:</th>
                  <td id="batch" ></td>
                </tr>
                <tr>
                  <th>Pre Encounter:</th>
                  <td id="preEncounter" ></td>
                </tr>
                <tr>
                  <th>Encounter:</th>
                  <td id="encounter" ></td>
                </tr>
                <tr>
                  <th>Post Encounter:</th>
                  <td id="postEncounter" ></td>
                </tr>
                <tr>
                  <th>SOL 1:</th>
                  <td id="sol1" ></td>
                </tr>
                <tr>
                  <th>SOL 2:</th>
                  <td id="sol2" ></td>
                </tr>
                <tr>
                  <th>Re Encounter:</th>
                  <td id="reEncounter" ></td>
                </tr>
                <tr>
                  <th>SOL 3:</th>
                  <td id="sol3" ></td>
                </tr>
                <tr>
                  <th>BAPTISM:</th>
                  <td id="baptism" ></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js')

<script>

    var members = [];
    var dataTable;

    $( document ).ready(function() {
      $("#loader").show();
      $.ajax({
           url: "{{ route('readMembers') }}",
           success:function(data) {
             $("#loader").hide();
             leaders = data.leaders;
             var html = "";
             $.each( data.members, function( key, member ) {
                html +=
                "<tr>" +
                  "<td><img width='80px' src='{{ asset('dp') }}/"+member.dp_filename+"' /></td>" +
                  "<td>"+member.first_name+" "+member.last_name+"</td>" +
                  "<td>"+member.network_leader+"</td>" +
                  "<td>"+member.leader+"</td>" +
                  "<td>"+Math.pow(12, member.level)+"</td>" +
                  "<td>"+(member.inactive?"Inactive":"Active")+"</td>" +
                  "<td>" +
                  "<button onclick='viewBtn("+member.id+")' class='btn btn-primary btn-block btn-sm'>View</button>" +
                  "</td>" +
                "</tr>";
                });
                $("#tableBody").html(html);
                dataTable = $('#dataTable').DataTable();
           }
       });
    });

    $("#filterForm").on('change', function() {
      $("#loader").show();
      var networkId = $("select[name='filter_network']").val();
      var level =   $("select[name='filter_level']").val();
      var leader =   $("select[name='filter_leader']").val();
      var inactive =   $("select[name='filter_status']").val();
      var oldNetworkId = "";
      var oldLevel = "";

      if ($('select[name="filter_level"]').val() > 2) {
        if (!leader || networkId!=oldNetworkId || level!=oldLevel) {
          var html = "<option value=''>All Leaders</option>";
          oldNetworkId = networkId;
          oldLevel = level;
          $.each( leaders, function( key, leader ) {
            if (networkId) {
              if (leader.network_id == networkId && leader.level==(parseInt(level)-1)) {
                html += "<option value='"+leader.id+"' >"+leader.first_name+" "+leader.last_name+"</option>";
              }
            }else {
              if (leader.level==(parseInt(level)-1)) {
                html += "<option value='"+leader.id+"' >"+leader.first_name+" "+leader.last_name+"</option>";
              }
            }

           });
           $("select[name='filter_leader']").html(html);
        }

        $('#filterLeaderView').fadeIn()

      }else {
        $('#filterLeaderView').fadeOut()
         $("select[name='filter_leader']").val("");
       }

      $.ajax({
           url: "{{ route('readMembersWithFilter') }}",
           type: 'POST',
           dataType: 'json',
           data: {
             'network_id': networkId,
             'level': level,
             'leader_id': leader,
             'inactive': inactive,
           },
           encode:true,
           success:function(data) {
             $("#loader").hide();
             console.log(data);
             var html = "";
             $.each( data, function( key, member ) {
                html +=
                "<tr>" +
                  "<td><img width='80px' src='{{ asset('dp') }}/"+member.dp_filename+"' /></td>" +
                  "<td>"+member.first_name+" "+member.last_name+"</td>" +
                  "<td>"+member.network_leader+"</td>" +
                  "<td>"+member.leader+"</td>" +
                  "<td>"+Math.pow(12, member.level)+"</td>" +
                  "<td>"+(member.inactive?"Inactive":"Active")+"</td>" +
                  "<td>" +
                  "<button onclick='viewBtn("+member.id+")' class='btn btn-primary btn-block btn-sm'>View</button>" +
                  "</td>" +
                "</tr>";
                });
                dataTable.destroy();
                $("#tableBody").html(html);
                dataTable = $('#dataTable').DataTable();


           }
       });
    });

    function viewBtn(id){
      $("#loader").show();
      $.ajax({
           url: "{{ url('api/showMember') }}/"+id,
           success:function(member) {
             console.log(member);
             $('#dp').attr('src',"{{ asset('dp') }}/"+member.dp_filename);
             $('#name').text(member.first_name+" "+member.last_name);
             $('#sex').text(member.sex=="MALE"?"Male":"Female");
             $('#birthDate').text(member.formatted_birth_date);
             $('#age').text(member.age);
             $('#address').text(member.address);
             $('#level').text(Math.pow(12,member.level));
             $('#networkLeader').text(member.network_leader);
             $('#leader').text(member.leader);
             $('#batch').text(member.batch_name);
             $('#preEncounter').text((member.training.pre_encounter)?"Completed":"Not Yet Completed");
             $('#encounter').text((member.training.encounter)?"Completed":"Not Yet Completed");
             $('#postEncounter').text((member.training.post_encounter)?"Completed":"Not Yet Completed");
             $('#sol1').text((member.training.sol1)?"Completed":"Not Yet Completed");
             $('#sol2').text((member.training.sol2)?"Completed":"Not Yet Completed");
             $('#reEncounter').text((member.training.re_encounter)?"Completed":"Not Yet Completed");
             $('#sol3').text((member.training.sol3)?"Completed":"Not Yet Completed");
             $('#baptism').text((!member.training.baptism)?"N/A":member.training.baptism);
             $("#loader").hide();
             $( "#viewModal" ).modal('show');
           }
       });
    }


</script>

@endsection
