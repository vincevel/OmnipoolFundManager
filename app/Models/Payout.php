<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Payout extends Model
{
    use HasFactory;
	protected $table = 'payouts';
    protected $fillable = ['month', 'year','amount','balance','user_id','txHash','running_balance','isDeferred','isProcessed','date'];

}

