@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row">
		<h1 class="text-center"></h1>
		<div class="col-md-12 col-xs-12 tenant-panel">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title" style="font-size:18px;display: inline-block;">{{ $history->user->name }} History Graph</h3>
					<span class="pull-right clickable">
						<i class="fa fa-chevron-up"></i>
					</span>
					<a href="{{ route('admin.history.show', $history->user->id) }}" style="margin-left: 20px;">
						<i class="fa fa-arrow-left"></i> Back
					</a>
				</div>
				<div class="panel-body">
					
					<div id="ecg" class="tab-pane">
						@php
							$synched_id = Helper::get_synched_id($history->user);
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
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
@endsection