<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\verifyMail;
use App\Mail\pendingMail;
use App\Mail\notifyMail;
use App\TransactionSync;
use App\Transaction;



class CheckingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(){
        
      
        
    }
    
    public function notifyUser(Request $request){
        //dd("Hello");
        $str = array();
        
        $items = $request->input('user.0');
        //foreach ($items as $item){
        //$str[] = $item;
        //}
        
        //$str = json_encode(array($str));
        
        $this->sendNotifyMail($items);
        
        
    }
    public function sendNotifyMail($items){
        //var_dump($items);
        //dd($items);
        
         $data = $items;
         //$data["notes"] = "Testing"; 
         //$data["notes"] = $items["email"]; 
         
         $receiver = "vincentvelasco1232019@gmail.com";
            
         $cc= array();
         
         $cc[] = "vincemvelasco@gmail.com";
            
         Mail::to($receiver)->cc($cc)->send(new notifyMail($data));
         
    }
    
    public function sendErrorMail($item,$errorMsg){
        
       
        
    }
    
}
