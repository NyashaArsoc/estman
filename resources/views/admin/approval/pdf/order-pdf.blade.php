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

    .logo {
      margin-bottom: 10px;
    }

    .header {
      background-color: #1a5276;
      color: #fff;
      padding: 20px;
      text-align: center;
      border-radius: 8px;
      margin-bottom: 30px;
    }

    .header h2 {
      margin: 0;
      font-size: 24px;
    }

    .header p {
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

    .status-badge {
      display: inline-block;
      padding: 6px 12px;
      background-color: #27ae60;
      color: #fff;
      border-radius: 20px;
      font-weight: bold;
      font-size: 12px;
    }
  </style>
</head>
<body>
  <div class="logo">
    <img src="{{ public_path('ESTMANLOGO.png') }}" alt="ESTMAN Logo" style="height: 50px;">
  </div>

  <div class="header">
    <h2>Order Summary</h2>
    <p>Generated on</p>
  </div>

  <div class="section">
    <div class="details-grid">
      <p><strong>Order Number:</strong></p>
      <p><strong>Submitted By:</strong></p>
      <p><strong>Currency:</strong></p>
      <p><strong>Total Amount:</strong></p>
      <p><strong>Justification:</strong></p>
      <p><strong>Requisition Type:</strong></p>
    </div>
  </div>

  <div class="section">
    <h4>Descriptions</h4>
    <p></p>
  </div>

  <div class="section">
    <h4>Product Breakdown</h4>
    <table>
      <thead>
        <tr>
          <th>Item</th>
          <th>Qty</th>
          <th>Rate</th>
          <th>VAT (%)</th>
          <th>Subtotal</th>
          <th>VAT Amount</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="7" style="text-align: center;">No product items available.</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="section">
    <p><strong>Status:</strong> <span class="status-badge"></span></p>
  </div>
</body>
</html>
