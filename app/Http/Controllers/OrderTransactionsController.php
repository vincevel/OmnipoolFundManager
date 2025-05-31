<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\UserO;
use Carbon\Carbon;
use Auth;
use DB;
use Response;

class OrderTransactionsController extends Controller
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
        $transactions = Transaction::orderBy('date_transaction','asc')->orderBy('id','asc')->get();
        $grand_total = Transaction::sum('amount');



        foreach ($transactions as $transaction){
            $user = UserO::find($transaction->user_id);
            $transaction->lname = $user->last_name;
        }

        //get transaction data for specific user
        $current_year = date('Y');
        if (Auth::user()->admin == 1){
            return Response::view("ordertransactions.show", [
                'current_year' => $current_year,
                'transactions' => $transactions,
                'grand_total' => $grand_total,
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
            //return $this->process_transactions(Auth::user()->id,'home');
        }
    }

    
}
