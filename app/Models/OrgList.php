<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgList extends Model
{
    protected $table = "orglist";

    protected $fillable = array('sent_certificate');
}
