<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 11px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 1.4px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 25px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 3px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
.logo{width:100%; max-width:200px;}
    </style>

</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0"cellspacing="0"><!--first table-->
            <tr class="top">
                <td colspan="1">
                    <table><!--2nd table--><header> <h1>Tax Invoice</h1></header> 
                        <tr>
                            <td>
                                Integrated Properties<br> 
                                6th Floor Green Bridge<br> 
                            Eastgate, Harare 
                            </td>
                            <td class="title">
                                <img src="img/estman logo.png" class="logo">
                            </td>
                        </tr>
                        <tr class="information">
                            <td colspan="3">
                                <table><!--3rd table-->
                                    <tr>
                                        <td>
                                            <strong>To,</strong><br> 
                                            TenantName <br> 
                                            PremisesNo <br> 
                                            VAT:2000528132 & TIN: 220264619
                                        </td>
                                        <td>
                                            TIN:2000528132<br>   
                                            VAT: 220264619 <br>  
                                            Period: Feb 2024<br> 
                                            Invoice No: 6<br> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Currency:  USD</td>
                                        <td> Amount B/f: 200 </td>
                                    </tr>
                                </table><!--3rd table-->
                            </td>
                        </tr>
                        <tr class="heading">
                            <td>Description</td>
                            <td>Total Inc</td>
                        </tr>
                        <tr class="item">
                            <td>Rent</td>
                            <td>500</td>
                        </tr>
                        <tr class="item">
                            <td>Rates & Water</td>
                            <td>30</td>
                        </tr>
                        <tr class="item">
                            <td>Other Expenses</td>
                            <td>67</td>
                        </tr>
                        <tr class="item last">
                            <td>Interest Charged</td>
                            <td>0.67</td>
                        </tr>
                        <tr class="total">
                            <td></td>
                            <td>Current Invoice: 678</td>
                        </tr>
                        <tr class="total">
                            <td></td>
                            <td>VAT on Rent: 67</td>
                        </tr>
                        <tr class="total">
                            <td></td>
                            <td>Invoice Total: 700 </td>
                        </tr>
                    </table><!--2nd table-->
                    <table><!--4th table-->
                        <tr><td><hr></td></tr>
                        <tr class="heading"><td>Banking Details</td></tr>
                        <tr class="item"><td>Integrated Properties (USD)<br>Bank Name <br>
                        Branch <br> Account Number</td></tr>
                        <tr><td><hr></td></tr>
                        <tr class="item"><td>STATEMENT</td></tr>
                        <tr class="item"><td>Closing Remarks</td></tr>
                    </table><!--4th table-->
                </td>
            </tr>
        </table><!--first table-->
    </div>
</body>
