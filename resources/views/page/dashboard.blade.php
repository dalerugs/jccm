@extends('layout.adminlte')

@section('css')

@endsection

@section('content')


<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{{$active_members}}}</h3>

              <p><br />Active Members</p>
            </div>
            <div class="icon">
              <i class="fa fa-check-circle-o"></i>
            </div>
            <a href="{{route('members')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{{$inactive_members}}}</h3>

              <p><br /> Inactive Members</p>
            </div>
            <div class="icon">
              <i class="fa fa-times-circle-o"></i>
            </div>
            <a href="{{route('members')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{{$leaders}}}</h3>

              <p><br /> Leaders</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="{{route('members')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$completion_rate}}<sup style="font-size: 20px">%</sup></h3>

              <p>PEPSOL <br /> Completion Rate</p>
            </div>
            <div class="icon">
              <i class="fa fa-line-chart"></i>
            </div>
            <a href="{{route('pepsol')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

      </div>

      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class=""><a onclick="womensTablClick()" href="javascript:void(0)" data-toggle="tab">Women</a></li>
              <li class="active"><a onclick="mensTabClick()" href="javascript:void(0)" data-toggle="tab">Men</a></li>
              <li class="pull-left header"><i class="fa fa-sitemap"></i> Networks</li>
            </ul>
            <div style="padding:10px" class="tab-content">
              <div id="mensNetView" style="height: 100%;" >
                <div class="table-responsive">
                  <table id="mensTable" class="table table-bordered">
                    <thead>
                      <tr>
                        <th>NETWORK</th>
                        @for($i=1;$i<=App\Constants::$MAX_LEVEL-1;$i++)
                        <th>{{pow(12,$i)}}</th>
                        @endfor
                        <th>TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($mens_network as $network)
                      @php $total = 0; @endphp
                      <tr>
                        <td>{{$network->first_name." ".$network->last_name}}</td>
                        @for($i=2;$i<=App\Constants::$MAX_LEVEL;$i++)
                        @php $total += $network[$i]; @endphp
                        <td>{{$network[$i]}}</td>
                        @endfor
                        <td>{{$total}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

              <div style="display:none" id="womensNetView" style="position: relative; height: 100%;" >
                <div class="table-responsive">
                  <table id="womensTable" class="table table-bordered">
                    <thead>
                      <tr>
                        <th>NETWORK</th>
                        @for($i=1;$i<=App\Constants::$MAX_LEVEL-1;$i++)
                        <th>{{pow(12,$i)}}</th>
                        @endfor
                        <th>TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($womens_network as $network)
                      @php $total = 0; @endphp
                      <tr>
                        <td>{{$network->first_name." ".$network->last_name}}</td>
                        @for($i=2;$i<=App\Constants::$MAX_LEVEL;$i++)
                        @php $total += $network[$i]; @endphp
                        <td>{{$network[$i]}}</td>
                        @endfor
                        <td>{{$total}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </section>
      </div>

@endsection

@section('js')
<script>

  $( document ).ready(function() {
    $('#mensTable').DataTable({
        "searching": false,
        "bFilter": false,
        "bInfo": false,
        "paging": false,
        "responsive": true,
    });
    $('#womensTable').DataTable({
      "searching": false,
      "bFilter": false,
      "bInfo": false,
      "paging": false,
      "responsive": true,
    });
    dataTableMember = $('#dataTableMember').DataTable();
  });

  function mensTabClick(){
    $("#womensNetView").hide();
    $("#mensNetView").show();
  }

  function womensTablClick(){
    $("#mensNetView").hide();
    $("#womensNetView").show();
  }
</script>
@endsection
