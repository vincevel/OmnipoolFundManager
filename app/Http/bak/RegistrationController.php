<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
	public function index()
    {
    	//return view( URL::route('test',['id'=>'2','test_id'=>'3']) );
    	return view('demo5.demo');

    }
    
    
    public function main()
    {
        //return view( URL::route('test',['id'=>'2','test_id'=>'3']) );
        //return view('demo5.user3');
       
        return redirect()->route('register1', ['jumpToPage' => 3]);

    }
    
    
    public function main2()
    {
        //return view( URL::route('test',['id'=>'2','test_id'=>'3']) );
        //return view('demo5.user3');
       
        return view('demo5.demo');

    }
    
    public function redirectToMessenger(){
        return redirect()->away("https://m.me/vincerapisura?ref=w12388913");
    }
    
}
