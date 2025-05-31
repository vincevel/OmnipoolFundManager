<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionOrg1b extends Model
{
    protected $table = "transactions_org_joined";

    protected $fillable = array('sent_certificate');
    
   
}
