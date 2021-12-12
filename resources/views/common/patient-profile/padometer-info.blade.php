@php
	$pado_meter = Helper::patient_profile($user, 'pado-meter',null, $date);
	if($pado_meter){
		$extra_info = json_decode($pado_meter->extra_info, true);
		$pado_meter_date = date('d M, Y', strtotime($pado_meter->created_at));
	}
@endphp

<div class="row">
	<div class="col-md-2">
		<div class="img-text-wrap">
			<img src="{{ asset('images/walking.png') }}" alt="steps" class="img-responsive">
			<div class="text-content">
				<p>{{ $extra_info['steps'] ?? '-' }}</p>
				<span>Steps</span>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="img-text-wrap">
			<img src="{{ asset('images/route.png') }}" alt="steps" class="img-responsive">
			<div class="text-content">
				<p>{{ $extra_info['distance'] ?? '-'}}</p>
				<span>Distance</span>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="img-text-wrap">
			<img src="{{ asset('images/burn.png') }}" alt="steps" class="img-responsive">
			<div class="text-content">
				<p>{{ $extra_info['calories'] ?? '-'}}</p>
				<span>Calories</span>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="img-text-wrap">
			<img src="{{ asset('images/calendar.png') }}" alt="steps" class="img-responsive">
			<div class="text-content">
				<p>{{ $pado_meter_date ?? '-'}}</p>
				<span>Date</span>
			</div>
		</div>
	</div>
</div>


