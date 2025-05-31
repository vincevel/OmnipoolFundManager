<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
 
 
use App\Reinvestment;
use App\ReinvestmentRec;

use App\ReinvestmentRec2;

use Storage;

class ManyChatControllerReinvestSSSPagibig extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(){
        
        
        
    }
    
    public function reinvestssspagibig(Request $r1){
        //echo "Hi! Reinvest SSS Pag-Ibig";
        
        $message = "Reinvest Success";

        $rrec = new ReinvestmentRec($r1->input("data.fullName"),
            $r1->input("data.sriDepositDate"),
            $r1->input("data.sriDepositAmount"),
            $r1->input("data.sriOrganization"),
            $r1->input("data.lastInteraction"),
            $r1->input("data.email"));
        $rrec->saveRecord();
    
        //$message = $rrec->getOutput();
          
        //CLASSIFY HERE
 
                
 
        
        return response()->json($message);
    }
    
    public function reinvest2(Request $r1){
        //echo "Hi! Reinvest 2";
        
        $message = "Reinvest Success";

        $rrec = new ReinvestmentRec2($r1->input("data.fullName"),
            $r1->input("data.sriDepositDate"),
            $r1->input("data.sriDepositAmount"),
            $r1->input("data.sriOrganization"),
            $r1->input("data.lastInteraction"),
            $r1->input("data.email"));
        $rrec->saveRecord();
    
        //$message = $rrec->getOutput();
          
        //CLASSIFY HERE
 
                
 
        
        return response()->json($message);
    }
     
    
      
     
   
    
   
   
}
