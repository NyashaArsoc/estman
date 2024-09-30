
<option value="" >pick landlord</option>
@foreach($landlord as $abc)
	<option value="{{ $abc->id }}">{{ $abc->companyname }} {{ $abc->fullname }}</option>
    @endforeach