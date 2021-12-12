@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Add Settings</h1>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::horizontal_open()->action("admin/settings")->addClass('test-class')->method('POST') ?>
				<?= Former::text('key')->value('') ?>
				<?= Former::textarea('description')->value('') ?>
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
				<th>Description</th>
				<th>Value</th>
				<th>Action</th>
			</thead>
			@foreach ($settings as $s)
			<tr>
				<td class="col-sm-3">
					{{ $s->key }}
				</td>
				<td class="col-sm-4">
					{{ $s->description }}
				</td>
				<td class="col-sm-3">
					{{ $s->value }}
				</td>
				<td class="col-sm-2">					
					<a href="{{ URL::to('admin/settings/'.$s->id.'/edit') }}" class="btn btn-large btn-warning">Edit</a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection
