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

<div class="table-responsive">
	<div class="panel-group" id="accordion" style="margin-top:20px;">
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
	        Travel Information<i class="fa fa-chevron-down"></i></a>
	      </h4>
	    </div>
	    <div id="collapse2" class="panel-collapse collapse">
	      <div class="panel-body table-responsive">
	      	<table class="table-bordered profile" width="100%">
	      		<tbody>
					<tr>
						@php
						$national_travel =  Helper::patient_profile($user, 'travel-national', 'travel-interval', $date);
						$international_travel = Helper::patient_profile($user, 'travel-international', 'travel-interval', $date);
						@endphp
						<th>Travel Frequency(National)</th>
						@if($national_travel)
						<td id="national-travel">{{ $national_travel->unit }} ({{ $national_travel->value }})</td>
						@endif
						<th>Travel Frequency(International)</th>
						@if($international_travel)
						<td id="international-travel">{{ $international_travel->unit }} ({{ $international_travel->value }})</td>
						@endif
					</tr>
	      		</tbody>
	      	</table>
	      </div>
	    </div>
	  </div>
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
	        Diet Information<i class="fa fa-chevron-down"></i></a>
	      </h4>
	    </div>
	    <div id="collapse3" class="panel-collapse collapse">
	      <div class="panel-body table-responsive">
	      	<table class="table-bordered profile" width="100%">
	      		<tbody>
					<tr>
						<th>Diet Type</th>
						<td id="diet-type">{{ Helper::patient_profile($user, 'diet-type', null, $date)->value ?? ''}}</td>
						<th>Average quantity of vegetables consumed everyday</th>
						<td id="vegetables">{{ Helper::patient_profile($user, 'cup-of-vegetables', null, $date)->value  ?? ''}}</td>
						<th>Average quantity of fast food consumed everyday</th>
						<td id="fast-food">{{ Helper::patient_profile($user, 'fast-food', null, $date)->value ?? '' }}</td>
					</tr>
					<tr>
						<th>How many cups of fruits you had in the last week?</th>
						<td id="fruits">{{ Helper::patient_profile($user, 'fruits', null, $date)->value ?? ''}}</td>
						<th>Average quantity of cereals everyday</th>
						<td id="cereals">{{ Helper::patient_profile($user, 'fast-food', null, $date)->value ?? ''}}</td>
						<th>Drinks(juice,soda,cola) taken in the past week</th>
						<td id="drinks">{{ Helper::patient_profile($user, 'drinks', null, $date)->value ?? ''}}</td>
					</tr>
	      		</tbody>
	      	</table>
	      </div>
	    </div>
	  </div>
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
	        Alcohol Information<i class="fa fa-chevron-down"></i></a>
	      </h4>
	    </div>
	    <div id="collapse4" class="panel-collapse collapse">
	      <div class="panel-body table-responsive">
	      	<table class="table-bordered profile" width="100%">
	      		<tbody>
					<tr>
						@php $alcohols = Helper::getAlcoholConsumption($user->id, $date) @endphp
						<th>Do you take alcohol</th>
						<td id="alcohol">{{ Helper::patient_profile($user, 'alcohol', null, $date)->value ?? '' }}</td>
						<th>Alochol Intake</th>
						<td colspan="3" id="intake-alcohol">
							@foreach($alcohols as $alcohol)
							<ul>
								<li>{{ $alcohol->child_key }}</li>
								<ul>
									<li>{{ $alcohol->value }}</li>
									<li>{{ $alcohol->extra_info }}</li>
								</ul>
							</ul>
							@endforeach
						</td>
						{{-- <th>Choose Quantity of Alochol Intake</th>
						<td id="quantity-alcohol">Small</td> --}}
					</tr>
	      		</tbody>
	      	</table>
	      </div>
	    </div>
	  </div>
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
	        Tobacco Information<i class="fa fa-chevron-down"></i></a>
	      </h4>
	    </div>
	    <div id="collapse5" class="panel-collapse collapse">
	      <div class="panel-body table-responsive">
	      	<table class="table-bordered profile" width="100%">
	      		<tbody>
					<tr>
						<th>Smoking</th>
						<td id="smoke">{{ Helper::patient_profile($user, 'smoking', null, $date)->value ?? '' }}</td>
						<th>Smoking Intake</th>
						<td id="smoking-intake">{{ Helper::patient_profile($user, 'smoking', 'smoking-interval', $date)->value ?? '' }}</td>
						<th>Choose number of cigarettes smoked</th>
						<td id="smoking-times">{{ Helper::patient_profile($user, 'smoking', 'dosage', $date)->value ?? ''}}</td>
					</tr>
	      		</tbody>
	      	</table>
	      </div>
	    </div>
	  </div>
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
	        Physical Activity<i class="fa fa-chevron-down"></i></a>
	      </h4>
	    </div>
	    <div id="collapse6" class="panel-collapse collapse">
	      <div class="panel-body table-responsive">
	      	<table class="table-bordered profile" width="100%">
	      		<tbody>
					<tr>
						<th>Choose consumption of non-smoking tobacco</th>
						<td id="non-smoking-tobaco">{{ Helper::patient_profile($user, 'smoking', 'tobacco', $date)->value ?? '' }}</td>
						<th>In the past week, how much time did you spend doing vigorous intensity physical activity?</th>
						<td id="vigorous-activity">{{ Helper::patient_profile($user, 'vigorus-physical-activity',null, $date)->value ?? ''}}</td>
						<th>In the past week, how much time did you spend doing moderate intensity physical activity?</th>
						<td id="moderate-activity">{{ Helper::patient_profile($user, 'moderate-physical-activity',null, $date)->value ?? '' }} </td>
					</tr>
					<tr>
						<th>In the past week, how much time did you spend doing light intensity physical activity?</th>
						<td id="light-activity">{{ Helper::patient_profile($user, 'light-physical-activity', null, $date)->value ?? ''}}</td>
					</tr>
	      		</tbody>
	      	</table>
	      </div>
	    </div>
	  </div>
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
	        Health Information<i class="fa fa-chevron-down"></i></a>
	      </h4>
	    </div>
	    <div id="collapse7" class="panel-collapse collapse">
	      <div class="panel-body table-responsive">
	      	<table class="table-bordered profile" width="100%">
	      		<tbody>
			      	<tr>
						<th>Are you Diabetic?</th>
						<td id="diabtice">{{ Helper::patient_profile($user, 'diebetic', null, $date)->value ?? ''}}</td>
						<th>Are you Diabetic?</th>
						<td id="diabtice-answer">{{ Helper::patient_profile($user, 'diebetic', 'medicine', $date)->value ?? '' }}</td>
						<th>Taking Blood Cholesterol (checked within 6 months)</th>
						<td id="blood-cholesterol">{{ Helper::patient_profile($user, 'blood-cholestrol', null, $date)->value ?? ''}}</td>
					</tr>
					<tr>
						<th>Enter Systolic Blood Pressure (if checked recently)</th>
						<td id="sys-bp">{{ Helper::patient_profile($user, 'blood-pressure', 'systolic', $date)->value ?? '' }}</td>
						<th>Enter Diastolic Blood Pressure (if checked recently)</th>
						<td id="ds-bp">{{ Helper::patient_profile($user, 'blood-pressure', 'diastolic', $date)->value ?? '' }}</td>
						<th>Have you been diagnosed to have any heart related ailment?</th>
						<td id="heart-aliment">{{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'heart-attack', $date)->value ?? ''}}</td>
					</tr>
					<tr>
						<th>Coronary artey disease/ ischemic heart disease</th>
						<td id="artery">{{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'coronary-heart-ischemic-heart', $date)->value  ?? ''}}</td>
						<th>Have you ever suffered form Angina pain?</th>
						<td id="angina-pain">{{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'angina-pain', $date)->value ?? ''}}</td>
						<th>Are you under regular medication for the same?</th>
						<td id="medication">{{ Helper::patient_profile($user,'cardiovascular-or-stroke','regular-medication', $date)->value ?? '' }}</td>
					</tr>
					<tr>
						<th>Have you suffered a heart attack?</th>
						<td id="heart-attck">{{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'heart-attack', $date)->value ?? ''}}</td>
						<th>Do you have an abnormal ECG for which you are being treated?</th>
						<td id="ECG">{{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'ecg', $date)->value ?? ''}}</td>
						<th>Have you undergone coronary angiography?</th>
						<td id="angiography">{{ Helper::patient_profile($user, 'cardiovascular-or-stroke', 'coronary-angiography', $date)->value ?? ''}}</td>
					</tr>
					<tr>
						<th>Have you suffered from stroke?</th>
						<td id="stroke">{{ Helper::patient_profile($user, 'stroke', null, $date)->value ?? '' }}</td>
						<th>Reason for stroke?</th>
						<td id="stroke-reason">{{ Helper::patient_profile($user, 'stroke', 'reason-for-stroke', $date)->value ?? '' }}</td>
						<th>Have you ever been diagnosed to have a TIA(Transient Ischemic Attck)</th>
						<td id="tia">{{ Helper::patient_profile($user, 'tia', null, $date)->value ?? ''}}</td>
					</tr>
					<tr>
						<th>Are you under regular treatment for the same?</th>
						<td id="tia-treatment">{{ Helper::patient_profile($user, 'tia', 'regular-treatment', $date)->value ?? '' }}</td>

						{{-- <th>Any Pre-Existing Diseases?</th> --}}
						{{-- <td id="pre-diseases">@if($diseases->count) 'Yes' @else 'No' @endif</td> --}}
						@php $diseases = Helper::patient_profile_collection($user, 'disease', 'disease-details', $date)->get() @endphp
						<th>Any Pre-Existing Diseases?</th>
						<td id="pre-diseases-list">
							@foreach($diseases as $disease)
							<li class="w-100">{{ $disease->value }}</li>
							@endforeach
						</td>
						@php $allergies = Helper::patient_profile_collection($user, 'allergy', 'allergy-details', $date)->get() @endphp
						<th>Any Allergy?</th>
						<td id="allergy">{{ Helper::patient_profile($user, 'allergy', null, $date)->value ?? '' }}</td>
					</tr>
					<tr>
						<th>Any Allergy?</th>
						<td id="allergy-list">
							@foreach($allergies as $allergy)
							<li class="w-100">{{ $allergy->value }}</li>
							@endforeach
						</td>
						@php $medications = Helper::patient_profile_collection($user, 'medication', 'medication-details', $date)->get() @endphp

						<th>Any Medication?</th>
						<td id="normal-medication">{{ Helper::patient_profile($user, 'medication', null, $date)->value ?? '-' }}</td>
						<th>Any Medication?</th>
						<td id="normal-medication-list">
							@foreach($medications as $medication)
							<li class="w-100">{{ $medication->value }}
								@php $extra_info = json_decode($medication->extra_info ) @endphp
								<ul>
									<li>{{ $extra_info->type }}</li>
									<li>{{ $extra_info->dosage }}</li>
									<li>{{ $extra_info->per_day }}</li>
								</ul>
							</li>
							@endforeach
						</td>
					</tr>
	      		</tbody>
	      	</table>
	      </div>
	    </div>
	  </div>
	</div>
</div>
