@extends('layouts.master')

@section('content')
	<div class="row">
		<h3 class="text-center">Edit Speciality</h3>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/specialty/{$speciality->id}")->addClass('test-class') ?>
				<?= Former::text('specialty')->value($speciality->specialty) ?>
				<?= Former::textarea('details')->value($speciality->details) ?>
				<img src="{{$speciality->image }}" alt="" width="200px" height="200px">
				<?= Former::file('image') ?>
				<?= Former::select('parent')->options($specialties, $speciality->parent)->addClass('specialty-select select2') ?>
				<?= Former::actions()->large_primary_submit('Submit')->large_inverse_reset('Reset') ?>
			<?= Former::close() ?>
		</div>
	</div>
	<div class="text-center"><a href="{{ URL::to('admin/specialty') }}" class="btn btn-primary">Back to speciality</a></div>
@endsection