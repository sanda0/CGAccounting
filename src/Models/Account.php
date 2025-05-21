<?php

namespace CodGlo\CGAccounting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Account extends Model
{
    use HasFactory;

    protected $table = "accpkg_accounts";

    protected $fillable = [
        'name',
        'type',
    ];

    protected $connection;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (env('MULTI_TENANCY_ENABLED') !== null && env('MULTI_TENANCY_ENABLED') === true) {
            $this->connection = 'sqlite_company';
        }
    }

    public function balance($toDate = null)
    {
        $balance = 0;

        // 1. Recursively calculate balance for child accounts
        $childAccounts = Account::where('parent_id', $this->id)->get();
        foreach ($childAccounts as $childAccount) {
            $balance += $childAccount->balance($toDate);
        }

        // 2. Calculate this account's own contribution to the balance
        $debitQuery = Record::where('from_account', $this->id);
        $creditQuery = Record::where('to_account', $this->id);

        if ($toDate) {
            $endDate = Carbon::parse($toDate, 'UTC')->endOfDay();
            $debitQuery->where('created_at', '<=', $endDate);
            $creditQuery->where('created_at', '<=', $endDate);
        }

        $accountDebit = $debitQuery->sum('debit');
        $accountCredit = $creditQuery->sum('credit');

        // 3. Apply account type specific logic
        if (in_array($this->type, ['assets', 'expenses'])) {
            $balance += ($accountDebit - $accountCredit);
        } else {
            $balance += ($accountCredit - $accountDebit);
        }

        return $balance;
    }

    public function hasChildAccounts(): bool
    {
        return $this->children()->exists();
    }

    public function balanceAtDateRange($fromDate, $toDate)
    {
        $childAccounts = Account::where('parent_id', $this->id)->get();
        $balance = 0;
        foreach ($childAccounts as $childAccount) {
            $balance += $childAccount->balanceAtDateRange($fromDate, $toDate);
        }
        $credit = Record::where('from_account', $this->id)->
            whereBetween('created_at', [$fromDate, $toDate])
            ->sum("credit");
        $debit = Record::where('from_account', $this->id)->
            whereBetween('created_at', [$fromDate, $toDate])
            ->sum("debit");
        $account = Account::find($this->id);

        if(in_array($account->type, ['assets', 'expenses'])){
            $balance = $balance + ($debit - $credit);
        }else{
            $balance = $balance +($credit - $debit);
        }



        return $balance;
    }


    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id', 'id');
    }
}
