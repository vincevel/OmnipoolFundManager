<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\UserParent;
use App\SQueue;
use App\ParentTest;
use App\TransactionOrg1;

use App\TransactionToParent;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth',['except' => ['testSend','testLoad','testRe']]);
    } 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ///home/vincerap7132/sri/app/Http/Middleware/VerifyCsrfToken.php for csrf exemption
        
        //return view('home');
    }

     public function findParentTest4(){
        //return "back";

        $arr[] = ["name" =>'Abigail',"state" =>'CA'];
        $arr[] = ["name" =>'Abigail2',"state" =>'CA'];
        $arr[] = ["name" =>'Abigail3',"state" =>'CA'];
  
        return response()->json($arr);
    }

    public function findParentTest5(Request $r1){

        //UPDATE CASE
         if ($r1->input("flag") == 0){
             $parent_id = $r1->input("parent_id");
             $orig_id = $r1->input("orig_id");

             $t1 = TransactionToParent::find($orig_id);
             $t1->parent_id = $parent_id;
             $t1->save();

         }

         //INSERT CASE
         if ($r1->input("flag") == 1){
             $parent_id = $r1->input("parent_id");
             $orig_id = $r1->input("orig_id");

             $t1 = TransactionToParent::find($orig_id);
             //$t1->parent_id = $parent_id;
             $t1b = $t1->replicate();
             $t1b->parent_id = $parent_id;

             $t1b->save();

         }

         //FLAG CASE
         if ($r1->input("flag") == 2){
             
             $orig_id = $r1->input("orig_id");

             $t1 = TransactionToParent::find($orig_id);
             //$t1->parent_id = $parent_id;
            $t1->flagged = !$t1->flagged;
            $t1->save();
             /*
            if ($t1->flagged == 0){
             $t1->flagged = 1;
              $t1->save();
            }else {
                $t1->flagged = 0;
             $t1->save();
            }
            */

         }

        return response()->json();
    }

    public function findParentTest5b(Request $r1){
        //return "back";
         //$response = $r1->input("parent_ids");
         //$response = "Post Response";


        $org = "Alalay Sa Kaunlaran Inc";

        $transactions3 = TransactionOrg1::where([
                    ['investment_type', '=', $org ],
                ])->whereIn('status',array('Verified'))
        ->orderBy('user_id','asc')
        ->orderBy('date_transaction','asc')
        ->get();
       // ->limit(3)
        
        /*
        return view('verification.listOrgVerificationTransactions', [
             
            'transactions' => $transactions3
            
        ]);
  */
        //foreach ($transactions3 as $item){}
        //$output 

        //$transactions3 = "testing";
        return response()->json($transactions3);
    }


    public function findParentTest(){
        //echo "Here at Find Parent";

        $orgs = array('Alalay Sa Kaunlaran Inc','NSCC','OOI2','Organic Options','Pantukan Chess Club Cooperative','United Sugar Planters of Digos');

        $quarters = array("2020-03-31","2020-06-30","2020-09-30","2020-12-31");
        $sq = new SQueue;

        $u1 = new UserParent;
        
        $uUsers = $u1->usersWithDividends();
        //$user = $uUsers;
        //$user = 1689;

        //$org = "Organic Options";
        foreach ($orgs as $org){
            foreach ($uUsers as $user){
                foreach ($quarters as $quarter){

          
            //var_dump($u1->getDeposits($user,"2020-03-31"));
            //$user = $user->id;
            $deposits = $u1->getDeposits($user,$quarter,$org);

            if (count($deposits) > 0){
            echo $deposits[0]->first_name . " ". $deposits[0]->last_name . " - " . $org . " <BR>";    
            echo (count($deposits)) . " Count <BR>";
            ///var_dump($deposits);
            }
           


            foreach ($deposits as $deposit){
                //var_dump($deposit);
               
                echo $deposit->date_transaction . " ";
                echo $deposit->amount . " ";
                echo $deposit->transaction_type_id . " ";
                echo $deposit->id . " " . $quarter. "_DID";

                echo "<BR>";
                //var_dump($deposit);
                $sq->push($deposit);
                

                //var_dump($sq->getArr());
            }   

            
            $contributions = $u1->getContributions($user,$quarter,$org);

            foreach ($contributions as $contribution){

                    echo $contribution->date_transaction . " ";
                    echo $contribution->amount . " ";
                    echo $contribution->transaction_type_id . " ";
                    echo $contribution->id . " " . $quarter. "_CID";
                    echo "<BR>";    
                    
                    $p1 = ParentTest::find($contribution->id);
                    echo $p1->id . " " . $quarter. "_PID";
                    echo "<BR>";

                    $item = $sq->pop();
                    //var_dump($item->id);    


                    if ($item != NULL){
                        $p1->parent_id = $item->id;
                    }else{
                      //  $p1->parent_id = 9999991;
                    }


                    //$p1->save();
                    
            }

            $sq->clear();
                } //foreach quarters
            //var_dump($sq);
            /*
            ///////////////////////////////////////////////////
            $deposits = $u1->getDeposits($user,"2020-06-30",$org);

            ///var_dump($deposits);
            
            foreach ($deposits as $deposit){
                //var_dump($deposit);
                echo $deposit->date_transaction . " ";
                echo $deposit->amount . " ";
                echo $deposit->transaction_type_id . " ";
                echo $deposit->id . " D2_ID";

                echo "<BR>";
                $sq->push($deposit);
            }   

            $contributions = $u1->getContributions($user,"2020-06-30",$org);

            foreach ($contributions as $contribution){

                    echo $contribution->date_transaction . " ";
                    echo $contribution->amount . " ";
                    echo $contribution->transaction_type_id . " ";
                    echo $contribution->id . " C2_ID";
                    echo "<BR>"; 

                     $p1 = ParentTest::find($contribution->id);
                     echo $p1->id . " P2_ID";
                    echo "<BR>";
                     $item = $sq->pop();
                     
                    if ($item != NULL){
                        $p1->parent_id = $item->id;
                    }else{
                       // $p1->parent_id = 9999992;
                    }

                    //$p1->save();
            }

            $sq->clear();

            ///////////////////////////////////////////////////
             $deposits = $u1->getDeposits($user,"2020-09-30",$org);

            ///var_dump($deposits);
            
            foreach ($deposits as $deposit){
                //var_dump($deposit);
                echo $deposit->date_transaction . " ";
                echo $deposit->amount . " ";
                echo $deposit->transaction_type_id . " ";
                echo $deposit->id . " D3_ID";

                echo "<BR>";    

                $sq->push($deposit);
            }   

            $contributions = $u1->getContributions($user,"2020-09-30",$org);

            foreach ($contributions as $contribution){

                    echo $contribution->date_transaction . " ";
                    echo $contribution->amount . " ";
                    echo $contribution->transaction_type_id . " ";
                    echo $contribution->id . " C3_ID";
                    echo "<BR>"; 
                     $p1 = ParentTest::find($contribution->id);
                     echo $p1->id . " P3_ID";
                    echo "<BR>";
                     $item = $sq->pop();
                     
                    if ($item != NULL){
                        $p1->parent_id = $item->id;
                    }else{
                       // $p1->parent_id = 9999993;
                    }

                   // $p1->save();
            }

            $sq->clear();


            ///////////////////////////////////////////////////
             $deposits = $u1->getDeposits($user,"2020-12-31",$org);

            ///var_dump($deposits);
            
            foreach ($deposits as $deposit){
                //var_dump($deposit);
                 echo $deposit->date_transaction . " ";
                echo $deposit->amount . " ";
                echo $deposit->transaction_type_id . " ";
                echo $deposit->id . " D4_ID";

                echo "<BR>";
                $sq->push($deposit);
            }   

            $contributions = $u1->getContributions($user,"2020-12-31",$org);

            foreach ($contributions as $contribution){
                    echo $contribution->date_transaction . " ";
                    echo $contribution->amount . " ";
                    echo $contribution->transaction_type_id . " ";
                    echo $contribution->id . " C4_ID";
                    echo "<BR>"; 

                     $p1 = ParentTest::find($contribution->id);
                     echo $p1->id . " P4_ID";
                    echo "<BR>";
                     $item = $sq->pop();
                     
                    if ($item != NULL){
                        $p1->parent_id = $item->id;
                    }else{
                        //$p1->parent_id = 9999994;
                    }

                   // $p1->save();
            }

            $sq->clear();
            */
            } //end foreach users
        } //end foreach orgs
        //dd($sq);
        //dd($deposits);

    } // end func
    
   
}
