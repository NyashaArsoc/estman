@php
$title = 'Approve Landlord';
$description = 'below are landlord details .';
$id= Crypt::encrypt($landlord->id);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Approval')
@section('additional css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2/select2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.property') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('propapp.listland') }}">List</a></li>
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
        <form class="form-material material-primary" id="defaultform" method="POST"
                action="{{ route('propdec.landdec', $id)}}">@csrf
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="landlord-detail" role="tabpanel" aria-labelledby="landlord-detail-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $landlord->fullname ?? ''}}  {{ $landlord->companyname ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Registration:</strong></td>
                            <td>{{ $landlord->companynumber ?? '' }}  {{ $landlord->nationalid ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Tin Number:</strong></td>
                            <td>{{ $landlord->tinnumber ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Vat Number:</strong></td>
                            <td> {{ $landlord->vatnumber ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Cell:</strong></td>
                            <td> {{ $landlord->cell ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $landlord->email ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Tel:</strong></td>
                            <td>{{ $landlord->tel ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Billing Address:</strong></td>
                            <td>{{ $landlord->contactaddress ?? ''}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane show" id="landlord-contact" role="tabpanel" aria-labelledby="landlord-contact-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Contact Name:</strong></td>
                            <td>{{ $contact->lastname ?? ''}} {{ $contact->firstname ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Cell:</strong></td>
                            <td>{{ $contact->cell ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $contact->email ?? ''}} </td>
                        </tr>
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
        <div class="form-group row">
            <label for="Email" class="col-sm-2 col-form-label">Reason for decline
            </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="reasons_comments" 
                id="rejectreason" />
                <small id="rejectreasoncheck" style="color: red;"> reasons for rejection</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-4">@if (in_array(5,$arraycontrolids))
                <a onclick = "approveentry(this); return false;" class="btn btn-success btn-sm" 
                href="{{route('propapp.landapprove', $id)}}"title="approve">
                <i class="ti-check mr-0-5"></i>approve</a> @endif
                @if (in_array(6,$arraycontrolids)) <button type="submit" class="btn btn-danger btn-sm" 
                id="btn-reject-entry" onclick = "rejectapproval(this); return false;">
                <i class="ti-close mr-0-5"> </i>decline</button> @endif
            </div>
        </div>
        </form>
    </div>
</div>
<!-- Content End -->
@endsection
@section('additional js')
<script src="{{ asset('js/validation/approvalpropman.js') }}"></script>
<script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
@endsection
