<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\UserO;
use App\Models\UserN;
use App\Helpers\PayoutUpdater;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\Payout;
use App\Helpers\SMS;

use Illuminate\Support\Facades\DB;

class ProfileUpdateController extends Controller
{
 

    public function __construct(){
        //initialize
        

    }
 
 

    public function updatedivp(Request $r1){
       $tid = $r1->input('tid'); 
       $amount = $r1->input('amount'); 
       //return json_encode($input);
       //return $r1->input('firstName');

       
       $t1 = Transaction::where([
            ['id', '=', $tid ],
       ])
       ->get()[0];

       

       $t1->dividend_payout = $amount;

       $t1->save();
       
       //return json_encode($user1b);
       return 1;
    }

    public function update_baddress(Request $r1){

       //dd($r1);
       $baddress = $r1->input('baddress'); 
       $uid = $r1->input('uid'); 
        
       $u1 = UserO::where([
            ['id', '=', $uid ],
       ])
       ->get()[0];

       //dd($baddress);
       $old=$u1->bitcoin_address;
       $u1->bitcoin_address = $baddress;
       // $u1->bitcoin_address = "124213";
       //dd($u1);
       
       $u1->save();
       SMS::bitcoinAddressChanged(ucwords($u1->last_name).', '.ucwords($u1->first_name),$old?$old:'<None>',$u1->bitcoin_address?$u1->bitcoin_address:'<None>');
       
       //return json_encode($user1b);
       return 1;
    }

    public function changeinterestrate(Request $r1){
      //dd($r1);
      $interest = $r1->input('interest'); 
      $user_id = $r1->input('user_id'); 
       
      $u1 = UserO::where([
           ['id', '=', $user_id ],
      ])
      ->get()[0];

      $u1->interest_rate = $interest;
      $u1->save();
      $payoutUpdater=new PayoutUpdater();
      $payoutUpdater->invalidateUserPayouts($user_id,'2020-01-01');
      
      return 1;
    }

    public function update_deferred1(Request $r1){

       //dd($r1);
      //$t=((new Carbon())->copy()->setDay(15)->addMonths(1));
      $t=(new Carbon());
      $month=$t->format('m');
      $year=$t->format('Y');
      $isdeferred = $r1->input('isdeferred'); 
      $user_id = $r1->input('uid'); 
      
       $match = array(
         'month' => $month,
         'year' => $year,
         'user_id' => $user_id
      );
     
     Payout::UpdateOrCreate($match, array(
         'isDeferred'=>$isdeferred
     ));
     UserO::where('id', $user_id)->update([
      'isDeferred1'=>$isdeferred
     ]);
     
     $user=UserO::where([
      ['id', '=', $user_id ],
      ])
      ->get()[0];
      SMS::deferStatusChanged(ucwords($user->last_name).', '.ucwords($user->first_name),$t->format('F'),$isdeferred);
   return 1;
    }

    public function update_deferred2(Request $r1){
      $t=(new Carbon())->copy()->setDay(15)->addMonths(1);
      $month=$t->format('m');
      $year=$t->format('Y');
      $isdeferred = $r1->input('isdeferred'); 
      $user_id = $r1->input('uid'); 
      
       $match = array(
         'month' => $month,
         'year' => $year,
         'user_id' => $user_id
      );
     
     Payout::UpdateOrCreate($match, array(
         'isDeferred'=>$isdeferred
     ));
     UserO::where('id', $user_id)->update([
      'isDeferred2'=>$isdeferred
     ]);
     $user=UserO::where([
      ['id', '=', $user_id ],
      ])
      ->get()[0];
      SMS::deferStatusChanged(ucwords($user->last_name).', '.ucwords($user->first_name),$t->format('F'),$isdeferred);
       return 1;
    }
    public function formSubmit(Request $request){
      $imageName=time().'.'.$request->image->getClientOriginalExtension();
      $request->image->move(public_path('images'),$imageName);
      return 1;

  }


  
}
