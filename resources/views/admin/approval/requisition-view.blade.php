@php
  $adminintake = $adminintake ?? [];
  $adminapprove = $adminapprove ?? [];
  $admindecline = $admindecline ?? [];
  $adminmanage = $adminmanage ?? [];
  $user = $user ?? (object)['firstname' => 'Shania', 'lastname' => 'Nyaude'];

  $title = 'Approve Requisition';
  $description = 'Review requisition details and proceed with approval or decline.';

  // Inject dummy requisition data
  $requisition = (object)[
    'requisition_code' => 'REQ-2025-001',
    'submitted_by' => 'Tariro Moyo',
    'type' => 'procurement',
    'amount' => 1250.75,
    'status' => 'pending',
    'approvers' => collect([
      (object)['name' => 'Shania Nyaude'],
      (object)['name' => 'Blessing Chikafu'],
      (object)['name' => 'Tawanda Moyo'],
    ]),
  ];
@endphp

@extends('layout.admin-main-menu')

@section('title', $title)

@section('content')
<div class="container-fluid">
  <h4>{{ $title }}</h4>
  <ol class="breadcrumb no-bg mb-1">
    <li class="breadcrumb-item"><a href="{{ route('admin.approval.requisition-approval') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>

  <div class="box box-block bg-white">
    <h5>{{ $title }}</h5>
    <p class="font-90 text-muted mb-1">{{ $description }}</p>

    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#details" role="tab">Requisition Details</a></li>
      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#trail" role="tab">Approval Trail</a></li>
      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#finance" role="tab">Finance & Bank Approval</a></li>
    </ul>

    <div class="tab-content pt-3">
      <!-- Requisition Details -->
      <div class="tab-pane active" id="details" role="tabpanel">
        <table class="table table-bordered">
          <tr><th>Requisition ID</th><td>{{ $requisition->requisition_code }}</td></tr>
          <tr><th>Submitted By</th><td>{{ $requisition->submitted_by }}</td></tr>
          <tr><th>Type</th><td>{{ ucfirst($requisition->type) }}</td></tr>
          <tr><th>Amount</th><td>${{ number_format($requisition->amount, 2) }}</td></tr>
          <tr><th>Status</th><td><span class="badge badge-warning">{{ ucfirst($requisition->status) }}</span></td></tr>
        </table>
      </div>

      <!-- Approval Trail -->
      <div class="tab-pane" id="trail" role="tabpanel">
        <ul class="list-unstyled">
          @foreach($requisition->approvers as $index => $approver)
            @php
              $statusId = 'approverStatus' . $index;
              $buttonId = 'approverBtn' . $index;
              $isFirst = $loop->first;
            @endphp
            <li>
              <strong>{{ $approver->name }}</strong> – 
              <span id="{{ $statusId }}" class="{{ $isFirst ? 'text-warning' : 'text-muted' }}">
                {{ $isFirst ? 'Pending' : 'Waiting' }}
              </span>
              <button id="{{ $buttonId }}" class="btn btn-outline-success btn-sm" {{ $isFirst ? '' : 'disabled' }}>Approve</button>
            </li>
          @endforeach
        </ul>
        <p class="text-muted small">Approvers act in sequence based on the requisition form.</p>

        <div class="form-group mt-3">
          <label for="trailDeclineReason">Reason for Decline</label>
          <textarea class="form-control" id="trailDeclineReason" rows="2" placeholder="Optional reason if declining..."></textarea>
        </div>

        <button id="trailDeclineBtn" class="btn btn-outline-danger float-right">Decline</button>
      </div>

      <!-- Finance & Bank Approval -->
      <div class="tab-pane" id="finance" role="tabpanel">
        <ul class="list-unstyled">
          <li><strong>Finance Department</strong> – <span id="financeStatus" class="text-warning">Pending</span></li>
          <li><strong>Bank Approval</strong> – <span id="bankStatus" class="text-muted">Waiting for Finance</span></li>
        </ul>
        <p class="text-muted small">Bank cannot approve until Finance has completed their review.</p>

        <div class="form-group mt-3">
          <label for="declineReason">Reason for Decline</label>
          <textarea class="form-control" id="declineReason" rows="2" placeholder="Optional reason if declining..."></textarea>
        </div>

        <div class="mt-3">
          <button id="financeApproveBtn" class="btn btn-outline-success" disabled>Finance Approve</button>
          <button id="bankApproveBtn" class="btn btn-outline-success" disabled>Bank Approve</button>
          <button id="declineBtn" class="btn btn-outline-danger float-right">Decline</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('additional js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const financeBtn = document.getElementById('financeApproveBtn');
  const bankBtn = document.getElementById('bankApproveBtn');
  const financeStatus = document.getElementById('financeStatus');
  const bankStatus = document.getElementById('bankStatus');
  const declineBtn = document.getElementById('declineBtn');
  const declineReason = document.getElementById('declineReason');

  const totalApprovers = {{ $requisition->approvers->count() }};
  let approvedCount = 0;

  @foreach($requisition->approvers as $index => $approver)
    document.getElementById('approverBtn{{ $index }}').addEventListener('click', function () {
      const status = document.getElementById('approverStatus{{ $index }}');
      status.textContent = 'Approved';
      status.className = 'text-success';

      approvedCount++;
      if (approvedCount === totalApprovers) {
        financeBtn.disabled = false;
      }

      const nextBtn = document.getElementById('approverBtn{{ $index + 1 }}');
      const nextStatus = document.getElementById('approverStatus{{ $index + 1 }}');
      if (nextBtn && nextStatus) {
        nextBtn.disabled = false;
        nextStatus.textContent = 'Pending';
        nextStatus.className = 'text-warning';
      }
    });
  @endforeach

  financeBtn.addEventListener('click', function () {
    financeStatus.textContent = 'Approved';
    financeStatus.className = 'text-success';
    bankStatus.textContent = 'Pending';
    bankStatus.className = 'text-warning';
    bankBtn.disabled = false;
  });

  bankBtn.addEventListener('click', function () {
    bankStatus.textContent = 'Approved';
    bankStatus.className = 'text-success';
    alert('Bank has approved. Payment processing can now begin.');
  });

  declineBtn.addEventListener('click', function () {
    const reason = declineReason.value.trim();
    if (reason === '') {
      alert('Please provide a reason for declining.');
    } else {
      alert('Requisition declined with reason: ' + reason);
    }
  });

  const trailDeclineBtn = document.getElementById('trailDeclineBtn');
  const trailDeclineReason = document.getElementById('trailDeclineReason');

  trailDeclineBtn.addEventListener('click', function () {
    const reason = trailDeclineReason.value.trim();
    if (reason === '') {
      alert('Please provide a reason for declining.');
    } else {
      alert('Requisition declined with reason: ' + reason);
    }
  });
});
</script>
@endsection
