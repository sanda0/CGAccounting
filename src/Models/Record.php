<?php

namespace CodGlo\CGAccounting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $table = "accpkg_entries";

    protected $fillable = [
        'from_account',
        'to_account',
        'debit',
        'credit',
        'balance',
        'ref_id',
        'ref_type',
        'description',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($record) {
            $fromAccount = Account::find($record->from_account);
            if ($fromAccount->parent_id != null) {
                // $parentAccount = Account::find($fromAccount->parent_id);
                $parentLastBalance = Record::where('from_account', $fromAccount->parent_id)->orderBy('id', 'desc')->first()->value('balance');
                if ($record->debit > 0) {
                    if ($fromAccount->type == "assets" || $fromAccount->type == "expenses") {
                        $new_balance = $parentLastBalance + $record->debit;

                        $new_entry = new Record();
                        $new_entry->from_account = $fromAccount->parent_id;
                        $new_entry->to_account = $fromAccount->parent_id;
                        $new_entry->debit = $record->debit;
                        $new_entry->credit = 0;
                        $new_entry->balance = $new_balance;
                        $new_entry->ref_id = 0;
                        $new_entry->ref_type = "system";
                        $new_entry->description = "Balance update";
                        $new_entry->save();
                    } elseif (in_array($fromAccount->type, ['liabilities', 'equity', 'income'])) {
                        $new_balance = $parentLastBalance - $record->debit;

                        $new_entry = new Record();
                        $new_entry->from_account = $fromAccount->parent_id;
                        $new_entry->to_account = $fromAccount->parent_id;
                        $new_entry->debit = $record->debit;
                        $new_entry->credit = 0;
                        $new_entry->balance = $new_balance;
                        $new_entry->ref_id = 0;
                        $new_entry->ref_type = "system";
                        $new_entry->description = "Balance update";
                        $new_entry->save();

                        return true;
                    }
                } elseif ($record->credit > 0) {
                    if ($fromAccount->type == "assets" || $fromAccount->type == "expenses") {
                        $new_balance = $parentLastBalance - $record->credit;

                        $new_entry = new Record();
                        $new_entry->from_account = $fromAccount->parent_id;
                        $new_entry->to_account = $fromAccount->parent_id;
                        $new_entry->debit = 0;
                        $new_entry->credit = $record->credit;
                        $new_entry->balance = $new_balance;
                        $new_entry->ref_id = 0;
                        $new_entry->ref_type = "system";
                        $new_entry->description = "Balance update";
                        $new_entry->save();
                    } elseif (in_array($fromAccount->type, ['liabilities', 'equity', 'income'])) {
                        $new_balance = $parentLastBalance + $record->credit;

                        $new_entry = new Record();
                        $new_entry->from_account = $fromAccount->parent_id;
                        $new_entry->to_account = $fromAccount->parent_id;
                        $new_entry->debit = 0;
                        $new_entry->credit = $record->credit;
                        $new_entry->balance = $new_balance;
                        $new_entry->ref_id = 0;
                        $new_entry->ref_type = "system";
                        $new_entry->description = "Balance update";
                        $new_entry->save();

                        return true;
                    }
                }
            }
            return true;
        });
    }

}

