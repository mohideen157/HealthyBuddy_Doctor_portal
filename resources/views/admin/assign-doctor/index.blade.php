@extends('layouts.master')

@section('content')
<div class="container-fluid">
<div class="row">
	<div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
	        <div class="panel-heading">
			   <h3 class="panel-title" style="font-size:18px;display: inline-block;">Assign Doctor</h3>
			   <span class="pull-right clickable">
				  <i class="fa fa-chevron-up"></i>
			   </span>
			</div>
		<div class="panel-body">
		    <div id="collapse">
				<form action="{{ route('admin.assign.doctor.store') }}" method="POST">
				{{ csrf_field() }}
					<div class="col-md-4">
						<div class="form-group">
							<label for="doctor">Doctors:</label>
							<select class="form-control" id="doctor" name="doctor">
								<option>Select Doctor</option>
								@foreach($doctors as $doctor)
									<option value="{{ $doctor->id }}">{{ $doctor->name }} </option>
								@endforeach
							</select>
						</div>
						@include('components.error', ['index' => 'doctor'])
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="tenant">Tenants:</label>
							<select class="form-control" id="tenant" name="tenant" >
								@foreach($tenants as $tenant)
									<option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
								@endforeach
							</select>
						</div>
						@include('components.error', ['index' => 'tenant'])
					</div>
						<div class="col-md-4">
						<div class="form-group">
							<label for="org">Organisations:</label>
							<select class="form-control" id="org" name="organisation[]" multiple>
							</select>
						</div>
						@include('components.error', ['index' => 'organisation'])
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<button type="submit" class="btn btn-primary" id="assign">Assign</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<hr>

<div class="row">
    <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
	        <div class="panel-heading">
			   <h3 class="panel-title" style="font-size:18px;display: inline-block;">Doctor & Organisation</h3>
			   <span class="pull-right clickable">
				  <i class="fa fa-chevron-up"></i>
			   </span>
			</div>
			<div class="panel-body">
			    <div id="collapse1">
					<table id="adminsettings-table" class="table table-bordered table-hover">
						<thead>
							<th>#</th>
							<th>Doctor Name</th>
							<th>Tenant Name</th>
							<th>Organisation Name</th>
							<th>Action</th>
						</thead>
						<tbody>
							@foreach($doc_orgs as $doc_org)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $doc_org->doctor->name }}</td>
									<td>{{ $doc_org->tenant->name }}</td>
									<td>{{ $doc_org->organisation->name }}</td>
									<td>
										<a class="btn btn-xs btn-danger delete" data-id="{{ $doc_org->id }}"><i class='fa fa-trash-o'></i></a>
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

		//ajax to get organisation of selected tenant
		if($('#tenant').val() != null){
			getOrganisation();
		}
		$('#tenant').change(function(){
			getOrganisation();
		});

		function getOrganisation()
		{
			var tenant_id = $('#tenant').val();
			$.ajax({
				type:'GET',
				data:{ id:tenant_id },
				url:"{{ route('get.organisation.by.tenant') }}",
				success:function(res){
					$('#org').empty();
					$.each(res, function(index, value)
					{
						$('#org').append('<option value='+value["user_id"]+'>'+value["user"]["name"]+'</option>')
					});
				}
			});
		}
		// select2 for expertise
		$('#org').select2();
		$('#tenant').select2();

		//ajax to delete the assigned doctors
		$('.delete').click(function(){
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
					url: "{{ route('admin.assign.doctor.delete') }}",
					data:{id:id},
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