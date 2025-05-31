<?php

namespace App\Http\Controllers;

use DB;
use App\UserO;
use App\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DividendUserController2 extends Controller
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

    public function search(Request $request)
    {
        
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
            ['user_email', 'like', "%".$request->email."%" ],
        ])
        ->orWhere([
            ['first_name', 'like', "%".$request->email."%" ],
        ])
        ->orWhere([
            ['last_name', 'like', "%".$request->email."%" ],
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function list($id)
    {
        
        $user = UserO::where([
                ['id', '=', $id ],
        ])->get();
        

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

    public function list5b($id)
    {

        $id = 16215;    
        
        $user = UserO::where([
                ['id', '=', $id ],
        ])->get();
        

        

           
        return view('demo5.backend5c', [
            'user' => $user[0]
            
        ]);
        
        //return "At List $id";
    } 

    public function list5bRental($id)
    {

        $id = 16215;    
        
        $user = UserO::where([
                ['id', '=', $id ],
        ])->get();
        

        

           
        return view('demo5.backend5cRental', [
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
        $this->validate($request,[
            'from_account' => 'required'        
        ]);

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
        }



        $id = $user1[0]->id;
        //dd($request);
        $transactionsOld = Transaction::where('user_id', $id)->get();
        //dd($transactionsOld);
       
        foreach ($transactionsOld as $transaction) {
            # code...
            $transaction->user_id = $request->id;
            //set to existing user id
            $transaction->transferred_id = $id;
           // $transaction->save();
        }
        //d($transactionsOld);

        




        return back()->with('message','Accounts Merged');
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
                        $date2 = "";
                        
                        switch ($request->date2){
                        
                            case "Mar 31, 2020":
                                    $date2 = "2020-03-31";
                                break;
                                
                            case "June 30, 2020":
                                    $date2 = "2020-06-30";
                                break;
                                
                            case "Sep 30, 2020":
                                    $date2 = "2020-09-30";
                                break;
                                
                            case "Dec 31, 2020":
                                    $date2 = "2020-12-31";
                                break;

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
                        
                        
                        //dd($date);
                        $transaction1->date_transaction = $date2;

                        $transaction1->status = "Verified";
                        //NEED TO DEFINE ORG
                        $transaction1->investment_type = $request->investment1;
                       
                        $transaction1->transaction_type_id = 6;
                        
                        //dd($request->$date2);
                        
                        $transaction1->remarks = "Dividend and Contribution Payout " . $request->date2;
                         
                         
                         
                         
                        $transaction1->contribution_payout = $request->amount2;
                        $transaction1->dividend_payout = $request->amount;

 
                        $transaction1->amount = $transaction1->contribution_payout + $transaction1->dividend_payout ;
                        $transaction1->running_balance = $request->amount;
                        
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
                        $transaction2->remarks = "Wallet Dividend and Contribution Payout";

                        $transaction2->amount = $amt;
                        $transaction2->running_balance = $request->amount;
 
              
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
