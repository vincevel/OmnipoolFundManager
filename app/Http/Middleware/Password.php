<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserO;
class Password
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id=auth()->user()->id;
        $user=UserO::where('id',$id)->first();
        if(auth()->user()->first_time == 0){
            
            if($user->verified){
                return $next($request);
            }else{
                $secret=$request->route('secret');
                if($secret=='done'){
                    $user->verified=1;
                    $user->save();
                    return $next($request);
                }
                return redirect()->away('https://na4.docusign.net/Member/PowerFormSigning.aspx?PowerFormId=61fd3bb3-b58a-4dc2-afe8-c4a48a961d2f&env=na4&acct=b4f94b77-bb52-465d-ac17-15699d9e2edb&v=2');
            } 
        } 
        $secret=$request->route('secret');
        if($secret=='done'){
            $user->verified=1;
            $user->save();
            return $next($request);
        }
        return redirect('/changepassword')->with('error','You need to change your password');
    }
    private function updateUser($request,$user,$next){

    }
}

