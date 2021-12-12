@if(empty($synched_ids))
	<h3> Not Data Found </h3>
@endif

@foreach($synched_ids as $synched_id)
	@php
		$ppg_path = 'https://us-central1-freeview-d955b.cloudfunctions.net/pulse?email=som@indglobal-consulting.com&synched_id='.$synched_id ;
		$ecg_path = 'https://us-central1-freeview-d955b.cloudfunctions.net/ecg?email=som@indglobal-consulting.com&synched_id='.$synched_id ;
	@endphp
	<h3>ECG</h3>
	<div>
		@php if($synched_id)echo file_get_contents($ecg_path) @endphp
	</div>
	<h3>PPG</h3>
	<div>
		@php if($synched_id)echo file_get_contents($ppg_path) @endphp
	</div>
@endforeach