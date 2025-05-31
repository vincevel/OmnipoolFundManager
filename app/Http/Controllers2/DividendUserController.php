<?php

namespace App\Http\Controllers;

use DB;
use App\UserO;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DividendUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        //
        
        //dd($r->user);
        //return view('dividends.dividendusers');
        
        if ($r->user=="admin"){
         
          return view('dividends.dividendusers', [
            'user' => $r->user()
            
        ]); 
        }
        
        return view('dividends.dividendusers', [
           
            
        ]);
    }

    public function indexError(Request $r)
    {
        //
        return view('dividends.dividenduserserror');
    }

    public function searchapi(Request $request)
    {
        
        //First Name Last Name ID View Email
        $tests = array();
       
        $validator = Validator::make($request->all(), [
        'email' => 'required|max:50|min:3',
        ]);
        
        
        if ($validator->fails()) {

                return redirect('/dividendusererror')
                ->withInput()
                ->withErrors($validator);
        }


  
        $tests = DB::table('users')
        ->where([
            ['email', 'like', "%".$request->email."%" ],
        ])
        ->orWhere([
            ['name', 'like', "%".$request->email."%" ],
        ])
        ->orWhere([
            ['id', '=', $request->email ],
        ])
        ->orderBy('last_name', 'asc')
        ->get();

    

        return view('dividends.dividendusers', [
            'tests' => $tests,
            'user' => $request->user()
            
        ]);

   
    }

    public function search(Request $request)
    {
        //dd($request->email);
        //First Name Last Name ID View Email
        if ($request->email != null){
  
            $tests = DB::table('users')
            ->where([
                ['email', 'like', "%".$request->email."%" ],
            ])
            ->orWhere([
                ['name', 'like', "%".$request->email."%" ],
            ])
            ->orWhere([
                ['id', '=', $request->email ],
            ])
            ->orderBy('name', 'asc')
            ->get();

        
            return $tests;
        } else {
            return 0;
        }
        //return view('dividends.dividendusers', [
        //    'tests' => $tests,
        //    'user' => $request->user()
            
        //]);

   
    }

    public function gettransactions(Request $request)
    {
        //dd($request->email);
        //First Name Last Name ID View Email

         //$request->email = "Caldwell";

        if ($request->email != null){
    


            $tests = DB::table('transactions')
            ->where([
                ['email', 'like', "%".$request->email."%" ],
            ])
            ->orderBy('email', 'asc')
            ->get();

        
            return $tests;
        } else {
            return 0;
        }
        //return view('dividends.dividendusers', [
        //    'tests' => $tests,
        //    'user' => $request->user()
            
        //]);

   
    }

    public function submittransactions(Request $request)
    {

        //dd(explode("\n",$request->transactions));
    if ($request->transactions != null){    
        $transactions = explode("\n",$request->transactions);

        foreach ($transactions as $transaction){
            $transaction_parts = explode(",",$transaction);

            $t1 = new Transaction;
            $t1->date_transaction = $transaction_parts[0];
            $t1->time_transaction = $transaction_parts[1];
            $t1->email = $transaction_parts[2];
            $t1->user_id = $transaction_parts[2];
            $t1->amount = $transaction_parts[3];
            $t1->bitcoin_amount = $transaction_parts[4];
            $t1->percentage_of_account = $transaction_parts[5];
           
                $t1->save();
            
        }

        $prefix = "(";
        $suffix = ",'', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-03-09 18:41:21', '2022-03-09 18:41:21', NULL),";
       
        $suffix2 = "('2021-10-06','9:16:00 PM','Caldwell','1465.56','0.026872','0.4','', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-03-09 18:41:21', '2022-03-09 18:41:21', NULL),";
    }
//         2021-10-06,9:16:00 PM,Caldwell,1465.56,0.026872,0.4
// 2021-10-06,9:16:00 PM,Caldwell,1465.56,0.026872,0.4
// 2021-10-06,9:16:00 PM,Caldwell,1465.56,0.026872,0.4

// 2021-10-06,9:16:00 PM,Caldwell,1465.56,0.026472,0.2
// 2021-11-06,10:16:00 PM,Caldwell,1065.56,0.0212872,0.3
// 2021-12-06,11:16:00 PM,Caldwell,565.56,0.023872,0.5

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    }
    
    public function list($id)
    {
        
        $user = UserO::where([
                ['id', '=', $id ],
        ])->get();
        
        //var_dump($user[0]->id);
        //var_dump($user[0]->user_email);
        //var_dump($user[0]->first_name);
        //var_dump($user[0]->last_name);
        
        $userId = "";
        
        $userId = $user[0]->id;
        $email = $user[0]->user_email;
        $first_name = $user[0]->first_name;
        $last_name = $user[0]->last_name;
        $fname =  strtoupper(substr($first_name, 0, 1));
        $lname = strtoupper(substr($last_name, 0, 1));
        $userIdNum = sprintf('%08d', $userId);
        
        $date = $user[0]->created_at->format('ymd');
        
        $userId = $fname . $lname  ."-". $date ."-".$userIdNum;
        

        //$statusArr = ["Verified","Pending"];
        //$otherInvestmentArray = ["My Wallet","Pending"];

        //Wallet only and verified only
        $walletHeader = ['Date','Amount','Running Balance','Code','Status','Remarks from SEDPI'];
        $transactionsWallet = Transaction::where([
                ['user_id', '=', $id ],
        ])->where('investment_type','My Wallet')
        ->where('status','Verified')
        ->orderBy('investment_type', 'date_transaction')
        ->get();
        
        //only not wallet investment and only verified
        
        $transactionHeader = ['Date','Dividend Payout','Contribution Payout','Amount','Running Balance','Code','Status','Remarks from SEDPI'];
        $transactions = Transaction::where([
                ['user_id', '=', $id ],
        ])->whereNotIn('investment_type', ["My Wallet"])
        ->where('status','Verified')
        ->orderBy('investment_type', 'date_transaction')
        ->get();
        
        //all investment but pending only
        
        $pendingHeader = ['Date','Amount','Code','Status','SRI Chosen','View','Delete','Remarks from SEDPI'];
        $transactionsPending = Transaction::where([
                ['user_id', '=', $id ],
        ])->where('investment_type','Pending')
        ->where('status','Pending')
        ->orderBy('investment_type', 'date_transaction')
        ->get();
        
          // return $user;
        
        //return redirect()->route('backend3', ['jumpToPage' => 22,'id' => $id]);
 
        //dd($transactionsWallet);

           
        return view('demo5.backend2', [
            'user' => $user[0],
            'walletHeader' => $walletHeader,
            'transactionsWallet' => $transactionsWallet,
            'transactionHeader' => $transactionHeader,
            'transactions' => $transactions,
            'pendingHeader' => $pendingHeader,
            'userId' => $userId,
            'transactionsPending' => $transactionsPending
            
        ]);
        
        //return "At List $id";
    }

    public function list2($id)
    {
        //$id = 34;

        $user = UserO::where([
                ['id', '=', $id ],
        ])->get();

        $userId = "";
        
        $userId = $user[0]->id;
        $email = $user[0]->user_email;
        $first_name = $user[0]->first_name;
        $last_name = $user[0]->last_name;
        $fname =  strtoupper(substr($first_name, 0, 1));
        $lname = strtoupper(substr($last_name, 0, 1));
        $userIdNum = sprintf('%08d', $userId);
        
        $date = $user[0]->created_at->format('ymd');
        
        $userId = $fname . $lname  ."-". $date ."-".$userIdNum;
        

        //$statusArr = ["Verified","Pending"];
        //$otherInvestmentArray = ["My Wallet","Pending"];

        //Wallet only and verified only
        $walletHeader = ['Date','Amount','Running Balance','Code','Status','Remarks from SEDPI'];
        $transactionsWallet = Transaction::where([
                ['user_id', '=', $id ],
        ])->where('investment_type','My Wallet')
        ->where('status','Verified')
        ->orderBy('investment_type', 'asc')
        ->orderBy('date_transaction', 'asc')
        ->get();
        
        //only not wallet investment and only verified
        
        $transactionHeader = ['Date','Dividend Payout','Contribution Payout','Amount','Running Balance','Code','Status','Remarks from SEDPI'];
        $transactions = Transaction::where([
                ['user_id', '=', $id ],
        ])->whereNotIn('investment_type', ["My Wallet"])
        ->where('status','Verified')
        //->orderBy('investment_type', 'date_transaction')
        ->orderBy('investment_type', 'asc')
        ->orderBy('date_transaction', 'asc')
        ->get();

        $transactionsTypes = Transaction::where([
        ['user_id', '=', $id ],
        ])->whereNotIn('investment_type', ["My Wallet"])
        ->where('status','Verified')
        ->distinct()
        ->pluck('investment_type');

        
        
        //createTypesArray
        $types = array();
        foreach ($transactionsTypes as $item){
            $types["$item"] = array();

        }

        foreach ($transactions as $item){
            //if (isset($types[$item->investment_type])){
                array_push($types[$item->investment_type],$item);
            //}else{
             //   $types[$item->investment_type] = array();
            //    $types[$item->investment_type][] = $item;
            //}
        }

        //dd($types);
        //all investment but pending only
        
        $pendingHeader = ['Date','Amount','Code','Status','SRI Chosen','View','Delete','Remarks from SEDPI'];
        $transactionsPending = Transaction::where([
                ['user_id', '=', $id ],
        ])->where('status','Pending')
        ->orderBy('investment_type', 'asc')
        ->orderBy('date_transaction', 'asc')
        ->get();
        
          // return $user;
        
        //return redirect()->route('backend3', ['jumpToPage' => 22,'id' => $id]);
 
        //dd($transactionsWallet);

          
        return view('demo5.backend3', [
            'user' => $user[0],
            'walletHeader' => $walletHeader,
            'transactionsWallet' => $transactionsWallet,
            'transactionHeader' => $transactionHeader,
            'transactions' => $transactions,
            'pendingHeader' => $pendingHeader,
            'userId' => $userId,
            'transactionsPending' => $transactionsPending,
            'types' => $types
        ]);
        
        
        //return "At List $id";
    }
    
    public function list3($id)
    {
        
        $user = UserO::where([
                ['id', '=', $id ],
        ])->get();
        

        

           
        return view('demo5.backend4', [
            'user' => $user[0]
            
        ]);
        
        //return "At List $id";
    } 

    public function list4($id)
    {
        
        $user = UserO::where([
                ['id', '=', $id ],
        ])->get();
        

        

           
        return view('demo5.backend5', [
            'user' => $user[0]
            
        ]);
        
        //return "At List $id";
    } 
     
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function mergeaccounts(Request $request)
    {
        //dd($request);

        //VALIDATE
        $this->validate($request,[
            'from_account' => 'required'        
        ]);

        //CHECK IF DIFFERENT ACCOUNT
        if (trim($request->from_account) == trim($request->taccount)){
            return back()->withErrors(["errors1"=>"Accounts must be different"]);
        }



        $user1 = UserO::where(DB::raw("TRIM(user_email)"), trim($request->from_account))->count(); 
        
        //dd($user1);
        //dd($user1);
        if ($user1 <= 0){
             return back()->withErrors(["errors1"=>"From Account Not Found"]);
        } else {
            $user1 = UserO::where('user_email', $request->from_account)->get(); 
            $userTo = UserO::where('user_email', $request->taccount)->get(); 
        }



        $id = $user1[0]->id;
        $toId = $userTo[0]->id;
        //dd($request);
        $transactionsOld = Transaction::where('user_id', $id)->get();
        //dd($transactionsOld);
       
        foreach ($transactionsOld as $transaction) {
            # code...
            //transaction->user_id = $request->id;
            //set to existing user id
            $transaction->transferred_id = $toId;
           // $transaction->save();

            $status = $transaction->status;
            $transaction->status = "Transferred";
            $transaction->save();

            //dd($transaction);
            $t2 = new Transaction;
           
           

            $t2->date_transaction = $transaction->date_transaction;
            $t2->requested_by = $transaction->requested_by;
            $t2->email = $transaction->email;
            $t2->amount = $transaction->amount;
            $t2->investment_type = $transaction->investment_type; 
            $t2->running_balance = $transaction->running_balance;
            $t2->remarks = $transaction->remarks; 
            $t2->status = $status;
            //$t2->status = "Transferred2";
            $t2->user_id = $toId;
            $t2->transaction_type_id = $transaction->transaction_type_id;
            $t2->notes = $transaction->notes;
            $t2->notes_investment_purpose = $transaction->notes_investment_purpose;
            $t2->file_name = $transaction->file_name;
            $t2->transaction_id = $transaction->transaction_id;
            $t2->notes_withdraw_reason = $transaction->notes_withdraw_reason;
            $t2->bank_name = $transaction->bank_name;
            $t2->bank_acct_no = $transaction->bank_acct_no;
            $t2->bank_acct_name = $transaction->bank_acct_name; 
            $t2->bank_branch = $transaction->bank_branch;
            $t2->bank_account_type = $transaction->bank_account_type; 
            $t2->bankrouting_no = $transaction->bankrouting_no; 
            $t2->govt_id = $transaction->govt_id;
            $t2->authorization_letter = $transaction->authorization_letter; 
            $t2->first_name = $transaction->first_name; 
            $t2->last_name = $transaction->last_name;
            $t2->account_name = $transaction->account_name;  
            $t2->account_id = $transaction->account_id; 
            $t2->is_posted = $transaction->is_posted; 
            $t2->testing = $transaction->testing; 
            $t2->seen = $transaction->seen;
            $t2->sent_certificate = $transaction->sent_certificate;
            $t2->dividend_payout = $transaction->dividend_payout;
            $t2->contribution_payout = $transaction->contribution_payout;
            $t2->sync_id = $transaction->sync_id;
            $t2->transferred_id = $transaction->transferred_id;
            $t2->save();

        }
        //d($transactionsOld);

        return back()->with('message','Accounts Merged');
    }
    
    public function convertDate($date){
        //   case "0-Dec 1-31, 2-2013": $date2 = "2013-12-31"; break;
        list($month,$day,$year) = explode(" ", $date);
        $day = str_replace(",", "", $day);
        $month = $this->convertMonthToNum($month);

        return implode("-",array($year,$month,$day));
    }

    public function convertMonthToNum($month){

        switch ($month) {
            case 'Jan': $month = "01"; break;
            case 'Feb': $month = "02"; break;
            case 'Mar': $month = "03"; break;
            case 'Apr': $month = "04"; break;
            case 'May': $month = "05"; break;
            case 'Jun': $month = "06"; break;
            case 'June': $month = "06"; break;
            case 'Jul': $month = "07"; break;
            case 'Aug': $month = "08"; break;
            case 'Sep': $month = "09"; break;
            case 'Oct': $month = "10"; break;
            case 'Nov': $month = "11"; break;
            case 'Dec': $month = "12"; break;
        }
        return $month;
    }

    public function removeCommas($str){


        return str_replace(",", "", $str);
    }

    public function store(Request $request)
    {
        $user1 = UserO::where([
                ['id', '=', $request->id ],
            ])->get();
        
             //return $user;
        $user = $user1[0];
        
        //all from user query
                        $transaction1 = new Transaction;
                        $transaction1->last_name = $user->last_name;
                        $transaction1->first_name = $user->first_name;
         
                        $transaction1->user_id = $user->id;
                        $transaction1->account_id = $user->account_id;
                        $transaction1->email = $user->user_email;
                        
                        //from form
                        //$date = explode("/",$request->date2);
                        //01/01/2020 to  2020-01-01
                        //$date2 = "$date[2]" . "-". "$date[0]" . "-" . "$date[1]";
                        //$date2 = "";
                        $date2 = $this->convertDate($request->date2);
                        
                        /*
                        switch ($request->date2){

            case "Dec 31, 2013": $date2 = "2013-12-31"; break;
            case "Dec 31, 2014": $date2 = "2014-12-31"; break;
            case "Dec 31, 2015": $date2 = "2015-12-31"; break;
            case "Dec 31, 2016": $date2 = "2016-12-31"; break;
            case "Dec 31, 2017": $date2 = "2017-12-31"; break;
            case "Dec 31, 2018": $date2 = "2018-12-31"; break;
            case "Dec 31, 2019": $date2 = "2019-12-31"; break;
                        
                            case "Mar 31, 2020":
                                    $date2 = "2020-03-31";
                                break;
                                
                            case "June 30, 2020":
                                    $date2 = "2020-06-30";
                                break;
                                
                            case "Sep 30, 2020":
                                    $date2 = "2020-09-30";
                                break;
                                
            case "Dec 31, 2020": $date2 = "2020-12-31"; break;

                            case "Mar 31, 2021":
                                    $date2 = "2021-03-31";
                                break;
                                
                            case "June 30, 2021":
                                    $date2 = "2021-06-30";
                                break;
                                
                            case "Sep 30, 2021":
                                    $date2 = "2021-09-30";
                                break;
                                
                            case "Dec 31, 2021":
                                    $date2 = "2021-12-31";
                                break;
                                
                            
                        }
                        */
                        
                        //dd($date);
                        $transaction1->date_transaction = $date2;

                        $transaction1->status = "Verified";
                        //NEED TO DEFINE ORG
                        $transaction1->investment_type = $request->investment1;
                       
                        $transaction1->transaction_type_id = 6;
                        
                        //dd($request->$date2);
                        
                        $transaction1->remarks = "Dividend and Contribution Payout " . $request->date2;
                         
                         
                         
                         
                        $transaction1->contribution_payout = $this->removeCommas($request->amount2);
                        $transaction1->dividend_payout = $this->removeCommas($request->amount);

 
                        $transaction1->amount = $transaction1->contribution_payout + $transaction1->dividend_payout ;
                        $transaction1->running_balance = $this->removeCommas($request->amount);
                        
                        $amt = $transaction1->contribution_payout + $transaction1->dividend_payout ;
              
                        $transaction1->is_posted = 8;
                        $transaction1->requested_by = $user->first_name . " " . $user->last_name;
                        
                        $transaction1->save();

                        //Wallet Transaction
                        $transaction2 = new Transaction;
                        $transaction2->last_name = $user->last_name;
                        $transaction2->first_name = $user->first_name;

                        $transaction2->user_id = $user->id;
                        $transaction2->account_id = $user->account_id;
                        $transaction2->email = $user->user_email;
                        
                        //from form
                        $transaction2->date_transaction = $date2;

                        $transaction2->status = "Verified";
                        //NEED TO DEFINE ORG
                        $transaction2->investment_type = "My Wallet";
                       
                        $transaction2->transaction_type_id = 7;
                        $transaction2->remarks = "Wallet Dividend and Contribution Payout " . $request->date2;

                        $transaction2->amount = $amt;
                        $transaction2->running_balance = $this->removeCommas($request->amount);
 
              
                        $transaction2->is_posted = 8;
                        $transaction2->requested_by = $user->first_name . " " . $user->last_name;
                        
                        $transaction2->save();













        //return "At Store";
 
        //return $transaction1;
        return back()->with('message','Dividend and Contribution Payout Added');   
    }
    
    public function storeReinvest(Request $request)
    {
        //return $request->investment1;
        $user1 = UserO::where([
                ['id', '=', $request->id ],
        ])->get();
       
        //return $user;
        $user = $user1[0];
       
             //Wallet Transaction
                        $transaction2 = new Transaction;
                        $transaction2->last_name = $user->last_name;
                        $transaction2->first_name = $user->first_name;

                        $transaction2->user_id = $user->id;
                        $transaction2->account_id = $user->account_id;
                        $transaction2->email = $user->user_email;
                        
                        //from form
                        
                        $date = explode("/",$request->date);
                        //01/01/2020 to  2020-01-01
                        $date2 = "$date[2]" . "-". "$date[0]" . "-" . "$date[1]";
                        $transaction2->date_transaction = $date2;

                        $transaction2->status = "Verified";
  
                        $transaction2->investment_type = "My Wallet";
                       
                        $transaction2->transaction_type_id = 8;
                        $transaction2->remarks = "Reinvested to $request->investment1";

                        $transaction2->amount = $request->amount;
                        $transaction2->running_balance = $request->amount;
 
              
                        $transaction2->is_posted = 8;
                        $transaction2->requested_by = $user->first_name . " " . $user->last_name;
                        
                        $transaction2->save();
                        
                        
                        //ORG Transaction
                        $transaction1 = new Transaction;
                        $transaction1->last_name = $user->last_name;
                        $transaction1->first_name = $user->first_name;
         
                        $transaction1->user_id = $user->id;
                        $transaction1->account_id = $user->account_id;
                        $transaction1->email = $user->user_email;
                        
                        //from form
                        $transaction1->date_transaction = $date2;

                        $transaction1->status = "Verified";
 
                        $transaction1->investment_type = $request->investment1;
                       
                        $transaction1->transaction_type_id = 9;
                        $transaction1->remarks = "Reinvestment";

 
                        $transaction1->amount =  $request->amount;
                        $transaction1->running_balance = $request->amount;
              
                        $transaction1->is_posted = 8;
                        $transaction1->requested_by = $user->first_name . " " . $user->last_name;
                        
                        $transaction1->save();

                
       
        //return $request->select1;
        //return back()->with('message','Reinvestment 1n2 Added');   
        return back()->with('message','Reinvestment Added');  
    }
    
    public function storeweb2(Request $request)
    {
        //$request->amount = str_replace( ',', '', $request->amount );
        
        $this->validate($request,[
            'amount' => 'required|numeric',
            'investment' => 'required',
            'date' => 'required'
            
        ]);
        
     

        $user1 = UserO::where([
                ['id', '=', $request->id ],
            ])->get();
        
             //return $user;
        $user = $user1[0];
        
        //all from user query
                        $transaction1 = new Transaction;
                        $transaction1->last_name = $user->last_name;
                        $transaction1->first_name = $user->first_name;
         
                        $transaction1->user_id = $user->id;
                        $transaction1->account_id = $user->account_id;
                        $transaction1->email = $user->user_email;
                        
                        //from form
                        $transaction1->date_transaction = $request->date;

                        $transaction1->status = "Verified";
                        //NEED TO DEFINE ORG
                        $transaction1->investment_type = $request->investment;
                       
                        $transaction1->transaction_type_id = 10;
                        $transaction1->remarks = "Transferred to My Wallet";

 
                        $transaction1->amount =  $request->amount;
                        $transaction1->running_balance = $request->amount;
                        $amt = $request->amount;
                        //$amt = $transaction1->contribution_payout + $transaction1->dividend_payout ;
              
                        $transaction1->is_posted = 8;
                        $transaction1->requested_by = $user->first_name . " " . $user->last_name;
                        
                        $transaction1->save();

                        //Wallet Transaction
                        $transaction2 = new Transaction;
                        $transaction2->last_name = $user->last_name;
                        $transaction2->first_name = $user->first_name;

                        $transaction2->user_id = $user->id;
                        $transaction2->account_id = $user->account_id;
                        $transaction2->email = $user->user_email;
                        
                        //from form
                        $transaction2->date_transaction = $request->date;

                        $transaction2->status = "Verified";
                        //NEED TO DEFINE ORG
                        $transaction2->investment_type = "My Wallet";
                       
                        $transaction2->transaction_type_id = 1;
                        $transaction2->remarks = "Transferred from $request->investment";

                        $transaction2->amount = $amt;
                        $transaction2->running_balance = $request->amount;
 
              
                        $transaction2->is_posted = 8;
                        $transaction2->requested_by = $user->first_name . " " . $user->last_name;
                        
                        $transaction2->save();













        //return "At Store";
 
        //return $transaction1;
        return back()->with('message','Wallet Funds Successfully Transferred');   
    }
     
    public function store2(Request $request)
    {
        //
        //return $request;
        
           $user1 = UserO::where([
                ['id', '=', $request->id ],
            ])->get();
        
             //return $user;
        $user = $user1[0];
        
        //all from user query
         $transaction1 = new Transaction;
         
         $transaction1->last_name = $user->last_name;
         $transaction1->first_name = $user->first_name;
          
       
          $transaction1->user_id = $user->id;
                        $transaction1->account_id = $user->account_id;
                        $transaction1->email = $user->user_email;
                        
                        //from form
                        $transaction1->date_transaction = $request->date;

                        $transaction1->status = "Verified";
                        //NEED TO DEFINE ORG
                        $transaction1->investment_type = "SEDPI";
                
                       
                       
                        $transaction1->transaction_type_id = 2;
                        $transaction1->remarks = "Dividend for 2019 Dec";
 
                        $transaction1->amount = $request->amount;
                        $transaction1->running_balance = $request->amount;
 
              
                        $transaction1->is_posted = 7;
                        $transaction1->requested_by = $user->first_name . " " . $user->last_name;
                        
                        $transaction1->save();


        //return "At Store";
 
        //return $transaction1;
        return back()->with('message','Dividend Added');   
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(UserO $user)
    {
        //return $user->id;
        
        $t1 = DB::table('transactions')->select('investment_type')->distinct()->get();
        
        return view('dividends.adddividendusers', [
            'user' => $user,
            'investments' => $t1
            
        ]);
        
        //return 123;

        //return $user;
    }
    
    public function show2(UserO $user)
    {
        //return $user->id;
        //return "show2";
        $t1 = DB::table('transactions')->select('investment_type')->distinct()->get();
        return view('dividends.adddividendusers2', [
            'user' => $user,
            'investments' => $t1
            
        ]);
        
        //return 123;

        //return $user;
    }

    public function showmerge(UserO $user)
    {
        //dd($user);

        return view('dividends.mergeusers', [
            'user' => $user
            
            
        ]);
        
    }
    
    public function showReinvest(UserO $user)
    {
        //return $user->id;
        //return "showReinvest";
        
        
        $t1 = DB::table('transactions')->select('investment_type')->distinct()->get();
        
        //return $t1;
        
        
        return view('dividends.adddividendusersreinvest', [
            'user' => $user,
            'investments' => $t1
        ]);
        
        //return 123;

        //return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
