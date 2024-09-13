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
            border-left: 1px solid black;
            border-right: 1px solid black;
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
    </style>
</head>




<body>
    <div class="container">
        <h1>Profit and Loss {{ $startDate }} to {{ $startDate }}</h1>
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
            <tr class="bordered-cols">
                <td class="indentx2"> Sales Revenue </td>
                <td class="text-right"> {{ number_format($salesRevenue, 2) }} </td>
                <td class="text-right"></td>
            </tr>
            <tr class="bordered-cols">
                <td class="indentx2"> Service Revenue </td>
                <td class="text-right"> {{ number_format($serviceRevenue, 2) }} </td>
                <td class="text-right"></td>
            </tr>
            <tr class="bordered-cols">
                <td class="indentx2"> Other Income </td>
                <td class="text-right"> {{ number_format($otherIncome, 2) }} </td>
                <td class="text-right"></td>
            </tr>
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
                <td class="text-right">{{ number_format($costOfGoodsSold,2) }}</td>
            </tr>

            <tr class="bordered-cols">
                <td class="indentx1">
                    <h4>Gross Profit</h4>
                </td>
                <td class="text-right"></td>
                <td class="text-right">{{ number_format($grossProfit,2) }}</td>
            </tr>

            <tr class="bordered-cols">
                <td>
                    <h3>Other Expenses</h3>
                </td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>

            <tr class="bordered-cols">
              <td class="indentx2">Salaries Expense </td>
              <td class="text-right"> {{ number_format($salariesExpense, 2) }} </td>
              <td class="text-right"></td>
            </tr>
            <tr class="bordered-cols">
              <td class="indentx2">Rent Expense</td>
              <td class="text-right"> {{ number_format($rentExpense, 2) }} </td>
              <td class="text-right"></td>
            </tr>
            <tr class="bordered-cols">
              <td class="indentx2">Utilities Expense</td>
              <td class="text-right"> {{ number_format($utilitiesExpense, 2) }} </td>
              <td class="text-right"></td>
            </tr>
            <tr class="bordered-cols">
              <td class="indentx2">Depreciation Expense </td>
              <td class="text-right"> {{ number_format($depreciationExpense, 2) }} </td>
              <td class="text-right"></td>
            </tr>
            <tr class="bordered-cols">
              <td class="indentx2">Sales Discount </td>
              <td class="text-right"> {{ number_format($salesDiscount, 2) }} </td>
              <td class="text-right"></td>
            </tr>

            <tr class="bordered-cols">
              <td class="indentx2">Sales Returns and Allowances </td>
              <td class="text-right"> {{ number_format($salesReturnsAndAllowances, 2) }} </td>
              <td class="text-right"></td>
            </tr>

            <tr class="bordered-cols">
              <td class="indentx2">Other Expenses</td>
              <td class="text-right"> {{ number_format($otherExpenses, 2) }} </td>
              <td class="text-right"></td>
            </tr>

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
