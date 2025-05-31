<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\ReinvestmentTest;

use App\UserO;
use App\Transaction;
use App\TransactionReTest;

use App\OrgListOthers;
use App\OrgList;

use App\Mail\reinvestSuccessMail;
use App\Mail\reinvestErrorMail;

class ReinvestmentRec2 extends Model
{
    public $fullName;
    public $sriDepositDate;
    public $sriDepositAmount;
    public $sriOrganization;
    public $lastInteraction;
    public $email;
    
    public $fOrg;
    
    public $errors = array();
    public $isInvalid = false;
    public $isOrgValid = false;
    
    public $user;
    public $userId;
    public $walletTotal;
    public $remainingAmt;
    
    public $denomination;
    public $maxamount;
    public $isInvalidForRecord = false;
    
    function __construct($fullName,$sriDepositDate,$sriDepositAmount,$sriOrganization,$lastInteraction,$email) {
    
        //THIS CLASS IS TO RECORD THE REINVEST REQUEST
        //BUT ADDITIONAL PRELIMINARY CHECKS ON BELOW MINIMUM, VALID ACCOUNT
        //VALID ORG
    
        $this->fullName = trim($fullName);
        $this->sriDepositDate = trim($sriDepositDate);
        $this->sriDepositAmount = str_replace( ',', '', $sriDepositAmount);
        $this->sriOrganization = trim($sriOrganization);
        $this->lastInteraction = trim($lastInteraction);
        $this->email = trim($email);
        
        $this->fOrg = $this->formatOrg($this->sriOrganization);
        
        //CHECK IF ORG IS VALID
        //QUERY DB for valid. if not do nothing
        $this->isOrgValid = $this->checkOrg($this->fOrg);
        
        
        if ($this->isOrgValid){
            $org = $this->getOrg($this->fOrg);
            $this->denomination = $org->denomination;
            $this->maxamount = $org->maxamount;
            $this->process();
        
        } else {// END IF ORGVALID 
            $this->isInvalidForRecord = true;
            //$this->isInvalid = true;
            //$this->errors[] = "Wrong ORg";
            
        }
     
        if ($this->isInvalid){
            $this->sendErrorMail();
        }
        
    }
    
    public function getOutput(){
        if ($this->isInvalid){
         echo $this->isInvalid . " " . $this->errors[0];
        }else {
            echo " OK ";
        }
    }
    
    public function getOrgTotal(){
        
        $subsum = Transaction::where([
                ['investment_type', '=', $this->fOrg  ],
                ])->whereIn('status',array('Verified'))
                ->sum('amount');
        
        return $subsum;
    }
    
    public function setAmount($amount){
 
            $denomination = $this->denomination;
 
            if($amount % $denomination == 0){
                return $amount;
            } else {
                $temp = intval($amount / $denomination);
                return $temp * $denomination;
            }
 
    }
    
