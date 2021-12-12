@extends('layouts.master')

@section('content')
	<div class="row">
		<h3 class="text-center">Edit Slab</h3>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/doctor-commission-slabs/{$slab->id}")->addClass('test-class') ?>
				@if($slab->id == 1)
				<?= Former::text('key')->value($slab->key)->readonly() ?>
				@else
				<?= Former::text('key')->value($slab->key) ?>
				@endif
				<?= Former::text('value')->value($slab->value); ?>
				<?= Former::actions()->large_primary_submit('Submit') ?>
			<?= Former::close() ?>
		</div>
	</div>
	<div class="text-center"><a href="{{ URL::to('admin/doctor-commission-slabs') }}" class="btn btn-primary">Back to Doctor Commission Slabs</a></div>
@endsection