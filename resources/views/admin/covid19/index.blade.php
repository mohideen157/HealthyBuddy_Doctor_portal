@extends('layouts.master')

@section('content')
<div class="container-fluid">
<div class="row">
	<h1 class="text-center"></h1>
    <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
	        <div class="panel-heading">
				<h3 class="panel-title" style="font-size:18px;display: inline-block;">Covid Details</h3>
				<span class="pull-right clickable">
					<i class="fa fa-chevron-up"></i>
				</span>
		    </div>
			<div class="panel-body">
			   <div id="collapse" class="table-responsive">
				<table id="adminsettings-table" width="100%" class="table display responsive no-wrap table-bordered table-hover">
					<thead>
						<th>ID</th>
						<th>Mobile Number</th>
						<th>Triage Level</th>
						<th>Label</th>
						<th>Description</th>
						<th>Checked Datetime</th>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{ $user->user_id ?? ''}}</td>
								<td>{{ $user->mobile_no ?? ''}}</td>
								<td>{{ $user->triage_level  ?? ''}}</td>
								<td>{{ $user->label ?? ''}}</td>
								<td>{{ $user->description ?? '' }}</td>
								<td>{{ $user->checked_datetime ?? '' }}</td>
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
