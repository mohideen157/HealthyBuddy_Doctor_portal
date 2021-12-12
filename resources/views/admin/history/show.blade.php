@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row">
		<h1 class="text-center"></h1>
		<div class="col-md-12 col-xs-12 tenant-panel">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title" style="font-size:18px;display: inline-block;">{{ $user->name }} History</h3>
					<span class="pull-right clickable">
						<i class="fa fa-chevron-up"></i>
					</span>
					<a href="{{ route('admin.history') }}" style="margin-left: 20px;">
						<i class="fa fa-arrow-left"></i> Back
					</a>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4 col-md-offset-8">
							<select name="user" id="user" class="form-control">
								<option value=""></option>
							</select>
						</div>
					</div>
					<hr>
					<div id="collapse" class="table-responsive">
						<table id="adminsettings-table" class="table table-bordered table-hover">
							<thead>
								<th>AFIB</th>
								<th>Arrythmia</th>
								<th>Bp</th>
								<th>HRVLevel</th>
								<th>Heart Rate</th>
								<th>rPWV</th>
								<th>Date</th>
								<th>Action</th>
							</thead>
							<tbody>
								@foreach($user->history as $history)
								<tr>
									<td>{{ $history->afib }}</td>
									<td>{{ $history->arrhythmia }}</td>
									<td>{{ $history->bp }}</td>
									<td>{{ $history->hrvlevel }}</td>
									<td>{{ $history->heart_rate }}</td>
									<td>{{ $history->rpwv }}</td>
									<td>{{ $history->date }}</td>
									<td>
										<a href="{{ route('admin.history.graph', $history->id) }}" class="btn btn-sm btn-info">
											Show Graph
										</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
@endsection