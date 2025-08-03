@php
$title = 'Edit Tenant Keen';
$description = 'update next of keen details...';
$id= Crypt::encrypt($tenant->id);
$contactid= Crypt::encrypt($contact->id);
$divindividualclass = $tenant->clienttypeid == 1 ? 'hide': 'dropdwn';
$divcompanyclass = $tenant->clienttypeid != 1 ? 'hide': 'dropdwn';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Edit Tenant')
@section('additional css')
<!-- Additional css Start-->
<!-- Additional css End-->
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('propma.tenalist') }}">List</a></li>
        <li class="breadcrumb-item"><a href="{{ route('propma.edittena',$id) }}">View/Edit</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$tenant->description ?? '' }}</span>
        <hr />
        <form class="form-material material-primary" id="" method="POST" id="defaultform"
            action="{{ route('propma.updatenacon', [$id,$contactid]) }}">@csrf

            <div id="corporategroup">
                <div class="form-group row">
                    <label for="CompanyName" class="col-sm-2 form-control-label">Tenant Name</label>
                    <div class="col-sm-4">
                        {{ $tenant->lastname ?? ''}} {{ $tenant->firstname ?? ''}}
                        {{ $tenant->companyname ?? ''}}
                    </div>
                </div>
            </div>
            <br />
            <h5>contact person </h5>
            <div class="form-group row">
                <label for="FirstName" class="col-sm-2 form-control-label">First Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="contactfirstname"
                        name="contactfirstname" value="{{ $contact->firstname ?? ''}}" autocomplete="off">
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
                    <button type="submit" class="btn btn-primary" id="btn-add-landlord-contact">submit</button>
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
<!-- Additional JS End-->
@endsection