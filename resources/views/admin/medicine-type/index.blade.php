@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Add Medicine Type</h1>
		<div class="col-xs-8 col-xs-offset-2">
			<?= Former::horizontal_open()->action("admin/medicine-types")->addClass('test-class')->method('POST') ?>
				<?= Former::text('medicine_type')->value('') ?>
				<?= Former::actions()->large_primary_submit('Submit')?>
			<?= Former::close() ?>
		</div>
	</div>

	<div class="row">
		<h1 class="text-center">Medicine Types</h1>
		<table id="medicine-types-table" class="table table-bordered table-hover">
			<thead>
				<th>Medicine Type</th>
				<th>Update</th>
				<th>Actions</th>
			</thead>
			@foreach ($medicine_types as $mt)
			<tr>
				<td>
					{{ $mt->medicine_type }}
				</td>
				<td>
					<?= Former::horizontal_open()->action("admin/medicine-types/{$mt->id}")->addClass('test-class')->method('PUT') ?>
						<?= Former::text('medicine_type_new')->label('')->value($mt->medicine_type) ?>
						<?= Former::actions()->large_primary_submit('Submit')?>
					<?= Former::close() ?>
				</td>
				<td>
					<?= Former::horizontal_open()->action("admin/medicine-types/{$mt->id}")->addClass('test-class')->method('DELETE') ?>
						<?= Former::actions()->danger_submit('Delete')?>
					<?= Former::close() ?>					
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection
