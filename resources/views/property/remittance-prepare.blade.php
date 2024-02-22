@php
$title = 'Property Remittance';
$description = 'property details...'; 
if ($property->landlordclienttype == 1){
    $owner   =  $property->fullname ;
   }else{
     $owner   =  $property->companyname ;
 }
 if ($property->commissionon == 'rental'){
    $comissioncharged   =  ($property->commissionpercentage/100) * $remit->rental;
   }else if($property->commissionon == 'rental and rates'){
    $comissioncharged   =  ($property->commissionpercentage/100) * ($remit->rental +
    $remit->rates );
   }else if($property->commissionon == 'rental and operation cost'){
    $comissioncharged   =  ($property->commissionpercentage/100) * ($remit->rental +
    $remit->operationalcost );
   }else{
    $comissioncharged   =  0;
 }
 $id= Crypt::encrypt($property->id);
 $currency= Crypt::encrypt($remit->currencycode);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Property Remit')
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('property.remit')}}">Remit List</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title.'-'.$remit->currencycode }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="add property" 
            action="{{ route('property.preremit',['id'=>$id,'currency'=>$currency]) }}" method="put" >
                <div class="form-group row">
                    <label for="Province" class="col-sm-2 form-control-label">Landlord </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $owner }}" readonly>
                    </div>
                    <label for="City" class="col-sm-2 col-form-label">Property Address </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $property->streetaddress }}" readonly>
                    </div>
                </div><div class="b-a b-a-success b-a-width-1 mb-0-5"></div>
                <div class="form-group row">
                    <label for="PropertyType" class="col-sm-2 form-control-label">Total Billed</label>
                    <div class="col-sm-4"></div>
                    <label for="" class="col-sm-2 col-form-label"> </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="BillTotalBilled"
                         value="{{ $remit->balancebf}}" readonly name="BillTotalBilled">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="PropertyType" class="col-sm-2 form-control-label">Collections</label>
                    <div class="col-sm-4"></div>
                    <label for="" class="col-sm-2 col-form-label"> </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="BillCollections" 
                        value="{{ $remit->balancebf}}" readonly name="BillCollections">
                    </div>
                </div>
                <h4>Deductions</h4>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Interest</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="BillInterest" 
                            value="{{ $remit->interest}}" readonly name="BillInterest">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Commission ({{$property->commissionpercentage.'%'}})</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="BillCommission" name="BillCommission"
                             readonly value="{{$comissioncharged}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Rates/Levies</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="BillRates" 
                            value="{{ $remit->rates}}" readonly name="BillRates">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Operational Costs</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="BillOppC" 
                            value="{{ $remit->operationalcost}}" readonly name="BillOppC">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">VAT</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="BillVAT" 
                            value="{{ $remit->vat}}" readonly name="BillVAT">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Security</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="SecurityCharge" 
                            id="SecurityCharge" autocomplete="off"/>
                            <small id="securitychargecheck" style="color: red;"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Caretaker</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="CaretakerCharge" 
                            id="CaretakerCharge" autocomplete="off" />
                            <small id="caretakerchargecheck" style="color: red;"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Other Expenses</label>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="OtherExpensesCharge" 
                            id="OtherExpensesCharge" autocomplete="off"/>
                            <small id="otherexpensecheck" style="color: red;"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Total Deductions</label>
                        <div class="col-sm-4"></div>
                        <label for="" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-2">
                            <small id="remitcalcdeductionscheck" id="totaldeductions" style="color: rgb(4, 70, 49);"> </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="TotalArea" class="col-sm-2 col-form-label">Total Remittance</label>
                        <div class="col-sm-4">
                        </div>
                        <label for="" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-2">
                            <small id="remitcalcremittancecheck" id="totalremittance" style="color: rgb(7, 86, 16);"></small>
                        </div>
                    </div>
                <br />
                <div class="form-group row">
                    <div class="col-sm-4">
                    <table><!--4th table-->
                        <tr><td><hr></td></tr>
                        <tr class="heading"><td>Banking Details</td></tr>
                        <tr class="item"><td>{{$bank->accountname }} ( {{$bank->code}})
                            <br>{{$bank->bankname }}<br>
                             {{$bank->branch}}  <br>  {{$bank->accountnumber}} </td></tr>
                        <tr><td><hr></td></tr>
                    </table><!--4th table-->
                </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-pre-remit"
                         value="Submit">submit</button>
                    </div>
                </div>
                @include('layout.arlet')
            </form>
        </div>
    </div>
    <!-- Content End-->
@endsection
@section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/validation/property.js') }}"></script>
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
@endsection
