@php
$title = 'Edit Property';
$description = 'update property details...';
$id= Crypt::encrypt($property->id);

if ($property->propertytypeid == 1){
$divclasscompany = 'dropdwn';
$divclassresidential = 'show';
}else{ $divclasscompany = 'show';
$divclassresidential = 'dropdwn';
}
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Edit Property')
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
        <li class="breadcrumb-item"><a href="{{route('propma.landproplist')}}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <form class="form-material material-primary" id="defaultform" method="PUT"
            action="{{ route('propma.updatprop',$id) }}"> @csrf
            <div class="form-group row">
                <label for="City" class="col-sm-2 col-form-label">Landlord Name </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" readonly
                        value="{{ $property->fullname ?? ''}}  {{ $property->companyname ?? ''}}">
                </div>
            </div><br />
            <div class="form-group row">
                <label for="Province" class="col-sm-2 form-control-label">Province </label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="province" id="province" />
                    <option value="{{ $property->provinceid }}">{{ $property->province }}</option>
                    @foreach ($province as $abc)
                    <option value="{{ $abc->id }}"> {{ $abc->description }} </option>
                    @endforeach
                    </select>
                    <small id="provincecheck" style="color: red;">required</small>
                </div>
                <label for="City" class="col-sm-2 col-form-label">City/Town </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="city" name="city"
                        value="{{ $property->city ?? ''}}" autocomplete="off">
                    <small id="citycheck" style="color: red;">required</small>
                </div>
            </div><br />
            <div class="form-group row">
                <label for="PropertyType" class="col-sm-2 form-control-label">Property Type</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" readonly id="propertytype"
                        value="{{ $property->propertytype }}">
                </div>
                <label for="LocationSurburb" class="col-sm-2 col-form-label">Location/Surburb </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="requiredgeneraltextcaps" name="locationsurburb"
                        value="{{ $property->location ?? ''}}" autocomplete="off">
                    <small id="requiredgeneraltextcapscheck" style="color: red;"> required</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="PropertyStreetAddress" class="col-sm-2 col-form-label">Street Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="billingaddress" name="billingaddress"
                        value="{{ $property->streetaddress ?? ''}}">
                    <small id="billingaddresscheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="StandNumber" class="col-sm-2 col-form-label">Stand Number</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="standnumber" name="standnumber"
                        value="{{ $property->standnumber ?? ''}}">
                    <small id="standnumbercheck" style="color: red;"></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="Highlights" class="col-sm-2 col-form-label">Comments/Highlights</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="commentshighlights"
                        value="{{ $property->comments ?? ''}}" name="commentshighlights">
                    <small id="commentshighlightscheck" style="color: red;"></small>
                </div>
            </div>
            <br />
            <h5>additional information </h5>
            <div id="Residential" class="{{$divclassresidential}}">

                <div class="form-group row">
                    <label for="Rooms" class="col-sm-2 col-form-label">Rooms</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="rooms" name="rooms"
                            value="{{ $property->rooms ?? ''}}" autocomplete="off">
                        <small id="roomscheck" style="color: red;"> required</small>
                    </div>
                    <label for="Bedrooms" class="col-sm-2 col-form-label">Bedrooms</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="bedrooms" name="bedrooms"
                            value="{{ $property->bedrooms ?? ''}}" autocomplete="off">
                        <small id="bedroomscheck" style="color: red;">required</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Bathrooms" class="col-sm-2 col-form-label">Bathrooms</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="numericrequired" name="bathrooms"
                            value="{{ $property->bathrooms ?? ''}}" autocomplete="off">
                        <small id="numericrequiredcheck" style="color: red;">required</small>
                    </div>
                    <label for="Stories" class="col-sm-2 col-form-label">Stories</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="numericnotrequired" name="stories"
                            value="{{ $property->stories ?? ''}}"
                            autocomplete="off">
                        <small id="numericnotrequiredcheck" style="color: red;"></small>
                    </div>
                </div>
            </div>
            <div id="Commercial" class="{{$divclasscompany}}">
                <div class="form-group row">
                    <label for="TotalArea" class="col-sm-2 col-form-label">Total Area (Sqm)</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="totalarea" name="totalarea"
                            value="{{ $property->totalarea ?? ''}}" autocomplete="off">
                        <small id="totalareacheck" style="color: red;">required</small>
                    </div>
                    <label for="Stories" class="col-sm-2 col-form-label">Lettable Area (Sqm)</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="lettablearea" name="lettablearea"
                            value="{{ $property->lettablearea ?? ''}}" autocomplete="off">
                        <small id="lettableareacheck" style="color: red;">required</small>
                    </div>
                </div>
            </div>
            <br />
            <h5>rental information </h5>
            <div class="form-group row">
                <label for="Bedrooms" class="col-sm-2 col-form-label">Currency</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="currencycode" id="currencycode" />
                    <option value="{{ $property->currencycode }}">{{ $property->currencycode }}</option>
                    @foreach ($currency as $abc)
                    <option value="{{ $abc->code }}"> {{ $abc->code }}
                    </option>
                    @endforeach
                    </select>
                    <small id="currencycodecheck" style="color: red;">required</small>
                </div>
                <div id="CommercialBottom" class="{{$divclasscompany}}">
                    <label for="Bedrooms" class="col-sm-2 col-form-label">Expected Rate/sqm</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="expectedrate" name="expectedrate"
                            value="{{ $property->ratesqm ?? ''}}" autocomplete="off">
                        <small id="expectedratecheck" style="color: red;">required</small>
                    </div>
                </div>
                <div id="ResidentialBottom" class="{{$divclassresidential}}">
                    <label for="Bedrooms" class="col-sm-2 col-form-label">Expected Rental</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="expectedrental" name="expectedrental"
                            value="{{ $property->expectedrental ?? ''}}" autocomplete="off">
                        <small id="expectedrentalcheck" style="color: red;">required</small>
                    </div>
                </div>
            </div><br />
            <h5>commissions</h5>
            <div class="form-group row">
                <label for="CommissionType" class="col-sm-2 form-control-label">Commission Type</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" readonly value="{{ $property->commissiontype ?? ''}} ">
                </div>
                <label for="CommissionPercentage" class="col-sm-2 col-form-label">Commission (%) </label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="commissionpercentage" name="commissionpercentage"
                        value="{{ $property->commission ?? ''}}" autocomplete="off">
                    <small id="commissionpercentcheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                @if (in_array(2,$arraycontrolids))
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-edit-property">submit</button>
                </div>
                @endif
            </div>
            @include('layout.arlet')
        </form>
    </div>
</div>
<!-- Content End-->
@endsection
@section('additional js')
<!-- Additional JS Start-->
<script src="{{ asset('js/validation/intakepropman.js') }}"></script>
<script src="{{ asset('js/validation/property.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
<!-- Additional JS End-->
@endsection