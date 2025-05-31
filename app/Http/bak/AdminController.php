<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function backend()
    {
        //return view( URL::route('test',['id'=>'2','test_id'=>'3']) );
        //return view('demo5.user3');
       
        return redirect()->route('backend2', ['jumpToPage' => 11]);

    }

    public function backend2()
    {

      //	return 123;
            return view('demo5.backend');
     
    }
    
    public function backend3($id)
    {
            return $id;
      //	return 123;
            return view('demo5.backend2');
     
    }
    
    
}
