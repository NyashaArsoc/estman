@php 
$title = 'Add Client';
$description = 'add new client to the system...'; @endphp
@extends('layout.val-main-menu')
@section('title', 'Add CLient')
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
                        <select class="js-example-basic-single w-100" name="clienttype" id="clienttype"
                            onchange="LandlordCreationType(this)" />
                        <option value="">Select Client Type</option>
                        @foreach($type as $abc)
                        <option value="{{ $abc->id }}">  {{ $abc->description }}
                        </option>
                        @endforeach
                        </select>
                        <small id="clientypecheck" style="color: red;"> select client type </small>
                    </div>
                </div>
                <div id="IndividualGroup" class="dropdwn">
                    <div class="form-group row">
                        <label for="FirstName" class="col-sm-2 form-control-label">First Name
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                placeholder="First Name" autocomplete="off">
                        <small id="firstnamecheck" style="color: red;"> first name is required</small>
                        </div>
                        <label for="LastName" class="col-sm-2 form-control-label">Last Name
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                placeholder="Last Name" autocomplete="off">
                        <small id="lastnamecheck" style="color: red;"> last name is required</small>
                        </div>
                    </div>
                </div>
                <div id="CorporateGroup" class="dropdwn">
                    <div class="form-group row">
                        <label for="CompanyName" class="col-sm-2 form-control-label">Company Name 
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="companyname" name="companyname"
                                placeholder="Company Name" autocomplete="off">
                                <small id="companynamecheck" style="color: red;"> company name is required</small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Cell" class="col-sm-2 col-form-label">Cell
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="cell" name="cell" placeholder="cell"
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
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="email" name="email" 
                        placeholder="example@example.com" autocomplete="off">
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
                            <input type="text" class="form-control" id="contactfirstname" 
                            name="contactfirstname"  placeholder="First Name" autocomplete="off">
                            <small id="contactfirstnamecheck" style="color: red;">first name 
                                is required</small>
                        </div>

                        <label for="LastName" class="col-sm-2 form-control-label">Last Name
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contactlastname" 
                            name="contactlastname" placeholder="Last Name" autocomplete="off">
                            <small id="contactlastnamecheck" style="color: red;"> last name 
                                is required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Cell" class="col-sm-2 col-form-label">Cell
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contactcell" name="contactcell"
                             placeholder="Cell" autocomplete="off">
                             <small id="contactcellcheck" style="color: red;">cell is required</small>
                        </div>
                        <label for="Email" class="col-sm-2 col-form-label">Email
                            <i class="text-danger">*</i>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contactemail" name="contactemail"
                                placeholder="example@example.com" onkeypress='' autocomplete="off">
                                <small id="contactemailcheck" style="color: red;">email is required</small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    @if (in_array(1,$arraycontrolids))
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-val-new-client" >
                            submit</button>
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
<script src="{{ asset('js/validation/intake.js') }}"></script>
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    <!-- Additional JS End-->
@endsection
