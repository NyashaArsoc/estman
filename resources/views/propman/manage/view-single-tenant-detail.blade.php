@php
$title = 'View Tenant';
$description = 'below are tenant details .';
$id= Crypt::encrypt($tenant->id);
if ($tenant->clienttypeid == 1){
    $tenanttab =' <li class="nav-item"> <a class="nav-link" id="tenant-keen-tab" data-toggle="tab" 
        href="#tenant-keen" role="tab" aria-controls="tenant-keen" aria-selected="true">Next of Keen</a>  </li>';
 }else{
    $tenanttab = '<li class="nav-item"><a class="nav-link" id="tenant-contact-tab" 
    data-toggle="tab" href="#tenant-contact" role="tab" aria-controls="tenant-contact" \
    aria-selected="true">Contact Person</a> </li>';
 }
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
        <li class="breadcrumb-item"><a href="{{ route('propma.tenalist') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$tenant->description ?? '' }}</span><hr/>
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tenant-detail-tab" data-toggle="tab" href="#tenant-detail" role="tab" aria-controls="tenant-detail" aria-selected="true">Tenant Details</a>
            </li>
            {!! $tenanttab !!}
            <li class="nav-item">
                <a class="nav-link" id="lease-info-tab" data-toggle="tab" href="#lease-info" role="tab" aria-controls="lease-info" aria-selected="false">Lease Details</a>
            </li>
        </ul>
        <form class="form-material material-primary" id="defaultform" method="POST"
                action="{{ route('propdec.landdec', $id)}}">@csrf
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
            <div class="tab-pane show" id="tenant-keen" role="tabpanel" aria-labelledby="tenant-keen-tab">
                <h5 class="mt-2">Contact</h5><hr/>
                <table  class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No </th> <th>Name</th> <th>Cell</th><th>Email</th><th>Status </th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($keen as $abc)
                        <tr>
                           @php
                           $status = 'available';
                           $badge = "badge badge-pill bg-success badge-secondary";
                           @endphp
                            <td>{{$count ++}}</td><td>{{ $abc->lastname }} {{ $abc->firstname ?? ''}}</td>
                            <td>{{ $abc->cell }}</td><td>{{ $abc->email }}</td>
                            <td><span class="{{ $badge }}">{{$status}}</span></td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="lease-info" role="tabpanel" aria-labelledby="lease-info-tab">
                <h5 class="mt-2">Lease</h5><hr/>
                <div class="table-responsive">
                    <table  class="datatable table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No </th> <th>Type</th><th>Property Description</th><th>Rental</th><th>Status </th>
                            </tr>
                        </thead>
                        <tbody>@php $count=1;@endphp
                            @foreach($lease as $abc)
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
                                <td>{{$count ++}}</td><td>{{ $abc->propertytype }}</td><td>{{ $abc->propertydescription }}</td>
                                <td>{{ $abc->currencycode }}{{ number_format($abc->rental,2) }}</td>
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
