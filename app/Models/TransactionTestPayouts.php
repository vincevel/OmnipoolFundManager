<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionTestPayouts extends Model
{
    protected $table = "transactions";

    protected $fillable = [
        'email', 
        'last_name',
        'first_name',
        'user_id',
        'account_id',
        'date_transaction',
        'status',
        'investment_type',
        'notes',
        'running_balance',
        'transaction_type_id',
        'remarks',
        'amount',
        'contribution_payout',
        'dividend_payout',
        'file_name',
        'is_posted',
        'requested_by',
        
    ];
}
