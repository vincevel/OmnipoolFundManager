<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionTestingDeletePls extends Model
{
    protected $table = "transactions_testing_deletepls";

    protected $fillable = array('sent_certificate');
}
