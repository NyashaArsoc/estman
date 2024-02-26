@php 
$title = 'Add Landlord';
$description = 'add landlord to the system...'; @endphp
@extends('layout.main-layout')
@section('title', 'Add Landlord')
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
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="" method="POST"
                action="{{ route('landlord.addlandlord') }}">@csrf
                <div class="form-group row">
                    <label for="ClientType" class="col-sm-2 form-control-label">Type<i class="text-danger">*</i></label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="LandlordClientType" id="LandlordClientType"
                            onchange="LandlordCreationType(this)" />
                        <option value="">Select Client Type</option>
                        @foreach($type as $typ)
                        <option value="{{ $typ->id }}">  {{ $typ->description }}
                        </option>
                        @endforeach
                        </select>
                        <small id="landlordtypecheck" style="color: red;"> select landlord type </small>
                    </div>
                </div>
                <div id="IndividualGroup" class="dropdwn">
                    <div class="form-group row">
                        <label for="FirstName" class="col-sm-2 form-control-label">First Name
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="FirstName" name="FirstName"
                                placeholder="First Name" autocomplete="off">
                        <small id="firstnamecheck" style="color: red;"> first name is required</small>
                        </div>
                        <label for="LastName" class="col-sm-2 form-control-label">Last Name
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="LastName" name="LastName"
                                placeholder="Last Name" autocomplete="off">
                        <small id="lastnamecheck" style="color: red;"> last name is required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="NationalIDNumber" class="col-sm-2 col-form-label">National ID
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="NationalIDNumber" name="NationalID"
                                placeholder="33708965K67" autocomplete="off">
                                <small id="nationalidcheck" style="color: red;"> national id is required</small>
                        </div>
                    </div>
                </div>
                <div id="CorporateGroup" class="dropdwn">
                    <div class="form-group row">
                        <label for="CompanyName" class="col-sm-2 form-control-label">Company Name 
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="CompanyName" name="CompanyName"
                                placeholder="Company Name" autocomplete="off">
                                <small id="companynamecheck" style="color: red;"> company name is required</small>
                        </div>

                        <label for="ClientType" class="col-sm-2 form-control-label">Company Number
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="CompanyNumber" name="CompanyNumber"
                                placeholder="Company Number" autocomplete="off">
                                <small id="companynumbercheck" style="color: red;"> company reg number is required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="VATNumber" class="col-sm-2 form-control-label">VAT Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="VATNumber" name="VATNumber"
                                placeholder="VAT Number" autocomplete="off">
                        </div>

                        <label for="BPNumber" class="col-sm-2 form-control-label">BP Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="BPNumber" name="BPNumber"
                                placeholder="BP Number" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Cell" class="col-sm-2 col-form-label">Cell
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="Cell" name="Cell" placeholder="Cell"
                            autocomplete="off">
                            <small id="cellcheck" style="color: red;"> cell number is required</small>
                    </div>
                    <label for="Tel" class="col-sm-2 col-form-label">Tel</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="Tel" name="Tel"
                            placeholder="024456787/9" onkeypress='' autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ContactAddress" class="col-sm-2 col-form-label">Contact Address</label>
                    <div class="col-sm-4">
                        <textarea type="text" class="form-control" name="ContactAddress" rows="2" cols="3"
                            id="ContactAddress"></textarea>
                    </div>
                    <label for="Email" class="col-sm-2 col-form-label">Email
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="Email" name="Email" placeholder="Email"
                            autocomplete="off">
                            <small id="emailcheck" style="color: red;"> email is required</small>
                    </div>
                </div>
                <div id="CorporateGroupContact" class="dropdwn">
                    <br />
                    <h5>company contact person </h5>
                    <div class="form-group row">
                        <label for="FirstName" class="col-sm-2 form-control-label">First Name
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ContactFirstName" 
                            name="ContactFirstName"  placeholder="First Name" autocomplete="off">
                            <small id="contactfirstnamecheck" style="color: red;">first name 
                                is required</small>
                        </div>

                        <label for="LastName" class="col-sm-2 form-control-label">Last Name
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ContactLastName" 
                            name="ContactLastName" placeholder="Last Name" autocomplete="off">
                            <small id="contactlastnamecheck" style="color: red;"> last name 
                                is required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Cell" class="col-sm-2 col-form-label">Cell
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ContactCell" name="ContactCell"
                             placeholder="Cell" autocomplete="off">
                             <small id="contactcellcheck" style="color: red;">cell is required</small>
                        </div>
                        <label for="Email" class="col-sm-2 col-form-label">Email
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ContactEmail" name="ContactEmail"
                                placeholder="example@example.com" onkeypress='' autocomplete="off">
                                <small id="contactemailcheck" style="color: red;">email is required</small>
                        </div>
                    </div>
                </div>
                <h5>Banking Details </h5>
                <div class="table-responsive" style="margin-top: 15px;">
                    <table class="table table-bordered table-hover" id="landlordbanking">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Curreny<i class="text-danger">*</i></th>
                                <th class="text-center">Account Name<i class="text-danger">*</i></th>
                                <th class="text-center">Bank Name<i class="text-danger">*</i></th>
                                <th class="text-center">Branch</th>
                                <th class="text-center">Account Number<i class="text-danger">*</i></th>
                                <th class="text-center">Option</th>
                            </tr>
                        </thead>
                        <tbody id="addBankItem">
                            <tr>
                                <td></td>
                                <td>
                                    <select class="js-example-basic-single w-100" name="Currency" id="Currency"
                                        tabindex="1"  >
                                    <option value="">Select Currency </option>
                                    @foreach($currency as $cur)
                                    <option value="{{ $cur->code }}">  {{ $cur->code }}
                                    </option>
                                    @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input name="AccountName" class="form-control" id="AccountName" value=""
                                        tabindex="2" type="text">
                                        <small id="accountnamecheck" style="color: red;"></small>
                                </td>
                                <td>
                                    <input name="BankName" class="form-control" id="BankName" value=""
                                        tabindex="3" type="text">
                                        <small id="banknamecheck" style="color: red;"></small>
                                </td>
                                <td>
                                    <input name="Branch" class="form-control " id="Branch" value=""
                                        tabindex="4" type="text">
                                </td>
                                <td>
                                    <input name="AccountNumber" class="form-control " id="AccountNumber" value=""
                                        tabindex="5" type="text">
                                        <small id="accountnumbercheck" style="color: red;"></small>
                                </td>
                                <td align="center" colspan="2">
                                    <input id="add-banking-item" class="btn btn-info" name="add-banking-item"
                                        value="Save" tabindex="6" type="button">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-submit" >
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
<script src="{{ asset('js/validation/landlord.js') }}"></script>
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    <script src="{{ asset('js/add-table-details.js') }}"></script>
    
    <!-- Additional JS End-->
@endsection
