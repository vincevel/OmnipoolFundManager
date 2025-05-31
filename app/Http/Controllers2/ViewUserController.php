<?php

namespace App\Http\Controllers;

use DB;
use App\UserO;
use App\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ViewUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('viewusers.viewusers');
    }

    public function indexError()
    {
        //
        return view('viewusers.viewuserserror');
    }

    public function search(Request $request)
    {
        
        $tests = array();
       
        $validator = Validator::make($request->all(), [
        'email' => 'required|max:50|min:3',
        ]);
        
        
        if ($validator->fails()) {

                return redirect('/viewusererror')
                ->withInput()
                ->withErrors($validator);
        }


  
        $tests = DB::table('users')
        ->where([
            ['user_email', 'like', "%".$request->email."%" ],
        ])
        ->orWhere([
            ['first_name', 'like', "%".$request->email."%" ],
        ])
        ->orWhere([
            ['last_name', 'like', "%".$request->email."%" ],
        ])
        ->orderBy('last_name', 'asc')
        ->get();

   

        return view('viewusers.viewusers', [
            'tests' => $tests
            
        ]);

   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function list($id)
    {
        
         $user = UserO::where([
                ['id', '=', $id ],
        ])->get();
        
          // return $user;
        
        //return redirect()->route('backend3', ['jumpToPage' => 22,'id' => $id]);
 
           
           
        return view('demo5.backend2', [
            'user' => $user[0]
            
        ]);

        //return "At List $id";
    }
     
     
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //return $request;
        
           $user1 = UserO::where([
                ['id', '=', $request->id ],
            ])->get();
        
             //return $user;
        $user = $user1[0];
        
        //all from user query
         $transaction1 = new Transaction;
         
         $transaction1->last_name = $user->last_name;
         $transaction1->first_name = $user->first_name;
          
       
          $transaction1->user_id = $user->id;
                        $transaction1->account_id = $user->account_id;
                        $transaction1->email = $user->user_email;
                        
                        //from form
                        $transaction1->date_transaction = $request->date;

                        $transaction1->status = "Verified";
                        //NEED TO DEFINE ORG
                        $transaction1->investment_type = "SEDPI";
                
                       
                       
                        $transaction1->transaction_type_id = 2;
                        $transaction1->remarks = "Dividend for 2019 Dec";
 
                        $transaction1->amount = $request->amount;
                        $transaction1->running_balance = $request->amount;
 
              
                        $transaction1->is_posted = 7;
                        $transaction1->requested_by = $user->first_name . " " . $user->last_name;
                        
                        $transaction1->save();


        //return "At Store";
 
        //return $transaction1;
        return back()->with('message','Dividend Added');   
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(UserO $user)
    {
        //return $user->id;
        
        return view('viewusers.viewusers', [
            'user' => $user
            
        ]);
        
        //return 123;

        //return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
