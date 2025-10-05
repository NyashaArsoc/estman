@php
$adminintake = $adminintake ?? [];
$adminapprove = $adminapprove ?? [];
$admindecline = $admindecline ?? [];
$adminmanage = $adminmanage ?? [];
$user = $user ?? (object)['firstname' => 'Guest', 'lastname' => 'User'];

$title = 'Requisition Intake';
$description = 'Complete all required fields to submit requisition...';
@endphp

@extends('layout.admin-main-menu')

@section('title', $title)

@section('additional css')
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
<style>
  .select2-container { width: 100% !important; }
  .select2-selection--multiple { min-height: 38px; padding: 6px 12px; }
</style>
@endsection

@section('content')
<div class="container-fluid">
  <h4>{{ $title }}</h4>
  <ol class="breadcrumb no-bg mb-1">
    <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>

  <div class="box box-block bg-white">
    <h5>{{ $title }}</h5>
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p class="font-90 text-muted mb-1">{{ $description }}</p>

    <form class="form-material material-primary" id="defaultform" method="POST" action="{{ url('/admin/intake/requisition-form') }}" enctype="multipart/form-data">
      @csrf

      <!-- Requisition Type -->
      <div class="form-group row">
        <label for="requisitiontype" class="col-sm-2 col-form-label">Requisition Type</label>
        <div class="col-sm-4">
          <select class="form-control" name="requisitiontype" id="requisitiontype" required>
            <option value="">Select type</option>
            <option value="product">Product</option>
            <option value="service">Service</option>
          </select>
        </div>
      </div>

      <!-- Approval Mode -->
      <div class="form-group row" id="approvalModeGroup" style="display: none;">
        <label for="approval_mode" class="col-sm-2 col-form-label">Approval Mode</label>
        <div class="col-sm-4">
          <select class="form-control" name="approval_mode" id="approval_mode" required>
            <option value="">Select mode</option>
            <option value="sequential">Sequential</option>
            <option value="parallel">Parallel</option>
          </select>
        </div>
      </div>

      <!-- Approver Selection -->
      <div class="form-group row" id="approverGroup" style="display: none;">
        <label for="approvers" class="col-sm-2 col-form-label" id="approverLabel">Approvers</label>
        <div class="col-sm-6">
          <select name="approvers[]" id="approvers" class="form-control" multiple="multiple">
  <option value="1">Alice Moyo</option>
  <option value="2">Brian Chikafu</option>
  <option value="3">Chipo Dube</option>
  <option value="4">David Nyathi</option>
  <option value="5">Ethel Gondo</option>
</select>
        </div>
      </div>

      <!-- Product Table -->
<div id="productSection" style="display: none;">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Item</th>
        <th>VAT Rate</th>
        <th>Quantity</th>
        <th>Rate</th>
        <th>Amount</th>
        <th>VAT</th>
        <th>Total</th>
        <th>Attachment</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody id="productBody">
      <tr class="entry-row">
        <td><input type="text" name="item[]" class="form-control" required></td>
        <td><input type="text" name="vat_rate[]" class="form-control" required></td>
        <td><input type="number" name="quantity[]" class="form-control" required></td>
        <td><input type="number" name="rate[]" class="form-control" step="0.01" required></td>
        <td><input type="number" name="amount[]" class="form-control" step="0.01" required></td>
        <td><input type="number" name="vat[]" class="form-control" step="0.01" required></td>
        <td><input type="number" name="total[]" class="form-control" step="0.01" required></td>
        <td><input type="file" name="attachment[]" class="form-control attachment"></td>
        <td><button type="button" class="btn btn-success btn-sm saveRow">Save</button></td>
      </tr>
    </tbody>
  </table>
  <div class="form-group">
    <label for="justification">Justification</label>
    <textarea name="justification" id="justification" class="form-control" rows="3" required></textarea>
  </div>
</div>

      <!-- Service Table -->
<div id="serviceSection" style="display: none;">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Item Description</th>
        <th>Price Per Each (USD)</th>
        <th>Total Amount (USD)</th>
        <th>Attachment</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody id="serviceBody">
      <tr class="entry-row">
        <td><input type="text" name="item_description[]" class="form-control" required></td>
        <td><input type="number" name="price_per_each[]" class="form-control" step="0.01" required></td>
        <td><input type="number" name="total_amount[]" class="form-control" step="0.01" required></td>
        <td><input type="file" name="service_attachment[]" class="form-control attachment"></td>
        <td><button type="button" class="btn btn-success btn-sm saveRow">Save</button></td>
      </tr>
    </tbody>
  </table>
  <div class="form-group">
    <label for="description">Description of Service</label>
    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
  </div>
