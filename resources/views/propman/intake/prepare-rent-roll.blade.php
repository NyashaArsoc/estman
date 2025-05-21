@php
$title = 'Rent Roll';
$description = 'property details...';

if ($property->commissiontype == 'rental'){
$comissioncharged = ($property->commission/100) * $roll->rental;
}else if($property->commissiontype == 'rental and rates'){
$comissioncharged = ($property->commission/100) * ($roll->rental +
$roll->rates );
}else if($property->commissiontype == 'rental and operation cost'){
$comissioncharged = ($property->commission/100) * ($roll->rental +
$roll->operationalcost );
}else{
$comissioncharged = 0;
}
$id= Crypt::encrypt($roll->id);
$currency= Crypt::encrypt($roll->currencycode);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Rent Roll')
@section('additional css')
<!-- Additional css Start-->
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
<!-- Additional css End-->
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('propin.preremit')}}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title.' - '.$roll->currencycode }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <div class="form-group row">
            <label for="" class="col-sm-2 form-control-label">Landlord </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="{{ $roll->companyname}} {{ $roll->fullname}}" readonly>
            </div>
            <label for="City" class="col-sm-2 col-form-label">Property Address </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="{{ $roll->propertyaddress }}" readonly>
            </div>
        </div>
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="rentroll-detail-tab" data-toggle="tab" href="#rentroll-detail" role="tab" aria-controls="rentroll-detail" aria-selected="true">Rent-Roll Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="billing-info-tab" data-toggle="tab" href="#billing-info" role="tab" aria-controls="billing-info" aria-selected="true">Billing Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="collection-info-tab" data-toggle="tab" href="#collection-info" role="tab" aria-controls="collection-info" aria-selected="true">Collection Information</a>
            </li>
        </ul>
        <div class="b-a b-a-primary b-a-width-1 mb-0-5"></div>
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent"><br />
            <div class="tab-pane show active" id="rentroll-detail" role="tabpanel" aria-labelledby="rentroll-detail-tab">
                <form class="form-material material-primary" id="defaultform"
                    action="{{ route('propin.prepareroll',$id) }}" method="post"> @csrf
                    <div class="form-group row">
                        <label for="PropertyType" class="col-sm-2 form-control-label">Rental Balancebd</label>
                        <div class="col-sm-4"></div>
                        <label for="" class="col-sm-2 col-form-label"> </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="rentalbd"
                                value="{{ number_format($roll->balancebd, 2, '.', ',')}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="PropertyType" class="col-sm-2 form-control-label">Total Billed</label>
                        <div class="col-sm-4"></div>
                        <label for="" class="col-sm-2 col-form-label"> </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="amountbilled"
                                value="{{ number_format($roll->totalbilled, 2, '.', ',')}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="PropertyType" class="col-sm-2 form-control-label">Collections</label>
                        <div class="col-sm-4"></div>
                        <label for="" class="col-sm-2 col-form-label"> </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="receipts"
                                value="{{ number_format($roll->totalreceipts, 2, '.', ',')}}" readonly>
                        </div>
                    </div>
                    <h4>Deductions</h4>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Interest</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="interest"
                                value="{{ number_format($roll->interest, 2, '.', ',')}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Commission ({{$property->commission.'%'}})</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="commission" name="commission"
                                readonly value="{{number_format($comissioncharged, 2, '.', ',')}}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Rates/Levies</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="rates" name="rates"
                                value="{{ number_format($roll->rates, 2, '.', ',')}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Operational Costs</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="operationalcost" name="operationalcost"
                                value="{{ number_format($roll->operationalcost, 2, '.', ',')}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">VAT</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="vat" name="vat"
                                value="{{ number_format($roll->vat, 2, '.', ',')}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Security</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="securitycharge"
                                id="securitycharge" />
                            <small id="securitychargecheck" style="color: red;"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Caretaker</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="caretakercharge"
                                id="caretakercharge" autocomplete="off" min="0" />
                            <small id="caretakerchargecheck" style="color: red;"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Other Expenses</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="otherexpensecharge"
                                id="otherexpensecharge" autocomplete="off" min="0" />
                            <small id="otherexpensechargecheck" style="color: red;"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Total Deductions</label>
                        <div class="col-sm-4"></div>
                        <label for="" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-2">
                            <small id="remitcalcdeductionscheck" style="color: rgb(11, 2, 57);"> </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="TotalArea" class="col-sm-2 col-form-label">Total Remittance</label>
                        <div class="col-sm-4">
                        </div>
                        <label for="" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-2">
                            <small id="remitcalcremittancecheck" style="color: rgb(7, 86, 16);"></small>
                        </div>
                    </div>
                    <br />
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <table class="datatable table table-hover table-bordered"><!--4th table-->
                                <tr>
                                    <th>Account Name</th>
                                    <th>Bank</th>
                                    <th>Branch</th>
                                    <th>Account Number</th>
                                </tr>
                                <tbody>@foreach($bank as $abc) <tr>
                                        <td>{{ $abc->accountname }}</td>
                                        <td>{{ $abc->bankname }}</td>
                                        <td>{{ $abc->branch }}</td>
                                        <td>{{ $abc->accountnumber }}</td>
                                    <tr> @endforeach
                                </tbody>
                            </table><!--4th table-->
                        </div>
                    </div>
                    <div class="form-group row">
                        @if (in_array(1,$arraycontrolids))
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-pre-remit">submit</button>
                        </div>
                        @endif
                    </div>
                    @include('layout.arlet')
                </form>
            </div>
            <div class="tab-pane show" id="billing-info" role="tabpanel" aria-labelledby="billing-info-tab">
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Name</th>
                            <th>Billed</th>
                            <th>Rental</th>
                            <th>Rates</th>
                            <th>Operation</th>
                            <th>Vat</th>
                            <th>Interest</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice as $abc)
                        <tr>
                            <td>{{ $abc->invoicenumber }}</td>
                            <td>{{ $abc->companyname}} {{ $abc->fullname}}</td>
                            <td>{{ number_format($abc->totalbilled, 2, '.', ',') }}</td>
                            <td>{{ number_format($abc->rental, 2, '.', ',') }}</td>
                            <td>{{ number_format($abc->rates, 2, '.', ',') }}</td>
                            <td>{{ number_format($abc->operationalcost, 2, '.', ',') }}</td>
                            <td>{{ number_format($abc->vat, 2, '.', ',') }}</td>
                            <td>{{ number_format($abc->interest, 2, '.', ',') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane show" id="collection-info" role="tabpanel" aria-labelledby="collection-info-tab">
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Receipt No</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Receipt Date</th>
                            <th>Operator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($receipt as $abc)
                        <tr>
                            <td>{{ $abc->receiptnumber }}</td>
                            <td>{{ $abc->tenantcompanyname}} {{ $abc->tenantfullname}}</td>
                            <td>{{ number_format($abc->amountpaid, 2, '.', ',') }}</td>
                            <td>{{ Carbon\Carbon::parse($abc->datestamp)->format('F j, Y') ?? ''}}</td>
                            <td>{{ $abc->operatorid }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Content End-->
    @endsection
    @section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/validation/intakepropman.js') }}"></script>
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script>
    <!-- Additional JS End-->
    @endsection