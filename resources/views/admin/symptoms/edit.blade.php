@extends('layouts.master')

@section('content')
	<div class="row">
		<h3 class="text-center">Edit Symptom</h3>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/symptom/{$symptom->id}")->addClass('test-class') ?>
				<?= Former::text('name')->value($symptom->symptoms) ?>
				<?= Former::multiselect('specialties')->options($specialties)->addClass('specialty-select select2')->value($symptom_specialties); ?>
				<?= Former::actions()->large_primary_submit('Submit')->large_inverse_reset('Reset') ?>
			<?= Former::close() ?>
		</div>
	</div>
	<div class="text-center"><a href="{{ URL::to('admin/symptom') }}" class="btn btn-primary">Back to symptom</a></div>
@endsection