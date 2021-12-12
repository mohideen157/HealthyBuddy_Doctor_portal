@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row">
		<h1 class="text-center"></h1>
		<div class="col-md-12 col-xs-12 tenant-panel">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title" style="font-size:18px;display: inline-block;">History</h3>
					<span class="pull-right clickable">
						<i class="fa fa-chevron-up"></i>
					</span>
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
										<th>ID</th>
										<th>Name</th>
										<th>SYS(mmHg)</th>
										<th>DIA(mmHg)</th>
										<th>HR(bpm)</th>
										<th>rPWV(m/s)</th>
										<th>Arterial Age</th>
										<th>AFib(#)</th>
										<th>Arrhythmia(#)</th>
									</thead>
									<tbody>
										@foreach($users as $user)
										<tr>
											<td>{{ $user->shdct_user_id }}</td>
											<td>
												<a href="{{ route('admin.history.show', $user->id) }}">
													<img src="{{ asset($user->profile_image) }}" width="50">&nbsp; {{ ucfirst($user->name) }}
												</a>
											</td>
											@php
												$data = Helper::patient_hra_band_data($user->id);
												$bp = $data['bp'];
												$bp = explode('/', $bp);
											@endphp
											<td>{{ $bp[0] ?? '-'}}</td>
											<td>{{ $bp[1] ?? '-' }}</td>
											<td>{{ $data['hr'] ?? '-' }}</td>
											<td>{{ $data['rpwv'] ?? '-' }}</td>
											<td>{{ $data['artrialage'] ?? '-' }}</td>
											<td>{{ $data['afib'] ?? '-' }}</td>
											<td>{{ $data['arrhythmia'] ?? '-' }}</td>
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