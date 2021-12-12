@extends('caregiver.component._master')

@section('content')
@php
	$image = isset($article->image) ? asset($article->image) : '';

	if(App\User::isDoctor()){
		$store_article = 'caregiver/diet/store';
		$update_article = 'caregiver/diet/update';
	}
	else{
		$store_article = 'caregiver/diet/store';
		$update_article = 'caregiver/diet/update';
	}
@endphp
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-xs-12 article-panel">
		   <div class="panel panel-default">
	            <div class="panel-heading">
					<h3 class="panel-title" style="font-size:18px;display: inline-block;">@if(isset($article)) Update Diet Plan @else Add Diet Plan @endif</h3>
					<span class="pull-right clickable">
					    <i class="fa fa-chevron-up"></i>
					</span>
				</div>
				<div class="panel-body">
			        <div id="collapse">
						<form action="@if(isset($article)){{ url($update_article, $article->id) }} @else{{ url($store_article) }} @endif" method="POST" enctype="multipart/form-data">
							<div class="row" style="display: flex;justify-content: center;">
								<div class="col-md-4">
								{{ csrf_field() }}
									<div class="form-group">
										<label for="title">Title:</label>
										<input type="text" class="form-control" id="title" name="title" placeholder="Enter Article Title" value="{{ old('title', $article->title ?? '') }}">
									</div>
									@include('components.error', ['index' => 'title'])
									<div class="form-group">
										<label for="active">Status:</label>
										<select class="form-control" name="active" id="active">
											<option value="1" @if(old('active', $article->active ?? '') == 1) selected @endif>Active</option>
											<option value="0" @if(old('active', $article->active ?? '') == 0) selected @endif>Not Active</option>
										</select>
									</div>
									@include('components.error', ['index' => 'active'])

								</div>	
								<div class="col-md-8">
									<div class="form-group">
										<label for="image">Image:</label>
										<input type="hidden" id="hasImage" name="hasImage" value="{{ old('image', $article->image ?? '') }}">
										<input type="file" name="image" id="image" data-default-file="{{ asset($image) }}">
									</div>
									@include('components.error', ['index' => 'image'])

									<div class="form-group">
										<label for="content">content:</label>
										<textarea class="form-control" id="content" name="content">{{ old('content', $article->content ?? '') }}</textarea>
									</div>
									@include('components.error', ['index' => 'content'])	

									<div class="form-group">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</div>
							</div>
						</form>
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
		$('textarea').ckeditor(); 
		$('#image').dropify();

		$('.dropify-clear').click(function(){
			$('#hasImage').val('')
		})
	});
</script>
@endsection