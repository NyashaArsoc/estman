<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Report</title>
    <style>
        #items {
            font-family: Lucida Console, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #items td,
        #items th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #items tr:nth-child(even) {
            background-color: #f2f2ff;
        }

        #items tr:hover {
            background-color: #ddd;
        }

        #items th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>
    <h4>Valuation Compilation Status :{{ \Carbon\Carbon::parse($mondayfirstday)->format('d M, Y') }}
        to {{ \Carbon\Carbon::parse($sundaylastday)->format('d M, Y')}}</h4><br />
    <table id="items">
        <thead>
            <tr>
                <th>Name</th>
                <th>Assigned CW</th>
                <th>Completed CW</th>
                <th>Pending CW</th>
                <th>Pending 1W+</th>
                <th>Total Pending</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($normalindividual as $abc)
            <tr>
                <td>{{ $abc->fullname }}</td>
                <td>{{ $abc->assignthisweek }}</td>
                <td>{{ $abc->completedthisweek }}</td>
                <td>{{ $abc->pendingcurrentweek}}</td>
                <td>{{ $abc->pendingweekplus }}</td>
                <td>{{ $abc->totalpending }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br />
    <hr />
    <h4>Valuations Tasks Summary</h4>
    <table id="items">
        <tr>
            <th>Name</th>
            <th>Stage</th>
            <th>Completed CW</th>
            <th>Pending CW</th>
            <th>Pending 1W+</th>
            <th>Total Pending</th>
        </tr>
        <tr>
            <td>Finance</td>
            <td>Invoicing</td>
            <td>{{ $invoicecompletedcw }}</td>
            <td>{{ $invoicependingcw ?? 0}}</td>
            <td>{{ $invoicependingweekplus ?? 0}}</td>
            <td>{{ $invoicependingcw +  $invoicependingweekplus }}</td>
        </tr>
        <tr>
            <td>Valuations</td>
            <td>Quality Check</td>
            <td>{{ $qualitycompletedcw }}</td>
            <td>{{ $qualitypendingcw }}</td>
            <td>{{ $qualitypendingweekplus }}</td>
            <td>{{ $qualitypendingweekplus + $qualitypendingcw }}</td>
        </tr>
        <tr>
            <td>Tinashe Chimuto</td>
            <td>Report Approval</td>
            <td>{{ $approvecompletedcw }}</td>
            <td>{{ $approvependingcw }}</td>
            <td>{{ $approvependingweekplus }}</td>
            <td>{{ $approvependingweekplus + $approvependingcw }}</td>
        </tr>
        <tr>
            <td>Fadzayi Chiteka</td>
            <td>Mail Report</td>
            <td>{{ $mailcompletedcw }}</td>
            <td>{{ $mailpendingcw }}</td>
            <td>{{ $mailpendingweekplus }}</td>
            <td>{{ $mailpendingweekplus + $mailpendingcw }}</td>
        </tr>
        <tr>
            <td>Valuations</td>
            <td>Print Report</td>
            <td>{{ $printcompletedcw }}</td>
            <td>{{ $printpendingcw }}</td>
            <td>{{ $printpendingweekplus }}</td>
            <td>{{ $printpendingweekplus + $printpendingcw }}</td>
        </tr>
    </table>
</body>

</html>