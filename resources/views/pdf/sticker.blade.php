<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shipping Label</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 5in; /* Adjust width to 4 inches */
        height: 4in; /* Adjust height to 3 inches */
        border: 1px solid #000;
        padding: 0.2in; /* Adjust padding as needed */
    }
    .row {
        display: table;
        width: 100%;
    }
    .column {
        display: table-cell;
        border-right: 1px solid #000;
        padding: 0.1in; /* Adjust padding as needed */
        text-align: center;
        vertical-align: middle;
    }
    .logo img {
        max-width: 100%;
    }
    .barcode img,
    .qrcode img {
        max-width: 80%; /* Adjust width of barcode and QR code */
        height: auto;
    }
    .second-row {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
    }
    .single-column {
        padding: 0.05in; /* Adjust padding as needed */
        text-align: center;
    }
    .third-row,
    .fourth-row {
        border-top: 1px solid #000;
    }
    .barcode-column {
        width: 75%;
        border-right: 1px solid #000;
        padding: 0.1in; /* Adjust padding as needed */
    }
    .qrcode-column {
        width: 25%;
        padding: 0.1in; /* Adjust padding as needed */
    }
    .three-columns {
        width: 75%; /* Adjust width of three columns */
        display: table-cell;
        vertical-align: top;
    }
    .three-columns .single-column {
        border-bottom: 1px solid #000;
        text-align: center;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="row" style="height: 0.1in;">
            <div class="column logo" style="width: 1.66in;">
                <img style="max-width: 40%;" src="{{ public_path('images/logo.jpeg') }}" alt="">
            </div>
            <div class="column order-details">
                <div>Order-ID:{{ $order->id }}</div>
            </div>
            <div class="column barcode">
                {{ now()->format('Y-m-d') }}
            </div>
        </div>
        <div class="row second-row">
            <div class="single-column">
                <img style="max-width: 50%;" src="{{ public_path('images/barcode.png') }}" alt="Barcode">
            </div>
        </div>
        <div class="row third-row">
            <div class="column barcode-column">
                <img style="max-width: 90%;" src="{{ public_path('images/barcode.png') }}" alt="Barcode">
            </div>
            <div class="column three-columns">
                <div class="single-column">Inside Dhaka</div>
                <div class="single-column">Cash On Delivery</div>
                <div class="single-column">{{ $order->total_price }}</div>
            </div>
        </div>
        <div class="row fourth-row">
            <div class="column qrcode-column">
                <img style="max-width: 100%;" src="{{ public_path('images/qr.png') }}" alt="QRcode">
            </div>
            <div class="column three-columns">
                <div class="single-column">Reciplient: {{ $order->customer->full_name }}, {{ $order->detail_address }}, {{ $order->customer->phone }}</div>
                <div class="single-column">Seller: Flare Brand - www.flarebrandbd.com - newmarket dhaka - 8801994635351</div>
                <div class="single-column">Package Weight: 2</div>
            </div>
        </div>
    </div>
</body>
</html>
