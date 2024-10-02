
<option value="" >pick property</option>
@foreach($property as $abc)
	<option value="{{ $abc->id }}">{{ $abc->streetaddress }}</option>
@endforeach