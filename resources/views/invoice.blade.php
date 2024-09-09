<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="{{ asset('assets/img/logo.jpg') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link rel="stylesheet" href="{{ asset('loginform_css/invoice.css') }}">
</head>
<body>
    <div class="invoice-container">
        <header>
            <div class="invoice-header">
                <div class="company-info">
                    <h1>INNOVATIVE</h1>
                    <p>[SHOP# L-19, HASHOO CENTRE A.HAROON ROAD SADDAR KARACHI]</p>
                    <p>Phone: (021-32772452-32783268-32764525-32770195)</p>
                </div>
                <div class="invoice-title">
                    <h2>INVOICE</h2>
                </div>
            </div>
            <div class="invoice-details">
                <div>
                    <p><strong>Date:</strong> 8/28/2014</p>
                    <p><strong>Invoice #:</strong> 456</p>
                    <p><strong>Customer ID:</strong> 456</p>
                    <p><strong>Valid Until:</strong></p>
                </div>
                <div>
                    <p><strong>Company Name:</strong></p>
                    <p>M/S: Abdul Haseeb</p>
                </div>
                <div>
                    <p><strong>INNOVATIVE ELECTRONICS</strong></p>
                    <p>★★★★★</p>
                </div>
            </div>
        </header>
        <main>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gree Floor Standing 24H</td>
                        <td>1</td>
                        <td>478,000</td>
                        <td>478,000</td>
                    </tr>
                    <tr>
                        <td>TCL Split AC 24T3 Pro</td>
                        <td>1</td>
                        <td>218,000</td>
                        <td>218,000</td>
                    </tr>
                    <tr>
                        <td>Dawlance Water Dispenser</td>
                        <td>1</td>
                        <td>51,000</td>
                        <td>51,000</td>
                    </tr>
                    <tr>
                        <td>Multynet LED</td>
                        <td>1</td>
                        <td>35,000</td>
                        <td>35,000</td>
                    </tr>
                    <tr>
                        <td>Suzuki Carrier</td>
                        <td>1</td>
                        <td>100,000</td>
                        <td>100,000</td>
                    </tr>
                    <tr>
                        <td>Old Balance Samsung Top Load 1375260</td>
                        <td>2</td>
                        <td>1,000</td>
                        <td>2,000</td>
                    </tr>
                </tbody>
            </table>
        </main>
        <footer>
            <div class="notes">
                <p><strong>Note:</strong> Complete Units with all accessories.</p>
            </div>
            <div class="total-section">
                <table>
                    <tr>
                        <td>Subtotal:</td>
                        <td>₨</td>
                    </tr>
                    <tr>
                        <td>Taxable:</td>
                        <td>₨</td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td><strong>PKR 1,250,000.00</strong></td>
                    </tr>
                </table>
            </div>
            <div class="footer-note">
                <p>[Name Zarak Zubair , Email: business@innovative.com]</p>
                <p>Thank You For Your Business!</p>
            </div>
        </footer>
    </div>
</body>
</html>
