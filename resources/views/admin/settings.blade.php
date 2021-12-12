@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Add Settings</h1>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::horizontal_open()->action("admin/settings")->addClass('test-class')->method('POST') ?>
				<?= Former::text('key')->value('') ?>
				<?= Former::text('value')->value('') ?>
				<?= Former::actions()->large_primary_submit('Submit')?>
			<?= Former::close() ?>
		</div>
	</div>

	<div class="row">
		<h1 class="text-center">Settings</h1>
		<table id="adminsettings-table" class="table table-bordered table-hover">
			<thead>
				<th>Key</th>
				<th>Value</th>
				<th>Action</th>
			</thead>
			@foreach ($settings as $s)
			<tr>
				<td class="col-sm-5">
					{{ $s->key }}
				</td>
				<td class="col-sm-5">
					{{ $s->value }}
				</td>
				<td class="col-sm-2">					
					
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection
