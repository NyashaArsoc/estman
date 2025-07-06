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
    <h4>Portfolios Summary</h4>
    <table id="items">
        <thead>
            <tr>
                <th>Client</th>
                <th>Stage</th>
                <th>Properties</th>
                <th>Completed Reports</th>
                <th>Total Pending</th>
                <th>Date Due</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($portfoliocompilation as $abc)
            <tr>@php $pending =$abc->totalproperties - $abc->incoming;@endphp
                <td>{{ $abc->fullname }} {{ $abc->companyname }}</td>
                <td>Compilation</td>
                <td>{{ $abc->totalproperties }}</td>
                <td>{{ $abc->incoming}}</td>
                <td>{{ $pending }}</td>
                <td>{{ $abc->datedue }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr /><br />
    <table id="items">
        <thead>
            <tr>
                <th>Client</th>
                <th>Stage</th>
                <th>Properties</th>
                <th>Date Due</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($portfolioreview as $abc)
            <tr>
                <td>{{ $abc->fullname }} {{ $abc->companyname }}</td>
                <td>Pending Review</td>
                <td>{{ $abc->totalproperties }}</td>
                <td>{{ $abc->datedue }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>