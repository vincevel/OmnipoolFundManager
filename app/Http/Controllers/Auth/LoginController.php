<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Models\UserO;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
