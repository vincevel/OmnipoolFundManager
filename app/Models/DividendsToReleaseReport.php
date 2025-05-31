<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DividendsToReleaseReport extends Model
{
    protected $table = "dividends_to_release_apr2021_report";

    protected $fillable = array('sent_certificate');
    
    
    protected $casts = [
        'amount' => 'float', 
        'dividend_payout' => 'float', 
        'days_between' => 'int', 
    ];
}
