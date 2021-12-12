@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">View Article</h1>
		<table class="table table-bordered table-hover">
			<tr>
				<th class="col-xs-3">Name</th>
				<td class="col-xs-9">{{ $article->title }}</td>
			</tr>
			<tr>
				<th class="col-xs-3">Image</th>
				<td class="col-xs-9">
					<img src="{{ $article->image }}" width="200px">
					<?= Former::vertical_open_for_files()->method('POST')->action("/admin/articles/update-image/{$article->id}")->addClass('test-class') ?>
						<?= Former::file('file')->label('Change Image') ?>
						<?= Former::actions()->large_primary_submit('Submit') ?>
					<?= Former::close() ?>
				</td>
			</tr>
			<tr>
				<th class="col-xs-3">Content</th>
				<td class="col-xs-9">{{ $article->content }}</td>
			</tr>
		</table>

		@if($article->active == 0)
			<div>
				<?= Former::vertical_open()->method('GET')->action("/admin/articles/activate") ?>
					<?= Former::token() ?>
					<?= Former::hidden('article_id')->value($article->id) ?>
					<?= Former::actions()->large_primary_submit('Activate') ?>
				<?= Former::close() ?>
			</div>
		@else
			<div>
				<?= Former::vertical_open()->method('GET')->action("/admin/articles/deactivate") ?>
					<?= Former::token() ?>
					<?= Former::hidden('article_id')->value($article->id) ?>
					<?= Former::actions()->large_danger_submit('Deactivate') ?>
				<?= Former::close() ?>
			</div>
		@endif
@endsection