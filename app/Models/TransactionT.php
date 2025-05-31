<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionT extends Model
{
    protected $table = "transactions_tmp";

    protected $fillable = array('sent_certificate');
}
