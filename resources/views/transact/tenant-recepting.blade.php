@php
    $title = 'Tenant Receipting';
$description = 'tenant payments...'; @endphp
@extends('layout.main-layout')
@section('title', 'Receipt')

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
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
        </ol>
        <div class="box box-block bg-white">
            <form class="form-vertical" id="" name="" 
            enctype="multipart/form-data" method="post" accept-charset="utf-8">
                <div class="panel-body">
                    <div class="row"> 
                        <div id="error"></div> 
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <label for="customer_name" class="col-sm-3 col-form-label">
                                    Search Property <i class="text-danger">*</i></label>
                                <div class="col-sm-6 has-success">
                                    <select class="js-example-basic-single w-100" name="PropertyAddressDesc"
                                    id="PropertyAddressDesc" onchange="getTenantDetails();" />
                                    <option value="">Property Description</option>
                                    @foreach($lease as $abc)
								    <option value="{{ $abc->id }}"> {{$abc->streetaddress.' - '.$abc->propertydescription}}
                                    </option>
                                    @endforeach
                                    </select>
                                      <h5>Payment Details:</h5>
                                      <div id="tenantdetailsform">
                                        <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">Tenant:</span>
                                            <span class="float-xs-right" id="tenantname">k</span>
                                          </div>
                                          <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">Mobile:</span>
                                            <span class="float-xs-right" id="tenantcell"></span>
                                          </div>
                                          <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">Email:</span>
                                            <span class="float-xs-right" id="tenantemail"></span>
                                        </div>
                                        <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">Billing Address:</span>
                                            <span class="float-xs-right" id="tenantaddress"></span>
                                        </div>
                                    <div class="b-a b-a-success b-a-width-1 mb-0-5"></div>
                                    <table  class="table table-hover table-bordered">
                                        <thead>
                                            <tr><th>Currency</th><th>Balance</th></tr>
                                        </thead>
                                        <tbody>
                                            <tr><td></td><td></td></tr>
                                        </tbody>
                                    </table>
                                    <div class="b-a b-a-success b-a-width-1 mb-0-5"></div>
                                </div>
                                </div>
                                <div  class=" col-sm-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pay_payment_type" class="col-sm-2 col-form-label">Currency
                            <i class="text-danger">*</i></label>
                        <div class="col-sm-4 has-success">
                             <select class="js-example-basic-single w-100" name="ReceiptCurrency"
                                    id="ReceiptCurrency" />                                               	
                                <option value="">Select Currency</option>
                                @foreach($currency as $abc)
								    <option value="{{ $abc->code }}"> {{$abc->code}}
                                    </option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CashReceivable" class="col-sm-2 col-form-label">Amount Received <i class="text-danger">*</i></label>
                        <div class="col-sm-4">
                            <div class="input-group has-success">
                                <div class="input-group-addon">$</div>
                                <input type="text" class="form-control" id="cash_recieved" 
                                name="cash_recieved" autocomplete="off" onkeyup="received_amount();" 
                                placeholder="Amount">
                                <div class="input-group-addon">.00</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Date <i class="text-danger">*</i></label>
                        <div class="col-sm-4">
                             <div class="input-group has-success">
                                <input type="text" class="form-control" autocomplete="off" required 
                                 id="datepicker_invoice_date" name="datepicker_invoice_date" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="pay_payment_detail" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4 has-success">
                             <input id="pay_payment_detail" autocomplete="off" class="form-control" 
                             name="pay_payment_detail" placeholder="Payment Type Reference #/ Detail">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="CashReceivable" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <div class="input-group has-success">
                                <input id="add-receivable" class="btn btn-success" name="add-receivable" 
                                 value="Cash Received" tabindex="9" type="submit">
                                        
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <!-- Additional JS End-->
@endsection
