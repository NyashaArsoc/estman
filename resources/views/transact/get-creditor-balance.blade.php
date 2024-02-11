<div id="creditorbalance"> 
    <table  class="table table-hover table-bordered">
    <thead>
        <tr><th>Currency</th><th>Balance</th></tr>
    </thead>
    <tbody id="balancebd">
        @foreach($balance as $abc)<tr><td>{{ $abc->currency }}</td>
            <td>{{ $abc->otherexpenses ?? $abc->caretaker ?? $abc->security
            ?? $abc->operationalcost ?? $abc->rates ?? $abc->vat}}</td></tr>@endforeach
    </tbody>
</table>
</div>