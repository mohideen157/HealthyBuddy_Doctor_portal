@extends('layouts.master')

@section('content')
	<!-- top tiles -->
	<div class="container-fluid">
		<div class="row tile_count">
			<div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
				<div class="card">
					<span class="count_top"><i class="fa fa-user"></i> Total Users</span>
					<div class="count">{{ $totals['total_users'] }}</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
				<div class="card">
					<span class="count_top"><i class="fa fa-user-md"></i> Total Doctors</span>
					<div class="count green">{{ $totals['total_doctors'] }}</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
				<div class="card">
					<span class="count_top"><i class="fa fa-user"></i> Total Patients</span>
					<div class="count">{{ $totals['total_patients'] }}</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
				<div class="card">
					<span class="count_top"><i class="fa fa-users"></i> Total Appointments</span>
					<div class="count">{{ $totals['total_appointments'] }}</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /top tiles -->
@endsection
