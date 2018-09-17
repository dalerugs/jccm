@extends('layout.adminlte')

@section('css')

@endsection

@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Admin Menu</h3>
  </div>
  <div class="box-body">
    <div class="container-fluid">
      <div class="col-md-12">
    			<ul class="admin-menu">
    				<li>
    					<a href="{{route('manageMembers')}}"><i class="fa fa-users fa-3x"></i><br />Manage Members</a>
    				</li>
    				<li>
    					<a href="{{route('admin')}}"><i class="fa fa-check-square-o fa-3x"></i><br />Manage Requests</a>
    				</li>
    				<li>
    					<a href="{{route('manageBatch')}}"><i class="fa fa-certificate fa-3x"></i><br />Manage Batch</a>
    				</li>
    				<li>
    					<a href="{{route('admin')}}"><i class="fa fa-globe fa-3x"></i><br />Manage G12</a>
    				</li>
    				<li>
    					<a href="{{route('manageFiles')}}"><i class="fa fa-files-o fa-3x"></i><br />Manage Files</a>
    				</li>
    				<li>
    					<a href="{{route('manageUsers')}}"><i class="fa fa-id-card-o fa-3x"></i><br />Manage Users</a>
    				</li>
    			</ul>
        </div>
    </div>
  </div>
</div>

@endsection

@section('js')

@endsection
