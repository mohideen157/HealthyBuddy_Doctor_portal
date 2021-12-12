@extends('layouts.master')

@section('content')
	<h3 class="text-center">Edit Service</h3>
	<div class="col-xs-8 col-xs-offset-2">
		<?= Former::vertical_open_for_files()->method('PUT')->action("/ourservices/{$service->id}") ?>
			<?= Former::text('title')->value($service->title) ?>
			<?= Former::textarea('description')->value($service->description) ?>
			<img src="/uploads/services/{{$service->image }}" alt="" width="200px" height="200px">
			<?= Former::file('image') ?>
			<?= Former::actions()->large_primary_submit('Submit')->large_inverse_reset('Reset') ?>
		<?= Former::close() ?>
	</div>
@endsection