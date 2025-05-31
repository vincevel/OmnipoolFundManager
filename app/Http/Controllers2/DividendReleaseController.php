<?php

namespace App\Http\Controllers;

use DB;
use App\UserO;
use App\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DividendReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function releasedividends()
    {

        $id = 16215;    
        
        $user = UserO::where([
                ['id', '=', $id ],
        ])->get();
        
        //get SRI choices
        $investmentTypes = Transaction::distinct()->pluck('investment_type');

        return view('releasedividends.releasedividends', [
            'user' => $user[0],
            'investmentTypes' => $investmentTypes
        ]);
        
        //return "At List $id";
    } 

     
}
