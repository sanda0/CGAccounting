
# CGAccounting

## Usage

### AccountingService

The `AccountingService` class provides methods to handle accounting operations such as crediting and debiting accounts.

#### Credit an Amount to an Account

```php
use CodGlo\CGAccounting\Services\AccountingService;

$accountingService = new AccountingService();
$result = $accountingService->credit('fromAccount', 'toAccount', 100.0, 'ref123', 'type1', 'Payment for services');
if ($result === true) {
    echo "Transaction successful!";
} else {
    echo "Error: " . $result;
}
```

#### Debit an Amount from an Account

```php
use CodGlo\CGAccounting\Services\AccountingService;

$accountingService = new AccountingService();
$result = $accountingService->debit('fromAccount', 'toAccount', 50.0, 'ref456', 'type2', 'Refund for services');
if ($result === true) {
    echo "Transaction successful!";
} else {
    echo "Error: " . $result;
}
```

#### Get Account Details

```php
use CodGlo\CGAccounting\Services\AccountingService;

$accountingService = new AccountingService();
$account = $accountingService->getAccount('accountName');
echo "Account ID: " . $account->id;
```

### AccountingReportService

The `AccountingReportService` class provides methods to generate various accounting reports.

#### Generate Profit and Loss Report

```php
use CodGlo\CGAccounting\Services\AccountingReportService;

$reportService = new AccountingReportService('Company Name', 'Address', 'Phone', 'Email');
$reportUrl = $reportService->generateProfitAndLossReport('2024-01-01', '2024-12-31');
echo "Report URL: " . $reportUrl;
```

#### Generate Cash Flow Report

```php
use CodGlo\CGAccounting\Services\AccountingReportService;

$reportService = new AccountingReportService('Company Name', 'Address', 'Phone', 'Email');
$reportUrl = $reportService->generateCashFlow('2024-01-01', '2024-12-31');
echo "Report URL: " . $reportUrl;
```

#### Generate Balance Sheet

```php
use CodGlo\CGAccounting\Services\AccountingReportService;

$reportService = new AccountingReportService('Company Name', 'Address', 'Phone', 'Email');
$reportUrl = $reportService->generateBalanceSheet('2024-12-31');
echo "Report URL: " . $reportUrl;
```
