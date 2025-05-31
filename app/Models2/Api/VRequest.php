<?php

namespace App\Api;

use Illuminate\Database\Eloquent\Model;

class VRequest extends Model
{
    protected $table = "transactions";

    protected $fillable = array('sent_certificate');
}
