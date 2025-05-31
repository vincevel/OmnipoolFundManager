<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
 
use App\Mail\regMail;


use App\TransactionSync;
use App\Transaction;
use App\UserO;
use App\UserTesting;
 

 

use Storage;
 
use App\JfRegistration;
use App\JfBeneficiaryRegistration;
use App\JfIdRegistration;

use App\McRegistration;

class ManyChatRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function shortregisteruser(Request $r1){
        $data = $r1->input();
        $data = $data["data"];
        
        
        //$mystring = 'abc';
        $findme   = '@';
        $pos = strpos($data["email"], $findme);
        
        // Note our use of ===.  Simply == would not work as expected
        // because the position of 'a' was the 0th (first) character.
        if ($pos === false) {
        //echo "The string '$findme' was not found in the string '$mystring'";
        } else {
        //echo "The string '$findme' was found in the string '$mystring'";
        //echo " and exists at position $pos";
        $this->shortregister($r1);
             
             
        }
        
    }
    
    
    public function registeruser(Request $r1){
         //echo "Here at RegisterUserTest";
         $data = $r1->input();
         $data = $data["data"];
         
         
         //print_r($data);
         
         //$mystring = 'abc';
         $findme   = '@';
         $pos = strpos($data["email"], $findme);
        
         // Note our use of ===.  Simply == would not work as expected
         // because the position of 'a' was the 0th (first) character.
         if ($pos === false) {
            //echo "The string '$findme' was not found in the string '$mystring'";
         } else {
            //echo "The string '$findme' was found in the string '$mystring'";
            //echo " and exists at position $pos";
            $this->register($r1);
             
             
         }
    }
    
    public function registertest(){
        //echo "Here at RegisterTest";
 
        
    }
    
    public function createAccount(Request $r1){
            $data = $r1->input();
            $data = $data["data"];
            
            //$data["name"][0]
            
            $user = new UserTesting;
            $user->user_email = $data["email"];
            $passw = "sdfi2008";
            $user->user_pass = password_hash($passw, PASSWORD_DEFAULT);
            $user->plainpass = $passw;
            
            //no full name
            $user->last_name = $data["lastName"];
            $user->first_name = $data["firstName"];
            $user->middle_name = $data["middleName"];
            $user->account_id = md5(uniqid());
            $user->phone_no = $data["phone"];
            //$user->country = $item->country;
            
            $user->address_line1 = $data["streetAddress"] ;
            //$user->address_line2 = $item->;
            $user->city = $data["city"];
            $user->state_province = $data["stateOrProvince"];
            $user->postal_zip_code = $data["zipCode"];
                
            //format date
            //$user->birthday = "1973-03-17";
 
            $user->save();
                
            //invoke mail 
            $data = array();
            $data["email"] = $user->user_email;
            
            $this->sendRegMail($data);
            
            //pass ID back
            return $user->id;    
           
    } 
    
    public function createShortAccount(Request $r1){
            $data = $r1->input();
            $data = $data["data"];
            
            //$data["name"][0]
            
            $user = new UserTesting;
            $user->user_email = $data["email"];
            $passw = "sdfi2008";
            $user->user_pass = password_hash($passw, PASSWORD_DEFAULT);
            $user->plainpass = $passw;
            
            //no full name
            $user->last_name = $data["lastName"];
            $user->first_name = $data["firstName"];
            $user->middle_name = $data["middleName"];
            $user->account_id = md5(uniqid());
            $user->phone_no = $data["phone"];
            //$user->country = $item->country;
            
            //$user->address_line1 = $data["streetAddress"] ;
            //$user->address_line2 = $item->;
            //$user->city = $data["city"];
            //$user->state_province = $data["stateOrProvince"];
            //$user->postal_zip_code = $data["zipCode"];
                
            //format date
            //$user->birthday = "1973-03-17";
 
            $user->save();
                
            //invoke mail 
            $data = array();
            $data["email"] = $user->user_email;
            
            $this->sendRegMail($data);
            
            //pass ID back
            return $user->id;    
           
    } 
 
    
    public function createAccount2(Request $r1){
            $data = $r1->input();
            //$data["name"][0]
            
            $user = new UserTesting;
            $user->user_email = $data["emailaddress"];
            $passw = "sdfi2008";
            $user->user_pass = password_hash($passw, PASSWORD_DEFAULT);
            $user->plainpass = $passw;
            $user->last_name = $data["name"][2];
            $user->first_name = $data["name"][0];
            $user->middle_name = $data["name"][1];
            $user->account_id = md5(uniqid());
            $user->phone_no = $data["contactno"];
            //$user->country = $item->country;
            
            $user->address_line1 = $data["permanentaddress28"][0] . " " . $data["permanentaddress28"][1] ;
            //$user->address_line2 = $item->;
            $user->city = $data["permanentaddress28"][2];
            $user->state_province = $data["permanentaddress28"][3];
            $user->postal_zip_code = $data["permanentaddress28"][4];
                
            //format date
            //$user->birthday = "1973-03-17";
 
            $user->save();
                
            //invoke mail 
            $data = array();
            $data["email"] = $user->user_email;
            
            $this->sendRegMail($data);
            
            //pass ID back
            return $user->id;    
           
    }
    
    public function sendRegMail($data){
    
        $cc= array();
        $cc[] = "vvmanychat2020@gmail.com";
        
        
        $receiver = $data["email"];
        
        
        //$receiver = "vincentvelasco1232019@gmail.com";
        Mail::to($receiver)->cc($cc)->send(new regMail($data));
        
    }
    
    
    
    public function register(Request $r1){
        $data = $r1->input();
        //var_dump($data)
        $data = $data["data"];
        
        $hasAccount = false;
        $hasRegAccount = false;
    
        //Step 1. Check if User has existing account - check email
        //If Yes - grab user ID
        
        //If No - create account then grab user ID
        
        $hasAccount = $this->countForEmail($data["email"]);
    
    
        if ($hasAccount){
            //echo "Has account registered";
            
            $item = $this->searchForEmail($data["email"]);
            //echo $item->id;
            $id = $item->id;
            
            //get ID 
        }else{
            //create new user get id and send mail
            $id = $this->createAccount($r1);
            //echo $id;
            
        }
    
      
        //Ensure existing account
        //Step 2. Check if User has existing registration account
        //If Yes - Do nothing.
        $hasRegAccount = $this->countForId($id);
        
        if ($hasRegAccount){
            //If Yes - Do nothing.
             
        }else{
             //If No - create registration account using ID
            $this->createRegistration($r1,$id);
            
            //loop through beneficiary and ids and create matching .

            $this->registerMcBeneficiary($data["beneficiary1"],$data["beneficiaryRelationship1"],$id);
            $this->registerMcBeneficiary($data["beneficiary2"],$data["beneficiaryRelationship1"],$id);
            $this->registerMcBeneficiary($data["beneficiary3"],$data["beneficiaryRelationship1"],$id);
            
            $idItem = array();
            $idItem["idType"] = $data["idType"];
            $idItem["idNumber"] = $data["idNumber"];
            $idItem["idDateOfIssue"] = $data["idDateOfIssue"];
            $idItem["idDateOfExpiry"] = $data["idDateOfExpiry"];
            $idItem["idPlaceOfIssue"] = $data["idPlaceOfIssue"];
            $idItem["idPicture"] = $data["idPicture"];
            
            $this->registerMcId($idItem,$id);

        }
        
        //return view('registration.thankyou', []);
        
      
    }
    
    public function shortregister(Request $r1){
        $data = $r1->input();
        //var_dump($data)
        $data = $data["data"];
        
        $hasAccount = false;
        
    
        //Step 1. Check if User has existing account - check email
        
        $hasAccount = $this->countForEmail($data["email"]);
    
    
        if ($hasAccount){
         
           
        }else{
            
            $this->createShortAccount($r1);
         
            
        }
     
      
    }
    
    public function registerMcBeneficiary($fname,$rel,$id){
        $nullCounter = 0;
        
        $bene = new JfBeneficiaryRegistration;
        $bene->reg_id = $id;
        
        if (trim($fname) == NULL){
            $nullCounter ++;
        }
        
        if (trim(strtolower($fname)) == "none"){
            $nullCounter ++;
        }
        
        if (trim($rel) == NULL){
            $nullCounter ++;
        }
        
        if (trim(strtolower($rel)) == "none"){
            $nullCounter ++;
        }
        
        
        $bene->full_name = $fname;
        
        $bene->relationship = $rel;
        //$bene->occupation = $item->{"Occupation"};
        //$bene->sex = $item->{"Sex"};
        
        //need to format birthdate.
        //$bene->birthday = $item->{"Birthdate"};
        //$bene->setBirthday($item->{"Birthdate"});
        if ($nullCounter == 0){
            $bene->save();
        }
    }
    
    public function registerMcId($item,$id){
        
        
        $iden = new JfIdRegistration;
        $iden->reg_id = $id;
        $iden->id_type = $item["idType"];
        
        $iden->id_number = $item["idNumber"];
        //$iden->sex = $item[""];
         //need to format dates.
         //01/02/1967
         
        $iden->issue_date = $item["idDateOfIssue"];
        //$iden->setIssueDate($item->{"Date of issue"});
        
        $iden->expiry_date = $item["idDateOfExpiry"];
        //$iden->setExpiryDate($item->{"Date of expiry"});
        
        $iden->place_issued = $item["idPlaceOfIssue"];
        
        $iden->save();
        
    }
    
    
    public function registerBeneficiary($item,$id){
        $bene = new JfBeneficiaryRegistration;
        $bene->reg_id = $id;
        $bene->full_name = $item->{"Full Name"};
        
        $bene->relationship = $item->{"Relationship"};
        $bene->occupation = $item->{"Occupation"};
        $bene->sex = $item->{"Sex"};
        
        //need to format birthdate.
        //$bene->birthday = $item->{"Birthdate"};
        $bene->setBirthday($item->{"Birthdate"});
        
        $bene->save();
        
    }
    
    public function registerId($item,$id){
        
        
        $iden = new JfIdRegistration;
        $iden->reg_id = $id;
        $iden->id_type = $item->{"Kind of ID"};
        
        $iden->id_number = $item->{"ID Number"};
        $iden->sex = $item->{"Sex"};
         //need to format dates.
         //01/02/1967
         
        //$iden->issue_date = $item->{"Date of issue"};
        $iden->setIssueDate($item->{"Date of issue"});
        
        //$iden->expiry_date = $item->{"Date of expiry"};
        $iden->setExpiryDate($item->{"Date of expiry"});
        
        $iden->place_issued = $item->{"Place of issue"};
        
        $iden->save();
        
    }
    
    
    public function createRegistration(Request $r1,$id){
        //$beneficiaries = json_decode($input["beneficiaries"]);
        
        //Convert post to assoc array
        $data = $r1->input();
        $data = $data["data"];
       
        $j1 = new McRegistration;
        
        $j1->reg_id = $id;
        $j1->full_name = $data["fullName"];
        $j1->first_name = $data["firstName"];
        $j1->middle_name = $data["middleName"];
        $j1->last_name = $data["lastName"];
        //$j1->suffix_name = $data["fullName"];
        $j1->nick_name = $data["nickName"];
        

        
        //Need date formatter
        $j1->birthday = $data["birthday"];
        //$j1->setBirthday($data["dateof"][0],$data["dateof"][1],$data["dateof"][2]);
        //$j1->birthday = $data["birthday"];
        
             
        $j1->address1 = $data["streetAddress"];
        //$j1->street_address = $data["permanentaddress28"];
        $j1->city = $data["city"];
        $j1->state_or_province = $data["stateOrProvince"];
        $j1->postal_zip_code = $data["zipCode"];
        
         
        
        $j1->country = $data["country"];
        
        $j1->phone = $data["phone"];
        $j1->email = $data["email"];
        
                
        $j1->id_picture = $this->getMcImage($r1,$id);
        
        $j1->flagged = 0;

        
        $j1->save();
        
        
        /*
        $j1->first_maiden_name = $data["maidenname4"][0];
        $j1->middle_maiden_name = $data["maidenname4"][1];
        $j1->last_maiden_name = $data["maidenname4"][2];
        $j1->suffix_maiden_name = $data["maidenname4"][3];
        */
        
        //$j1->civil_status = $data["maritalstatus"];
        //$j1->sex = $data["sex"];
        //$j1->isOfw = $data["areyou"];
        
        //$j1->birth_place = $data["typea"];
        
        /*
        $j1->mothers_maiden_first_name = $data["mothersmaiden"][0];
        $j1->mothers_maiden_middle_name = $data["mothersmaiden"][1];
        $j1->mothers_maiden_last_name = $data["mothersmaiden"][2];
        $j1->mothers_maiden_suffix_name = $data["mothersmaiden"][3];
        
        $j1->fathers_first_name = $data["fathersname"][0];
        $j1->fathers_middle_name = $data["fathersname"][1];
        $j1->fathers_last_name = $data["fathersname"][2];
        $j1->fathers_suffix_name = $data["fathersname"][3];
        
        $j1->spouses_first_name = $data["spouse"][0];
        $j1->spouses_middle_name = $data["spouse"][1];
        $j1->spouses_last_name = $data["spouse"][2];
        $j1->spouses_suffix_name = $data["spouse"][3];
        */
    
    
    
   
        /*
        $j1->employment_status = $data["employmentstatus"];
        $j1->occupation = $data["occupation"];
        $j1->employer = $data["emailaddress16"];
        $j1->employers_address = $data["employeraddress"];
        */
           
        
        //format date
        //$j1->employment_date = $data["employmentdate"][0];
        //$j1->setEmploymentDate($data["employmentdate"][0],$data["employmentdate"][1],$data["employmentdate"][2]);
        
        /*
        $j1->sss_number = $data["sssgsisnumber"];
        $j1->tin_number = $data["taxidentification"];
        $j1->monthly_salary = $data["basicmonthly"];
        */

   
        //return response()->json($r1->all());
        
        
    }
    
    public function getMcImage(Request $r1,$id){
        //changed to Mc Picture
        
        $data = $r1->input();
        $data = $data["data"];
        
        $contents = file_get_contents($data["idPicture"]);
        $extension = ".jpg";
        $fileFirstPart = $id;
        $filename = $fileFirstPart . "_" . time() ."". $extension;
 
                        
        Storage::disk('public')->put($filename, $contents);
        return asset('storage/'.$filename);
       
    }
    
    public function getJfImage(Request $r1){
        $data = $r1->input();
        
        //perform function for picture storage.
        //$j1->id_picture = $data["uploadid"][0];
        
        //http://www.jotform.com/uploads/vincerap/YOUR_FORM_ID/{$SUBMISSION_ID_VARIABLE}/{$FILE_UPLOAD_VARIABLE}
        
        $prefix = "http://www.jotform.com/uploads/vincerap/";
        //$formId = $data["formID"];
        $url = $prefix . $data["formID"] ."/". $data["submission_id"] . "/" . $data["uploadid"][0];
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
    

    public function gswepdep(Request $r1){
        
        //$count = "hello gswepdep";
        //print_r($r1->all());
        $input = $r1->input();
        
        
        return response()->json($input);
        
        
        //return back();
    }
    
     
    public function countForId($id){
        
        $found = false;
        
        $count = JfRegistration::where([
            ['reg_id', '=', $id  ],
        ])
        ->count();
            
        if ($count > 0){
            $found = true;
        }   
            
        //dd($count);
        return $found;
        
    }
    
     
    
    public function countForEmail($email){
        
        $found = false;
        //UserO
        $count = UserTesting::where([
            ['user_email', '=', $email  ],
        ])
        ->count();
            
        if ($count > 0){
            $found = true;
        }   
            
        //dd($count);
        return $found;
        
    }
    
    
    
    public function searchForEmail($email){
        //UserO
        $user = UserTesting::where([
                        ['user_email', '=', $email  ],
                ])
        ->get();
        
        return $user[0];
        
        
    }
    
   
    
   
   
}
