@extends('caregiver.component._master')
<link rel="stylesheet" type="text/css" href="{{ asset('css/patient-profile') }}">
@section('content')
<div class="container-fluid">
<div class="row">
	 @if ($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>	
			        <strong>{{ $message }}</strong>
			</div>
			@endif
	<span class="pull-right  ">
	       	   <a class="btn btn-primary expertise-btn pull-right" href="{{ url('caregiver/organisation/create') }}">Add</a>
	       	    </span>
	<div class="col-md-12 col-xs-12 Patient-panel">

		<div class="panel panel-default">
     
	       <div class="panel-heading">
	       	   
			   <h3 class="panel-title" style="font-size:18px;display: inline-block;">Organisation Detail</h3>
			   <span class="pull-right clickable">
				   <i class="fa fa-chevron-up"></i>
			   </span>
		   </div>
		   <div class="panel-body">
			  <div id="collapse">
			  	<div class="table-responsive">
					<table id="adminsettings-table" class="table table-bordered table-hover">
					<thead>
						<th>ID</th>
						<th>organisation Name</th>
						<th>organisation Email</th>
						<th>organisation Mobile</th>
					 
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($user as $user)
							<tr>
								<td>{{ $user->id }}</td>
								<td>{{ $user->user->name }}</td>
								<td>{{ $user->user->email }}</td>
								<td>{{ $user->user->mobile_no }}</td>
								<?php $pid=$user->user->id; ?>
								<td>
									<a href='{{ url("caregiver/organisation/edit/$user->id/$pid ") }}' class="btn btn-xs btn-default"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									 
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
			$('.Patient-delete').click(function(){

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