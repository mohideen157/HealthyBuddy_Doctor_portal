@extends('layouts.master')

@section('content')
	<div class="row" id="allergy-app">
		<h1 class="text-center">Allergies</h1>
		<data-table endpoint="{{route('allergy.index')}}"></data-table>
	</div>
@endsection