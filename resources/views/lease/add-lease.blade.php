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
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" action="{{ route('lease.addstore') }}"
            method="POST"> @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Tenant Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="TenantClientType" id="LeaseTenantClientType"
                            onChange="getTenantonLease();" />
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
                    <label for="" class="col-sm-2 form-control-label">Property Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="PropertyType" 
                        id="LeasePropertyType" onchange="getPropertyonLease();"
                        />
                        <option value="">Select Property Type</option>
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
                        <option value="">Select Property Address</option>
                        <option value=""> </option>
                        </select>
                    </div>
                    <small id="propertyaddresscheck" style="color: red;"> select property address</small>
                </div><br />
                <div class="form-group row">
                    <label for="ClientType" class="col-sm-2 form-control-label">Valid From</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="LeaseValidFrom" name="LeaseValidFrom">
                        <small id="validfromcheck" style="color: red;"> date is required</small>
                    </div>
                    <label for="ClientType" class="col-sm-2 form-control-label">Valid To</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="LeaseValidTo" name="LeaseValidTo">
                        <small id="validtocheck" style="color: red;"> date is required</small>
                    </div>
                </div><br />
                <div class="form-group row">
                    <label for="Type" class="col-sm-2 form-control-label">Inspection Period</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="InspectionPeriod" id="LeaseInspectionPeriod"
                        />
                        <option value="">Inspection Schedule</option>
                        @foreach ($period as $p)
                        <option value="{{ $p->description }}"> {{ $p->description }} </option>
                    @endforeach
                        </select>
                        <small id="inspectionscheck" style="color: red;"> select inspection schedule </small>
                    </div>
                        <label for="" class="col-sm-2 col-form-label">Property Description</label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" name="PropertyDescription"
                             rows="2" cols="3" id="PropertyDescription"></textarea>
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
                <option value="">Review Schedule</option>
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
            <label for="" class="col-sm-2 col-form-label">Currency</label>
            <div class="col-sm-4">
                <select class="js-example-basic-single w-100" name="RentCurrency" id="RentCurrency" />
                <option value="">Select Currency </option>
                @foreach ($currency as $cur)
                <option value="{{ $cur->id }}"> {{ $cur->code }}
                </option>
            @endforeach
                </select>
                <small id="rentalcurrencycheck" style="color: red;"> rental currency is required</small>
            </div>
            <div id="Commercial" class="dropdwn">
                <label for="" class="col-sm-2 col-form-label">Rate/sqm</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="RateSqm" name="RateSqm" placeholder="8"
                        autocomplete="off">
                    <small id="ratesqmcheck" style="color: red;"> rate/sqm is required</small>
                </div>
            </div>
            <div id="Residential" class="dropdwn">
                <label for="" class="col-sm-2 col-form-label">Expected Rental</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="ExpectedRental" name="ExpectedRental"
                        placeholder="8" autocomplete="off">
                    <small id="expectedrentalcheck" style="color: red;">rental is required</small>
                </div>
            </div>
        </div><br/>
        <div class="form-group row">
            <div id="CommercialBottom" class="dropdwn">
                <label for="AreaTaken" class="col-sm-2 col-form-label">Area Taken(Sqm)</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="AreaTaken" name="AreaTaken" placeholder="400"
                        autocomplete="off">
                    <small id="areatakencheck" style="color: red;">area taken is required</small>
                </div>
                <label for="Stories" class="col-sm-2 col-form-label">Occupied Area (Sqm)</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="OccupiedArea" name="OccupiedArea" readonly/>
                    <input type="text" class="form-control" id="AvailableLettableArea" 
                    name="AvailableLettableArea" readonly hidden>
                </div>
            </div>
        </div> <br />
        <h5>Additional Details  </h5>
        <div class="table-responsive" style="margin-top: 15px;">
            <table class="table table-bordered table-hover" id="leaseitems">
                <thead>
                    <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Curreny<i class="text-danger">*</i></th>
                    <th class="text-center">Balance b/d</th>
                    <th class="text-center">Rates/Utilities</th>
                    <th class="text-center">Operation Cost</th>
                    <th class="text-center">Deposit Paid</th>
                    <th class="text-center">Admin Paid</th>
                    <th class="text-center">Option</th>
                    </tr>
                </thead>
                <tbody id="addLeaseItem">
                    <tr>
                    <td></td><td>
                        <select class="js-example-basic-single w-100" name="LeaseItemCurrencyID"
                    id="LeaseItemCurrencyID"  tabindex="1"/>
                    <option value="">Select Currency </option>
                    @foreach ($currency as $cur)
                            <option value="{{ $cur->id }}"> {{ $cur->code }}
                            </option>
                    @endforeach
                    </select><small id="leaseitemcurrencycheck" style="color: red;"> select currency</small>
                        </td>
                        <td>
                            <input name="LeaseItemBDamount" class="form-control"
                            id="LeaseItemBDamount" value=""  tabindex="2" type="text">
                            <small id="leaseitembdamountcheck" style="color: red;">  </small>
                        </td>
                        <td>
                            <input name="LeaseItemRatesCost" class="form-control"
                            id="LeaseItemRatesCost" value=""  tabindex="3" type="text">
                            <small id="leaseitemratecostcheck" style="color: red;">  </small>
                        </td>
                        <td>
                            <input name="LeaseItemOperationalCost" class="form-control "
                            id="LeaseItemOperationalCost" value=""  tabindex="4" type="text">
                            <small id="leaseitemoperationcostcheck" style="color: red;">  </small>
                        </td>
                        <td>
                            <input name="LeaseItemDepositPaid" class="form-control "
                            id="LeaseItemDepositPaid" value=""  tabindex="5" type="text">
                            <small id="leaseitemdepositcheck" style="color: red;">  </small>
                        </td> 
                        <td>
                            <input name="LeaseItemAdminPaid" class="form-control "
                            id="LeaseItemAdminPaid" value=""  tabindex="4" type="text">
                            <small id="leaseitemadminpaidcheck" style="color: red;">  </small>
                        </td>                                        
                        <td align="center" colspan="2">
                        <input id="add-lease-item" class="btn btn-info" name="add-lease-item" 
                         value="Save" tabindex="6" type="button">
                        </td>
                    </tr>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-submit-lease-new" value="{{ $title }}">
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
    <script src="{{ asset('js/add-table-details.js') }}"></script> 
    <!-- Additional JS End-->
@endsection
