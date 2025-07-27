<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: 'Comic Sans MS', cursive; margin: 20px; color: #333333; font-size: 14px;">

    <div style="width: 100%; max-width: 900px; margin: 0 auto; border: 1px solid #4CAF50; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); background-color: #ffffff;">

        <h1 style="text-align: center; color: #005A2C; margin-bottom: 20px; font-size: 22px;">Leave Report</h1>
        <p style="font-size: 8px;">@ {{$dateat}}</p>

        <!-- Leave -->
        @foreach ($leavetype as $abc => $applications)
        <div style="margin-bottom: 40px;">
            <h1 style="text-align: left; margin-top: 0; border-bottom: 2px solid #005A2C; padding-bottom: 5px; margin-bottom: 20px; font-size: 13px;">{{ strtoupper($abc) }}</h1>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                <thead>
                    <tr>
                        <th style="background-color: #005A2C; font-weight: bold; color: #f2f7f7; border: 1px solid #4CAF50; padding: 8px; text-align: left; font-size: 13px;">FullName</th>
                        <th style="background-color: #005A2C; font-weight: bold; color: #f2f7f7; border: 1px solid #4CAF50; padding: 8px; text-align: left; font-size: 13px;">Start Date</th>
                        <th style="background-color: #005A2C; font-weight: bold; color: #f2f7f7; border: 1px solid #4CAF50; padding: 8px; text-align: left; font-size: 13px;">End Date</th>
                        <th style="background-color: #005A2C; font-weight: bold; color: #f2f7f7; border: 1px solid #4CAF50; padding: 8px; text-align: left; font-size: 13px;">Number Of Days</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $abcd)
                    <tr style="background-color: #b1bcc4; font-weight: bold; color: #f2f7f7; border: 1px solid #4CAF50; padding: 8px; text-align: left; font-size: 13px;">
                        <td>{{ $abcd->firstname }}{{ $abcd->lastname }}</td>
                        <td>{{ $abcd->datefrom }}</td>
                        <td>{{ $abcd->dateto }}</td>
                        <td>{{ (int)$abcd->daysapplied }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

    </div>
    <div class="footer">&copy; estman</div>
</body>

</html>