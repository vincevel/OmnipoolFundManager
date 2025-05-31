<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//use App\UserN;
use App\UserO;
use App\QueryString;

class FormsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
    }
    
    //public function add
    
    public function showRegistrationForm($id)
    {
        //dd(base64_decode($id));
        //$id = base64_decode($id);  
        //dd($id);
        $id =  ($id - 2314921374012136123) / 2;
        $user = UserO::find($id);
        //dd($user);
        $query = new QueryString;
        $query->addParam("emailAddress",$user->user_email);

        if (isset($user->first_name)){ 
            $query->addParam("name[first]",$user->first_name);
        }
        
        if (isset($user->middle_name)){
            $query->addParam("name[middle]",$user->middle_name);
        }

        if (isset($user->last_name)){
            $query->addParam("name[last]",$user->last_name);
        }

        //$query->addParam("name2dfsds[last]",$user->last_name);
        //$query->addParam("update",$user->last_name);
        //$query->addParam("nickname","test");
        //$query->addParam("maritalStatus","Singler");
        //$query->addParam("beneficiaries",'{"Full Name":"John","Relationship":"brother","Occupation":"lawyer","Sex":"Male","Birthdate":"02/01/1990"}');
        $query = $query->getQString();
        
        //dd($user);

        return view('forms.showregistrationform', [
           //'user' => $user,
           'query' => $query
        ]);
    }
    
     


     
}
