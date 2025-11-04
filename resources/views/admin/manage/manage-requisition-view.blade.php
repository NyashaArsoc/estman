@php
$title = 'View Requisition';
$description = 'Review requisition details and download if needed.';
@endphp

@extends('layout.no-menu-layout')

@section('title', $title)

@section('content')
<div class="container-fluid">
  <h4>{{ $title }}</h4>
  <ol class="breadcrumb no-bg mb-1">
    <li class="breadcrumb-item"><a href="{{ route('dash.admin') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('adman.allorder') }}">List</a></li>
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
          <tr>
            <th>Order Number</th>
            <td>ORD-{{ $order->id }}</td>
          </tr>
          <tr>
            <th>Submitted By</th>
            <td>{{ $order->operatorid }}</td>
          </tr>
          <tr>
            <th>Description</th>
            <td>{{ $order->description }}</td>
          </tr>
          <tr>
            <th>Justification</th>
            <td>{{ $order->justification }}</td>
          </tr>
          <tr>
            <th>Type</th>
            <td>{{ ucfirst($order->requisitiontype) }}</td>
          </tr>
          <tr>
            <th>Total Amount</th>
            <td>{{ $order->currencycode }} {{ number_format($order->overraltotal, 2) }}</td>
          </tr>
          <tr>
            <th>Status</th>
            <td><span class="badge badge-warning">{{ ucfirst($order->status) }}</span></td>
          </tr>
        </table>
      </div>

      <!-- Itemized Breakdown Tab -->
      <div class="tab-pane" id="items" role="tabpanel">
        @php $count = 1; $type = strtolower(trim($order->requisitiontype)); @endphp

        @if($type === 'product')
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Item</th>
              <th>Qty</th>
              <th>Rate</th>
              <th>VAT (%)</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orderdetails as $abc)
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $abc->item }}</td>
              <td>{{ $abc->quantity }}</td>
              <td>{{ number_format($abc->rate, 2) }}</td>
              <td>{{ number_format($abc->vat, 2) }}</td>
              <td>{{ number_format($abc->totalprice, 2) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @elseif($type === 'service')
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Service</th>
              <th>Rate</th>
              <th>VAT (%)</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orderdetails as $abc)
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $abc->item }}</td>
              <td>{{ number_format($abc->rate, 2) }}</td>
              <td>{{ number_format($abc->vat, 2) }}</td>
              <td>{{ number_format($abc->totalprice, 2) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif

        <hr />
        <h6>Quotation Attachment</h6>
        <ul>
          @foreach($orderattachment as $abc)
          <li>
            @php
            $attachement = Crypt::encrypt($abc->attachment);
            $requiredpdf = (!is_null($abc->attachment)) ? route('admapp.dwnquoteordr',[$attachement]) : '';
            $attachementrequiredpdf = (!is_null($abc->attachment)) ? 'Download file' : '';
            @endphp
            <a href="{{ $requiredpdf }}" target="_blank">{{ $attachementrequiredpdf }}</a>
          </li>
          @endforeach
        </ul>
      </div>
    </div>

    <div class="mt-4">
      <a href="{{ route('adman.dwnreqordr', Crypt::encrypt($order->id)) }}" class="btn btn-info">Download Requisition</a>
    </div>
  </div>
</div>
@endsection