<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgListPerUser extends Model
{
    protected $table = "orglist_peruser";

    protected $fillable = array('sent_certificate');
}
