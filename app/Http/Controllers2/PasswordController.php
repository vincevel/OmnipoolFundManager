<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserO;
use Illuminate\Support\Facades\Hash;
use App\UserN;
use App\Http\Requests\ResetPasswordRequest;


class PasswordController extends Controller
{
    //
    public function index(){

    	$users = UserO::all();

    	
    	foreach ($users as $user) {


    		$newUser = new UserN;

    		echo $user->user_name . "<BR>";
    		$passwd = str_random(8);
    		echo $passwd . "<BR>";
    		$hashed_random_password = bcrypt($passwd);
    		//$hashed_random_password = Hash::make(str_random(8));
			//echo $hashed_random_password . "<BR>";
			echo $hashed_random_password . "<BR>";
    
            $newUser->id = $user->id;
            $newUser->account_id = $user->account_id;

            $newUser->first_name = $user->first_name;
            $newUser->last_name = $user->last_name;

    		$newUser->name = $user->first_name . " " . $user->last_name;
    		$newUser->email = $user->user_email;
    		$newUser->password = $hashed_random_password;
    		$newUser->plainpass = $passwd;


    		$newUser->save();
    		
		}
		//return $users;
    


    }

    public function changePassword(){


        return view('demo5.changepass');

    }
    
    public function viewall(){

        //$users = UserN::all()->orderBy('last_name');
        $users = UserO::orderBy('last_name')->get();
        
        return view('demo5.viewall')->with('users',$users);

    }

     public function setPassword(ResetPasswordRequest $ResetPasswordRequest){
        
        $user = UserN::find($ResetPasswordRequest->id);
        $user->password = bcrypt($ResetPasswordRequest->password);
        $user->plainpass = $ResetPasswordRequest->password;
        $user->first_time = 0;
        $user->save();

        return redirect('/main')->with('success','Password changed');
        //var_dump($user);

        //$post = Post::find($id);
        //var_dump($ResetPasswordRequest);

        //return view('demo5.changepass');

    }
}
