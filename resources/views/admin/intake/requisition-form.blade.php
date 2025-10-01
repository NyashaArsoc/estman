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
  .select2-container {
    width: 100% !important;
  }
  .select2-selection--multiple {
    min-height: 38px;
    padding: 6px 12px;
  }
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
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
 @endif

    <p class="font-90 text-muted mb-1">{{ $description }}</p>

    <form class="form-material material-primary" id="defaultform" method="POST" action="{{ url('/admin/intake/requisition-form') }}" enctype="multipart/form-data">
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
          <small id="typeRequired" class="text-danger d-block mt-1" style="display: none;">Required</small>
        </div>
      </div>

      <!-- Approval Mode -->
      <div class="form-group row">
        <label for="approval_mode" class="col-sm-2 col-form-label">Approval Mode</label>
        <div class="col-sm-4">
          <select class="form-control" name="approval_mode" id="approval_mode" required>
            <option value="">Select mode</option>
            <option value="sequential">Sequential</option>
            <option value="parallel">Parallel</option>
          </select>
          <small id="modeRequired" class="text-danger d-block mt-1" style="display: none;">Required</small>
        </div>
      </div>

      <!-- Approver Selection -->
      <div class="form-group row" id="approverGroup" style="display: none;">
        <label for="approvers" class="col-sm-2 col-form-label" id="approverLabel">Approvers</label>
        <div class="col-sm-6">
          <select class="js-example-basic-multiple w-100" name="approvers[]" id="approvers" multiple="multiple">
            <option value="1" data-dept="finance">Alice Moyo</option>
            <option value="2" data-dept="procurement">Brian Chikafu</option>
            <option value="3" data-dept="hr">Chipo Dube</option>
            <option value="4" data-dept="finance">David Nyathi</option>
            <option value="5" data-dept="it">Ethel Gondo</option>
          </select>
          <small class="text-muted d-block mt-1">Select users who will approve this requisition</small>
        </div>
      </div>

      <!-- Requisition Table -->
