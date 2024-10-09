@php
    $title = 'Add Lease';
    $description = 'add new lease to the system...';
@endphp
@extends('layout.propman-main-menu')
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
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" action="{{ route('propin.addnewlease') }}"
            method="POST" enctype="multipart/form-data"> @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Client Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="clienttype" id="clienttype"
                            onChange="getpropmantenantlist();" />
                            <option value="">select client type</option>
                            @foreach ($type as $abc)
                                <option value="{{ $abc->id }}"> {{ $abc->description }}
                                </option>
                            @endforeach
                            </select>
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Tenant Name </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="tenantname" id="tenantlist" />
                        <option value="">select tenant</option>
                        <option value=""> </option>
                        </select>
                    </div>
                    <small id="tenantlistcheck" style="color: red;">required</small>
                </div><br />
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Property Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="propertytype" 
                        id="propertytype" onchange="getoptionpropmanpropertylist();"/>
                        <option value="">select property type </option>
                        @foreach ($proptype as $abc)
                        <option value="{{ $abc->id }}"> {{ $abc->description }}</option>
                    @endforeach
                        </select>
                    </div> 
                    <label for="City" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="propertyaddress"
                         id="propertyaddress" onchange="getpropmanlandlordlistbyproperty();"/>
                        <option value="">Select Property Address</option>
                        <option value=""> </option>
                        </select>
                    </div>
                </div><br />
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Landlord Name </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="landlordname" id="landlordlist" />
                        <option value="">select landlord</option>
                        <option value=""> </option>
                        </select>
                        <small id="landlordlistcheck" style="color: red;">required</small>
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Property Description</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="billingaddress" name="propertydescription">
                            <small id="billingaddresscheck" style="color: red;">required</small> 
                        </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Valid From</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="datefrom" name="leasevalidfrom">
                        <small id="datefromcheck" style="color: red;">required</small>
                    </div>
                    <label for="ClientType" class="col-sm-2 form-control-label">Valid To</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="dateto" name="leasevalidto">
                        <small id="datetocheck" style="color: red;">required</small>
                    </div>
                </div><br />
                <div class="form-group row">
                   
                        
                </div><br />
        <br />
        <h5>rental information (VAT incl)</h5>
        <div class="form-group row">
            <label for="City" class="col-sm-2 col-form-label">Rent Review Period</label>
            <div class="col-sm-4">
                <select class="js-example-basic-single w-100" name="rentreviewperiod"
                    id="rentreviewperiod" />
                    <option value="">review schedule</option>
                    <option value="monthly"> monthly </option>
                    <option value="quarterly"> quarterly </option>
                    <option value="halfyearly"> half yearly </option>
                    <option value="yearly"> yearly </option>
                </select>
                <small id="rentreviewcheck" style="color: red;">required</small>
            </div>
            <label for="Type" class="col-sm-2 form-control-label">Inspection Period</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="inspectionperiod" id="periodlist"/>
                        <option value="">inspection schedule</option>
                        <option value="monthly"> monthly </option>
                        <option value="quarterly"> quarterly </option>
                        <option value="halfyearly"> half yearly </option>
                        <option value="yearly"> yearly </option>
                        </select>
                        <small id="periodlistcheck" style="color: red;"> required </small>
            </div>
        </div><br />
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Currency</label>
            <div class="col-sm-4">
                <select class="js-example-basic-single w-100" name="currencycode" id="currencycode" />
                <option value="">select currency </option>
                @foreach ($currency as $abc)
                    <option value="{{ $abc->code }}"> {{ $abc->code }}
                    </option>
                @endforeach
                </select>
                <small id="currencycodecheck" style="color: red;">required</small>
            </div>
            <div id="commercial" class="dropdwn">
                <label for="" class="col-sm-2 col-form-label">Rate/sqm</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="expectedrate" name="expectedrate"
                    placeholder="8" autocomplete="off">
                <small id="expectedratecheck" style="color: red;">required</small>
                </div>
            </div>
            <div id="residential" class="dropdwn">
                <label for="" class="col-sm-2 col-form-label">Expected Rental</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="expectedrental" name="expectedrental"
                    placeholder="8" autocomplete="off">
                <small id="expectedrentalcheck" style="color: red;">required</small>
                </div>
            </div>
        </div><br/>
        <div class="form-group row">
            <div id="commercialbottom" class="dropdwn">
                <label for="AreaTaken" class="col-sm-2 col-form-label">Area Taken(Sqm)</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="lettablearea" name="areataken"
                                placeholder="380" autocomplete="off">
                    <small id="lettableareacheck" style="color: red;">required</small>
                </div>
                <label for="" class="col-sm-2 col-form-label">Calulated Rental</label>
                <div class="col-sm-4">
                    <strong id="rentalcalculatedcheck" style="color: rgb(37, 27, 182);"></strong>
                    <input type="text" class="form-control" id="OccupiedArea" name="OccupiedArea" readonly hidden/>
                    <input type="text" class="form-control" id="AvailableLettableArea" 
                    name="AvailableLettableArea" readonly hidden>
                </div>
            </div>
        </div>
        <h5>attachments </h5>
        <div class="form-group row">
            <label for="pdf" class="col-sm-2 col-form-label">Signed Lease</label>
            <div class="col-sm-4">
                <input type="file" class="form-control" id="requiredsignedpdf" name="leaseagreement"
                accept=".pdf">
                <small id="requiredsignedpdfcheck" style="color: red;">required</small>
            </div>
        </div>  <br />
        <h5>Additional Details  </h5>
        <div class="table-responsive" style="margin-top: 15px;">
            <table class="table table-bordered table-hover" id="leaseitems">
                <thead>
                    <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Curreny</th>
                    <th class="text-center">Balance b/d</th>
                    <th class="text-center">Rates/Utilities</th>
                    <th class="text-center">Operation Cost</th>
                    <th class="text-center">Deposit Paid</th>
                    <th class="text-center">Admin Paid</th>
                    <th class="text-center">Option</th>
                    </tr>
                </thead>
                <tbody id="addleaseitem">
                    <tr>
                    <td></td><td>
                        <select class="js-example-basic-single w-100" name="leaseitemcurrencycode"
                         id="leaseitemcurrencycode" />
                        <option value="">currency </option>
                        @foreach ($currency as $abc)
                            <option value="{{ $abc->code }}"> {{ $abc->code }}
                            </option>
                        @endforeach
                        </select>
                        <small id="leaseitemcurrencycodecheck" style="color: red;">required</small>
                        </td>
                        <td>
                            <input name="leasebalancebd" class="form-control"
                            id="balancebdinput" value=""  tabindex="2" type="text">
                            <small id="balancebdinputcheck" style="color: red;">  </small>
                        </td>
                        <td>
                            <input name="leaseratescost" class="form-control"
                            id="leaseratescost" value=""  tabindex="3" type="text">
                            <small id="leaseratescostcheck" style="color: red;">  </small>
                        </td>
                        <td>
                            <input name="leaseoperationalcost" class="form-control "
                            id="leaseoperationalcost" value=""  tabindex="4" type="text">
                            <small id="leaseoperationcostcheck" style="color: red;">  </small>
                        </td>
                        <td>
                            <input name="leasedepositpaid" class="form-control "
                            id="leasedepositpaid" value=""  tabindex="5" type="text">
                            <small id="leasedepositpaidcheck" style="color: red;">  </small>
                        </td> 
                        <td>
                            <input name="leaseadminpaid" class="form-control "
                            id="leaseadminpaid" value=""  tabindex="4" type="text">
                            <small id="leaseadminpaidcheck" style="color: red;">  </small>
                        </td>                                        
                        <td align="center" colspan="2">
                        <input id="add-lease-item" class="btn btn-info" name="add-lease-item" 
                         value="Save" tabindex="6" type="button">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="form-group row">
            @if (in_array(1,$arraycontrolids))
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-add-lease" >submit</button>
            </div>
            @endif
        </div>
        </form>
        @include('layout.arlet')
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
