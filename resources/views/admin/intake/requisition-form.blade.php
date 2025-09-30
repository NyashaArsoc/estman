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
          </select>
          <small class="text-danger d-block mt-1">Required</small>
        </div>
      </div>

      <!-- Requisition Table -->
      <div class="table-responsive mt-4">
        <table class="table table-bordered" id="requisitionTable">
          <thead>
            <tr>
              <th>Requisition Number</th>
              <th>Quantity</th>
              <th id="costHeader">Unit Cost</th>
              <th id="supplierHeader">Supplier</th>
              <th>Attachment</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            <tr class="entry-row">
              <td><input type="text" class="form-control requisition_number" required></td>
              <td><input type="number" class="form-control quantity" required></td>
              <td><input type="number" class="form-control unit_cost" step="0.01" required></td>
              <td><input type="text" class="form-control supplier" required></td>
              <td><input type="file" class="form-control attachment"></td>
              <td><button type="button" class="btn btn-success btn-sm saveRow">Save</button></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Submit Button -->
      <div class="form-group row mt-4">
        <div class="offset-sm-2 col-sm-10">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>

      @include('layout.arlet')
    </form>
  </div>
</div>
@endsection

@section('additional js')
<script src="{{ asset('js/validation/intakeadmin.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>

<script>
  // Update column labels based on requisition type
  document.getElementById('requisitiontype').addEventListener('change', function () {
    const selectedType = this.value;
    document.getElementById('costHeader').textContent = selectedType === 'service' ? 'Service Fee' : 'Unit Cost';
    document.getElementById('supplierHeader').textContent = selectedType === 'service' ? 'Service Provider' : 'Supplier';
  });

  document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('saveRow')) {
      const row = e.target.closest('tr');
      const requisitionNumber = row.querySelector('.requisition_number').value;
      const quantity = row.querySelector('.quantity').value;
      const unitCost = row.querySelector('.unit_cost').value;
      const supplier = row.querySelector('.supplier').value;

      if (requisitionNumber && quantity && unitCost && supplier) {
        row.querySelectorAll('input').forEach(input => input.setAttribute('readonly', true));
        row.querySelector('.attachment').setAttribute('disabled', true);
        e.target.outerHTML = `<button type="button" class="btn btn-danger btn-sm deleteRow">Delete</button>`;

        const newRow = document.createElement('tr');
        newRow.classList.add('entry-row');
        newRow.innerHTML = `
          <td><input type="text" class="form-control requisition_number" required></td>
          <td><input type="number" class="form-control quantity" required></td>
          <td><input type="number" class="form-control unit_cost" step="0.01" required></td>
          <td><input type="text" class="form-control supplier" required></td>
          <td><input type="file" class="form-control attachment"></td>
          <td><button type="button" class="btn btn-success btn-sm saveRow">Save</button></td>
        `;
        document.querySelector('#requisitionTable tbody').insertBefore(newRow, document.querySelector('#requisitionTable tbody').firstChild);
      } else {
        alert('Please fill in all required fields before saving.');
      }
    }

    if (e.target && e.target.classList.contains('deleteRow')) {
      e.target.closest('tr').remove();
    }
  });
</script>
@endsection
