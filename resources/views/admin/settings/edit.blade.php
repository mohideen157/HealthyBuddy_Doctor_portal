@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Add Settings</h1>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::horizontal_open()->action("admin/settings/{$setting->id}")->addClass('test-class')->method('PUT') ?>
				<?= Former::text('key')->value($setting->key)->readonly(true) ?>
				<?= Former::textarea('description')->value($setting->description) ?>
				<?= Former::text('value')->value($setting->value) ?>
				<?= Former::actions()->large_primary_submit('Submit')?>
			<?= Former::close() ?>
		</div>
	</div>
	<div class="text-center"><a href="{{ URL::to('admin/settings') }}" class="btn btn-primary">Back to Settings</a></div>
@endsection
