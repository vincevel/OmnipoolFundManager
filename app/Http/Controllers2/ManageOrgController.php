<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\verifyMail;
use App\Mail\pendingMail;

use App\TransactionSync;
use App\Transaction;
use App\TransactionT;
use App\TransactionOrg;
use App\TransactionOrg1;

use App\TransactionOrgRental;
use App\TransactionOrgRental1;

use App\OrgList;
use App\OrgListOrig;

use Excel;

class ManageOrgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(){
        
         $orgs = OrgList::paginate(25);
         $orgs3 = OrgListOrig::whereNotIn('code', ['SEDPI',
         'Class B',
         'Class C',
         'Class D',
         'Class E'
         ])->paginate(25);
        
         $orgs2 = OrgListOrig::whereIn('code', ['123412'
         ])->paginate(25);

        //->orderBy('id', 'desc')->get();
        
        return view('manageorgs.listOrgs', [
            //verification.listVerificationTransactions
            'orgs' => $orgs,
            'orgs2' => $orgs2
            
        ]);
        
    }
    
    public function editId(Request $request)
    {
      //dd($request->all());
      
       $org = Orglist::where([
                ['id', '=', $request->editId  ],
            ])
        ->orderBy('id', 'desc')->get();
        
           $item = $org[0];
          
          
           $item->code = $request->editCode;
           $item->title = $request->editTitle;
           $item->denomination = $request->editDenomination;
           $item->maxamount = $request->editLimit;
           if (strtolower(trim($request->editEnabled))=="yes"){
                $item->enabled = 1;
           }else{
               $item->enabled = 0;
           }
           $item->remarks = $request->editRemarks;
         
 
           
          
           $item->save();
          
            
           
     
        return back()->with('message','Edited Successfully');  
    }
   
    public function deleteId(Request $request){
        return back();
        
    }
    
    public function addId(Request $request){
        
           $item = new Orglist;
          
          
           $item->code = str_replace(" ","",strtoupper(trim($request->addCode)));
           $item->title = $request->addTitle;
           $item->denomination = $request->addDenomination;
           $item->maxamount = $request->addLimit;
           if (strtolower(trim($request->addEnabled))=="yes"){
                $item->enabled = 1;
           }else{
               $item->enabled = 0;
           }
           $item->remarks = $request->addRemarks;
         
 
           
          
           $item->save();
           return back()->with('message','Added Successfully');   
    }
   
}
