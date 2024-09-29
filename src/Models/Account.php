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

    public function balance($toDate = null)
    {
        $childAccounts = Account::where('parent_id', $this->id)->get();
        $balance = 0;
        foreach ($childAccounts as $childAccount) {
            $balance += $childAccount->balance();
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
}
