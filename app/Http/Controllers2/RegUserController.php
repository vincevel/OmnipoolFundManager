<?php

namespace App\Http\Controllers;

use DB;
use App\UserO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('users.users');
    }

    public function indexError()
    {
        //
        return view('users.userserror');
    }

    public function search(Request $request)
    {
        
        $tests = array();
       
        $validator = Validator::make($request->all(), [
        'email' => 'required|max:50|min:3',
        ]);
        
        
        if ($validator->fails()) {

                return redirect('/usermailerror')
                ->withInput()
                ->withErrors($validator);
        }


  
        $tests = DB::table('users')->where([
            ['user_email', 'like', "%".$request->email."%" ],
        ])->get();

   

        return view('users.users', [
            'tests' => $tests
            
        ]);

   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
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
