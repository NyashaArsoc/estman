@php
$title = 'Edit Property';
$description = 'edit property...';
$id= Crypt::encrypt($property->id);
$mandate= Crypt::encrypt($property->mandate);
$otherattachement= Crypt::encrypt($property->otherattachement);
$attachementrequiredpdf = (!is_null($property->mandate)) ? 'download file' : '';
$attachementnotrequired = (!is_null($property->otherattachement)) ? 'download file' : '';
$requiredpdf    = (!is_null($property->mandate)) ? route('propapp.dwnmandpdf',[$mandate]) : '';
$notrequiredpdf = (!is_null($property->otherattachement)) ? route('propapp.dwnothrpdf',[$otherattachement]) : '';
$divindividualclass = $property->propertytypeid == 1 ? 'hide': 'dropdwn';
$divcompanyclass = $property->propertytypeid != 1 ? 'hide': 'dropdwn';
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
            <li class="breadcrumb-item"><a href="{{ route('propdec.listpropdec') }}">List</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="defaultform" method="POST"
            action="{{ route('propdec.propupd',$id) }}" enctype="multipart/form-data"> @csrf
                <div class="form-group row">
                    <label for="LandlordType" class="col-sm-2 form-control-label">Client Type </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="clienttype"
                            id="clienttype" onChange="getpropmanlandlordlist();" />
                            <option value="{{ $property->clienttypeid }}">{{ $property->clienttype }}</option>
                        @foreach ($type as $abc)
                            <option value="{{ $abc->id }}"> {{ $abc->description }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Landlord Name </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="landlordname" id="landlordlist" />
                        <option value="{{ $property->landlordid }}">{{ $property->companyname }}
                            {{ $property->fullname }} </option>
                        <option value=""> </option>
                        </select>
                    </div>
                    <small id="landlordlistcheck" style="color: red;">required</small>
                </div><br />
                <div class="form-group row">
                    <label for="Province" class="col-sm-2 form-control-label">Province </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="province" id="province">
                            <option value="{{ $property->provinceid }}">{{ $property->province }}</option>
                        @foreach ($province as $abc)
                            <option value="{{ $abc->id }}"> {{ $abc->description }}
                            </option>
                        @endforeach
                        </select>
                        <small id="provincecheck" style="color: red;">required</small>
                    </div>
                    <label for="City" class="col-sm-2 col-form-label">City/Town </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="city" name="city" 
                        value="{{ $property->city ?? ''}}">
                        <small id="citycheck" style="color: red;">required</small>
                    </div>
                </div><br />
                <div class="form-group row">
                    <label for="PropertyType" class="col-sm-2 form-control-label">Property Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="propertytype" id="propertytype"
                            onchange="optionpropertytype(this)" />
                            <option value="{{ $property->propertytypeid }}">{{ $property->propertytype }}</option>
                        @foreach ($proptype as $abc)
                            <option value="{{ $abc->id }}"> {{ $abc->description }}</option>
                        @endforeach
                        </select>
                        <small id="propertytypecheck" style="color: red;">required</small>
                    </div>
                    <label for="LocationSurburb" class="col-sm-2 col-form-label">Location/Surburb </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="requiredgeneraltextcaps" name="locationsurburb"
                        value="{{ $property->location ?? ''}}">
                        <small id="requiredgeneraltextcapscheck" style="color: red;"> required</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="PropertyStreetAddress" class="col-sm-2 col-form-label">Street Address</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="billingaddress" name="billingaddress"
                        value="{{ $property->streetaddress ?? ''}}">
                        <small id="billingaddresscheck" style="color: red;">required</small> 
                    </div>
                </div>
                <div class="form-group row">
                    <label for="StandNumber" class="col-sm-2 col-form-label">Stand Number</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="standnumber" name="standnumber"
                        value="{{ $property->standnumber ?? ''}}">
                        <small id="standnumbercheck" style="color: red;"></small> 
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Highlights" class="col-sm-2 col-form-label">Comments/Highlights</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="commentshighlights" name="commentshighlights"
                        value="{{ $property->comments ?? ''}}">
                        <small id="commentshighlightscheck" style="color: red;"></small> 
                    </div>
                </div>
                <br /><h5>additional information </h5>
                <div id="residential" class="{{$divindividualclass}}">
                    
                    <div class="form-group row">
                        <label for="Rooms" class="col-sm-2 col-form-label">Rooms</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="rooms" name="rooms" 
                            value="{{ $property->rooms ?? ''}}">
                            <small id="roomscheck" style="color: red;"> required</small>
                        </div>
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Bedrooms</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="bedrooms" name="bedrooms" 
                            value="{{ $property->bedrooms ?? ''}}">
                            <small id="bedroomscheck" style="color: red;">required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Bathrooms" class="col-sm-2 col-form-label">Bathrooms</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="numericrequired" name="bathrooms"
                            value="{{ $property->bathrooms ?? ''}}">
                            <small id="numericrequiredcheck" style="color: red;">required</small>
                        </div>
                        <label for="Stories" class="col-sm-2 col-form-label">Stories</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="numericnotrequired" name="stories" 
                            value="{{ $property->stories ?? ''}}">
                            <small id="numericnotrequiredcheck" style="color: red;"></small>
                        </div>
                    </div>
                </div>
                <div id="commercial" class="{{$divcompanyclass}}">
                    <div class="form-group row">
                        <label for="TotalArea" class="col-sm-2 col-form-label">Total Area (Sqm)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="totalarea" name="totalarea"
                            value="{{ $property->totalarea ?? ''}}">
                            <small id="totalareacheck" style="color: red;">required</small>
                        </div>
                        <label for="Stories" class="col-sm-2 col-form-label">Lettable Area (Sqm)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="lettablearea" name="lettablearea"
                            value="{{ $property->lettablearea ?? ''}}">
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
                    <div id="commercialbottom" class="{{$divcompanyclass}}">
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Expected Rate/sqm</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="expectedrate" name="expectedrate"
                            value="{{ $property->ratesqm ?? ''}}">
                            <small id="expectedratecheck" style="color: red;">required</small>
                        </div>
                    </div>
                    <div id="residentialbottom" class="{{$divindividualclass}}">
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Expected Rental</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="expectedrental" name="expectedrental"
                            value="{{ $property->expectedrental ?? ''}}">
                            <small id="expectedrentalcheck" style="color: red;">required</small>
                        </div>
                    </div>
                </div><br />
                <h5>commissions</h5>
                <div class="form-group row">
                    <label for="CommissionType" class="col-sm-2 form-control-label">Commission Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="commissiontype" id="commissiontype" />
                        <option value="{{ $property->commissiontypeid }}">{{ $property->commissiontype }}</option>
                        @foreach ($commtype as $abc)
                            <option value="{{ $abc->id }}"> {{ $abc->description }}
                            </option>
                        @endforeach
                        </select>
                        <small id="commissiontypecheck" style="color: red;">required</small>
                    </div>
                    <label for="CommissionPercentage" class="col-sm-2 col-form-label">Commission (%) </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="commissionpercentage" name="commissionpercentage"
                        value="{{ $property->commission ?? ''}}">
                        <small id="commissionpercentcheck" style="color: red;">required</small>
                    </div>
                </div>
                 <h5>attachments </h5>
                 <div class="form-group row">
                    <label for="Mandate" class="col-sm-2 col-form-label">Mandate</label>
                    <div class="col-sm-4">
                        <a href="{{ $requiredpdf }}">{{ $attachementrequiredpdf}}</a>
                    </div>
                    <label for="Mandate" class="col-sm-2 col-form-label">Other</label>
                    <div class="col-sm-4">
                        <a href="{{ $notrequiredpdf }}">{{ $attachementnotrequired}}</a>
                    </div>
                 </div>
                <div class="form-group row">
                    <label for="Mandate" class="col-sm-2 col-form-label">Signed Mandate</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" id="requiredsignedpdf" name="mandate"
                        accept=".pdf">
                        <small id="requiredsignedpdfcheck" style="color: red;">required</small>
                    </div>
                    <label for="OtherAttachment" class="col-sm-2 col-form-label">Other attachment</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" id="notrequiredpdf" name="otherattachment"
                        accept=".pdf" />
                        <small id="notrequiredpdfcheck" style="color: red;"></small>
                    </div>
                </div> 
                <div class="form-group row">
                    @if (in_array(1,$arraycontrolids))
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-add-property" >submit</button>
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
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    <!-- Additional JS End-->
@endsection
