@php
$title = 'Rejected Property';
$description = 'list of all properties rejected...'; 
@endphp
@extends('layout.propman-main-menu')
@section('title', 'Rejected Properties')
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
                            <th>Reason</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach ($property as $abc)
                            <tr>@php $id = Crypt::encrypt($abc->id);@endphp
                                <td>{{ $count++ }}</td>
                                <td>{{ $abc->fullname }} {{ $abc->companyname }}</td>
                                <td>{{ $abc->propertytype }}</td>
                                <td>{{ $abc->currencycode }}</td>
                                <td>{{ $abc->location }}</td>
                                <td>{{ $abc->streetaddress }}</td>
                                <td>{{ $abc->reasons }}</td>
                                <td>    @if (in_array(2,$arraycontrolids))<a class="btn btn-secondary 
                                btn-sm view_landlord" id=""href="{{route('propdec.editviewprop', $id)}}"
                                 title="view"><i class="ti-pencil mr-0-5"></i>edit</a> @endif
                                 @if (in_array(4,$arraycontrolids))<a class="btn btn-danger btn-sm"
                                  onclick = "rejectapproval(this); return false;"
                                 id=""href="{{route('propdec.propdel', $id)}}"
                                 title="view"><i class="ti-close mr-0-5"></i>remove</a> @endif
                                    
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
                            <th>Reason</th>
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
