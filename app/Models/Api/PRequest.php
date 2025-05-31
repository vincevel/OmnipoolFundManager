<?php

namespace App\Api;

use Illuminate\Database\Eloquent\Model;

class PRequest extends Model
{
    //protected $table = "transactions";
    protected $table = "transactions_paymaya";

    protected $fillable = array('sent_certificate');
}
