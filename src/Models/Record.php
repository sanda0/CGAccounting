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

    protected $connection;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (env('MULTI_TENANCY_ENABLED') !== null && env('MULTI_TENANCY_ENABLED') === true) {
            $this->connection = 'sqlite_company';
        }
    }

    public function fromAccount()
    {
        return $this->belongsTo(Account::class, 'from_account');
    }

    public function toAccount()
    {
        return $this->belongsTo(Account::class, 'to_account');
    }


}

