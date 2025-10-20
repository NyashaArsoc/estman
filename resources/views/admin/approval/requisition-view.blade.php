@php
$title = 'Approve Requisition';
$description = 'Review requisition details and proceed with approval or decline.';

$order = $order ?? (object)[
  'ordernumber' => 'ORD-2025-001',
  'operatorid' => 'Tariro Moyo',
  'description' => 'Procurement of laptops',
  'justification' => 'Laptops needed for new interns joining in Q4.',
  'requisitiontype' => 'procurement',
  'currencycode' => 'USD',
  'totalprice' => 1250.75,
  'status' => 'pending',
  'approvers' => collect([
    (object)['name' => 'Shania Nyaude'],
    (object)['name' => 'Blessing Chikafu'],
    (object)['name' => 'Tawanda Moyo'],
  ]),
  'items' => [
    ['name' => 'HP Laptop', 'qty' => 2, 'rate' => 500, 'vat' => 15],
    ['name' => 'Mouse', 'qty' => 2, 'rate' => 25, 'vat' => 15],
  ],
];

$attachments = [
  ['filename' => 'quotation.docx', 'url' => '#'],
];
@endphp

@extends('layout.admin-main-menu')
@section('title', $title)

@section('content')
<div class="container-fluid">
  <h4>{{ $title }}</h4>
  <ol class="breadcrumb no-bg mb-1">
    <li class="breadcrumb-item"><a href="{{ route('admapp.lstreqapp') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>

  <div class="box box-block bg-white">
    <h5>{{ $title }}</h5>
    <p class="font-90 text-muted mb-1">{{ $description }}</p>

    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#info" role="tab">Requisition Info</a></li>
      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#items" role="tab">Itemized Breakdown</a></li>
    </ul>

    <div class="tab-content pt-3">
      <!-- Requisition Info Tab -->
      <div class="tab-pane active" id="info" role="tabpanel">
        <table class="table table-bordered">
          <tr><th>Order Number</th><td>{{ $order->ordernumber }}</td></tr>
          <tr><th>Submitted By</th><td>{{ $order->operatorid }}</td></tr>
          <tr><th>Description</th><td>{{ $order->description }}</td></tr>
          <tr><th>Justification</th><td>{{ $order->justification }}</td></tr>
          <tr><th>Type</th><td>{{ ucfirst($order->requisitiontype) }}</td></tr>
          <tr><th>Currency</th><td>{{ $order->currencycode }}</td></tr>
          <tr><th>Total Amount</th><td>{{ number_format($order->totalprice, 2) }}</td></tr>
          <tr><th>Status</th><td><span class="badge badge-warning">{{ ucfirst($order->status) }}</span></td></tr>
        </table>

        <hr />
        <h6>Approval Trail</h6>
        <ul class="list-unstyled">
          @foreach($order->approvers as $approver)
            <li>
              <strong>{{ $approver->name }}</strong> – <span class="text-muted">Pending</span>
            </li>
          @endforeach
        </ul>

        <div class="form-group mt-3">
          <label for="trailDeclineReason">Reason for Decline</label>
          <textarea class="form-control" id="trailDeclineReason" rows="2" placeholder="Optional reason if declining..."></textarea>
        </div>
      </div>

      <!-- Itemized Breakdown Tab -->
      <div class="tab-pane" id="items" role="tabpanel">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Item</th>
              <th>Qty</th>
              <th>Rate</th>
              <th>VAT (%)</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->items as $item)
              @php
                $subtotal = $item['qty'] * $item['rate'];
                $vatAmount = $subtotal * ($item['vat'] / 100);
                $total = $subtotal + $vatAmount;
              @endphp
              <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['qty'] }}</td>
                <td>{{ number_format($item['rate'], 2) }}</td>
                <td>{{ $item['vat'] }}%</td>
                <td>{{ number_format($total, 2) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <hr />
        <h6>Quotation Attachment</h6>
        <ul>
          @foreach($attachments as $file)
            <li><a href="{{ $file['url'] }}" target="_blank">{{ $file['filename'] }}</a></li>
          @endforeach
        </ul>
      </div>
    </div>

    <div class="mt-4">
      <button id="finalApproveBtn" class="btn btn-success">Approve</button>
      <button id="trailDeclineBtn" class="btn btn-danger float-right">Decline</button>
    </div>
  </div>
</div>
@endsection

@section('additional js')
<script>
document.addEventListener('DOMContentLoaded', function () {
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
