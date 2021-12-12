@extends('layouts.master')

@section('content')
	<div class="row" id="allergy-app">
		<h1 class="text-center">Medications</h1>
		<data-table endpoint="{{route('medication.index')}}"></data-table>
	</div>
@endsection