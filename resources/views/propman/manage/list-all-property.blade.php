@php
$title = 'Manage Property';
$description = 'list of all properties...'; 
@endphp
@extends('layout.propman-main-menu')
@section('title', 'Manage Property')
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{ route('dash.property') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <div class="table-responsive">
                <hr />
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Landlord</th>
                            <th>Type</th>
                            <th>Currency</th>
                            <th>Location</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach ($property as $abc)
                            <tr>@php $id = Crypt::encrypt($abc->id);
                            if (trim($abc->available) == 'Y'){
                                        $status = 'available';
                                        $badge = "badge badge-pill bg-success badge-secondary";
                                        $buttondeactivate = '<a onclick = "deactivaterecord(this); 
                                        return false;" class="btn btn-warning btn-sm" href="' . route('propdec.disprop',$id) . '"
                                     title="disable"><i class="ti-close mr-0-5"></i>disable</a>';
                                     $buttonview = '<a class="btn btn-info btn-sm"  href="' . route('propma.viewprop',$id) . '"
                                     title="view"><i class="ti-eye mr-0-5"></i>view</a>';
                                     $buttonedit = '<a class="btn btn-secondary btn-sm"  href="' . route('propma.editprop',$id) . '"
                                     title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>';
                                    }else if (trim($abc->available) == 'D'){//include the deleted status
                                        $status = 'deleted';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        $buttondeactivate = '';
                                        $buttonview = '';
                                        $buttonedit = '';
                                    }else{
                                    if (trim($abc->approval) == 'R'){ 
                                        $status = 'rejected';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        $buttondeactivate = '';
                                        $buttonview = '';
                                        $buttonedit = '';
                                    }else{
                                        $status = 'inactive';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        $buttondeactivate ='';
                                        $buttonview = '';
                                        $buttonedit = '';
                                    }
                                 }
                                @endphp
                                <td>{{ $count++ }}</td>
                                <td>{{ $abc->fullname }} {{ $abc->companyname }}</td>
                                <td>{{ $abc->propertytype }}</td>
                                <td>{{ $abc->currencycode }}</td>
                                <td>{{ $abc->location }}</td>
                                <td>{{ $abc->streetaddress }}</td>
                                <td><span class="{{ $badge }}">{{ $status }}</span></td>
                                <td>
                                    {!! $buttonview !!} {!! $buttonedit !!}
                                    {!! $buttondeactivate !!}
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Landlord</th>
                            <th>Type</th>
                            <th>Currency</th>
                            <th>Location</th>
                            <th>Address</th>
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
