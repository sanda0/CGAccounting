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

    public function balance()
    {
        $childAccounts = Account::where('parent_id', $this->id)->get();
        $balance = 0;
        foreach ($childAccounts as $childAccount) {
            $balance += $childAccount->balance();
        }

        $lastRecord = Record::where('from_account', $this->id)->latest()->first();
        if ($lastRecord) {
            $balance += $lastRecord->balance;
        }

        return $balance;

    }
}
