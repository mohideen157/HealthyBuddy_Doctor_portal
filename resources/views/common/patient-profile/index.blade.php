@extends(App\User::isTenant() ? 'tenant.component._master' : (App\User::isOrganisation() ? 'organisation.component._master' : (App\User::isDoctor() ? 'doctor.component._master' : 'layouts.master')))

@php
	if(App\User::isTenant()){
		$all_route = 'tenant.patient.profile';
		$afib_filter_route = 'tenant.patient.profile.filter.afib';
		$arrhythmia_filter_route = 'tenant.patient.profile.filter.arrhythmia';
		$filter_abnormal = 'tenant.patient.profile.filter.abnormal';
		$org = Helper::tenant_organisation(Auth::id());
	}
	elseif(App\User::isOrganisation()){
		$all_route = 'organisation.patient.profile';
		$afib_filter_route = 'organisation.patient.profile.filter.afib';
		$arrhythmia_filter_route = 'organisation.patient.profile.filter.arrhythmia';
		$filter_abnormal = 'organisation.patient.profile.filter.abnormal';
		$org = [Auth::id()];
	}
	elseif(App\User::isDoctor()){
		$all_route = 'doctor.patient.profile';
		$afib_filter_route = 'doctor.patient.profile.filter.afib';
		$arrhythmia_filter_route = 'doctor.patient.profile.filter.arrhythmia';
		$filter_abnormal = 'doctor.patient.profile.filter.abnormal';
		$org = Helper::doctor_organisation(Auth::id());
	}
	else{
		$all_route = 'admin.patient.profile';
		$afib_filter_route = 'admin.patient.profile.filter.afib';
		$arrhythmia_filter_route = 'admin.patient.profile.filter.arrhythmia';
		$filter_abnormal = 'admin.patient.profile.filter.abnormal';
		$org = [];
	}
@endphp

