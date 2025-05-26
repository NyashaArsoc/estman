<option value="">pick client</option>
@foreach($client as $abc)
<option value="{{ $abc->id }}">{{ $abc->companyname }} {{ $abc->lastname }} {{ $abc->firstname }}</option>
@endforeach