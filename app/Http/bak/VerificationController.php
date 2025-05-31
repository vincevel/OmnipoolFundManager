<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\verifyMail;
use App\Mail\pendingMail;

use App\TransactionSync;
use App\Transaction;
use App\TransactionT;
use App\TransactionOrg;
use App\TransactionOrg1;

use App\TransactionOrgRental;
use App\TransactionOrgRental1;

use App\OrgList;

use Excel;
    
use App\TransactionParent;

use App\TransactionToParent;

 use App\TransactionOrg1b;

use App\DividendsToRelease;

use App\TransactionTestingDeletePls;
use App\TransactionToParentDeletePls;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(){
        
         $transactions = TransactionSync::where([

        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->whereNotIn('transaction_type_id',array('3'))
        ->orderBy('id', 'desc')->paginate(25);
        
        //->orderBy('id', 'desc')->get();
        
        return view('verification.listVerificationTransactions', [
            
            'transactions' => $transactions
            
        ]);
        
    }
    
    public function indexdeleteuserentry($id){
        //dd($id);
        
         $transactions = Transaction::where([
             ['id', '=', $id ]
        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->orderBy('id', 'desc')->paginate(50);
        
        //->orderBy('id', 'desc')->get();
        
        foreach ($transactions as $item){
            
            $item->status = "Deleted";
            $item->save();
        }
        
        
        //return view('verification.listVerificationTransactions', [
            
        //    'transactions' => $transactions
            
        //]);
        
    }
    
    public function indexuser($user){
        
         $transactions = Transaction::where([
             ['user_id', '=', $user ]
        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->orderBy('id', 'desc')->paginate(50);
        
        //->orderBy('id', 'desc')->get();
        
        
        
        return view('verification.listVerificationTransactions', [
            
            'transactions' => $transactions
            
        ]);
        
    }
    
    public function indexOrgAski(){
        
        return $this->indexOrg("Alalay Sa Kaunlaran Inc");
    }
    
    public function indexOrgPCCC(){
        
        return $this->indexOrg("Pantukan Chess Club Cooperative");
    }
    
    public function indexOrgUSPD(){
        
        return $this->indexOrg("United Sugar Planters of Digos");
    }
    
    public function indexOrgNSCC(){
        
        return $this->indexOrg("NSCC");
    }
    
    public function indexOrgOoi(){
        
        return $this->indexOrg("Organic Options");
    }
    
    public function indexOrgOoi2(){
        
        return $this->indexOrg("OOI2");
    }
    
    public function indexOrgMarzan(){
        
        return $this->indexOrg2("MARZAN1");
    }
    
    public function indexOrgMadela(){
        
        return $this->indexOrg2("MADDELA1");
    }
    
   

    public function indexOrgYearly3(){
        $dividends_to_release = DB::select('select * from rentals_to_release_marzan');
        //$dividends_to_release = DB::select('select * from dividends_to_release_apr2021');
        //dd($dividends_to_release);
        //return $this->indexOrg2("MADDELA1");
        foreach ($dividends_to_release as $item){
            //for rentals
            //$this->createDividendEntry($item);
            //$this->createWalletEntry($item);
          

            //$this->createDividendEntry2($item);
            //$this->createWalletEntry2($item);
            
            //echo print_r($item) . "<BR><BR>";
            //$this->findDividendEntry($item);
            //$this->findWalletEntry($item);

        }

        echo "Dividends Loaded.";

    }    
    
    public function indexOrg3($org){
        
    }

    public function findDividendEntry($item){
        $entries = Transaction::where([
                    ['date_transaction', '=', '2021-04-18' ],
                    ['user_id', '=', $item->user_id ],
                    ['testing', '=', '124' ],
                    ['transaction_type_id', '=', '6' ],
                    ['status', '=', 'Verified' ],
                    ['investment_type', '=', $item->investment_type ],
                    ['amount', '=', $item->dividend_payout ],
                ])->get();
        // echo "entries" . "<BR>";

        //echo $entries . "<BR>";

        $out = "";
        foreach ($entries as $entry){
        // echo $entries . "<BR>";
            //echo print_r($entry) . "<BR>";
            echo $entry->id . "<BR>";
            $out = $entry->id;
        }
        $this->updateTransactionToParent($out,$item->transaction_id,$item->investment_type,6);
        //echo "<BR>" . "<BR>";
    }

    public function findWalletEntry($item){
        $entries = Transaction::where([
                    ['date_transaction', '=', '2021-04-18' ],
                    ['user_id', '=', $item->user_id ],
                    ['testing', '=', '124' ],
                    ['investment_type', '=', "My Wallet" ],
                    ['transaction_type_id', '=', '7' ],
                    ['amount', '=', $item->dividend_payout ],
                    ['status', '=', 'Verified' ],
                ])->get();
        //if ($entries > 1){
        //echo $entries . "<BR>";

        //}
        $out = "";
          foreach ($entries as $entry){
        // echo $entries . "<BR>";
           //echo print_r($entry) . "<BR>";
           echo $entry->id . "<BR>";
           $out = $entry->id;
        }
        $this->updateTransactionToParent($out,$item->transaction_id,"My Wallet",7);
        echo "<BR>" . "<BR>";
    }

    public function updateTransactionToParent($transaction_id,$parent_id,$investment_type,$transaction_type_id){
         $ttp1 = new TransactionToParent;
         $ttp1->transaction_id = $transaction_id;
         $ttp1->parent_id = $parent_id;
         $ttp1->investment_type = $investment_type;
         //$ttp1->transaction_type_id = 6;
         $ttp1->transaction_type_id = $transaction_type_id;
         $ttp1->flagged = 5;

        //$ttp1->save();  
    }

    public function createDividendEntry($item){
                    
        //$remarks = "Dividend Payout 19 Apr 2021";
        //$remarks = "Rental Dividend Payout Qtr 2 2021";
        $remarks = "Rental Dividend Payout Qtr 3 2021";
        

        $testing_code = "121";
        $testing_code = "143"; //marzanjun
        $testing_code = "161"; //marzanjun
        $testing_code = "162"; //marzanjun
        
        $tdate = '2021-09-30';
        
        //$t1 = new TransactionTestingDeletePls;
        $t1 = new Transaction;
        
        $t1->date_transaction = $tdate;
        $t1->requested_by = $item->requested_by;
        $t1->email = $item->email;
        $t1->amount = $item->dividend_payout;
        $t1->investment_type = $item->investment_type;
        $t1->remarks = $remarks;
        $t1->account_id = $item->account_id;
        $t1->status = "Verified";
        $t1->user_id = $item->user_id;
        $t1->transaction_type_id = 6;
        $t1->running_balance = $item->amount;
        $t1->first_name = $item->first_name;
        $t1->last_name = $item->last_name;
        //$t1->is_posted = $item->is_posted;
        $t1->testing = $testing_code;
        $t1->dividend_payout = $item->dividend_payout;
        
        //for contribution payout_only
        //$t1->contribution_payout = $item->contribution_payout;
        
        $t1->save();
                 
                  
         $ttp1 = new TransactionToParent;
         //$ttp1 = new TransactionToParentDeletePls;
         $ttp1->transaction_id = $t1->id;
         $ttp1->parent_id = $item->transaction_id;
         $ttp1->investment_type = $item->investment_type;
         $ttp1->transaction_type_id = 6;
         $ttp1->flagged = $testing_code;
         $ttp1->save();
                   
    }
    
    public function createWalletEntry($item){
          //WALLET ENTRY
                    //$remarks = "Wallet Dividend and Contribution Payout Apr 18, 2021";

                    $remarks = "Wallet Dividend and Contribution Payout Qtr 1 2021";
                    $remarks = "Wallet Dividend for Rental Payout Qtr 2 2021";
                    $remarks = "Wallet Dividend for Rental Payout Qtr 3 2021";

                    $testing_code = "143"; //marzanjun
                    $testing_code = "161"; //marzanjun
                    $testing_code = "162"; //marzanjun
                    $investment_type = "My Wallet";
                    $transaction_type_id = 7;
                    $tdate = '2021-06-30';
                    $tdate = '2021-09-30';

                    //$w1 = new TransactionTestingDeletePls;
                    $w1 = new Transaction;
                    $w1->testing = $testing_code;
            
                    $w1->last_name = $item->last_name;
                    $w1->first_name = $item->first_name;

                    $w1->user_id = $item->user_id;
                    $w1->account_id = $item->account_id;
                    $w1->email = $item->email;
                        
                    //from form
                    $w1->date_transaction = $tdate;

                    $w1->status = "Verified";
                    //NEED TO DEFINE ORG
                    $w1->investment_type = $investment_type;
                       
                    $w1->transaction_type_id = $transaction_type_id;
                    //$w1->remarks = "Wallet Dividend and Contribution Payout Sep 30";
                    $w1->remarks = $remarks;
                    $w1->amount = $item->dividend_payout;
                    $w1->running_balance = $item->amount;
                    $w1->requested_by = $item->requested_by;
                 
                    
                    $w1->save();


                    $ttp1 = new TransactionToParent;
                    //$ttp1 = new TransactionToParentDeletePls;
                    $ttp1->transaction_id = $w1->id;
                    $ttp1->parent_id = $item->transaction_id;
                    $ttp1->investment_type = $investment_type;
                    $ttp1->transaction_type_id = $transaction_type_id;
                    $ttp1->flagged = $testing_code;
                    $ttp1->save();
    }

    public function indexOrgYearly(){
        $dividends_to_release = DB::select('select * from dividends_to_release_apr2021');
        //dd($dividends_to_release);
        //return $this->indexOrg2("MADDELA1");

        $flag = false;

        if ($flag){
            foreach ($dividends_to_release as $item){
                $this->createDividendEntry2($item);
                $this->createWalletEntry2($item);
                
                //echo print_r($item) . "<BR><BR>";
                //$this->findDividendEntry($item);
                //$this->findWalletEntry($item);

            }
        }

    }    

    public function indexOrgYearlyRentals(){
        //$dividends_to_release = DB::select('select * from dividends_to_release_apr2021');
        $dividends_to_release = DB::select('select * from rentals_to_release_marzan');
        //dd($dividends_to_release);
        //return $this->indexOrg2("MADDELA1");

        $flag = true;

        if ($flag){
            foreach ($dividends_to_release as $item){
                $this->createDividendEntry($item);
                $this->createWalletEntry($item);
                
                //echo print_r($item) . "<BR><BR>";
                //$this->findDividendEntry($item);
                //$this->findWalletEntry($item);

            }
        }

    }    

    public function createDividendEntry2($item){
                    
        //$remarks = "Dividend Payout 19 Apr 2021";
        $remarks = "Dividend and Contribution Payout 31 Dec 2020";
        $remarks = "Dividend and Contribution Payout 30 Jun 2021";
        $remarks = "Dividend and Contribution Payout 30 Jun 2021";
       
        $remarks = "Dividend and Contribution Payout 31 Mar 2021";
        $remarks = "Dividend and Contribution Payout 30 Jun 2021";
        $remarks = "Dividend and Contribution Payout 31 Mar 2021";


        $remarks = "Dividend and Contribution Payout 31 Jul 2021";
        $remarks = "Dividend and Contribution Payout 31 Aug 2021";
        $remarks = "Dividend and Contribution Payout 30 Sep 2021";
        $remarks = "Dividend and Contribution Payout 31 Oct 2021";
        //testing code mii may 122
        //testing code mii jun 130
        //testing code lkbp 131
        //testing code ooi2 132
        //testing code ooi3 133
        //testing code maf1 134
        //testing code aski 135
        //testing code nscc 136
        //testing code pccc 137
        //testing code pccc B 138
        //testing code uspd A 139
        //testing code uspd B 140
        //testing code uspd A2 141
        //testing code uspd B2 142
        //testing code mii jul B2 144
        $testing_code = "130";
        $testing_code = "131";
        $testing_code = "132";
        $testing_code = "133";
        $testing_code = "134";
        $testing_code = "135";
        $testing_code = "136";
        $testing_code = "137";
        $testing_code = "138";
        $testing_code = "139";
        $testing_code = "140";
        $testing_code = "141";
        $testing_code = "142";
        $testing_code = "143";
        $testing_code = "144";
        $testing_code = "145";
        $testing_code = "146";
        $testing_code = "147";
        $testing_code = "148";
        $testing_code = "149";
        $testing_code = "150";
        $testing_code = "151";
        $testing_code = "152";
        $testing_code = "153";
        $testing_code = "154";
        $testing_code = "155";
        $testing_code = "156";
        $testing_code = "157";
        $testing_code = "158";
        $testing_code = "159";
        $testing_code = "160";
        
        $tdate = '2020-12-31';
        $tdate = '2021-06-30';
        $tdate = '2021-06-30';
        $tdate = '2021-03-31';
        $tdate = '2021-06-30';
        $tdate = '2021-03-31';

        $tdate = '2021-07-31';
        $tdate = '2021-08-31';
        $tdate = '2021-09-30';
        $tdate = '2021-10-31';
        //$t1 = new TransactionTestingDeletePls;
        $t1 = new Transaction;
        
        $t1->date_transaction = $tdate;
        $t1->requested_by = $item->requested_by;
        $t1->email = $item->email;
        $t1->amount = $item->dividend_payout + $item->contribution_payout;
        $t1->investment_type = $item->investment_type;
        $t1->remarks = $remarks;
        $t1->account_id = $item->account_id;
        $t1->status = "Verified";
        $t1->user_id = $item->user_id;
        $t1->transaction_type_id = 6;
        $t1->running_balance = $item->amount;
        $t1->first_name = $item->first_name;
        $t1->last_name = $item->last_name;
        //$t1->is_posted = $item->is_posted;
        $t1->testing = $testing_code;
        $t1->dividend_payout = $item->dividend_payout;
        
        //for contribution payout_only
        $t1->contribution_payout = $item->contribution_payout;
        
        $t1->save();
                 
                  
         $ttp1 = new TransactionToParent;
         //$ttp1 = new TransactionToParentDeletePls;
         $ttp1->transaction_id = $t1->id;
         $ttp1->parent_id = $item->transaction_id;
         $ttp1->investment_type = $item->investment_type;
         $ttp1->transaction_type_id = 6;
         $ttp1->flagged = $testing_code;
         $ttp1->save();
                   
    }
    
    public function createWalletEntry2($item){
          //WALLET ENTRY
                    //$remarks = "Wallet Dividend and Contribution Payout Apr 18, 2021";


                    $remarks = "Wallet Dividend and Contribution Payout 31 May, 2021";
                  
                    $remarks = "Wallet Dividend and Contribution Payout 31 Dec, 2020";
                    $remarks = "Wallet Dividend and Contribution Payout 30 Jun, 2021";
                     

                    $remarks = "Wallet Dividend and Contribution Payout 31 Mar, 2021";
                    $remarks = "Wallet Dividend and Contribution Payout 30 Jun, 2021";
                    $remarks = "Wallet Dividend and Contribution Payout 31 Mar, 2021";
                    $remarks = "Wallet Dividend and Contribution Payout 31 Jul, 2021";
                    $remarks = "Wallet Dividend and Contribution Payout 31 Aug, 2021";
                    $remarks = "Wallet Dividend and Contribution Payout 30 Sep, 2021";
                    $remarks = "Wallet Dividend and Contribution Payout 31 Oct, 2021";
                    //testing code mii may 122
                    //testing code mii jun 130
                    //testing code lkbp jun 131
                    //testing code ooi2 jun 132
                    //testing code ooi3 jun 133
                    //testing code maf1 jun 134
                    //testing code aski jun 135
                    //testing code aski jun 136
                    //testing code pccc A jun 137
                    //testing code pccc B jun 138
                    //testing code uspd A jun 139
                    //testing code uspd B jun 140
                    //testing code uspd A jun 141
                    //testing code uspd B jun 142

                    //testing code mii jul B2 144
                    $testing_code = "121";
                    $testing_code = "131";
                    $testing_code = "132";
                    $testing_code = "133";
                    $testing_code = "134";
                    $testing_code = "135";
                    $testing_code = "136";
                    $testing_code = "137";
                    $testing_code = "138";
                    $testing_code = "139";
                    $testing_code = "140";
                    $testing_code = "141";
                    $testing_code = "142";
                    $testing_code = "143";
                    $testing_code = "144";
                    $testing_code = "145";
                    $testing_code = "146";
                    $testing_code = "147";
                    $testing_code = "148";
                    $testing_code = "149";
                    $testing_code = "150";
                    $testing_code = "151";
                    $testing_code = "152";
                    $testing_code = "153";
                    $testing_code = "154";
                    $testing_code = "156";
                    $testing_code = "157";
                    $testing_code = "158";
                    $testing_code = "159";
                    $testing_code = "160";

                    $investment_type = "My Wallet";
                    $transaction_type_id = 7;
                    $tdate = '2021-05-31';
                    
                    $tdate = '2020-12-31';
                    $tdate = '2021-06-30';
                    $tdate = '2021-03-31';
                    $tdate = '2021-06-30';
                    $tdate = '2021-03-31';
                    $tdate = '2021-06-30';
                    $tdate = '2021-03-31';
                    $tdate = '2021-07-31';
                    $tdate = '2021-08-31';
                    $tdate = '2021-09-30';
                    $tdate = '2021-10-31';
                    //$w1 = new TransactionTestingDeletePls;
                    $w1 = new Transaction;
                    $w1->testing = $testing_code;
            
                    $w1->last_name = $item->last_name;
                    $w1->first_name = $item->first_name;

                    $w1->user_id = $item->user_id;
                    $w1->account_id = $item->account_id;
                    $w1->email = $item->email;
                        
                    //from form
                    $w1->date_transaction = $tdate;

                    $w1->status = "Verified";
                    //NEED TO DEFINE ORG
                    $w1->investment_type = $investment_type;
                       
                    $w1->transaction_type_id = $transaction_type_id;
                    //$w1->remarks = "Wallet Dividend and Contribution Payout Sep 30";
                    $w1->remarks = $remarks;
                    $w1->amount = $item->dividend_payout + $item->contribution_payout;
                    $w1->running_balance = $item->amount;
                    $w1->requested_by = $item->requested_by;
                 
                    
                    $w1->save();


                    $ttp1 = new TransactionToParent;
                    //$ttp1 = new TransactionToParentDeletePls;
                    $ttp1->transaction_id = $w1->id;
                    $ttp1->parent_id = $item->transaction_id;
                    $ttp1->investment_type = $investment_type;
                    $ttp1->transaction_type_id = $transaction_type_id;
                    $ttp1->flagged = $testing_code;
                    $ttp1->save();
    }
    
    public function indexOrg2($org){
        TransactionOrgRental1::truncate();
        $transactions = TransactionOrgRental::where([
                    ['investment_type', '=', $org ],
                ])->whereIn('status',array('Verified'))
                ->where('amount','>=',100000)
        ->orderBy('date_transaction','asc')
        ->paginate(1000);
        
        foreach ($transactions as $item){
            $item->getDividends();
        }
        
        
        return view('verification.listOrgVerificationTransactions2', [
             
            'transactions' => $transactions
            
        ]);
    }
    
    public function loader1(){
        
        return "Here";
    }

    public function indexOrg($org){
        //$this->indexOrgA($org);
        return $this->indexOrgAA($org);

    }

    public function indexOrgAA($org){
        //$sql = "select * from transactions_org_joined where investment_type = ? and status = ? order by ? asc, ? asc";
        //$transactions3 = DB::select($sql,[$org,"Verified","user_id","date_transaction"]);


        
         $transactions3 = TransactionOrg1::where([
                    ['investment_type', '=', $org ],
                ])->whereIn('status',array('Verified'))
        //->limit(3)
        ->orderBy('user_id','asc')
        ->orderBy('date_transaction','asc')
        ->get();
        ///->limit(3)
        //

        $parents = array();
        foreach ($transactions3 as $t3item){
            if ($t3item->transaction_type_id == 6){
                $ttp1 = TransactionToParent::find($t3item->orig_id);
                 
                $parents[$t3item->orig_id] =  $ttp1->parent_id;

            }    


        }
        
        
        return view('verification.listOrgVerificationTransactions', [
             
            'transactions' => $transactions3,
            'parents' => $parents,
        ]);

    }
    
    public function indexOrgBB($org){
        

         //   ['investment_type', '=', "Pantukan Chess Club Cooperative" 
        //Clear scratch table 
        TransactionOrg1::truncate();
        
        //get verified org entries from transaction
         $transactions = TransactionOrg::where([
                    ['investment_type', '=', $org ],
                    ['date_transaction', '<', "2021-01-01" ],
                ])->whereIn('status',array('Verified'))
                ->whereIn('transaction_type_id',array('1','9','6'))
        ->orderBy('user_id','asc')
        ->orderBy('date_transaction','asc')
        ->get();
        
        //->orderBy('id', 'desc')->get();
        $maincount = 0;
        $collection1 = array();
        $multiple = false;
        $isMain = false;
        $isSub = false;
       // dd($transactions);
   
        $currentId = 0;
        //$pid = 9999;
        $i=0;
        foreach ($transactions as $item){
            
            if ($i==0){
                $pid = $item->user_id;
                
            }else{
            
                //TRACK IF USER CHANGED
                if ($pid != $item->user_id)
                {
                //$cid = $item->user_id;
                    $pid = $item->user_id;
                    $n0 = new TransactionOrg1;
                    //$n0->id = $item->id;
                    $n0->date_transaction = $item->date_transaction;
                    $n0->user_id = $item->user_id;
                    //$n0->investment_type = $item->investment_type;
                    $n0->save();
                }
            }
            $i++;
            
            $n1 = new TransactionOrg1;
          //  $currentId = $item->id();
            //$n1 = $item;
            //$n1->save;
            $n1->orig_id = $item->id;
            $n1->date_transaction = $item->date_transaction;
            $n1->date_transaction2 = $item->date_transaction;
            $n1->requested_by = $item->requested_by;
            $n1->email = $item->email;
            $n1->amount = $item->amount;
            $n1->investment_type = $item->investment_type;
            $n1->running_balance = $item->running_balance;
            $n1->remarks = $i . " : " . $item->remarks;
             $n1->account_id = $item->account_id;
            
            $n1->status = $item->status;
            $n1->user_id = $item->user_id;
            $n1->transaction_type_id = $item->transaction_type_id;
            $n1->notes = $item->notes;
            $n1->notes_investment_purpose = $item->notes_investment_purpose;
            $n1->file_name = $item->file_name;
            $n1->transaction_id = $item->transaction_id;
            $n1->notes_withdraw_reason = $item->notes_withdraw_reason;
            $n1->bank_name = $item->bank_name;
            $n1->bank_acct_no = $item->bank_acct_no;
            $n1->bank_acct_name = $item->bank_acct_name;
            $n1->bank_branch = $item->bank_branch;
            $n1->bank_account_type = $item->bank_account_type;
            $n1->bankrouting_no = $item->bankrouting_no;
            $n1->govt_id = $item->govt_id;
            $n1->authorization_letter = $item->authorization_letter;
            $n1->first_name = $item->first_name;
            $n1->last_name = $item->last_name;
            $n1->account_name = $item->account_name;
            $n1->is_posted = $item->is_posted;
            $n1->testing = $item->testing;
            $n1->seen = $item->seen;
            $n1->sent_certificate = $item->sent_certificate;
            $n1->dividend_payout = $item->dividend_payout;
            $n1->contribution_payout = $item->contribution_payout;
            $n1->sync_id = $item->sync_id;

            if ($item->transaction_type_id == 1 || $item->transaction_type_id == 9){
                $currentId = $item->id;
                $n1->parent_id = $currentId;
            }else{
                $n1->parent_id = $currentId;
            }


            if ($item->transaction_type_id == 1 || $item->transaction_type_id == 9){
                if ($item->amount < 10000){
                    
                }else{
                     
                     if ($isMain == false ){
                        //COMING FROM SUB
                        $collection1 = array();  
                        //reset array.

                     }

                     $isMain = true;
                     $isSub = false;

                     $maincount++;   
                     //array_push($collection1,$n1->parent_id);
                     $collection1[] = $n1->parent_id;
                     $collection1b = implode("-",$collection1);
                     $n1->transaction_id = $collection1b . " ".   $maincount;
                     $n1->save(); 
                     //MAIN TO MAIN
                     //SUB TO SUB
                     //MAIN TO SUB
                     //SUB TO MAIN
                }
            }else {

                $isMain = false;
                $isSub = true;
                //reset maincount on encounter type 6
                if (count($collection1)>1){
                    $tid = array_shift($collection1);
                }else{
                    $tid = $collection1[0]; 
                }
                $maincount = 0;
                $n1->transaction_id =  $tid . " " . $maincount;
                $n1->parent_id = $tid;
                $n1->save();   
                     

            }


            

            
            if ($item->date_transaction == "2020-12-31" && $item->transaction_type_id == 6){
                
            }else{
            
            }
         
           
            //$item->increaseByTen();
            if ($item->transaction_type_id == 1 || $item->transaction_type_id == 9){
              
                $sri_balance = $item->getSriBalance();
                
                $item->setDividendPayout();
                
                
                //$sri_balance = 1111;
                 $n1 = new TransactionOrg1;
                 //$n1->id = $item->id;
                $n1->date_transaction = $item->date_transaction;
                $n1->date_transaction2 = $item->date_transaction;
            $n1->requested_by = $item->requested_by;
            $n1->email = $item->email;
            $n1->amount = $item->amount;
            $n1->investment_type = $item->investment_type;
            $n1->running_balance = $item->running_balance;
            $n1->remarks = $item->remarks;
              $n1->account_id = $item->account_id;
            
            $n1->status = $item->status;
            $n1->user_id = $item->user_id;
            $n1->transaction_type_id = 6;
            $n1->notes = $item->notes;
            $n1->notes_investment_purpose = $item->notes_investment_purpose;
            $n1->file_name = $item->file_name;
            $n1->transaction_id = $item->transaction_id;
            $n1->notes_withdraw_reason = $item->notes_withdraw_reason;
            $n1->bank_name = $item->bank_name;
            $n1->bank_acct_no = $item->bank_acct_no;
            $n1->bank_acct_name = $item->bank_acct_name;
            $n1->bank_branch = $item->bank_branch;
            $n1->bank_account_type = $item->bank_account_type;
            $n1->bankrouting_no = $item->bankrouting_no;
            $n1->govt_id = $item->govt_id;
            $n1->authorization_letter = $item->authorization_letter;
            $n1->first_name = $item->first_name;
            $n1->last_name = $item->last_name;
            $n1->account_name = $item->account_name;
            $n1->is_posted = $item->is_posted;
            $n1->testing = $item->testing;
            $n1->seen = $item->seen;
            $n1->sent_certificate = $item->sent_certificate;
            $n1->dividend_payout = $item->dividend_payout;
            $n1->contribution_payout = $item->contribution_payout;
            $n1->sync_id = $item->sync_id;
            

            if ($item->sri_balance != 999999.99){
                $n1->sri_balance = $sri_balance;
            }else{
                
                $n1->sri_balance = 999999.99;
            }
            
            if ($item->transaction_type_id == 1 || $item->transaction_type_id == 9){
                $currentId = $item->id;
                $n1->parent_id = $currentId;
            }else{
                $n1->parent_id = $currentId;
            }
            
            
                if ($item->status != "Error"){
                    //NEW DIVIDEND SAVE
                    //                  $n1->save();
                }
                 
                if ($item->status != "Error"){
                    //NEW TRANSACTION AND WALLET ENTRY
                    
                    $n99 = new TransactionParent;
                    //WALLET ENTRY
                    $transaction2 = new TransactionParent;
                }   
                     
                if ($item->status != "Error"){    
                //transaction entry
                   
                    $n99->date_transaction = $item->date_transaction;
                    //$n99->date_transaction2 = $item->date_transaction;
                    $n99->requested_by = $item->requested_by;
                    $n99->email = $item->email;
                    $n99->amount = $item->amount;
                    $n99->investment_type = $item->investment_type;
                    $n99->running_balance = $item->running_balance;
                    $n99->remarks = $item->remarks;
                    $n99->account_id = $item->account_id;
            
                    $n99->status = $item->status;
                    $n99->user_id = $item->user_id;
                    $n99->transaction_type_id = 6;
                    $n99->notes = $item->notes;
                    $n99->notes_investment_purpose = $item->notes_investment_purpose;
                    $n99->file_name = $item->file_name;
                    $n99->transaction_id = $item->transaction_id;
                    $n99->notes_withdraw_reason = $item->notes_withdraw_reason;
                    $n99->bank_name = $item->bank_name;
                    $n99->bank_acct_no = $item->bank_acct_no;
                    $n99->bank_acct_name = $item->bank_acct_name;
                    $n99->bank_branch = $item->bank_branch;
                    $n99->bank_account_type = $item->bank_account_type;
                    $n99->bankrouting_no = $item->bankrouting_no;
                    $n99->govt_id = $item->govt_id;
                    $n99->authorization_letter = $item->authorization_letter;
                    $n99->first_name = $item->first_name;
                    $n99->last_name = $item->last_name;
                    $n99->account_name = $item->account_name;
                    $n99->is_posted = $item->is_posted;
                    
                    $n99->testing = "56";
                    $n99->parent_id = $item->id;
                    
                    //1 TESTING 10 ASKI
                    //$n99->testing = "10";
                    //$n99->testing = "10";
                    
                    //2 TESTING 20 PCCC
                    //$n99->testing = "20";
                    
                     //3 TESTING 30 OOI
                    //$n99->testing = "30";
                    
                     //4 TESTING 40 NSCC
                    //$n99->testing = "40";
                    
                     //5 TESTING 50 OOI 2
                    //$n99->testing = "50";
                    
                     //6 TESTING 60 USPD
                    //$n99->testing = "60";
                    
                    
                   
                    $n99->seen = $item->seen;
                    $n99->sent_certificate = $item->sent_certificate;
                    $n99->dividend_payout = $item->dividend_payout;
                    $n99->contribution_payout = $item->contribution_payout;
                    $n99->sync_id = $item->sync_id;
                    //$n99->sri_balance = $sri_balance;
                    
                   
                }
                
                if ($item->status != "Error"){
                //wallet entry
                    
                    $transaction2->testing = "56";
                    
                    //TESTING 10 ASKI
                    //$transaction2->testing = "10";
                    
                    //TESTING 20 PCCC
                    //$transaction2->testing = "20";
                    
                    //TESTING 30 OOI
                    //$transaction2->testing = "30";
                    
                    //TESTING 40 NSCC
                    //$transaction2->testing = "40";
                    
                    //TESTING 50 OOI 2
                    //$transaction2->testing = "50";
                    
                    //TESTING 60 USPD
                    //$transaction2->testing = "60";
                    
                    
                    $transaction2->last_name = $item->last_name;
                    $transaction2->first_name = $item->first_name;

                    $transaction2->user_id = $item->user_id;
                    $transaction2->account_id = $item->account_id;
                    $transaction2->email = $item->email;
                        
                    //from form
                    $transaction2->date_transaction = $item->date_transaction;

                    $transaction2->status = "Verified";
                    //NEED TO DEFINE ORG
                    $transaction2->investment_type = "My Wallet";
                       
                    $transaction2->transaction_type_id = 7;
                    //$transaction2->remarks = "Wallet Dividend and Contribution Payout Sep 30";
                    $transaction2->remarks = "Wallet Dividend and Contribution Payout Dec 31";

                    $transaction2->amount = $item->amount;
                    $transaction2->running_balance = $item->amount;
 
              
                    $transaction2->is_posted = 8;
                    $transaction2->requested_by = $item->requested_by;
                    $transaction2->parent_id = $item->id;     
                    
                }
                
                if ($item->status != "Error"){
                    
                    if ($item->sri_balance != 999999.99){
                         
                    }else{
                        //special case only
                        //$transaction2->save();
                       // $n99->save();
                    }
                    
                    
                    //if ($i > 63){
                        
                    //ENABLE DISABLE FOR DB WRITE    
                    //$transaction2->save();
                    //$n99->save();
                
                    //}        
                }
                
            }
             //echo    $item->transaction_type_id ;
        }
        
        //dd($transactions2);
          //     ['investment_type', '=', "Alalay Sa Kaunlaran Inc" ],
        $transactions3 = TransactionOrg1::where([
                    ['investment_type', '=', $org ],
                ])->whereIn('status',array('Verified'))
        ->orderBy('user_id','asc')
        ->orderBy('date_transaction','asc')
        ->paginate(2000);
        
        /*
        foreach ($transactions3 as $t3item){
            $ttp1 = TransactionToParent::find($t3item->orig_id);
            $ttp1->parent_id = $t3item->parent_id;
            if ($t3item->transaction_type_id == 6){
                $ttp1->save();
            }    
        }
        */


        return view('verification.listOrgVerificationTransactions', [
             
            'transactions' => $transactions3
            
        ]);
        
    }
    
    public function subIndex(){
        
        $transactions = TransactionSync::where([

        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->orderBy('id', 'desc')->paginate(25);
        
        //->orderBy('id', 'desc')->get();
        
       return view('verification.listSubVerificationTransactions', [
            
            'transactions' => $transactions
            
        ]);
         
    }
    
    public function subSearch(Request $request){
        
        //dd($r->all());
        
        $search = $request->search;

        
        if ($search!=NULL){
         
        $transactions = TransactionSync::where([
            ['email', 'like', "%".$search."%"  ],
        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->orWhere([
            ['first_name', 'like', "%".$search."%" ],
        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
         ->orWhere([
            ['last_name', 'like', "%".$search."%" ],
        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->orderBy('id', 'desc')
        ->paginate(25);
        //->get();
        
           
        
        } else {
            //Empty search
             $transactions = TransactionSync::where([
        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->orderBy('id', 'desc')->paginate(25);
            
        }
        
        if (count($transactions)==0){
                $transactions = TransactionSync::where([
                ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
                 ->orderBy('id', 'desc')->paginate(25);
                //dd($transactions->all());
        }
        
        
        return view('verification.listSubVerificationTransactions', [
            
            'transactions' => $transactions,
            'search'=> true
            
        ]);
        
    }
    
    public function search(Request $request){
        
        //dd($r->all());
        
        $flag = $request->pendingFlag;
        
         
        $search = $request->search;
        
        if ($search!=NULL){
        
             
         
                 $transactions = TransactionSync::where([
                    ['email', 'like', "%".$search."%"  ],
                ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
                ->whereNotIn('transaction_type_id',array('3'))
                ->orWhere([
                    ['first_name', 'like', "%".$search."%" ],
                ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
                ->whereNotIn('transaction_type_id',array('3'))
                 ->orWhere([
                    ['last_name', 'like', "%".$search."%" ],
                ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
                ->whereNotIn('transaction_type_id',array('3'))
                ->orderBy('id', 'desc')
                ->paginate(25);
                //->get();
                
     
        
        } else {
            //Empty search
            

                 $transactions = TransactionSync::where([
        ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
        ->whereNotIn('transaction_type_id',array('3'))
        ->orderBy('id', 'desc')->paginate(25);
                
      
        }
        
        if (count($transactions)==0){
            

                 $transactions = TransactionSync::where([
                ])->whereIn('status',array('PendingAdmin','Deleted','Verified','Pending'))
                ->whereNotIn('transaction_type_id',array('3'))
                 ->orderBy('id', 'desc')->paginate(25);
                //dd($transactions->all());
        
        
        }
        
        
        return view('verification.listVerificationTransactions', [
            
            'transactions' => $transactions,
            'search'=> true
            
        ]);
        
    }
    
     public function filterpending(Request $request){
        
        //dd($r->all());
        
        //$flag = $request->pendingFlag;
        
         
        $search = $request->search;
        
        if ($search!=NULL){
        
             
         
                 $transactions = TransactionSync::where([
                    ['email', 'like', "%".$search."%"  ],
                ])->whereIn('status',array('Pending'))
                ->whereNotIn('transaction_type_id',array('3'))
                ->orWhere([
                    ['first_name', 'like', "%".$search."%" ],
                ])->whereIn('status',array('Pending'))
                ->whereNotIn('transaction_type_id',array('3'))
                 ->orWhere([
                    ['last_name', 'like', "%".$search."%" ],
                ])->whereIn('status',array('Pending'))
                ->whereNotIn('transaction_type_id',array('3'))
                ->orderBy('id', 'desc')
                ->paginate(25);
                //->get();
                
     
        
        } else {
            //Empty search
            

                 $transactions = TransactionSync::where([
        ])->whereIn('status',array('Pending'))
        ->whereNotIn('transaction_type_id',array('3'))
        ->orderBy('id', 'desc')->paginate(25);
                
      
        }
        
        if (count($transactions)==0){
            

                 $transactions = TransactionSync::where([
                ])->whereIn('status',array('Pending'))
                ->whereNotIn('transaction_type_id',array('3'))
                 ->orderBy('id', 'desc')->paginate(25);
                //dd($transactions->all());
        
        
        }
        
        
        return view('verification.listVerificationTransactions', [
            
            'transactions' => $transactions,
            'search'=> true
            
        ]);
        
    }
    
    public function subfilterpending(Request $request){
        
        //dd($r->all());
        
        $search = $request->search;

        
        if ($search!=NULL){
         
        $transactions = TransactionSync::where([
            ['email', 'like', "%".$search."%"  ],
        ])->whereIn('status',array('Pending'))
        ->orWhere([
            ['first_name', 'like', "%".$search."%" ],
        ])->whereIn('status',array('Pending'))
         ->orWhere([
            ['last_name', 'like', "%".$search."%" ],
        ])->whereIn('status',array('Pending'))
        ->orderBy('id', 'desc')
        ->paginate(25);
        //->get();
        
           
        
        } else {
            //Empty search
             $transactions = TransactionSync::where([
        ])->whereIn('status',array('Pending'))
        ->orderBy('id', 'desc')->paginate(25);
            
        }
        
        if (count($transactions)==0){
                $transactions = TransactionSync::where([
                ])->whereIn('status',array('Pending'))
                 ->orderBy('id', 'desc')->paginate(25);
                //dd($transactions->all());
        }
        
        
         return view('verification.listSubVerificationTransactions', [
            
            'transactions' => $transactions,
            'search'=> true
            
        ]);
        
    }
    
    public function clear()
    {
        TransactionSync::truncate();   
        echo "Transaction Sync cleared.";
        
    }
    
    public function transfer2()
    {
        $transactions = TransactionSync::where([])
        ->orderBy('id', 'desc')->get();
        
        //return $transactions[0]->email;
        
        foreach ($transactions as $item)
        {
            
            //return $item;
            $t2 = new Transaction;
            
            
            $t2->requested_by = $item->requested_by;
            $t2->email = $item->email; 
            $t2->date_transaction = $item->date_transaction; 
            $t2->amount = $item->amount; 
            $t2->running_balance = $item->running_balance; 
            $t2->remarks = $item->remarks; 
            $t2->status = $item->status . "BB";
            $t2->investment_type = $item->investment_type; 
            $t2->user_id = $item->user_id;
            $t2->notes = $item->notes;
            $t2->notes_investment_purpose = $item->notes_investment_purpose; 
            $t2->transaction_type_id = $item->transaction_type_id; 
            $t2->transaction_id = $item->transaction_id; 
            $t2->file_name = $item->file_name; 
            $t2->notes_withdraw_reason = $item->notes_withdraw_reason; 
            $t2->bank_name = $item->bank_name;
            $t2->bank_acct_no = $item->bank_acct_no;
            $t2->bank_acct_name = $item->bank_acct_name;
            $t2->bank_branch = $item->bank_branch;
            $t2->bank_account_type = $item->bank_account_type;
            $t2->bankrouting_no = $item->bankrouting_no;
            $t2->govt_id = $item->govt_id;
            $t2->authorization_letter = $item->authorization_letter;
            $t2->first_name = $item->first_name;
            $t2->last_name = $item->last_name;
            $t2->account_name = $item->account_name;
            $t2->account_id = $item->account_id;
            $t2->is_posted = $item->is_posted;
            $t2->testing = $item->testing;
            $t2->seen = $item->seen;
            $t2->dividend_payout = $item->dividend_payout;
            $t2->contribution_payout = $item->contribution_payout;
            $t2->sent_certificate = $item->sent_certificate;
            //return $t2;
            $t2->save();
            //return "Saved transactions sync to transactions";
        }
        
        $count = count($transactions);
        
        echo "Saved transactions sync to transactions - Count $count";
        
        //return $transactions;
        
        //return "index2";
    }
    
    public function transferId(Request $request)
    {
        //return "here at Id";
        //return $request->$id;
        //return dd($request->itemIdN);
        
        $transactions = TransactionSync::where([
                ['id', '=', $request->itemIdN  ],
            ])
        ->orderBy('id', 'desc')->get();
        
        //return $transactions[0]->email;
        
        foreach ($transactions as $item)
        {
            
            //return $item;
            $t2 = new Transaction;
            
            
            $t2->requested_by = $item->requested_by;
            $t2->email = $item->email; 
            $t2->date_transaction = $item->date_transaction; 
            $t2->amount = $item->amount; 
            $t2->running_balance = $item->running_balance; 
            $t2->remarks = $item->remarks; 
            //$t2->status = $item->status . "CC";
            $t2->status = "Pending";
            $t2->investment_type = $item->investment_type; 
            $t2->user_id = $item->user_id;
            $t2->notes = $item->notes;
            $t2->notes_investment_purpose = $item->notes_investment_purpose; 
            $t2->transaction_type_id = $item->transaction_type_id; 
            $t2->transaction_id = $item->transaction_id; 
            $t2->file_name = $item->file_name; 
            $t2->notes_withdraw_reason = $item->notes_withdraw_reason; 
            $t2->bank_name = $item->bank_name;
            $t2->bank_acct_no = $item->bank_acct_no;
            $t2->bank_acct_name = $item->bank_acct_name;
            $t2->bank_branch = $item->bank_branch;
            $t2->bank_account_type = $item->bank_account_type;
            $t2->bankrouting_no = $item->bankrouting_no;
            $t2->govt_id = $item->govt_id;
            $t2->authorization_letter = $item->authorization_letter;
            $t2->first_name = $item->first_name;
            $t2->last_name = $item->last_name;
            $t2->account_name = $item->account_name;
            $t2->account_id = $item->account_id;
            $t2->is_posted = $item->is_posted;
            $t2->testing = $item->testing;
            $t2->seen = $item->seen;
            $t2->dividend_payout = $item->dividend_payout;
            $t2->contribution_payout = $item->contribution_payout;
            $t2->sent_certificate = $item->sent_certificate;
            //return $t2;
            $t2->save();
            //return "Saved transactions sync to transactions";
            $item->status = "Deleted";
            $item->save();
        }
        
        $count = count($transactions);
        
        //echo "Saved transactions sync to transactions - Count $count";
        
        return back();
        //return $transactions;
        
        //return "index2";
    }
    
    
    public function createNewTransaction($item,$id){
            $t2 = new Transaction;
            $t2->requested_by = $item->requested_by;
            $t2->email = $item->email; 
            $t2->date_transaction = $item->date_transaction; 
            $t2->amount = $item->amount; 
            $t2->running_balance = $item->running_balance; 

            $t2->remarks = $item->remarks; 

            $t2->status = $item->status;
            $t2->investment_type = $item->investment_type; 
            $t2->user_id = $item->user_id;
            $t2->notes = $item->notes;
            $t2->notes_investment_purpose = $item->notes_investment_purpose; 
            $t2->transaction_type_id = $item->transaction_type_id; 
            $t2->transaction_id = $item->transaction_id; 
            $t2->file_name = $item->file_name; 
            $t2->notes_withdraw_reason = $item->notes_withdraw_reason; 
            $t2->bank_name = $item->bank_name;
            $t2->bank_acct_no = $item->bank_acct_no;
            $t2->bank_acct_name = $item->bank_acct_name;
            $t2->bank_branch = $item->bank_branch;
            $t2->bank_account_type = $item->bank_account_type;
            $t2->bankrouting_no = $item->bankrouting_no;
            $t2->govt_id = $item->govt_id;
            $t2->authorization_letter = $item->authorization_letter;
            $t2->first_name = $item->first_name;
            $t2->last_name = $item->last_name;
            $t2->account_name = $item->account_name;
            $t2->account_id = $item->account_id;
            $t2->is_posted = $item->is_posted;
            $t2->testing = $item->testing;
            $t2->seen = $item->seen;
            $t2->dividend_payout = $item->dividend_payout;
            $t2->contribution_payout = $item->contribution_payout;
            $t2->sent_certificate = $item->sent_certificate;
            $t2->sync_id = $id;
            //return $t2;
            $t2->save();
            //return "Saved transactions sync to transactions";
    }
    
    public function toggleStatus2($item,$action,$item2 = ""){
        
        //if $action
     
       
    }
    
    
    public function toggleStatus($item,$status1,$status2,$item2 = ""){
        
        if ($item2!=NULL){
            
            if ( $item->status == $status1){
                    $item->status = $status2;
                    $item2->status = $status2;
            }else{
                 $item->status = $status1;
                 $item2->status = $status1;
            }
            
            
             $item->save();
             $item2->save();
            
        }else{
            
            if ( $item->status == $status1){
                    $item->status = $status2;
            }else{
                 $item->status = $status1;
            }
             $item->save();
        }
         
       
    }
    
    public function formatOrg($org){
        
        return strtoupper(str_replace(" ","",trim($org)));
        
    }
    
    
     public function getOrg($org){
        
        $org = OrgList::where([
            ['code', '=', $org ],
        ])
        ->get();
        
         
        return $org[0];
        
    }
    
    public function checkOrg($org){
        
        $org2 = $this->formatOrg($org);
        
        $orgCount = OrgList::where([
            ['code', '=', $org2 ],
        ])
        ->count();
        
        if ($orgCount > 0){
            return true;
        } else {
            return false;
        }
        
        //return $user[0];
    }
    
    public function getOrgTotal($org){
        
        $subsum = Transaction::where([
                ['investment_type', '=', $org  ],
                ])->whereIn('status',array('Verified'))
                ->sum('amount');
        
        return $subsum;
    }
    
    public function verifyId(Request $request)
    {
       
      
        $transactions = TransactionSync::where([
                ['id', '=', $request->verifyId  ],
            ])
        ->orderBy('id', 'desc')->get();
        
        $item = $transactions[0];
        $item->date_transaction = $request->verifyDate;
        $item->amount = $request->verifyAmount;
        
        if ($request->verifyInvestment == "My Wallet"){
            $item->investment_type = "My Wallet";
        }
        
        //$item->investment_type = $request->verifyInvestment;
        $item->remarks = $request->verifyRemarks;
        //find corresponding row at transactions
            $count = Transaction::where([
                ['sync_id', '=', $request->verifyId  ],
            ])
            ->count();
   
        
         if ($count == 0){ 
                $this->toggleStatus($item,"Verified","Verified");
                //$this->toggleStatus($item,"Verified","PendingAdmin");
                $this->createNewTransaction($item,$request->verifyId);
                
            } else {
                //SYNC CASE
                 $t2 = Transaction::where([
                ['sync_id', '=', $request->verifyId  ],
                ])
                ->get();
                
                $this->toggleStatus($item,"Verified","Verified",$t2[0]);
                 
                
                
                
                $t2[0]->date_transaction = $request->verifyDate;
                $t2[0]->amount = $request->verifyAmount;
                
                if ($request->verifyInvestment == "My Wallet"){
                    $t2[0]->investment_type = "My Wallet";
                }
                
                //check if in list
                $isA = $this->checkOrg($request->verifyInvestment);
            
                if ($isA){
                        $fOrg = $this->formatOrg($request->verifyInvestment);
                        $org = $this->getOrg($fOrg);
                        //$this->denomination = $org->denomination;
                        //$this->maxamount = $org->maxamount;
                        $subsum = $this->getOrgTotal($fOrg);
                        $maxamount = $org->maxamount;
                       
                        if ($subsum >= $maxamount){
                        //OVER THE LIMIT
                            if ($maxamount > 0){
                                $item->investment_type = "My Wallet";
                                $t2[0]->investment_type = "My Wallet";
                                $request->verifyRemarks = "$fOrg joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                                $item->remarks = $request->verifyRemarks;
                                $item->notes = $request->verifyRemarks;
                            }
                        } else {
                        //BELOW LIMIT
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                            if ($maxamount > 0){
                                $ti1amount = $request->verifyAmount;
                                $ti2amount = number_format($ti1amount, 2, '.', '');
                            
                                $subtotalti = $subsum + $ti2amount;
                             
                                if ($subtotalti > $maxamount){
                                
                                    //already full case
                                    $item->investment_type = "My Wallet";
                                    $t2[0]->investment_type = "My Wallet";
    
                                    $request->verifyRemarks = "$fOrg joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                                    $item->remarks = $request->verifyRemarks;
                                    $item->notes = $request->verifyRemarks;
                                } //end inner if
                            } //end maxlimit if                        
                        } //end if
                       
                       
                } //end table case
                
                
                
                
                
                if ($request->verifyInvestment == "MAF1"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "MAF1"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1400000.00"){
                        //OVER THE LIMIT
                        $item->investment_type = "My Wallet";
                        $t2[0]->investment_type = "My Wallet";
                        $request->verifyRemarks = "MAF1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                        $item->remarks = $request->verifyRemarks;
                        $item->notes = $request->verifyRemarks;
                    } else {
                        //BELOW LIMIT
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $request->verifyAmount;
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1400000.00){
                            
                            //already full case
                            //$isOrgValid = 0;
                            //$error = true;
                            $item->investment_type = "My Wallet";
                            $t2[0]->investment_type = "My Wallet";
                            //$errorMsg[] = "MAF1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            $request->verifyRemarks = "MAF1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            $item->remarks = $request->verifyRemarks;
                            $item->notes = $request->verifyRemarks;
                        }
                        
                    } //end if
                }
                    //1
                    
                    if ($request->verifyInvestment == "PHCCI"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "PHCCI"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1500000.00"){
                        //OVER THE LIMIT
                        $item->investment_type = "My Wallet";
                        $t2[0]->investment_type = "My Wallet";
                        $request->verifyRemarks = "PHCCI joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                        $item->remarks = $request->verifyRemarks;
                        $item->notes = $request->verifyRemarks;
                    } else {
                        //BELOW LIMIT
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $request->verifyAmount;
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1500000.00){
                            
                            //already full case
                            //$isOrgValid = 0;
                            //$error = true;
                            $item->investment_type = "My Wallet";
                            $t2[0]->investment_type = "My Wallet";
                           
                            $request->verifyRemarks = "PHCCI joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            $item->remarks = $request->verifyRemarks;
                            $item->notes = $request->verifyRemarks;
                        }
                        
                    } //end if
                }    
                    
                    //2
                    
                    if ($request->verifyInvestment == "DCCCO"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "DCCCO"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1000000.00"){
                        //OVER THE LIMIT
                        $item->investment_type = "My Wallet";
                        $t2[0]->investment_type = "My Wallet";
                        $request->verifyRemarks = "DCCCO joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                        $item->remarks = $request->verifyRemarks;
                        $item->notes = $request->verifyRemarks;
                    } else {
                        //BELOW LIMIT
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $request->verifyAmount;
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1000000.00){
                            
                            //already full case
                            //$isOrgValid = 0;
                            //$error = true;
                            $item->investment_type = "My Wallet";
                            $t2[0]->investment_type = "My Wallet";
                           
                            $request->verifyRemarks = "DCCCO joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            $item->remarks = $request->verifyRemarks;
                            $item->notes = $request->verifyRemarks;
                        }
                        
                    } //end if
                }    
                    
                    //3
                    
                    if ($request->verifyInvestment == "SAMULCO"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "SAMULCO"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1500000.00"){
                        //OVER THE LIMIT
                        $item->investment_type = "My Wallet";
                        $t2[0]->investment_type = "My Wallet";
                        $request->verifyRemarks = "SAMULCO joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                        $item->remarks = $request->verifyRemarks;
                        $item->notes = $request->verifyRemarks;
                    } else {
                        //BELOW LIMIT
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $request->verifyAmount;
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1500000.00){
                            
                            //already full case
                            //$isOrgValid = 0;
                            //$error = true;
                            $item->investment_type = "My Wallet";
                            $t2[0]->investment_type = "My Wallet";
                           
                            $request->verifyRemarks = "SAMULCO joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            $item->remarks = $request->verifyRemarks;
                            $item->notes = $request->verifyRemarks;
                        }
                        
                    } //end if
                }
                    
                    //4
                    
                    if ($request->verifyInvestment == "BCC"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "BCC"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1000000.00"){
                        //OVER THE LIMIT
                        $item->investment_type = "My Wallet";
                        $t2[0]->investment_type = "My Wallet";
                        $request->verifyRemarks = "BCC joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                        $item->remarks = $request->verifyRemarks;
                        $item->notes = $request->verifyRemarks;
                    } else {
                        //BELOW LIMIT
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $request->verifyAmount;
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1000000.00){
                            
                            //already full case
                            //$isOrgValid = 0;
                            //$error = true;
                            $item->investment_type = "My Wallet";
                            $t2[0]->investment_type = "My Wallet";
                           
                            $request->verifyRemarks = "BCC joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            $item->remarks = $request->verifyRemarks;
                            $item->notes = $request->verifyRemarks;
                        }
                        
                    } //end if
                }
                
                
                //4 - 1
                    
                    if ($request->verifyInvestment == "MARZAN1"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "MARZAN1"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "14570493.00"){
                        //OVER THE LIMIT
                        $item->investment_type = "My Wallet";
                        $t2[0]->investment_type = "My Wallet";
                        $request->verifyRemarks = "MARZAN1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                        $item->remarks = $request->verifyRemarks;
                        $item->notes = $request->verifyRemarks;
                    } else {
                        //BELOW LIMIT
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $request->verifyAmount;
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 14570493.00){
                            
                            //already full case
                            //$isOrgValid = 0;
                            //$error = true;
                            $item->investment_type = "My Wallet";
                            $t2[0]->investment_type = "My Wallet";
                           
                            $request->verifyRemarks = "MARZAN1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            $item->remarks = $request->verifyRemarks;
                            $item->notes = $request->verifyRemarks;
                        }
                        
                    } //end if
                }
                
                //4 - 12
                    
                if ($request->verifyInvestment == "MARZAN2"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "MARZAN2"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "15800000.00"){
                        //OVER THE LIMIT
                        $item->investment_type = "My Wallet";
                        $t2[0]->investment_type = "My Wallet";
                        $request->verifyRemarks = "MARZAN2 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                        $item->remarks = $request->verifyRemarks;
                        $item->notes = $request->verifyRemarks;
                    } else {
                        //BELOW LIMIT
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $request->verifyAmount;
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 15800000.00){
                            
                            //already full case
                            //$isOrgValid = 0;
                            //$error = true;
                            $item->investment_type = "My Wallet";
                            $t2[0]->investment_type = "My Wallet";
                           
                            $request->verifyRemarks = "MARZAN2 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            $item->remarks = $request->verifyRemarks;
                            $item->notes = $request->verifyRemarks;
                        }
                        
                    } //end if
                }
                
                //4 - 2
                    
                    if ($request->verifyInvestment == "MADDELA1"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "MADDELA1"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "6725460.42"){
                        //OVER THE LIMIT
                        $item->investment_type = "My Wallet";
                        $t2[0]->investment_type = "My Wallet";
                        $request->verifyRemarks = "MADDELA1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                        $item->remarks = $request->verifyRemarks;
                        $item->notes = $request->verifyRemarks;
                    } else {
                        //BELOW LIMIT
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $request->verifyAmount;
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 6725460.42){
                            
                            //already full case
                            //$isOrgValid = 0;
                            //$error = true;
                            $item->investment_type = "My Wallet";
                            $t2[0]->investment_type = "My Wallet";
                           
                            $request->verifyRemarks = "MADDELA1 joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            $item->remarks = $request->verifyRemarks;
                            $item->notes = $request->verifyRemarks;
                        }
                        
                    } //end if
                }
                
                    //5
                    
                    if ($request->verifyInvestment == "NOVADECI"){
                    
                    $subsum = Transaction::where([
                        ['investment_type', '=', "NOVADECI"  ],
                    ])->whereIn('status',array('Verified'))
                    ->sum('amount');
                    
                    if ($subsum >= "1000000.00"){
                        //OVER THE LIMIT
                        $item->investment_type = "My Wallet";
                        $t2[0]->investment_type = "My Wallet";
                        $request->verifyRemarks = "NOVADECI joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                        $item->remarks = $request->verifyRemarks;
                        $item->notes = $request->verifyRemarks;
                    } else {
                        //BELOW LIMIT
                        //UNDER THE LIMIT - CHECK IF IT FITS ()
                        
                        $ti1amount = $request->verifyAmount;
                        $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                        $subtotalti = $subsum + $ti2amount;
                         
                        if ($subtotalti > 1000000.00){
                            
                            //already full case
                            //$isOrgValid = 0;
                            //$error = true;
                            $item->investment_type = "My Wallet";
                            $t2[0]->investment_type = "My Wallet";
                           
                            $request->verifyRemarks = "NOVADECI joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                            $item->remarks = $request->verifyRemarks;
                            $item->notes = $request->verifyRemarks;
                        }
                        
                    } //end if
                
                    
                    //6
                    
                    
                    
                }
                
                
                
                $t2[0]->remarks = $request->verifyRemarks;
                
                $item->save();
                $t2[0]->save();
                //$this->toggleStatus($item,"Verified","PendingAdmin",$t2[0]);
              

            }//end else
        
         //dd($item->status);
     
         if ($item->status == "Verified"){
             
            $data = array();
          
            $data["requested_by"] = $item->requested_by; 
            $data["email"] = $item->email; 
            $data["date_transaction"] = $item->date_transaction; 
            $data["amount"] = $item->amount; 
            $data["notes"] = $item->notes; 
            $data["investment_type"] = $item->investment_type; 
            
            $receiver = $item->email;
            //$receiver = "vincentvelasco1232019@gmail.com";
            
            $cc= array();
            
            
            $cc[] = "irmacuello18@gmail.com";
            $cc[] = "lianne.tabug@sedpi.com"; 
             $cc[] = "maliannedct@gmail.com"; 
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
             $cc[] = "fadviento@gmail.com";
              
             $cc[] = "vvmanychat2020@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new verifyMail($data));
            /*
            $cc[] = "vvmanychat2020@gmail.com";
             $cc[] = "lianne.tabug@sedpi.com"; 
             
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
             $cc[] = "maliannedct@gmail.com";
             $cc[] = "vincentvelascosw2020@gmail.com";
            Mail::to($request->email)->cc($cc)->send(new certMail($data,$request->user_id));
            */
         }
     
         return back()->with('message','Verified Successfully'); 
    }
    
    public function deleteIdFromUser(Request $request)
    {
        //dd($request->all());
        //dd($request->id);
        $t1 = Transaction::find($request->deleteid);
        //dd($t1);
        if ($t1!=NULL){
        $t1->status = "Deleted";
        $t1->save();
        
            if (!$request->deletesyncid==0){
                $t2 = TransactionSync::findOrFail($request->deletesyncid);
                $t2->status = "Deleted";
                $t2->save();
            }
        }

        return back()->with('message','Deleted Successfully'); 
        
    }
    
    public function deleteId(Request $request)
    {
        
      //  dd($request->all());
        $transactions = TransactionSync::where([
                ['id', '=', $request->deleteId  ],
            ])
        ->orderBy('id', 'desc')->get();
        
      
         $item = $transactions[0];
          $item->remarks = $request->deleteRemarks;
        //find corresponding row at transactions
            $count = Transaction::where([
                ['sync_id', '=', $request->deleteId  ],
            ])
            ->count();
        
        
          if ($count == 0){ 
                $this->toggleStatus($item,"Deleted","Deleted");
                //$this->toggleStatus($item,"Deleted","PendingAdmin");
                $this->createNewTransaction($item,$request->deleteId);
                
            } else {
                //SYNC CASE
                 $t2 = Transaction::where([
                ['sync_id', '=', $request->deleteId  ],
                ])
                ->get();
                
                $this->toggleStatus($item,"Deleted","Deleted",$t2[0]);
                //$this->toggleStatus($item,"Deleted","PendingAdmin",$t2[0]);
                $item->save();
                $t2[0]->remarks = $request->deleteRemarks;
                $t2[0]->save();
            }//end else
        
        
     
        return back()->with('message','Deleted Successfully'); 
 
    }
    
    
    public function pendingId(Request $request)
    {
      //dd($request->all());
      
       $transactions = TransactionSync::where([
                ['id', '=', $request->pendingId  ],
            ])
        ->orderBy('id', 'desc')->get();
        
           $item = $transactions[0];
           $item->remarks = $request->pendingRemarks;
           
            //find corresponding row at transactions
            $count = Transaction::where([
                ['sync_id', '=', $request->pendingId  ],
            ])
            ->count();
          
            if ($count == 0){ 
                $this->toggleStatus($item,"Pending","Pending");
                $this->createNewTransaction($item,$request->pendingId);
                
            } else {
                //SYNC CASE
                 $t2 = Transaction::where([
                ['sync_id', '=', $request->pendingId  ],
                ])
                ->get();
                
                $this->toggleStatus($item,"Pending","Pending",$t2[0]);
                $item->save();
                $t2[0]->remarks = $request->pendingRemarks;
                $t2[0]->save();

            }//end else
            
            if ($item->status == "Pending"){
             
            $data = array();
          
            $data["requested_by"] = $item->requested_by; 
            $data["email"] = $item->email; 
            if ($item->remarks == "No Transaction Date"){
                
               $data["date_transaction"] = "----/--/--";  
            }else{
                $data["date_transaction"] = $item->date_transaction; 
            }
            $data["amount"] = $item->amount; 
            $data["notes"] = $item->notes; 
            $data["remarks"] = $item->remarks; 
            $data["investment_type"] = $item->investment_type; 
            
            //$receiver = "vincentvelasco1232019@gmail.com";
            $receiver = $item->email;
            
            $cc= array();
           
           
            $cc[] = "irmacuello18@gmail.com";
            $cc[] = "lianne.tabug@sedpi.com"; 
             $cc[] = "maliannedct@gmail.com"; 
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
             $cc[] = "fadviento@gmail.com"; 
             $cc[] = "vvmanychat2020@gmail.com";
           
            
            Mail::to($receiver)->cc($cc)->send(new pendingMail($data));
            /*
            $cc[] = "vvmanychat2020@gmail.com";
             $cc[] = "lianne.tabug@sedpi.com"; 
             $cc[] = "irmacuello18@gmail.com";
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
             $cc[] = "maliannedct@gmail.com";
             $cc[] = "vincentvelascosw2020@gmail.com";
            Mail::to($request->email)->cc($cc)->send(new certMail($data,$request->user_id));
            */
         }
     
        return back()->with('message','Set to Pending Successfully');  
    }
    
   
    
   
    
   
   
}
