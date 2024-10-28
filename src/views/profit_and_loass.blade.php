<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit and Loss {{ $startDate }} to {{ $endDate }}</title>
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
        <div class="sub-heading">{{ $startDate }} to {{ $endDate }}</div>
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
                    <h3>Income</h3>
                </td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>
            @foreach ($incomeAccountsBalances as $key => $value)
                <tr class="bordered-cols">
                    <td class="indentx2"> {{ $key }} </td>
                    <td class="text-right"> {{ number_format($value, 2) }} </td>
                    <td class="text-right"></td>
                </tr>
            @endforeach

            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Total Income</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right"> {{ number_format($totalIncome, 2) }} </td>
            </tr>

            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Cost of Goods</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right">{{ number_format($costOfGoodsSold, 2) }}</td>
            </tr>

            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Gross Profit</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right">{{ number_format($grossProfit, 2) }}</td>
            </tr>

            <tr class="bordered-cols">
                <td>
                    <h3>Other Expenses</h3>
                </td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>

            @foreach ($otherExpensesAccountBlances as $key => $value)
                <tr class="bordered-cols">
                    <td class="indentx2">{{ $key }}</td>
                    <td class="text-right"> {{ number_format($value, 2) }} </td>
                    <td class="text-right"></td>
                </tr>
            @endforeach

            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Total Expense</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right"> {{ number_format($totalExpenses, 2) }} </td>
            </tr>

            <tr class="bordered-cols">
                <td>
                    <h3>Net Profit</h3>
                </td>
                <td class="text-right"></td>
                <td class="text-right"> {{ number_format($netProfit, 2) }} </td>
            </tr>

        </table>
    </div>
</body>

</html>
