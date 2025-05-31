<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BatchRegistrationController extends Controller
{
	public function index()
    {
    

    }
    
    
    public function setId(Request $request)
    {   
            //Request $request
            //$id = 2;
            $id = $request->input('id');
            
            DB::update('update registration_counter set id = ?', [$id]);
            
    }
    
    public function getId()
    {
        $item = DB::table('registration_counter')->first();
        //return $item->id;
        return response()->json($item->id);
    }
    
   

    
}
