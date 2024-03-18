<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .invoice {
      text-align: left;
    }

    .invoice table {
      width: 100%;
      border-collapse: collapse;
    }

    .invoice th, .invoice td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }

    .invoice th {
      background-color: #f1f1f1;
    }

    .total {
      margin-top: 20px;
      text-align: right;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Invoice</h1>
    </div>
    <div class="invoice">
      <table>
        <thead>
          <tr>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Item 1</td>
            <td>2</td>
            <td>$10.00</td>
            <td>$20.00</td>
          </tr>
          <tr>
            <td>Item 2</td>
            <td>1</td>
            <td>$15.00</td>
            <td>$15.00</td>
          </tr>
          <tr>
            <td>Item 3</td>
            <td>3</td>
            <td>$5.00</td>
            <td>$15.00</td>
          </tr>
        </tbody>
      </table>
      <div class="total">
        Total: $50.00
      </div>
    </div>
  </div>
</body>
</html>
