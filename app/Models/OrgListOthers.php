<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgListOthers extends Model
{
    protected $table = "orglistothers";

    protected $fillable = array('sent_certificate');
}
