<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Order Summary</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      font-size: 13px;
      color: #2c3e50;
      background-color: #f4f6f7;
      margin: 0;
      padding: 30px;
    }

    .header {
      background-color: #1a5276;
      color: #fff;
      padding: 20px 30px;
      border-radius: 8px;
      margin-bottom: 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .header img {
      height: 50px;
    }

    .header-text {
      text-align: right;
    }

    .header-text h2 {
      margin: 0;
      font-size: 24px;
    }

    .header-text p {
      margin-top: 5px;
      font-size: 12px;
      color: #d6eaf8;
    }

    .section {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      margin-bottom: 25px;
    }

    .details-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px 30px;
    }

    .details-grid p {
      margin: 5px 0;
    }

    .details-grid strong {
      display: inline-block;
      width: 120px;
      color: #34495e;
    }

    .section h4 {
      margin-bottom: 15px;
      color: #2e4053;
      border-bottom: 1px solid #d5d8dc;
      padding-bottom: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th,
    td {
      border: 1px solid #d5d8dc;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #eaf2f8;
      color: #1a5276;
    }

    tr:nth-child(even) {
      background-color: #fdfefe;
    }

    .status-badge {
      display: inline-block;
      padding: 6px 12px;
      background-color: #27ae60;
      color: #fff;
      border-radius: 20px;
      font-weight: bold;
      font-size: 12px;
    }

    .totals-row td {
      font-weight: bold;
      background-color: #f4f6f7;
    }
  </style>
</head>

<body>

  <div class="header">
    <img src="https://uatwlqqahsybwdryppbh.supabase.co/storage/v1/object/public/images/logos/logo-light.png" alt="ESTMAN Logo">
    <div class="header-text">
      <h2>Order Summary</h2>
      <p>Generated on {{ now()->format('d M Y') }}</p>
    </div>
  </div>

  <div class="section">
    <div class="details-grid">
      <p><strong>Order Number:</strong> ORD - {{ $order->id }}</p>
      <p><strong>Submitted By:</strong> {{ $order->operatorid }}</p>
      <p><strong>Justification:</strong>{{ $order->justification }}</p>
      <p><strong>Requisition Type:</strong>{{ ucfirst($order->requisitiontype) }}</p>
    </div>
  </div>

  <div class="section">
    <h4>Descriptions</h4>
    <p>{{ $order->description }}</p>
  </div>

  @if(trim($order->requisitiontype) === 'product')
  <div class="section">
    <h4>Product Breakdown</h4>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Item</th>
          <th>Qty</th>
          <th>Rate</th>
          <th>VAT</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @php $count=1;@endphp
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
        <tr>
          <td colspan="6" style="text-align: center;">No product items available.</td>
        </tr>
        <tr class="totals-row">
          <td colspan="3">Totals</td>
          <td>{{ $order->currencycode }} {{ number_format($order->overraltotal, 2) }}</td>
          <td>{{ $order->currencycode }} {{ number_format($order->overraltotal, 2) }}</td>
          <td>{{ $order->currencycode }} {{ number_format($order->overraltotal, 2) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  @elseif(trim($order->requisitiontype)=== 'service')
  <div class="section">
    <h4>Service Breakdown</h4>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Item</th>
          <th>Rate</th>
          <th>VAT</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @php $count=1;@endphp
        @foreach($orderdetails as $abc)
        <tr>
          <td>{{ $count++ }}</td>
          <td>{{ $abc->item }}</td>
          <td>{{ number_format($abc->rate, 2) }}</td>
          <td>{{ number_format($abc->vat, 2) }}</td>
          <td>{{ number_format($abc->totalprice, 2) }}</td>
        </tr>
        @endforeach
        <tr class="totals-row">
          <td colspan="3">Total</td>
          <td>{{ $order->currencycode }} {{ number_format($order->overraltotal, 2) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  @endif
</body>

</html>