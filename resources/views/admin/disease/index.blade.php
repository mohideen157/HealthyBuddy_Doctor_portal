@extends('layouts.master')

@section('content')
	<div class="row" id="allergy-app">
		<h1 class="text-center">Disease</h1>
		<data-table endpoint="{{route('disease.index')}}"></data-table>
	</div>
@endsection