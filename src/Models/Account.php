<?php

namespace Vendor\CGAccounting\Models;

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
}
