@php
$title = 'Add Property';
$description = 'add property to the system...';
@endphp
@extends('layout.main-layout')
@section('title', 'Add Property')
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
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="add property" method="POST"
            action="{{ route('property.store') }}" > @csrf
                <div class="form-group row">
                    <label for="LandlordType" class="col-sm-2 form-control-label">Landlord Type </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="LandlordClientType"
                            id="PropertyLandlordClientType" onChange="getLandlordonProperty();" />
                        <option value="">Select Client Type</option>
                        @foreach ($type as $typ)
                            <option value="{{ $typ->id }}"> {{ $typ->description }}
                            </option>
                        @endforeach
                        </select>
                        <small id="landlordtypecheck" style="color: red;"> select landlord type </small>
                    </div>
                    <label for="City" class="col-sm-2 col-form-label">Landlord Name </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="LandlordName" id="PropertyLandlordName" />
                        <option value="">Select Landlord Name</option>
                        <option value=""> </option>
                        </select>
                    </div>
                    <small id="landlordnamecheck" style="color: red;"> select landlord name </small>
                </div><br />
                <div class="form-group row">
                    <label for="Province" class="col-sm-2 form-control-label">Province </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="Province" id="Province"
                            onchange="PropertyProvince(this)" />
                        <option value="">Select Province </option>
                        @foreach ($province as $pro)
                            <option value="{{ $pro->id }}"> {{ $pro->description }}
                            </option>
                        @endforeach
                        </select>
                        <small id="provincecheck" style="color: red;"> province is required</small>
                    </div>
                    <label for="City" class="col-sm-2 col-form-label">City/Town </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="City" name="City" placeholder="City"
                            autocomplete="off">
                        <small id="citycheck" style="color: red;"> city is required</small>
                    </div>
                </div><br />
                <div class="form-group row">
                    <label for="PropertyType" class="col-sm-2 form-control-label">Property Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="PropertyType" id="PropertyType"
                            onchange="AddPropertyType(this)" />
                        <option value="">Select Property Type </option>
                        @foreach ($propertytype as $prop)
                            <option value="{{ $prop->id }}"> {{ $prop->description }}
                            </option>
                        @endforeach
                        </select>
                        <small id="propertytypecheck" style="color: red;"> property type is required</small>
                    </div>
                    <label for="LocationSurburb" class="col-sm-2 col-form-label">Location/Surburb </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="LocationSurburb" name="LocationSurburb"
                            placeholder="Location Surburb" autocomplete="off">
                        <small id="locationcheck" style="color: red;"> location is required</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="PropertyStreetAddress" class="col-sm-2 col-form-label">Street Address</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" name="PropertyAddress" rows="2" cols="3" id="PropertyAddress"></textarea>
                        <small id="propertyaddresscheck" style="color: red;"> address is required</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="StandNumber" class="col-sm-2 col-form-label">Stand Number</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" name="StandNumber" rows="2" cols="3" id="StandNumber"></textarea>

                    </div>
                </div>
                <div class="form-group row">
                    <label for="Highlights" class="col-sm-2 col-form-label">Comments/Highlights</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" name="Highlights" rows="2" cols="3" id="Highlights"></textarea>
                    </div>
                </div>
                <br /><h5>additional information </h5>
                <div id="Residential" class="dropdwn">
                    
                    <div class="form-group row">
                        <label for="Rooms" class="col-sm-2 col-form-label">Rooms</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="AddRooms" name="Rooms" placeholder="13"
                                autocomplete="off">
                            <small id="addroomscheck" style="color: red;"> rooms is required</small>
                        </div>
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Bedrooms</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="AddBedrooms" name="Bedrooms" placeholder="8"
                                autocomplete="off">
                            <small id="addbedroomscheck" style="color: red;"> bedrooms is required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Bathrooms" class="col-sm-2 col-form-label">Bathrooms</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="AddBathrooms" name="Bathrooms"
                                placeholder="3" autocomplete="off">
                            <small id="addbathroomscheck" style="color: red;"> bathrooms is required</small>
                        </div>
                        <label for="Stories" class="col-sm-2 col-form-label">Stories</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="AddStories" name="Stories" placeholder="4"
                                autocomplete="off">
                        </div>
                    </div>
                </div>
                <div id="Commercial" class="dropdwn">
                    <div class="form-group row">
                        <label for="TotalArea" class="col-sm-2 col-form-label">Total Area (Sqm)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="AddTotalArea" name="TotalArea"
                                placeholder="4000" autocomplete="off">
                            <small id="addtotalareacheck" style="color: red;"> total area is required</small>
                        </div>
                        <label for="Stories" class="col-sm-2 col-form-label">Lettable Area (Sqm)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="AddLettableArea" name="LettableArea"
                                placeholder="3800" autocomplete="off">
                            <small id="addlettableareacheck" style="color: red;"> lettable area is required</small>
                        </div>
                    </div>
                </div>
                <br />
                <h5>rental information </h5>
                <div class="form-group row">
                    <label for="Bedrooms" class="col-sm-2 col-form-label">Currency</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="Currency" id="Currency" />
                        <option value="">Select Currency </option>
                        @foreach ($currency as $cur)
                            <option value="{{ $cur->id }}"> {{ $cur->code }}
                            </option>
                        @endforeach
                        </select>
                        <small id="addcurrencycheck" style="color: red;"> rental currency is required</small>
                    </div>
                    <div id="CommercialBottom" class="dropdwn">
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Expected Rate/sqm</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="AddExpectedRate" name="ExpectedRate"
                                placeholder="8" autocomplete="off">
                            <small id="addexpectedratecheck" style="color: red;"> rate/sqm is required</small>
                        </div>
                    </div>
                    <div id="ResidentialBottom" class="dropdwn">
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Expected Rental</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="AddExpectedRental" name="ExpectedRental"
                                placeholder="8" autocomplete="off">
                            <small id="addexpectedrentalcheck" style="color: red;"> expected rental is required</small>
                        </div>
                    </div>
                </div><br />
                <h5>commissions</h5>
                <div class="form-group row">
                    <label for="CommissionType" class="col-sm-2 form-control-label">Commission Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="CommissionType" id="CommissionType" />
                        <option value="">Select Commission Type </option>
                        @foreach ($commission as $com)
                            <option value="{{ $com->id }}"> {{ $com->description }}
                            </option>
                        @endforeach
                        </select>
                        <small id="commissiontypecheck" style="color: red;"> commission type is required</small>
                    </div>
                    <label for="CommissionPercentage" class="col-sm-2 col-form-label">Commission (%) </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="CommissionPercentage" name="CommissionPercentage"
                            placeholder="20" autocomplete="off">
                        <small id="commissionpercentcheck" style="color: red;"> % of commission is required</small>
                    </div>
                </div>
                <h5>attachments </h5>
                <div class="form-group row">
                    <label for="Mandate" class="col-sm-2 col-form-label">Signed Mandate</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" id="Mandate" name="Mandate">
                    </div>
                    <label for="OtherAttachment" class="col-sm-2 col-form-label">Other attachment</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" id="OtherAttachment" name="OtherAttachment" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-submit-add" value="{{ $title }}">
                            {{ $title }}</button>

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
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    <!-- Additional JS End-->
@endsection
