@php 
$title = 'Add Lease Prepayment';
$description = 'update lease details...';
$id= Crypt::encrypt($lease->id);
 @endphp
@extends('layout.no-menu-layout')
@section('title', 'Add Prepay')
@section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
@endsection
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('propdec.listleadec') }}">List</a></li>
            <li class="breadcrumb-item"><a href="{{ route('propdec.editviewlea',$id) }}">View/Edit</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <span class="badge badge-pill bg-info">{{$lease->propertytype ?? '' }}</span><hr/>
            <form class="form-material material-primary" id="" method="POST" id="defaultform"
                action="{{ route('propin.addnewleaprepay', $id) }}">@csrf
               
                <div id="corporategroup">
                    <div class="form-group row">
                        <label for="CompanyName" class="col-sm-2 form-control-label">Tenant Name</label>
                        <div class="col-sm-4">
                            {{ $lease->tenantfullname ?? ''}} {{ $lease->tenantcompanyname ?? ''}}
                        </div>
                        <label for="CompanyName" class="col-sm-2 form-control-label">Property Description</label>
                        <div class="col-sm-4">
                            {{ $lease->propertydescription ?? ''}}
                        </div>
                    </div>
                </div>
                    <br />
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Currency</label>
                        <div class="col-sm-4">
                            <select class="js-example-basic-single w-100" name="currencycode" id="currencycode" />
                            <option value="">select currency </option>
                            @foreach ($currency as $abc)
                                <option value="{{ $abc->code }}"> {{ $abc->code }}
                                </option>
                            @endforeach
                            </select>
                            <small id="currencycodecheck" style="color: red;">required</small>
                        </div>
                   
                        <label for="" class="col-sm-2 form-control-label">Amount</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="leaseratescost" 
                            name="amount"  autocomplete="off">
                            <small id="leaseratescostcheck" style="color: red;"></small>
                        </div>
                    </div>
                <div class="form-group row">
                    @if (in_array(1,$arraycontrolids))
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-add-lease-prepay" >submit</button>
                    </div>
                    @endif
                </div>
                @include('layout.arlet')
            </form>
        </div>
    </div>
    <!-- Content End-->

@endsection
@section('additional js')
<script src="{{ asset('js/validation/intakepropman.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <!-- Additional JS End-->
@endsection
