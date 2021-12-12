@extends('layouts.master')

@section('content')
<div class="container-fluid">
<div class="row">
	<div class="col-md-12 col-xs-12 tenant-panel">
	   <div class="panel panel-default">
	      <div class="panel-heading">
			<h3 class="panel-title" style="font-size:18px;display: inline-block;">Doctor Details</h3>
			<span class="pull-right clickable">
				<i class="fa fa-chevron-up"></i>
			</span>
		  </div>
		  <div class="panel-body">
			 <div id="collapse" class="table-responsive">
			 	<a class="btn btn-primary expertise-btn pull-right" href="{{ route('admin.doctor.create') }}">Add</a>
				<table id="adminsettings-table" class="table table-bordered table-hover">
					<thead>
						<th>ID</th>
						<th>Doctor Name</th>
						<th>Doctor Email</th>
						<th>Doctor Mobile</th>
						<th>Landline</th>
						<th>Hospital</th>
						<th>Experiance</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{ $user->shdct_user_id  ?? '' }}</td>
								<td>{{ $user->name  ?? ''}}</td>
								<td>{{ $user->email ?? '' }}</td>
								<td>{{ $user->mobile_no ?? '' }}</td>
								<td>{{ $user->doctor->landline ?? '' }}</td>
								<td>{{ $user->doctor->current_hospital ?? '' }}</td>
								<td>{{ $user->doctor->experiance ?? '' }}</td>
								<td>
									<a href="{{ route('admin.doctor.edit', $user->id) }}" class="btn btn-xs btn-default"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									<a class="btn btn-xs btn-danger doctor-delete" data-id="{{ $user->id }}"><i class='fa fa-trash-o'></i></a>
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
@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			$('.doctor-delete').click(function(){
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
						url: '{{ route('admin.doctor.delete') }}',
						data:{ id: id },
						success:function(res){
							if(res){
				 				swal("Deleted!", "Your file has been deleted.", "success");
							}
							else{
				 				swal("Error!", "Failed To Delete.", "error");
							}
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