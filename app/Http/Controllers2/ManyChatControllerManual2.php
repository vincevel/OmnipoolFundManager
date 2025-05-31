<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\verifyMail;
use App\Mail\pendingMail;

use App\TransactionSync;
use App\Transaction;
use App\UserO;
use App\Reinvestment;
use App\ManyChatRecord;

use Storage;

class ManyChatControllerManual2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(){
        
        
        
    }
    
    public function setOrg($org){
        
        $inputs = array();
        
    	switch (strtoupper(trim($org))){

				case "ASKI":	
					$inputs["investment_type"] = "Alalay Sa Kaunlaran Inc";
					break;
				case "OOI":
					$inputs["investment_type"] = "Organic Options";
					break;
				case "PCCC":
					$inputs["investment_type"] = "Pantukan Chess Club Cooperative";
					break;
				case "USPD":
					$inputs["investment_type"] = "United Sugar Planters of Digos";
					break;	
				case "TC":
					$inputs["investment_type"] = "Tagum Cooperative";
					break;	
				case "NSCC":	
					$inputs["investment_type"] = "NSCC";
					break;
				case "SHSC":	
					$inputs["investment_type"] = "SHSC";
					break;
			    
			    case "LKBP":	
					$inputs["investment_type"] = "LKBP";
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
				
				case "MADDELA 1":	
					$inputs["investment_type"] = "MADDELA1";
					break;
				
				case "MADDELA1":	
					$inputs["investment_type"] = "MADDELA1";
					break;
				
				
				
				case "Wallet":	
			    	$inputs["investment_type"] = "My Wallet";
					break;
				
			 
					
				default:
					$inputs["investment_type"] = "SEDPI";
					break;

			}
			
			return $inputs["investment_type"];
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
    
    
    
    
    public function manual(){
        //dd("at manual");
       // $message = "Success";
        /*
        $r1->input("data.fullName") = "Laarnie Lansang";
        $r1->input("data.sriDepositDate") = "2020-04-16";
        $r1->input("data.sriDepositAmount") = "1500.00";
        $r1->input("data.sriDepositPicture") = "https://scontent.xx.fbcdn.net/v/t1.15752-9/118411912_1237515386621690_4229182140693885683_n.jpg?_nc_cat=108&_nc_sid=b96e70&_nc_ohc=zv89b2AE5koAX_Wo8ZO&_nc_ad=z-m&_nc_cid=0&_nc_ht=scontent.xx&oh=e0dce843525e093e6254aaf3a56c4394&oe=5F67E350";
        $r1->input("data.sriOrganization") = "WALLET";
        $r1->input("data.lastInteraction") = "2020-08-24 14:15:12.2";
        $r1->input("data.email") = "nie0708@gmail.com";
        $r1->input("data.firstName") = "Laarnie";
        $r1->input("data.lastName") = "Lansang";
        $r1->input("data.country") = "UAE";
        */
        // 
        
        $item = ManyChatRecord::find(256);
        
        $name = $item->full_name;
        $fullName = $item->full_name;
        $sriDepositDate = $item->sri_deposit_date;
        $sriDepositAmount = $item->sri_deposit_amount;
        
        if (trim($sriDepositAmount)==NULL){
            
            $sriDepositAmount = 1;
            
        }
        
        $sriDepositAmount = str_replace( ',', '', $sriDepositAmount );
        
        $sriDepositPicture = $item->sri_deposit_picture;
        
        $sriOrganization = $this->setOrg($item->sri_organization);
        $lastInteraction = $item->last_interaction;
        $email = trim($item->email);
        $lastName = $item->last_name;
        $firstName = $item->first_name;
        $country = $item->country;
        
        /*
        $data_out = array();
        $data_out[] = $fullName;
        $data_out[] = $sriDepositDate;
        $data_out[] = $sriDepositAmount;
        $data_out[] = $sriDepositPicture;
        $data_out[] = $sriOrganization;
        $data_out[] = $lastInteraction;
        $data_out[] = $email;
        $data_out[] = $lastName;
        $data_out[] = $firstName;
        $data_out[] = $country;
        */
        
        //dd($data_out);
        
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
                        
  
                        
  
                        $t1->investment_type = $sriOrganization;
                        $t1->transaction_type_id = 1;
                        
                        
                        if ($sriOrganization == "Organic Options"){
                            $t1->remarks = "The Organic Options(OOI) joint venture is already full. Kindly choose another SRI organization or My Wallet.";
                        }
                        
                        if ($sriOrganization == "Tagum Cooperative"){
                            $t1->remarks = "Tagum Cooperative joint venture is already full. Kindly choose another SRI organization or My Wallet.";
                        }
                        
                        $fake_date = date('Y-m-d', strtotime('+7900 years'));
                        
                        if (trim($sriDepositDate) == NULL){
                            $t1->remarks = "No Transaction Date";
                            $t1->date_transaction = $fake_date;
                        }else {
                            $t1->remarks .= "";
                        }
                        
                        $t1->amount = $sriDepositAmount;
                        $t1->running_balance = $sriDepositAmount;
 
                        $t1->is_posted = 4;
                        
                        if (trim($fullName)==NULL){
                            
                            $fullName = $user->first_name . " " . $user->last_name;
                            
                        }
                        
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
                        $t2->transaction_type_id = 1;
                        
                        
                        if ($sriOrganization == "Organic Options"){
                            $t2->remarks = "The Organic Options(OOI) joint venture is already full. Kindly choose another SRI organization or My Wallet.";
                        }
                        
                        if ($sriOrganization == "Tagum Cooperative"){
                            $t2->remarks = "The Tagum Cooperative joint venture is already full. Kindly choose another SRI organization or My Wallet.";
                        }
                        
                        
                        if (trim($sriDepositDate) == NULL){
                            $t2->remarks = "No Transaction Date";
                            $t2->date_transaction = $fake_date;
                        }else {
                            $t2->remarks .= "";
                        }
                        
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
                            $data["amount"] = $t1->amount; 
                            $data["notes"] = $t1->notes; 
                            $data["remarks"] = $t1->remarks; 
                            $data["investment_type"] = $t1->investment_type; 
                            
                            //$receiver = "vincentvelasco1232019@gmail.com";
                            $receiver = $t1->email;
                            
                            $cc= array();
                            $cc[] = "vincemvelasco@gmail.com";
                            /*
                            $cc[] = "irmacuello18@gmail.com";
                            $cc[] = "lianne.tabug@sedpi.com"; 
                            $cc[] = "maliannedct@gmail.com"; 
                            $cc[] = "diane.lumbao@sedpi.com";
                            $cc[] = "dianelumbao@yahoo.com";
                            
                      
                            */
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
                    
                        $receiver_error = "vincentvelasco1232019@gmail.com";
                        Mail::to($receiver_error)->cc($cc_error)->send(new pendingMail($data_error));
                        $cc_error= array();
                        $cc_error[] = "vincemvelasco@gmail.com";
                        
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
        
            $receiver = "vincentvelasco1232019@gmail.com";
            $cc= array();
            $cc[] = "vincemvelasco@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new pendingMail($data));
            
        
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
    
    public function reinvest(Request $r1){
        
        $message = "Reinvest Success";
      
        $fullName = $r1->input("data.fullName");
        $sriDepositDate = $r1->input("data.sriDepositDate");
        $sriDepositAmount = $r1->input("data.sriDepositAmount");
        $sriDepositAmount = str_replace( ',', '', $sriDepositAmount );
        $sriOrganization = $r1->input("data.sriOrganization");
        $lastInteraction = $r1->input("data.lastInteraction");
        $email = trim($r1->input("data.email"));
        
                
                $re2 = new Reinvestment;
                 
                $re2->name = $fullName;
                $re2->transaction_date = $sriDepositDate;
                $re2->amount = $sriDepositAmount;
                $re2->org = $sriOrganization;
                $re2->date_submitted = $sriDepositDate;
                $re2->email_count = 1;
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
