@php
$title = 'Allocate Property';
$description = 'select properties to allocate...';
@endphp
@extends('layout.no-menu-layout')
@section('title', $title)
@section('additional css')
<!--===============================================================================================-->
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.val')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('valin.addinstnorm')}}">Initiate</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">

        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5>Valuer Name: {{ $valuer->firstname }} {{ $valuer->lastname }}</h5>
                <p class="font-90 text-muted mb-1">Check the items you want to allocate</p>
            </div>
        </div>
        <form method="POST" id="defaultform" action="{{ route('valin.allonom') }}" />@csrf
        <div>
            <button type="submit" class="btn btn-primary" id="btn-allocate">Allocate
                <span id="selected-items-info"></span>
            </button>
        </div>
        <div class="table-responsive">
            <!-- <div class="alert alert-primary" id="selected-items-info" role="alert" style="display: none;"></div> -->
            <hr />
            <table class="datatable table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Property Type</th>
                        <th>Location </th>
                        <th>Street Address </th>
                        <th>Select <input type="checkbox" id="select-all"></th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 1; @endphp
                    @foreach($property as $abc)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $abc->propertytype }}</td>
                        <td>{{ $abc->town }}</td>
                        <td>{{ $abc->streetaddress }}</td>
                        <td>
                            <input type="checkbox" name="selectedids[]" value="{{ $abc->id }}" class="select-item">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Property Type</th>
                        <th>Location </th>
                        <th>Street Address </th>
                        <th>Select</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <input type="text" name="purpose" value="{{$purpose->description}}" hidden><input type="text"
            name="valtype" value="{{$valtype->description}}" hidden><input type="text" name="payment"
            value="{{$payment->description}}" hidden><input type="text" name="contact"
            value="{{$contact->id}}" hidden><input type="text" name="user" value="{{$valuer->id}}" hidden>
        <input type="text" name="allocateto" value="{{$valuer->username}}" hidden>
        <input type="text" name="accessdatetime" value="{{$access}}" hidden>
        </form>
        <!-- <div class="mt-3"></div> -->
        @include('layout.arlet')
    </div>
</div>
<!-- Content End-->
@endsection
@section('additional js')
<!-- Additional JS Start-->
<script src="{{ asset('js/validation/intakevaluation.js') }}"></script>
<script src="{{ asset('js/button-select-multiple.js') }}"></script>

<!-- Additional JS End-->
@endsection