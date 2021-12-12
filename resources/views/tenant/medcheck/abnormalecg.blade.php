@extends('tenant.component._master')

@section('content')
<div class="container-fluid">
	<div class="row">

		<div class="col-md-12 dashboard-wrapper">
			<div class="col-md-9 dashboard_box_container">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<a href="{{ route('tenant.medcheck') }}" class="all-color search-option active-search-option">
						<span class="number-info">{{ $users->count() }}</span>
						<span class="name-info">All</span>
					</a>
				</div>
				
				<div class="col-md-3 col-sm-6 col-xs-12">
					<a href="{{ route('tenant.medcheck.abnormal') }}" class="arrhythmia-color search-option">
						<span class="number-info">{{ $users1->count() }}</span>
						<span class="name-info">Abnormal <br/> (Temp > 37.5 °C)</span>
					</a>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<a href="{{ route('tenant.medcheck.abnormalecg') }}" class="arrhythmia-color search-option">
						<span class="number-info">{{ $users3->count() }}</span>
						<span class="name-info">Abnormal <br/> (ECG [QTc] > 450)</span>
					</a>
				</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
					<a href="{{ route('tenant.medcheck.abnormalspo2') }}" class="arrhythmia-color search-option">
						<span class="number-info">{{ $users4->count() }}</span>
						<span class="name-info">Abnormal <br/> (SPO2 < 95)</span>
					</a>
				</div>
		
			</div>
			
			
		</div>
    <div class="col-md-12 col-xs-12 tenant-panel">
		<div class="panel panel-default">
	        <div class="panel-heading">
				<h3 class="panel-title" style="font-size:18px;display: inline-block;">Patient Device Reading</h3>
				<span class="pull-right clickable">
					<i class="fa fa-chevron-up"></i>
				</span>
		    </div>
			<div class="panel-body">
			   <div id="collapse" class="table-responsive">
				<table id="adminsettings-table" width="100%" class="table display responsive no-wrap table-bordered table-hover">
					<thead>
						 <th>ID</th>
			             <th>Name </th>
			             <th>Email</th>
			             <th>Mobile Number</th>
					</thead>
					<tbody>
						@foreach($users3 as $user)
						
						
							<tr>
								<td>{{ $user->shdct_user_id ?? '' }}</td>
					           <td><a href="{{ route('tenant.medcheck.show', $user->id) }}">
													<img src="{{ asset($user->profile_image) }}" width="50">&nbsp; {{ ucfirst($user->name) }}
												</a>
								</td>
								<td>{{ $user->email ?? '' }}</td>
					            <td>{{ $user->mobile_no ?? '' }}</td>
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
