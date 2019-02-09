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
              @for($i=1;$i<=App\Constants::$MAX_LEVEL;$i++)
              <option value="{{$i}}">{{pow(12,$i)}}</option>
              @endfor
            </select>
          </div>
          <div  id='filterLeaderView' style="display:none" class="form-group">
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
      <div class="col-md-3">
        <button style="margin-bottom:20px" id="addNewBtn" class="btn btn-default pull-right" >
          <i style="margin-right:5px" class="fa fa-plus" aria-hidden="true"></i><b>ADD NEW MEMBER</b>
        </button>
      </div>
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
            <th width='5%'></th>
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
              <label>First Name <span style="color:red">*</span></label>
              <input class="form-control" type="text" name="first_name" placeholder="Enter First Name" />
            </div>
            <div class="form-group">
              <label>Last Name <span style="color:red">*</span></label>
              <input class="form-control" type="text" name="last_name" placeholder="Enter Last Name" />
            </div>
            <div class="form-group">
              <label>Birth Date <span style="color:red">*</span></label>
              <input class="form-control" type="date" name="birth_date" />
            </div>
            <div class="form-group">
              <label>Sex <span style="color:red">*</span></label>
              <select class="form-control choose" name="sex">
                  <option selected value disabled value="">Select Sex</option>
                  <option value="MALE">Male</option>
                  <option value="FEMALE">Female</option>
              </select>
            </div>
            <div class="form-group">
              <label>Address <span style="color:red">*</span></label>
              <textarea class="form-control" rows="2" name="address"></textarea>
            </div>
            <div class="form-group">
              <label>Level <span style="color:red">*</span></label>
              <select class="form-control choose" name="level">
                  <option value="" disabled selected value>Select Level</option>
                  @for($i=1;$i<=App\Constants::$MAX_LEVEL;$i++)
                  <option value="{{$i}}">{{pow(12,$i)}}</option>
                  @endfor
              </select>
            </div>
            <div id="networkLeaderView" style="display:none" class="form-group">
              <label>Network Leader <span style="color:red">*</span></label>
              <select class="form-control choose" name="network_id">
                  <option value="" disabled selected value>Select Network Leader</option>
              </select>
            </div>
            <div id="leaderView" style="display:none" class="form-group">
              <label>Leader <span style="color:red">*</span></label>
              <select class="form-control choose" name="leader_id">
                  <option value="" disabled selected value>Select Leader</option>
              </select>
            </div>
            <div class="form-group">
              <label>Picture</label>
              <input id="picture" class="form-control"  accept="image/x-png,image/jpeg,capture=camera" type="file" name="picture">
              <br />
              <img width="150px" id="output">
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">
              <h4><b>PEPSOL / BAPTISM</b></h4>
            </div>
            <div class="form-group">
              <label>Batch</label>
              <select class="form-control choose" name="batch">
                  <option value="" selected value>Select Batch</option>
                  @foreach ($batches as $batch)
                      <option value="{{$batch->id}}" >{{$batch->no." - ".$batch->name}}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Pre Encounter</label>
              <select class="form-control" name="pre_encounter">
                  <option value="0" >Not Yet Completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>Encounter</label>
              <select class="form-control" name="encounter">
                  <option value="0" >Not Yet Completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>Post Encounter</label>
              <select class="form-control" name="post_encounter">
                  <option value="0" >Not Yet Completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>SOL 1</label>
              <select class="form-control" name="sol1">
                  <option value="0" >Not Yet Completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>SOL 2</label>
              <select class="form-control" name="sol2">
                  <option value="0" >Not Yet Completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>Re Encounter</label>
              <select class="form-control" name="re_encounter">
                  <option value="0" >Not Yet Completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>
            <div class="form-group">
              <label>SOL 3</label>
              <select class="form-control" name="sol3">
                  <option value="0" >Not Yet Completed</option>
                  <option value="1" >Completed</option>
              </select>
            </div>

            <div class="form-group">
              <label>Baptism</label>
              <select class="form-control" name="baptism">
                  <option value="" selected value>Select Baptism Year</option>
                  @foreach (range( date('Y'), 1990 ) as $year)
                      <option value="{{$year}}" >{{$year}}</option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Spiritual Lifestyle</label><br />
              <label>Category: <span id="category"></span></label><br />

              <input type="checkbox" name="devotion_cb" /> Devotion</label> <br />
              <input type="hidden" name="devotion" />

              <input type="checkbox" name="cell_group_cb" /> Cell Group</label> <br />
              <input type="hidden" name="cell_group" />

              <input type="checkbox" name="sunday_service_cb" /> Sunday Service</label> <br />
              <input type="hidden" name="sunday_service" />

              <input type="checkbox" name="training_cb" /> Trainings</label> <br />
              <input type="hidden" name="training" />

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

    $("input[type='checkbox']").on('change', function() {
      var devotion = $("input[name='devotion_cb']").is(":checked");
      var cellGroup = $("input[name='cell_group_cb']").is(":checked");
      var sundayService = $("input[name='sunday_service_cb']").is(":checked");
      var training = $("input[name='training_cb']").is(":checked");
      var counter = 0;
      if (devotion) {counter += 1;}
      if (cellGroup) {counter += 1;}
      if (sundayService) {counter += 1;}
      if (training) {counter += 1;}

      if (counter == 1) { $("#category").text("4"); }
      else if (counter == 2) { $("#category").text("3"); }
      else if (counter == 3) { $("#category").text("2"); }
      else if (counter == 4) { $("#category").text("1"); }
      else { $("#category").text(""); }

      var formData = new FormData($("#dataForm")[0]);
      console.log($("#dataForm"));
    });

    const fileInput = document.getElementById('picture');
    const output = document.getElementById('output');

    fileInput.addEventListener('change', (e) => doSomethingWithFiles(e.target.files));
    let file = null;
    function doSomethingWithFiles(fileList) {
      for (let i = 0; i < fileList.length; i++) {
        if (fileList[i].type.match(/^image\//)) {
          file = fileList[i];
          break;
        }
      }

      if (file !== null) {
        output.src = URL.createObjectURL(file);
      }
    }

    var members = [];
    var leaders = [];
    var dataTable;

    $( document ).ready(function() {
      $("#loader").show();
      $.ajax({
           url: "{{ route('readMembers') }}",
           success:function(data) {
             $("#loader").hide();
             members = data.members;
             leaders = data.leaders;
             var html = "";
             $.each( data.members, function( key, member ) {
               var status="<button onclick='toggleMemberStatusBtn("+member.id+",0)' class='btn btn-success btn-block btn-sm'>Active</button>";
                if (member.inactive==0) {
                  status = "<button onclick='toggleMemberStatusBtn("+member.id+",1)' class='btn btn-warning btn-block btn-sm'>Inactive</button>";
                }
                html +=
                "<tr>" +
                  "<td><img width='80px' src='{{ asset('dp') }}/"+member.dp_filename+"' /></td>" +
                  "<td>"+member.first_name+" "+member.last_name+"</td>" +
                  "<td>"+member.network_leader+"</td>" +
                  "<td>"+member.leader+"</td>" +
                  "<td>"+Math.pow(12, member.level)+"</td>" +
                  "<td>"+(member.inactive==1?"Inactive":"Active")+"</td>" +
                  "<td>" +
                  "<button onclick='viewBtn("+member.id+")' class='btn btn-primary btn-block btn-sm'>View</button>" +
                  "<button onclick='editBtn("+member.id+")' class='btn btn-info btn-block btn-sm'>Edit</button>" +
                  status +
                  "<button onclick='deleteBtn("+member.id+")' class='btn btn-danger btn-block btn-sm'>Delete</button>" +
                  "</td>" +
                "</tr>";
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
      var networkId = $("select[name='filter_network']").val();
      var level =   $("select[name='filter_level']").val();
      var leader =   $("select[name='filter_leader']").val();
      var inactive =   $("select[name='filter_status']").val();


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
             $.each( data.members, function( key, member ) {
               var status="<button onclick='toggleMemberStatusBtn("+member.id+",0)' class='btn btn-success btn-block btn-sm'>Activate</button>";
                if (!member.inactive) {
                  status = "<button onclick='toggleMemberStatusBtn("+member.id+",1)' class='btn btn-warning btn-block btn-sm'>Deactivate</button>";
                }
                html +=
                "<tr>" +
                  "<td><img width='80px' src='{{ asset('dp') }}/"+member.dp_filename+"' /></td>" +
                  "<td>"+member.first_name+" "+member.last_name+"</td>" +
                  "<td>"+member.network_leader+"</td>" +
                  "<td>"+member.leader+"</td>" +
                  "<td>"+Math.pow(12, member.level)+"</td>" +
                  "<td>"+(member.inactive==1?"Inactive":"Active")+"</td>" +
                  "<td>" +
                  "<button onclick='viewBtn("+member.id+")' class='btn btn-primary btn-block btn-sm'>View</button>" +
                  "<button onclick='editBtn("+member.id+")' class='btn btn-info btn-block btn-sm'>Edit</button>" +
                  status +
                  "<button onclick='deleteBtn("+member.id+")' class='btn btn-danger btn-block btn-sm'>Delete</button>" +
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
             $('#preEncounter').html((member.training.pre_encounter==1)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#encounter').html((member.training.encounter==1)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#postEncounter').html((member.training.post_encounter==1)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#sol1').html((member.training.sol1==1)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#sol2').html((member.training.sol2==1)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#reEncounter').html((member.training.re_encounter==1)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#sol3').html((member.training.sol3==1)?"<i class='fa fa-check' aria-hidden='true'></i>":"");
             $('#baptism').text((!member.training.baptism)?"N/A":member.training.baptism);
             $("#loader").hide();
             $( "#viewModal" ).modal({backdrop: 'static', keyboard: false});;
           }
       });
    }

    $( "#addNewBtn" ).click(function() {
      $('input[type="checkbox').prop('checked', false);
      $("#modalTitle").text("Add New Member");
      $( "#saveNewBtn" ).show();
      $( "#saveEditBtn" ).hide();
      $('input[name="id"]').val("0");
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
      output.src = "";
      $( "#formModal" ).modal({backdrop: 'static', keyboard: false});;
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

        if ($("select[name='network_id']").val()) {
          filterLeaders();
        }
    });

    $("select[name='network_id']").on('change', function() {
      filterLeaders();
    });

    function filterLeaders(){
      var networkId = $("select[name='network_id']").val();
      var level =   $("select[name='level']").val();
      html = "<option value='' disabled selected value>Select Leader</option>";
      $.each( members, function( key, member ) {
        if (member.network_id == networkId && member.level==(parseInt(level)-1) && $('input[name="id"]').val() != member.id) {
          html += "<option value='"+member.id+"' >"+member.first_name+" "+member.last_name+"</option>";
        }
       });
       $("select[name='leader_id']").html(html);
    }

    $("select[name='sex']").on('change', function() {
        var sex = this.value;
        html = "<option value='' disabled selected value>Select Network Leader</option>";
        $.each( members, function( key, member ) {
          if (member.sex == sex && member.level == 1 && $('input[name="id"]').val() != member.id) {
            html += "<option value='"+member.id+"' >"+member.first_name+" "+member.last_name+"</option>";
          }
         });
         $("select[name='network_id']").html(html);
    });

    $( "#saveNewBtn" ).click(function() {
      $("#loader").show();
      var formData = new FormData($("#dataForm")[0]);
      if (file!=null) {
        formData.set('picture',file,'picture.jpg');
      }
      $.ajax({
           url: "{{ route('createMember') }}",
           type: 'POST',
           data: formData,
           processData: false,
           contentType: false,
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
      $('select[name="network_id"]').val("<option value='' disabled selected value>Select Network Leader</option>");
      $('select[name="leader_id"]').val("<option value='' disabled selected value>Select Leader</option>");
      $("#loader").show();
      $.ajax({
           url: "{{ url('api/showMember') }}/"+id,
           success:function(member) {
             console.log(member);
             $('input[name="id"]').show();
             $('input[name="id"]').val(member.id);
             $('input[name="first_name"]').val(member.first_name);
             $('input[name="last_name"]').val(member.last_name);
             $('input[name="birth_date"]').val(member.birth_date);
             $('select[name="sex"]').val(member.sex).change();
             $('textarea[name="address"]').val(member.address);
             $('select[name="level"]').val(member.level).change();
             $('select[name="network_id"]').val(member.network_id).change();
             $('select[name="leader_id"]').val(member.leader_id).change();
             $('select[name="batch"]').val(member.training.batch).change();
             $('select[name="batch"]').val((member.training.batch?member.training.batch:"")).change();
             $('select[name="pre_encounter"]').val(member.training.pre_encounter).change();
             $('select[name="encounter"]').val(member.training.encounter).change();
             $('select[name="post_encounter"]').val(member.training.post_encounter).change();
             $('select[name="sol1"]').val(member.training.sol1).change();
             $('select[name="sol2"]').val(member.training.sol2).change();
             $('select[name="re_encounter"]').val(member.training.re_encounter).change();
             $('select[name="sol3"]').val(member.training.sol3).change();
             $('select[name="baptism"]').val(member.training.baptism).change();
             $( "#saveEditBtn" ).show();
             $( "#saveNewBtn" ).hide();
             output.src = "{{ asset('dp') }}/"+member.dp_filename;
             $("#loader").hide();
             $( "#formModal" ).modal({backdrop: 'static', keyboard: false});;
           }
       });

    }

    $( "#saveEditBtn" ).click(function() {
      $("#loader").show();
      var formData = new FormData($("#dataForm")[0]);
      if (file!=null) {
        formData.set('picture',file,'picture.jpg');
      }
      $.ajax({
           url: "{{ route('updateMember') }}",
           type: 'POST',
           data: formData,
           processData: false,
           contentType: false,
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

    function toggleMemberStatusBtn(id, status){
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
               url: "{{ url('api/toggleMemberStatus') }}/"+id+"/"+status,
               success:function(data) {
                 $("#loader").hide();
                 swalWithBootstrapButtons(
                   "Success!",
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
               url: "{{ url('api/deleteMember') }}/"+id,
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
