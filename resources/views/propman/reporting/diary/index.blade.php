@php
$title = 'Diary Reports';
@endphp

@extends('layout.propman-main-menu')
@section('title', 'Diary Reports Dashboard')

@section('additional css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row" id="diaryAccordion">

        <!-- LANDLORD DIARY -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-left-warning">
                <div class="card-header bg-warning text-white" id="headingLandlord">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-white text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLandlord" aria-expanded="false" aria-controls="collapseLandlord">
                            <i class="bi bi-person-badge"></i> Landlord Diary
                        </button>
                    </h5>
                </div>
                <div id="collapseLandlord" class="collapse" aria-labelledby="headingLandlord" data-bs-parent="#diaryAccordion">
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

        <!-- PROPERTY DIARY -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-left-success">
                <div class="card-header bg-success text-white" id="headingProperty">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-white text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProperty" aria-expanded="false" aria-controls="collapseProperty">
                            <i class="bi bi-building"></i> Property Diary
                        </button>
                    </h5>
                </div>
                <div id="collapseProperty" class="collapse" aria-labelledby="headingProperty" data-bs-parent="#diaryAccordion">
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

        <!-- TENANT DIARY -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-left-primary">
                <div class="card-header bg-primary text-white" id="headingTenant">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-white text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTenant" aria-expanded="false" aria-controls="collapseTenant">
                            <i class="bi bi-person-lines-fill"></i> Tenant Diary
                        </button>
                    </h5>
                </div>
                <div id="collapseTenant" class="collapse" aria-labelledby="headingTenant" data-bs-parent="#diaryAccordion">
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

        <!-- LEASE DIARY -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-left-secondary">
                <div class="card-header bg-secondary text-white" id="headingLease">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-white text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLease" aria-expanded="false" aria-controls="collapseLease">
                            <i class="bi bi-file-earmark-text"></i> Lease Diary
                        </button>
                    </h5>
                </div>
                <div id="collapseLease" class="collapse" aria-labelledby="headingLease" data-bs-parent="#diaryAccordion">
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
@endsection

@section('additional js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
