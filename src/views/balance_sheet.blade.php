<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Sheet as of {{ $toDate }}</title>
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
        <div class="heading">Balance Sheet as of {{ $toDate }}</div>
        
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
                <th>LKR</th>
                <th>LKR</th>
            </tr>
            <tr class="bordered-cols">
                <td>
                    <h3>Assets</h3>
                </td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>
            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Current Assets</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>
            @foreach($currentAssetsAcountBalances as $description => $amount)
            <tr class="bordered-cols">
                <td class="indentx2"> {{ $description }} </td>
                <td class="text-right"> {{ number_format($amount, 2) }} </td>
                <td class="text-right"></td>
            </tr>
            @endforeach
            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Fixed Assets</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>
            @foreach($fixAssetsAcountBalances as $description => $amount)
            <tr class="bordered-cols">
                <td class="indentx2"> {{ $description }} </td>
                <td class="text-right"> {{ number_format($amount, 2) }} </td>
                <td class="text-right"></td>
            </tr>
            @endforeach
            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Total Assets</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right"> {{ number_format($totalAssets, 2) }} </td>
            </tr>

            <tr class="bordered-cols">
                <td>
                    <h3>Liabilities</h3>
                </td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>
            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Short-term Liabilities</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>
            @foreach($currentLiabilitiesAcountBalances as $description => $amount)
            <tr class="bordered-cols">
                <td class="indentx2"> {{ $description }} </td>
                <td class="text-right"> {{ number_format($amount, 2) }} </td>
                <td class="text-right"></td>
            </tr>
            @endforeach
            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Long-term Liabilities</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>
            @foreach($longTermLiabilitiesAcountBalances as $description => $amount)
            <tr class="bordered-cols">
                <td class="indentx2"> {{ $description }} </td>
                <td class="text-right"> {{ number_format($amount, 2) }} </td>
                <td class="text-right"></td>
            </tr>
            @endforeach
            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Total Liabilities</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right"> {{ number_format($totalLiabilities, 2) }} </td>
            </tr>

            <tr class="bordered-cols">
                <td>
                    <h3>Equity</h3>
                </td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>
            @foreach($equityAcountBalances as $description => $amount)
            <tr class="bordered-cols">
                <td class="indentx2"> {{ $description }} </td>
                <td class="text-right"> {{ number_format($amount, 2) }} </td>
                <td class="text-right"></td>
            </tr>
            @endforeach
            <tr class="bordered-cols">
                <td>
                    <h3>Total Liabilities and Equity</h3>
                </td>
                <td class="text-right"></td>
                <td class="text-right"> {{ number_format($totalLiabilitiesAndEquity, 2) }} </td>
            </tr>
        </table>
    </div>
</body>

</html>
