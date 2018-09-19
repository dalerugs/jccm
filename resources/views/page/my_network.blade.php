@extends('layout.adminlte')

@section('css')

@endsection

@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">My Network Menu</h3>
  </div>
  <div class="box-body">
    <div class="container-fluid">
      <div class="col-md-12">
    			<ul class="admin-menu">
    				<li>
    					<a href="{{route('myNetworkMembers')}}"><i class="fa fa-users fa-3x"></i><br />Manage Members</a>
    				</li>
    				<li>
    					<a href="{{route('myNetworkRequests')}}"><i class="fa fa-check-square-o fa-3x"></i><br />Manage Requests</a>
    				</li>
    			</ul>
        </div>
    </div>
  </div>
</div>

@endsection

@section('js')

<script>


</script>

@endsection
