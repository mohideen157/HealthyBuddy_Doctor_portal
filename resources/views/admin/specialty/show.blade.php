@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Specialty Details</h1>
		<table class="table table-bordered table-hover">
			<tr>
				<th class="col-xs-3">Name</th>
				<td class="col-xs-9">{{ $speciality->specialty }}</td>
			</tr>
			<tr>
				<th class="col-xs-3">Details</th>
				<td class="col-xs-9">{{ $speciality->details }}</td>
			</tr>
			<tr>
				<th class="col-xs-3">Image</th>
				<td class="col-xs-9"><img src="/uploads/{{ $speciality->image }}" alt="" width="200px" height="200px"></td>
			</tr>
		</table>
		<div class="text-center"><a href="{{ URL::to('admin/specialty') }}" class="btn btn-primary">Back to speciality</a></div>
	</div>
@endsection