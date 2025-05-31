<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";

    protected $fillable = ['date_transaction', 'user_id','amount','transaction_type_id','user_id','isProcessed','image'];
}
