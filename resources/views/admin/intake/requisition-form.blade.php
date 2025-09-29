@php
$title = 'Requisition Intake';
$description = 'Complete all required fields to submit requisition...';
@endphp

@extends('layout.admin-main-menu')

@section('title', $title)

@section('additional css')
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endsection

@section('content')
<div class="container-fluid">
  <h4>{{ $title }}</h4>
  <ol class="breadcrumb no-bg mb-1">
    {{-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> --}}
    <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>

  <div class="box box-block bg-white">
    <h5>{{ $title }}</h5>
    <p class="font-90 text-muted mb-1">{{ $description }}</p>

    <form class="form-material material-primary" id="defaultform" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Requisition Type -->
      <div class="form-group row">
        <label for="requisitiontype" class="col-sm-2 col-form-label">Requisition Type</label>
        <div class="col-sm-4">
          <select class="js-example-basic-single w-100" name="requisitiontype" id="requisitiontype" required>
            <option value="">Select type</option>
            <option value="product">Product</option>
            <option value="service">Service</option>
            <option value="maintenance">Maintenance</option>
          </select>
          <small class="text-danger d-block mt-1">Required</small>
        </div>
      </div>

      <!-- Requisition Details -->
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Requisition Number</label>
        <div class="col-sm-4"><input type="text" name="requisition_number" class="form-control" required></div>
        <label class="col-sm-2 col-form-label">Quantity</label>
        <div class="col-sm-4"><input type="number" name="quantity" class="form-control" required></div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Unit Cost</label>
        <div class="col-sm-4"><input type="number" name="unit_cost" class="form-control" step="0.01" required></div>
        <label class="col-sm-2 col-form-label">Supplier / Provider</label>
        <div class="col-sm-4"><input type="text" name="supplier" class="form-control" required></div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Attachment</label>
        <div class="col-sm-4"><input type="file" name="attachment" class="form-control"></div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Description / Notes</label>
        <div class="col-sm-10">
          <textarea name="description" class="form-control" rows="3" placeholder="Add any relevant notes or comments..." required></textarea>
        </div>
      </div>

      <!-- Submit Button -->
      {{-- @if (in_array(1, $arraycontrolids)) --}}
      <div class="form-group row mt-4">
        <div class="offset-sm-2 col-sm-10">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
      {{-- @endif --}}

      @include('layout.arlet')
    </form>
  </div>
</div>
@endsection

@section('additional js')
<script src="{{ asset('js/validation/intakeadmin.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
@endsection
