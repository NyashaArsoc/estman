@php
$title = 'Edit Tenant';
$description = 'below are tenant details .';
$id= Crypt::encrypt($tenant->id);
if ($tenant->clienttypeid == 1){
$tenanttab =' <li class="nav-item"> <a class="nav-link" id="tenant-keen-tab" data-toggle="tab"
        href="#tenant-keen" role="tab" aria-controls="tenant-keen" aria-selected="true">Next of Keen</a> </li>';
}else{
$tenanttab = '<li class="nav-item"><a class="nav-link" id="tenant-contact-tab"
        data-toggle="tab" href="#tenant-contact" role="tab" aria-controls="tenant-contact" \
        aria-selected="true">Contact Person</a> </li>';
}
$divindividualclass = $tenant->clienttypeid == 1 ? 'hide': 'dropdwn';
$divcompanyclass = $tenant->clienttypeid != 1 ? 'hide': 'dropdwn';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Edit Tenant')
@section('additional css')
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.property') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('propma.tenalist') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$tenant->description ?? '' }}</span>
        <hr />
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tenant-detail-tab" data-toggle="tab" href="#tenant-detail" role="tab" aria-controls="tenant-detail" aria-selected="true">Tenant Details</a>
            </li>
            {!! $tenanttab !!}
        </ul>
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="tenant-detail" role="tabpanel" aria-labelledby="tenant-detail-tab">
                <br />
                <form class="form-material material-primary" method="POST" id="defaultform"
                    action="{{ route('propma.updttena', $id) }}">@csrf
                    <br />
                    <div id="individualgroup" class="{{$divindividualclass}}">
                        <input type="text" class="form-control" id="clienttype" hidden
                            value="{{ $tenant->clienttypeid ?? ''}}" readonly>
                        <div class="form-group row">
                            <label for="FirstName" class="col-sm-2 form-control-label">First Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    value="{{ $tenant->firstname ?? ''}}" autocomplete="off">
                                <small id="firstnamecheck" style="color: red;">required</small>
                            </div>
                            <label for="LastName" class="col-sm-2 form-control-label">Last Name
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    value="{{ $tenant->lastname ?? ''}}" autocomplete="off">
                                <small id="lastnamecheck" style="color: red;">required</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="NationalIDNumber" class="col-sm-2 col-form-label">National ID
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nationalid" name="nationalid"
                                    value="{{ $tenant->nationalid ?? '' }}" autocomplete="off">
                                <small id="nationalidcheck" style="color: red;">required</small>
                            </div>
                        </div>
                    </div>
                    <div id="corporategroup" class="{{$divcompanyclass}}">
                        <div class="form-group row">
                            <label for="CompanyName" class="col-sm-2 form-control-label">Company Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="companyname" name="companyname"
                                    value="{{ $tenant->companyname ?? ''}}" autocomplete="off">
                                <small id="companynamecheck" style="color: red;">required</small>
                            </div>
                            <label for="" class="col-sm-2 form-control-label">Company Number
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="companynumber" name="companynumber"
                                    value="{{ $tenant->companynumber ?? ''}}" autocomplete="off">
                                <small id="companynumbercheck" style="color: red;">required</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="VATNumber" class="col-sm-2 form-control-label">VAT Number</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="numericnotrequired" name="vatnumber"
                                    value="{{ $tenant->vatnumber ?? ''}}" autocomplete="off">
                                <small id="numericnotrequiredcheck" style="color: red;"></small>
                            </div>
                            <label for="" class="col-sm-2 form-control-label">TIN Number</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="" name="tinnumber"
                                    value="{{ $tenant->tinnumber ?? ''}}" autocomplete="off">
                                <small id="numericnotrequiredcheck" style="color: red;"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Cell" class="col-sm-2 col-form-label">Cell
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cell" name="cell"
                                value="{{ $tenant->cell ?? ''}}" autocomplete="off">
                            <small id="cellcheck" style="color: red;">required</small>
                        </div>
                        <label for="Tel" class="col-sm-2 col-form-label">Tel</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="Tel" name="tel"
                                value="{{ $tenant->tel ?? ''}}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ContactAddress" class="col-sm-2 col-form-label">Contact Address</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="billingaddress" name="billingaddress"
                                value="{{ $tenant->contactaddress ?? ''}}">
                            <small id="billingaddresscheck" style="color: red;">required</small>
                        </div>
                        <label for="Email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ $tenant->email ?? ''}}" autocomplete="off">
                            <small id="emailcheck" style="color: red;">required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        @if (in_array(2,$arraycontrolids))
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-edit-landlord">submit</button>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="tab-pane show" id="tenant-contact" role="tabpanel" aria-labelledby="tenant-contact-tab">
                <h5 class="mt-2">Contact</h5>
                @if (in_array(1,$arraycontrolids))
                <a class="btn btn-primary btn-sm" href="{{route('propin.addtencon', $id)}}
                " title="add">create new</a>
                @endif
                <hr />
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No </th>
                            <th>Name</th>
                            <th>Cell</th>
                            <th>Email</th>
                            <th>Status </th>
                            <th>Option </th>
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
                            $buttonedit = '<a class="btn btn-secondary btn-sm" href="' . route('propma.edittencon',[$id,$contactid]) . '"
                                title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>';
                            $buttondisable = '<a class="btn btn-danger btn-sm"
                                href="' . route('propdec.distencon',[$id,$contactid]) . '" title="disable"
                                onclick="deactivaterecord(this); return false;"><i class="ti-close 
                                      mr-0-5"></i>disable</a>';
                            }else if (trim($abc->available) == 'D'){//include the deleted status
                            $status = 'deleted';
                            $badge = 'badge badge-pill bg-danger badge-secondary';
                            $buttonedit = '';
                            $buttondisable = '';
                            }else{
                            $status = 'inactive';
                            $badge = 'badge badge-pill bg-danger badge-secondary';
                            $buttonedit = '';
                            $buttondisable = '';
                            }
                            @endphp
                            <td>{{$count ++}}</td>
                            <td>{{ $abc->lastname }} {{ $abc->firstname ?? ''}}</td>
                            <td>{{ $abc->cell }}</td>
                            <td>{{ $abc->email }}</td>
                            <td><span class="{{ $badge }}">{{$status}}</span></td>
                            <td>@if (in_array(2,$arraycontrolids)){!! $buttonedit !!} @endif
                                @if (in_array(7,$arraycontrolids)){!! $buttondisable !!} @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane show" id="tenant-keen" role="tabpanel" aria-labelledby="tenant-keen-tab">
                <h5 class="mt-2">Next of Keen</h5>
                @if (in_array(1,$arraycontrolids))
                <a class="btn btn-primary btn-sm" href="{{route('propin.addtenkeen', $id)}}
                    " title="add">create new</a>
                @endif
                <hr />
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No </th>
                            <th>Name</th>
                            <th>Cell</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Option </th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($keen as $abc)
                        <tr>
                            @php
                            $status = 'available';
                            $badge = "badge badge-pill bg-success badge-secondary";
                            $contactid= Crypt::encrypt($abc->id);
                            @endphp
                            <td>{{$count ++}}</td>
                            <td>{{ $abc->lastname }} {{ $abc->firstname ?? ''}}</td>
                            <td>{{ $abc->cell }}</td>
                            <td>{{ $abc->email }}</td>
                            <td><span class="{{ $badge }}">{{$status}}</span></td>
                            <td><a class="btn btn-secondary btn-sm" href="{{route('propma.edittenkeen',[$id,$contactid])}}"
                                    title="edit"><i class="ti-pencil mr-0-5"></i>edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><br />
        @include('layout.arlet')
    </div>
</div>
<!-- Content End -->
@endsection
@section('additional js')
<!-- Additional JS End-->
<script src="{{ asset('js/validation/intakepropman.js') }}"></script>
@endsection