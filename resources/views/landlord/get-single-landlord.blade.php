
<option value="" >Select Landlord</option>
@foreach($landlord as $land)
    @php
        if ($land->clienttypeid == 1){
           $Owner   =  $land->fullname ;
        }else{
            $Owner   =  $land->companyname ;
        }
    @endphp
	<option value="{{ $land->id }}">{{ $Owner }}</option>
    @endforeach