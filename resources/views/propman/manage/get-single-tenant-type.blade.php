<option value="" >pick tenant</option>
    @foreach($tenant as $abc)
        <option value="{{ $abc->id }}">{{ $abc->companyname }} {{ $abc->fullname }}</option>
    @endforeach