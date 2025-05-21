@php
$title = 'Property Rent-rolls';
$description = 'list of all properties for monthly rent-roll...';
@endphp
@extends('layout.propman-main-menu')
@section('title', 'Rent-roll List')
@section('additional css')
<!-- Additional css Start-->
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
<!-- Additional css End-->
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{$title}}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{$title}}</h5>
        <p class="font-90 text-muted mb-1"> {{$description}}</p>
        <div class="table-responsive">
            <hr />
            <table class="datatable table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Landlord</th>
                        <th>Property Address</th>
                        <th>Currency</th>
                        <th>Billed</th>
                        <th>Period</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($remit as $abc)
                    <tr>
                        <td>{{$count ++}}</td>
                        <td>{{ $abc->companyname}} {{ $abc->fullname}}</td>
                        <td>{{ $abc->propertyaddress }}</td>
                        <td>{{ $abc->currencycode }}</td>
                        <td>{{ number_format($abc->totalbilled, 2, '.', ',');}}</td>
                        <td>{{ $abc->period }}</td>
                        <td>@php $id= Crypt::encrypt($abc->id)@endphp
                            @if (in_array(3,$arraycontrolids))<a class="btn btn-info btn-sm" id=""
                                href="{{route('propin.viewpreroll',$id)}}"
                                title="view"><i class="ti-eye mr-0-5"></i>view</a> @endif
                            @if (in_array(3,$arraycontrolids))<a class="btn btn-secondary btn-sm"
                                onclick="rentsummary(this); return false;"
                                href="{{route('propin.downrentsum',$id)}}"
                                title="view"><i class="ti-download mr-0-5"></i>download</a> @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Landlord</th>
                        <th>Property Address</th>
                        <th>Currency</th>
                        <th>Billed</th>
                        <th>Period</th>
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
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script>
<!-- Additional JS End-->
@endsection