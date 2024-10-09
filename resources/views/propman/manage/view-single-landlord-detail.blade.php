@php
$title = 'View Landlord';
$description = 'below are landlord details .';
$id= Crypt::encrypt($landlord->id);
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
            <li class="nav-item">
                <a class="nav-link" id="property-info-tab" data-toggle="tab" href="#property-info" role="tab" aria-controls="property-info" aria-selected="false">Property Details</a>
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
                <h5 class="mt-2">Contact</h5><hr/>
                <table  class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No </th> <th>Name</th> <th>Cell</th><th>Email</th><th>Status </th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($contact as $abc)
                        <tr>
                           @php
                               if (trim($abc->available) == 'Y'){
                                    $status = 'available';
                                    $badge = "badge badge-pill bg-success badge-secondary";
                                }else if (trim($abc->available) == 'D'){//include the deleted status
                                    $status = 'deleted';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                }else{
                                if (trim($abc->approval) == 'R'){ 
                                    $status = 'rejected';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                }else{
                                    $status = 'inactive';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                }
                             }
                           @endphp
                            <td>{{$count ++}}</td><td>{{ $abc->lastname }} {{ $abc->firstname ?? ''}}</td>
                            <td>{{ $abc->cell }}</td><td>{{ $abc->email }}</td>
                            <td><span class="{{ $badge }}">{{$status}}</span></td> 
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
            <div class="tab-pane fade" id="property-info" role="tabpanel" aria-labelledby="property-info-tab">
                <h5 class="mt-2">Property</h5><hr/>
                <div class="table-responsive">
                    <table  class="datatable table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No </th> <th>Type</th> <th>Address</th><th>Status </th>
                            </tr>
                        </thead>
                        <tbody>@php $count=1;@endphp
                            @foreach($property as $abc)
                            <tr>
                               @php
                                   if (trim($abc->available) == 'Y'){
                                        $status = 'available';
                                        $badge = "badge badge-pill bg-success badge-secondary";
                                    }else if (trim($abc->available) == 'D'){//include the deleted status
                                        $status = 'deleted';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                    }else{
                                    if (trim($abc->approval) == 'R'){ 
                                        $status = 'rejected';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                    }else{
                                        $status = 'inactive';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                    }
                                 }
                               @endphp
                                <td>{{$count ++}}</td><td>{{ $abc->propertytype }}</td><td>{{ $abc->streetaddress }}</td>
                                <td><span class="{{ $badge }}">{{$status}}</span></td> 
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
    <!-- Additional JS End-->
@endsection