<div class="table-responsive mt-4">
  <table class="table table-bordered" id="requisitionTable">
    <thead>
      <tr>
        <th>Quantity</th>
        <th id="costHeader">Unit Cost</th>
        <th id="supplierHeader">Supplier</th>
        <th>Attachment</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody>
      <tr class="entry-row">
        <td><input type="number" name="quantity[]" class="form-control quantity" required></td>
        <td><input type="number" name="unit_cost[]" class="form-control unit_cost" step="0.01" required placeholder="Unit Cost"></td>
        <td><input type="text" name="supplier[]" class="form-control supplier" required placeholder="Supplier"></td>
        <td><input type="file" name="attachment[]" class="form-control attachment"></td>
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
  $(document).ready(function () {
    $('#approvers').select2({
      theme: 'bootstrap',
      placeholder: 'Select approvers',
      allowClear: true
    });
  });

  let currentType = '';

  function updateLabels(type) {
    const costLabel = type === 'service' ? 'Service Fee' : 'Unit Cost';
    const supplierLabel = type === 'service' ? 'Service Provider' : 'Supplier';

    document.getElementById('costHeader').textContent = costLabel;
    document.getElementById('supplierHeader').textContent = supplierLabel;

    document.querySelectorAll('.entry-row').forEach(row => {
      row.querySelector('.unit_cost').setAttribute('placeholder', costLabel);
      row.querySelector('.supplier').setAttribute('placeholder', supplierLabel);
    });
  }

  // Hide red "Required" messages when valid selection is made
  document.getElementById('requisitiontype').addEventListener('change', function () {
    const selected = this.value;
    if (selected) {
      document.getElementById('typeRequired').style.display = 'none';
    }
    currentType = selected;
    updateLabels(currentType);
  });

  document.getElementById('approval_mode').addEventListener('change', function () {
    const selected = this.value;
    if (selected) {
      document.getElementById('modeRequired').style.display = 'none';
    }

    const approverGroup = document.getElementById('approverGroup');
    const label = document.getElementById('approverLabel');

    if (selected === 'sequential') {
      label.textContent = 'Approvers (in order)';
      approverGroup.style.display = 'flex';
      showAllApprovers();
    } else if (selected === 'parallel') {
      label.textContent = 'Approvers (any can act)';
      approverGroup.style.display = 'flex';
      showAllApprovers();
    } else {
      approverGroup.style.display = 'none';
    }
  });

  function showAllApprovers() {
    $('#approvers option').show();
    $('#approvers').val(null).trigger('change');
  }

  document.addEventListener('click', function (e) {
    if (e.target && e.target.matches('.saveRow')) {
      const typeSelected = document.getElementById('requisitiontype').value;
      const modeSelected = document.getElementById('approval_mode').value;

      if (!typeSelected) {
        document.getElementById('typeRequired').style.display = 'block';
        return;
      }

      if (!modeSelected) {
        document.getElementById('modeRequired').style.display = 'block';
        return;
      }

      const row = e.target.closest('tr');
      const quantity = row.querySelector('.quantity').value;
      const unitCost = row.querySelector('.unit_cost').value;
      const supplier = row.querySelector('.supplier').value;

if (quantity && unitCost && supplier) {
        row.querySelectorAll('input').forEach(input => input.setAttribute('readonly', true));
        row.querySelector('.attachment').setAttribute('disabled', true);
        e.target.outerHTML = `<button type="button" class="btn btn-danger btn-sm deleteRow">Delete</button>`;

        const costLabel = currentType === 'service' ? 'Service Fee' : 'Unit Cost';
        const supplierLabel = currentType === 'service' ? 'Service Provider' : 'Supplier';

       const newRow = document.createElement('tr');
newRow.classList.add('entry-row');
newRow.innerHTML = `
  <td><input type="number" name="quantity[]" class="form-control quantity" required></td>
  <td><input type="number" name="unit_cost[]" class="form-control unit_cost" step="0.01" required placeholder="${costLabel}"></td>
  <td><input type="text" name="supplier[]" class="form-control supplier" required placeholder="${supplierLabel}"></td>
  <td><input type="file" name="attachment[]" class="form-control attachment"></td>
  <td><button type="button" class="btn btn-success btn-sm saveRow">Save</button></td>
`;
document.querySelector('#requisitionTable tbody').insertBefore(newRow, document.querySelector('#requisitionTable tbody').firstChild);
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
    $('#approvers').val(null).trigger('change');
    document.querySelectorAll('#requisitionTable tbody tr').forEach((row, index) => {
      if (index > 0) row.remove(); // keep only the first empty row
      else {
        row.querySelectorAll('input').forEach(input => {
          input.removeAttribute('readonly');
          input.value = '';
        });
        row.querySelector('.attachment').removeAttribute('disabled');
        row.querySelector('button').outerHTML = `<button type="button" class="btn btn-success btn-sm saveRow">Save</button>`;
      }
    });
  }
});

// Prevent duplicate approver selection
$(document).ready(function () {
  $('#approvers').select2({
    theme: 'bootstrap',
    placeholder: 'Select approvers',
    allowClear: true
  }).on('select2:select', function (e) {
    const selectedId = e.params.data.id;
    const selectedText = e.params.data.text;

    // Disable selected option to prevent re-selection
    $(this).find(`option[value="${selectedId}"]`).prop('disabled', true);
    $(this).trigger('change.select2');
  });

  $('#approvers').on('select2:unselect', function (e) {
    const unselectedId = e.params.data.id;
    $(this).find(`option[value="${unselectedId}"]`).prop('disabled', false);
    $(this).trigger('change.select2');
  });
});

// Reset form after successful submission
window.addEventListener('load', function () {
  const successMessage = document.querySelector('.alert-success');
  if (successMessage) {
    document.getElementById('defaultform').reset();
    $('#approvers').val(null).trigger('change');
    document.querySelectorAll('#requisitionTable tbody tr').forEach((row, index) => {
      if (index > 0) row.remove();
      else {
        row.querySelectorAll('input').forEach(input => {
          input.removeAttribute('readonly');
          input.value = '';
        });
        row.querySelector('.attachment').removeAttribute('disabled');
        row.querySelector('button').outerHTML = `<button type="button" class="btn btn-success btn-sm saveRow">Save</button>`;
      }
    });
  }
});
</script>
@endsection
