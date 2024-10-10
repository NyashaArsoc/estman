@php
$title = 'View Landlord';
$description = 'below are landlord details .';
$id= Crypt::encrypt($landlord->id);
$divindividualclass = $landlord->clienttypeid == 1 ? 'hide': 'dropdwn';
$divcompanyclass = $landlord->clienttypeid != 1 ? 'hide': 'dropdwn';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Approval')
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
        <li class="breadcrumb-item"><a href="{{ route('dash.property') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('propma.landlist') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$landlord->description ?? '' }}</span><hr/>
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="landlord-detail-tab" data-toggle="tab" href="#landlord-detail" role="tab" aria-controls="landlord-detail" aria-selected="true">Landlord Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="landlord-contact-tab" data-toggle="tab" href="#landlord-contact" role="tab" aria-controls="landlord-contact" aria-selected="true">Contact Person</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="banking-info-tab" data-toggle="tab" href="#banking-info" role="tab" aria-controls="banking-info" aria-selected="false">Banking Details</a>
            </li>
        </ul>
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="landlord-detail" role="tabpanel" aria-labelledby="landlord-detail-tab">
                <br/><form class="form-material material-primary" id="" method="POST" id="defaultform"
                action="{{ route('propma.updtland', $id) }}">@csrf
                <br/>
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
                            <input type="text" class="form-control" id="" name="tinnumber"
                            value="{{ $landlord->tinnumber ?? ''}}" autocomplete="off">
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
                <div class="form-group row">
                    @if (in_array(2,$arraycontrolids))
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-edit-landlord" >submit</button>
                    </div>
                    @endif
                </div>
            </form>
            </div>
            <div class="tab-pane show" id="landlord-contact" role="tabpanel" aria-labelledby="landlord-contact-tab">
                <h5 class="mt-2">Contact</h5>
                    @if (in_array(1,$arraycontrolids))
                    <a  class="btn btn-primary btn-sm" href="{{route('propin.addlandcont', $id)}}
                    " title="add">create new</a>
                    @endif<hr/>
                <table  class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No </th> <th>Name</th> <th>Cell</th><th>Email</th><th>Status </th><th>Option </th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($contact as $abc)
                        <tr>
                           @php
                           $contactid= Crypt::encrypt($abc->id);
                               if (trim($abc->available) == 'Y'){
                                    $status = 'available';
                                    $badge = "badge badge-pill bg-success badge-secondary";
                                    $buttonedit = '<a class="btn btn-secondary btn-sm"  href="' . route('propma.editlandcon',[$id,$contactid]) . '"
                                     title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>';
                                }else if (trim($abc->available) == 'D'){//include the deleted status
                                    $status = 'deleted';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                    $buttonedit = '';
                                }else{
                                if (trim($abc->approval) == 'R'){ 
                                    $status = 'rejected';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                }else{
                                    $status = 'inactive';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                }
                                $buttonedit = '';
                             }
                           @endphp
                            <td>{{$count ++}}</td><td>{{ $abc->lastname }} {{ $abc->firstname ?? ''}}</td>
                            <td>{{ $abc->cell }}</td><td>{{ $abc->email }}</td>
                            <td><span class="{{ $badge }}">{{$status}}</span></td> 
                            <td>@if (in_array(2,$arraycontrolids)){!! $buttonedit !!} @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="banking-info" role="tabpanel" aria-labelledby="banking-info-tab">
                <h5 class="mt-2">Banking</h5><hr/>
                <div class="table-responsive">
                    <table  class="datatable table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No </th> <th>Account Name</th> <th>Bank Name</th><th>Branch </th>
                                <th>Account Number </th><th>Currency </th>
                            </tr>
                        </thead>
                        <tbody>@php $count=1;@endphp
                            @foreach($bank as $abc)
                            <tr>
                               
                                <td>{{$count ++}}</td><td>{{ $abc->accountname }}</td><td>{{ $abc->bankname }}</td>
                                <td>{{ $abc->branch }}</td> <td>{{ $abc->accountnumber }}</td><td>{{ $abc->currencycode }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><br/>
        @include('layout.arlet')
        </form>
    </div>
</div>
<!-- Content End -->
@endsection
@section('additional js')
<script src="{{ asset('js/validation/intakepropman.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
    <!-- Additional JS End-->
@endsection
