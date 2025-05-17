# CGAccounting

A Laravel package for handling accounting operations, including account management, transactions, and generating financial reports such as profit and loss, balance sheets, and cash flow statements. Easily manage credits, debits, and generate reports with a simple API.

---

## Features

- Account Management (Assets, Liabilities, Equity, Income, Expenses)
- Transaction Processing (Credits and Debits)
- Financial Report Generation
  - Profit and Loss Statements
  - Balance Sheets
  - Cash Flow Statements
  - Trial Balance Sheets
- Cheque Management (with status tracking and references)
- Database Migration and Seeding Support
- Built-in Account Types and Structures
- Flexible Transaction References and Descriptions
- Multi-tenancy support (via `MULTI_TENANCY_ENABLED`)

---

## Setup Instructions

### 1. Install via Composer

```sh
composer require cod-glo/cgaccounting
```

### 2. Run Migrations

To set up the database tables, run the migration commands:

```sh
php artisan migrate
```

This will create the required tables:
- `accpkg_accounts`: Stores account information and hierarchies
- `accpkg_entries`: Records all transactions and balances
- `cheques`: Stores cheque details and status

### 3. Run Account Seeder

To seed the database with initial account data:

```sh
php artisan db:seed --class=CodGlo\\CGAccounting\\Seeders\\AccountSeeder
```

---

## Usage

### AccountingService

Handles all transaction-related operations.

#### Credit Transaction

```php
use CodGlo\CGAccounting\Services\AccountingService;

$accountingService = new AccountingService();
$result = $accountingService->credit(
    'fromAccount',    // Source account name
    'toAccount',      // Destination account name
    100.0,           // Amount
    'ref123',        // Reference ID (optional)
    'type1',         // Reference type (optional)
    'Description',   // Transaction description (optional)
    '2024-01-01'     // Transaction date (optional)
);

if ($result === true) {
    echo "Transaction successful!";
} else {
    echo "Error: " . $result;
}
```

#### Debit Transaction

```php
use CodGlo\CGAccounting\Services\AccountingService;

$accountingService = new AccountingService();
$result = $accountingService->debit(
    'fromAccount',    // Source account name
    'toAccount',      // Destination account name
    50.0,            // Amount
    'ref456',        // Reference ID (optional)
    'type2',         // Reference type (optional)
    'Refund',        // Transaction description (optional)
    '2024-01-02'     // Transaction date (optional)
);
```

#### Get Account

```php
$account = $accountingService->getAccount('Cash');
```

#### Get Account Transactions

```php
$transactions = $accountingService->getAccountTransactions(
    $account->id,
    '2024-01-01', // Start date (optional)
    '2024-12-31', // End date (optional)
    20            // Results per page (optional)
);
```

#### Get General Ledger

```php
$ledger = $accountingService->getGeneralLedger(
    '2024-01-01', // Start date (optional)
    '2024-12-31', // End date (optional)
    50            // Results per page (optional)
);
```

---

### Cheque Management

Cheques are managed via the `Cheque` model. You can create, update status, and link cheques to transactions using `ref_id` and `ref_type`.

```php
use CodGlo\CGAccounting\Models\Cheque;

$cheque = new Cheque([
    'cheque_number' => '123456',
    'cheque_date' => '2024-12-31',
    'type' => 'out',
    'amount' => 5000,
    'payee_name' => 'Supplier Name',
    // ... other fields
]);
$cheque->save();

// Update status
$cheque->updateStatus('cleared');
```

---

### AccountingReportService

Generate financial reports with customizable company information.

#### Initialize Report Service

```php
use CodGlo\CGAccounting\Services\AccountingReportService;

$reportService = new AccountingReportService(
    'Company Name',
    'Company Address',
    'Phone Number',
    'Email Address'
);
```

#### Generate Reports

##### Profit and Loss Report
```php
$reportUrl = $reportService->generateProfitAndLossReport(
    '2024-01-01',    // Start date
    '2024-12-31',    // End date
    'output/path',   // Optional output path
    'pdf'            // Optional format (pdf/html)
);
```

##### Cash Flow Report
```php
$reportUrl = $reportService->generateCashFlow(
    '2024-01-01',    // Start date
    '2024-12-31'     // End date
);
```

##### Balance Sheet
```php
$reportUrl = $reportService->generateBalanceSheet(
    '2024-12-31'     // As of date
);
```

##### Trial Balance Sheet
```php
$reportUrl = $reportService->generateTrialBalanceSheet(
    '2024-12-31',    // As of date
    'output/path',   // Optional output path
    'pdf'            // Optional format (pdf/html)
);
```

---

## Account Types

The package supports standard accounting types:
- Assets
- Liabilities
- Equity
- Income
- Expenses

---

## Error Handling

The package includes validation for:
- Invalid amounts (zero or negative)
- Non-existent accounts
- Invalid account types
- Transaction constraints

---

## Multi-Tenancy

If `MULTI_TENANCY_ENABLED` is set to `true` in your `.env`, the package will use the `sqlite_company` connection for models.

---

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

## License

This project is licensed under the MIT License - see the LICENSE file for details.