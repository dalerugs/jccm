@extends('layout.adminlte')

@section('css')

@endsection

@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Requests Data</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <form id="filterForm">
        <div class="col-md-4">
          <div class="form-group">
            <label>Filter By Action:</label>
            <select name="filter_action" style="margin-bottom:20px" class="form-control">
              <option value="" >All Actions</option>
              <option value="CREATE" >New Member</option>
              <option value="UPDATE" >Update Member</option>=
              <option value="DELETE" >Delete Member</option>=
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Filter By Level:</label>
            <select name="filter_level" style="margin-bottom:20px" class="form-control">
              <option value="" >All Levels</option>
              @for($i=2;$i<=App\Constants::$MAX_LEVEL;$i++)
              <option value="{{$i}}">{{pow(12,$i)}}</option>
              @endfor
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div id='filterLeaderView' style="display:none" class="form-group">
            <label>Filter By Leader:</label>
            <select name="filter_leader" style="margin-bottom:20px" class="form-control">
              <option value="" >All Leaders</option>
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
            <th>LEADER</th>
            <th>LEVEL</th>
            <th>ACTION</th>
            <th width='5%'></th>
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

    var leaders = [];
    var dataTable;

    var networkId = "{{Auth::user()->network}}";

    $( document ).ready(function() {
      $("#loader").show();
      $.ajax({
            url: "{{ route('readMembersWithFilter') }}",
            type: 'POST',
            dataType: 'json',
            data: {
              'network_id': networkId,
            },
            encode:true,
            success:function(data) {
             leaders = data.leaders;
           }
       });
       $.ajax({
             url: "{{ route('readRequestsWithFilter') }}",
             type: 'POST',
             dataType: 'json',
             data: {
               'network_id': networkId,
             },
             encode:true,
             success:function(data) {
              $("#loader").hide();
              var html = "";
              $.each( data.members, function( key, member ) {
                if(member.level>1){
                   html +=
                   "<tr>" +
                     "<td><img width='80px' src='{{ asset('dp') }}/"+member.dp_filename+"' /></td>" +
                     "<td>"+member.first_name+" "+member.last_name+"</td>" +
                     "<td>"+member.leader+"</td>" +
                     "<td>"+Math.pow(12, member.level)+"</td>" +
                     "<td>"+(member.action=="CREATE"?"NEW MEMBER":member.action+" MEMBER")+"</td>" +
                     "<td>" +
                     "<button onclick='viewBtn("+member.id+")' class='btn btn-primary btn-block btn-sm'>View</button>" +
                     "<button onclick='deleteBtn("+member.id+","+'"'+"DELETE"+'"'+")' class='btn btn-danger btn-block btn-sm'>Delete</button>" +
                     "</td>" +
                   "</tr>";
                }
               });
               $("#tableBody").html(html);
               dataTable = $('#dataTable').DataTable();
            }
        });
    });

    var oldNetworkId = "";
    var oldLevel = "";

    $("#filterForm").on('change', function() {
      $("#loader").show();
      var level =   $("select[name='filter_level']").val();
      var leader =   $("select[name='filter_leader']").val();
      var action =   $("select[name='filter_action']").val();


      if ($('select[name="filter_level"]').val() > 2) {
          var html = "<option value=''>All Leaders</option>";
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

        if (networkId==oldNetworkId && level==oldLevel) {
           $("select[name='filter_leader']").val(leader);
        }else {
            oldNetworkId = networkId;
            oldLevel = level;
            $("select[name='filter_leader']").val("");
            leader = "";
        }

        $('#filterLeaderView').fadeIn()

      }else {
          $('#filterLeaderView').fadeOut()
         $("select[name='filter_leader']").val("");
         leader = "";
       }

       $.ajax({
             url: "{{ route('readRequestsWithFilter') }}",
             type: 'POST',
             dataType: 'json',
             data: {
               'network_id': networkId,
               'level': level,
               'leader_id': leader,
               'action': action,
             },
             encode:true,
             success:function(data) {
              $("#loader").hide();
              var html = "";
              $.each( data.members, function( key, member ) {
                if(member.level>1){
                   html +=
                   "<tr>" +
                     "<td><img width='80px' src='{{ asset('dp') }}/"+member.dp_filename+"' /></td>" +
                     "<td>"+member.first_name+" "+member.last_name+"</td>" +
                     "<td>"+member.leader+"</td>" +
                     "<td>"+Math.pow(12, member.level)+"</td>" +
                     "<td>"+(member.action=="CREATE"?"NEW MEMBER":member.action+" MEMBER")+"</td>" +
                     "<td>" +
                     "<button onclick='viewBtn("+member.id+")' class='btn btn-primary btn-block btn-sm'>View</button>" +
                     "<button onclick='deleteBtn("+member.id+","+'"'+"DELETE"+'"'+")' class='btn btn-danger btn-block btn-sm'>Delete</button>" +
                     "</td>" +
                   "</tr>";
                }
               });
               $("#tableBody").html(html);
               dataTable = $('#dataTable').DataTable();
            }
        });
    });

    function viewBtn(id){
      $("#loader").show();
      $.ajax({
           url: "{{ url('api/showRequest') }}/"+id,
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
             $('#preEncounter').html((member.training.pre_encounter)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#encounter').html((member.training.encounter)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#postEncounter').html((member.training.post_encounter)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#sol1').html((member.training.sol1)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#sol2').html((member.training.sol2)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#reEncounter').html((member.training.re_encounter)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#sol3').html((member.training.sol3)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#baptism').text((!member.training.baptism)?"N/A":member.training.baptism);
             $("#loader").hide();
             $( "#viewModal" ).modal({backdrop: 'static', keyboard: false});;
           }
       });
    }



    function deleteBtn(id){
      $('input[name="action"]').val("DELETE");
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
               url: "{{ url('api/deleteRequest') }}/"+id,
               success:function(data) {
                 $("#loader").hide();
                 swalWithBootstrapButtons(
                   'Deleted!',
                   'Request was sucessfully deleted.',
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
