<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionMod1 extends Model
{
    protected $table = "transactions";

    protected $fillable = array('sent_certificate');

    protected $casts = [
        'amount' => 'float', 
    ];
    
}
