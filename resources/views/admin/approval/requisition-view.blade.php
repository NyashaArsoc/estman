@php
$title = 'Approve Requisition';
$description = 'Review requisition details and proceed with approval or decline.';
@endphp

@extends('layout.admin-main-menu')
@section('title', $title)

@section('content')
<!-- Content Start -->
<div class="container-fluid">
  <h4>{{ $title }}</h4>
  <ol class="breadcrumb no-bg mb-1">
    <li class="breadcrumb-item"><a href="{{ route('admapp.lstreqapp') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>

  <div class="box box-block bg-white">
    <h5>{{ $title }}</h5>
    <p class="font-90 text-muted mb-1">{{ $description }}</p>

    <div class="table-responsive">
      <hr />
      <table class="table table-bordered">
        <tbody>
          <tr><th>Order Number</th><td>{{ $order->ordernumber ?? '' }}</td></tr>
          <tr><th>Submitted By</th><td>{{ $order->operatorid ?? '' }}</td></tr>
          <tr><th>Description</th><td>{{ $order->description ?? '' }}</td></tr>
          <tr><th>Type</th><td>{{ ucfirst($order->requisitiontype ?? '') }}</td></tr>
          <tr><th>Amount</th><td>{{ $order->currencycode ?? '' }} {{ number_format($order->totalprice ?? 0, 2) }}</td></tr>
          <tr><th>Status</th><td><span class="badge badge-warning">{{ ucfirst($order->status ?? '') }}</span></td></tr>
        </tbody>
      </table>
    </div>

    <hr />
    <h6>Approval Trail</h6>
    <ul class="list-unstyled">
      @foreach($order->approvers ?? [] as $index => $approver)
        @php
          $statusId = 'approverStatus' . $index;
          $buttonId = 'approverBtn' . $index;
          $isFirst = $loop->first;
        @endphp
        <li>
          <strong>{{ $approver->name ?? 'Approver' }}</strong> – 
          <span id="{{ $statusId }}" class="{{ $isFirst ? 'text-warning' : 'text-muted' }}">
            {{ $isFirst ? 'Pending' : 'Waiting' }}
          </span>
          <button id="{{ $buttonId }}" class="btn btn-outline-success btn-sm" {{ $isFirst ? '' : 'disabled' }}>Approve</button>
        </li>
      @endforeach
    </ul>

    <div class="form-group mt-3">
      <label for="trailDeclineReason">Reason for Decline</label>
      <textarea class="form-control" id="trailDeclineReason" rows="2" placeholder="Optional reason if declining..."></textarea>
    </div>
    <button id="trailDeclineBtn" class="btn btn-outline-danger float-right">Decline</button>

    <hr />
    <h6>Finance & Bank Approval</h6>
    <ul class="list-unstyled">
      <li><strong>Finance Department</strong> – <span id="financeStatus" class="text-warning">Pending</span></li>
      <li><strong>Bank Approval</strong> – <span id="bankStatus" class="text-muted">Waiting for Finance</span></li>
    </ul>

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
<!-- Content End -->
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

  const totalApprovers = {{ $order->approvers->count() ?? 0 }};
  let approvedCount = 0;

  @foreach($order->approvers ?? [] as $index => $approver)
    document.getElementById('approverBtn{{ $index }}')?.addEventListener('click', function () {
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

  financeBtn?.addEventListener('click', function () {
    financeStatus.textContent = 'Approved';
    financeStatus.className = 'text-success';
    bankStatus.textContent = 'Pending';
    bankStatus.className = 'text-warning';
    bankBtn.disabled = false;
  });

  bankBtn?.addEventListener('click', function () {
    bankStatus.textContent = 'Approved';
    bankStatus.className = 'text-success';
    alert('Bank has approved. Payment processing can now begin.');
  });

  declineBtn?.addEventListener('click', function () {
    const reason = declineReason.value.trim();
    if (reason === '') {
      alert('Please provide a reason for declining.');
    } else {
      alert('Requisition declined with reason: ' + reason);
    }
  });

  const trailDeclineBtn = document.getElementById('trailDeclineBtn');
  const trailDeclineReason = document.getElementById('trailDeclineReason');

  trailDeclineBtn?.addEventListener('click', function () {
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
