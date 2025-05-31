<?php 
namespace App\Helpers;
use App\Models\Payout;
use App\Models\UserO;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\SMS;

class PayoutUpdater{
    public static function decorateResult($tx, $result)
    {
        $result->deposit = $tx->deposit;
        $result->defer = $tx->defer;
        $result->withdraw = $tx->withdraw;
        $result->bonus = $tx->bonus;
        $result->disperse = $tx->disperse;
        return $result;
    }
    public static function calculatePayout($interest_rate,$from, $amount, $running_balance, $add, $isFullMonth = false)
    {
        $daily_interest = ($interest_rate/100) / 365;
        $result = new class{};
        $result->deposit = null;
        $result->defer = null;
        $result->withdraw = null;
        $result->bonus = null;
        $result->disperse = null;

        $result->from = $from;
        $result->to = $from->copy()->lastOfMonth();
        $result->diff = ($result->to->diffInDays($result->from)) + $add;
        
        $result->amount = $amount * ($isFullMonth ? ($daily_interest * (365 / 12)) : $result->diff * $daily_interest);
    
        $result->running_balance = $running_balance;
        return $result;
    }
    public static function generatePayoutArray($tx_i, $tx_i1, $isMonthStart, $i)
    {
        $results = array();
        $year = $tx_i->year;
        $month_started = false;

        if (
            ($tx_i->year == $tx_i1->year) &&
            ($tx_i->month == $tx_i1->month)
        ) {
            array_push(
                $results,
                self::decorateResult(
                    $tx_i,
                    self::calculatePayout(
                        $tx_i->interest_rate,
                        new Carbon($tx_i->date_transaction),
                        $isMonthStart ? $tx_i->running_balance : $tx_i->amount,
                        $tx_i->running_balance,
                        $isMonthStart ? ($i == 0 ? $i : 1) : 0
                    )
                )
            );
            $isMonthStart = false;
        } else if (
            ($tx_i->month != $tx_i1->month || ($year != $tx_i1->year))
        ) {
            $start = (new Carbon($tx_i->date_transaction));
            $month = $tx_i->month;
            $decorated = false;

            if (!$start->isSameDay($start->copy()->lastOfMonth())) {
                $decorated = true;
                array_push(
                    $results,
                    self::decorateResult($tx_i, self::calculatePayout(
                        $tx_i->interest_rate,
                        $start,
                        $tx_i->amount,
                        $tx_i->running_balance,
                        0
                    ))
                );
            }

            $year = $tx_i->year;
            $add = 0;
            if (($month != $tx_i1->month) || ($year != $tx_i1->year)) {
                $month = $month + 1;
                $add++;
                if ($month > 12) {
                    $month = 1;
                    $year++;
                }
            }

            while (($month != $tx_i1->month) || ($year != $tx_i1->year)) {


                $result = self::calculatePayout(
                    $tx_i->interest_rate,
                    (new Carbon($tx_i->date_transaction))->setDay(15)->addMonths($add)->firstOfMonth(),
                    $tx_i->running_balance,
                    $tx_i->running_balance,
                    1,
                    true
                );
                if ($add == 0) {
                    $decorated = true;
                    self::decorateResult(
                        $tx_i,
                        $result
                    );
                }

                array_push(
                    $results,
                    $result
                );
                $month = $month + 1;
                $add++;
                if ($month > 12) {
                    $month = 1;
                    $year++;
                }
            }

            $month++;
            $add++;
            if ($month > 12) {
                $month = 1;
                $year++;
            }

            $addDay = 0;
            if (($tx_i1->days_in_month == $tx_i1->day) || ($tx_i1->day == 1)) {
                $addDay = 1;
            }
            $month_started = true;
            $result = self::calculatePayout(
                $tx_i->interest_rate,
                (new Carbon($tx_i1->date_transaction))->firstOfMonth(),
                $tx_i->running_balance,
                $tx_i->running_balance,
                $addDay,
                true
            );

            if (!$decorated) {
                self::decorateResult(
                    $tx_i,
                    $result
                );
            }

            array_push(
                $results,
                $result
            );
        }
        return array($results, $month_started);
    }
    private static function updatePayoutRecord($result, $newTransaction,$running_balance)
    {

        $payout = array(
            'date'=> $newTransaction->year.'-'.$newTransaction->month.'-1',
            'month' => $newTransaction->month,
            'year' => $newTransaction->year,
            'amount' => $running_balance!=0?$result->amount:0,
            'isDeferred' => 0,
            'user_id' => $newTransaction->user_id,
            'txHash' => null,
            'running_balance' => $running_balance,
            'isProcessed' => 1
        );

        $match = array(
            'month' => $newTransaction->month,
            'year' => $newTransaction->year,
            'user_id' => $newTransaction->user_id
        );
        
        Payout::UpdateOrCreate($match, $payout);
        
    }
    private static function updateTransaction($newTransaction){
        $lastPayoutUpdates = DB::select(DB::raw("
            SELECT p.running_balance,p.amount,p.month,p.year,u.interest_rate FROM 
            payouts p left join users u on p.user_id=u.id WHERE 
            (p.user_id=:user_id and p.isProcessed=:isProcessed) 
            ORDER BY p.id DESC LIMIT 1;
            "), array(
                'user_id' => $newTransaction->user_id,
                'isProcessed' => 1
            ));
            $running_balance = 0;
            $len = count($lastPayoutUpdates);

            

            if ($len == 1) {
                $running_balance = $lastPayoutUpdates[0]->running_balance;
                if (
                    $lastPayoutUpdates[0]->month == $newTransaction->month &&
                    $lastPayoutUpdates[0]->year == $newTransaction->year
                ) {
                    
                    $running_balance= $newTransaction->amount+$running_balance;
                    $result = self::calculatePayout(
                        $lastPayoutUpdates[0]->interest_rate,
                        new Carbon($newTransaction->date_transaction),
                        $newTransaction->amount,
                        $running_balance,
                        0,
                        false
                    );
                    $result->amount+=$lastPayoutUpdates[0]->amount;
                    self::updatePayoutRecord($result, $newTransaction, $running_balance);
                } else if (
                    (($newTransaction->month != $lastPayoutUpdates[0]->month
                        || ($newTransaction->year != $lastPayoutUpdates[0]->year)))
                ) {
                    $running_balance= $lastPayoutUpdates[0]->running_balance;
                    $start = (new Carbon())->setDay(15)
                        ->setYear($lastPayoutUpdates[0]->year)
                        ->setMonth($lastPayoutUpdates[0]->month)->addMonths(1)->firstOfMonth();

                    $month = $start->month;
                    $year = $start->year;

                    while (($month != $newTransaction->month)||($year != $newTransaction->year)) {
                        $tx = new class{};
                        $tx->month = $month;
                        $tx->year = $year;
                        $tx->amount = 0;
                        $tx->user_id = $newTransaction->user_id;
                        $result = self::calculatePayout(
                            $lastPayoutUpdates[0]->interest_rate,
                            $start,
                            $running_balance,
                            $running_balance,
                            1,
                            true
                        );

                        self::updatePayoutRecord($result, $tx, $running_balance);
                        $month++;
                        if ($month > 12) {
                            $month = 1;
                            $year++;
                        }
                    }
                    
                    
                    $tx_date2 = (new Carbon($newTransaction->date_transaction))->copy()->firstOfMonth();
                    $result2 = self::calculatePayout(
                        $lastPayoutUpdates[0]->interest_rate,
                        $tx_date2,
                        $running_balance,
                        $running_balance,
                        1,
                        true
                    );
                    self::updatePayoutRecord($result2, $newTransaction, $running_balance);

                    $running_balance+=$newTransaction->amount;
                    $tx_date = (new Carbon($newTransaction->date_transaction));
                    
                    $result = self::calculatePayout(
                        $lastPayoutUpdates[0]->interest_rate,
                        $tx_date,
                        $newTransaction->amount,
                        $running_balance,
                        0,
                        false
                    );
                    $result->amount+=$result2->amount;
                    self::updatePayoutRecord($result, $newTransaction, $running_balance);
                    
                    
                }
            } else {
                

                $user=UserO::where('id', $newTransaction->user_id)->first();
                $result = self::calculatePayout(
                    $user->interest_rate,
                    new Carbon($newTransaction->date_transaction),
                    $newTransaction->amount,
                    $running_balance,
                    0,
                    false
                );
                
                self::updatePayoutRecord($result, $newTransaction, $running_balance+$newTransaction->amount,true);
            }
            if($newTransaction->id!=null){
                Transaction::where('id', $newTransaction->id)->update([
                    'isProcessed'=>1
                ]);
                
            }
            
    }
    public static function updatePayoutTable($txs_query,$user_query,$txs_filter=array(),$user_filter=array())
    {

        $newTransactions  = DB::select(DB::raw($txs_query),$txs_filter);
        
        foreach ($newTransactions as $newTransaction) {
            self::updateTransaction($newTransaction);
        }
        $users=DB::select(DB::raw($user_query),$user_filter);
        $t=((new Carbon())->copy()->setDay(15)->addMonths(1));
        $date_transaction=$t->format("Y-m-d");
        $day=$t->format("d");
        $month=$t->format("m");
        $year=$t->format("Y");
        foreach($users as $user){
            $newTransaction=new class{};
            $newTransaction->id=null;
            $newTransaction->date_transaction=$date_transaction;
            $newTransaction->day=$day;
            $newTransaction->month=$month;
            $newTransaction->year=$year;
            $newTransaction->user_id=$user->id;
            $newTransaction->transaction_type_id=0;
            $newTransaction->amount=0;
            self::updateTransaction($newTransaction);
        }
        
    }
    public static function updateDefers($payouts_query,$defer_query,$user_filter=array(),$defer_filter=array(),$updates_query=null){
        
        $users=DB::select(DB::raw($payouts_query),$user_filter);
        $t=((new Carbon())->copy()->setDay(15)->addMonths(1));
        $next_month=$t->format("m");
        $next_year=$t->format("Y");
        $tn=(new Carbon());
        $month=$tn->format("m");
        $year=$tn->format("Y");
        foreach($users as $user){
            
            $match = array(
                'month' => $month,
                'year' => $year,
                'user_id' => $user->id
            );
            $matchNext = array(
                'month' => $next_month,
                'year' => $next_year,
                'user_id' => $user->id
            );
            
            Payout::UpdateOrCreate($match, array(
                'isDeferred'=>$user->isDeferred1
            ));
            Payout::UpdateOrCreate($matchNext, array(
                'isDeferred'=>$user->isDeferred2
            ));
            
            
        }
        $defers=DB::select(DB::raw($defer_query),$defer_filter);

        foreach($defers as $defer){
            $match = array(
                'month' => $defer->month,
                'year' => $defer->year,
                'user_id' => $defer->user_id
            );
            Payout::UpdateOrCreate($match, array(
                'isDeferred'=>1
            ));
        }
        if($updates_query!=null){
            $payouts=DB::select(DB::raw($updates_query),$defer_filter);
            
            foreach($payouts as $payout){
                $endMonth=(new Carbon($payout->year.'-'.($payout->month).'-1'))->copy()->endOfMonth();
                $date=$endMonth->format('Y-m-d');
                $match = array(
                    'date_transaction' => $date,
                    'user_id' => $payout->user_id
                );
                $tx = array(
                    'date_transaction' => $date,
                    'user_id' =>$payout->user_id,
                    'amount' => $payout->amount,
                    'transaction_type_id' => 3,
                    'isProcessed'=>1
                );
                Transaction::UpdateOrCreate($match, $tx);
            }
        }  
    }
    public function invalidateUserPayouts($user_id,$d){
        $d=(new Carbon($d))->firstOfMonth();
        $date=($d)->format('Y-m-d');
        Transaction::where('user_id', $user_id)
            ->where('date_transaction','>=',$date)->
            update([
            'isProcessed'=>0
        ]);
    
        Payout::where('user_id',$user_id)
        ->where('date','>=',$d)
        ->update([
            'isProcessed'=>0
        ]);
        $filter=array('user_id'=>$user_id);
        $currentDate=new Carbon();
        self::updatePayoutTable(
            "
            SELECT 
                date_transaction, day(date_transaction) as day, 
                if(transaction_type_id=4,-amount,if(transaction_type_id=7,0,amount)) as amount,
                transaction_type_id,
                id,
                user_id,
                month(date_transaction) as month, 
                year(date_transaction) as year
                FROM transactions WHERE isProcessed=0 and user_id=:user_id  order by date_transaction;
        ",
        "
        SELECT running_balance,user_id as id FROM payouts where user_id=:user_id;
        ",
        $filter,
        $filter
        );
        self::updateDefers(
            "
            SELECT id,isDeferred1,isDeferred2 FROM users where id=:user_id
            ",
            "
            SELECT user_id,month(date_transaction) as month,year(date_transaction) as year FROM 
            `transactions` where transaction_type_id=3 and user_id=:user_id group by date_transaction,user_id order by user_id;
            ",
            $filter,
            $filter,
            'SELECT * from payouts where isDeferred=1 and user_id=:user_id and month<'.$currentDate->format('m').' and year<='.$currentDate->format('Y')
        );

        
    }
    private static function cmp($a, $b){
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? 1 : -1;
    }
    public static function getUserPayouts($user_id){
        
        $date=(new Carbon())->subMonths(1)->format('Y-m-d');
        $payouts = DB::select(DB::raw("
            SELECT amount,date,concat(monthname(date),' ',year) as month,if(isDeferred=1,'Deferred','Dispersed') as isDeferred from payouts where user_id=:user_id and date<:date order by date desc,month desc;
        "),
        array(
            'user_id'=>$user_id,
            'date'=>$date
        ));

        $dispersed = DB::select(DB::raw("
            SELECT amount,date_transaction as date,concat(monthname(date_transaction),' ',year(date_transaction)) as month,'Dispersed' as isDeferred from transactions where user_id=:user_id and transaction_type_id=7 order by date_transaction desc;
        "),
        array(
            'user_id'=>$user_id
        ));
        $merged=array_merge($payouts,$dispersed);
        
        usort($merged,array("self","cmp"));
        
        

        //dd($merged);
        
        return $merged;
    }
    public static function getUserTransactions($user_id)
    {
        $txs = DB::select(DB::raw("
        SELECT 
        if(t.transaction_type_id=1,t.amount,null) as deposit, 
        if(t.transaction_type_id=3,t.amount,null) as defer, 
        if(t.transaction_type_id=4,-t.amount,null) as withdraw, 
        if(t.transaction_type_id=5,t.amount,null) as bonus,
        if(t.transaction_type_id=7,t.amount,null) as disperse, 
        u.interest_rate,
        SUM(if(t.transaction_type_id=4,-t.amount,if(t.transaction_type_id=7,0,t.amount))) OVER (ORDER BY t.date_transaction) as running_balance, 
        day(last_day(t.date_transaction)) as days_in_month, 
        t.date_transaction, day(t.date_transaction) as day, 
        if(t.transaction_type_id=4,-t.amount,t.amount) as amount, 
        month(t.date_transaction) as month, 
        year(t.date_transaction) as year, 
        t.user_id from transactions t join users u on u.id=t.user_id where t.user_id=:user_id order by t.date_transaction;
                "), array(
            'user_id' => $user_id,
        ));
        $length = count($txs);
        $results = array();
        $prev_month = 0;
        $started = false;
        for ($i = 0; $i < $length; $i++) {
            $start = false;
            if (!$started) {
                if ($i == 0) {
                    $start = true;
                } else if ($i > 0) {
                    $start = ($txs[$i]->month != $prev_month);
                }
            }

            if ($i + 1 < $length) {
                $res = PayoutUpdater::generatePayoutArray($txs[$i], $txs[$i + 1], $start, $i);
                $started = $res[1];
                $results = array_merge($results, $res[0]);
                $prev_month = $txs[$i]->month;
            } else {
                $tx = new class
                {
                };
                $tx->date_transaction = (Carbon::now())->lastOfMonth();
                $tx->year = $tx->date_transaction->format('Y');
                $tx->month = $tx->date_transaction->format('m');
                if($txs[$i]->month!= $tx->month){
                    $tx->date_transaction=$tx->date_transaction->copy()->setDay(15)->subMonths(1)->lastOfMonth();
                    $tx->year = $tx->date_transaction->format('Y');
                    $tx->month = $tx->date_transaction->format('m');
                }
                $tx->day = $tx->date_transaction->format('d');
                $tx->days_in_month = $tx->date_transaction->lastOfMonth();
                $prev_month = $tx->month;
                $res = PayoutUpdater::generatePayoutArray($txs[$i], $tx, $start, $i);
                $started = $res[0];
                $results = array_merge($results, $res[0]);
            }
        }
        $len = count($results);
        for ($i = 0; $i < $len; $i++) {
            $results[$i]->month = $results[$i]->to->format('M Y');
            $results[$i]->from = $results[$i]->from->format('Y-m-d');
            $results[$i]->to = $results[$i]->to->format('Y-m-d');
        }

        return $results;
    }
    public static function getCurrentTier($totalBalance)
    {

        $tier = "Pre Entry";

        if ($totalBalance > 10000) {
            $tier = "Tier " . intval($totalBalance / 10000);
        } else if ($totalBalance > 3000) {

            $tier = "Entry Status";
        }

        return $tier;
    }

    public static function getAmountToNextTier($totalBalance)
    {

        $amountToNextTier = "0";

        if ($totalBalance > 10000) {
            $upperBound = (intval($totalBalance / 10000) + 1) * 10000;
            $amountToNextTier = $upperBound - $totalBalance;
        } else if ($totalBalance > 3000) {
            $amountToNextTier = 10000 - $totalBalance;
        } else {
            $amountToNextTier = 3000 - $totalBalance;
        }

        return $amountToNextTier;
    }
}