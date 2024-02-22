@php
    $title = 'Edit Profoma';
    $description = 'invoice to be generated...';
    if ($invoice->clienttypeid == 1){
    $tname   =  $invoice->fullname ;
   }else{
     $tname   =  $invoice->companyname ;
 } 
 $id= Crypt::encrypt($invoice->id);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Profoma')
@section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
    <script src="{{ asset('js/dropdown-get-data.js') }}"></script>
@endsection
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('invoice.listpre')}}">Pending</a></li>
            <li class="breadcrumb-item"><a href="{{route('invoice.viewpro', $id)}}">Profoma Invoice</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $invoice->currencycode.' - '.$tname }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" action="{{ route('invoice.updateviewpro', $id) }}"
            method="PUT"> @csrf

                <div class="form-group row">
                    <label for="ClientType" class="col-sm-2 form-control-label">Period</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control"value="{{\Carbon\Carbon::createFromTimestamp(strtotime
                            ($invoice->period))->format('M-Y')}}" @readonly(true)>
                    </div>
                        <label for="Type" class="col-sm-2 form-control-label">Deposit Paid</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control"value="{{ number_format($invoice->deposit,2) }}"
                            @readonly(true)>
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
                    <td><input type="text" class="form-control" id="Rental"
                        name="Rental" value="{{ floatval($invoice->rental) }}"/>
                        <small id="proitemrentcheck" style="color: red;">  </small></td>                                      
                    </tr>  
                    <tr>
                        <td>{{$count ++}}</td>
                        <td><i>Rates & Levies</i></td>
                        <td><input type="text" class="form-control" id="RatesLevies"
                            name="RatesLevies" value="{{ floatval($invoice->rates) }}"/>
                            <small id="proitemratecostcheck" style="color: red;">  </small> </td>                                      
                        </tr>
                        <tr>
                            <td>{{$count ++}}</td>
                            <td><i>Operational Costs</i></td>
                            <td><input type="text" class="form-control"id="OperationCosts"
                                name="OperationCosts" value="{{ floatval($invoice->operationalcost) }}"/>
                                <small id="proitemoperationcostcheck" style="color: red;">  </small></td>                                      
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong><i>Total</i></strong> </td>
                                <td>
                                    <small id="proitemtotalbilledcheck" style="color: rgb(218, 12, 12));">  </small></td>                                    
                                </tr>
                </tbody>
            </table>
            
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-edit-pro" value="{{ $title }}">
                    {{ $title }}</button>

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
    <script src="{{ asset('js/validation/invoice.js') }}"></script> 
    <!-- Additional JS End-->
@endsection
