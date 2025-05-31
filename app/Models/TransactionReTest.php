<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionReTest extends Model
{
   // protected $table = "transactionsretest";
    protected $table = "transactions";
    protected $fillable = array('sent_certificate');
}
