@extends('tenant.component._master')

@section('content')
<div class="container-fluid">
<div class="row">
	<div class="col-md-12 col-xs-12 tenant-panel">
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
		         	    <a class="btn btn-primary expertise-btn pull-right" href="{{ route('tenant.organisation.create') }}">Add</a>
						<table id="adminsettings-table" class="table table-bordered table-hover">
							<thead>
								<th>ID</th>
								<th>Organisation Name</th>
								<th>Organisation Email</th>
								<th>Organisation Mobile</th>
								<th>Concern Person</th>
								<th>Concern Person Contact</th>
								<th>Action</th>
							</thead>
							<tbody>
								@foreach($organisations as $organisation)
									<tr>
										<td>{{ $organisation->user->shdct_user_id }}</td>
										<td>{{ $organisation->user->name }}</td>
										<td>{{ $organisation->user->email }}</td>
										<td>{{ $organisation->user->mobile_no }}</td>
										<td>{{ $organisation->concern_person }}</td>
										<td>{{ $organisation->concern_person_mobile }}</td>
										<td>
											<a href="{{ route('tenant.organisation.edit', $organisation->user->id) }}" class="btn btn-xs btn-default"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<a class="btn btn-xs btn-danger organisation-delete" data-id="{{ $organisation->user->id }}"><i class='fa fa-trash-o'></i></a>
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
						url: '{{ route('tenant.organisation.delete') }}',
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
@endsection