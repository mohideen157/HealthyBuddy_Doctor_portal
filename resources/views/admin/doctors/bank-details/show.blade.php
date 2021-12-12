@extends('layouts.master')

@section('content')
	<div class="row">
		<h1 class="text-center">Doctor Bank Details</h1>

		<div class="col-xs-12" role="tabpanel" data-example-id="togglable-tabs">
			@include('layouts.doctor_tabs')
			<div id="myTabContent" class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
					@if(count($doctor->bankDetails) > 0)
						<table class="table table-bordered table-hover">
							<tr>
								<th class="col-xs-2">Bank</th>
								<td class="col-xs-10">{{ $doctor->bankDetails[0]->bank_name }}</td>
							</tr>
							<tr>
								<th class="col-xs-2">Account Type</th>
								<td class="col-xs-10">{{ $doctor->bankDetails[0]->account_type }}</td>
							</tr>
							<tr>
								<th class="col-xs-2">Account No.</th>
								<td class="col-xs-10">{{ Crypt::decrypt($doctor->bankDetails[0]->account_no) }}</td>
							</tr>
							<tr>
								<th class="col-xs-2">IFSC Code</th>
								<td class="col-xs-10">{{ $doctor->bankDetails[0]->ifsc }}</td>
							</tr>
						</table>
					@else
						<p>Doctor has not added their bank details</p>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection