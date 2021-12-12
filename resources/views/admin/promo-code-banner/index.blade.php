@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Promo Code Banner</h1>
		<table id="promo-code-banner-table" class="table table-bordered table-hover">
			<thead>
				<th>Title</th>
				<th>Status</th>
				<th>Actions</th>
			</thead>
			@if(count($data) > 0)
				@foreach ($data as $d)
				<tr>
					<td>{{ $d->title }}</td>
					<td>{{ ($d->is_active == 1)?'Active':'Disabled' }}</td>
					<td>
						<a href="{{ URL::to('/admin/promo-code-banner/'.$d->id.'/edit') }}" class="btn btn-primary">Edit</a>
						<?= Former::horizontal_open()->action("admin/promo-code-banner/{$d->id}")->method('DELETE') ?>
							<a class="delete-btn btn btn-danger">Delete</a>
						<?= Former::close() ?>
					</td>
				</tr>
				@endforeach
			@else
				<tr>
					<td colspan="3">No Data Available</td>
				</tr>
			@endif
		</table>
	</div>
@endsection
