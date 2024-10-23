@php
$title = 'Approve Tenant';
$description = 'below are tenant details .';
$id= Crypt::encrypt($tenant->id);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Approval')
@section('additional css')
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.property') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('propapp.listten') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$tenant->clienttype ?? '' }}</span><hr/>
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tenant-detail-tab" data-toggle="tab" href="#tenant-detail" role="tab" aria-controls="tenant-detail" aria-selected="true">Tenant Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tenant-contact-tab" data-toggle="tab" href="#tenant-contact" role="tab" aria-controls="tenant-contact" aria-selected="true">Contact Person</a>
            </li>
        </ul>
        <form class="form-material material-primary" id="defaultform" method="POST"
                action="{{ route('propdec.tendec', $id)}}">@csrf
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="tenant-detail" role="tabpanel" aria-labelledby="tenant-detail-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $tenant->fullname ?? ''}}  {{ $tenant->companyname ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Registration:</strong></td>
                            <td>{{ $tenant->companynumber ?? '' }}  {{ $tenant->nationalid ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Tin Number:</strong></td>
                            <td>{{ $tenant->tinnumber ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Vat Number:</strong></td>
                            <td> {{ $tenant->vatnumber ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Cell:</strong></td>
                            <td> {{ $tenant->cell ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $tenant->email ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Tel:</strong></td>
                            <td>{{ $tenant->tel ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Billing Address:</strong></td>
                            <td>{{ $tenant->contactaddress ?? ''}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane show" id="tenant-contact" role="tabpanel" aria-labelledby="tenant-contact-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Operator Name:</strong></td>
                            <td>{{ $keen->operatorid ?? ''}} {{ $contact->operatorid ?? ''}} 
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Contact Name:</strong></td>
                            <td>{{ $keen->lastname ?? ''}} {{ $keen->firstname ?? ''}} 
                                {{ $contact->lastname ?? ''}} {{ $contact->firstname ?? ''}}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Cell:</strong></td>
                            <td>{{ $keen->cell ?? ''}} {{ $contact->cell ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $keen->email ?? ''}} {{ $contact->email ?? ''}}</td>
                        </tr>
                    </tbody>
                </table>
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
                href="{{route('propapp.tenappv', $id)}}"title="approve">
                <i class="ti-check mr-0-5"></i>approve</a> @endif
                @if (in_array(6,$arraycontrolids)) <button type="submit" class="btn btn-danger btn-sm" 
                id="btn-reject-entry" onclick = "rejectapproval(this); return false;">
                <i class="ti-close mr-0-5"> </i>decline</button> @endif
            </div>
        </div>
        @include('layout.arlet')
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
