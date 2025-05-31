<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserO extends Model
{
    //
    protected $table = 'users';

    protected $fillable = [
        'first_name', 'last_name','email', 'password','interest_rate',
    ];
}
