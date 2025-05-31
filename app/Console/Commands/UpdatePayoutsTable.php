<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\PayoutUpdater;

class UpdatePayoutsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payout:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates payouts table after new payouts are added';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        PayoutUpdater::updatePayoutTable(
            "
            SELECT 
                date_transaction, day(date_transaction) as day, 
                if(transaction_type_id=4,-amount,if(transaction_type_id=7,0,amount)) as amount,
                id,
                transaction_type_id,
                user_id,
                month(date_transaction) as month, 
                year(date_transaction) as year
                FROM transactions WHERE isProcessed=0 order by date_transaction;
        ",
        "
        SELECT running_balance,user_id as id FROM payouts
        "

        );
        PayoutUpdater::updateDefers(
            "
            SELECT id,isDeferred1,isDeferred2 FROM users
            ",
            "
            SELECT user_id,month(date_transaction) as month,year(date_transaction) as year FROM `transactions` where transaction_type_id=3 group by date_transaction,user_id order by user_id;
            "
        );
        $this->info('Done.');
        return 0;
    }
}
