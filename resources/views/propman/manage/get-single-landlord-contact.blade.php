
<option value="" >pick landlord contact</option>
@foreach($landlord as $abc)
	<option value="{{ $abc->id }}">{{ $abc->firstname }} {{ $abc->lastname }}</option>
    @endforeach