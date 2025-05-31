<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DividendsToRelease extends Model
{
    protected $table = "dividends_to_release";
    //protected $primaryKey = 'transaction_id';
    protected $primaryKey = 'transaction_id';
    protected $fillable = array('sent_certificate');
}
