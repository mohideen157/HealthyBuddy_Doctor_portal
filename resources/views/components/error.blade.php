{{-- component to display error message inside the form --}}
@if($errors->has($index))
	<span style="color:red">{{ $errors->first($index) }}</span>
@endif