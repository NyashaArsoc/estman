<option value="" >select client</option>
@foreach($client as $abc)
    @php
        if ($abc->clienttypeid == 1){
        $fullname   =  $abc->firstname.' '.$abc->lastname ;
             }else{
                 $fullname   =  $abc->companyname;
             }
    @endphp
	<option value="{{ $abc->id }}">{{ $fullname }}</option>
    @endforeach