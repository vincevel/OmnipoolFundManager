<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\verifyMail;
use App\Mail\pendingMail;
use App\Mail\errorMail;

use App\Mail\verifyWMail;
use App\Mail\pendingWMail;
use App\Mail\errorWMail;


use App\TransactionSync;
use App\Transaction;
use App\UserO;
use App\Reinvestment;
use App\ManyChatRecord;

use App\ManyChatSSSRemit;
use App\ManyChatPagIbigRemit;
use App\ManyChatWithdraw;

use App\ManyChatWithdrawManual;

use Storage;

class ManyChatControllerSelfService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(){
        
        
        
    }
    
    
    public function informDeposit(Request $r1){
    
    
    }
    
    public function setOrg($org){
        
        $inputs = array();
        
    	switch (strtoupper(trim($org))){

				case "ASKI":	
					$inputs["investment_type"] = "Alalay Sa Kaunlaran Inc";
					break;
				
				case "OOI 2":
					$inputs["investment_type"] = "OOI2";
					break;
				
				case "OOI2":
					$inputs["investment_type"] = "OOI2";
					break;
					
				case "Organic Options 2":
					$inputs["investment_type"] = "OOI2";
					break;
				
				case "Organic Options2":
					$inputs["investment_type"] = "OOI2";
					break;
					
					
				case "OOI":
					$inputs["investment_type"] = "Organic Options";
					break;
				case "OOI Inc":
					$inputs["investment_type"] = "Organic Options";
					break;
				case "PCCC":
					$inputs["investment_type"] = "Pantukan Chess Club Cooperative";
					break;
				case "PMPC":
					$inputs["investment_type"] = "PMPC";
					break;	
				case "USPD":
					$inputs["investment_type"] = "United Sugar Planters of Digos";
					break;	
				case "TC":
					$inputs["investment_type"] = "Tagum Cooperative";
					break;	
				case "TC1":
					$inputs["investment_type"] = "Tagum Cooperative";
					break;	
				case "TAGUM COOP":
					$inputs["investment_type"] = "Tagum Cooperative";
					break;
				case "TAGUM COOPERATIVE":
					$inputs["investment_type"] = "Tagum Cooperative";
					break;
				
					
				case "LKBP":	
					$inputs["investment_type"] = "LKBP";
					break;	
					
				case "NIC":	
					$inputs["investment_type"] = "NICO";
					break;	
				
				case "NICO":	
					$inputs["investment_type"] = "NICO";
					break;
				case "BCS":	
					$inputs["investment_type"] = "BCS";
					break;
				
				case "NSCC":	
					$inputs["investment_type"] = "NSCC";
					break;
				case "SHSC":	
					$inputs["investment_type"] = "SHSC";
					break;
			
				case "WALLET":	
					$inputs["investment_type"] = "My Wallet";
					break;	
				case "DEPOSIT TO WALLET":	
					$inputs["investment_type"] = "My Wallet";
					break;
				case "MARZAN 1":	
					$inputs["investment_type"] = "MARZAN1";
					break;
					
				//MARZAN2
					
				case "MARZAN2":	
					$inputs["investment_type"] = "MARZAN2";
					break;
				
				case "MARZAN 2":	
					$inputs["investment_type"] = "MARZAN2";
					break;
				
				case "MADDELA 1":	
					$inputs["investment_type"] = "MADDELA1";
					break;
					
				case "MAF 1":	
					$inputs["investment_type"] = "MAF1";
					break;
				
				case "MAF1":	
					$inputs["investment_type"] = "MAF1";
					break;
					
				
				case "MADDELA1":	
					$inputs["investment_type"] = "MADDELA1";
					break;
				
				
				case "Wallet":	
			    	$inputs["investment_type"] = "My Wallet";
					break;
					
				case "SSS":	
			    	$inputs["investment_type"] = "SSS";
					break;
					
				case "PAGIBIG":	
			    	$inputs["investment_type"] = "Pag-Ibig";
					break;
			 
			    case "SEDPI":
			        $inputs["investment_type"] = "SEDPI";
					break;
					
				case "PHCCI":
			        $inputs["investment_type"] = "PHCCI";
					break;
					
				case "DCCCO":
			        $inputs["investment_type"] = "DCCCO";
					break;
			    
			    case "SAMULCO":
			        $inputs["investment_type"] = "SAMULCO";
					break;
					
				case "BCC":
			        $inputs["investment_type"] = "BCC";
					break;
					
				case "NOVADECI":
			        $inputs["investment_type"] = "NOVADECI";
					break;
					
				default:
					$inputs["investment_type"] = "My Wallet";
					break;

			}
			
			return $inputs["investment_type"];
    }
    
     public function setOrg2($org){
        
        $isValid = true;
    
        
    	switch (strtoupper(trim($org))){
				
				
				case "OOI2":
	 
					$isValid = true;
					break;
					
				case "OOI 2":
	 
					$isValid = true;
					break;
				
				
				case "PCCC":
                    $isValid = true;
					break;
					


				case "USPD":
		            $isValid = false;
					break;	
				case "NSCC":	
                    $isValid = false;
					break;
				case "SHSC":	
                    $isValid = true;
					break;	
				case "ASKI":	
			        $isValid = true;
					break;
				case "LKBP":	
			        $isValid = true;
					break;	
				case "NICO":	
			        $isValid = true;
					break;	
				case "NIC":	
			        $isValid = true;
					break;	
				case "BCS":	
			        $isValid = true;
					break;	
				case "PMPC":	
			        $isValid = true;
					break;	
					
					
				case "OOI":
	 
					$isValid = false;
					break;
				case "OOI Inc":
					$isValid = false;
					break;
				
				case "TC":
					$isValid = false;
					break;	
				case "TC1":
					$isValid = false;
					break;	
				case "TAGUM COOP":
					$isValid = false;
					break;
				
				case "MAF 1":
					$isValid = true;
					break;
					
				case "MAF 1":
					$isValid = true;
					break;
					
				case "PHCCI":
					$isValid = true;
					break;
				
				case "DCCCO":
					$isValid = true;
					break;	
					
				case "SAMULCO":
					$isValid = true;
					break;
				
				case "BCC":
					$isValid = true;
					break;
				
				case "NOVADECI":
					$isValid = true;
					break;
					
				case "TAGUM COOPERATIVE":
					$isValid = false;
					break;
					
			    
			
				case "WALLET":	
					$isValid = false;
					break;	
				case "DEPOSIT TO WALLET":	
					$isValid = false;
					break;
				case "MARZAN 1":	
					$isValid = false;
					break;
				
				//MARZAN2
				
				case "MARZAN2":	
					$isValid = false;
					break;
				
				case "MARZAN 2":	
					$isValid = false;
					break;
				
				
				case "Wallet":	
			    	$isValid = false;
					break;
				
			 
					
				default:
					$isValid = false;
					break;

			}
			
			return $isValid;
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
    
    public function remitsss(Request $r1){
        
        $item = new ManyChatSSSRemit;
        $item->full_name = $r1->input("data.fullName");
        $item->last_name = $r1->input("data.lastName");
        $item->first_name = $r1->input("data.firstName");
        $item->pagibig_deposit_date = $r1->input("data.sriDepositDate");
        $item->pagibig_deposit_amount = $r1->input("data.sriDepositAmount");
        $item->pagibig_deposit_picture = $r1->input("data.sriDepositPicture");
        $item->pagibig_deposit_reference_number = $r1->input("data.pagibig_deposit_reference_number");
        $item->pagibig_payment_type = $r1->input("data.pagibig_payment_type");
        $item->pagibig_account_number = $r1->input("data.pagibig_account_number");
        $item->last_interaction = $r1->input("data.lastInteraction");
        $item->email = $r1->input("data.email");
        $item->phone = $r1->input("data.phone");
        $item->save();
        
        //save input to dumping table
        
        //pass $r1 to testResponse
        
        $count = "remitsss";
        $this->testResponse($r1);
        return response()->json($count);
    }
    
    public function withdraw(Request $r1){
        $item = new ManyChatWithdraw;
        
        $item->last_name = $r1->input("data.last_name");
        $item->first_name = $r1->input("data.first_name");
        $item->middle_name = $r1->input("data.middle_name");
        $item->nick_name = $r1->input("data.nick_name");
        $item->email = $r1->input("data.email");
        $item->withdrawal_date = $r1->input("data.withdrawal_date");
        $item->withdrawal_amount = $r1->input("data.withdrawal_amount");
        $item->bank_account_name = $r1->input("data.bank_account_name");
        $item->bank_name = $r1->input("data.bank_name");
        $item->withdraw_reason = $r1->input("data.withdraw_reason");
        $item->bank_branch = $r1->input("data.bank_branch");
        $item->bank_account_type = $r1->input("data.bank_account_type");
        $item->bank_account_number = $r1->input("data.bank_account_number");
        $item->bank_routing_number = $r1->input("data.bank_routing_number");
        $item->save();
        $this->testResponseWithdraw($r1);
        $count = "withdraw";
         
        return response()->json($count);
    }
    
    public function withdrawManual(){
         
        $items = ManyChatWithdrawManual::all();
        
        /*
        foreach ($items as $item){
            $this->testResponseWithdrawManual($item);
        }
        */
         
        //$this->testResponseWithdrawManual($r1);
        $count = "withdraw";
         
        return response()->json($count);
    }
    
    public function remitpagibig(Request $r1){
        
        $item = new ManyChatPagIbigRemit;
        $item->full_name = $r1->input("data.fullName");
        $item->last_name = $r1->input("data.lastName");
        $item->first_name = $r1->input("data.firstName");
        $item->pagibig_deposit_date = $r1->input("data.sriDepositDate");
        $item->pagibig_deposit_amount = $r1->input("data.sriDepositAmount");
        $item->pagibig_deposit_picture = $r1->input("data.sriDepositPicture");
        $item->pagibig_deposit_reference_number = $r1->input("data.pagibig_deposit_reference_number");
        $item->pagibig_payment_type = $r1->input("data.pagibig_payment_type");
        $item->pagibig_account_number = $r1->input("data.pagibig_account_number");
        $item->last_interaction = $r1->input("data.lastInteraction");
        $item->email = $r1->input("data.email");
        $item->phone = $r1->input("data.phone");
        $item->save();
        
        $count = "remitpagibig";
        $this->testResponse($r1);
        return response()->json($count);
    }
    
    public function calculateSplitToWallet($amount, $denomination){
        $output = array();
        
        if ($amount % $denomination != 0){
                $output["extraWalletAmount"] = $amount % $denomination;
                $tempVal1 = intval($amount / $denomination);
                $output["baseAmount"] = $tempVal1 * $denomination;
                //$specialCase = true;
            return $output;
        }else{
            return 0;
        }
        
    }
    
    public function testResponse(Request $r1){
        
        $message = "Success";
        
        $name = $r1->input("data.fullName");
        $fullName = $r1->input("data.fullName");
        $sriDepositDate = $r1->input("data.sriDepositDate");
        $sriDepositAmount = $r1->input("data.sriDepositAmount");
        
        if (trim($sriDepositAmount)==NULL){
            
            $sriDepositAmount = 1;
            
        }
        
        $sriDepositAmount = str_replace( ',', '', $sriDepositAmount );
        
        $sriDepositPicture = $r1->input("data.sriDepositPicture");
        
      
        
        $sriOrganization = $this->setOrg($r1->input("data.sriOrganization"));
        $isValidOrg = $this->setOrg2($r1->input("data.sriOrganization"));
        //add query for denomination
        
        if ($sriOrganization == "Pag-Ibig"){
         
            //$sriOrganization = $r1->input("data.sriDepositPicture")
            $pay_type = trim($r1->input("data.pagibig_payment_type"));
            
            switch ($pay_type) {
                
                case "P1": 
                    $sriOrganization = "P1";
                    break;    
                    
                default:
                    $sriOrganization = "MP2";
                    break;                    
                
            }
            
            
            
        }
        
        $specialCase = false;
       
       
        if ($isValidOrg){
            /*
            
                $result = $this->calculateSplitToWallet($sriDepositAmount, $denomination);
                if ($result != 0){
                    $extraWalletAmount = $result["extraWalletAmount"];
                    $baseAmount = $result["baseAmount"];
                    $specialCase = true;
                }
            
            */
            $n = $sriDepositAmount;
            $whole = floor($sriDepositAmount);      // 1
            $fraction = $n - $whole; // .25
            if ($fraction == 0){
                //NORMAL CASE - modulo WITHOUT decimal
                if ($sriDepositAmount % 10000.00 != 0){
                    $extraWalletAmount = $sriDepositAmount % 10000;
                    $tempVal1 = intval($sriDepositAmount / 10000);
                    $baseAmount = $tempVal1 * 10000;
                    $specialCase = true;
                }
            }else{
                //WITH FRACTION - modulo WITH decimal
                
                if ( $whole == 10000 ){
                    
                    $extraWalletAmount = 0;
                    $extraWalletAmount = $extraWalletAmount + $fraction;
                    $tempVal1 = intval($sriDepositAmount / 10000);
                    $baseAmount = $tempVal1 * 10000;
                    $specialCase = true;
                    
                    
                }else{
                
                    if ($sriDepositAmount % 10000.00 != 0){
                        $extraWalletAmount = $sriDepositAmount % 10000;
                        $extraWalletAmount = $extraWalletAmount + $fraction;
                        $tempVal1 = intval($sriDepositAmount / 10000);
                        $baseAmount = $tempVal1 * 10000;
                        $specialCase = true;
                    }
                }
            }
        }
        
       
        
        $lastInteraction = $r1->input("data.lastInteraction");
        $email = trim($r1->input("data.email"));
        $lastName = $r1->input("data.lastName");
        $firstName = $r1->input("data.firstName");
        $country = $r1->input("data.country");
        
        
        try { 
            $mc_record = new ManyChatRecord;
            $mc_record->full_name = $r1->input("data.fullName"); 
            $mc_record->sri_deposit_date = $r1->input("data.sriDepositDate");  
            $mc_record->sri_deposit_amount = $r1->input("data.sriDepositAmount");
            $mc_record->sri_deposit_picture = $r1->input("data.sriDepositPicture");
            $mc_record->sri_organization = $r1->input("data.sriOrganization");
            $mc_record->last_interaction = $r1->input("data.lastInteraction");
            $mc_record->email = $r1->input("data.email");
            $mc_record->first_name = $r1->input("data.firstName");
            $mc_record->last_name = $r1->input("data.lastName");
            $mc_record->country =$r1->input("data.country");
            $mc_record->save();
        } catch (\Illuminate\Database\QueryException $e) {
            //$out[]  = $e->errorInfo;
            
            $data_error = array();
                          
            $data_error["requested_by"] = $r1->input("data.fullName"); 
            $data_error["email"] = $r1->input("data.email");
            $data_error["date_transaction"] = $r1->input("data.sriDepositDate");
            $data_error["amount"] = $r1->input("data.sriDepositAmount");
            $data_error["notes"] = $e->errorInfo; 
            $data_error["remarks"] = $e->errorInfo; 
            $data_error["investment_type"] = $r1->input("data.sriOrganization");
        
            $cc_error= array();
            $cc_error[] = "vvmanychat2020@gmail.com";
        
            $receiver_error = "vvmanychat2020@gmail.com";
            Mail::to($receiver_error)->cc($cc_error)->send(new pendingMail($data_error));
           
            
        }
                
        /*
        $final = $name . "," . $fullName . "," . $sriDepositDate . "," . $sriDepositAmount . "," . $sriDepositPicture . "," . $sriOrganization . "," . $lastInteraction . "," . $email . "," . $lastName . "," . $firstName . "," .  $country;
        
        $data_test = array();
                          
        $data_test["requested_by"] = $lastName . "," . $firstName . "," . $fullName; 
        $data_test["email"] = $email; 
        $data_test["date_transaction"] = $sriDepositDate; 
        $data_test["amount"] = $sriDepositAmount; 
        $data_test["notes"] = $final; 
        $data_test["remarks"] = $final; 
        $data_test["investment_type"] = $sriOrganization; 
                            
        $receiver_test = "vvmanychat2020@gmail.com";
         
                            
        $cc_test= array();
        $cc_test[] = "vincemvelasco@gmail.com";
                             
        Mail::to($receiver_test)->cc($cc_test)->send(new pendingMail($data_test));
        */
        
        /*
        switch(trim($email)){
            
            case "elyza.sorreda@gmail.com":
                $email = "aazyle29@gmail.com";
                
                break;
                
            default:
                break;
            
        }*/
        
        
        $count = UserO::where([
                ['user_email', '=', $email  ],
            ])
        ->count();
        
        if ($count > 0){
            
                    try { 
                        $t1 = new TransactionSync;
            
                        $user = UserO::where([
                                ['user_email', '=', $email  ],
                            ])
                        ->get();
                        
                        $user = $user[0];
             
                        $contents = file_get_contents($sriDepositPicture);
                        $extension = ".jpg";
                        $fileFirstPart = $user->id;
                        $filename = $fileFirstPart . "_" . time() ."". $extension;
                        //$t1->notes_investment_purpose = $sriDepositPicture;
                        
                        Storage::disk('public')->put($filename, $contents);
                        $t1->file_name = asset('storage/'.$filename);
                        //$t1->file_name = $sriDepositPicture;
                        
                        $t1->last_name = $user->last_name;
                        $t1->first_name = $user->first_name;

                        $t1->user_id = $user->id;
                        $t1->account_id = $user->account_id;
                        $t1->email = $user->user_email;
                        

                        $t1->date_transaction = $sriDepositDate;
                        
                        if (trim($sriDepositDate) == NULL){
                            $t1->status = "Pending";
                       
                        }else {
                            $t1->status = "Pending";
                        }
                        
  
                        if ($sriOrganization == "Organic Options"){
                            $t1->remarks = "The Organic Options(OOI) joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                        }
                        
                        if ($sriOrganization == "Tagum Cooperative"){
                            $t1->remarks = "Tagum Cooperative joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                        }
                        
                        if ($sriOrganization == "DELMARZAN 1"){
                            $t1->remarks = "MARZAN 1 is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                        }
                        
                        if ($sriOrganization == "DELMADDELA 1"){
                            $t1->remarks = "MADDELA 1 is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                        }
                        
                        if ($sriOrganization == "NSCC"){
                            $t1->remarks = "NSCC joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                        }
                        
                        if ($sriOrganization == "SEDPI"){
                            $t1->remarks = "SEDPI joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                        }
                        
                        if ($sriOrganization == "LKBP"){
                            $t1->remarks = "LKBP joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                        }
                        
                        if ($sriOrganization == "USPD"){
                            $t1->remarks = "USPD joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos
                            
                        }
                        
                        if ($sriOrganization == "MAF1"){
                            $t1->remarks = "MAF1 joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos
                            
                        }
                        
                        
                        if ($sriOrganization == "United Sugar Planters of Digos"){
                            $t1->remarks = "USPD joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos
                            
                        }
                        
                        if ($sriOrganization == "BCS"){
                            $t1->remarks = "BCS joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos
                            
                        }
                        
                        if ($sriOrganization == "DCCCO"){
                            $t1->remarks = "DCCCO joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos
                            
                        }
                        
                        if ($sriOrganization == "PCCC"){
                            $t1->remarks = "PCCC joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos
                            
                        }
                        
                        if ($sriOrganization == "PHCCI"){
                            $t1->remarks = "PHCCI joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos
                            
                        }
                        
                        if ($sriOrganization == "SAMULCO"){
                            $t1->remarks = "SAMULCO joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos
                            
                        }
                        
                        
                        if ($sriOrganization == "OOI2"){
                            
                            $subsum = Transaction::where([
                                ['investment_type', '=', "OOI2"  ],
                            ])->whereIn('status',array('Pending','Verified'))
                            ->sum('amount');
                        
                        }
                        
                        if ($sriOrganization == "OOI2"){
 
                            if ($subsum >= "3200000.00"){
                                $t1->remarks = "OOI2 joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                                $sriOrganization = "My Wallet";
                            }
                        }
                        
                        //PLACE QUERY FOR FULL
                        //IF ORG MATCHES FULL, SET FULL REMARKS AND SET TO MY WALLET
                        
                        
                        
                        
                        
                        $t1->investment_type = $sriOrganization;
                        $t1->transaction_type_id = 1;
                        
                        $fake_date = date('Y-m-d', strtotime('+7900 years'));
                        
                        if (trim($sriDepositDate) == NULL){
                            $t1->remarks = "No Transaction Date";
                            $t1->date_transaction = $fake_date;
                        }else {
                            $t1->remarks .= "";
                        }
                        
                        if ($specialCase){
                            $t1->amount = $baseAmount;
                            $t1->running_balance = $baseAmount;
                        } else {
                            $t1->amount = $sriDepositAmount;
                            $t1->running_balance = $sriDepositAmount;
                        }
 
                        $t1->is_posted = 4;
                        
                        if (trim($fullName)==NULL){
                            
                            $fullName = $user->first_name . " " . $user->last_name;
                            
                        }
                        
                        $t1->requested_by = $fullName;
                        
                        
                        if ($t1->amount!=0){
                        
                            $t1->save();
                        }
                      
                        
                        
                        //new transaction
                        //$this->createNewTransaction($t1,$t1->id);
                        $t2 = new Transaction;
                        $t2->sync_id = $t1->id;
                        $t2->last_name = $user->last_name;
                        $t2->first_name = $user->first_name;

                        $t2->user_id = $user->id;
                        $t2->account_id = $user->account_id;
                        $t2->email = $user->user_email;

                        $t2->date_transaction = $sriDepositDate;
                        
                        if (trim($sriDepositDate) == NULL){
                            $t2->status = "Pending";
                        }else {
                            $t2->status = "Pending";
                        }
                        
                        $t2->file_name = $t1->file_name;
                        //$t2->file_name = $sriDepositPicture;
  
                        $t2->investment_type = $sriOrganization;
                        $t2->transaction_type_id = 1;
                        
                        
                        if ($sriOrganization == "Organic Options"){
                            $t2->remarks = "The Organic Options(OOI) joint venture is already full. Kindly choose another SRI organization or My Wallet.";
                            $sriOrganization = "My Wallet";
                        }
                        
                        if ($sriOrganization == "Tagum Cooperative"){
                            $t2->remarks = "The Tagum Cooperative joint venture is already full. Kindly choose another SRI organization or My Wallet.";
                            $sriOrganization = "My Wallet";
                        }
                        
                        if ($sriOrganization == "DELMARZAN 1"){
                            $t2->remarks = "MARZAN 1 is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            
                        }
                        
                        if ($sriOrganization == "DELMADDELA 1"){
                            $t2->remarks = "MADDELA 1 is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            
                        }
                        
                        if ($sriOrganization == "NSCC"){
                            $t2->remarks = "NSCC joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                             
                        }
                        
                        if ($sriOrganization == "SEDPI"){
                            $t2->remarks = "SEDPI joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                             
                        }
                        
                        if ($sriOrganization == "LKBP"){
                            $t2->remarks = "LKBP joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                             
                        }
                        
                        if ($sriOrganization == "USPD"){
                            $t2->remarks = "USPD joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos  
                        }
                        
                        if ($sriOrganization == "MAF1"){
                            $t2->remarks = "MAF1 joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos  
                        }
                        
                        if ($sriOrganization == "United Sugar Planters of Digos"){
                            $t2->remarks = "USPD joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos  
                        }
                        
                        if ($sriOrganization == "BCS"){
                            $t2->remarks = "BCS joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos  
                        }
                        
                        if ($sriOrganization == "DCCCO"){
                            $t2->remarks = "DCCCO joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos  
                        }
                        
                        if ($sriOrganization == "PCCC"){
                            $t2->remarks = "PCCC joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos  
                        }
                        
                        if ($sriOrganization == "PHCCI"){
                            $t2->remarks = "PHCCI joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos  
                        }
                        
                        if ($sriOrganization == "SAMULCO"){
                            $t2->remarks = "SAMULCO joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                            $sriOrganization = "My Wallet";
                            //United Sugar Planters of Digos  
                        }
                        
                        if ($sriOrganization == "OOI2"){
 
                            if ($subsum >= "3200000.00"){
                                $t2->remarks = "OOI2 joint venture is already full. Your deposit will be placed into My Wallet after it has been verified. Afterwards, you may reinvest the money in your wallet to another Org via the REINVEST keyword in messenger.";
                                $sriOrganization = "My Wallet";
                            }
                        }
                        
                        //PLACE QUERY FOR FULL
                        //IF ORG MATCHES FULL, SET FULL REMARKS AND SET TO MY WALLET
                        
                        
                        if (trim($sriDepositDate) == NULL){
                            $t2->remarks = "No Transaction Date";
                            $t2->date_transaction = $fake_date;
                        }else {
                            $t2->remarks .= "";
                        }
                        
                        if ($specialCase){
                            $t2->amount = $baseAmount;
                            $t2->running_balance = $baseAmount;
                        } else {
                            $t2->amount = $sriDepositAmount;
                            $t2->running_balance = $sriDepositAmount;
                        }
                        
                        $t2->is_posted = 4;
                        $t2->requested_by = $fullName;
                        
                        if ($t2->amount!=0){
                        
                            $t2->save();
                        }
                        
                        
                        if ($specialCase){
                            $t3 = new TransactionSync;
                            $t3->file_name = asset('storage/'.$filename);
                            //$t1->file_name = $sriDepositPicture;
                            
                            $t3->last_name = $user->last_name;
                            $t3->first_name = $user->first_name;
    
                            $t3->user_id = $user->id;
                            $t3->account_id = $user->account_id;
                            $t3->email = $user->user_email;
                            
    
                            $t3->date_transaction = $sriDepositDate;
                            
                            if (trim($sriDepositDate) == NULL){
                                $t3->status = "Pending";
                           
                            }else {
                                $t3->status = "Pending";
                            }
                            
      
                            
      
                            $t3->investment_type = "My Wallet";
                            $t3->transaction_type_id = 1;
                            
                            
                         
                            
                            $fake_date = date('Y-m-d', strtotime('+7900 years'));
                            
                            if (trim($sriDepositDate) == NULL){
                                $t3->remarks = "No Transaction Date";
                                $t3->date_transaction = $fake_date;
                            }else {
                                $t3->remarks .= "";
                            }
                            
                            if ($specialCase){
                                $t3->amount = $extraWalletAmount;
                                $t3->running_balance = $extraWalletAmount;
                            }  
     
                            $t3->is_posted = 4;
                            
                            if (trim($fullName)==NULL){
                                
                                $fullName = $user->first_name . " " . $user->last_name;
                                
                            }
                            
                            $t3->requested_by = $fullName;
                            
                            $t3->save();
                            
                          
                            
                            
                            //new transaction
                            //$this->createNewTransaction($t1,$t1->id);
                            $t4 = new Transaction;
                            $t4->sync_id = $t3->id;
                            $t4->last_name = $user->last_name;
                            $t4->first_name = $user->first_name;
    
                            $t4->user_id = $user->id;
                            $t4->account_id = $user->account_id;
                            $t4->email = $user->user_email;
    
                            $t4->date_transaction = $sriDepositDate;
                            
                            if (trim($sriDepositDate) == NULL){
                                $t4->status = "Pending";
                            }else {
                                $t4->status = "Pending";
                            }
                            
                            $t4->file_name = $t3->file_name;
                            //$t2->file_name = $sriDepositPicture;
      
                            $t4->investment_type = "My Wallet";
                            $t4->transaction_type_id = 1;
                            
                            
                            
                            
                            if (trim($sriDepositDate) == NULL){
                                $t4->remarks = "No Transaction Date";
                                $t4->date_transaction = $fake_date;
                            }else {
                                $t4->remarks .= "";
                            }
                            
                            if ($specialCase){
                                $t4->amount = $extraWalletAmount;
                                $t4->running_balance = $extraWalletAmount;
                            }  
                            
                            $t4->is_posted = 4;
                            $t4->requested_by = $fullName;
                            
                            $t4->save();
                            
                            
                        }
                        
                        
                        
                        if ($t1->status == "Pending"){
             
                            $data = array();
                          
                            $data["requested_by"] = $t1->first_name . " " . $t1->last_name ; 
                            $data["email"] = $t1->email; 
                            $data["date_transaction"] = $t1->date_transaction; 
                            $data["amount"] = $sriDepositAmount; 
                            //$data["amount"] = $t1->amount; 
                            $data["notes"] = $t1->notes; 
                            $data["remarks"] = $t1->remarks; 
                            $data["investment_type"] = $t1->investment_type; 
                            
                            //$receiver = "vvmanychat2020@gmail.com";
                            $receiver = $t1->email;
                            
                            $cc= array();
                            $cc[] = "vvmanychat2020@gmail.com";
                            
                            $cc[] = "irmacuello18@gmail.com";
                            $cc[] = "lianne.tabug@sedpi.com"; 
                            $cc[] = "maliannedct@gmail.com"; 
                            $cc[] = "diane.lumbao@sedpi.com";
                            $cc[] = "dianelumbao@yahoo.com";
                            
                      
                            
                            Mail::to($receiver)->cc($cc)->send(new pendingMail($data));
                           
                         }
                         
                         
                    } catch (\Illuminate\Database\QueryException $e) {
                        //$out[]  = $e->errorInfo;
                        
                        $data_error = array();
                                      
                        $data_error["requested_by"] = $fullName; 
                        $data_error["email"] = $email; 
                        $data_error["date_transaction"] = $sriDepositDate;
                        $data_error["amount"] = $sriDepositAmount;
                        $data_error["notes"] = $e->errorInfo; 
                        $data_error["remarks"] = $e->errorInfo; 
                        $data_error["investment_type"] = $sriOrganization;
                    
                        $receiver_error = "vvmanychat2020@gmail.com";
                         $cc_error= array();
                        $cc_error[] = "vvmanychat2020@gmail.com";
                        Mail::to($receiver_error)->cc($cc_error)->send(new pendingMail($data_error));
                       
                        
                    }     //end catch
                                     
                         
        } else { //end if
        
            $data = array();
                          
            $data["requested_by"] = $fullName;
            $data["email"] = $email; 
            $data["date_transaction"] = $sriDepositDate;
            $data["amount"] = $sriDepositAmount;
            $data["notes"] = "email not found $email"; 
            $data["remarks"] = "email not found $email"; 
            $data["investment_type"] = $sriOrganization;
        
            $receiver = "vvmanychat2020@gmail.com";
            $cc= array();
            $cc[] = "vvmanychat2020@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new errorMail($data));
            
        
        }
        
        
        $out = array();
        $out[] = $fullName;
        $out[] = $sriDepositDate;
        $out[] = $sriDepositAmount;
        $out[] = $sriDepositPicture;
        $out[] = $sriOrganization;
        $out[] = $lastInteraction;
        $out[] = $email;
        $out[] = $lastName;
        $out[] = $firstName;
        $out[] = $country;
        
        
        
        
        
        
        
        
        return response()->json($count);
    }
    
    public function testResponseWithdrawManual($r1){
        
        $message = "SuccessWithdraw";
        
        $info = array();
        $info[] = "W Date: " . trim($r1->withdrawal_date);
        $info[] = "W Amount: " . trim($r1->withdrawal_amount);
        $info[] = "BAcctName: " . trim($r1->bank_account_name);
        $info[] = "BName: " . trim($r1->bank_name);
        $info[] = "WReason: " . trim($r1->withdraw_reason);
        $info[] = "BBranch: " . trim($r1->bank_branch);
        $info[] = "BAccount Type: " . trim($r1->bank_account_type);
        $info[] = "BAcctNo: " . trim($r1->bank_account_number);
        $info[] = "BRoutingNo: " . trim($r1->bank_routing_number);
        
        $infoGrp = implode(",",$info);
        //$infoGrp = "";
        //$fullname = $r1->input 
        //$name = $r1->input("data.fullName");
        //$fullName = $r1->input("data.fullName");
        $sriDepositDate = $r1->withdrawal_date;
        $sriDepositAmount = $r1->withdrawal_amount;
        
        if (trim($sriDepositAmount)==NULL){
            
            $sriDepositAmount = 1;
            
        }
        
        $sriDepositAmount = str_replace( ',', '', $sriDepositAmount );
        
        $sriDepositPicture = "Test";
        
        //checkSetOrg
        $sriOrganization = "My Wallet";
        //$isValidOrg = $this->setOrg2($r1->input("data.sri_organization"));
        
        //$lastInteraction = $r1->input("data.lastInteraction");
        $email = trim($r1->email);
        $lastName = $r1->last_name;
        $firstName = $r1->first_name;
        //$country = $r1->country;
        
        $count = UserO::where([
                ['user_email', '=', $email  ],
            ])
        ->count();
        
        if ($count > 0){
            
                    try { 
                        $t1 = new TransactionSync;
            
                        $user = UserO::where([
                                ['user_email', '=', $email  ],
                            ])
                        ->get();
                        
                        $user = $user[0];
             
                        //$contents = file_get_contents($sriDepositPicture);
                        //$extension = ".jpg";
                        //$fileFirstPart = $user->id;
                        //$filename = $fileFirstPart . "_" . time() ."". $extension;
                        
                        $filename = "test.jpg";
                        //$t1->notes_investment_purpose = $sriDepositPicture;
                        //Storage::disk('public')->put($filename, $contents);
                        $t1->file_name = asset('storage/'.$filename);
                        //$t1->file_name = $sriDepositPicture;
                        $t1->last_name = $user->last_name;
                        $t1->first_name = $user->first_name;
                        $t1->user_id = $user->id;
                        $t1->account_id = $user->account_id;
                        $t1->email = $user->user_email;
                        $t1->date_transaction = $sriDepositDate;
                        if (trim($sriDepositDate) == NULL){
                            $t1->status = "Pending";
                       
                        }else {
                            $t1->status = "Pending";
                        }
                        $t1->investment_type = $sriOrganization;
                        $t1->transaction_type_id = 3;
                        $fake_date = date('Y-m-d', strtotime('+7900 years'));
                        if (trim($sriDepositDate) == NULL){
                            $t1->remarks = "No Transaction Date";
                            $t1->date_transaction = $fake_date;
                        }else {
                            $t1->remarks .= "";
                        }
                        $t1->remarks .= $infoGrp; 
                        $t1->amount = $sriDepositAmount;
                        $t1->running_balance = $sriDepositAmount;
                        $t1->is_posted = 4;
                        $fullName = $user->first_name . " " . $user->last_name;
                        $t1->requested_by = $fullName;
                        $t1->save();
                        
                      
                        
                        
                        //new transaction
                        //$this->createNewTransaction($t1,$t1->id);
                        $t2 = new Transaction;
                        $t2->sync_id = $t1->id;
                        $t2->last_name = $user->last_name;
                        $t2->first_name = $user->first_name;

                        $t2->user_id = $user->id;
                        $t2->account_id = $user->account_id;
                        $t2->email = $user->user_email;

                        $t2->date_transaction = $sriDepositDate;
                        
                        if (trim($sriDepositDate) == NULL){
                            $t2->status = "Pending";
                        }else {
                            $t2->status = "Pending";
                        }
                        
                        $t2->file_name = $t1->file_name;
                        //$t2->file_name = $sriDepositPicture;
  
                        $t2->investment_type = $sriOrganization;
                        $t2->transaction_type_id = 3;
                        
                        
                        
                        if (trim($sriDepositDate) == NULL){
                            $t2->remarks = "No Transaction Date";
                            $t2->date_transaction = $fake_date;
                        }else {
                            $t2->remarks .= "";
                        }
                        
                        $t2->remarks .= $infoGrp; 
              
                        $t2->amount = $sriDepositAmount;
                        $t2->running_balance = $sriDepositAmount;
                        
                        $t2->is_posted = 4;
                        $t2->requested_by = $fullName;
                        
                        $t2->save();
                        
                       
                        if ($t1->status == "Pending"){
             
                            $data = array();
                          
                            $data["requested_by"] = $t1->first_name . " " . $t1->last_name ; 
                            $data["email"] = $t1->email; 
                            $data["date_transaction"] = $t1->date_transaction; 
                            $data["amount"] = $sriDepositAmount; 
                            //$data["amount"] = $t1->amount; 
                            $data["notes"] = $t1->notes; 
                            $data["remarks"] = $t1->remarks; 
                            $data["investment_type"] = $t1->investment_type; 
                            
                            $receiver = "vvmanychat2020@gmail.com";
                            //$receiver = $t1->email;
                            
                            $cc= array();
                            $cc[] = "vvmanychat2020@gmail.com";
                            
                            $cc[] = "irmacuello18@gmail.com";
                            $cc[] = "lianne.tabug@sedpi.com"; 
                            $cc[] = "maliannedct@gmail.com"; 
                            $cc[] = "diane.lumbao@sedpi.com";
                            $cc[] = "dianelumbao@yahoo.com";
                            
                      
                            
                            //Mail::to($receiver)->cc($cc)->send(new pendingWMail($data));
                           
                         }
                         
                         
                    } catch (\Illuminate\Database\QueryException $e) {
                        //$out[]  = $e->errorInfo;
                        
                        $data_error = array();
                                      
                        $data_error["requested_by"] = $fullName; 
                        $data_error["email"] = $email; 
                        $data_error["date_transaction"] = $sriDepositDate;
                        $data_error["amount"] = $sriDepositAmount;
                        $data_error["notes"] = $e->errorInfo; 
                        $data_error["remarks"] = $e->errorInfo; 
                        $data_error["investment_type"] = $sriOrganization;
                    
                        $receiver_error = "vvmanychat2020@gmail.com";
                        
                        
                        $cc_error= array();
                        $cc_error[] = "vvmanychat2020@gmail.com";
                        
                        Mail::to($receiver_error)->cc($cc_error)->send(new pendingWMail($data_error));
                       
                        
                    }     //end catch
                                     
                         
        } else { //end if
        
            $data = array();
                          
            $data["requested_by"] = $fullName;
            $data["email"] = $email; 
            $data["date_transaction"] = $sriDepositDate;
            $data["amount"] = $sriDepositAmount;
            $data["notes"] = "email not found $email"; 
            $data["remarks"] = "email not found $email"; 
            $data["investment_type"] = $sriOrganization;
        
            $receiver = "vvmanychat2020@gmail.com";
            $cc= array();
            $cc[] = "vvmanychat2020@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new errorWMail($data));
            
        
        }
        
        return response()->json($count);
        
    }
    
    
      public function testResponseWithdraw(Request $r1){
        
        $message = "SuccessWithdraw";
        
        $info = array();
        $info[] = "Withdrawal Date: " . $r1->input("data.withdrawal_date");
        $info[] = "Withdrawal Amount: " . $r1->input("data.withdrawal_amount");
        $info[] = "Bank Account Name: " . $r1->input("data.bank_account_name");
        $info[] = "Bank Name: " . $r1->input("data.bank_name");
        $info[] = "Withdrawal Reason: " . $r1->input("data.withdraw_reason");
        $info[] = "Bank Branch: " . $r1->input("data.bank_branch");
        $info[] = "Bank Account Type: " . $r1->input("data.bank_account_type");
        $info[] = "Bank Account Number: " . $r1->input("data.bank_account_number");
        $info[] = "Bank Routing Number: " . $r1->input("data.bank_routing_number");
        
        $infoGrp = implode(",",$info);
        
        //$fullname = $r1->input 
        //$name = $r1->input("data.fullName");
        //$fullName = $r1->input("data.fullName");
        $sriDepositDate = $r1->input("data.withdrawal_date");
        $sriDepositAmount = $r1->input("data.withdrawal_amount");
        
        if (trim($sriDepositAmount)==NULL){
            
            $sriDepositAmount = 1;
            
        }
        
        $sriDepositAmount = str_replace( ',', '', $sriDepositAmount );
        
        $sriDepositPicture = $r1->input("data.sriDepositPicture");
        
        //checkSetOrg
        $sriOrganization = $this->setOrg($r1->input("data.sri_organization"));
        //$isValidOrg = $this->setOrg2($r1->input("data.sri_organization"));
        
        //$lastInteraction = $r1->input("data.lastInteraction");
        $email = trim($r1->input("data.email"));
        $lastName = $r1->input("data.last_name");
        $firstName = $r1->input("data.first_name");
        //$country = $r1->input("data.country");
        
        $count = UserO::where([
                ['user_email', '=', $email  ],
            ])
        ->count();
        
        if ($count > 0){
            
                    try { 
                        $t1 = new TransactionSync;
            
                        $user = UserO::where([
                                ['user_email', '=', $email  ],
                            ])
                        ->get();
                        
                        $user = $user[0];
             
                        //$contents = file_get_contents($sriDepositPicture);
                        //$extension = ".jpg";
                        //$fileFirstPart = $user->id;
                        //$filename = $fileFirstPart . "_" . time() ."". $extension;
                        
                        $filename = "test.jpg";
                        //$t1->notes_investment_purpose = $sriDepositPicture;
                        //Storage::disk('public')->put($filename, $contents);
                        $t1->file_name = asset('storage/'.$filename);
                        //$t1->file_name = $sriDepositPicture;
                        $t1->last_name = $user->last_name;
                        $t1->first_name = $user->first_name;
                        $t1->user_id = $user->id;
                        $t1->account_id = $user->account_id;
                        $t1->email = $user->user_email;
                        $t1->date_transaction = $sriDepositDate;
                        if (trim($sriDepositDate) == NULL){
                            $t1->status = "Pending";
                       
                        }else {
                            $t1->status = "Pending";
                        }
                        $t1->investment_type = $sriOrganization;
                        $t1->transaction_type_id = 3;
                        $fake_date = date('Y-m-d', strtotime('+7900 years'));
                        if (trim($sriDepositDate) == NULL){
                            $t1->remarks = "No Transaction Date";
                            $t1->date_transaction = $fake_date;
                        }else {
                            $t1->remarks .= "";
                        }
                        $t1->remarks .= $infoGrp; 
                        $t1->amount = $sriDepositAmount;
                        $t1->running_balance = $sriDepositAmount;
                        $t1->is_posted = 4;
                        $fullName = $user->first_name . " " . $user->last_name;
                        $t1->requested_by = $fullName;
                        $t1->save();
                        
                      
                        
                        
                        //new transaction
                        //$this->createNewTransaction($t1,$t1->id);
                        $t2 = new Transaction;
                        $t2->sync_id = $t1->id;
                        $t2->last_name = $user->last_name;
                        $t2->first_name = $user->first_name;

                        $t2->user_id = $user->id;
                        $t2->account_id = $user->account_id;
                        $t2->email = $user->user_email;

                        $t2->date_transaction = $sriDepositDate;
                        
                        if (trim($sriDepositDate) == NULL){
                            $t2->status = "Pending";
                        }else {
                            $t2->status = "Pending";
                        }
                        
                        $t2->file_name = $t1->file_name;
                        //$t2->file_name = $sriDepositPicture;
  
                        $t2->investment_type = $sriOrganization;
                        $t2->transaction_type_id = 3;
                        
                        
                        
                        if (trim($sriDepositDate) == NULL){
                            $t2->remarks = "No Transaction Date";
                            $t2->date_transaction = $fake_date;
                        }else {
                            $t2->remarks .= "";
                        }
                        
                        $t2->remarks .= $infoGrp; 
              
                        $t2->amount = $sriDepositAmount;
                        $t2->running_balance = $sriDepositAmount;
                        
                        $t2->is_posted = 4;
                        $t2->requested_by = $fullName;
                        
                        $t2->save();
                        
                       
                        if ($t1->status == "Pending"){
             
                            $data = array();
                          
                            $data["requested_by"] = $t1->first_name . " " . $t1->last_name ; 
                            $data["email"] = $t1->email; 
                            $data["date_transaction"] = $t1->date_transaction; 
                            $data["amount"] = $sriDepositAmount; 
                            //$data["amount"] = $t1->amount; 
                            $data["notes"] = $t1->notes; 
                            $data["remarks"] = $t1->remarks; 
                            $data["investment_type"] = $t1->investment_type; 
                            
                            //$receiver = "vvmanychat2020@gmail.com";
                            $receiver = $t1->email;
                            
                            $cc= array();
                            $cc[] = "vvmanychat2020@gmail.com";
                            
                            $cc[] = "irmacuello18@gmail.com";
                            $cc[] = "lianne.tabug@sedpi.com"; 
                            $cc[] = "maliannedct@gmail.com"; 
                            $cc[] = "diane.lumbao@sedpi.com";
                            $cc[] = "dianelumbao@yahoo.com";
                            
                      
                            
                            Mail::to($receiver)->cc($cc)->send(new pendingWMail($data));
                           
                         }
                         
                         
                    } catch (\Illuminate\Database\QueryException $e) {
                        //$out[]  = $e->errorInfo;
                        
                        $data_error = array();
                                      
                        $data_error["requested_by"] = $fullName; 
                        $data_error["email"] = $email; 
                        $data_error["date_transaction"] = $sriDepositDate;
                        $data_error["amount"] = $sriDepositAmount;
                        $data_error["notes"] = $e->errorInfo; 
                        $data_error["remarks"] = $e->errorInfo; 
                        $data_error["investment_type"] = $sriOrganization;
                    
                        $receiver_error = "vvmanychat2020@gmail.com";
                        
                         $cc_error= array();
                        $cc_error[] = "vvmanychat2020@gmail.com";
                        
                        Mail::to($receiver_error)->cc($cc_error)->send(new pendingWMail($data_error));
                       
                        
                    }     //end catch
                                     
                         
        } else { //end if
        
            $data = array();
                          
            $data["requested_by"] = $fullName;
            $data["email"] = $email; 
            $data["date_transaction"] = $sriDepositDate;
            $data["amount"] = $sriDepositAmount;
            $data["notes"] = "email not found $email"; 
            $data["remarks"] = "email not found $email"; 
            $data["investment_type"] = $sriOrganization;
        
            $receiver = "vvmanychat2020@gmail.com";
            $cc= array();
            $cc[] = "vvmanychat2020@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new errorWMail($data));
            
        
        }
        
        return response()->json($count);
    }
    
    public function reinvest(Request $r1){
        
        $message = "Reinvest Success";
      
        $fullName = $r1->input("data.fullName");
        $sriDepositDate = $r1->input("data.sriDepositDate");
        $sriDepositAmount = $r1->input("data.sriDepositAmount");
        $sriDepositAmount = str_replace( ',', '', $sriDepositAmount );
        $sriOrganization = $r1->input("data.sriOrganization");
        $lastInteraction = $r1->input("data.lastInteraction");
        $email = trim($r1->input("data.email"));
        
        //CLASSIFY HERE
                
                $re2 = new Reinvestment;
                 
                $re2->name = $fullName;
                $re2->transaction_date = $sriDepositDate;
                $re2->amount = $sriDepositAmount;
                $re2->org = $sriOrganization;
                $re2->date_submitted = $sriDepositDate;
                
                if(trim($email)!=NULL){
                    $re2->email_count = 1;
                }     
                
                
                //EXCEPTION LIST
                if(trim($email)=="ria_m_ph@yahoo.com"){
                    $email = "grc.monte@gmail.com";
                    
                }
                
                
                $re2->email = $email;
                $re2->save();

                $out = array();
                $out[] = $fullName;
                $out[] = $sriDepositDate;
                $out[] = $sriDepositAmount;
 
                $out[] = $sriOrganization;
                $out[] = $lastInteraction;
                $out[] = $email;
 
        
        return response()->json($message);
    }
    
    public function countForEmail($search){
        
        if ($search == NULL){
            $count = 0;
        }else{
            
            $count = UserO::where([
                ['user_email', '=', $search  ],
            ])
            ->count();
            
            
        }
        
        //dd($count);
        return $count;
        
        
    }
    
    
    
    public function searchForEmail($email){
        
        $user = UserO::where([
                        ['user_email', '=', $email  ],
                ])
        ->get();
        
        return $user[0];
        
        
    }
    
   
    
   
   
}
