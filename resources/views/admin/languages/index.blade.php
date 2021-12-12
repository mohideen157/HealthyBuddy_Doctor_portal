@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Add Language</h1>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::horizontal_open()->action("admin/languages")->addClass('test-class')->method('POST') ?>
				<?= Former::text('language')->value('') ?>
				<?= Former::actions()->large_primary_submit('Submit')?>
			<?= Former::close() ?>
		</div>
	</div>

	<div class="row">
		<h1 class="text-center">Languages</h1>
		<table id="medicine-types-table" class="table table-bordered table-hover">
			<thead>
				<th>Language</th>
				<th>Update</th>
				<th>Actions</th>
			</thead>
			@foreach ($languages as $l)
			<tr>
				<td class="col-sm-5">
					{{ $l->language }}
				</td>
				<td class="col-sm-5">
					<?= Former::horizontal_open()->action("admin/languages/{$l->id}")->addClass('test-class')->method('PUT') ?>
						<?= Former::text('language_new')->label('')->value($l->language) ?>
						<?= Former::actions()->large_primary_submit('Submit')?>
					<?= Former::close() ?>
				</td>
				<td>
					<?= Former::horizontal_open()->action("admin/languages/{$l->id}")->addClass('test-class')->method('DELETE') ?>
						<?= Former::actions()->danger_submit('Delete')?>
					<?= Former::close() ?>		
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection
