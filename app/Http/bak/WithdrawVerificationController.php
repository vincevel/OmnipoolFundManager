<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\verifyMail;
use App\Mail\pendingMail;

use App\Mail\verifyWMail;
use App\Mail\pendingWMail;
use App\Mail\errorWMail;


use App\TransactionSync;
use App\Transaction;
use App\TransactionOrg;
use App\TransactionOrg1;

class WithdrawVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(){
        
         $transactions = TransactionSync::where([

        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->whereIn('transaction_type_id',array('3'))
        ->orderBy('id', 'desc')->paginate(25);
        
        //->orderBy('id', 'desc')->get();
        
        return view('withdrawverification.listWVerificationTransactions', [
            
            'transactions' => $transactions
            
        ]);
        
    }
    
    
    
    
    
    public function search(Request $request){
        
        //dd($r->all());
        
        $flag = $request->pendingFlag;
        
         
        $search = $request->search;
        
        if ($search!=NULL){
        
             
         
                 $transactions = TransactionSync::where([
                    ['email', 'like', "%".$search."%"  ],
                ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
                 ->whereIn('transaction_type_id',array('3'))
                ->orWhere([
                    ['first_name', 'like', "%".$search."%" ],
                ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
                 ->whereIn('transaction_type_id',array('3'))
                 ->orWhere([
                    ['last_name', 'like', "%".$search."%" ],
                ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
                ->whereIn('transaction_type_id',array('3'))
                ->orderBy('id', 'desc')
                ->paginate(25);
                //->get();
                
     
        
        } else {
            //Empty search
            

                 $transactions = TransactionSync::where([
        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->whereIn('transaction_type_id',array('3'))
        ->orderBy('id', 'desc')->paginate(25);
                
      
        }
        
        if (count($transactions)==0){
            

                 $transactions = TransactionSync::where([
                ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
                 ->whereIn('transaction_type_id',array('3'))
                 ->orderBy('id', 'desc')->paginate(25);
                //dd($transactions->all());
        
        
        }
        
        
        return view('withdrawverification.listWVerificationTransactions', [
            
            'transactions' => $transactions,
            'search'=> true
            
        ]);
        
    }
    
     public function filterpending(Request $request){
        
        //dd($r->all());
        
        //$flag = $request->pendingFlag;
        
         
        $search = $request->search;
        
        if ($search!=NULL){
        
             
         
                 $transactions = TransactionSync::where([
                    ['email', 'like', "%".$search."%"  ],
                ])->whereIn('status',array('Pending'))
                 ->whereIn('transaction_type_id',array('3'))
                ->orWhere([
                    ['first_name', 'like', "%".$search."%" ],
                ])->whereIn('status',array('Pending'))
                 ->whereIn('transaction_type_id',array('3'))
                 ->orWhere([
                    ['last_name', 'like', "%".$search."%" ],
                ])->whereIn('status',array('Pending'))
                ->whereIn('transaction_type_id',array('3'))
                ->orderBy('id', 'desc')
                ->paginate(25);
                //->get();
                
     
        
        } else {
            //Empty search
            

                 $transactions = TransactionSync::where([
        ])->whereIn('status',array('Pending'))
        ->whereIn('transaction_type_id',array('3'))
        ->orderBy('id', 'desc')->paginate(25);
                
      
        }
        
        if (count($transactions)==0){
            

                 $transactions = TransactionSync::where([
                ])->whereIn('status',array('Pending'))
                ->whereIn('transaction_type_id',array('3'))
                 ->orderBy('id', 'desc')->paginate(25);
                //dd($transactions->all());
        
        
        }
        
        
        return view('withdrawverification.listWVerificationTransactions', [
            
            'transactions' => $transactions,
            'search'=> true
            
        ]);
        
    }
    
    
    
    public function clear()
    {
        TransactionSync::truncate();   
        echo "Transaction Sync cleared.";
        
    }
    
    public function transfer2()
    {
        $transactions = TransactionSync::where([])
        ->orderBy('id', 'desc')->get();
        
        //return $transactions[0]->email;
        
        foreach ($transactions as $item)
        {
            
            //return $item;
            $t2 = new Transaction;
            
            
            $t2->requested_by = $item->requested_by;
            $t2->email = $item->email; 
            $t2->date_transaction = $item->date_transaction; 
            $t2->amount = $item->amount; 
            $t2->running_balance = $item->running_balance; 
            $t2->remarks = $item->remarks; 
            $t2->status = $item->status . "BB";
            $t2->investment_type = $item->investment_type; 
            $t2->user_id = $item->user_id;
            $t2->notes = $item->notes;
            $t2->notes_investment_purpose = $item->notes_investment_purpose; 
            $t2->transaction_type_id = $item->transaction_type_id; 
            $t2->transaction_id = $item->transaction_id; 
            $t2->file_name = $item->file_name; 
            $t2->notes_withdraw_reason = $item->notes_withdraw_reason; 
            $t2->bank_name = $item->bank_name;
            $t2->bank_acct_no = $item->bank_acct_no;
            $t2->bank_acct_name = $item->bank_acct_name;
            $t2->bank_branch = $item->bank_branch;
            $t2->bank_account_type = $item->bank_account_type;
            $t2->bankrouting_no = $item->bankrouting_no;
            $t2->govt_id = $item->govt_id;
            $t2->authorization_letter = $item->authorization_letter;
            $t2->first_name = $item->first_name;
            $t2->last_name = $item->last_name;
            $t2->account_name = $item->account_name;
            $t2->account_id = $item->account_id;
            $t2->is_posted = $item->is_posted;
            $t2->testing = $item->testing;
            $t2->seen = $item->seen;
            $t2->dividend_payout = $item->dividend_payout;
            $t2->contribution_payout = $item->contribution_payout;
            $t2->sent_certificate = $item->sent_certificate;
            //return $t2;
            $t2->save();
            //return "Saved transactions sync to transactions";
        }
        
        $count = count($transactions);
        
        echo "Saved transactions sync to transactions - Count $count";
        
        //return $transactions;
        
        //return "index2";
    }
    
    public function transferId(Request $request)
    {
        //return "here at Id";
        //return $request->$id;
        //return dd($request->itemIdN);
        
        $transactions = TransactionSync::where([
                ['id', '=', $request->itemIdN  ],
            ])
        ->orderBy('id', 'desc')->get();
        
        //return $transactions[0]->email;
        
        foreach ($transactions as $item)
        {
            
            //return $item;
            $t2 = new Transaction;
            
            
            $t2->requested_by = $item->requested_by;
            $t2->email = $item->email; 
            $t2->date_transaction = $item->date_transaction; 
            $t2->amount = $item->amount; 
            $t2->running_balance = $item->running_balance; 
            $t2->remarks = $item->remarks; 
            //$t2->status = $item->status . "CC";
            $t2->status = "Pending";
            $t2->investment_type = $item->investment_type; 
            $t2->user_id = $item->user_id;
            $t2->notes = $item->notes;
            $t2->notes_investment_purpose = $item->notes_investment_purpose; 
            $t2->transaction_type_id = $item->transaction_type_id; 
            $t2->transaction_id = $item->transaction_id; 
            $t2->file_name = $item->file_name; 
            $t2->notes_withdraw_reason = $item->notes_withdraw_reason; 
            $t2->bank_name = $item->bank_name;
            $t2->bank_acct_no = $item->bank_acct_no;
            $t2->bank_acct_name = $item->bank_acct_name;
            $t2->bank_branch = $item->bank_branch;
            $t2->bank_account_type = $item->bank_account_type;
            $t2->bankrouting_no = $item->bankrouting_no;
            $t2->govt_id = $item->govt_id;
            $t2->authorization_letter = $item->authorization_letter;
            $t2->first_name = $item->first_name;
            $t2->last_name = $item->last_name;
            $t2->account_name = $item->account_name;
            $t2->account_id = $item->account_id;
            $t2->is_posted = $item->is_posted;
            $t2->testing = $item->testing;
            $t2->seen = $item->seen;
            $t2->dividend_payout = $item->dividend_payout;
            $t2->contribution_payout = $item->contribution_payout;
            $t2->sent_certificate = $item->sent_certificate;
            //return $t2;
            $t2->save();
            //return "Saved transactions sync to transactions";
            $item->status = "Deleted";
            $item->save();
        }
        
        $count = count($transactions);
        
        //echo "Saved transactions sync to transactions - Count $count";
        
        return back();
        //return $transactions;
        
        //return "index2";
    }
    
    
    public function createNewTransaction($item,$id){
         $t2 = new Transaction;
            $t2->requested_by = $item->requested_by;
            $t2->email = $item->email; 
            $t2->date_transaction = $item->date_transaction; 
            $t2->amount = $item->amount; 
            $t2->running_balance = $item->running_balance; 

            $t2->remarks = $item->remarks; 

            $t2->status = $item->status;
            $t2->investment_type = $item->investment_type; 
            $t2->user_id = $item->user_id;
            $t2->notes = $item->notes;
            $t2->notes_investment_purpose = $item->notes_investment_purpose; 
            $t2->transaction_type_id = $item->transaction_type_id; 
            $t2->transaction_id = $item->transaction_id; 
            $t2->file_name = $item->file_name; 
            $t2->notes_withdraw_reason = $item->notes_withdraw_reason; 
            $t2->bank_name = $item->bank_name;
            $t2->bank_acct_no = $item->bank_acct_no;
            $t2->bank_acct_name = $item->bank_acct_name;
            $t2->bank_branch = $item->bank_branch;
            $t2->bank_account_type = $item->bank_account_type;
            $t2->bankrouting_no = $item->bankrouting_no;
            $t2->govt_id = $item->govt_id;
            $t2->authorization_letter = $item->authorization_letter;
            $t2->first_name = $item->first_name;
            $t2->last_name = $item->last_name;
            $t2->account_name = $item->account_name;
            $t2->account_id = $item->account_id;
            $t2->is_posted = $item->is_posted;
            $t2->testing = $item->testing;
            $t2->seen = $item->seen;
            $t2->dividend_payout = $item->dividend_payout;
            $t2->contribution_payout = $item->contribution_payout;
            $t2->sent_certificate = $item->sent_certificate;
            $t2->sync_id = $id;
            //return $t2;
            $t2->save();
            //return "Saved transactions sync to transactions";
    }
    
    public function toggleStatus2($item,$action,$item2 = ""){
        
        //if $action
     
       
    }
    
    
    public function toggleStatus($item,$status1,$status2,$item2 = ""){
        
        if ($item2!=NULL){
            
            if ( $item->status == $status1){
                    $item->status = $status2;
                    $item2->status = $status2;
            }else{
                 $item->status = $status1;
                 $item2->status = $status1;
            }
            
            
             $item->save();
             $item2->save();
            
        }else{
            
            if ( $item->status == $status1){
                    $item->status = $status2;
            }else{
                 $item->status = $status1;
            }
             $item->save();
        }
         
       
    }
    
    
    public function verifyId(Request $request)
    {
       
      
        $transactions = TransactionSync::where([
                ['id', '=', $request->verifyId  ],
            ])
        ->orderBy('id', 'desc')->get();
        
        $item = $transactions[0];
        $item->date_transaction = $request->verifyDate;
        $item->amount = $request->verifyAmount;
        $item->investment_type = $request->verifyInvestment;
        $item->remarks = $request->verifyRemarks;
        //find corresponding row at transactions
            $count = Transaction::where([
                ['sync_id', '=', $request->verifyId  ],
            ])
            ->count();
   
        
         if ($count == 0){ 
                $this->toggleStatus($item,"Verified","Verified");
                //$this->toggleStatus($item,"Verified","PendingAdmin");
                $this->createNewTransaction($item,$request->verifyId);
                
            } else {
                //SYNC CASE
                 $t2 = Transaction::where([
                ['sync_id', '=', $request->verifyId  ],
                ])
                ->get();
                
                $this->toggleStatus($item,"Verified","Verified",$t2[0]);
                $item->save();
                $t2[0]->date_transaction = $request->verifyDate;
                $t2[0]->amount = $request->verifyAmount;
                $t2[0]->investment_type = $request->verifyInvestment;
                $t2[0]->remarks = $request->verifyRemarks;
                $t2[0]->save();
                //$this->toggleStatus($item,"Verified","PendingAdmin",$t2[0]);
              

            }//end else
        
         //dd($item->status);
     
         if ($item->status == "Verified"){
             
            $data = array();
          
            $data["requested_by"] = $item->requested_by; 
            $data["email"] = $item->email; 
            $data["date_transaction"] = $item->date_transaction; 
            $data["amount"] = $item->amount; 
            $data["notes"] = $item->notes; 
            $data["investment_type"] = $item->investment_type; 
            
            $receiver = $item->email;
            //$receiver = "vincentvelasco1232019@gmail.com";
            
            $cc= array();
            
            
            $cc[] = "irmacuello18@gmail.com";
            $cc[] = "lianne.tabug@sedpi.com"; 
             $cc[] = "maliannedct@gmail.com"; 
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
             $cc[] = "fadviento@gmail.com"; 
             $cc[] = "vvmanychat2020@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new verifyWMail($data));
            /*
            $cc[] = "vincemvelasco@gmail.com";
             $cc[] = "lianne.tabug@sedpi.com"; 
             
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
             $cc[] = "maliannedct@gmail.com";
             $cc[] = "vincentvelascosw2020@gmail.com";
            Mail::to($request->email)->cc($cc)->send(new certMail($data,$request->user_id));
            */
         }
     
         return back()->with('message','Verified Successfully'); 
    }
    
    public function deleteIdFromUser(Request $request)
    {
        //dd($request->all());
        //dd($request->id);
        $t1 = Transaction::find($request->deleteid);
        //dd($t1);
        $t1->status = "Deleted";
        $t1->save();
        
        if (!$request->deletesyncid==0){
            $t2 = TransactionSync::findOrFail($request->deletesyncid);
            $t2->status = "Deleted";
            $t2->save();
        }
        
        return back()->with('message','Deleted Successfully'); 
        
    }
    
    public function deleteId(Request $request)
    {
        
      //  dd($request->all());
        $transactions = TransactionSync::where([
                ['id', '=', $request->deleteId  ],
            ])
        ->orderBy('id', 'desc')->get();
        
      
         $item = $transactions[0];
          $item->remarks = $request->deleteRemarks;
        //find corresponding row at transactions
            $count = Transaction::where([
                ['sync_id', '=', $request->deleteId  ],
            ])
            ->count();
        
        
          if ($count == 0){ 
                $this->toggleStatus($item,"Deleted","Deleted");
                //$this->toggleStatus($item,"Deleted","PendingAdmin");
                $this->createNewTransaction($item,$request->deleteId);
                
            } else {
                //SYNC CASE
                 $t2 = Transaction::where([
                ['sync_id', '=', $request->deleteId  ],
                ])
                ->get();
                
                $this->toggleStatus($item,"Deleted","Deleted",$t2[0]);
                //$this->toggleStatus($item,"Deleted","PendingAdmin",$t2[0]);
                $item->save();
                $t2[0]->remarks = $request->deleteRemarks;
                $t2[0]->save();
            }//end else
        
        
     
        return back()->with('message','Deleted Successfully'); 
 
    }
    
    
    public function pendingId(Request $request)
    {
      //dd($request->all());
      
       $transactions = TransactionSync::where([
                ['id', '=', $request->pendingId  ],
            ])
        ->orderBy('id', 'desc')->get();
        
           $item = $transactions[0];
           $item->remarks = $request->pendingRemarks;
           //$item->remarks = $request->pendingRemarks2;
           
            //find corresponding row at transactions
            $count = Transaction::where([
                ['sync_id', '=', $request->pendingId  ],
            ])
            ->count();
          
            if ($count == 0){ 
                $this->toggleStatus($item,"Pending","Pending");
                $this->createNewTransaction($item,$request->pendingId);
                
            } else {
                //SYNC CASE
                 $t2 = Transaction::where([
                ['sync_id', '=', $request->pendingId  ],
                ])
                ->get();
                
                $this->toggleStatus($item,"Pending","Pending",$t2[0]);
                $item->save();
                $t2[0]->remarks = $request->pendingRemarks;
                $t2[0]->save();

            }//end else
            
            if ($item->status == "Pending"){
             
            $data = array();
          
            $data["requested_by"] = $item->requested_by; 
            $data["email"] = $item->email; 
            if ($item->remarks == "No Transaction Date"){
                
               $data["date_transaction"] = "----/--/--";  
            }else{
                $data["date_transaction"] = $item->date_transaction; 
            }
            $data["amount"] = $item->amount; 
            $data["notes"] = $item->notes; 
            $data["remarks"] = $item->remarks; 
            $data["investment_type"] = $item->investment_type; 
            
            //$receiver = "vincentvelasco1232019@gmail.com";
            $receiver = $item->email;
            
            $cc= array();
           
           
            $cc[] = "irmacuello18@gmail.com";
            $cc[] = "lianne.tabug@sedpi.com"; 
             $cc[] = "maliannedct@gmail.com"; 
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
             $cc[] = "fadviento@gmail.com";
             $cc[] = "vvmanychat2020@gmail.com";
           
            
            Mail::to($receiver)->cc($cc)->send(new pendingWMail($data));
            /*
            $cc[] = "vincemvelasco@gmail.com";
             $cc[] = "lianne.tabug@sedpi.com"; 
             $cc[] = "irmacuello18@gmail.com";
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
             $cc[] = "maliannedct@gmail.com";
             $cc[] = "vincentvelascosw2020@gmail.com";
            Mail::to($request->email)->cc($cc)->send(new certMail($data,$request->user_id));
            */
         }
     
        return back()->with('message','Set to Pending Successfully');  
    }
    
   
    
   
    
   
   
}
