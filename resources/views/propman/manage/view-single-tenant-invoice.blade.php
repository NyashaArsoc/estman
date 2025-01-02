@php
$title = 'Tenant Invoices';
$description = 'list of all tenant invoices...'; 
$id = Crypt::encrypt($property->id);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Tenant Invoices')
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{ route('dash.property') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('propma.propinvo') }}">List</a></li>
            <li class="breadcrumb-item"><a href="{{ route('propma.viewpropinvo',$id) }}">Tenant</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <span class="badge badge-pill bg-info">{{ $tenant->fullname ?? ''}}
                {{$tenant->companyname ?? '' }} : {{ $property->streetaddress ?? ''}}</span><hr/>
            <div class="table-responsive">
                <hr />
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Property Description</th>
                            <th>Valid To</th>                            
                            <th>Invoices</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach ($lease as $abc)
                            <tr>@php $id = Crypt::encrypt($abc->id);
                            if (trim($abc->available) == 'Y'){
                                        $status = 'available';
                                        $badge = "badge badge-pill bg-success badge-secondary";
                                    }else{
                                        $status = 'inactive';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                    }
                                @endphp
                                <td>{{ $count++ }}</td>
                                <td>{{ $abc->propertydescription }}</td>
                                <td>{{ $abc->validto }}</td>
                                <td>{{ $abc->totalinvoice ?? 0 }}</td>
                                <td><span class="{{ $badge }}">{{ $status }}</span></td>
                                <td>
                                    <a class="btn btn-info btn-sm"  href="{{route('propma.viewleainvo',$id)}}"
                                     title="view"><i class="ti-eye mr-0-5"></i>view</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Property Description</th>
                            <th>Valid To</th>                            
                            <th>Invoices</th>
                            <th>Status</th>
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
