@php 
$title = 'Edit Landlord';
$description = 'update landlord details...';
$id= Crypt::encrypt($landlord->id);
$contactid= Crypt::encrypt($contact->id);
$divindividualclass = $landlord->clienttypeid == 1 ? 'hide': 'dropdwn';
$divcompanyclass = $landlord->clienttypeid != 1 ? 'hide': 'dropdwn';
 @endphp
@extends('layout.no-menu-layout')
@section('title', 'Edit Landlord')
@section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
@endsection
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('propdec.listlanddec') }}">List</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="" method="POST" id="defaultform"
                action="{{ route('propdec.landupd', [$id,$contactid]) }}">@csrf
                <div class="form-group row">
                    <label for="ClientType" class="col-sm-2 form-control-label">Type<i class="text-danger">*</i></label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="clienttype" id="clienttype"
                            onchange="optionlandlordtype(this)" />
                            <option value="{{ $landlord->clienttypeid }}">{{ $landlord->description }}</option>
                        @foreach($type as $abc)
                        <option value="{{ $abc->id }}">  {{ $abc->description }}
                        </option>
                        @endforeach
                        </select>
                        <small id="clienttypecheck" style="color: red;">required</small>
                    </div>
                </div>
                <div id="individualgroup"  class="{{$divindividualclass}}">
                    <div class="form-group row">
                        <label for="FirstName" class="col-sm-2 form-control-label">First Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="firstname" name="firstname"
                            value="{{ $landlord->firstname ?? ''}}" autocomplete="off">
                        <small id="firstnamecheck" style="color: red;">required</small>
                        </div>
                        <label for="LastName" class="col-sm-2 form-control-label">Last Name
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="lastname" name="lastname"
                            value="{{ $landlord->lastname ?? ''}}" autocomplete="off">
                        <small id="lastnamecheck" style="color: red;">required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="NationalIDNumber" class="col-sm-2 col-form-label">National ID
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="nationalid" name="nationalid"
                            value="{{ $landlord->nationalid ?? '' }}" autocomplete="off">
                                <small id="nationalidcheck" style="color: red;">required</small>
                        </div>
                    </div>
                </div>
                <div id="corporategroup"  class="{{$divcompanyclass}}">
                    <div class="form-group row">
                        <label for="CompanyName" class="col-sm-2 form-control-label">Company Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="companyname" name="companyname"
                            value="{{ $landlord->companyname ?? ''}}" autocomplete="off">
                                <small id="companynamecheck" style="color: red;">required</small>
                        </div>
                        <label for="ClientType" class="col-sm-2 form-control-label">Company Number
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="companynumber" name="companynumber"
                            value="{{ $landlord->companynumber ?? ''}}" autocomplete="off">
                                <small id="companynumbercheck" style="color: red;">required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="VATNumber" class="col-sm-2 form-control-label">VAT Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="numericnotrequired" name="vatnumber"
                            value="{{ $landlord->vatnumber ?? ''}}" autocomplete="off">
                                <small id="numericnotrequiredcheck" style="color: red;"></small>
                        </div>
                        <label for="" class="col-sm-2 form-control-label">TIN Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="" name="tinumber"
                            value="{{ $landlord->bpnumber ?? ''}}" autocomplete="off">
                                <small id="numericnotrequiredcheck" style="color: red;"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Cell" class="col-sm-2 col-form-label">Cell
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="cell" name="cell" 
                        value="{{ $landlord->cell ?? ''}}"  autocomplete="off">
                            <small id="cellcheck" style="color: red;">required</small>
                    </div>
                    <label for="Tel" class="col-sm-2 col-form-label">Tel</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="Tel" name="tel"
                        value="{{ $landlord->tel ?? ''}}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ContactAddress" class="col-sm-2 col-form-label">Contact Address</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="billingaddress" name="billingaddress"
                        value="{{ $landlord->contactaddress ?? ''}}">
                        <small id="billingaddresscheck" style="color: red;">required</small> 
                    </div>
                    <label for="Email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="email" name="email" 
                        value="{{ $landlord->email ?? ''}}" autocomplete="off">
                            <small id="emailcheck" style="color: red;">required</small>
                    </div>
                </div>
                    <br />
                    <h5>contact person </h5>
                    <div class="form-group row">
                        <label for="FirstName" class="col-sm-2 form-control-label">First Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contactfirstname" 
                            name="contactfirstname"  value="{{ $contact->firstname ?? ''}}" autocomplete="off">
                            <small id="contactfirstnamecheck" style="color: red;">required</small>
                        </div>

                        <label for="LastName" class="col-sm-2 form-control-label">Last Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contactlastname" 
                            name="contactlastname" value="{{ $contact->lastname ?? ''}}" autocomplete="off">
                            <small id="contactlastnamecheck" style="color: red;">required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Cell" class="col-sm-2 col-form-label">Cell</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contactcell" name="contactcell"
                            value="{{ $contact->cell ?? ''}}" autocomplete="off">
                             <small id="contactcellcheck" style="color: red;">required</small>
                        </div>
                        <label for="Email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contactemail" name="contactemail"
                            value="{{ $contact->email ?? ''}}" autocomplete="off">
                                <small id="contactemailcheck" style="color: red;">required</small>
                        </div>
                    </div>
                <div class="form-group row">
                    @if (in_array(2,$arraycontrolids))
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-add-landlord" >submit</button>
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
<script src="{{ asset('js/validation/intakepropman.js') }}"></script>
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    <!-- Additional JS End-->
@endsection
