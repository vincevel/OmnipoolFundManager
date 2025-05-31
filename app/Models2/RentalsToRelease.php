<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentalsToRelease extends Model
{
    protected $table = "rentals_to_release";
    //protected $primaryKey = 'transaction_id';
    protected $primaryKey = 'transaction_id';
    //protected $fillable = array('sent_certificate');
}
