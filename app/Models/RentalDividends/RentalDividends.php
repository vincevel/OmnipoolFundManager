<?php

namespace App\RentalDividends;

use Illuminate\Database\Eloquent\Model;

class RentalDividends extends Model
{
    //protected $table = "rentals_to_release";
    protected $table = "rentals_to_release_report_marzan";
    protected $fillable = array('sent_certificate');
}
