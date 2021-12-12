@extends('layouts.master')
<link rel="stylesheet" type="text/css" href="{{ asset('css/patient-profile') }}">
@section('content')
<div class="container-fluid">
<div class="row">
	<div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
	       <div class="panel-heading">
			   <h3 class="panel-title" style="font-size:18px;display: inline-block;">Tenant Detail</h3>
			   <span class="pull-right clickable">
				   <i class="fa fa-chevron-up"></i>
			   </span>
		   </div>
		   <div class="panel-body">
			  <div id="collapse">
			  	<div class="table-responsive">
			  	    <a class="btn btn-primary expertise-btn pull-right" href="{{ route('admin.tenant.create') }}">Add</a>
					<table id="adminsettings-table" class="table table-bordered table-hover">
					<thead>
						<th>ID</th>
						<th>Tenant Name</th>
						<th>Tenant Email</th>
						<th>Tenant Mobile</th>
						<th>Concern Person</th>
						<th>Concern Person Contact</th>
						<th>Slug</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{ $user->shdct_user_id ?? ''}}</td>
								<td>{{ $user->name  ?? ''}}</td>
								<td>{{ $user->email  ?? '' }}</td>
								<td>{{ $user->mobile_no ?? '' }}</td>
								<td>{{ $user->tenant_details->concern_person ?? '' }}</td>
								<td>{{ $user->tenant_details->concern_person_mobile ?? '' }}</td>
								<td>{{ $user->tenant_details->slug ?? '' }}</td>
								<td>
									<a href="{{ route('admin.tenant.edit', $user->id) }}" class="btn btn-xs btn-default"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									<a class="btn btn-xs btn-danger tenant-delete" data-id="{{ $user->id }}"><i class='fa fa-trash-o'></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
					</table>
				</div>
			  </div>
			</div>
		</div>
	</div>
</div>
</div>

@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			$('.tenant-delete').click(function(){

			var id = $(this).attr('data-id');

			swal({
				  	title: "Are you sure?",
				    text: "Your will not be able to recover this file!",
				  	type: "warning",
				  	showCancelButton: true,
				  	confirmButtonClass: "btn-danger",
				  	confirmButtonText: "Yes, delete it!",
				  	closeOnConfirm: false
				},
				function(){
					$.ajax({
						type:'GET',
						url: '{{ route('admin.tenant.delete') }}',
						data:{ id: id },
						success:function(res){
				 			swal("Deleted!", "Your file has been deleted.", "success");
				 			$('.confirm').click(function(){
				 				location.reload();
				 			});
						}
					});
				});
			});
		});
	</script>
@endsection