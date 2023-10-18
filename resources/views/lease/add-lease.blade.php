@php 
$title = 'Add Lease'; 
$description = 'add new lease to the system...'; 
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
            <h4>{{$title}}</h4>
            <ol class="breadcrumb no-bg mb-1">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
            <div class="box box-block bg-white">
                <h5>{{$title}}</h5>
                <p class="font-90 text-muted mb-1"> {{$description}}</p>
                <form class="form-material material-primary" id="">
                    <div class="form-group row">
                        <label for="LandlordType" class="col-sm-2 form-control-label">Tenant Type</label>
                        <div class="col-sm-4">
                            <select class="js-example-basic-single w-100" name="TenantClientType"
                                id="LeaseTenantClientType" onChange="getTenantonLease();" />
                            <option value="">Select Client Type</option>
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
                            <option value="">Select Tenant Name</option>
                            <option value=""> </option>
                            </select>
                        </div>
                        <small id="tenantnamecheck" style="color: red;"> select tenant name </small>
                    </div><br />
                    <div class="form-group row">
                        <label for="LandlordType" class="col-sm-2 form-control-label">Property Type</label>
                        <div class="col-sm-4">
                            <select class="js-example-basic-single w-100" name="PropertyType"
                                id="LeasePropertyType" onChange="getPropertyonLease();" />
                            <option value="">Select Property Type</option>
                            @foreach ($propertytype as $prop)
                            <option value="{{ $prop->id }}"> {{ $prop->description }} </option>
                        @endforeach
                            </select>
                            <small id="propertytypecheck" style="color: red;"> select property type </small>
                        </div>
                        <label for="City" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-4">
                            <select class="js-example-basic-single w-100" name="PropertyAddress" id="LeasePropertyAddress" />
                            <option value="">Select Property Address</option>
                            <option value=""> </option>
                            </select>
                        </div>
                        <small id="propertyaddresscheck" style="color: red;"> select property address</small>
                    </div><br />
                    <div class="form-group row">
                        <label for="LandlordType" class="col-sm-2 form-control-label">Inspection Period</label>
                        <div class="col-sm-4">
                            <select class="js-example-basic-single w-100" name="InspectionPeriod"
                                id="LeaseInspectionPeriod" onChange="getLandlordonProperty();" />
                            <option value="">Inspection Schedule</option>
                                <option value=""> </option>
                            </select>
                            <small id="inspectionscheck" style="color: red;"> select inspection schedule </small>
                        </div>
                        <label for="City" class="col-sm-2 col-form-label">Maintenance Period</label>
                        <div class="col-sm-4">
                            <select class="js-example-basic-single w-100" name="MaintenancePeriod" id="LeaseMaintenancePeriod" />
                            <option value="">Maintainance Schedule</option>
                            <option value=""> </option>
                            </select>
                        </div>
                        <small id="maintenancecheck" style="color: red;"> select maintenance schedule </small>
                    </div><br />
                    <div class="form-group row"> 
                        <label for="ClientType" class="col-sm-2 form-control-label">Valid From</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="LeaseValidFrom" 
                                name="LeaseValidFrom">
                                <small id="validfromcheck" style="color: red;"> date is required</small>
                            </div> 
                            <label for="ClientType" class="col-sm-2 form-control-label">Valid To</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="LeaseValidTo" 
                                name="LeaseValidTo">
                                <small id="validtocheck" style="color: red;"> date is required</small>
                            </div> 
                    </div>
                    <div id="Residential" class="dropdwnn">
                    
                        <div class="form-group row">
                            <label for="Rooms" class="col-sm-2 col-form-label">Rooms</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="AddRooms" name="Rooms">
                            </div>
                            <label for="Bedrooms" class="col-sm-2 col-form-label">Bedrooms</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="AddBedrooms" name="Bedrooms" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Bathrooms" class="col-sm-2 col-form-label">Bathrooms</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="AddBathrooms" name="Bathrooms">
                            </div>
                            <label for="Stories" class="col-sm-2 col-form-label">Stories</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="AddStories" name="Stories">
                            </div>
                        </div>
                    </div>
                    <div id="Commercial" class="dropdwnn">
                        <div class="form-group row">
                            <label for="AreaTaken" class="col-sm-2 col-form-label">Area Taken(Sqm)</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="AreaTaken" name="AreaTaken"
                                    placeholder="400" autocomplete="off">
                                <small id="areatakencheck" style="color: red;">area taken is required</small>
                            </div>
                            <label for="Stories" class="col-sm-2 col-form-label">Available Lettable (Sqm)</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="AvailableLettableArea" name="AvailableLettableArea"
                                    placeholder="380" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <br />
                    <h5>rental information </h5>
                <div class="form-group row">
                    <label for="Bedrooms" class="col-sm-2 col-form-label">Currency</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="RentCurrency" id="RentCurrency" />
                        <option value="">Select Currency </option>
                            <option value=""> 
                            </option>
                        </select>
                        <small id="rentalcurrencycheck" style="color: red;"> rental currency is required</small>
                    </div>
                    <div id="CommercialBottom" class="dropdwnn">
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Rate/sqm</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="RateSqm" name="RateSqm"
                                placeholder="8" autocomplete="off">
                            <small id="ratesqmcheck" style="color: red;"> rate/sqm is required</small>
                        </div>
                    </div>
                    <div id="ResidentialBottom" class="dropdwnn">
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Expected Rental</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="ExpectedRental" name="ExpectedRental"
                                placeholder="8" autocomplete="off">
                            <small id="expectedrentalcheck" style="color: red;">rental is required</small>
                        </div>
                    </div>
                </div><br />
                <div class="form-group row">
                    <label for="TotalArea" class="col-sm-2 col-form-label">Operation Cost</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="OperationalCost" name="OperationalCost"
                            placeholder="4000" autocomplete="off">
                        <small id="operationalcostcheck" style="color: red;"></small>
                    </div>
                    <label for="Stories" class="col-sm-2 col-form-label">Rates</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="RatesCost" name="RatesCost"
                            placeholder="3800" autocomplete="off">
                        <small id="ratescostcheck" style="color: red;"></small>
                    </div>
                </div>
                <h5>Deposit</h5>
                <div class="form-group row">
                    <label for="Bedrooms" class="col-sm-2 col-form-label">Currency</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="DepositCurrency" id="DepositCurrency" />
                        <option value="">Select Currency </option>
                            <option value=""> 
                            </option>
                        </select>
                        <small id="depositcurrencycheck" style="color: red;"> deposit currency is required</small>
                    </div>
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Deposit Paid</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="DepositPaid" name="DepositPaid"
                                placeholder="0" autocomplete="off">
                            <small id="depositpaidcheck" style="color: red;">deposit paid</small>
                        </div>
                </div><br />
                <div class="form-group row">
                    <label for="Bedrooms" class="col-sm-2 col-form-label">Balance b/d Currency</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="BalanceBDCurrency" id="BalanceBDCurrency" />
                        <option value="">Select Currency </option>
                            <option value=""> 
                            </option>
                        </select>
                        <small id="bdcurrencycheck" style="color: red;"> balance bd currency is required</small>
                    </div>
                        <label for="Bedrooms" class="col-sm-2 col-form-label">Balance b/d </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="BDamount" name="BDamount"
                                placeholder="0" autocomplete="off">
                            <small id="bdamountcheck" style="color: red;"> balance bd is required</small>
                        </div>
                </div><br />
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-submit-lease" value="{{$title}}">
                                {{$title}}</button>

                        </div>
                    </div>
                </form>
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