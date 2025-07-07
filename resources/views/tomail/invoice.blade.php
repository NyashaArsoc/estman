<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        #firsttable {
            width: 60%;
            border-collapse: collapse;
            /* Remove borders */
            margin-right: 0;
            margin-left: auto;
            /* Push table to the right */
            font-family: Arial, sans-serif;
        }

        .right-cell {
            padding: 10px;
            text-align: right;
            /* Align text to the right for the right cell */
        }

        .logo {
            width: 50%;
            max-width: 150px;
        }

        #addresstable {
            width: 100%;
            border-collapse: collapse;
            /* Remove borders */
            margin-right: 0;
            margin-left: auto;
            /* Push table to the right */
        }

        #descrptiontable {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
            /* Remove borders */
        }

        /* Styles for the second row (with borders) */
        .bordered td {
            border: 1.5px solid #000;
            /* Black border */
            padding: 3px;
            /* Padding for spacing */
        }

        #bottomline {
            border-bottom: 1px solid #000;
            /* Bottom border for the last cell */
        }

        #textright {
            text-align: right;
        }

        #textleft {
            text-align: left;
        }

        .footer {
            text-align: left;
            /* Align text to the left */
            padding: 10px;
            /* Padding for spacing */
            margin-top: auto;
            /* Push footer to the bottom */
            border-top: 1px solid #000;
            /* Top border for the footer */
        }

        .company-name {
            text-align: right;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <table id="firsttable">
        <tr>
            <td></td>
            <td class="company-name">Integrated Properties</td>
        </tr>
        <tr>
            <td><strong>{{$invoicetitle}}<strong></td>
            <td class="right-cell"><img src="https://intpro.co.zw/wp-content/uploads/2023/02/newlogo2.png" class="logo"></td>
        </tr>
    </table>
    <table id="addresstable">
        <tr>
            <td><strong>Attention:</strong> {{$tenantname}}<br>{{$propdesc}}
            </td>
            <td class="right-cell">6th Floor Green Bridge<br />Eastgate, Harare<br />Tel. +263 8677030000</td>
        </tr>
        <tr>
            <td>VAT Number: {{$tenantvatnumber ?? ''}}<br>TIN: {{$tenanttinnumber ?? ''}}
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="right-cell">Integrated PropertiesVAT: 220141335<br>Integrated Properties TIN: 2000036892</td>
        </tr>
    </table>
    <table id="firsttable">
        <tr>
            <td>Currency</td>
            <td>Period</td>
            <td>Invoice Date</td>
            <td>Invoice No</td>
        </tr>
        <tr class="bordered">
            <td>{{$currencycode ?? ''}}</td>
            <td>{{$period ?? ''}}</td>
            <td>{{$today ?? ''}}</td>
            <td>{{$invoicenumber ?? ''}}</td>
        </tr>
    </table>
    <table id="addresstable">
        <tr>
            <td>Deposit: {{$deposit ?? 0}}</td>
            <td></td>
            <td class="right-cell">Balance bd: {{$balancebd ?? 0}}</td>
        </tr>
    </table>
    <table id="descrptiontable">
        <thead>
            <tr id="bottomline">
                <th id="textleft">No</th>
                <th id="textleft">Item Description</th>
                <th id="textright">Amount (Exc)</th>
                <th id="textright">Amount (Inc)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Rental:</td>
                <td id="textright">{{$rentbeforevat ?? 0}}</td>
                <td id="textright">{{$rent ?? 0}}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Rates & Levies:</td>
                <td id="textright">{{$rateswater ?? 0}}</td>
                <td id="textright">{{$rateswater ?? 0}}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Operational Costs:</td>
                <td id="textright">{{$operational ?? 0}}</td>
                <td id="textright">{{$operational ?? 0}}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Interest:</td>
                <td id="textright">{{$interestcharged ?? 0}}</td>
                <td id="textright">{{$interestcharged ?? 0}}</td>
            </tr>
            <tr id="bottomline"> </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Total (Exc)</td>
                <td id="textright">{{$totalbilledexc ?? 0}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>VAT </td>
                <td id="textright">{{$rentvat ?? 0}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Total (Inc)</td>
                <td id="textright">{{$totalvatincl ?? 0}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td id="bottomline"></td>
                <td id="bottomline"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Total</td>
                <td id="textright">{{$invoicetotal ?? 0}}</td>
            </tr>
            <tr id="bottomline">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table><br>
    <table id="descrptiontable">
        <tr>
            <td>Banking Details</td>
        </tr>
        <tr>
            <td>Integrated Properties ( $currencycode )<br> $bankname <br>
                $branch <br> $accountnumber </td>
        </tr>
        <tr id="bottomline"> </tr>
        <tr>
            <td>STATEMENT <br> Closing Remarks</td>
        </tr>
    </table>
    <div class="footer">&copy; estman</div>
</body>

</html>