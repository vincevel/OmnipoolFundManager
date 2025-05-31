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
 
 
use App\JfSweppDepRecord; 
use App\JfGSweppDepAgentRecord; 

use Storage;
 
class JfGSweppDepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(){
        
        
        
    }
    
    public function gsweppdeptest(Request $r1){
        
        if (!$r1->has('fullname32')) {
            $r1->merge(['user_id4' => "MOD"]);
        }
        
        //echo "<script type=\"text/javascript\" src=\"https://form.jotform.com/jsform/210914658617461\"></script>";
        //print_r($data);
        $this->gsweppdeptestB($r1);
    }
    
     public function gsweppdeptestB(Request $r1){
         $data = $r1->input();
        //var_dump($data);
    }
         
    public function gsweppdep(Request $r1){
        
 
        $data = $r1->input();
        //print_r($data);
 
        $this->recordSubmission($r1);
        
        //check if account exists.
        $hasAccount = false;
        $hasAccount = $this->countForEmail($data["email32"]);
        
        if ($hasAccount){
             
            $this->createTransactionEntries($r1);
            
            
            
             
        } else {
            
            $this->sendErrorMailEmailNotFound($r1);
            
            
        }
        
        return view('gsweppdep.thankyou', [
            
         
            
        ]);
 
    }
    
    public function sendErrorMailEmailNotFound(Request $r1){
            $data = $r1->input();
        
            $dataErrMail = array();
                          
            $dataErrMail["requested_by"] = $data["fullname3"][0] . " " . $data["fullname3"][1] . " " . $data["fullname3"][2] . " " . $data["fullname3"][3];
            $dataErrMail["email"] = $data["email32"]; 
            $dataErrMail["date_transaction"] = $data["depositdate"][2] . "-" . $data["depositdate"][0] . "-" . $data["depositdate"][1];;
            $dataErrMail["amount"] = $data["depositamount"];
            $dataErrMail["notes"] = "email not found " . $data["email32"]; 
            $dataErrMail["remarks"] = "email not found " . $data["email32"]; 
            $dataErrMail["investment_type"] = $data["premiumpayment"];
        
            $receiver = "vvmanychat2020@gmail.com";
            $cc= array();
            $cc[] = "vvmanychat2020@gmail.com";
            
            Mail::to($receiver)->cc($cc)->send(new errorMail($dataErrMail));
    }
    
    public function recordSubmission(Request $r1){ 
        $data = $r1->input();
        
        try { 
            $jf_sweppdep_record = new JfSweppDepRecord;
            $jf_sweppdep_record->full_name = $data["fullname3"][0] . " " . $data["fullname3"][1] . " " . $data["fullname3"][2] . " " . $data["fullname3"][3];
            //$jf_sweppdep_record->sri_deposit_date = $data["depositdate"][2] . "-" . $data["depositdate"][0] . "-" . $data["depositdate"][1];
            $jf_sweppdep_record->setSriDepositDate($data["depositdate"][0],$data["depositdate"][1],$data["depositdate"][2]);
            
            $jf_sweppdep_record->sri_deposit_amount = $data["depositamount"];
            //$jf_sweppdep_record->sri_deposit_picture = $this->getJfImageUrl($data["uploadproof"][0]); 
            $jf_sweppdep_record->sri_deposit_picture = $this->getJfImageUrl($r1); 
            $jf_sweppdep_record->sri_organization = $data["premiumpayment"];
            //$jf_sweppdep_record->sri_organization = $sriOrganization;
            //$jf_sweppdep_record->last_interaction = $r1->input("data.lastInteraction");
            $jf_sweppdep_record->email = $data["email32"];
            $jf_sweppdep_record->first_name = $data["fullname3"][0]; 
            $jf_sweppdep_record->last_name = $data["fullname3"][2];   
            //$jf_sweppdep_record->country =$r1->input("data.country");
            
            if (isset($data["nameof65"][0])){
                $jf_sweppdep_record->agent_first_name = $data["nameof65"][0];
            }
            
            if (isset($data["nameof65"][1])){
                $jf_sweppdep_record->agent_last_name = $data["nameof65"][1];
            }
            
            
            
            
            $jf_sweppdep_record->save();
            
        } catch (\Illuminate\Database\QueryException $e) {
            //$out[]  = $e->errorInfo;
            $out = $this->processErrorMessages($e->errorInfo);
            
            $data_error = array();
                          
            $data_error["requested_by"] = $data["fullname3"][0] . " " . $data["fullname3"][1] . " " . $data["fullname3"][2] . " " . $data["fullname3"][3];
            $data_error["email"] = $data["email32"];
            $data_error["date_transaction"] = $data["depositdate"][2] . "-" . $data["depositdate"][0] . " " . $data["depositdate"][1];
            $data_error["amount"] = $data["depositamount"];
            $data_error["notes"] = $out; 
            $data_error["remarks"] = $out; 
            $data_error["investment_type"] = $data["premiumpayment"];
        
            $cc_error= array();
            $cc_error[] = "vvmanychat2020@gmail.com";
        
            $receiver_error = "vvmanychat2020@gmail.com";
            Mail::to($receiver_error)->cc($cc_error)->send(new pendingMail($data_error));
           
            
        }
      
    }
    
     public function getJfImageUrl(Request $r1){
        $data = $r1->input();
        
        //perform function for picture storage.
        //$j1->id_picture = $data["uploadid"][0];
        
        //http://www.jotform.com/uploads/vincerap/YOUR_FORM_ID/{$SUBMISSION_ID_VARIABLE}/{$FILE_UPLOAD_VARIABLE}
        
        $prefix = "http://www.jotform.com/uploads/vincerap/";
        //$formId = $data["formID"];
        $url = $prefix . $data["formID"] ."/". $data["submission_id"] . "/" . $data["uploadproof"][0];
        //var_dump($url);
         
        return $url;
        //build url string
       
       
    }
    
     public function getJfImage(Request $r1){
        $data = $r1->input();
        
        //perform function for picture storage.
        //$j1->id_picture = $data["uploadid"][0];
        
        //http://www.jotform.com/uploads/vincerap/YOUR_FORM_ID/{$SUBMISSION_ID_VARIABLE}/{$FILE_UPLOAD_VARIABLE}
        
        $prefix = "http://www.jotform.com/uploads/vincerap/";
        //$formId = $data["formID"];
        $url = $prefix . $data["formID"] ."/". $data["submission_id"] . "/" . $data["uploadproof"][0];
        //var_dump($url);
         
        
        //build url string
        
        $contents = file_get_contents($url);
        $extension = ".jpg";
        $fileFirstPart =  $data["formID"].$data["submission_id"];
        $filename = $fileFirstPart . "_" . time() ."". $extension;
        //$t1->notes_investment_purpose = $sriDepositPicture;
                        
        Storage::disk('public')->put($filename, $contents);
        return asset('storage/'.$filename);
       
    }
    
    
    
      
    public function createTransactionEntries(Request $r1){
        
        $data = $r1->input();
        
        $name = $data["fullname3"][0] . " " . $data["fullname3"][1] . " " . $data["fullname3"][2] . " " . $data["fullname3"][3];
        $fullName = $name;
        $sriDepositDate = $data["depositdate"][2] . "-" . $data["depositdate"][0] . "-" . $data["depositdate"][1];
        $sriDepositAmount = $data["depositamount"];
        
        if (trim($sriDepositAmount)==NULL){
            
            $sriDepositAmount = 1;
            
        }
        
        $sriDepositAmount = str_replace( ',', '', $sriDepositAmount );
        
        //$sriDepositPicture = $data["uploadproof"][0]; 
        
        //$lastInteraction = $r1->input("data.lastInteraction");
        
        $email = $data["email32"];
        $lastName = $data["fullname3"][2];
        $firstName = $data["fullname3"][0];
        
        $sriOrganization = $data["premiumpayment"];
        
        //$country = $r1->input("data.country");
        
 
 
            
                    try { 
                        $t1 = new TransactionSync;
            
                        $user = $this->searchForEmail($email);
                        $t1->file_name = $this->getJfImage($r1);

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
                        
                        $fake_date = date('Y-m-d', strtotime('+7900 years'));
                        
                        if (trim($sriDepositDate) == NULL){
                            $t1->remarks = "No Transaction Date";
                            $t1->date_transaction = $fake_date;
                        }else {
                            $t1->remarks .= "";
                        }
                        
                        
                        $t1->amount = $sriDepositAmount;
                        $t1->running_balance = $sriDepositAmount;
                        
 
                        $t1->is_posted = 11;
                        
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
                         
                        
                        //PLACE QUERY FOR FULL
                        //IF ORG MATCHES FULL, SET FULL REMARKS AND SET TO MY WALLET
                        
                        
                        if (trim($sriDepositDate) == NULL){
                            $t2->remarks = "No Transaction Date";
                            $t2->date_transaction = $fake_date;
                        }else {
                            $t2->remarks .= "";
                        }
                        
                        
                        $t2->amount = $sriDepositAmount;
                        $t2->running_balance = $sriDepositAmount;
                        
                        $t2->is_posted = 11;
                        $t2->requested_by = $fullName;
                        
                        if ($t2->amount!=0){
                        
                            $t2->save();
                            $transaction_id = $t2->id;
                            
                            if (!$transaction_id == NULL){
                                
                                $this->recordAgentInfo($r1,$transaction_id);
                                
                            }
                            
                        }
                        
                        
                        if ($t1->status == "Pending"){
             
                            $dataPending = array();
                          
                            $dataPending["requested_by"] = $t1->first_name . " " . $t1->last_name ; 
                            $dataPending["email"] = $t1->email; 
                            $dataPending["date_transaction"] = $t1->date_transaction; 
                            $dataPending["amount"] = $sriDepositAmount; 
                            //$data["amount"] = $t1->amount; 
                            $dataPending["notes"] = $t1->notes; 
                            $dataPending["remarks"] = $t1->remarks; 
                            $dataPending["investment_type"] = $t1->investment_type; 
                            
                            //$receiver = "vvmanychat2020@gmail.com";
                            $receiver = $t1->email;
                            
                            $cc= array();
                            $cc[] = "vvmanychat2020@gmail.com";
                            
                            $cc[] = "irmacuello18@gmail.com";
                            $cc[] = "lianne.tabug@sedpi.com"; 
                            $cc[] = "maliannedct@gmail.com"; 
                            $cc[] = "diane.lumbao@sedpi.com";
                            $cc[] = "dianelumbao@yahoo.com";
                            
                      
                            
                            Mail::to($receiver)->cc($cc)->send(new pendingMail($dataPending));
                           
                         }
                         
                         
                    } catch (\Illuminate\Database\QueryException $e) {
                        //$out[]  = $e->errorInfo;
                        
                        //$out = array();
                        $out = $this->processErrorMessages($e->errorInfo);
                        /*
                        foreach ($e->errorInfo as $error){
                            $out .= $error . ".";    
                        }
                        */
                        
                        $data_error = array();
                                      
                        $data_error["requested_by"] = $fullName; 
                        $data_error["email"] = $email; 
                        $data_error["date_transaction"] = $sriDepositDate;
                        $data_error["amount"] = $sriDepositAmount;
                        $data_error["notes"] = $out; 
                        $data_error["remarks"] = $out; 
                        $data_error["investment_type"] = $sriOrganization;
                    
                        $receiver_error = "vvmanychat2020@gmail.com";
                        $cc_error= array();
                        $cc_error[] = "vvmanychat2020@gmail.com";
                        Mail::to($receiver_error)->cc($cc_error)->send(new pendingMail($data_error));
                       
                        
                    }     //end catch
                                     
                         
 
        
        
        
        
        
        
        
        
   
    }
    
    public function processErrorMessages($errors){
        
        $errorsOutput = "";
        
        foreach ($errors as $error){
            $errorsOutput .= $error . ". ";
        }
        
        
        return $errorsOutput;
    }
    
    public function recordAgentInfo(Request $r1,$id){
    
        $emptyCounter = 0;
      
        $data = $r1->input();
        
        $a1 = new JfGSweppDepAgentRecord;
        
        if (!isset($data["nameof65"][0])){
             $emptyCounter++;
        }else{
            if (trim($data["nameof65"][0]) == NULL){
            
                $emptyCounter++;
            }
        }
 
            
        if (!isset($data["nameof65"][1])){
             $emptyCounter++;
        }else {
            if (trim($data["nameof65"][1]) == NULL){
            
                $emptyCounter++;
            }
        }
            
     
        
        if ($emptyCounter == 0){
            $a1->transaction_id = $id;
            $a1->first_name = $data["nameof65"][0];
            $a1->last_name = $data["nameof65"][1];
            
            $a1->save();
            
        }
        
        
       
    }
    
     
    public function searchForEmail($email){
        //UserO
        $user = UserO::where([
                        ['user_email', '=', $email  ],
                ])
        ->get();
        
        return $user[0];
        
        
    }
    
     public function countForEmail($email){
        
        $found = false;
        //UserO
        $count = UserO::where([
            ['user_email', '=', $email  ],
        ])
        ->count();
            
        if ($count > 0){
            $found = true;
        }   
            
        //dd($count);
        return $found;
        
    } 
    
    
 
   
    
   
   
}
