<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit and Loss 2024-09-01 to 2024-09-30</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        .bordered-header,
        .bordered-cols td {
            border: 1px solid black;
        } 

        .bordered-cols td:first-child {
            border-left: none;
        }

        /* .bordered-header th:last-child, */
        .bordered-cols td:last-child {
            border-right: none;
        }

        .text-right {
            text-align: right;
        }

        th {
            border: 1px solid black;
        }

        .indentx1 {
            padding-left: 20px;
        }

        .indentx2 {
            padding-left: 40px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }
        .heading {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        .sub-heading {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>




<body>
    <div class="container">
        <div class="heading">Profit and Loss</div>
        <div class="sub-heading">2024-09-01 to 2024-09-30</div>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="4">
                    <p>{{ $companyName }}
                        <br>{{ $companyAddress }}
                        <br>Phone: {{ $companyPhone }}
                        <br>Email: {{ $companyEmail }}
                    </p>
                </td>
            </tr>
            <tr class="bordered-header">
                <th>Date</th>
                <th>Description</th>
                <th>IN</th>
                <th>OUT</th>
            </tr>

            @foreach ($cashFlowData as $transaction)
                <tr class="bordered-cols">
                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td class="text-right">{{ $transaction->debit }}</td>
                    <td class="text-right">{{ $transaction->credit }}</td>
                </tr>
            @endforeach


        </table>
    </div>
</body>

</html>
