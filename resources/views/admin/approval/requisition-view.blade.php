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

    <div class="mt-3">
      <button id="finalApproveBtn" class="btn btn-success">Approve</button>
      <button id="trailDeclineBtn" class="btn btn-danger float-right">Decline</button>
    </div>
  </div>
</div>
<!-- Content End -->
@endsection

@section('additional js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const totalApprovers = {{ $order->approvers->count() ?? 0 }};
  let approvedCount = 0;

  @foreach($order->approvers ?? [] as $index => $approver)
    document.getElementById('approverBtn{{ $index }}')?.addEventListener('click', function () {
      const status = document.getElementById('approverStatus{{ $index }}');
      status.textContent = 'Approved';
      status.className = 'text-success';

      approvedCount++;
      const nextBtn = document.getElementById('approverBtn{{ $index + 1 }}');
      const nextStatus = document.getElementById('approverStatus{{ $index + 1 }}');
      if (nextBtn && nextStatus) {
        nextBtn.disabled = false;
        nextStatus.textContent = 'Pending';
        nextStatus.className = 'text-warning';
      }
    });
  @endforeach

  document.getElementById('finalApproveBtn')?.addEventListener('click', function () {
    alert('Requisition approved.');
  });

  document.getElementById('trailDeclineBtn')?.addEventListener('click', function () {
    const reason = document.getElementById('trailDeclineReason').value.trim();
    if (reason === '') {
      alert('Please provide a reason for declining.');
    } else {
      alert('Requisition declined with reason: ' + reason);
    }
  });
});
</script>
@endsection
