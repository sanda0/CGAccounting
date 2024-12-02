<?php

namespace CodGlo\CGAccounting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    use HasFactory;


    protected $connection;

    protected $fillable = [
        'cheque_number',
        'cheque_date',
        'type',
        'amount',
        'payee_name',
        'payee_id',
        'payee_account_id',
        'payer_name',
        'payer_id',
        'payer_account_id',
        'bank_id',
        'status',
        'remarks',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (env('MULTI_TENANCY_ENABLED') !== null && env('MULTI_TENANCY_ENABLED') === true) {
            $this->connection = 'sqlite_company';
        }
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->save();



    }


    

}
