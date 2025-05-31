<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payout;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\PayoutUpdater;
use App\Helpers\SMS;

class AutoDefer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payout:defer:auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Defers current month Payouts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    private function autoDefer(){
        $endMonth=(new Carbon())->copy()->endOfMonth();
        $date=$endMonth->format('Y-m-d');
        $month=$endMonth->format('m');
        $year=$endMonth->format('Y');
        Transaction::where('transaction_type_id',3)->where('date_transaction','>=',$date)
        ->delete();
        
        $payouts=Payout::where('isDeferred',1)
        ->where('year','=',$year)
        ->where('month','=',$month)
            ->get();
        foreach($payouts as $payout){
            
            $match = array(
                'date_transaction' => $date,
                'user_id' => $payout->user_id
            );
            $tx = array(
                'date_transaction' => $date,
                'user_id' =>$payout->user_id,
                'amount' => $payout->amount,
                'transaction_type_id' => 3
            );
            Transaction::UpdateOrCreate($match, $tx);
            $this->updateUserPayouts($payout->user_id,$date,$endMonth->format('Y'),$endMonth->format('m'));

            
        }
        Artisan::queue("payout:update");
        foreach($payouts as $payout){
            SMS::sendAutoDeferNotification($payout);
        }
        
    }
    private function updateUserPayouts($user_id,$date,$year,$month){
        Transaction::where('user_id', $user_id)
            ->where('date_transaction','>=',$date)->
            update([
            'isProcessed'=>0
        ]);
        Payout::where('user_id',$user_id)
        ->where('month','>=',$month)
        ->where('year','>=',$year)
        ->update([
            'isProcessed'=>0
        ]);
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $t=(new Carbon())->subMonths(1)->firstOfMonth();
        echo($t->format('Y-m-d'));
        $this->autoDefer($t);
    }
}
