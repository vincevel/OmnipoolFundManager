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
        
        
    }

    public function test()
    {
        //
        
        return View('home2');
        
    }

   

    public function search(Request $request)
    {
        //dd($request->email);
        //First Name Last Name ID View Email
        if ($request->email != null){

            $search_str = strtolower($request->email);
  
            $tests = DB::table('users')
            ->where([
                ['email', 'like', "%".$search_str."%" ],
            ])
            ->orWhere([
                ['first_name', 'like', "%".$search_str."%" ],
            ])
            ->orWhere([
                ['last_name', 'like', "%".$search_str."%" ],
            ])
            ->orWhere([
                ['id', '=', $search_str ],
            ])
            ->orderBy('name', 'asc')
            ->get();

        
            return $tests;
        } else {
            $tests = DB::table('users')->get();
            return $tests;
        }
        //return view('dividends.dividendusers', [
        //    'tests' => $tests,
        //    'user' => $request->user()
            
        //]);

   
    }

    public function deletetransactions(Request $request){
        //dd($request->all());
        $trans_id = intval($request->trans_id);
        //dd($trans_id);
        if ($trans_id > 0){
            Transaction::destroy($trans_id);
            return $trans_id;
        }
        
        return 0;
    }

    public function gettransactions(Request $request)
    {
        //dd($request->email);
        //First Name Last Name ID View Email

         //$request->email = "Caldwell";

        if ($request->email != null){
    


            $tests = DB::table('transactions')
            ->where([
                ['user_id', '=', $request->email ],
            ])
            ->orderBy('date_transaction', 'desc')
            ->get();

            foreach ($tests as $transaction) {
                # code...

                $transaction->amount = "$ " . number_format($transaction->amount,2);    

                if ($transaction->transaction_type_id == 1){
                    $transaction->transaction_type_id = "Deposit";
                }elseif ($transaction->transaction_type_id == 3) {
                    $transaction->transaction_type_id = "Deferred";
                    # code...
                }elseif ($transaction->transaction_type_id == 5) {
                    $transaction->transaction_type_id = "Bonus";
                    # code...
                }elseif ($transaction->transaction_type_id == 4) {
                    $transaction->transaction_type_id = "Withdraw";
                    # code...
                }
            }

        
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

        //dd($request->all());
        //dd(explode("\n",$request->transactions));
    if ($request->transactions != null){    
        //$transactions = explode("\n",$request->transactions);

        //foreach ($transactions as $transaction){
           // $transaction_parts = explode(",",$transaction);

            $t1 = new Transaction;
            //dd($request->date);
            $date_transaction = strtotime($request->date);
            $t1->date_transaction = date('Y-m-d',$date_transaction);
            //$t1->time_transaction = $transaction_parts[1];
            //$t1->email = $transaction_parts[2];
            $t1->user_id = $request->id + 2;
            $t1->amount = str_replace(",", "", $request->amount);
            //$t1->transaction_type_id = $request->type;

 
            $t1->transaction_type_id = $request->type;
            //$t1->bitcoin_amount = $transaction_parts[4];
            //$t1->percentage_of_account = $transaction_parts[5];
           
            $t1->save();
            
        //}

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
    
   
}
