<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Download|Invoice No. {{ $invoice->invoice_no }}</title>

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ public_path('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Template Stylesheet -->
    <link href="{{ public_path('frontend/css/style.css') }}" rel="stylesheet">
    <link href="{{ public_path('frontend/css/custom.css') }}" rel="stylesheet">
    <link href="{{ public_path('frontend/css/app.css') }}" rel="stylesheet">
    <style>
        
        @page {
            margin: 65px 50px 50px 50px;
        }
        
        .page-header {
            position: fixed;
            top: -65px;
            width: 100%;
            margin: auto;
            
        }

        .page-footer {
            position: fixed;
            bottom: -50px;
            width: 100%;
            
        }

        .footer-text {
            text-align: center;
        }

        .logo {
            width: 150px;
            float: right;
        }

        @page {
            page-break-after: always;
            position: relative;
            counter-increment: page
        }

        .page-counter {
            font-weight: 600;
        }

        .page-counter:after {
            content: " - (" counter(page) ")";
        }

        .ic_name {
            color: #0355D0;
            font-size: 18px
        }

        .ic_address {
            color: #000;
        }

        .ic_phone {
            color: #0355D0;
        }

        .invoice_date {
            color: #000;
            font-weight: bold;
        }

        .invoice_no {
            color: #0355D0;
            font-weight: bold;
            font-size: 16px;
            padding: 5px 70px 5px 0px;
        }

        .invoice-box {
            border: 1px solid black;
            
        }

        .invoice-section {
            white-space: pre-line;
        }

        .company_email {
            color: #FB5404;
        }
        

        .invoice_date_col {
            text-align: right;
            padding-right: 10px;
            width: 400px;
        }

        .invoice_table {
            width: 100%
        }

        .invoice_table thead {
            color: #fff;
            background: #0355D0;
            text-align: center;
        }

        .invoice_table tbody td {
            border: 1px solid #ccc;
            color: #000;
        }
        
    </style>
</head>
<body>
    <div class="page-header">
        <!--Company Logo-->
        <div class="logo">
            <img class="" src="{{ public_path('/img/logo/ic-logo.png') }}" alt="IC Logo" width="150">
        </div>
    </div>

    <div class="page-footer">
        <p class="footer-text">© infinitycareers.com.mm</p>
    </div>
    <div>
        <p class="ic_name">Infinity Careers Co.,Ltd</p>
        <p class="ic_address">No (47), Thazin Street, Ahlone Township, Yangon</p>
        <p class="ic_phone">09 880915475, 09 880915476</p>
    </div>
    <div class="invoice-section">
        <span class="invoice_no">Invoice No. - {{ $invoice->invoice_no }}</span>
    </div>
    <div class="invoice-section">
        <table>
            <tr>
                <td><span class="ic_address">{{ $invoice->PointOrder->Employer->name }}</span></td>
                <td class="invoice_date_col"><span class="ic_address"><span class="invoice_date">Invoice Date : </span> {{ date('d/m/Y', strtotime($invoice->created_at)) }}</span></td>
            </tr>
            <tr>
                <td><span class="ic_address">{{ $invoice->PointOrder->name }}</span></td>
            </tr>
            <tr>
                <td><span class="ic_address">{{ $invoice->PointOrder->Employer->EmployerAddress->first()->address_detail }}</span></td>
            </tr>
            <tr>
                <td><span class="ic_address">{{ $invoice->PointOrder->phone }}</span></td>
            </tr>
            <tr>
                <td><span class="company_email">{{ $invoice->PointOrder->Employer->email }}</span></td>
            </tr>
        </table>
        
    </div>
    <table class="invoice_table">
        <thead>
            <tr>
                <th>DESCRIPTION</th>
                <th>QTY</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="background: #f3f3f3">
                <td>{{ $invoice->PointOrder->PointPackage->point }} x Points purchasing</td>
                <td style="text-align: center">1</td>
                <td style="text-align: right; padding-right: 10px">{{ number_format($invoice->PointOrder->PointPackage->price) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">SUBTOTAL</td>
                <td style="text-align: right; background: #f3f3f3; padding-right: 10px">{{ number_format($invoice->PointOrder->PointPackage->price) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">Commercial Tax ({{ $tax->tax }} %)</td>
                <td style="text-align: right; background: #f3f3f3; padding-right: 10px">{{ number_format($tax_amount) }}</td>
            </tr>
            <tr style="border: none">
                <td colspan="3" style="border: none">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="border:none; text-align: right; color: #0355D0; font-size: 18px; font-weight: bold">Balance Due</td>
                <td style="text-align: right; background: #0355D0; color: #fff; padding-right: 10px">{{ number_format($final_balance) }}</td>
            </tr>
        </tbody>
    </table>
    <div>
        @foreach($banks as $bank)
        <p><span class="ic_address"><span class="invoice_date">Account Name : </span> {{ $bank->account_name }}</span></p>
        <p><span class="ic_address"><span class="invoice_date">Bank Name : </span> {{ $bank->bank_name }}</span></p>
        <p><span class="ic_address"><span class="invoice_date">Account No : </span> {{ $bank->account_no }}</span></p>
        <hr style="border: 1px solid #ccc">
        @endforeach
    </div>
</body>
</html>