    public function process(){
        
          //CHECK IF BELOW 1 Peso - denomination
            if ($this->sriDepositAmount < $this->denomination){
                $this->isInvalid = true;
                $this->errors[] = "The amount requested is below Php $denomination. Please resubmit your request.";
            }
            
            
            //GET USER DETAILS
            $this->user = $this->getUserDetails($this->email);
            $this->userId = $this->user["id"];
            
            
            
            //SET PROPER DEPOSIT AMOUNT - remove excess from denomination
            
            $this->sriDepositAmount = $this->setAmount($this->sriDepositAmount);
            
            
            
            
            
            
            
            //GET USER WALLET AMT
            $walletTransactions = $this->getUserWalletTransactions($this->userId);
            $this->walletTotal = $this->getWalletTotal($walletTransactions);
            
            //CHECK IF FUNDS ARE ENOUGH
            $this->remainingAmt = $this->walletTotal - $this->sriDepositAmount;
            
            
            
            if ($this->remainingAmt < 0){
                
                $this->isInvalid = true;
                $this->errors[] = "Your Wallet does not have enough funds. Please add funds to your wallet.";
                
                //$this->errors[] = "Not Enough.$this->userId.$this->remainingAmt.$this->walletTotal  ";
                
            } 
            
            
            
            $subsum = $this->getOrgTotal();
           
            if ($subsum >= $this->maxamount){
                    //OVER THE LIMIT
                
                if ($this->maxamount > 0){             
                    $this->isInvalid = true;
                    $this->errors[] = "$this->fOrg joint venture is already full. Kindly choose another SRI organization or in your wallet.";
                }
            } else {
                //UNDER THE LIMIT - CHECK IF IT FITS ()
                
                if ($this->maxamount > 0){       
                    $ti1amount = $this->sriDepositAmount;
                    $ti2amount = number_format($ti1amount, 2, '.', '');
                        
                    $subtotalti = $subsum + $ti2amount;
             
                    if ($subtotalti > $this->maxamount){
                        $this->isInvalid = true;
                        
                        $this->errors[] = "$this->fOrg joint venture is already full. Kindly choose another SRI organization or in our wallet.";
                                
                    }           
                }    
            }
 
            
            
  
  
            if (!$this->isInvalid){
                //VALID CASE.
                //SAVE TO REINVEST TABLE.
                $this->storeReinvest($this->user,$this->sriDepositAmount,$this->sriDepositDate,$this->fOrg);
                
                //Send success mail
                $this->sendSuccessMail();
            }
           
        
    }
    
    
    public function formatOrg($org){
        
        return strtoupper(str_replace(" ","",trim($org)));
        
    }
    
    public function checkOrg($org){
        
        $orgCount = OrgList::where([
            ['code', '=', $org ],
        ])
        ->count();
        
        if ($orgCount > 0){
            return true;
        } else {
            return false;
        }
        
        //return $user[0];
        
    }
    
    public function getOrg($org){
        
        $org = OrgList::where([
            ['code', '=', $org ],
        ])
        ->get();
        
         
        return $org[0];
        
    }
    
    public function getUserDetails($email){
        
        $user = UserO::where([
            ['user_email', '=', $email ],
        ])
        ->orderBy('id', 'desc')->get();
        
        //Only One User
        return $user[0];
        
    }
    
    public function getUserWalletTransactions($user_id){
        
        $walletTransactions = Transaction::where([
            ['user_id', '=', $user_id ],
            ['investment_type', '=', "My Wallet" ],
            ['status', '=', "Verified" ],
        ])
        ->orderBy('date_transaction', 'asc')->get();
        
        //Only One User
        return $walletTransactions;
        
    }
    
    
    public function getWalletTotal($items){
        
        $total = 0;
        
        foreach ($items as $item){
            ($item->transaction_type_id == 3 || $item->transaction_type_id == 8 || $item->transaction_type_id == 10) ? $total -= $item->amount : $total += $item->amount;
        }
        
        $total = number_format($total, 2, '.', '');
        
        return $total;
    }
    
    function saveRecord(){
        
        $re2 = new ReinvestmentTest;
             
        $re2->name = $this->fullName;
        $re2->transaction_date = $this->sriDepositDate;
        $re2->amount = $this->sriDepositAmount;
        $re2->org = $this->sriOrganization;
        $re2->date_submitted = $this->sriDepositDate;
                
            if(trim($this->email)!=NULL){
                $re2->email_count = 1;
            }     
        
        //4 is for sss pagibig not done, 5 is for done
        $re2->status = 3;
        $re2->email = $this->email;
         if (!$this->isInvalidForRecord){
            $re2->save();
        }
    }
    
    public function sendSuccessMail(){
        
     
        
        
           $data = array();
          
            $data["requested_by"] = $this->fullName; 
            $data["email"] = $this->email; 
            $data["date_transaction"] = $this->sriDepositDate; 
            $data["amount"] = $this->setAmount($this->sriDepositAmount); 
            //$data["notes"] = $item->notes; 
            $data["investment_type"] = $this->fOrg; 
            
            $receiver = $this->email;
            //$receiver = "vincentvelasco1232019@gmail.com";
            
            $cc= array();
            
            
            $cc[] = "irmacuello18@gmail.com";
            //$cc[] = "lianne.tabug@sedpi.com"; 
             //$cc[] = "maliannedct@gmail.com"; 
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
            
            
             $cc[] = "vvmanychat2020@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new reinvestSuccessMail($data));
    }
    
