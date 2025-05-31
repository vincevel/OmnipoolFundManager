<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\UserO;

class InvestmentController extends Controller
{
    //
    //http://sri/test/?jumpToPage=3

	public function work()
    {
    	//return redirect()->route('test',['jumpToPage' => 3]);
    	//return view('demo5.demo');
    }


    public function index()
    {
    	//return view( URL::route('test',['id'=>'2','test_id'=>'3']) );
        $user = UserO::find(Auth::User()->id);
     
        return view('demo5.demo', [
            
            'user1' => $user
            
        ]);
    }


    public function main()
    {
        //return view( URL::route('test',['id'=>'2','test_id'=>'3']) );
        //return view('demo5.user3');
        //return view('demo5.user2');
        //return view('demo5.user2');
        //  return view('demo5.user2');
       // return view('demo5.user2');
        //return redirect()->route('main2', ['jumpToPage' => '10']);

    }

   
   
    public function main4(){
        $users = UserO::all();
        
        foreach ($users as $user){
            
            //echo $user->id . "<BR>";
            $userId = $user->id;
            $email = $user->user_email;
            $first_name = $user->first_name;
            $last_name = $user->last_name;
            $fname =  strtoupper(substr($user->first_name, 0, 1));
            $lname = strtoupper(substr($user->last_name, 0, 1));
            $userIdNum = sprintf('%08d', $userId);
        
            $date = $user->created_at->format('ymd');
        
            $userId = $fname . $lname  ."-". $date ."-".$userIdNum;
           // echo "$first_name,$last_name,$email,$userId<BR>";
        }
    } 

    public function main2()
    {
        
        //$user = UserO::find(Auth::User()->id);
        //$user = "1";
        $userId = Auth::id();
        
        
        $user = UserO::find($userId);
        
        //if ($user!= NULL){
        
            $fname =  strtoupper(substr($user->first_name, 0, 1));
            $lname = strtoupper(substr($user->last_name, 0, 1));
            $userIdNum = sprintf('%08d', $userId);
        
            $date = $user->created_at->format('ymd');
        
            $userId = $fname . $lname  ."-". $date ."-".$userIdNum;
            return view('demo5.user2', [
            
                'user1' => $userId
            
            ]);
        
        /*
        } else {
            
            return redirect()->route('main2');
        }*/
        
        //return view('demo5.user2');

        /*
        $url = url()->full();
        $urlParts = parse_url($url);
        $query = explode("=",$urlParts['query']);
        $page = (int)$query[1];
        //var_dump($page);
        //var_dump(url()->full());
        //$url=explode("=")
        //echo $page;
        //var_dump($page);
        
        if ($page==10){
        //return view( URL::route('test',['id'=>'2','test_id'=>'3']) );
           
           // return redirect()->route('main3', ['jumpToPage' => $page]);
            //echo "Here";

            return view('demo5.user2');
        } else {
            return view('demo5.error');

        }
        
        */
    }

    
}
