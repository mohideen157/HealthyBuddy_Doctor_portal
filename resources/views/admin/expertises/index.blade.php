@extends('layouts.master')

@section('style')
	<style type="text/css">
		.expertise-modal .modal-content{
			padding: 10px 30px;
		}
	</style>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row" style="position: relative;">
	  <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
	        <div class="panel-heading">
			   <h3 class="panel-title" style="font-size:18px;display: inline-block;">Expertise List</h3>
				<span class="pull-right clickable">
					<i class="fa fa-chevron-up"></i>
				</span>
			</div>
			<div class="panel-body">
			   <div id="collapse">
				<a class="btn btn-primary expertise-btn pull-right" id="expertise-btn">Add</a>
				<table id="expertise-table" class="table table-bordered table-hover">
					<thead>
						<th>ID</th>
						<th>Name</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($expertises as $expertise)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ ucfirst($expertise->name) }}</td>
							<td>
								<a class="btn btn-xs btn-danger expertise-delete" data-id="{{ $expertise->id }}"><i class='fa fa-trash-o'></i></a>
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

<!-- Expertise Add and Edit -->
<div class="modal fade expertise-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="text-align: center;">Add Expertise</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="name">Name:</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Enter company name" value="" autocomplete="off" required>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="add">Add</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){

	// Initialize datatables
	$('#expertise-table').DataTable();

	//Open Model
	$('#expertise-btn').click(function(){
		$('#name').val('');
		$('.expertise-modal').modal('show');
	})

	//Add Expertise
	$('#add').click(function(){
		var name = $('#name').val();
		$.ajax({
			type : 'POST',
			data :  {'name' : name},
			url  : "{{ route('admin.expertise.create') }}",
			headers : {
				'X-CSRF-TOKEN':'{{ csrf_token() }}'
			},
			success: function(res){
				if(res){
					swal("Added!", "Expertise Added Successfully.", "success");
				}
				else{
					swal('Error!', 'Expertise Already Exists.', 'error');
				}

	 			$('.confirm').click(function(){
					location.reload();
				});
			}
		});
		// Hide the create modal
		$('.expertise-modal').modal('hide');
	});


// Js to Delete expertise
	$('.expertise-delete').click(function(){

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
				type: 'GET',
				data: {'id': id},
				url: "{{ route('admin.expertise.delete') }}",
				success:function(res){
					if(res){
						swal("Deleted!", "Your file has been deleted.", "success");
					}
					else{
						swal("Error!", "Failed To Delete", "error");
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