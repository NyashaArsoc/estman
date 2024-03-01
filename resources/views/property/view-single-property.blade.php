@php
$title = 'Property';
$description = 'property details...'; 
$id= Crypt::encrypt($property->id);
if ($property->landlordclienttype == 1){
    $owner   =  $property->fullname ;
   }else{
     $owner   =  $property->companyname ;
 } 
 if ($property->propertytypeid == 1){
    $divclasscompany      =   'dropdwn';
    $divclassindividual   =   'show';
 }else{
    $divclasscompany   =   'show';
    $divclassindividual   =   'dropdwn';
 }
@endphp
@extends('layout.view-btn-menu-layout')
@section('title', 'View Property')

@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('property.list')}}">List</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="add property" 
            action="" >
                <div class="form-group row">
                    <label for="City" class="col-sm-2 col-form-label">Landlord Name </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $owner }}" readonly>
                    </div>
                </div><br />
                <div class="form-group row">
                    <label for="Province" class="col-sm-2 form-control-label">Province </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $property->province }}" readonly>
                    </div>
                    <label for="City" class="col-sm-2 col-form-label">City/Town </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $property->city }}" readonly>
                    </div>
                </div><br />
                <div class="form-group row">
                    <label for="PropertyType" class="col-sm-2 form-control-label">Property Type</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $property->propertytype }}" readonly>
                    </div>
                    <label for="LocationSurburb" class="col-sm-2 col-form-label">Location/Surburb </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $property->location }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="PropertyStreetAddress" class="col-sm-2 col-form-label">Street Address</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" rows="2" cols="3" 
                        readonly>{{ $property->streetaddress }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="StandNumber" class="col-sm-2 col-form-label">Stand Number</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" rows="2" cols="3" 
                        readonly>{{ $property->standnumber }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Highlights" class="col-sm-2 col-form-label">Comments/Highlights</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" rows="2" cols="3" 
                        readonly>{{ $property->comments }}</textarea>
                    </div>
                </div>
                <br /><h5>additional information </h5>
                <div id="Residential" class="{{$divclassindividual}}">
                    <div class="form-group row">
                        <label for="Rooms" class="col-sm-2 col-form-label">Rooms</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $property->rooms ?? ''}}"
                             readonly/>
                        </div>
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Bedrooms</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $property->bedrooms ?? ''}}"
                             readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Bathrooms" class="col-sm-2 col-form-label">Bathrooms</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $property->bathrooms ?? ''}}"
                                readonly />
                        </div>
                        <label for="Stories" class="col-sm-2 col-form-label">Stories</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $property->stories ?? ''}}"
                             readonly />
                        </div>
                    </div>
                </div>
                <div id="Commercial" class="{{$divclasscompany}}">
                    <div class="form-group row">
                        <label for="TotalArea" class="col-sm-2 col-form-label">Total Area (Sqm)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $property->totalarea ?? ''}}"
                               readonly />
                        </div>
                        <label for="Stories" class="col-sm-2 col-form-label">Lettable Area (Sqm)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  value="{{ $property->lettablearea ?? ''}}"
                                readonly>
                        </div>
                    </div>
                </div>
                <br />
                <h5>rental information </h5>
                <div class="form-group row">
                    <label for="Bedrooms" class="col-sm-2 col-form-label">Currency</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $property->code ?? ''}}"
                         readonly>
                    </div>
                    <div id="CommercialBottom" class="{{$divclasscompany}}">
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Expected Rate/sqm</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control"  value="{{ $property->ratesqm ?? ''}}"
                                readonly>
                        </div>
                    </div>
                    <div id="ResidentialBottom" class="{{$divclassindividual}}">
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Expected Rental</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="{{ $property->expectedrental ?? ''}}"
                               readonly>
                        </div>
                    </div>
                </div><br />
                <h5>commissions</h5>
                <div class="form-group row">
                    <label for="CommissionType" class="col-sm-2 form-control-label">Commission TyOn</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $property->commissionon ?? ''}}"
                        readonly>
                    </div>
                    <label for="CommissionPercentage" class="col-sm-2 col-form-label">Commission (%) </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control"  value="{{ $property->commissionpercentage ?? ''}}"
                        readonly >
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
