<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial Balance as of {{ $toDate }}</title>
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
        <div class="heading">Trial Balance as of {{ $toDate }}</div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="3">
                    <p>{{ $companyName }}
                        <br>{{ $companyAddress }}
                        <br>Phone: {{ $companyPhone }}
                        <br>Email: {{ $companyEmail }}
                    </p>
                </td>
            </tr>
            <tr class="bordered-header">
                <th>Description</th>
                <th>Debit (LKR)</th>
                <th>Credit (LKR)</th>
            </tr>
            @php
                $totalDebit = 0;
                $totalCredit = 0;
            @endphp
            @foreach ($debitAccountsWithBalances as $name => $amount)
                <tr class="bordered-cols">
                    <td> {{ $name }} </td>
                    <td class="text-right"> {{ number_format($amount, 2) }} </td>
                    <td class="text-right"> </td>
                </tr>
                @php
                    $totalDebit += $amount;
                @endphp
            @endforeach
            @foreach ($creditAccountsWithBalances as $name => $amount)
                <tr class="bordered-cols">
                    <td> {{ $name }} </td>
                    <td class="text-right"> </td>
                    <td class="text-right"> {{ number_format($amount, 2) }} </td>
                </tr>
                @php
                    $totalCredit += $amount;
                @endphp
            @endforeach
            <tr class="bordered-cols">
                <td><strong>Total</strong></td>
                <td class="text-right"><strong>{{ number_format($totalDebit, 2) }}</strong></td>
                <td class="text-right"><strong>{{ number_format($totalCredit, 2) }}</strong></td>
            </tr>
        </table>
    </div>
</body>

</html>
