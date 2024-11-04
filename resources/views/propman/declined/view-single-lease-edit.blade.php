@php
    $title = 'Edit Lease';
    $description = 'add new lease to the system...';

 $divindividualclass = $lease->propertytypeid == 1 ? 'hide': 'dropdwn';
$divcompanyclass = $lease->propertytypeid != 1 ? 'hide': 'dropdwn';

 $id= Crypt::encrypt($lease->id);
 $agreement= Crypt::encrypt($lease->agreement);
 $requiredpdf    = (!is_null($lease->agreement)) ? route('propapp.dwnagrepdf',[$agreement]) : '';
 $attachementrequiredpdf = (!is_null($lease->agreement)) ? 'download file' : '';
@endphp
@extends('layout.no-menu-layout')
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
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('propdec.listleadec') }}">List</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" id="clientTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="lease-detail-tab" data-toggle="tab" href="#lease-detail" role="tab" aria-controls="lease-detail" aria-selected="true">Lease Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="rates-info-tab" data-toggle="tab" href="#rates-info" role="tab" aria-controls="rates-info" aria-selected="true">Rates</a>
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
            <div class="tab-pane show active" id="lease-detail" role="tabpanel" aria-labelledby="lease-detail-tab">
            <form class="form-material material-primary" action="{{ route('propdec.uptlea',$id) }}"
            method="POST" enctype="multipart/form-data"> @csrf <hr>
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Client Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="clienttype" id="clienttype"
                            onChange="getpropmantenantlist();" />
                            <option value="{{ $clienttype->clienttypeid }}">{{ $clienttype->clienttype }}</option>
                            @foreach ($type as $abc)
                                <option value="{{ $abc->id }}"> {{ $abc->description }}
                                </option>
                            @endforeach
                            </select>
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Tenant Name </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="tenantname" id="tenantlist" />
                        <option value="{{ $lease->tenantid }}">{{ $lease->tenantfullname }}
                            {{ $lease->tenantcompanyname }} </option>
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
                        <option value="{{ $lease->propertytypeid }}">{{ $lease->propertytype }}</option>
                        @foreach ($proptype as $abc)
                        <option value="{{ $abc->id }}"> {{ $abc->description }}</option>
                    @endforeach
                        </select>
                    </div> 
                    <label for="City" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="propertyaddress"
                         id="propertyaddress" onchange="getpropmanlandlordlistbyproperty();"/>
                        <option value="{{ $lease->propertyid }}">{{ $lease->streetaddress }}</option>
                        <option value=""> </option>
                        </select>
                    </div>
                </div><br />
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Landlord Name </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="landlordname" id="landlordlist" />
                        <option value="{{ $lease->landlordcontactid }}">{{ $lease->landlordcontact }}</option>
                        <option value=""> </option>
                        </select>
                        <small id="landlordlistcheck" style="color: red;">required</small>
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Property Description</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="billingaddress" name="propertydescription"
                            value="{{ $lease->propertydescription ?? ''}}">
                            <small id="billingaddresscheck" style="color: red;">required</small> 
                        </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Valid From</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="datefrom" name="leasevalidfrom"
                        value="{{ $lease->validfrom ?? ''}}">
                        <small id="datefromcheck" style="color: red;">required</small>
                    </div>
                    <label for="ClientType" class="col-sm-2 form-control-label">Valid To</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="dateto" name="leasevalidto"
                        value="{{ $lease->validto ?? ''}}">
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
                    <option value="{{ $lease->rentreview }}">{{ $lease->rentreview }}</option>
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
                        <option value="{{ $lease->inspectionreview }}">{{ $lease->inspectionreview }}</option>
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
                <option value="{{ $lease->currencycode }}">{{ $lease->currencycode }}</option>
                @foreach ($currency as $abc)
                    <option value="{{ $abc->code }}"> {{ $abc->code }}
                    </option>
                @endforeach
                </select>
                <small id="currencycodecheck" style="color: red;">required</small>
            </div>
            <div id="commercial" class="{{$divcompanyclass}}">
                <label for="" class="col-sm-2 col-form-label">Rate/sqm</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="expectedrate" name="expectedrate"
                    value="{{ $lease->ratesqm ?? ''}}">
                <small id="expectedratecheck" style="color: red;">required</small>
                </div>
            </div>
            <div id="residential" class="{{$divindividualclass}}">
                <label for="" class="col-sm-2 col-form-label">Expected Rental</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="expectedrental" name="expectedrental"
                    value="{{ $lease->rental ?? ''}}">
                <small id="expectedrentalcheck" style="color: red;">required</small>
                </div>
            </div>
        </div><br/>
        <div class="form-group row">
            <div id="commercialbottom" class="{{$divcompanyclass}}">
                <label for="AreaTaken" class="col-sm-2 col-form-label">Area Taken(Sqm)</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="lettablearea" name="areataken"
                    value="{{ $lease->areataken ?? ''}}">
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
            <label for="" class="col-sm-2 col-form-label">Lease Agreement</label>
            <div class="col-sm-4">
                <a href="{{ $requiredpdf }}">{{ $attachementrequiredpdf}}</a>
            </div>
        </div> 
        <div class="form-group row">
            @if (in_array(2,$arraycontrolids))
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-add-lease" >submit</button>
            </div>
            @endif
        </div>
        </form>
    </div>
    <div class="tab-pane show" id="rates-info" role="tabpanel" aria-labelledby="rates-info-tab">
        <br/> <h5>Lease Rates  </h5>@if (in_array(1,$arraycontrolids))
        <a  class="btn btn-primary btn-sm" href="{{route('propin.addlearatedec', $id)}}
        " title="add">create new</a>
        @endif<hr/>
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
                    <th class="text-center">Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($rates as $abc)
                    <tr>
                        @php $itemid= Crypt::encrypt($abc->id); @endphp
                    <td>{{$count ++}}</td>
                    <td>{{ $abc->currencycode }}</td>
                    <td>{{ number_format($abc->ratescosts,2) }}</td>
                    <td>{{ number_format($abc->operationalcosts,2) }}</td>
                    <td>{{ number_format($abc->deposit,2) }}</td>   
                    <td>{{ number_format($abc->adminstrationfee,2) }}</td>
                    <td>@if (in_array(2,$arraycontrolids))<a class="btn btn-secondary btn-sm"  
                        href="{{ route('propdec.editlearat',[$itemid,$id]) }}"
                        title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>@endif
                        @if (in_array(4,$arraycontrolids))<a class="btn btn-danger btn-sm" 
                        href="{{ route('propdec.dellearate',[$itemid,$id]) }}"title="delete" 
                        onclick = "deleterecord(this); return false;"><i class="ti-close 
                        mr-0-5"></i>delete</a>@endif
                    </td>                                       
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane show" id="prepay-info" role="tabpanel" aria-labelledby="prepay-info-tab">
        <br/><h5>Prepayments</h5>
        @if (in_array(1,$arraycontrolids))
                <a  class="btn btn-primary btn-sm" href="{{route('propin.addleapre', $id)}}
                " title="add">create new</a>
                @endif<hr/>
        <div class="table-responsive" style="margin-top: 15px;">
            <table class="table table-bordered table-hover" id="leaseitems">
                <thead>
                    <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Curreny</th>
                    <th class="text-center">Balance</th>
                    <th class="text-center">Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($prepay as $abc)
                    <tr>
                        @php $itemid= Crypt::encrypt($abc->id); @endphp
                    <td>{{$count ++}}</td>
                    <td>{{ $abc->currencycode }}</td>
                    <td>{{ number_format($abc->balance,2) }}</td>  
                    <td>@if (in_array(2,$arraycontrolids))<a class="btn btn-secondary btn-sm" 
                         href="{{ route('propdec.editleapre',[$id,$itemid]) }}"
                        title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>@endif
                        @if (in_array(4,$arraycontrolids))<a class="btn btn-danger btn-sm" 
                        href="{{ route('propdec.delleaprepay',[$id,$itemid]) }}"title="disable" 
                        onclick = "deleterecord(this); return false;"><i class="ti-close 
                        mr-0-5"></i>delete</a>@endif
                    </td>                                    
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane show" id="arrear-info" role="tabpanel" aria-labelledby="arrear-info-tab">
        <br/><h5>Arrears </h5>
        @if (in_array(1,$arraycontrolids))
                <a  class="btn btn-primary btn-sm" href="{{route('propin.addleaarrer', $id)}}
                " title="add">create new</a>
                @endif<hr/>
        <div class="table-responsive" style="margin-top: 15px;">
            <table class="table table-bordered table-hover" id="leaseitems">
                <thead>
                    <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Curreny</th>
                    <th class="text-center">Balance</th>
                    <th class="text-center">Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($balance as $abc)
                    <tr>
                        @php $itemid= Crypt::encrypt($abc->id); @endphp
                    <td>{{$count ++}}</td>
                    <td>{{ $abc->currencycode }}</td>
                    <td>{{ number_format($abc->balrent,2) }}</td>
                    <td>@if (in_array(2,$arraycontrolids))<a class="btn btn-secondary btn-sm" 
                         href="{{route('propdec.editleaarrear',[$id,$itemid])}}"
                        title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>@endif
                        @if (in_array(4,$arraycontrolids))<a class="btn btn-danger btn-sm" 
                        href="{{route('propdec.delleaarrear',[$itemid,$id]) }}"title="delete" 
                        onclick = "deleterecord(this); return false;"><i class="ti-close 
                        mr-0-5"></i>delete</a>@endif
                    </td>                                        
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
        @include('layout.arlet')
    </div>
    </div>
    <!-- Content End-->
@endsection
@section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/validation/intakepropman.js') }}"></script>
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    
    <!-- Additional JS End-->
@endsection
