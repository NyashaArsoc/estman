@php
    $title = 'Profoma Invoice ';
    $description = 'invoice to be generated...';
    if ($invoice->clienttypeid == 1){
    $tname   =  $invoice->fullname ;
   }else{
     $tname   =  $invoice->invoicenumber ;
 } 
 $id= Crypt::encrypt($invoice->invoicenumber);
@endphp
@extends('layout.main-layout')
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
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('invoice.listpre')}}">Pending</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $invoice->currencycode.' - '.$title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" action=""
            method="PUT"> @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Tenant Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $tname }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
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
                        <input type="text" class="form-control" value="{{ number_format($invoice->predeposit,2) }}"
                         @readonly(true)>
                    </div>
                </div><br />
        <h5>rental information </h5>
        <div class="form-group row">
            <label for="City" class="col-sm-2 col-form-label">Balance b/f</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" value="{{ number_format($invoice->prebalancebd,2) }}" @readonly(true)>
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
                    <td>{{ number_format($invoice->prerental,2) }}</td>
                    <td><a class="btn btn-secondary btn-sm" 
                        href="{{route('invoice.editviewpro', $id)}}"
                     title="edit"><i class="ti-pencil mr-0-5"></i>Edit</a> </td>                                      
                    </tr>  
                    <tr>
                        <td>{{$count ++}}</td>
                        <td><i>Rates & Levies</i></td>
                        <td>{{ number_format($invoice->prerates,2) }}</td>
                        <td><a class="btn btn-secondary btn-sm" 
                            href="{{route('invoice.editviewpro', $id)}}"
                         title="edit"><i class="ti-pencil mr-0-5"></i>Edit</a> </td>                                      
                        </tr>
                        <tr>
                            <td>{{$count ++}}</td>
                            <td><i>Operational Costs</i></td>
                            <td>{{ number_format($invoice->operationalcost,2) }}</td>
                            <td><a class="btn btn-secondary btn-sm" 
                                href="{{route('invoice.editviewpro', $id)}}"
                             title="edit"><i class="ti-pencil mr-0-5"></i>Edit</a></td>                                      
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong><i>Total Billed</i></strong> </td>
                                <td>{{ number_format($invoice->totalbilled,2) }}</td>
                                <td> </td>                                      
                                </tr>
                </tbody>
            </table>
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
