@php
    $title = 'Edit Profoma';
    $description = 'update billed invoice to be generated...';
 $id= Crypt::encrypt($invoice->id);
 $vatrate    = (!is_null($vat)) ? $vat->rate : 0;
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
            <li class="breadcrumb-item"><a href="{{route('propapp.viewpre', $id)}}">Profoma Invoice</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $invoice->currencycode.' - '.$title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" action="{{ route('propdec.updtpre', $id) }}"
            method="PUT" id="defaultform"> @csrf

                <div class="form-group row">
                    <label for="ClientType" class="col-sm-2 form-control-label">Period</label>
                    <div class="col-sm-2">
                        <big style="color: rgb(19, 17, 151);">{{\Carbon\Carbon::createFromTimestamp(strtotime
                            ($invoice->period))->format('M-Y')}} </big>
                    </div>
                        <label for="Type" class="col-sm-2 form-control-label">Deposit Paid</label>
                        <div class="col-sm-2">
                            <big style="color: rgb(19, 17, 151);">{{ number_format($invoice->deposit,2) }} </big>
                        </div>
                </div>
        <h5>rental information </h5>
        <div class="table-responsive" style="margin-top: 15px;">
            <table class="table table-bordered table-hover" id="leaseitems">
                <thead>
                    <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Item Description</th>
                    <th class="text-center">Amount</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    <tr>
                    <td>{{$count ++}}</td>
                    <td><i>Rental</i></td>
                    <td><input type="text" class="form-control" id="rental"
                        name="rental" value="{{ floatval($invoice->rental) }}"/>
                        <input type="text" hidden id="percentrate" value="{{ $vatrate }}"/>
                        <small id="propitemrentcheck" style="color: red;">  </small></td>                                      
                    </tr>  
                    <tr>
                        <td>{{$count ++}}</td>
                        <td><i>Rates & Levies</i></td>
                        <td><input type="text" class="form-control" id="rateslevies"
                            name="rateslevies" value="{{ floatval($invoice->rates) }}"/>
                            <small id="propitemratecostcheck" style="color: red;">  </small> </td>                                      
                    </tr>
                    <tr>
                            <td>{{$count ++}}</td>
                            <td><i>Operational Costs</i></td>
                            <td><input type="text" class="form-control"id="operationcosts"
                                name="operationcosts" value="{{ floatval($invoice->operationalcost) }}"/>
                                <small id="propitemoperationcostcheck" style="color: red;">  </small></td>                                      
                    </tr>
                    <tr>
                        <td>{{$count ++}}</td>
                        <td><i>Interest Charged</i></td>
                        <td><input type="text" class="form-control"id="interest"
                            name="interest" value="{{ floatval($invoice->interest) }}" readonly/></td>                                      
                </tr>
                <tr>
                    <td>{{$count ++}}</td>
                    <td><i>VAT</i></td>
                    <td><input type="text" class="form-control"id="vat" readonly
                        name="vat" value="{{ floatval($invoice->vat) }}"/></td>                                      
            </tr>
                    <tr>
                                <td></td>
                                <td><strong><i>Total</i></strong> </td>
                                <td>
                                    <small id="propitemtotalbilledcheck" style="color: rgb(218, 12, 12));">  </small></td>                                    
                                </tr>
                </tbody>
            </table>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-edit-profoma"> submit</button>
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
    <script src="{{ asset('js/validation/approvalpropman.js') }}"></script>
    <!-- Additional JS End-->
@endsection
