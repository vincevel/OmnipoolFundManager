<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\regMail;
 

use App\TransactionSync;
use App\Transaction;
use App\UserOTest;
use App\UserO;
 
use App\Testing;
use App\ManyChatSSSRegRecord;
use App\ManyChatPagibigRegRecord;

use Storage;

class ManyChatControllerSSSPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(){
        
        
        
    }
    
    public function pagibigReg(Request $r1){
        
        $message = "Success";
          
        $item = new ManyChatPagibigRegRecord;
         
        $data2 = array();
          
        $count = "TestNumberpagibigreg";
        $item->full_name = $this->removeSpaces2($r1->input("data.full_name"));
        $item->last_name = $this->removeSpaces2($r1->input("data.last_name"));
        $item->middle_name = $this->removeSpaces2($r1->input("data.middle_name"));
        $item->first_name = $this->removeSpaces2($r1->input("data.first_name"));
        $item->nick_name = $this->removeSpaces2($r1->input("data.nick_name"));
        $item->phone = $this->removeSpaces($r1->input("data.phone"));
        $item->email = $this->removeSpaces($r1->input("data.email"));
        $item->civil_status = $this->removeSpaces($r1->input("data.civil_status"));
        $item->sex = $this->removeSpaces($r1->input("data.sex"));
        $item->birthday = $this->removeSpaces($r1->input("data.birthday"));
        $item->birth_place = $this->removeSpaces($r1->input("data.birth_place"));
        $item->mothers_maiden_name = $this->removeSpaces($r1->input("data.mothers_maiden_name"));
        $item->fathers_name = $this->removeSpaces($r1->input("data.fathers_name"));
        $item->spouses_name = $this->removeSpaces($r1->input("data.spouses_name"));
        $item->country = $this->removeSpaces($r1->input("data.country"));
        $item->street_address = $this->removeSpaces($r1->input("data.street_address"));
        $item->city = $this->removeSpaces($r1->input("data.city"));
        $item->state_or_province = $this->removeSpaces($r1->input("data.state_or_province"));
        $item->postal_zip_code = $this->removeSpaces($r1->input("data.postal_zip_code"));
        $item->employment_status = $this->removeSpaces($r1->input("data.employment_status"));
        $item->occupation = $this->removeSpaces($r1->input("data.occupation"));
        $item->employer = $this->removeSpaces($r1->input("data.employer"));
        $item->employers_address = $this->removeSpaces($r1->input("data.employers_address"));
        $item->employment_date = $this->removeSpaces($r1->input("data.employment_date"));
        $item->monthly_salary = $this->removeSpaces($r1->input("data.monthly_salary"));
        $item->beneficiary_1 = $this->removeSpaces($r1->input("data.beneficiary_1"));
        $item->beneficiary_1_relationship = $this->removeSpaces($r1->input("data.beneficiary_1_relationship"));
        $item->beneficiary_1_bdate = $this->removeSpaces($r1->input("data.beneficiary_1_bdate"));
        $item->beneficiary_2 = $this->removeSpaces($r1->input("data.beneficiary_2"));
        $item->beneficiary_2_relationship = $this->removeSpaces($r1->input("data.beneficiary_2_relationship"));
        $item->beneficiary_2_bdate = $this->removeSpaces($r1->input("data.beneficiary_2_bdate"));
        $item->beneficiary_3 = $this->removeSpaces($r1->input("data.beneficiary_3"));
        $item->beneficiary_3_relationship = $this->removeSpaces($r1->input("data.beneficiary_3_relationship"));
        $item->beneficiary_3_bdate = $this->removeSpaces($r1->input("data.beneficiary_3_bdate"));
        $item->kind_of_id = $this->removeSpaces($r1->input("data.kind_of_id"));
        $item->id_number = $this->removeSpaces($r1->input("data.id_number"));
        $item->id_date_of_issue = $this->removeSpaces($r1->input("data.id_date_of_issue"));
        $item->id_date_of_expiry = $this->removeSpaces($r1->input("data.id_date_of_expiry"));
        $item->id_place_of_issue = $this->removeSpaces($r1->input("data.id_place_of_issue"));
        $item->id_picture = $this->removeSpaces($r1->input("data.id_picture"));
        $item->sss_number = $this->removeSpaces($r1->input("data.sss_number"));
        $item->tin_number = $this->removeSpaces($r1->input("data.tin_number"));
        $item->agree_terms_and_conditions = $this->removeSpaces($r1->input("data.agree_terms_and_conditions"));
        $item->last_interaction = $this->removeSpaces($r1->input("data.last_interaction"));
        $item->mp2_open_account = $this->removeSpaces($r1->input("data.mp2_open_account"));
        $item->mp2_desired_deposit = $this->removeSpaces($r1->input("data.mp2_desired_deposit"));
        $item->mp2_dividend_payout = $this->removeSpaces($r1->input("data.mp2_dividend_payout"));
        $item->mp2_payment_mode = $this->removeSpaces($r1->input("data.mp2_payment_mode"));
        $item->source_of_funds = $this->removeSpaces($r1->input("data.source_of_funds"));
        $item->save();
        
        $this->syncToUsers($item,2);


          
        return response()->json($count);
    }
    
    public function removeSpaces($input){
        
        return trim($input);
        
    }
    
    public function removeSpaces2($input){
        
        return ucwords(strtolower(trim($input)));

    }
    
    
    public function sendRegMail($data){
    
    
        
            $cc= array();
            $cc[] = "vvmanychat2020@gmail.com";
        
        
            $receiver = $data["email"];
            //$receiver = "vincentvelasco1232019@gmail.com";
            Mail::to($receiver)->cc($cc)->send(new regMail($data));
        
    }
    
    
    
    public function syncToUsers($item,$case){
         
         

    $mystring = $item->birthday;
    $findme   = '-';
    $pos = strpos($mystring, $findme);
    $notProperDate = false;
    
    // Note our use of ===.  Simply == would not work as expected
    // because the position of 'a' was the 0th (first) character.
    if ($pos !== false) {
        //echo "The string '$findme' was  found in the string '$mystring'";
    } else {
        //echo "The string '$findme' was not found in the string '$mystring'";
        //echo " and exists at position $pos";
        $notProperDate = true;
    }
 
        
        
         $count = $this->countForEmail($item->email);
            if ($count == 0){
                $user = new UserO;
                $user->user_email = $item->email;
                $passw = "sdfi2008";
                $user->user_pass = password_hash($passw, PASSWORD_DEFAULT);
                $user->plainpass = $passw;
                $user->last_name = $item->last_name;
                $user->first_name = $item->first_name;
                $user->middle_name = $item->middle_name;
                $user->account_id = md5(uniqid());
                $user->phone_no = $item->phone;
                $user->country = $item->country;
                $user->address_line1 = $item->street_address;
                //$user->address_line2 = $item->;
                $user->city = $item->city;
                $user->state_province = $item->state_or_province;
                $user->postal_zip_code = $item->postal_zip_code;
                
                if (!$notProperDate){
                    $user->birthday = $item->birthday;
                }
            
                switch ($case){
                    
                    case 1:
                    $user->sss_id = $item->id;
                    break;
                    
                    case 2:
                    $user->pagibig_id = $item->id;
                    break;
                }
                
                $user->save();
                
                //invoke mail 
                $data = array();
                $data["email"] = $user->user_email;
                
                $this->sendRegMail($data);
                
            } else {
                
                $user = $this->searchForEmail($item->email);
                $user->last_name = $item->last_name;
                $user->first_name = $item->first_name;
                $user->middle_name = $item->middle_name;
                $user->phone_no = $item->phone;
                $user->country = $item->country;
                $user->address_line1 = $item->street_address;
                //$user->address_line2 = $item->;
                $user->city = $item->city;
                $user->state_province = $item->state_or_province;
                $user->postal_zip_code = $item->postal_zip_code;
                
                if (!$notProperDate){
                    $user->birthday = $item->birthday;
                }
                
                switch ($case){
                    
                    case 1:
                    $user->sss_id = $item->id;
                    break;
                    
                    case 2:
                    $user->pagibig_id = $item->id;
                    break;
                }
               
                //$user->save();
                
              
            }
        
    }
    
    public function sssReg(Request $r1){
        
          $message = "Success";
          
 
          $item = new ManyChatSSSRegRecord;
 
          
          $count = "TestNumber";
        
            $item->full_name = $this->removeSpaces2($r1->input("data.full_name"));
            $item->last_name = $this->removeSpaces2($r1->input("data.last_name"));
            $item->middle_name = $this->removeSpaces2($r1->input("data.middle_name"));
            $item->first_name = $this->removeSpaces2($r1->input("data.first_name"));
            $item->nick_name = $this->removeSpaces2($r1->input("data.nick_name"));
            $item->phone = $this->removeSpaces($r1->input("data.phone"));
            $item->email = $this->removeSpaces($r1->input("data.email"));
            $item->civil_status = $this->removeSpaces($r1->input("data.civil_status"));
            $item->sex = $this->removeSpaces($r1->input("data.sex"));
            $item->birthday = $this->removeSpaces($r1->input("data.birthday"));
            $item->birth_place = $this->removeSpaces($r1->input("data.birth_place"));
            $item->mothers_maiden_name = $this->removeSpaces($r1->input("data.mothers_maiden_name"));
            $item->fathers_name = $this->removeSpaces($r1->input("data.fathers_name"));
            $item->spouses_name = $this->removeSpaces($r1->input("data.spouses_name"));
            $item->country = $this->removeSpaces($r1->input("data.country"));
            $item->street_address = $this->removeSpaces($r1->input("data.street_address"));
            $item->city = $this->removeSpaces($r1->input("data.city"));
            $item->state_or_province = $this->removeSpaces($r1->input("data.state_or_province"));
            $item->postal_zip_code = $this->removeSpaces($r1->input("data.postal_zip_code"));
            $item->employment_kind = $this->removeSpaces($r1->input("data.employment_kind"));
            $item->foreign_address = $this->removeSpaces($r1->input("data.foreign_address"));
            $item->sss_flexi_fund = $this->removeSpaces($r1->input("data.sss_flexi_fund"));
            $item->employment_status = $this->removeSpaces($r1->input("data.employment_status"));
            $item->occupation = $this->removeSpaces($r1->input("data.occupation"));
            $item->employer = $this->removeSpaces($r1->input("data.employer"));
            $item->employers_address = $this->removeSpaces($r1->input("data.employers_address"));
            $item->employment_date = $this->removeSpaces($r1->input("data.employment_date"));
            $item->monthly_salary = $this->removeSpaces($r1->input("data.monthly_salary"));
            $item->beneficiary_1 = $this->removeSpaces($r1->input("data.beneficiary_1"));
            $item->beneficiary_1_relationship = $this->removeSpaces($r1->input("data.beneficiary_1_relationship"));
            $item->beneficiary_1_bdate = $this->removeSpaces($r1->input("data.beneficiary_1_bdate"));
            $item->beneficiary_2 = $this->removeSpaces($r1->input("data.beneficiary_2"));
            $item->beneficiary_2_relationship = $this->removeSpaces($r1->input("data.beneficiary_2_relationship"));
            $item->beneficiary_2_bdate = $this->removeSpaces($r1->input("data.beneficiary_2_bdate"));
            $item->beneficiary_3 = $this->removeSpaces($r1->input("data.beneficiary_3"));
            $item->beneficiary_3_relationship = $this->removeSpaces($r1->input("data.beneficiary_3_relationship"));
            $item->beneficiary_3_bdate = $this->removeSpaces($r1->input("data.beneficiary_3_bdate"));
            $item->kind_of_id = $this->removeSpaces($r1->input("data.kind_of_id"));
            $item->id_number = $this->removeSpaces($r1->input("data.id_number"));
            $item->id_date_of_issue = $this->removeSpaces($r1->input("data.id_date_of_issue"));
            $item->id_date_of_expiry = $this->removeSpaces($r1->input("data.id_date_of_expiry"));
            $item->id_place_of_issue = $this->removeSpaces($r1->input("data.id_place_of_issue"));
            $item->id_picture = $this->removeSpaces($r1->input("data.id_picture"));
            $item->sss_number = $this->removeSpaces($r1->input("data.sss_number"));
            $item->tin_number = $this->removeSpaces($r1->input("data.tin_number"));
            $item->agree_terms_and_conditions = $this->removeSpaces($r1->input("data.agree_terms_and_conditions"));
            $item->sss_number_spouse = $this->removeSpaces($r1->input("data.sss_number_spouse"));
            $item->agree_spouse_sss_membership = $this->removeSpaces($r1->input("data.agree_spouse_sss_membership"));
            $item->last_interaction = $this->removeSpaces($r1->input("data.last_interaction"));
            $item->save();
            
            $this->syncToUsers($item,1); 

          return response()->json($count);
    }
    
    public function createNewTransaction($item,$id){
           /*
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
            */
    }
    
    
    
    
    public function testResponse(Request $r1){
        
        $message = "Success";
        //$r1->input("data.fullName")
        /*
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
        
        $specialCase = false;
       
        if ($isValidOrg){
            if ($sriDepositAmount % 10000 != 0){
                $extraWalletAmount = $sriDepositAmount % 10000;
                $tempVal1 = intval($sriDepositAmount / 10000);
                $baseAmount = $tempVal1 * 10000;
                $specialCase = true;
            }
        }
        
       
        
        $lastInteraction = $r1->input("data.lastInteraction");
        $email = trim($r1->input("data.email"));
        $lastName = $r1->input("data.lastName");
        $firstName = $r1->input("data.firstName");
        $country = $r1->input("data.country");
        */
        
        try { 
            /*
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
            */
        } catch (\Illuminate\Database\QueryException $e) {
    
                          
        }
        
        
        
        return response()->json($count);
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
