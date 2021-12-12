@extends('layouts.master')

@section('content')
<div class="container-fluid">
<div class="row">
	<h1 class="text-center"></h1>
    <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
	        <div class="panel-heading">
				<h3 class="panel-title" style="font-size:18px;display: inline-block;">Organisation Details</h3>
				<span class="pull-right clickable">
					<i class="fa fa-chevron-up"></i>
				</span>
		    </div>
			<div class="panel-body">
			   <div id="collapse" class="table-responsive">
				<table id="adminsettings-table" width="100%" class="table display responsive no-wrap table-bordered table-hover">
					<thead>
						<th>ID</th>
						<th>Tenant </th>
						<th>Organisation</th>
						<th>Mobile</th>
						<th>Email</th>
						<th>Concern Person</th>
						<th>Concern Person Contact</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{ $user->shdct_user_id ?? ''}}</td>
								<td>{{ $user->organisation_details->parent_user->name ?? ''}}</td>
								<td>{{ $user->name  ?? ''}}</td>
								<td>{{ $user->mobile_no ?? ''}}</td>
								<td>{{ $user->email ?? '' }}</td>
								<td>{{ $user->organisation_details->concern_person ?? ''}}</td>
								<td>{{ $user->organisation_details->concern_person_mobile ?? '' }}</td>
								<td>
									<a href="{{ route('admin.organisation.edit', $user->id) }}" class="btn btn-xs btn-default"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									<a class="btn btn-xs btn-danger organisation-delete" data-id="{{ $user->id }}"><i class='fa fa-trash-o'></i></a>
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
@endsection
<script src="/bower_components/gentelella/vendors/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	   $(".dataTables_wrapper").addClass("table-responsive");

	   $('.organisation-delete').click(function(){
		var id = $(this).attr('data-id');

		swal({
			  	title: "Are you sure?",
			    text: "Your will not be able to recover this file!",
			  	type: "warning",
			  	showCancelButton: true,
			  	confirmButtonClass: "btn-danger",
			  	confirmButtonText: "Yes, delete it!",
			  	closeOnConfirm: true
			},
			function(){
				$.ajax({
					type:'GET',
					url: '{{ route('admin.organisation.delete') }}',
					data:{ id: id },
					success:function(res){
			 			if(res){
			 				swal("Deleted!", "Your file has been deleted.", "success");
						}
						else{
			 				swal("Failed!", "Failed To Delete.", "error");
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