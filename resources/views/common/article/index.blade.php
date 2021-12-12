@extends(App\User::isTenant() ? 'tenant.component._master' : (App\User::isOrganisation() ? 'organisation.component._master' : (App\User::isDoctor() ? 'doctor.component._master' : 'layouts.master')))

@php
	if(App\User::isDoctor()){
		$add_article = 'doctor.article.create';
		$edit_article = 'doctor.article.edit';
		$delete_article = 'doctor.article.delete';
	}
	else{
		$add_article = 'admin.article.create';
		$edit_article = 'admin.article.edit';
		$delete_article = 'admin.article.delete';
	}
@endphp

@section('content')
<div class="container-fluid">
<div class="row">
	<div class="col-md-12 col-xs-12 article-panel">
		<div class="panel panel-default">
	       <div class="panel-heading">
			   <h3 class="panel-title" style="font-size:18px;display: inline-block;">Articles</h3>
			   <span class="pull-right clickable">
				   <i class="fa fa-chevron-up"></i>
			   </span>
		   </div>
		   <div class="panel-body">
			  <div id="collapse">
			  	<div class="table-responsive">
			  	    <a class="btn btn-primary expertise-btn pull-right" href="{{ route($add_article) }}">Add</a>
					<table id="adminsettings-table" class="table table-bordered table-hover">
					<thead>
						<th>S no.</th>
						<th>Post By</th>
						<th>Title</th>
						<th>Image</th>
						<th>Status</th>
						<th>Action</th>
					</thead>
					<tbody>
					@foreach($articles as $article)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td><img src="{{ asset($article->user->profile_image) }}">{{ $article->user->name }}</td>
							<td>{{ $article->title }}</td>
							<td><img src="{{ asset($article->image) }}" style="border-radius:0%"></td>
							<td>@if($article->active == 1) Active @else Not Active @endif</td>
							<td>
								<a href="{{ route($edit_article, $article->id) }}" class="btn btn-xs btn-default"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<a class="btn btn-xs btn-danger article-delete" data-id="{{ $article->id }}"><i class='fa fa-trash-o'></i></a>
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
			$('.article-delete').click(function(){

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
						url: '{{ route($delete_article) }}',
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