<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserO;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PayoutUpdater;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function redirectTo()
    {
        $id=Auth::user()->id;
        $user=UserO::where('id',$id)->first();
        if($user->verified){
            return RouteServiceProvider::HOME;
        }else{
            return 'https://na4.docusign.net/Member/PowerFormSigning.aspx?PowerFormId=61fd3bb3-b58a-4dc2-afe8-c4a48a961d2f&env=na4&acct=b4f94b77-bb52-465d-ac17-15699d9e2edb&v=2';
        }
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'lname' => ['required', 'string', 'max:255'],
            'fname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user=UserO::create([
            'last_name' => $data['lname'],
            'first_name' => $data['fname'],
            'email' => $data['email'],
        ]);

        $payoutUpdater=new PayoutUpdater();
        $payoutUpdater->invalidateUserPayouts($user->id,date('Y-m-d',time()));
        return User::create([
            'last_name' => $data['lname'],
            'first_name' => $data['fname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
