@php 
$title = 'Add Currency';
$description = 'add currency type to the system...'; @endphp
@extends('layout.setup-main-menu')
@section('title', 'Add Currency')

@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.setup')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="defaultform" method="POST"
                action="{{ route('setin.addnewcurr') }}">@csrf

                <div class="form-group row">
                    <label for="currencycode" class="col-sm-2 form-control-label">Currency Code
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="currencycode" name="currencycode"
                            placeholder="ZWL" autocomplete="off">
                    <small id="currencycodecheck" style="color: red;">required</small>
                    </div>
                </div>
                <div class="form-group row">
                @if (in_array(1,$arraycontrolids))
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-submit-currency" >
                        submit</button>
                </div> @endif
                </div>
                @include('layout.arlet')
            </form>
        </div>
    </div>
    <!-- Content End-->

@endsection
@section('additional js')
<script src="{{ asset('js/validation/intake-setup.js') }}"></script>
    <!-- Additional JS End-->
@endsection
