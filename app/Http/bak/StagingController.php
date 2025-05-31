<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\TransactionSync;
use App\Transaction;



class StagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(){
        
         $transactions = TransactionSync::where([])
        ->orderBy('id', 'desc')->get();
        
        
        return view('staging.listTransactions', [
            
            'transactions' => $transactions
            
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
   
    public function deleteId(Request $request)
    {
        //return "here at Id";
        //return $request->$id;
        
        //return dd($request->all());
        
        $transactions = TransactionSync::where([
                ['id', '=', $request->itemIdNDel  ],
            ])
        ->orderBy('id', 'desc')->get();
        
        //return $transactions[0]->email;
        
        foreach ($transactions as $item)
        {
         
            //return "Saved transactions sync to transactions";
            
            if ( $item->status == "Deleted"){
                $item->status = "PendingAdmin";
            }else {
                 $item->status = "Deleted";
            }
           
            $item->save();
        }
     
        return back();
 
    }
   
   
}
