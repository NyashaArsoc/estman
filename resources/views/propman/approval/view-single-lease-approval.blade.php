@php
    $title = 'Approve Lease';
    $description = 'approve lease...';
 if ($lease->propertytypeid == 1){
    $divindividualclass      =   'dropdwn';
 }else{
    $divclasscompany   =   'dropdwn';
 }
 $id= Crypt::encrypt($lease->id);
 $agreement= Crypt::encrypt($lease->agreement);
 $requiredpdf    = (!is_null($lease->agreement)) ? route('propapp.dwnagrepdf',[$agreement]) : '';
 $attachementrequiredpdf = (!is_null($lease->agreement)) ? 'download file' : '';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Approve Lease')
@section('additional css')
    <!-- Additional css Start-->
@endsection
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('propapp.listlea')}}">Pending</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" action="{{ route('propdec.leadec',$id) }}"
            method="PUT"> @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Operator</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $lease->operatorid }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Tenant Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $lease->tenantfullname }}
                        {{ $lease->tenantcompanyname }}" readonly>
                    </div>
                    <label for="" class="col-sm-2 form-control-label">Landlord</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $lease->landlordcontact }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="LandlordType" class="col-sm-2 form-control-label">Property Type</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $lease->propertytype }}" readonly>
                    </div> 
                    <label for="City" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $lease->streetaddress }}"
                        readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ClientType" class="col-sm-2 form-control-label">Valid From</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control"value="{{ $lease->validfrom }}" @readonly(true)>
                    </div>
                    <label for="ClientType" class="col-sm-2 form-control-label">Valid To</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $lease->validto }}" readonly>
                    </div>
                </div><br />
                <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Property Description</label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" 
                            rows="2" cols="3" @readonly(true)>{{ $lease->propertydescription ??''}}</textarea>
                        </div>
            <label for="" class="col-sm-2 col-form-label">Lease Agreement</label>
            <div class="col-sm-4">
                <a href="{{ $requiredpdf }}">{{ $attachementrequiredpdf}}</a>
            </div>
                </div><br />
        <h5>rental information </h5>
        <div class="form-group row">
            <label for="City" class="col-sm-2 col-form-label">Next Rent Review</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="{{ $lease->rentreview ??'' }}" @readonly(true)>
            </div> 
            <label for="Type" class="col-sm-2 form-control-label">Inspection Schedule</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="{{ $lease->inspectionreview }}"
                 @readonly(true)>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Rental</label>
            <div class="col-sm-4">
                <input type="text" class="form-control"
                 value="{{ $lease->currencycode ?? ''}} {{number_format($lease->rental, 2) ??''}}"
                @readonly(true)>
            </div>
            <div id="Commercial" class="{{$divclasscompany}}">
                <label for="" class="col-sm-2 col-form-label">Rate/sqm</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" value="{{ $lease->ratesqm }}" readonly>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div id="CommercialBottom" class="{{$divclasscompany}}">
                <label for="AreaTaken" class="col-sm-2 col-form-label">Area Taken(Sqm)</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" value="{{ $lease->areataken ?? ''}}"
                    name= "AreaTaken"   readonly>
                </div>
            </div>
        </div>
        <h5>Additional Details  </h5>
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="rates-info-tab" data-toggle="tab" href="#rates-info" role="tab" aria-controls="rates-info" aria-selected="true">Rates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="prepay-info-tab" data-toggle="tab" href="#prepay-info" role="tab" aria-controls="prepay-info" aria-selected="true">Prepayments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="arrear-info-tab" data-toggle="tab" href="#arrear-info" role="tab" aria-controls="arrear-info" aria-selected="true">Arrears</a>
            </li>
        </ul>
       <!-- Tabs Content -->
       <div class="tab-content" id="clientTabContent">
        <!--start-->
        <div class="tab-pane show active" id="rates-info" role="tabpanel" aria-labelledby="rates-info-tab"><hr/>
            <div class="table-responsive" style="margin-top: 15px;">
                <table class="table table-bordered table-hover" id="leaseitems">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Curreny</th>
                            <th class="text-center">Rates/Utilities</th>
                            <th class="text-center">Operation Cost</th>
                            <th class="text-center">Deposit Paid</th>
                            <th class="text-center">Admin Fees</th> 
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($rates as $abc)
                        <tr>
                            <td>{{$count ++}}</td>
                            <td>{{ $abc->currencycode }}</td>
                            <td>{{ number_format($abc->ratescosts,2) }}</td>
                            <td>{{ number_format($abc->operationalcosts,2) }}</td>
                            <td>{{ number_format($abc->deposit,2) }}</td>
                            <td>{{ number_format($abc->adminstrationfee,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--end-->
        <!--start-->
        <div class="tab-pane show" id="prepay-info" role="tabpanel" aria-labelledby="prepay-info-tab"><hr/>
            <div class="table-responsive" style="margin-top: 15px;">
                <table class="table table-bordered table-hover" id="leaseitems">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Curreny</th>
                            <th class="text-center">Balance</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($prepay as $abc)
                        <tr>
                            <td>{{$count ++}}</td>
                            <td>{{ $abc->currencycode }}</td>
                            <td>{{ number_format($abc->balance,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--end-->
        <!--start-->
        <div class="tab-pane show" id="arrear-info" role="tabpanel" aria-labelledby="arrear-info-tab"><hr/>
            <div class="table-responsive" style="margin-top: 15px;">
                <table class="table table-bordered table-hover" id="leaseitems">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Curreny</th>
                            <th class="text-center">Balance</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($balance as $abc)
                        <tr>
                            <td>{{$count ++}}</td>
                            <td>{{ $abc->currencycode }}</td>
                            <td>{{ number_format($abc->balrent,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--end-->
       </div>
        <div class="form-group row">
            <label for="Email" class="col-sm-2 col-form-label">Reason for decline
            </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="reasons_comments" 
                id="rejectreason" />
                <small id="rejectreasoncheck" style="color: red;"> reasons for rejection</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">@if (in_array(5,$arraycontrolids))
                <a onclick = "approveentry(this); return false;"
                class="btn btn-success btn-sm" href="{{route('propapp.leaappv', $id)}}"
                title="approve"><i class="ti-check mr-0-5"></i>approve</a>  @endif
            <button type="submit" class="btn btn-danger btn-sm" id="btn-reject-entry" 
                    onclick = "rejectapproval(this); return false;"><i class="ti-close mr-0-5">
                        </i>reject</button>
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
    <script src="{{ asset('js/validation/approvalpropman.js') }}"></script>
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
@endsection
