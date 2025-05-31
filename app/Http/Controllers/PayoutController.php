<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\RevenueAccount;
use App\Models\Payout;
use App\Monthly;
use Response;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Client\Response as ClientResponse;
use User;
use App\Helpers\PayoutUpdater;

class PayoutController extends Controller
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
    
    
    private function get_payouts($user_id, $view)
    {

        $user = DB::table('users')
            ->where([
                ['id', '=', $user_id],
            ])
            ->first();

        $total_defered = $this->get_transactions_summary(3, $user_id);
        $total_bonus = $this->get_transactions_summary(5, $user_id);
        $total_withdraw = $this->get_transactions_summary(4, $user_id);
        $total_deposited = ($this->get_transactions_summary(1, $user_id) +
            $total_defered + $total_bonus
        )
            - $this->get_transactions_summary(4, $user_id);
        $amount_to_next_tier = PayoutUpdater::getAmountToNextTier($total_deposited);
        $current_tier = PayoutUpdater::getCurrentTier($total_deposited);

        $omnipool = ($total_deposited + $total_defered + $total_bonus) - $total_withdraw;
        $results = PayoutUpdater::getUserTransactions($user_id);
        $payouts = $this->get_monthly_summary($results);
        $total_payouts = 0;

        for ($i = 0; $i < count($payouts); $i++) {
            $total_payouts += $payouts[$i]['total'];
        }
        $total_dispersed=$this->get_transactions_summary(7, $user_id);

        return Response::view($view, [
            'current_year' => date('Y'),
            'total_deposited' => number_format($total_deposited, 2),
            'total_defered' => number_format($total_defered, 2),
            'total_bonus' => number_format($total_bonus, 2),
            'total_withdraw' => number_format($total_withdraw, 2),
            'total_payouts' => number_format($total_payouts, 2),
            'omnipool' => $omnipool,
            'payouts' => $payouts,
            'user' => $user,
            'amount_to_next_tier' => number_format($amount_to_next_tier,2),
            'current_tier' => $current_tier,
            'total_dispersed'=>number_format($total_dispersed, 2)
        ]);
    }
    private function get_monthly_summary($results)
    {
        $months = array('results' => array());
        $curr = "";
        $payouts = array();

        $l = count($results);
        for ($i = 0; $i < $l; $i++) {

            if ($curr != $results[$i]->month) {
                if (count($months['results']) > 0) {
                    array_push($payouts, $months);
                }

                $months = array(
                    'results' => array(),
                    'month' => $results[$i]->month,
                    'total' => 0
                );
            }
            $months['total'] += $results[$i]->amount;

            array_push($months['results'], $results[$i]);
            if ($i == $l - 1) {
                array_push($payouts, $months);
            }
            $curr = $results[$i]->month;
        }
        return $payouts;
    }

    public function monthly_reports($user_id,$view){
        $user = DB::table('users')
            ->where([
                ['id', '=', $user_id],
            ])
            ->first();
        $total_defered = $this->get_transactions_summary(3, $user_id);
        $total_bonus = $this->get_transactions_summary(5, $user_id);
        $total_withdraw = $this->get_transactions_summary(4, $user_id);
        $total_deposited = ($this->get_transactions_summary(1, $user_id) +
            $total_defered + $total_bonus
        )
            - $this->get_transactions_summary(4, $user_id);
        $amount_to_next_tier = PayoutUpdater::getAmountToNextTier($total_deposited);
        $current_tier = PayoutUpdater::getCurrentTier($total_deposited);

        $omnipool = ($total_deposited + $total_defered + $total_bonus) - $total_withdraw;
        $payouts=PayoutUpdater::getUserPayouts($user_id);
        $total_payouts = 0;
        $total_dispersed=0;//$this->get_transactions_summary(7, $user_id);
        for ($i = 0; $i < count($payouts); $i++) {
            $total_payouts += $payouts[$i]->amount;
            $total_dispersed+=($payouts[$i]->isDeferred=='Dispersed'?$payouts[$i]->amount:0);
        }
        
        return Response::view($view, [
            'current_year' => date('Y'),
            'total_deposited' => number_format($total_deposited, 2),
            'total_defered' => number_format($total_defered, 2),
            'total_bonus' => number_format($total_bonus, 2),
            'total_withdraw' => number_format($total_withdraw, 2),
            'total_payouts' => number_format($total_payouts, 2),
            'omnipool' => $omnipool,
            'payouts' => $payouts,
            'user' => $user,
            'amount_to_next_tier' => number_format($amount_to_next_tier,2),
            'current_tier' => $current_tier,
            'total_dispersed'=>number_format($total_dispersed, 2)
        ]);
        
    }

    public function payout_monthly_user()
    {
        return $this->monthly_reports(Auth::user()->id, 'payout_monthly_user');
    }
    public function payout_breakdown_user()
    {
        return $this->get_payouts(Auth::user()->id, 'payout_breakdown_user');
    }
    public function payout_monthly_admin($user_id)
    {
        return $this->monthly_reports($user_id, 'payout_monthly_admin');
    }
    public function payout_breakdown_admin($user_id)
    {
        return $this->get_payouts($user_id, 'payout_breakdown_admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->get_payouts(Auth::user()->id, false);
    }
    public function exportPayouts($user_id, $monthly_payout)
    {

        $txs = array();
        $txs = PayoutUpdater::getUserTransactions($user_id);
        if ($monthly_payout == 1) {
            $txs = $this->get_monthly_summary($txs);
        }
        //dd($txs);
        $len = count($txs);
        $fileName = 'omnipool.csv';
        if ($len != 0) {
            if ($monthly_payout == 1) {
                $fileName = 'monthly_' . $fileName;
            } else {
                $fileName = $txs[0]->from . '_' . $txs[$len - 1]->to . '_' . $fileName;
            }
        }
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $fileName);
        $columns = array('From', 'To', 'Deposit', 'Withdraw', 'Defer', 'Bonus', 'Balance', 'Payout');
        if ($monthly_payout == 1) {
            $columns = array('Month', 'Payout');
        }

        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        if ($monthly_payout == 1) {

            foreach (array_reverse($txs) as $tx) {

                $row['Month']  = $tx['month'];
                $row['Payout']  = $tx['total'] ? '$ ' . number_format($tx['total'], 2) : '';

                fputcsv($file, array(
                    $row['Month'],
                    $row['Payout'],
                ));
            }
        } else {
            foreach (array_reverse($txs) as $tx) {
                $row['From']  = $tx->from;
                $row['To']    = $tx->to;
                $row['Deposit']    = $tx->deposit ? '$ ' . number_format($tx->deposit, 2) : '';
                $row['Withdraw']  = $tx->withdraw ? '$ ' . number_format($tx->withdraw, 2) : '';
                $row['Defer']  = $tx->defer ? '$ ' . number_format($tx->defer, 2) : '';
                $row['Bonus']  = $tx->bonus ? '$ ' . number_format($tx->bonus, 2) : '';
                $row['Balance']  = $tx->running_balance ? '$ ' . number_format($tx->running_balance, 2) : '';
                $row['Payout']  = $tx->amount ? '$ ' . number_format($tx->amount, 2) : '';


                fputcsv($file, array(
                    $row['From'],
                    $row['To'],
                    $row['Deposit'],
                    $row['Withdraw'],
                    $row['Defer'],
                    $row['Bonus'],
                    $row['Balance'],
                    $row['Payout']
                ));
            }
        }

        return fclose($file);
    }
    public function paid_payouts()
    {
        $t=((new Carbon())->copy()->setDay(15)->addMonths(1));
        $next_month=$t->format("m");
        $next_year=$t->format("Y");
        $tn=(new Carbon());
        $month=$tn->format("m");
        $year=$tn->format("Y");
        $payouts = DB::select(DB::raw("

        SELECT u.first_name as first_name, 
        u.interest_rate as interest_rate,
        u.last_name as last_name, 
        p.user_id as user_id, 
        p.id as id, GROUP_CONCAT(p.amount SEPARATOR ',') as amount, 
        GROUP_CONCAT(p.running_balance SEPARATOR ',') as balance, 
        GROUP_CONCAT(p.isDeferred SEPARATOR ',') as isDeffered 
        FROM `payouts` p inner join users u on u.id=p.user_id 
        where ((p.month=:month and p.year=:year) or (p.month=:next_month and p.year=:next_year)) and 
        p.user_id>2 group by p.user_id order by p.user_id, p.year,p.month;"),array(
                'year'=>$year,
                'month'=>$month,
                'next_month'=>$next_month,
                'next_year'=>$next_year
            ));
        $curr_payouts=0;
        $curr_defers=0;
        $next_payouts=0;
        $next_defers=0;
        $total_balance=0;
        for($i=0;$i<count($payouts);$i++){
            $payouts[$i]->curr_payout=explode(",",$payouts[$i]->amount)[0];
            $payouts[$i]->next_month_payout=explode(",",$payouts[$i]->amount)[1];
            $payouts[$i]->isDeferred1=explode(",",$payouts[$i]->isDeffered)[0];
            $payouts[$i]->isDeferred2=explode(",",$payouts[$i]->isDeffered)[1];
            $payouts[$i]->total_balance=explode(",",$payouts[$i]->balance)[1];
            $total_balance+=$payouts[$i]->total_balance;
            if($payouts[$i]->isDeferred2==0){
                $next_payouts+=$payouts[$i]->next_month_payout;
            }else{
                $next_defers+=$payouts[$i]->next_month_payout;
            }
            if($payouts[$i]->isDeferred1==0){
                $curr_payouts+=$payouts[$i]->curr_payout;
            }else{
                $curr_defers+=$payouts[$i]->curr_payout;
            }
        }
        return Response::view('payout_db', [
            'payouts' => $payouts,
            'curr_payouts' => $curr_payouts,
            'curr_defers' => $curr_defers,
            'next_payouts' => $next_payouts,
            'next_defers' => $next_defers,
            'total_balance' => $total_balance
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function user_payouts()
    {

        $payouts = DB::select(DB::raw("SELECT payouts.curr_payout as curr_payout,
		payouts.next_month_payout_total as next_month_payout_total,
		payouts.total_balance as total_balance,
        payouts.isDeferred1 as isDeferred1,
        payouts.isDeferred2 as isDeferred2,
        users.first_name as first_name,
        users.last_name as last_name
        FROM pd_records payouts 
        INNER JOIN users  ON users.id = payouts.user_id where payouts.user_id=:user_id;"), array(
            'user_id' => Auth::user()->id,
        ));
        return Response::view('user_payouts', [
            'payouts' => $payouts
        ]);
    }
    public function get_transactions_summary($transaction_type_id, $user_id)
    {
        return Transaction::where([
            ['transaction_type_id', '=', $transaction_type_id],
            ['user_id', '=', $user_id]
        ])->sum('amount');
    }

    
}