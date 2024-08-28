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
}

