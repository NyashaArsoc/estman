<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #333;
            font-size: 13.5px;
            padding: 24px;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 24px;
            margin: auto;
            max-width: 900px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 16px;
            color: #1f2937;
        }

        h2 {
            font-size: 12px;
            font-weight: 600;
            margin-top: 24px;
            margin-bottom: 12px;
            color: #1f2937;
        }

        label {
            font-size: 10px;
            font-weight: bold;
            color: #4a5568;
            display: inline-block;
        }

        input[type="text"],
        input[type="date"] {
            border: none;
            border-bottom: 1px solid #000;
            background-color: transparent;
            font-size: 12px;
            padding: 2px 4px;
            width: 100%;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .note {
            font-style: italic;
            font-size: 10px;
            color: #4b5563;
            margin-bottom: 8px;
        }

        .checkbox-group label {
            font-size: 10px;
            margin-right: 12px;
        }

        .footer-notes {
            font-size: 10px;
            color: #6b7280;
            text-align: right;
            margin-top: 20px;
        }

        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>LEAVE APPLICATION FORM</h1>

        <h2>1. Employee Details</h2>
        <table>
            <tr>
                <td><label>FullName:</label><br><input type="text" value="{{$staff->lastname}} {{$staff->firstname}}"></td>
                <td><label>Employee No:</label><br><input type="text"></td>
            </tr>
            <tr>
                <td><label>Post:</label><br><input type="text"></td>
                <td><label>Grade:</label><br><input type="text"></td>
            </tr>
            <tr>
                <td><label>Department:</label><br><input type="text"></td>
                <td><label>Cell No:</label><br><input type="text" value="{{$staff->cell}}"></td>
            </tr>
        </table>

        <h2>2. Nature of Leave and Number of Days</h2>
        <p class="note">Note: You cannot proceed on any leave without the express written permission of the Head of Department/Supervisor.</p>
        <table>
            <tr>
                <td><label>From:</label><br><input type="text" value="{{$application->datefrom}}"></td>
                <td><label>To:</label><br><input type="text" value="{{$application->dateto}}"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label>Leave Type:</label>
                    <label><input type="checkbox" checked> {{$typegroup->description}}</label>
                </td>
                <td><label>No of days leave:</label><br><input type="text" value="{{ (int)$application->daysapplied}}"></td>
            </tr>
            <tr>
                <td colspan="2"><label>Comments:</label><br><input type="text" value="{{$application->comments}}"></td>
            </tr>
            <tr>
                <td><label>Application Date:</label><br><input type="text"
                        value="{{ Carbon\Carbon::parse($application->datestamp)->format('F j, Y') ?? ''}}"></td>
            </tr>
        </table>

        <h2>3. HC Department Leave Accrued</h2>
        <table>
            <tr>
                <td><label>Leave Accrued as at:</label><br><input type="text" value="{{$today}}"></td>
                <td><br><input type="text" value="{{$days->days}}"> W/Days</td>
            </tr>
            <tr>
                <td><label>Actioned by:</label><br><input type="text" value="{{$myuser->lastname}} {{$myuser->firstname}}"></td>
                <td><label>Date:</label><br><input type="text" value="{{$today}}"></td>
            </tr>
        </table>

        <h2>4. Department/Section Recommendation</h2>
        <table>
            <tr>
                <td colspan="2">
                    <label>Approved:</label>
                    <label><input type="radio" name="approved" checked> Yes</label>
                    <label><input type="radio" name="approved"> No</label>
                </td>
            </tr>
            <tr>
                <td><label>SUPERVISOR / HOD (NAME):</label><br><input type="text" value="{{$reportto->lastname}} {{$reportto->firstname}}"></td>
                <td><label>DATE:</label><br><input type="text"
                        value="{{ Carbon\Carbon::parse($application->approvedon)->format('F j, Y') ?? ''}}"></td>
            </tr>
        </table>

        <h2>5. Update on Leave Balance</h2>
        <table>
            <tr>
                <td><label>Leave days taken:</label><br><input type="text" value="{{ (int)$application->daysapplied}}"></td>
                <td><label>Leave balance at end:</label><br><input type="text" value="{{$balance}}"></td>
            </tr>
        </table>

        <hr />
        <div class="footer-notes">
            <p>&#169; estman</p>
        </div>
    </div>
</body>

</html>