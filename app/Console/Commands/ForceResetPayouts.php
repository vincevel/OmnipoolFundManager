<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payout;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ForceResetPayouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payout:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Payout tables and resets all calculations';

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
        
        Transaction::where('isProcessed',1)
            ->update(['isProcessed'=>0]);
        
        DB::table('payouts')->truncate();
        Artisan::call("payout:update");
        Artisan::call("payout:defer:auto");
        return 0;
    }
}
