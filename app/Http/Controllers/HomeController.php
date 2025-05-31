<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use DB;
use Response;
use App\Helpers\PayoutUpdater;
use App\Models\UserO;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //get transaction data for specific user
        
        if (Auth::user()->admin == 1){
            return $this->showAdminSection(Auth::user()->id,'admin');
            //return $this->process_transactions(Auth::user()->id,'home');
        }else{
            return $this->process_transactions(Auth::user()->id,'home');
        }
    }

    public function autoDefer(){
        $pdrs = DB::table('pd_records')->get();
        //var_dump($pdrs);

        foreach ($pdrs as $pdr){

            if ($pdr->isDeferred1 == 1){
                $t1 = new Transaction;
                $t1->date_transaction = "2022-06-30";
                $t1->testing = 1;
                $t1->transaction_type_id = 3;
                $t1->user_id = $pdr->user_id;
                $t1->amount = $pdr->curr_payout;
                //var_dump($t1);
 
                //$t1->save();
            }

        }
    }

    public function showAdminSection($user_id,$view = "admin")
    {
        $t=((new Carbon())->copy()->setDay(15)->addMonths(1));
        $next_month=$t->format("m");
        $next_year=$t->format("Y");
        $tn=(new Carbon());
        $month=$tn->format("m");
        $year=$tn->format("Y");
        $users = DB::select(DB::raw("
        SELECT u.first_name as first_name, u.last_name as last_name,u.verified as verified,
        u.email as email, u.bitcoin_address as bitcoin_address,u.interest_rate as interest_rate,
         p.user_id as user_id, u.id as id, GROUP_CONCAT(p.amount SEPARATOR ',') as amount, 
         GROUP_CONCAT(p.running_balance SEPARATOR ',') as balance, 
         GROUP_CONCAT(p.isDeferred SEPARATOR ',') as isDeffered FROM `payouts` p inner join users u on u.id=p.user_id 
         where ((p.month=:month and p.year=:year) or (p.month=:next_month and p.year=:next_year)) and p.user_id>2 group 
         by p.user_id order by p.user_id, p.year,p.month;"),array(
                'year'=>$year,
                'month'=>$month,
                'next_month'=>$next_month,
                'next_year'=>$next_year
            ));
           
        $grand_total_balance = 0;
        $grand_total_to_next_tier = 0;

	    $grand_total_defers = 0;
	    $grand_total_payouts = 0;
        for($i=0;$i<count($users);$i++){
            $users[$i]->curr_payout=explode(",",$users[$i]->amount)[0];
            $users[$i]->next_month_payout=explode(",",$users[$i]->amount)[1];
            $users[$i]->isDeferred1=explode(",",$users[$i]->isDeffered)[0];
            $users[$i]->isDeferred2=explode(",",$users[$i]->isDeffered)[1];
            $users[$i]->total_balance=explode(",",$users[$i]->balance)[1];
            $grand_total_balance+=$users[$i]->total_balance;
            $users[$i]->amount_to_next_tier=PayoutUpdater::getAmountToNextTier($users[$i]->total_balance);
            $grand_total_to_next_tier+=($users[$i]->total_balance>0?$users[$i]->amount_to_next_tier:0);
            
            if($users[$i]->isDeferred1==0){
                $grand_total_payouts+=$users[$i]->curr_payout;
            }else{
                $grand_total_defers+=$users[$i]->curr_payout;
            }
        }
        
        return view($view, [
           'users' => $users,
           'grand_total_balance' => $grand_total_balance,
           'grand_total_to_next_tier' => $grand_total_to_next_tier,
           'grand_total_defers' => $grand_total_defers,
           'grand_total_payouts' => $grand_total_payouts,
        ]);

    }  
   


    public function get_user_transactions($user_id)
    {
        return $this->process_transactions($user_id,'admindetails');
    }

    public function getTotalDeposits($user_id){

        return Transaction::where([
            ['user_id', '=', $user_id],
            ['transaction_type_id', '=', 1],
        ])
        ->sum('amount');

    }

    public function getTotalDefers($user_id){

        return Transaction::where([
            ['user_id', '=', $user_id],
            ['transaction_type_id', '=', 3],
        ])
        ->sum('amount');

    }

    public function getTotalBonuses($user_id){

        return Transaction::where([
            ['user_id', '=', $user_id],
            ['transaction_type_id', '=', 5],
        ])
        ->sum('amount');

    }

    public function getTotalWithdraws($user_id){

        return Transaction::where([
            ['user_id', '=', $user_id],
            ['transaction_type_id', '=', 4],
        ])
        ->sum('amount');
    }

    public function process_transactions($user_id,$view)
    {
        $t=((new Carbon())->copy()->setDay(15)->addMonths(1));
        
        $next_month=$t->format("m");
        $next_year=$t->format("Y");
        $tn=(new Carbon());
        
        $month=$tn->format("m");
        $year=$tn->format("Y");
        $user=UserO::where('id',$user_id)->first();
        
        $payouts=DB::select(DB::raw("
            SELECT isDeferred,amount,user_id,month,year
            FROM `payouts`
            where ((month=:month and year=:year) or (month=:next_month and year=:next_year)) and 
            user_id=:user_id order by year,month;
        "),array(
            'month'=>$month,
            'year'=>$year,
            'next_month'=>$next_month,
            'next_year'=>$next_year,
            'user_id'=>$user_id
        ));
        
        $transactions=DB::select(DB::raw("SELECT 
        SUM(if(transaction_type_id=4,-amount,if(transaction_type_id=7,0,amount))) OVER (ORDER BY date_transaction) as running_balance, 
        date_transaction,transaction_type_id,id,image, 
        amount, 
        user_id from transactions where user_id=:user_id order by date_transaction desc;"),array('user_id'=>$user_id));
          

        //1 GET ALL SUMS
        $total_deposits =  $this->getTotalDeposits($user_id);

        $total_defers =  $this->getTotalDefers($user_id);

        $total_bonus =  $this->getTotalBonuses($user_id);

        $total_withdraws =  $this->getTotalWithdraws($user_id);
        $total_withdraws = $total_withdraws * -1;

        //3 sum of total balance
        $total_balance  = $total_deposits + $total_defers + $total_bonus + $total_withdraws;
        //get current Tier
        $tier = PayoutUpdater::getCurrentTier($total_balance);
        //get amount to next Tier
        $amountToNextTier = PayoutUpdater::getAmountToNextTier($total_balance);

        $allPayouts=PayoutUpdater::getUserPayouts($user_id);
        $total_payouts = 0;
        for ($i = 0; $i < count($allPayouts); $i++) {
            $total_payouts += $allPayouts[$i]->amount;
        }



        return view($view, [
            'transactions' => $transactions,
            'total_deposits' => $total_deposits,
            'total_defers' => $total_defers,
            'total_balance' => $total_balance,
            'total_payouts' => $total_payouts,
            'tier' => $tier,
            'amount_to_next_tier' => $amountToNextTier,
            'payouts'=>$payouts,
            'user'=>$user
        ]);
 
    }


    
}
