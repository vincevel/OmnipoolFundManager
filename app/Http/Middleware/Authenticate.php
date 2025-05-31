<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Models\UserO;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $id=Auth::user()->id;
        $user=UserO::where('id',$id)->first();
        if($user->verified){
            if (! $request->expectsJson()) {
                return route('login');
            }
        }else{
            return 'https://na4.docusign.net/Member/PowerFormSigning.aspx?PowerFormId=61fd3bb3-b58a-4dc2-afe8-c4a48a961d2f&env=na4&acct=b4f94b77-bb52-465d-ac17-15699d9e2edb&v=2';
        }
        
    }
}
