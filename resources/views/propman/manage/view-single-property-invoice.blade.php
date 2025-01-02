@php
$title = 'Property Invoices';
$description = 'list of all tenants invoiced...'; 
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Manage Invoices')
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{ route('dash.property') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('propma.propinvo') }}">List</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <span class="badge badge-pill bg-info">{{ $property->streetaddress ?? ''}} : 
                {{$property->propertytype ?? '' }}</span><hr/>
            <div class="table-responsive">
                <hr />
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tenant</th>                          
                            <th>Invoices</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach ($tenant as $abc)
                            <tr>@php $tid = Crypt::encrypt($abc->tenantid);
                               $pid = Crypt::encrypt($abc->propertyid); @endphp
                                <td>{{ $count++ }}</td>
                                <td>{{ $abc->tenantfullname }} {{ $abc->tenantcompanyname }}</td>
                                <td>{{ $abc->totalinvoice ?? 0 }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm"  href="{{route('propma.viewteninvo',[$tid,$pid])}}"
                                     title="view"><i class="ti-eye mr-0-5"></i>view</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Tenant</th>                          
                            <th>Invoices</th>
                            <th>Option</th>
                        </tr>
                    </tfoot>
                </table>
                @include('layout.arlet')
            </div>
        </div>
    </div>
    <!-- Content End-->
@endsection
@section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script>
    <!-- Additional JS End-->
@endsection
