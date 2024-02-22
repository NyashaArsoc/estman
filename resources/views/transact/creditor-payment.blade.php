@php
    $title = 'Creditor Payment';
$description = 'creditors payments...'; @endphp
@extends('layout.main-layout')
@section('title', 'Creditor')

@section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
    <script src="{{ asset('js/dropdown-get-data.js') }}"></script>
@endsection
@section('content')
    <!-- Content End-->
    <div class="container-fluid">
        <h4>{{$title}}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
        </ol>
        <div class="box box-block bg-white">
            <form class="form-vertical" id="" action="{{ route('transact.paycreditor') }}"
            enctype="multipart/form-data" method="post" accept-charset="utf-8">@csrf
                <div class="panel-body">
                    <div class="row"> 
                        <div id="error"></div> 
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="customer_name" class="col-sm-3 col-form-label">
                                    Search Property <i class="text-danger">*</i></label>
                                <div class="col-sm-6 has-success">
                                    <select class="js-example-basic-single w-100" name="PropertyAddressDesc"
                                    id="PropertyAddressDesc" onchange="getRemittanceLandlordDetails();" />
                                    <option value="">Property Address</option>
                                    @foreach($property as $abc)
								    <option value="{{ $abc->id }}"> {{$abc->streetaddress}}
                                    </option>
                                    @endforeach
                                    </select>
                                    <small id="receiptaddresscheck" style="color: red;"> address is required</small>
                                      <h5>Property Details:</h5>
                                      <div id="propertydetailsform">
                                        <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">Landlord:</span>
                                            <span class="float-xs-right" id="landlordname"></span>
                                          </div>
                                          <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">Property Type:</span>
                                            <span class="float-xs-right" id="propertytype"></span>
                                          </div>    
                                </div>
                                <div class="b-a b-a-success b-a-width-1 mb-0-5"></div>
                                          <select class="js-example-basic-single w-100" name="CreditorCode"
                                    id="CreditorCode" onchange="getCreditorBalance();" />
                                    <option value="">Select Creditor</option>
								    <option value="rates">Rates/Levies </option>
                                    <option value="oppcost">Operational Cost</option>
                                    <option value="vat">VAT</option>
                                    <option value="security">Security</option>
                                    <option value="caretaker">Caretaker</option>
                                    <option value="otherexp">Other Expenses</option>
                                    </select>
                                    <div id="creditorbalance"> 
                                        <table  class="table table-hover table-bordered">
                                            <thead>
                                                <tr><th>Currency</th><th>Balance</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr><td></td><td></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="b-a b-a-success b-a-width-1 mb-0-5"></div>
                                </div>
                                <div  class=" col-sm-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pay_payment_type" class="col-sm-2 col-form-label">Currency
                            </label>
                        <div class="col-sm-4 has-success">
                             <select class="js-example-basic-single w-100" name="ReceiptCurrency"
                                    id="ReceiptCurrency" />                                               	
                                <option value="">Select Currency</option>
                                @foreach($currency as $abc)
								    <option value="{{ $abc->code }}"> {{$abc->code}}
                                    </option>
                                    @endforeach
                            </select>
                            <small id="receiptingcurrencycheck" style="color: red;"> currency is required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CashReceivable" class="col-sm-2 col-form-label">Amount Received</label>
                        <div class="col-sm-4">
                            <div class="input-group has-success">
                                <div class="input-group-addon">$</div>
                                <input type="text" class="form-control" id="ReceiptAmount" 
                                name="ReceiptAmount" autocomplete="off" placeholder="300">
                                <div class="input-group-addon">.00</div>
                            </div>
                            <small id="receiptamountcheck" style="color: red;"> amount is required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <div class="input-group has-success">
                                <input id="add-receipt" class="btn btn-primary" name="process-payment" 
                                 value="Process" tabindex="9" type="submit">
                                        
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @include('layout.arlet')
        </div>
    </div>
@endsection
@section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/validation/transaction.js') }}"></script>
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <!-- Additional JS End-->
@endsection
