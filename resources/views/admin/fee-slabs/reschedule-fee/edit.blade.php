@extends('layouts.master')

@section('content')
	<div class="row">
		<h3 class="text-center">Edit Slab</h3>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/reschedule-fee-slabs/{$slab->id}")->addClass('test-class') ?>
				<?= Former::text('from')->value($slab->from) ?>
				<?= Former::text('to')->value($slab->to); ?>
				<?= Former::text('fee')->value($slab->fee); ?>
				<?= Former::actions()->large_primary_submit('Submit') ?>
			<?= Former::close() ?>
		</div>
	</div>
	<div class="text-center"><a href="{{ URL::to('admin/reschedule-fee-slabs') }}" class="btn btn-primary">Back to Reschedule Fee Slabs</a></div>
@endsection