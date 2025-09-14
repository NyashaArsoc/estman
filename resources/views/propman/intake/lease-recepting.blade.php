@php
$title = 'Lease Receipting';
$description = 'tenant payments...'; @endphp
@extends('layout.propman-main-menu')
@section('title', 'Receipt')

@section('additional css')
<!-- Additional css Start-->
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset ('css/display.css') }}" />
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
        <form class="form-vertical" id="defaultform" action="{{ route('propin.procpay') }}"
            enctype="multipart/form-data" method="post" accept-charset="utf-8">@csrf
            <div class="panel-body">
                <div class="row">
                    <div id="error"></div>
                    <div class="col-sm-8">
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label">
                                Search Property </label>
                            <div class="col-sm-6 has-success">
                                <select class="js-example-basic-single w-100" name="lease"
                                    id="leasenumber" onchange="getpropmantenantbyleaseid();" />
                                <option value="">Property Description</option>
                                @foreach($lease as $abc)
                                <option value="{{ $abc->id }}"> {{$abc->propertydescription}} - {{$abc->tenantcompanyname}}
                                    {{$abc->tenantfullname}}
                                </option>
                                @endforeach
                                </select>
                                <small id="receiptleasecheck" style="color: red;">required</small>
                                <h5>Payment Details:</h5>
                                <div id="tenantdetailsform">
                                    <div class="clearfix mb-0-25">
                                        <span class="float-xs-left">Tenant:</span>
                                        <span class="float-xs-right" id="tenantname"></span>
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
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Currency</th>
                                                <th>Balance</th>
                                                <th>Prepayment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="b-a b-a-success b-a-width-1 mb-0-5"></div>
                                </div>
                            </div>
                            <div class=" col-sm-3"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label text-uppercase">
                        <small>Enable Multi-Currency</small>
                    </label>
                    <div class="col-sm-4 has-success">
                        <label class="switchToggle">
                            <input type="checkbox" name="multicurrency" />
                            <span class="sliderswitchToggle round"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pay_payment_type" class="col-sm-2 col-form-label">Currency
                    </label>
                    <div class="col-sm-4 has-success">
                        <select class="js-example-basic-single w-100" name="receiptcurrency"
                            id="currencycode" />
                        <option value="">Select Currency</option>
                        @foreach($currency as $abc)
                        <option value="{{ $abc->code }}"> {{$abc->code}}
                        </option>
                        @endforeach
                        </select>
                        <small id="currencycodecheck" style="color: red;">required</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="CashReceivable" class="col-sm-2 col-form-label">Amount Received</label>
                    <div class="col-sm-4">
                        <div class="input-group has-success">
                            <div class="input-group-addon">$</div>
                            <input type="text" class="form-control" id="numericrequired"
                                name="receiptamount" autocomplete="off" placeholder="300">
                            <div class="input-group-addon">.00</div>
                        </div>
                        <small id="numericrequiredcheck" style="color: red;">required</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Date</label>
                    <div class="col-sm-4">
                        <div class="input-group has-success">
                            <input type="date" class="form-control" autocomplete="off"
                                id="daterequired" name="receiptdate" placeholder="yyyy-mm-dd">
                            <span class="input-group-addon"></span>
                        </div>
                        <small id="daterequiredcheck" style="color: red;">required</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="pay_payment_detail" class="col-sm-2 col-form-label">Receipt Reference</label>
                    <div class="col-sm-4 has-success">
                        <input id="receiptreference" autocomplete="off" class="form-control"
                            name="receiptreference" placeholder="Receipt Reference #/ Detail">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-4">
                        <div class="input-group has-success">
                            <input id="add-lease-receipt" class="btn btn-primary"
                                value="Process" tabindex="9" type="submit">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal fade" id="printReceiptModal" tabindex="-1" role="dialog" aria-labelledby="printReceiptModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="printReceiptModalLabel">Print Receipt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you want to print a receipt?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="noPrintBtn" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" id="yesPrintBtn">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        @include('layout.arlet')
    </div>
</div>
@endsection
@section('additional js')
<!-- Additional JS Start-->
<script src="{{ asset('js/validation/intakepropman.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<!-- Additional JS End-->
<script>
    $(document).ready(function() {
        $('#defaultform').append('<input type="hidden" name="print_receipt" id="printDecision" value="no" />');

        $('#defaultform').on('submit', function(e) {
            if (!$(this).data('submitted')) {
                e.preventDefault();
                $('#printReceiptModal').modal('show');
            }
        });

        $('#noPrintBtn').on('click', function() {
            $('#printDecision').val('no');
            $('#defaultform').data('submitted', true).submit();
        });

        $('#yesPrintBtn').on('click', function() {
            $('#printDecision').val('yes');
            $('#defaultform').data('submitted', true).submit();
        });

        $('#printReceiptModal').on('hidden.bs.modal', function() {
            $('#defaultform').data('submitted', false);
        });
    });
</script>
@endsection