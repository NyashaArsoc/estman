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
      background-color: #0b2c4d;
      color: #fff;
      padding: 20px 30px;
      border-radius: 8px;
      margin-bottom: 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .logo-block {
      font-size: 22px;
      font-weight: bold;
      letter-spacing: 1px;
      background-color: #ffffff;
      color: #0b2c4d;
      padding: 6px 12px;
      border-radius: 4px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
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
      box-shadow: 0 1px 3px rgba(0,0,0,0.05);
      margin-bottom: 25px;
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

    th, td {
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

    .totals-row td {
      font-weight: bold;
      background-color: #f4f6f7;
    }

    .details-table td {
      padding: 6px 10px;
    }

    .details-table strong {
      color: #34495e;
    }
  </style>
</head>
<body>

  <div class="header">
    <div class="logo-block">ESTMAN</div>
    <div class="header-text">
      <h2>Order Summary</h2>
      <p>Generated on {{ now()->format('d M Y') }}</p>
    </div>
  </div>

  <div class="section">
    <table class="details-table">
      <tr>
        <td><strong>Order Number:</strong></td>
        <td>ORD - {{ $order->id }}</td>
      </tr>
      <tr>
        <td><strong>Submitted By:</strong></td>
        <td>{{ $order->submitted_by ?? '—' }}</td>
      </tr>
      <tr>
        <td><strong>Currency:</strong></td>
        <td>{{ $order->currencycode }}</td>
      </tr>
      <tr>
        <td><strong>Total Amount:</strong></td>
        <td>{{ number_format($order->total_amount, 2) }}</td>
      </tr>
      <tr>
        <td><strong>Justification:</strong></td>
        <td>{{ $order->justification }}</td>
      </tr>
      <tr>
        <td><strong>Requisition Type:</strong></td>
        <td>{{ ucfirst($order->requisitiontype) }}</td>
      </tr>
    </table>
  </div>

  <div class="section">
    <h4>Descriptions</h4>
    <p>{{ $order->description }}</p>
  </div>

  @php $type = strtolower(trim($order->requisitiontype)); @endphp

  @if($type === 'product')
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
          @php $count = 1; @endphp
          @forelse($order->items as $item)
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $item->item }}</td>
              <td>{{ $item->quantity }}</td>
              <td>{{ number_format($item->rate, 2) }}</td>
              <td>{{ number_format($item->vat, 2) }}</td>
              <td>{{ number_format($item->totalprice, 2) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align: center;">No product items available.</td>
            </tr>
          @endforelse
          <tr class="totals-row">
            <td colspan="3">Totals</td>
            <td>{{ $order->currencycode }} {{ number_format($order->total_amount, 2) }}</td>
            <td>{{ $order->currencycode }} {{ number_format($order->total_amount, 2) }}</td>
            <td>{{ $order->currencycode }} {{ number_format($order->total_amount, 2) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  @elseif($type === 'service')
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
          @php $count = 1; @endphp
          @forelse($order->items as $item)
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $item->item }}</td>
              <td>{{ number_format($item->rate, 2) }}</td>
              <td>{{ number_format($item->vat, 2) }}</td>
              <td>{{ number_format($item->totalprice, 2) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="text-align: center;">No service items available.</td>
            </tr>
          @endforelse
          <tr class="totals-row">
            <td colspan="4">Total</td>
            <td>{{ $order->currencycode }} {{ number_format($order->total_amount, 2) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  @endif

</body>
</html>
