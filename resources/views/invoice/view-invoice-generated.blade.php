@php
    $title = 'Invoice ';
    $description = 'invoice generated...';
    if ($invoice->clienttypeid == 1){
    $tname   =  $invoice->fullname ;
   }else{
     $tname   =  $invoice->companyname ;
 } 
 $id= Crypt::encrypt($invoice->id);
 $lid= Crypt::encrypt($invoice->leaseid);
 $totalbilled = ($invoice->rental + $invoice->rates + $invoice->operationalcost +
                                $invoice->balancebd + $invoice->interestbd + $invoice->vat);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Invoice')
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
            <li class="breadcrumb-item"><a href="{{route('invoice.listinv')}}">List</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $invoice->currencycode.' - '.$title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" action="{{ route('invoice.print',['id'=>$id,'lease'=>$lid]) }}"
            method="GET"> @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Tenant Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $tname }}" readonly>
                    </div>
                    <label for="" class="col-sm-2 form-control-label">Property Des</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $invoice->propertydescription }}" readonly>
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="ClientType" class="col-sm-2 form-control-label">Period</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control"value="{{\Carbon\Carbon::createFromTimestamp(strtotime
                            ($invoice->period))->format('M-Y')}}" @readonly(true)>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Type" class="col-sm-2 form-control-label">Deposit Paid</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" value="{{ number_format($invoice->deposit,2) }}"
                         @readonly(true)>
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
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    <tr>
                    <td>{{$count ++}}</td>
                    <td><i>Rental</i></td>
                    <td>{{ number_format($invoice->rental,2) }}</td>                                      
                    </tr>  
                    <tr>
                        <td>{{$count ++}}</td>
                        <td><i>Rates & Levies</i></td>
                        <td>{{ number_format($invoice->rates,2) }}</td>                                      
                        </tr>
                        <tr>
                            <td>{{$count ++}}</td>
                            <td><i>Operational Costs</i></td>
                            <td>{{ number_format($invoice->operationalcost,2) }}</td>                                    
                            </tr>
                        <tr>
                                <td>{{$count ++}}</td>
                                <td><i>Interest Charged</i></td>
                                <td>{{ number_format($invoice->interestbd,3) }}</td>     
                                </tr>
                        <tr>
                                    <td>{{$count ++}}</td>
                                    <td><i>VAT on Rent</i></td>
                                    <td>{{ number_format($invoice->vat,3) }}</td>      
                                    </tr>
                            <tr>
                                <td></td>
                                <td><strong><i>Total Billed</i></strong> </td>
                                <td>{{ number_format($totalbilled,2) }}</td>    
                                </tr>
                </tbody>
            </table>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-edit-pro" value="{{ $title }}">
                    <i class="ti-download mr-0-5"></i> export</button>
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
    <!-- Additional JS End-->
@endsection
