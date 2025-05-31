<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\PasswordReset; 


class UserN extends Model
{
    //
    protected $table = 'userslogin';

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
	    $this->notify(new PasswordReset($token));
	}
    
}

