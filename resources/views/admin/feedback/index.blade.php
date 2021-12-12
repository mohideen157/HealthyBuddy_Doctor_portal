@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Feedback</h1>
		<table id="feedback-table" class="table table-bordered table-hover">
			<thead>
				<th>User ID</th>
				<th>User</th>
				<th>User Type</th>
				<th>Topic</th>
				<th>Rating</th>
				<th>Details</th>
				<th>Date</th>
			</thead>
			@foreach ($feedback as $f)
			<tr>
				<td>
					{{ $f->user->shdct_user_id }}
				</td>
				<td>
					{{ $f->user->name }}<br />
					<a href="mailto:{{ $f->user->email }}" target="_blank">{{ $f->user->email }}</a><br />
					{{ $f->user->mobile_no }}
				</td>
				<td>
					{{ ucwords($f->user->userRole->user_role) }}
				</td>
				<td>
					{{ $f->topic }}
				</td>
				<td>
					{{ $f->rating }}
				</td>
				<td>
					{{ $f->feedback }}
				</td>
				<td>
					{{ $f->created_at->toDayDateTimeString() }}
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection