@extends('layouts.master')

@section('content')
	<h1 class="text-center">Service</h1>
	<table class="table table-bordered table-hover">
		<tr>
			<th class="col-xs-3">Name</th>
			<td class="col-xs-9">{{ $service->title }}</td>
		</tr>
		<tr>
			<th class="col-xs-3">Overview</th>
			<td class="col-xs-9">{{ $service->description }}</td>
		</tr>
		<tr>
			<th class="col-xs-3">Image</th>
			<td class="col-xs-9"><img src="/uploads/services/{{ $service->image }}" alt="" width="200px" height="200px"></td>
		</tr>
	</table>
@endsection