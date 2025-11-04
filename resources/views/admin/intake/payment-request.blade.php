@php
$title = 'Requisition';
$description = 'Complete all required fields to submit a requisition...';
@endphp
@extends('layout.admin-main-menu')
@section('title', 'Requisition')
@section('additional css')
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endsection
<style>
    #drop-zone {
        border: 2px dashed #ccc;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.3s ease;
        min-height: 120px;
        position: relative;
    }

    #drop-zone.hover {
        border-color: #333;
    }

    .file-item {
        display: inline-block;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 8px 12px;
        margin: 5px;
        position: relative;
    }

    .file-item img {
        max-width: 20px;
        max-height: 20px;
        display: block;
        margin-bottom: 5px;
    }

    .remove-file {
        color: red;
        cursor: pointer;
        font-weight: bold;
        position: absolute;
        top: 2px;
        left: 4px;
    }
</style>
@section('content')
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <form class="form-material material-primary" id="defaultform" method="POST"
            action="{{ route('admin.cretreq') }}" enctype="multipart/form-data"> @csrf
            <div class="form-group row">
                <label for="requisitiontype" class="col-sm-2 col-form-label">Requisition Type</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="requisitiontype" id="requisitiontype"
                        onchange="changesection(this)">
                        <option value="">Select type</option>
                        <option value="product">Product</option>
                        <option value="service">Service</option>
                    </select>
                    <small id="requisitiontypecheck" style="color: red;">required</small>
                </div>
                <label for="" class="col-sm-2 col-form-label">Currency</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="currencycode" id="currencycode">
                        <option value="">currency</option>
                        @foreach ($currency as $abc)
                        <option value="{{ $abc->code }}"> {{ $abc->code }}
                        </option>
                        @endforeach
                    </select>
                    <small id="currencycodecheck" style="color: red;">required</small>
                </div>
            </div>
            <!-- Approval Mode -->
            <div class="form-group row">
                <label for="approval_mode" class="col-sm-2 col-form-label">Approval Mode</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="approvalmode" id="approvalmode">
                        <option value="">Select mode</option>
                        <option value="sequential">Sequential</option>
                        <option value="parallel">Parallel</option>
                    </select>
                    <small id="approvalmodecheck" style="color: red;">required</small>
                </div>
            </div>
            <!-- Approver Selection -->
            <div class="form-group row">
                <label for="approvers" class="col-sm-2 col-form-label" id="approverLabel">Approvers</label>
                <div class="col-sm-6">
                    <select name="approvers[]" id="approvers" class="js-example-basic-single w-100" multiple="multiple">
                        @foreach ($staff as $abc)
                        <option value="{{ $abc->id }}"> {{ $abc->lastname }} {{ $abc->firstname}}</option>
                        @endforeach
                    </select>
                    <small id="approverscheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="justification" class="col-sm-2 col-form-label">Desription</label>
                <div class="col-sm-6">
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <!-- Product Table -->
            <div id="productsection" style="display: none; margin-top: 15px;" class="table-responsive">
                <table class="table table-bordered table-hover" id="productbody">
                    <thead>
                        <tr>
                            <th style="width:35%">Item</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>VAT</th>
                            <th>Total</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="entry-row">
                            <td><input type="text" name="productitem" id="productitem" class="form-control">
                                <small id="productitemcheck" style="color: red;">required</small>
                            </td>
                            <td><input type="text" name="productqty" id="productqty" class="form-control">
                                <small id="productqtycheck" style="color: red;">required</small>
                            </td>
                            <td><input type="text" name="productrate" id="productrate" class="form-control">
                                <small id="productratecheck" style="color: red;">required</small>
                            </td>
                            <td><input type="text" name="productvat" id="productvat" class="form-control">
                                <small id="productvatcheck" style="color: red;"></small>
                            </td>
                            <td><small id="producttotal" style="color: blue;"></small></td>
                            <td> <input id="add-new-product-item" class="btn btn-info" value="Save" tabindex="6" type="button"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Service Table -->
            <div id="servicesection" style="display: none; margin-top: 15px;" class="table-responsive">
                <table class="table table-bordered table-hover" id="servicebody">
                    <thead>
                        <tr>
                            <th style="width:35%">Item</th>
                            <th>Rate</th>
                            <th>VAT</th>
                            <th>Total</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="entry-row">
                            <td><input type="text" name="serviceitem" id="serviceitem" class="form-control">
                                <small id="serviceitemcheck" style="color: red;">required</small>
                            </td>
                            <td><input type="text" name="servicerate" id="servicerate" class="form-control">
                                <small id="serviceratecheck" style="color: red;">required</small>
                            </td>
                            <td><input type="text" name="servicevat" id="servicevat" class="form-control">
                                <small id="servicevatcheck" style="color: red;"></small>
                            </td>
                            <td><small id="servicetotal" style="color: blue;"></small></td>
                            <td> <input id="add-new-service-item" class="btn btn-info" value="Save"
                                    tabindex="6" type="button"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <input type="hidden" name="approversorder" id="approversorder">
            <div class="form-group row">
                <label for="approval_mode" class="col-sm-2 col-form-label">Quotation</label>
                <div class="col-sm-6">
                    <input type="file" id="file-input" name="quotations" multiple accept=".pdf,.doc,.docx,image/*" style="display:none;">
                    <div id="drop-zone">
                        <p>drag/pick quotations</p>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="justification" class="col-sm-2 col-form-label">Justification</label>
                <div class="col-sm-6">
                    <textarea name="justification" id="justification" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="form-group row mt-4">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-submit-requisition">Submit</button>
                </div>
            </div>
            @include('layout.arlet')
        </form>
    </div>
</div>
@endsection
@section('additional js')
<script src="{{ asset('js/validation/intake-admin.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<script src="{{ asset('js/file-dropzone.js') }}"></script>

<script>
    $(document).ready(function() {
        let order = [];

        $('#approvers').select2({
            sorter: data => data,
            templateSelection: function(data, container) {
                const selected = $('#approvers').val() || [];
                const idx = order.indexOf(data.id);
                if (idx !== -1) {
                    return (idx + 1) + "️⃣ " + data.text;
                }
                return data.text;
            }
        });

        $('#approvers').on('select2:select', function(e) {
            const id = e.params.data.id;
            order = order.filter(x => x !== id);
            order.push(id);
            $('#approvers').trigger('change.select2');
        });
        $('#approvers').on('select2:unselect', function(e) {
            const id = e.params.data.id;
            order = order.filter(x => x !== id);
            $('#approvers').trigger('change.select2');
        });
        $('#defaultform').on('submit', function(e) {
            const selected = $('#approvers').val() || [];
            const result = order
                .filter(id => selected.includes(id))
                .map(id => {
                    const text = $('#approvers option[value="' + id + '"]').text();
                    return {
                        id: id,
                        name: text
                    };
                });
            $('#approversorder').val(JSON.stringify(result));
        });
    });
</script>

<!-- Additional JS End-->
@endsection