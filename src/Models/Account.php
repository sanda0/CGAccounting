<?php

namespace CodGlo\CGAccounting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $childAccounts = Account::where('parent_id', $this->id)->get();
        $balance = 0;
        foreach ($childAccounts as $childAccount) {
            $balance += $childAccount->balance($toDate);
        }
        if ($toDate) {
            $lastRecord = Record::where('from_account', $this->id)
                ->whereDate('created_at', '<=', $toDate)
                ->orderBy("id", "desc")
                ->first();
        } else {
            $lastRecord = Record::where('from_account', $this->id)
                ->orderBy("id", "desc")
                ->first();
        }
        if ($lastRecord) {
            $balance += $lastRecord->balance;
        }

        return $balance;

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
            $balance = $debit - $credit;
        }else{
            $balance = $credit - $debit;
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
