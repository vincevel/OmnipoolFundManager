<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testing extends Model
{
    protected $table = "testing";

    protected $fillable = array('sent_certificate');
}
