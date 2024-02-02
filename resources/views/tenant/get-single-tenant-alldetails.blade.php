<div class="clearfix mb-0-25">
    <span class="float-xs-left">Tenant:</span>
    <span class="float-xs-right" id="tenantname">{{$tenant->fullname ?? ''}} {{$tenant->companyname ?? ''}}</span>
  </div>
  <div class="clearfix mb-0-25">
    <span class="float-xs-left">Mobile:</span>
    <span class="float-xs-right" id="tenantcell">{{$tenant->cell ?? ''}}</span>
  </div>
  <div class="clearfix mb-0-25">
    <span class="float-xs-left">Email:</span>
    <span class="float-xs-right" id="tenantemail">{{$tenant->email ?? ''}}</span>
</div>
<div class="clearfix mb-0-25">
    <span class="float-xs-left">Billing Address:</span>
    <span class="float-xs-right" id="tenantaddress">{{$tenant->contactaddress ?? ''}}</span>
</div>
<div class="b-a b-a-success b-a-width-1 mb-0-5"></div>
<table  class="table table-hover table-bordered">
    <thead>
        <tr><th>Currency</th><th>Balance</th><th>Prepayment</th></tr>
    </thead>
    <tbody id="balancebd">
        @foreach($balances as $abc)<tr><td>{{ $abc->currencycode }}</td>
            <td>{{ $abc->balancebd }}</td><td>{{ number_format($abc->prepayment,2) }}</td></tr>@endforeach
    </tbody>
</table>
<div class="b-a b-a-success b-a-width-1 mb-0-5"></div>

    