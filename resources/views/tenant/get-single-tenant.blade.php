
<option value="" >Select Tenant</option>
@foreach($tenant as $abc)
    @php
        if ($abc->clienttypeid == 1){ // individual
           $Tenant   =  $abc->fullname ;
        }else{
            $Tenant   =  $abc->companyname ;
        }
    @endphp
	<option value="{{ $abc->id }}">{{ $Tenant }}</option>
    @endforeach