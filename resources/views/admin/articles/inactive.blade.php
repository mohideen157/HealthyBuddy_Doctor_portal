@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Inactive Articles</h1>
		<table id="inactive-articles-table" class="table table-bordered table-hover">
			<thead>
				<th>Title</th>
				<th>Doctor</th>
				<th>Doctor ID</th>
				<th>Action</th>
			</thead>
			@foreach ($articles as $a)
			<tr>
				<td class="col-sm-2">{{ $a->title }}</td>
				<td class="col-sm-2">{{ $a->doctorProfile->name }}</td>
				<td class="col-sm-2">{{ $a->doctorProfile->userdata->shdct_user_id }}</td>
				<td class="col-sm-2">
					<a href="{{ URL::to('admin/articles/'.$a->id) }}" class="btn btn-large btn-primary">View</a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection