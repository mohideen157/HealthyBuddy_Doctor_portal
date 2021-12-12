@extends('layouts.master')

@section('content')
@include('partials.speciality')
	<h1 class="text-center">Our Services</h1>
	<table class="table table-bordered table-hover">
		<tr>
			<th>#</th>
			<th>title</th>
			<th>Action</th>
		</tr>
		@foreach ($services as $service)
		<tr>
			<td class="col-sm-2">{{ $service->id }}</td>
			<td class="col-sm-4">{{ $service->title }}</td>
			<td class="col-sm-4">
				<a href="{{ URL::to('ourservices/'.$service->id) }}" class="btn btn-large btn-primary">Show</a>
				<a href="{{ URL::to('ourservices/'.$service->id.'/edit') }}" class="btn btn-large btn-warning">Edit</a>
				<?= Former::vertical_open_for_files()->method('DELETE')->action("/ourservices/{$service->id}")->addClass('inline-form') ?>
					<?= Former::actions()->large_danger_submit('Delete')->addClass('btn') ?>
				<?= Former::close() ?>
			</td>
		</tr>
		@endforeach
	</table>
@endsection