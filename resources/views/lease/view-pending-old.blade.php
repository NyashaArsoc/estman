@php
    $title = 'Approve Lease';
    $description = 'approve lease...';
    if ($lease->clienttypeid == 1){
    $tname   =  $lease->fullname ;
   }else{
     $tname   =  $lease->companyname ;
 } 
 if ($lease->propertytypeid == 1){
    $divclasscompany      =   'dropdwn';
 }else{
    $divclasscompany   =   'show';
 }
 $id= Crypt::encrypt($lease->id);
 $pid =Crypt::encrypt($lease->propertyid)
@endphp
@extends('layout.main-layout')
@section('title', 'Add Lease')
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
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('lease.pending')}}">Pending</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" action="{{ route('lease.reject',$id) }}"
            method="PUT"> @csrf
                <div class="form-group row">
                    <label for="LandlordType" class="col-sm-2 form-control-label">Tenant Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $tname }}" readonly>
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
                    <label for="Type" class="col-sm-2 form-control-label">Next Inspection Date</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $inspection->nextinspectiondate }}"
                         @readonly(true)>
                    </div>
                        <label for="" class="col-sm-2 col-form-label">Property Description</label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" 
                            rows="2" cols="3" @readonly(true)>{{ $lease->propertydescription ??''}}</textarea>
                        </div>
                </div><br />
        <h5>rental information </h5>
        <div class="form-group row">
            <label for="City" class="col-sm-2 col-form-label">Next Rent Review</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="{{ $review->nextreviewdate ??'' }}" @readonly(true)>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Rental</label>
            <div class="col-sm-4">
                <input type="text" class="form-control"
                 value="{{ $lease->rentalcurrency.' '.number_format($lease->rental, 2) ??''}}"
                @readonly(true)>
            </div>
            <div id="Commercial" class="{{$divclasscompany}}">
                <label for="" class="col-sm-2 col-form-label">Rate/sqm</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" value="{{ $lease->ratesqm ?? ''}}" readonly>
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
        <div class="form-group row">
            <label for="TotalArea" class="col-sm-2 col-form-label">Operation Cost</label>
            <div class="col-sm-4">
                <input type="text" class="form-control"
                value="{{ $lease->operatingcostcurrency.' '.number_format($lease->operatingcosts, 2) ?? '' }}" readonly>
            </div>
            <label for="Stories" class="col-sm-2 col-form-label">Rates/Utilities</label>
            <div class="col-sm-4">
                <input type="text" class="form-control"
                 value="{{ $lease->ratescurrency.' '.number_format($lease->rates, 2) ?? '' }}" readonly>
            </div>
        </div>
        <h5>Deposit</h5>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Deposit</label>
            <div class="col-sm-4">
                <input type="text" class="form-control"
                 value="{{ $lease->depositcurrency.' '.number_format($lease->deposit, 2) ??'' }}"
                 readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Balance b/d</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" 
                value="{{ $lease->balbdcurrency.' '.number_format($lease->balancebd, 2) ??'' }}"
                readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="Email" class="col-sm-2 col-form-label">Reason for decline
            </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="ReasonsForDecline" 
                id="ReasonsForDecline" />
                <small id="reasonscheck" style="color: red;"> reasons for rejection</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <a onclick = "approvelease(this); return false;"
                class="btn btn-success btn-sm" href="{{route('lease.approve',['id'=>$id,'pid'=>$pid])}}"
                title="approve"><i class="ti-check mr-0-5"></i>approve</a>  
            <button type="submit" class="btn btn-danger btn-sm" id="reject-lease" 
                    onclick = "rejectlease(this); return false;"><i class="ti-close mr-0-5">
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
    <script src="{{ asset('js/validation/lease.js') }}"></script>
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
@endsection