    public function sendErrorMail(){
        

           
            
            
            
            
            
           
        
        
        $data = array();
        
        if ($this->fullName==NULL){
            
            //$user = $this->getUserDetails($item->email);
            $data["requested_by"] = "Investor";
        }else{
            
            $data["requested_by"] = $this->fullName; 
        }
        
          
            //$data["requested_by"] = $item->name; 
            $data["email"] = $this->email;  
            $data["date_transaction"] = $this->sriDepositDate; 
            $data["amount"] = $this->sriDepositAmount; 
            $data["notes"] = $this->errors; 
            $data["investment_type"] = $this->fOrg; 
            
            $receiver = $this->email;
            //$receiver = "vincentvelasco1232019@gmail.com";
            
            $cc= array();
            
            
            $cc[] = "irmacuello18@gmail.com";
            //$cc[] = "lianne.tabug@sedpi.com"; 
             //$cc[] = "maliannedct@gmail.com"; 
             $cc[] = "diane.lumbao@sedpi.com";
             $cc[] = "dianelumbao@yahoo.com";
            
            
             $cc[] = "vvmanychat2020@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new reinvestErrorMail($data));
        
    }
    
    
    public function storeReinvest($user,$amount,$date,$org)
    {
                        
         
        
             //Wallet Transaction
                        $transaction2 = new TransactionReTest;
                        $transaction2->last_name = $user->last_name;
                        $transaction2->first_name = $user->first_name;

                        $transaction2->user_id = $user->id;
                        $transaction2->account_id = $user->account_id;
                        $transaction2->email = $user->user_email;
 
                        // 2021-01-21
                        $date2 = $date;
                        
	                    $tdate = date('Y-m-d'); 
	                    $sdate4 = date_create($date2);
	                    $edate4 = date_create($tdate);
                        $diff = date_diff($edate4,$sdate4); 
                        $daysdiff = $diff->format("%R%a");
                      
                        
                        
                        if ( $daysdiff < 0 ){
                            $transaction2->date_transaction = $tdate;
                            
                        } else {
                            $transaction2->date_transaction = $date2;
                        }
                        
                        //$transaction2->date_transaction = $date2;

                        $transaction2->status = "Verified";
  
                        $transaction2->investment_type = "My Wallet";
                       
                        $transaction2->transaction_type_id = 8;
                        $transaction2->remarks = "Reinvested to $org";

                        $transaction2->amount = $amount;
                        $transaction2->running_balance = $amount;
 
              
                        $transaction2->is_posted = 8;
                        $transaction2->requested_by = $user->first_name . " " . $user->last_name;
                        
                        $transaction2->save();
                        
                        
                        //ORG Transaction
                        $transaction1 = new TransactionReTest;
                        $transaction1->last_name = $user->last_name;
                        $transaction1->first_name = $user->first_name;
         
                        $transaction1->user_id = $user->id;
                        $transaction1->account_id = $user->account_id;
                        $transaction1->email = $user->user_email;
                        
                        //from form
                        
                        if ( $daysdiff < 0 ){
                            $transaction1->date_transaction = $tdate;
                        } else {
                            $transaction1->date_transaction = $date2;
                        }
                        
                        //$transaction1->date_transaction = $date2;
                        
                        $transaction1->status = "Verified";
 
 
                       
                        $transaction1->investment_type = $org;
                       
                        $transaction1->transaction_type_id = 9;
                        $transaction1->remarks = "Reinvestment";

 
                        $transaction1->amount =  $amount;
                        $transaction1->running_balance = $amount;
              
                        $transaction1->is_posted = 8;
                        $transaction1->requested_by = $user->first_name . " " . $user->last_name;
                        
                       
                         
                       $transaction1->save();
                       
                
  
    }
}
