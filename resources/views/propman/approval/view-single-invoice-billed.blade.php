@php
$title = 'Profoma Invoice ';
$description = 'invoice to be generated...';
$id= Crypt::encrypt($invoice->id);
$lid= Crypt::encrypt($lease->id);
$totalbilled = ($invoice->rental + $invoice->rates + $invoice->operationalcost +
$invoice->balancebd + $invoice->interest + $invoice->vat);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Profoma')
@section('additional css')
<!-- Additional css Start-->
<!-- Additional css End-->
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('propapp.listpre')}}">Pending</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $invoice->currencycode.' - '.$title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <form class="form-material material-primary" action="{{ route('propapp.preapp',$id) }}"
            id="defaultform" method="POST"> @csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Tenant Name</label>
                <div class="col-sm-4">
                    <big style="color: rgb(19, 17, 151);">{{ $invoice->fullname }} {{ $invoice->companyname }}</big>
                </div>
                <label for="" class="col-sm-2 form-control-label">Property Des</label>
                <div class="col-sm-4">
                    <big style="color: rgb(19, 17, 151);">{{ $invoice->propertydescription }} </big>
                </div>
            </div>
            <div class="form-group row">
                <label for="ClientType" class="col-sm-2 form-control-label">Period</label>
                <div class="col-sm-4">
                    <big style="color: rgb(19, 17, 151);">{{\Carbon\Carbon::createFromTimestamp(strtotime
                            ($invoice->period))->format('M-Y')}} </big>
                </div>
            </div>
            <div class="form-group row">
                <label for="Type" class="col-sm-2 form-control-label">Deposit Paid</label>
                <div class="col-sm-2">
                    <big style="color: rgb(19, 17, 151);">{{ number_format($invoice->deposit,2) }} </big>
                </div>
            </div><br />
            <h5>rental information </h5>
            <div class="form-group row">
                <label for="City" class="col-sm-2 col-form-label">Balance b/f</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" value="{{ $invoice->balancebd }}" @readonly(true)>
                </div>
                <div class="col-sm-2">
                </div>
            </div>
            <div class="table-responsive" style="margin-top: 15px;">
                <table class="table table-bordered table-hover" id="leaseitems">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Item Description</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Options</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        <tr>
                            <td>{{$count ++}}</td>
                            <td><i>Rental</i></td>
                            <td>{{ number_format($invoice->rental,2) }}</td>
                            <td><a class="btn btn-secondary btn-sm"
                                    href="{{route('propdec.editpre', $id)}}"
                                    title="edit"><i class="ti-pencil mr-0-5"></i>Edit</a> </td>
                        </tr>
                        <tr>
                            <td>{{$count ++}}</td>
                            <td><i>Rates & Levies</i></td>
                            <td>{{ number_format($invoice->rates,2) }}</td>
                            <td><a class="btn btn-secondary btn-sm"
                                    href="{{route('propdec.editpre', $id)}}"
                                    title="edit"><i class="ti-pencil mr-0-5"></i>Edit</a> </td>
                        </tr>
                        <tr>
                            <td>{{$count ++}}</td>
                            <td><i>Operational Costs</i></td>
                            <td>{{ number_format($invoice->operationalcost,2) }}</td>
                            <td><a class="btn btn-secondary btn-sm"
                                    href="{{route('propdec.editpre', $id)}}"
                                    title="edit"><i class="ti-pencil mr-0-5"></i>Edit</a></td>
                        </tr>
                        <tr>
                            <td>{{$count ++}}</td>
                            <td><i>Interest Charged</i></td>
                            <td>{{ number_format($invoice->interest,3) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{$count ++}}</td>
                            <td><i>VAT on Rent</i></td>
                            <td>{{ number_format($invoice->vat,3) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong><i>Total Billed</i></strong> </td>
                            <td>{{ number_format($totalbilled,2) }}</td>
                            <td> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-edit-pro">approve</button>
                </div>
            </div>
            @include('layout.arlet')
        </form>
    </div>
</div>
<!-- Content End-->
@endsection
@section('additional js')
<!-- Additional JS Start-->
<script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script>
<script src="{{ asset('js/validation/approvalpropman.js') }}"></script>
<!-- Additional JS End-->
@endsection