</div>


      <!-- Submit Button -->
      <div class="form-group row mt-4">
        <div class="offset-sm-2 col-sm-10">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('additional js')
<!-- Load jQuery and Select2 directly here -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const requisitionType = document.getElementById('requisitiontype');
    const approvalModeGroup = document.getElementById('approvalModeGroup');
    const approverGroup = document.getElementById('approverGroup');
    const productSection = document.getElementById('productSection');
    const serviceSection = document.getElementById('serviceSection');
    const productBody = document.getElementById('productBody');
    const serviceBody = document.getElementById('serviceBody');

    requisitionType.addEventListener('change', function () {
      const selected = this.value;
      approvalModeGroup.style.display = selected ? 'flex' : 'none';
      approverGroup.style.display = selected ? 'flex' : 'none';
      productSection.style.display = selected === 'product' ? 'block' : 'none';
      serviceSection.style.display = selected === 'service' ? 'block' : 'none';
    });

    document.addEventListener('click', function (e) {
      if (e.target && e.target.matches('.saveRow')) {
  const row = e.target.closest('tr');
  const inputs = row.querySelectorAll('input');
  let valid = true;

  inputs.forEach(input => {
    if (input.required && !input.value) valid = false;
  });

  if (valid) {
    inputs.forEach(input => {
      input.setAttribute('readonly', true);
      if (input.type === 'file') input.setAttribute('disabled', true);
    });
    e.target.outerHTML = `<button type="button" class="btn btn-danger btn-sm deleteRow">Delete</button>`;

    const isProduct = productSection.style.display === 'block';
    const newRow = document.createElement('tr');
    newRow.classList.add('entry-row');

    newRow.innerHTML = isProduct ? `
      <td><input type="text" name="item[]" class="form-control" required></td>
      <td><input type="text" name="vat_rate[]" class="form-control" required></td>
      <td><input type="number" name="quantity[]" class="form-control" required></td>
      <td><input type="number" name="rate[]" class="form-control" step="0.01" required></td>
      <td><input type="number" name="amount[]" class="form-control" step="0.01" required></td>
      <td><input type="number" name="vat[]" class="form-control" step="0.01" required></td>
      <td><input type="number" name="total[]" class="form-control" step="0.01" required></td>
      <td><input type="file" name="attachment[]" class="form-control attachment"></td>
      <td><button type="button" class="btn btn-success btn-sm saveRow">Save</button></td>
    ` : `
      <td><input type="text" name="item_description[]" class="form-control" required></td>
      <td><input type="number" name="price_per_each[]" class="form-control" step="0.01" required></td>
      <td><input type="number" name="total_amount[]" class="form-control" step="0.01" required></td>
      <td><input type="file" name="service_attachment[]" class="form-control attachment"></td>
      <td><button type="button" class="btn btn-success btn-sm saveRow">Save</button></td>
    `;

    if (isProduct) {
      productBody.appendChild(newRow);
    } else {
      serviceBody.appendChild(newRow);
    }
  } else {
    alert('Please fill in all required fields before saving.');
  }
}

      if (e.target && e.target.matches('.deleteRow')) {
        e.target.closest('tr').remove();
      }
    });

    window.addEventListener('load', function () {
      const successMessage = document.querySelector('.alert-success');
      if (successMessage) {
        document.getElementById('defaultform').reset();
        approvalModeGroup.style.display = 'none';
        approverGroup.style.display = 'none';
        productSection.style.display = 'none';
        serviceSection.style.display = 'none';
        $('#approvers').val(null).trigger('change');

        document.querySelectorAll('.entry-row').forEach((row, index) => {
          if (index > 0) row.remove();
          else {
            row.querySelectorAll('input').forEach(input => {
              input.removeAttribute('readonly');
              input.removeAttribute('disabled');
              input.value = '';
            });
            row.querySelector('button').outerHTML = `<button type="button" class="btn btn-success btn-sm saveRow">Save</button>`;
          }
        });
      }
    });

    // Initialize Select2 with search and duplicate prevention
    $('#approvers').select2({
      theme: 'bootstrap',
      placeholder: 'Select approvers',
      allowClear: true,
      width: '100%'
    }).on('select2:select', function (e) {
      const selectedId = e.params.data.id;
      const selectedValues = $(this).val();
      const duplicates = selectedValues.filter(id => id === selectedId);

      if (duplicates.length > 1) {
        alert('This user is already selected.');
        const filtered = selectedValues.filter(id => id !== selectedId);
        $(this).val(filtered).trigger('change');
      }
    });
  });
</script>
@endsection

