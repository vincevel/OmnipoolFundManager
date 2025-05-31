<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgListOrig extends Model
{
    protected $table = "orglistorig";

    protected $fillable = array('sent_certificate');
}
