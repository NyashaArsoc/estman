@php
$title = 'Diary Reports';
@endphp

@extends('layout.propman-main-menu')
@section('title', $title)

@section('additional css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .report-tile {
        background-color: #0d6efd;
        color: #fff;
        padding: 1rem;
        border-radius: 0.5rem;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        height: 120px;
        width: 100%;
        max-width: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .report-tile:hover {
        background-color: #0b5ed7;
    }
    .report-header-tile {
        padding: 0.75rem 1rem;
        cursor: pointer;
    }
    .report-header-tile h2 {
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }
    .report-header-tile h6 {
        font-size: 0.9rem;
        text-transform: uppercase;
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Diary Reports Access Box -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="box box-block tile tile-2 bg-primary mb-2"
                 data-bs-toggle="collapse"
                 data-bs-target="#diaryReportsGroup"
                 aria-expanded="false"
                 aria-controls="diaryReportsGroup"
                 style="cursor: pointer;">
                <div class="t-icon right"></div>
                <div class="t-content text-center">
                    <h2 class="mb-1"><i class="ti-book"></i></h2>
                    <h6 class="text-uppercase">Diary Reports</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Collapsible Diary Reports Group -->
    <div class="collapse" id="diaryReportsGroup">
        <div class="row g-4">

            <!-- LANDLORD DIARY -->
            <div class="col-md-6">
                <div class="card shadow-sm border-left-warning">
                    <div class="card-header bg-warning text-white report-header-tile" id="headingLandlord"
                         data-bs-toggle="collapse"
                         data-bs-target="#collapseLandlord"
                         aria-expanded="false"
                         aria-controls="collapseLandlord">
                        <h2><i class="ti-user"></i></h2>
                        <h6>Landlord Diary</h6>
                    </div>
                    <div id="collapseLandlord" class="collapse" aria-labelledby="headingLandlord">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><a href="{{ route('report.diary.landlord.approval') }}">Approval History</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.landlord.onboarding') }}">Onboarding Timeline</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.landlord.status') }}">Status Changes</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.landlord.summary') }}">Summary by Date</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.landlord.acquisition') }}">Property Acquisition</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.landlord.tenants') }}">Linked Tenants</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.landlord.remittance') }}">Remittance Log</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TENANT DIARY -->
            <div class="col-md-6">
                <div class="card shadow-sm border-left-primary">
                    <div class="card-header bg-primary text-white report-header-tile" id="headingTenant"
                         data-bs-toggle="collapse"
                         data-bs-target="#collapseTenant"
                         aria-expanded="false"
                         aria-controls="collapseTenant">
                        <h2><i class="ti-id-badge"></i></h2>
                        <h6>Tenant Diary</h6>
                    </div>
                    <div id="collapseTenant" class="collapse" aria-labelledby="headingTenant">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><a href="{{ route('report.diary.tenant.registration') }}">Registration Timeline</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.tenant.linkage') }}">Lease Linkage</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.tenant.next-of-kin') }}">Next of Kin</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.tenant.contact') }}">Contact Changes</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.tenant.payment') }}">Payment Log</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.tenant.status') }}">Status Changes</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PROPERTY DIARY -->
            <div class="col-md-6">
                <div class="card shadow-sm border-left-success">
                    <div class="card-header bg-success text-white report-header-tile" id="headingProperty"
                         data-bs-toggle="collapse"
                         data-bs-target="#collapseProperty"
                         aria-expanded="false"
                         aria-controls="collapseProperty">
                        <h2><i class="ti-home"></i></h2>
                        <h6>Property Diary</h6>
                    </div>
                    <div id="collapseProperty" class="collapse" aria-labelledby="headingProperty">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><a href="{{ route('report.diary.property.registration') }}">Registration Timeline</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.property.transfers') }}">Ownership Transfers</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.property.occupancy') }}">Occupancy Changes</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.property.maintenance') }}">Maintenance Logs</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.property.commission') }}">Commission Adjustments</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.property.location') }}">Location Updates</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LEASE DIARY -->
            <div class="col-md-6">
                <div class="card shadow-sm border-left-secondary">
                    <div class="card-header bg-secondary text-white report-header-tile" id="headingLease"
                         data-bs-toggle="collapse"
                         data-bs-target="#collapseLease"
                         aria-expanded="false"
                         aria-controls="collapseLease">
                        <h2><i class="ti-file"></i></h2>
                        <h6>Lease Diary</h6>
                    </div>
                    <div id="collapseLease" class="collapse" aria-labelledby="headingLease">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><a href="{{ route('report.diary.lease.creation') }}">Creation Log</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.lease.validity') }}">Validity Changes</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.lease.renewal') }}">Renewal History</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.lease.uploads') }}">Signed Uploads</a></li>
                                <li class="list-group-item"><a href="{{ route('report.diary.lease.financial') }}">Financial Events</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('additional js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
