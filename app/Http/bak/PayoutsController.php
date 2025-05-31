<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payout;
use App\User;
use App\TransactionTestPayouts;

class PayoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $payouts = Payout::where([
            ['toinsert', '=', 9 ],
        ])->limit(10)->get();

        return view('payouts.payouts', [
            
            'payouts' => $payouts
            
        ]);
    }

    public function getCount($payout){

        //return 
    }


    public function showPayout( ) {
     
         
        //SEARCH FOR CORRESPODING USER MODEL instance

        /*
        $user = User::where([
            ['last_name', '=', $payout->lastname ],
        ])->orWhere([
            ['first_name', 'like', "%".$payout->firstname."%" ],
        ])->get();
        */
        $payouts = Payout::where([
            ['toinsert', '=', 1 ],
        ])->get();

        foreach ($payouts as $payout ){

            //$payout->lastname = trim($payout->lastname);
            //$payout->firstname = trim($payout->firstname);

            $count = User::where([
                ['last_name', '=', $payout->lastname ],
            ])->where([
                ['first_name', 'like', "%".$payout->firstname."%" ],
            ])->count();
 
            $user = User::where([
                ['last_name', '=', $payout->lastname ],
            ])->where([
                ['first_name', 'like', "%".$payout->firstname."%" ],
            ])->orderBy('id', 'desc')->get();


            //echo $payout;
            //$transaction = Transaction::
            
                    //print_r($payout->lastname);
               

            if ($count > 0){
                 echo "Count is" . $count . "<BR>";

                 $i =0 ;
                foreach ($user as $tempuser){
                    echo "here";
                    //echo $tempuser;
                    if ($i==0){
                        //Normal
                        $transaction1 = new TransactionTestPayouts;
                        $transaction1->last_name = $payout->lastname;
                        $transaction1->first_name = $payout->firstname;
                        $transaction1->user_id = $tempuser->id;
                        $transaction1->account_id = $tempuser->account_id;
                        $transaction1->email = $tempuser->user_email;
                        $transaction1->date_transaction = $payout->date;

                        $transaction1->status = "Verified";
                        //NEED TO DEFINE ORG
                        $transaction1->investment_type = $payout->org;
                        $transaction1->notes = "Dividend and Contribution Payout 31 Mar 2019";
                        
                        $transaction1->running_balance = $payout->sribal;
                        $transaction1->transaction_type_id = 2;
                        $transaction1->remarks = "Dividend and Contribution Payout 31 Mar 2019";
                        $transaction1->amount = $payout->contribpayout + $payout->divpayout ;

                        $transaction1->contribution_payout = $payout->contribpayout;
                        $transaction1->dividend_payout = $payout->divpayout;

                        $transaction1->file_name = "NA";
                        $transaction1->is_posted = 9;
                        $transaction1->requested_by = $payout->firstname . " " . $payout->lastname;
                        
                        //$transaction1->save();

                        //Wallet Transaction
                        $transaction2 = new TransactionTestPayouts;
                        $transaction2->last_name = $payout->lastname;

                        $transaction2->first_name = $payout->firstname;
                        $transaction2->user_id = $tempuser->id;
                        $transaction2->account_id = $tempuser->account_id;
                        $transaction2->email = $tempuser->user_email;
                        $transaction2->date_transaction = $payout->date;

                        $transaction2->status = "Verified";
                        $transaction2->investment_type = "My Wallet";
                        $transaction2->notes = "Wallet Dividend Payout and Contribution Payout ";
                            
                        $transaction2->running_balance = $payout->walletbal;
                        $transaction2->transaction_type_id = 2;
                        $transaction2->remarks = "Wallet Dividend and Contribution Payout";
                        $transaction2->amount = $payout->walletbal;
                            
                        $transaction2->file_name = "NA";
                        $transaction2->is_posted = 9;
                        $transaction2->requested_by = $payout->firstname . " " . $payout->lastname;

                        $transaction2->save();
                //$transaction1->amount2 = $payout->divpayout;
                        $i++;
                    }

                  }

            /*      
            }else if($count >1){    
                echo $payout->firstname . " " . $payout->lastname . "<BR>";
                echo "Count is" . $count . "<BR>";
                echo "Multiple Users Found<BR><br>";
            */

            }else{
                echo $payout->firstname . " " . $payout->lastname . "<BR>";
                echo "Count is" . $count . "<BR>";
                echo "No User Found<BR><br>";
            }
        } // END foreach payouts
        //$transaction1->save();

        /*
        $inputs["email"]
        $inputs["date_transaction"]
        $inputs["status"]
        $inputs["investment_type"]
        $inputs["notes"]
        $inputs["file_name"]
        $inputs["running_balance"]
            $this->transaction_type_id = 1; 
            $this->is_posted = 1;
            $this->remarks = $this->notes;
            //$this->status = "Pending";
            $this->requested_by = "{$this->first_name} {$this->last_name}";
        */

        //return $count;

        //return view('payouts.showpayout',compact('payout'));
        
    }
    
     public function showPayout2( ) {
     
         
        //SEARCH FOR CORRESPODING USER MODEL instance

        /*
        $user = User::where([
            ['last_name', '=', $payout->lastname ],
        ])->orWhere([
            ['first_name', 'like', "%".$payout->firstname."%" ],
        ])->get();
        */
        $payouts = Payout::where([
            ['toinsert', '=', 9 ],
        ])->get();

        foreach ($payouts as $payout ){

            //$payout->lastname = trim($payout->lastname);
            //$payout->firstname = trim($payout->firstname);

            $count = User::where([
                ['last_name', '=', $payout->lastname ],
            ])->where([
                ['first_name', 'like', "%".$payout->firstname."%" ],
            ])->count();
 
            $user = User::where([
                ['last_name', '=', $payout->lastname ],
            ])->where([
                ['first_name', 'like', "%".$payout->firstname."%" ],
            ])->orderBy('id', 'desc')->get();


            //echo $payout;
            //$transaction = Transaction::
            
                    //print_r($payout->lastname);
               

            if ($count > 0){
                 echo "Count is" . $count . "<BR>";

                 $i =0 ;
                foreach ($user as $tempuser){
                    echo "here";
                    //echo $tempuser;
                    if ($i==0){
                        //Normal
                        $transaction1 = new TransactionTestPayouts;
                        $transaction1->last_name = $payout->lastname;
                        $transaction1->first_name = $payout->firstname;
                        $transaction1->user_id = $tempuser->id;
                        $transaction1->account_id = $tempuser->account_id;
                        $transaction1->email = $tempuser->user_email;
                        $transaction1->date_transaction = $payout->date;

                        $transaction1->status = "Verified";
                        //NEED TO DEFINE ORG
                        $transaction1->investment_type = $payout->org;
                        $transaction1->notes = "Dividend and Contribution Payout 31 Mar 2020";
                        
                        $transaction1->running_balance = $payout->sribal;
                        $transaction1->transaction_type_id = 2;
                        $transaction1->remarks = "Dividend and Contribution Payout 31 Mar 2020";
                        $transaction1->amount = $payout->contribpayout + $payout->divpayout ;

                        $transaction1->contribution_payout = $payout->contribpayout;
                        $transaction1->dividend_payout = $payout->divpayout;

                        $transaction1->file_name = "NA";
                        $transaction1->is_posted = 9;
                        $transaction1->requested_by = $payout->firstname . " " . $payout->lastname;
                        
                        $transaction1->save();

                        //Wallet Transaction
                        $transaction2 = new TransactionTestPayouts;
                        $transaction2->last_name = $payout->lastname;

                        $transaction2->first_name = $payout->firstname;
                        $transaction2->user_id = $tempuser->id;
                        $transaction2->account_id = $tempuser->account_id;
                        $transaction2->email = $tempuser->user_email;
                        $transaction2->date_transaction = $payout->date;

                        $transaction2->status = "Verified";
                        $transaction2->investment_type = "My Wallet";
                        $transaction2->notes = "Wallet Dividend Payout and Contribution Payout ";
                            
                        $transaction2->running_balance = $payout->walletbal;
                        $transaction2->transaction_type_id = 2;
                        $transaction2->remarks = "Wallet Dividend and Contribution Payout";
                        $transaction2->amount = $payout->walletbal;
                            
                        $transaction2->file_name = "NA";
                        $transaction2->is_posted = 9;
                        $transaction2->requested_by = $payout->firstname . " " . $payout->lastname;

                        $transaction2->save();
                        
                        $i++;
                    }

                  }

            /*      
            }else if($count >1){    
                echo $payout->firstname . " " . $payout->lastname . "<BR>";
                echo "Count is" . $count . "<BR>";
                echo "Multiple Users Found<BR><br>";
            */

            }else{
                echo $payout->firstname . " " . $payout->lastname . "<BR>";
                echo "Count is" . $count . "<BR>";
                echo "No User Found<BR><br>";
            }
        } // END foreach payouts
        //$transaction1->save();

        /*
        $inputs["email"]
        $inputs["date_transaction"]
        $inputs["status"]
        $inputs["investment_type"]
        $inputs["notes"]
        $inputs["file_name"]
        $inputs["running_balance"]
            $this->transaction_type_id = 1; 
            $this->is_posted = 1;
            $this->remarks = $this->notes;
            //$this->status = "Pending";
            $this->requested_by = "{$this->first_name} {$this->last_name}";
        */

        //return $count;

        //return view('payouts.showpayout',compact('payout'));
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
