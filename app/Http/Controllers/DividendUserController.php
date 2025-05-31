<?php

namespace App\Http\Controllers;

use DB;
use App\Models\UserO;
use App\Models\Transaction;
use App\Models\Payout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\PayoutUpdater;
use App\Helpers\SMS;

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
            $tx = Transaction::find($trans_id);
            $user_id=$tx->user_id;
            Transaction::destroy($trans_id);
            $payoutUpdater=new PayoutUpdater();
            $payoutUpdater->invalidateUserPayouts($user_id,$tx->date_transaction);
            
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

    public function submitedittransactions(Request $request)
    {
    

        $t1 = Transaction::find($request->transaction_id);

        if(($request->image!=null)&&(gettype($request->image)!="string")){
            $image = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $image);
                
            $t1->image=$image;
        }
        
        $t1->amount = number_format($request->amount, 2, '.', '');
        $t1->transaction_type_id = $request->transaction_type;

        $t1->date_transaction = $request->input_date;

        $t1->save();
        $payoutUpdater=new PayoutUpdater();
        $payoutUpdater->invalidateUserPayouts($t1->user_id,$t1->date_transaction);
        
        if($t1->transaction_type_id==7){
            SMS::sendDisperseNotification($t1);
        }else{
            SMS::sendTierChangeMessage($t1);
        }
        return 0;

    }
    public function get_user_former_txs(Request $request){
        $txs=Transaction::where([
            ['transaction_type_id', '=', $request->transaction_type_id],
            ['user_id', '=', $request->user_id],
            ['date_transaction', '=', $request->date_transaction],
            ['amount', '=', $request->amount]])->count();
        return $txs;
    }


    public function sendSms(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://app.aloware.com/api/v1/webhook/sms-gateway/send?api_token=EEF412C6&line_id=1763&to=+19548540848&message=Hello,%20an%20SMS%20from%20Aloware.%20This%20is%20a%20text%20after%20a%20deposit',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
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
            if(($request->image!=null)&&(gettype($request->image)!="string")){
                $image = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $image);
                
                $t1->image=$image;
            }
            
            //dd($request->date);
            
            $t1->date_transaction = $request->date;
            $t1->user_id = $request->id ;
            $t1->amount = str_replace(",", "", $request->amount);
 
            $t1->transaction_type_id = $request->type;
            $this->sendSms();


            $t1->save();
            
                $payoutUpdater=new PayoutUpdater();
                $payoutUpdater->invalidateUserPayouts($t1->user_id,$t1->date_transaction);
            
            if($t1->transaction_type_id==7){
                SMS::sendDisperseNotification($t1);
            }else{
                SMS::sendTierChangeMessage($t1);
            }
            
        //}

    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    }
    public function changeinterestrate(Request $r1){
        //dd($r1);
        $interest = $r1->input('interest'); 
        $verified = $r1->input('verified');
        $user_id = $r1->input('user_id'); 
        
        $u1 = UserO::where([
             ['id', '=', $user_id ],
        ])
        ->get()[0];
  
        $u1->interest_rate = $interest;
        $u1->verified = $verified;
        $u1->save();
        $payoutUpdater=new PayoutUpdater();
        $payoutUpdater->invalidateUserPayouts($user_id,'2020-01-01');
        
        return 1;
      }
    
   
}
