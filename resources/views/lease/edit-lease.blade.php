@php
    $title = 'Edit Lease';
    $description = 'update lease...';
$id= Crypt::encrypt($lease->id);
if ($lease->clienttypeid == 1){//individual
      $lname   =  $lease->fullname ;
  }else{
  $lname   =  $lease->companyname ;
  }
  if ($lease->propertytypeid == 1){ //residential
    $divclasscompany      =   'dropdwn';
    $divclassresidential   =   'show';
 }else{ $divclasscompany   =   'show';
    $divclassresidential   =   'dropdwn';
 }
@endphp
@extends('layout.main-layout')
@section('title', 'Edit Lease')
@section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
    <script src="{{ asset('js/dropdown-get-data.js') }}"></script>
@endsection
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('lease.rejected')}}">Rejected</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" action="{{ route('lease.editupdate', $id) }}"
            method="PUT"> @csrf
                <div class="form-group row">
                    <label for="LandlordType" class="col-sm-2 form-control-label">Tenant Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="TenantClientType" id="LeaseTenantClientType"
                            onChange="getTenantonLease();" />
                        <option value="{{ $lease->clienttypeid }}">{{ $lease->clienttype }}</option>
                        @foreach ($type as $typ)
                            <option value="{{ $typ->id }}"> {{ $typ->description }}
                            </option>
                        @endforeach
                        </select>
                        <small id="tenanttypecheck" style="color: red;"> select tenant type </small>
                    </div>
                    <label for="City" class="col-sm-2 col-form-label">Tenant Name </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="TenantName" id="LeaseTenantName" />
                        <option value="{{ $lease->tenantid }}">{{ $lname}}</option>
                        <option value=""> </option>
                        </select>
                    </div>
                    <small id="tenantnamecheck" style="color: red;"> select tenant name </small>
                </div><br />
                <div class="form-group row">
                    <label for="LandlordType" class="col-sm-2 form-control-label">Property Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="PropertyType" 
                        id="LeasePropertyType" onchange="getPropertyonLease();" 
                        />
                        <option value="{{ $lease->propertytypeid }}">{{ $lease->propertytype }}</option>
                        @foreach ($propertytype as $prop)
                            <option value="{{ $prop->id }}"> {{ $prop->description }} </option>
                        @endforeach
                        </select>
                        <small id="propertytypecheck" style="color: red;"> select property type </small>
                    </div> 
                    <label for="City" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="PropertyAddress"
                         id="LeasePropertyAddress" onchange="getPropertyBalances();"/>
                        <option value="{{ $lease->propertyid }}">{{ $lease->streetaddress }}</option>
                        <option value=""> </option>
                        </select>
                    </div>
                    <small id="propertyaddresscheck" style="color: red;"> select property address</small>
                </div><br />
                <div class="form-group row">
                    <label for="ClientType" class="col-sm-2 form-control-label">Valid From</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="LeaseValidFrom" 
                        value="{{ $lease->validfrom }}" name="LeaseValidFrom">
                        <small id="validfromcheck" style="color: red;"> date is required</small>
                    </div>
                    <label for="ClientType" class="col-sm-2 form-control-label">Valid To</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="LeaseValidTo" 
                        value="{{ $lease->validto }}" name="LeaseValidTo">
                        <small id="validtocheck" style="color: red;"> date is required</small>
                    </div>
                </div><br />
                <div class="form-group row">
                    <label for="Type" class="col-sm-2 form-control-label">Inspection Period</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="InspectionPeriod" id="LeaseInspectionPeriod"
                         />
                        <option value="{{ $lease->inspectionperiod ?? '' }}">{{ $lease->inspectionperiod }}</option>
                        @foreach ($period as $p)
                        <option value="{{ $p->description }}"> {{ $p->description }} </option>
                    @endforeach
                        </select>
                        <small id="inspectionscheck" style="color: red;"> select inspection schedule </small>
                    </div>
                        <label for="" class="col-sm-2 col-form-label">Property Description</label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" name="PropertyDescription"
                             rows="2" cols="3" id="PropertyDescription">{{ $lease->propertydescription ?? ''}}</textarea>
                            <small id="propertydescriptioncheck" style="color: red;"> description is required</small>
                        </div>
                </div><br />
  
        <br />
        <h5>rental information </h5>
        <div class="form-group row">
            <label for="City" class="col-sm-2 col-form-label">Rent Review Period</label>
            <div class="col-sm-4">
                <select class="js-example-basic-single w-100" name="RentReviewPeriod"
                    id="LeaseRentReviewPeriod" />
                <option value="{{ $lease->rentreviewperiod ??'' }}">{{ $lease->rentreviewperiod ??'' }}</option>
                @foreach ($period as $p)
                <option value="{{ $p->description }}"> {{ $p->description }} </option>
            @endforeach
                </select>
                <small id="rentreviewcheck" style="color: red;"> select review schedule </small>
            </div>
            <div class="col-sm-2">
              
            </div>
        </div><br />
        <div class="form-group row">
            <label for="Bedrooms" class="col-sm-2 col-form-label">Currency</label>
            <div class="col-sm-4">
                <select class="js-example-basic-single w-100" name="RentCurrency" id="RentCurrency" />
                <option value="{{ $lease->rentalcurrencyid ??'' }}">{{ $lease->rentalcurrency ??'' }}</option>
                @foreach ($currency as $cur)
                <option value="{{ $cur->id }}"> {{ $cur->code }}
                </option>
            @endforeach
                </select>
                <small id="rentalcurrencycheck" style="color: red;"> rental currency is required</small>
            </div>
            <div id="Commercial" class="{{$divclasscompany}}">
                <label for="Bedrooms" class="col-sm-2 col-form-label">Rate/sqm</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="RateSqm" name="RateSqm"
                    value="{{ $lease->ratesqm }}" >
                    <small id="ratesqmcheck" style="color: red;"> rate/sqm is required</small>
                </div>
            </div>
            <div id="Residential" class="{{$divclassresidential}}">
                <label for="Bedrooms" class="col-sm-2 col-form-label">Expected Rental</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="ExpectedRental" name="ExpectedRental"
                   value="{{ number_format($lease->rental,2) }}" >
                    <small id="expectedrentalcheck" style="color: red;">rental is required</small>
                </div>
            </div>
        </div><br/>
        <div class="form-group row">
            <div id="CommercialBottom" class="dropdwn">
                <label for="AreaTaken" class="col-sm-2 col-form-label">Area Taken(Sqm)</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="AreaTaken" name="AreaTaken" 
                    value="{{ $lease->areataken }}">
                    <small id="areatakencheck" style="color: red;">area taken is required</small>
                </div>
                <label for="Stories" class="col-sm-2 col-form-label">Occupied Area (Sqm)</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="OccupiedArea" name="OccupiedArea" readonly/>
                    <input type="text" class="form-control" id="AvailableLettableArea" 
                    name="AvailableLettableArea" readonly hidden>
                </div>
            </div>
        </div><br/>
        <div class="form-group row">
            <label for="TotalArea" class="col-sm-2 col-form-label">Operation Cost</label>
            <div class="col-sm-2">
                <select class="js-example-basic-single w-100" name="OperationCurrency" id="OperationCurrency" />
                <option value="{{ $lease->operatingcostcurrencyid ??'' }}">{{ $lease->operatingcostcurrency ??'' }} </option>
                @foreach ($currency as $cur)
                <option value="{{ $cur->id }}"> {{ $cur->code }}
                </option>
            @endforeach
                </select>
                <small id="operationcurrencycheck" style="color: red;">currency is required</small>
            </div>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="OperationalCost" name="OperationalCost"
                value="{{ number_format($lease->operatingcosts,2) ??''}}">
                <small id="operationalcostcheck" style="color: red;">operational cost required</small>
            </div>
            <label for="Stories" class="col-sm-2 col-form-label">Rates/Utilities</label>
            <div class="col-sm-2">
                <select class="js-example-basic-single w-100" name="RatesCurrency" id="RatesCurrency" />
                <option value="{{ $lease->ratescurrencyid ??'' }}">{{ $lease->ratescurrency ??'' }} </option>
                @foreach ($currency as $cur)
                <option value="{{ $cur->id }}"> {{ $cur->code }}
                </option>
            @endforeach
                </select>
                <small id="ratescurrencycheck" style="color: red;">currency is required</small>
            </div>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="RatesCost" name="RatesCost" 
                value="{{ number_format($lease->rates,2) ??'' }}">
                <small id="ratescostcheck" style="color: red;">amount is required</small>
            </div>
        </div>
        <h5>Deposit</h5>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Currency</label>
            <div class="col-sm-4">
                <select class="js-example-basic-single w-100" name="DepositCurrency" id="DepositCurrency" />
                <option value="{{ $lease->depositcurrencyid ??'' }}">{{ $lease->depositcurrency ??'' }} </option>
                @foreach ($currency as $cur)
                <option value="{{ $cur->id }}"> {{ $cur->code }}
                </option>
            @endforeach
                </select>
                <small id="depositcurrencycheck" style="color: red;"> deposit currency is required</small>
            </div>
            <label for="" class="col-sm-2 col-form-label">Deposit Paid</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="DepositPaid" name="DepositPaid" 
                value="{{ number_format($lease->deposit,2) ??'' }}">
                <small id="depositpaidcheck" style="color: red;">deposit paid is required</small>
            </div>
        </div><br />
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Balance b/d Currency</label>
            <div class="col-sm-4">
                <select class="js-example-basic-single w-100" name="BalanceBDCurrency" id="BalanceBDCurrency" />
                <option value="{{ $lease->balancebdcurrencyid ??'' }}">{{ $lease->balbdcurrency ??'' }} </option>
                @foreach ($currency as $cur)
                            <option value="{{ $cur->id }}"> {{ $cur->code }}
                            </option>
                        @endforeach
                </select>
                <small id="bdcurrencycheck" style="color: red;"> balance bd currency is required</small>
            </div>
            <label for="" class="col-sm-2 col-form-label">Balance b/d </label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="BDamount" name="BDamount" 
                value="{{ number_format($lease->balancebd,2) ??'' }}">
                <small id="bdamountcheck" style="color: red;"> balance bd is required</small>
            </div>
        </div><br />
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-edit-lease" value="{{ $title }}">
                    {{ $title }}</button>
            </div>
        </div>
        </form>
        @include('layout.arlet')
    </div>
    </div>
    <!-- Content End-->
@endsection
@section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/validation/lease.js') }}"></script>
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    <!-- Additional JS End-->
@endsection
