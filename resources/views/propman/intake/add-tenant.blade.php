@php $title = 'Add Tenant'; 
      $description = 'add tenant to the system...'; @endphp
    @extends('layout.propman-main-menu')
    @section('title', 'Add Tenant')
    @section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
    @endsection
    @section('content')
        <!-- Content Start-->
        <div class="container-fluid">
            <h4>{{$title}}</h4>
            <ol class="breadcrumb no-bg mb-1">
                <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
            <div class="box box-block bg-white">
                <h5>{{$title}}</h5>
                <p class="font-90 text-muted mb-1"> {{$description}}</p>
                <form class="form-material material-primary" id="defaultform" action="{{ route('propin.addnewtenant') }}"
                method="POST" >@csrf
                    <div class="form-group row"> 
                        <label for="ClientType" class="col-sm-2 form-control-label">Client Type</label>
                            <div class="col-sm-4">
                                <select class="js-example-basic-single w-100" name="clienttype"
								id="clienttype" onchange="optiontenanttype(this)" />
                                <option value="">select client type</option>
                                @foreach($type as $abc)
                                <option value="{{ $abc->id }}">  {{ $abc->description }}
                                </option>
                                @endforeach
                                </select>
                                <small id="clienttypecheck" style="color: red;">required</small>
                            </div>      
                    </div>
                    <div id="individualgroup" class="dropdwn">
                        <div class="form-group row"> 
                            <label for="FirstName" class="col-sm-2 form-control-label">First Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    placeholder="First Name" autocomplete="off">
                            <small id="firstnamecheck" style="color: red;">required</small>
                            </div>
                            <label for="LastName" class="col-sm-2 form-control-label">Last Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    placeholder="Last Name" autocomplete="off">
                            <small id="lastnamecheck" style="color: red;">required</small>
                            </div> 
                        </div>
                        <div class="form-group row">
                            <label for="NationalIDNumber" class="col-sm-2 col-form-label">National ID </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="nationalid" name="nationalid"
                                placeholder="33708965K67" autocomplete="off">
                                <small id="nationalidcheck" style="color: red;">required</small>
                        </div>
                         </div>
                    </div>
                    <div id="corporategroup" class="dropdwn">
                        <div class="form-group row"> 
                            <label for="CompanyName" class="col-sm-2 form-control-label">Company Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="companyname" name="companyname"
                                    placeholder="Company Name" autocomplete="off">
                                    <small id="companynamecheck" style="color: red;">required</small>
                            </div>
                            <label for="" class="col-sm-2 form-control-label">Company Number</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="companynumber" name="companynumber"
                                    placeholder="Company Number" autocomplete="off">
                                    <small id="companynumbercheck" style="color: red;">required</small>
                            </div>
                        </div>
                        <div class="form-group row"> 
                            <label for="VATNumber" class="col-sm-2 form-control-label">VAT Number</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="numericnotrequired" name="vatnumber"
                                    placeholder="VAT Number" autocomplete="off">
                                    <small id="numericnotrequiredcheck" style="color: red;"></small>
                            </div>
                            <label for="" class="col-sm-2 form-control-label">TIN Number</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="" name="tinnumber"
                                placeholder="TIN Number" autocomplete="off">
                                <small id="numericnotrequiredcheck" style="color: red;"></small>
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Cell" class="col-sm-2 col-form-label">Cell </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cell" name="cell" placeholder="Cell"
                                autocomplete="off">
                                <small id="cellcheck" style="color: red;">required</small>
                        </div>
                        <label for="Tel" class="col-sm-2 col-form-label">Tel</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="Tel" name="tel"
                                placeholder="024456787/9" onkeypress='' autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ContactAddress" class="col-sm-2 col-form-label">Contact Address</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="billingaddress" name="billingaddress">
                            <small id="billingaddresscheck" style="color: red;">required</small> 
                        </div>
                        <label for="Email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="email" name="email" 
                            placeholder="example@example.com" autocomplete="off">
                                <small id="emailcheck" style="color: red;">required</small>
                        </div>
                    </div>
                    <div id="companycontactgroup" class="dropdwn">
                        <br/> <h5>company contact person </h5>
                        <div class="form-group row"> 
                            <label for="FirstName" class="col-sm-2 form-control-label">First Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="contactfirstname" 
                                name="contactfirstname"  placeholder="First Name" autocomplete="off">
                                <small id="contactfirstnamecheck" style="color: red;">required</small>
                            </div>
                            <label for="LastName" class="col-sm-2 form-control-label">Last Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="contactlastname" 
                                name="contactlastname" placeholder="Last Name" autocomplete="off">
                                <small id="contactlastnamecheck" style="color: red;">required</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Cell" class="col-sm-2 col-form-label">Cell</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="contactcell" name="contactcell"
                                 placeholder="Cell" autocomplete="off">
                                 <small id="contactcellcheck" style="color: red;">required</small>
                            </div>
                            <label for="Email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="contactemail" name="contactemail"
                                    placeholder="example@example.com" onkeypress='' autocomplete="off">
                                    <small id="contactemailcheck" style="color: red;">required</small>
                            </div>
                        </div>
                    </div>
                    <div id="keengroup" class="dropdwn">
                        <br/> <h5>next of keen</h5>
                        <div class="form-group row"> 
                            <label for="FirstName" class="col-sm-2 form-control-label">First Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="keenfirstname" name="keenfirstname"
                                    placeholder="First Name" autocomplete="off" >
                                    <small id="keenfirstnamecheck" style="color: red;">required</small>
                                </div> 
                                <label for="LastName" class="col-sm-2 form-control-label">Last Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="keenlastname" name="keenlastname"
                                    placeholder="Last Name" autocomplete="off" >
                                    <small id="keenlastnamecheck" style="color: red;">required</small>
                                </div> 
                        </div>
                        <div class="form-group row">
                            <label for="Cell" class="col-sm-2 col-form-label">Cell </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="keencell" 
                                    name="keencell" placeholder="Cell"  autocomplete="off" > 
                                    <small id="keencellcheck" style="color: red;">required</small>  
                                </div>
                                <label for="Email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="keenemail" 
                                    name="keenemail" placeholder="example@example.com" onkeypress=''
                                    autocomplete="off" >
                                    <small id="keenemailcheck" style="color: red;"></small>
                                </div>
                        </div>
                    </div> 
                    <div class="form-group row">
                        @if (in_array(1,$arraycontrolids))
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-add-tenant" >submit</button>
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