@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Doctor Commission Slab</h1>

		<div class="col-xs-12" role="tabpanel" data-example-id="togglable-tabs">
			@include('layouts.doctor_tabs')
			<div id="myTabContent" class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in">
					<?= Former::vertical_open_for_files()->method('PUT')->action("/admin/doctors/commission-slab/{$doctor->doctor_id}") ?>
						<?= Former::text('name')->value($doctor->name)->readonly() ?>
						<?= Former::text('email')->value($doctor->userData->email)->readonly() ?>
						<?= Former::text('mobile_no')->value($doctor->userData->mobile_no)->readonly() ?>
						<?= Former::select('slab')->options($doctor_slabs)->value($doctor->commission_slab) ?>
						<?= Former::actions()->large_primary_submit('Submit') ?>
					<?= Former::close() ?>
				</div>
			</div>
		</div>
	</div>
@endsection