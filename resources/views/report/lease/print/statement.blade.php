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
                    <table><!--2nd table--><header> <h1>STATEMENT OF ACCOUNT</h1></header> 
                        <tr>
                            <td>  @php
                                if ($lease->clienttypeid == 1){//individual
                                $tenantname   =  $lease->fullname ;
                             }else{
                                 $tenantname   =  $lease->companyname ;
                             } 
                            @endphp 
                                {{$tenantname}}<br> 
                                {{$lease->propertydescription}}<br> 
                                {{$date}}
                            </td><td></td><td></td><td></td>
                            <td class="title">
                                <img src="img/intpro logo 2020.png" class="logo">
                            </td>
                        </tr>
                        <tr class="information">
                            <td colspan="3">
                                <table><!--3rd table-->
                                    <tr>
                                        <td> Currency: {{$currencycode}} </td>
                                    </tr>
                                </table><!--3rd table-->
                            </td>
                        </tr></table><table>
                        <tr class="heading">
                            <td>DATE</td>
                            <td>REF.No</td>
                            <td>DEBIT/CREDIT</td>
                            <td>NARRATION</td>
                            <td>AMOUNT</td>
                        </tr>
                        @foreach ($status as $abc)
                        @php 
                        if (trim($abc->trxtype) == 'TD'){
                            $trxtype = 'DEBIT';
                        }else if (trim($abc->trxtype) == 'TC'){
                            $trxtype = 'CREDIT';
                        }  @endphp
                        <tr class="item">
                            <td>{{$abc->trxsystemdate }}</td>
                            <td>{{$abc->trxreference }} </td>
                            <td>{{$trxtype }}</td>
                            <td> {{$abc->trxdescription }} </td>
                            <td>{{number_format($abc->trxamount,2) }}</td>
                        </tr>
                        @endforeach
                    </table><!--2nd table--><hr>
                    Balance Due<table><!--4th table-->
                        <tr class="heading"><td>10 Days</td><td>30 Days</td><td>60 Days</td><td>90 Days</td>
                            <td>above 90 Days</td></tr>
                        <tr class="item"><td> {{$day10 ?? 0}}</td><td> {{$day30 ?? 0}}</td><td> {{$day60 ?? 0}}
                        </td><td> {{$day90 ?? 0}}</td><td> {{$dayabove90 ?? 0}}</td></tr>
                        @php $totaldue = $day10 + $day30 + $day60 + $day90 + $dayabove90 @endphp
                        <tr><td></td><td></td><td></td><td>Total Due</td><td>{{$totaldue ?? 0}}</td></tr>
                    </table><!--4th table-->
                </td>
            </tr>
        </table><!--first table-->
    </div>
</body>
