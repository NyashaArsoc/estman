<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .invoice-box {
            max-width: 100%;
            margin: auto;
            padding: 30px;
            box-shadow: 0 0 0px rgba(0, 0, 0, .15);
            border: 1px solid #eee;
            font-size: 10px;
            line-height: 24px;
            font-family: "Lucida Console", "Courier New", monospace;
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
            text-align: left;
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
            font-family: "Lucida Console", "Courier New", monospace;
        }

        .rtl table {
            text-align: left;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
.logo{width:100%; max-width:200px;}
table.reporttable {
  border: 0px solid #1C6EA4;
  background-color: #EEEEEE;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
 
}
table.reporttable td, table.reporttable th {
  border: 0px solid #e7dede;
  padding: 1px 0px;
  border-left: 1px solid #dd0e1f;
}
table.reporttable tbody td {
  font-size: 13px;
}
table.reporttable tr:nth-child(even) {
    
  background: #D0E4F5;
}
table.reporttable thead {
  background: #086F30;
  
  border-bottom: 1px solid #444444;
}
table.reporttable thead th {
  font-size: 15px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  border-left: 1px solid rgb(240, 247, 244);
}
table.reporttable thead th:first-child {
  border-left: none;
}

table.reporttable tfoot td {
  font-size: 14px;
}
table.reporttable tfoot .links {
  text-align: right;
}
table.reporttable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}

    </style>

</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0"cellspacing="0"><!--first table-->
            <tr class="top">
                <td colspan="1">
                    <table><!--2nd table--><header> <h1>Landlord Status</h1></header> 
                        <tr>
                            <td class="title">
                                <img src="img/intpro logo 2020.png" class="logo">
                            </td>
                        </tr>
                    </table><!--2nd table-->
                </td>
            </tr>
        </table><!--first table-->
        <table class="reporttable">
            <thead>
            <tr>
                <th>No</th>
                <th>Type</th>
                <th>Name</th>
                <th>Reg</th>
                <th>Cell</th>
                <th>Email</th>
                <th>All Prop</th>
                <th>Active Prop</th>
                <th>Status </th>
            </tr>
            </thead>
            <tbody>@php $count=1;@endphp
                @foreach ($status as $abc)
                @php if ($abc->clienttypeid == 1){//individual
                    $owner   =  $abc->fullname ;
                    $registration   =  $abc->nationalID ;
                 }else{
                    $owner   =  $abc->companyname ;
                    $registration   =  $abc->companynumber ;
                 }
                 if (trim($abc->available) == 'Y'){
                     $status = 'available';
                  }else if (trim($abc->available) == 'D'){//include the deleted status
                   $status = 'deleted';
                  }else{
                   if (trim($abc->approval) == 'R'){ 
                   $status = 'rejected';
                    }else{
                   $status = 'inactive';
                   }
                 }
                 @endphp
                <tr>
            <td>{{$count ++}}</td>
            <td> {{$abc->typedescription }}</td>
            <td>{{ $owner}}</td>
            <td> {{$registration}} </td>
            <td> {{$abc->cell }}</td>
            <td>{{ $abc->email }}</td>
            <td>{{ $abc->allproperty }}</td>
            <td> {{$abc->activeproperty }}</td>
            <td>{{ $status }}</td>
            </tr>
            @endforeach
            </tbody>
            </table><br/>
            <footer class="footer">
                        <div class="col-sm-5 text-sm-left mb-0-5 mb-sm-0">
                            © <a class="nav-link text-black" target="new"
                                href="https://www.arsoc.co.zw">ESTMAN</a><br>
                                <p> {{$date}} </p>
                        </div>
            </footer>
    </div>
</body>
