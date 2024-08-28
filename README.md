# CGAccounting

## usage

```php
use CodGlo\CGAccounting\Services\AccountingService;

class SomeController extends Controller
{
    protected $accountingService;

    public function __construct(AccountingService $accountingService)
    {
        $this->accountingService = $accountingService;
    }

    public function transferCredit()
    {
        $result = $this->accountingService->credit('Cash', 'Bank', 1000);
        // Handle the result...
    }

    public function transferDebit()
    {
        $result = $this->accountingService->debit('Bank', 'Cash', 500);
        // Handle the result...
    }
}
```