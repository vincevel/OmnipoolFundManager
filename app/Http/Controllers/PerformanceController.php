<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Auth;
use DB;
use Response;

class PerformanceController extends Controller
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
        $current_year = date('Y');
        if (Auth::user()->admin == 1){
            return Response::view("performance.show", [
                'current_year' => $current_year,
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
            //return $this->process_transactions(Auth::user()->id,'home');
        }else{
            return Response::view("performance.usershow", [
                'current_year' => $current_year,
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
        }
    }



    
}