@section('style')
<style type="text/css">
.loader{
    visibility: hidden;
    display: flex;
    margin: auto;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">

		<div class="col-md-12 dashboard-wrapper">
			<div class="col-md-9 dashboard_box_container">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<a href='{{ route($all_route) }}' class="all-color search-option active-search-option">
						<span class="number-info">{{ $users->count() }}</span>
						<span class="name-info">All</span>
					</a>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<a href='{{ route($filter_abnormal) }}' class="abnormal-color search-option">
						<span class="number-info">{{ Helper::filter_abnormal()->count() }}</span>
						<span class="name-info">Abnormal</span>
					</a>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<a href={{ route($afib_filter_route)}} class="afib-color search-option">
						<span class="number-info">{{ Helper::filter_by_afib($org)->count() }}</span>
						<span class="name-info">Afib</span>
					</a>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<a href='{{ route($arrhythmia_filter_route) }}' class="arrhythmia-color search-option">
						<span class="number-info">{{ Helper::filter_by_arrhythmia($org)->count() }}</span>
						<span class="name-info">Arrhythmia</span>
					</a>
				</div>
			</div>
			<div class="col-md-3 search-wrapper">
				<div class="select-style">
					<select id="select-option">
						<option value="device2" selected>Device 2</option>
					</select>
				</div>
			</div>
		</div>
		<div class="tenant-panel-wrapper" id="table-content">
			<div class="col-md-12 col-xs-12 tenant-panel" id="device2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title" style="font-size:18px;display: inline-block;">Patient Profile - Device 2</h3>
						<span class="pull-right clickable">
							<i class="fa fa-chevron-up"></i>
						</span>
					</div>
					<div class="panel-body" style="padding: 0;">
						<div id="collapse">
							<div class="table-responsive">
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
											<td id="show-link">
												@if(App\User::isTenant())
													<a href="{{ route('tenant.patient.profile.show',$user->id) }}">
														<img src="{{ asset($user->profile_image) }}">{{ ucfirst($user->name) }}
													</a>
												@else
													<a href="{{ route('common.patient.profile.show',$user->id) }}">
														<img src="{{ asset($user->profile_image) }}">{{ ucfirst($user->name) }}
													</a>
												@endif
											</td>
											@php
												$data = Helper::patient_hra_band_data($user->id);
												$bpSYS=null;
												$bpDIA=null;
												if(isset($data['bp'])){
												$bp = $data['bp'];
												$bp = explode('/', $bp);
												$bpSYS=$bp[0];
												$bpDIA=$bp[1];
												}
											@endphp
											<td>{{ $bpSYS ?? '-'}}</td>
											<td>{{ $bpDIA ?? '-' }}</td>
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
			{{-- <div class="col-md-12 col-xs-12 tenant-panel" id="device1">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title" style="font-size:18px;display: inline-block;">Patient Profile - Device1</h3>
						<span class="pull-right clickable">
							<i class="fa fa-chevron-up"></i>
						</span>
					</div>
					<div class="panel-body" style="padding: 0;">
						<div id="collapse">
							<div class="table-responsive">
								<table id="adminsettings-table" class="table table-bordered table-hover">
									<thead>
										<th>Name</th>
										<th>Steps</th>
										<th>BPM</th>
										<th>Oxygenation</th>
										<th>Systolic/diastolic</th>
										<th>healthy heart count</th>
										<th>Good blood reference</th>
										<th>Ecg</th>
										<th>PPG</th>
									</thead>
									<tbody>
										<tr>
											<td>
												<a href="#" data-toggle="modal" data-target="#information-modal"><img src="/images/admin.jpg">Abhishek</a>
											</td>
											<td>64</td>
											<td>122</td>
											<td>80</td>
											<td>78</td>
											<td>4.8</td>
											<td>33.4</td>
											<td>-</td>
											<td>2</td>
										</tr>
										<tr>
											<td>
												<a href="#" data-toggle="modal" data-target="#information-modal"><img src="/images/admin.jpg">Anita</a>
											</td>
											<td>0</td>
											<td>--</td>
											<td>--</td>
											<td>--</td>
											<td>--</td>
											<td>61.4-</td>
											<td>--</td>
											<td>--</td>
										</tr>
										<tr>
											<td>
												<a href="#" data-toggle="modal" data-target="#information-modal"><img src="/images/admin.jpg">Gaurav</a>
											</td>
											<td>0</td>
											<td>--</td>
											<td>--</td>
											<td>--</td>
											<td>--</td>
											<td>39.9--</td>
											<td>--</td>
											<td>--</td>
										</tr>
										<tr>
											<td>
												<a href="#" data-toggle="modal" data-target="#information-modal"><img src="/images/admin.jpg">Nishant</a>
											</td>
											<td>0</td>
											<td>--</td>
											<td>--</td>
											<td>--</td>
											<td>--</td>
											<td>39.3-</td>
											<td>--</td>
											<td>--</td>
										</tr>
										<tr>
											<td>
												<a href="#" data-toggle="modal" data-target="#information-modal"><img src="/images/admin.jpg">Rajat Sharma</a>
											</td>
											<td>14</td>
											<td>121-</td>
											<td>74-</td>
											<td>76</td>
											<td>4.4-</td>
											<td>39.2-</td>
											<td>--</td>
											<td>2-</td>
										</tr>
										<tr>
											<td>
												<a href="#" data-toggle="modal" data-target="#information-modal"><img src="/images/admin.jpg">Anita</a>
											</td>
											<td>75</td>
											<td>75</td>
											<td>75</td>
											<td>75</td>
											<td>64</td>
											<td>64</td>
											<td>64</td>
											<td>64</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div> --}}
		</div>
	</div>
	<div class="loader">
		<img src="{{ asset('images/loader.gif') }}" class="img-responsive">
	</div>
@endsection

@section('script')
<script type="text/javascript">

	$(document).ready(function(){

		$('#show-link a').click(function(){
			$(".loader").css("visibility","visible");
		});

	});
	
</script>
@endsection