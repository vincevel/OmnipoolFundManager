<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgUser extends Model
{
    protected $table = "ooitestusers";

    protected $fillable = array('sent_certificate');
}
