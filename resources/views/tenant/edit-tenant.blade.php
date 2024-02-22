@php 
$title = 'Edit Tenant';
$description = 'update tenant details...'; 
$id= Crypt::encrypt($tenant->id);
if ($tenant->clienttypeid == 1){
    $registration   =  $tenant->nationalid ;
    // dropdwn = show in css
    $divindividualclass   =   'hide';
    $divcompanyclass      =   'dropdwn';
    }else{
    $registration   =  $tenant->companynumber ;
    $divindividualclass   =   'dropdwn';
    $divcompanyclass      =   'hide';
   } 
@endphp
@extends('layout.main-layout')
@section('title', 'Edit Tenant')
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
            <li class="breadcrumb-item"><a href="{{route('tenant.rejected')}}">Rejected</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="" method="PUT"
                action="{{ route('tenant.editupdate', $id)}}">@csrf
                <div class="form-group row">
                    <label for="ClientType" class="col-sm-2 form-control-label">Type</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="TenantClientType" id="TenantClientType"
                            onchange="TenantCreationType(this)" />
                        <option value="{{ $tenant->clienttypeid }}">{{ $tenant->typedescription }}</option>
                        @foreach($type as $typ)
                        <option value="{{ $typ->id }}">  {{ $typ->description }}
                        </option>
                        @endforeach
                        </select>
                        <small id="tenanttypecheck" style="color: red;"> select tenant type </small>
                    </div>
                </div>
                <div id="IndividualGroup" class="{{$divindividualclass}}">
                    <div class="form-group row">
                        <label for="FirstName" class="col-sm-2 form-control-label">First Name
                       </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="FirstName" name="FirstName"
                                value="{{ $tenant->firstname ?? ''}}" autocomplete="off">
                        <small id="firstnamecheck" style="color: red;"> first name is required</small>
                        </div>
                        <label for="LastName" class="col-sm-2 form-control-label">Last Name
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="LastName" name="LastName"
                                value="{{ $tenant->lastname ?? ''}}" autocomplete="off">
                        <small id="lastnamecheck" style="color: red;"> last name is required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="NationalIDNumber" class="col-sm-2 col-form-label">National ID
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="NationalIDNumber" name="NationalID"
                                value="{{ $tenant->nationalid ?? '' }}" autocomplete="off">
                                <small id="nationalidcheck" style="color: red;"> national id is required</small>
                        </div>
                    </div>
                </div>
                <div id="CorporateGroup" class="{{$divcompanyclass}}">
                    <div class="form-group row">
                        <label for="CompanyName" class="col-sm-2 form-control-label">Company Name 
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="CompanyName" name="CompanyName"
                                value="{{ $tenant->companyname ?? ''}}" autocomplete="off">
                                <small id="companynamecheck" style="color: red;"> company name is required</small>
                        </div>

                        <label for="ClientType" class="col-sm-2 form-control-label">Company Number
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="CompanyNumber" name="CompanyNumber"
                                value="{{ $tenant->companynumber ?? ''}}" autocomplete="off">
                                <small id="companynumbercheck" style="color: red;"> company reg number is required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="VATNumber" class="col-sm-2 form-control-label">VAT Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="VATNumber" name="VATNumber"
                                value="{{ $tenant->vatnumber ?? ''}}" autocomplete="off">
                        </div>

                        <label for="BPNumber" class="col-sm-2 form-control-label">BP Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="BPNumber" name="BPNumber"
                                value="{{ $tenant->bpnumber ?? ''}}" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Cell" class="col-sm-2 col-form-label">Cell
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="Cell" name="Cell" 
                        value="{{ $tenant->cell ?? ''}}" autocomplete="off">
                            <small id="cellcheck" style="color: red;"> cell number is required</small>
                    </div>
                    <label for="Tel" class="col-sm-2 col-form-label">Tel</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="Tel" name="Tel"
                            value="{{ $tenant->tel ?? ''}}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ContactAddress" class="col-sm-2 col-form-label">Contact Address</label>
                    <div class="col-sm-4">
                        <textarea type="text" class="form-control" name="ContactAddress" rows="2" cols="3"
                            id="ContactAddress">{{ $tenant->contactaddress ?? ''}}</textarea>
                    </div>
                    <label for="Email" class="col-sm-2 col-form-label">Email
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="Email" name="Email" 
                        value="{{ $tenant->email ?? ''}}" autocomplete="off">
                            <small id="emailcheck" style="color: red;"> email is required</small>
                    </div>
                </div>
                <div id="CorporateGroupContact" class="{{$divcompanyclass}}">
                    <br />
                    <h5>company contact person </h5>
                    <div class="form-group row">
                        <label for="FirstName" class="col-sm-2 form-control-label">First Name
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ContactFirstName" 
                            name="ContactFirstName"  value="{{ $contact->firstname ?? ''}}" autocomplete="off">
                            <small id="contactfirstnamecheck" style="color: red;">first name 
                                is required</small>
                        </div>

                        <label for="LastName" class="col-sm-2 form-control-label">Last Name
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ContactLastName" 
                            name="ContactLastName" value="{{ $contact->lastname ?? ''}}" autocomplete="off">
                            <small id="contactlastnamecheck" style="color: red;"> last name 
                                is required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Cell" class="col-sm-2 col-form-label">Cell
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ContactCell" name="ContactCell"
                             value="{{ $contact->cell ?? ''}}" autocomplete="off">
                             <small id="contactcellcheck" style="color: red;">cell is required</small>
                        </div>
                        <label for="Email" class="col-sm-2 col-form-label">Email
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ContactEmail" name="ContactEmail"
                                value="{{ $contact->email ?? ''}}" autocomplete="off">
                                <small id="contactemailcheck" style="color: red;">email is required</small>
                        </div>
                    </div>
                </div>
                <div id="KeenGroup" class="{{$divindividualclass}}">
                    <br/> <h5>next of keen</h5>
                    <div class="form-group row"> 
                        <label for="FirstName" class="col-sm-2 form-control-label">First Name
                            <i class="text-danger">*</i>
                        </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="KeenFirstName" name="KeenFirstName"
                                value="{{ $keen->firstname ?? ''}}" >
                                <small id="keenfirstnamecheck" style="color: red;">first name 
                                    is required</small>
                            </div> 
                            <label for="LastName" class="col-sm-2 form-control-label">Last Name
                                <i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="KeenLastName" name="KeenLastName"
                                value="{{ $keen->lastname ?? ''}}" >
                                <small id="keenlastnamecheck" style="color: red;"> last name 
                                    is required</small>
                            </div> 
                    </div>
                    <div class="form-group row">
                        <label for="Cell" class="col-sm-2 col-form-label">Cell
                            <i class="text-danger">*</i>
                        </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="KeenCell" 
                                name="KeenCell"  value="{{ $keen->cell ?? ''}}"> 
                                <small id="keencellcheck" style="color: red;">cell is required</small>  
                            </div>
                            <label for="Email" class="col-sm-2 col-form-label">Email
                                <i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="KeenEmail" 
                                name="KeenEmail"  value="{{ $keen->email ?? ''}}"
                                autocomplete="off" >
                                <small id="keenemailcheck" style="color: red;">email is required</small>
                            </div>
                    </div>
                </div> 
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-edit-submit" >
                           Submit</button>
                    </div>
                </div>
                @include('layout.arlet')
            </form>
        </div>
    </div>
    <!-- Content End-->

@endsection
@section('additional js')
<script src="{{ asset('js/validation/tenant.js') }}"></script>
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>    
    <!-- Additional JS End-->
@endsection
