<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
 
use App\Mail\regMail;


use App\TransactionSync;
use App\Transaction;
use App\UserO;
 
 
use App\UserTesting2;
 

use Storage;
 
use App\JfRegistration;
use App\JfBeneficiaryRegistration;
use App\JfIdRegistration;

use App\JfSweppRegistration;
use App\JfSweppBeneficiaryRegistration;

use App\JfGyrtRegistration;
use App\JfGyrtBeneficiaryRegistration;

class JfGyrtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function registergyrt2(Request $r1){
         echo "At Register Gyrt";
         $data = $r1->input();
         print_r($data);
    }
    
 
     
     public function registerswepp2(Request $r1){
         $data = $r1->input();
         print_r($data);
     }
    
    
    
    
     public function registerswepp(Request $r1){
          //echo "Here at RegisterSweppTest";
         $data = $r1->input();
        //print_r($data);
 
        //var_dump($data)
        
        
        $hasAccount = false;
        $hasSweppAccount = false;
    
        //Step 1. Check if User has existing account - check email
        //If Yes - grab user ID
        
        //If No - create account then grab user ID
        
        $hasAccount = $this->countForEmail($data["email32"]);
    
    
        if ($hasAccount){
            //echo "Has account registered";
            
            $item = $this->searchForEmail($data["email32"]);
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
        $hasSweppAccount = $this->countForId($id);
        
        if ($hasSweppAccount){
            //If Yes - Do nothing.
             
        }else{
             //If No - create registration account using ID
            $this->createSweppRegistration($r1,$id);
            
            //loop through beneficiary and ids and create matching .
            $beneficiaries = json_decode($data["provideinformation"]);
            
            //var_dump($beneficiaries);
            foreach ($beneficiaries as $item){
                $this->registerSweppBeneficiary($item,$id);
            }
            
       
        }
        
        
        return view('registration.sweppthankyou', [
            
         
            
        ]);
        
    } 
 
    public function registergyrt(Request $r1){
          //echo "Here at RegisterSweppTest";
         $data = $r1->input();
        //print_r($data);
 
        //var_dump($data)
        
        
        $hasAccount = false;
        $hasGyrtAccount = false;
    
        //Step 1. Check if User has existing account - check email
        //If Yes - grab user ID
        
        //If No - create account then grab user ID
        
        $hasAccount = $this->countForEmail($data["email32"]);
    
    
        if ($hasAccount){
            //echo "Has account registered";
            
            $item = $this->searchForEmail($data["email32"]);
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
        $hasGyrtAccount = $this->countForId($id);
        
        if ($hasGyrtAccount){
            //If Yes - Do nothing.
             
        }else{
             //If No - create registration account using ID
            $this->createGyrtRegistration($r1,$id);
            
            //loop through beneficiary and ids and create matching .
            $beneficiaries = json_decode($data["provideinformation"]);
            
            //var_dump($beneficiaries);
            foreach ($beneficiaries as $item){
                $this->registerGyrtBeneficiary($item,$id);
            }
            
       
        }
        
        
        return view('registration.gyrtthankyou', [
            
         
            
        ]);
        
    } 
    
 
    
    public function createAccount(Request $r1){
            $data = $r1->input();
            //$data["name"][0]
            
            $user = new UserTesting2;
            $user->user_email = $data["email32"];
            $passw = "sdfi2008";
            $user->user_pass = password_hash($passw, PASSWORD_DEFAULT);
            $user->plainpass = $passw;
            $user->last_name = $data["fullname"][2];
            $user->first_name = $data["fullname"][0];
            $user->middle_name = $data["fullname"][1];
            $user->account_id = md5(uniqid());
            $user->phone_no = $data["contactnumber"][0] . " " . $data["contactnumber"][1] ;
            //$user->country = $item->country;
            
            $user->address_line1 = $data["presentaddress"][0] . " " . $data["presentaddress"][1] ;
            //$user->address_line2 = $item->;
            $user->city = $data["presentaddress"][2];
            $user->state_province = $data["presentaddress"][3];
            $user->postal_zip_code = $data["presentaddress"][4];
                
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
    

    public function registerGyrtBeneficiary($item,$id){
        $bene = new JfGyrtBeneficiaryRegistration;
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
    
     
    
    public function registerSweppBeneficiary($item,$id){
        $bene = new JfSweppBeneficiaryRegistration;
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
    
    
    
    public function createSweppRegistration(Request $r1,$id){
        //$beneficiaries = json_decode($input["beneficiaries"]);
        
 
        
        //Convert post to assoc array
        $data = $r1->input();
       
        $j1 = new JfSweppRegistration;
        
        $j1->reg_id = $id;
        //$j1->full_name = ;
        $j1->first_name = $data["fullname"][0];
        $j1->middle_name = $data["fullname"][1];
        $j1->last_name = $data["fullname"][2];
        $j1->suffix_name = $data["fullname"][3];
        $j1->nick_name = $data["nickname"];
        $j1->agent_first_name = $data["nameof65"][0];
        $j1->agent_last_name = $data["nameof65"][1];
        $j1->age = $data["age"];
        
        //format birthday
        //$j1->birthday = $data[""];
        $j1->setBirthday($data["dateof40"][0],$data["dateof40"][1],$data["dateof40"][2]);
        
        $j1->birth_place = $data["placeof"]; 
        $j1->number_of_siblings = $data["noof"];
        $j1->civil_status = $data["civilstatus"];
        $j1->sex = $data["sex"];
        $j1->religion = $data["religion"];
        $j1->education = $data["education"];
        $j1->phone1 = $data["contactnumber"][0];
        $j1->phone2 = $data["contactnumber"][1];
        $j1->address1 = $data["presentaddress"][0];
        $j1->street_address = $data["presentaddress"][1];
        $j1->city = $data["presentaddress"][2];
        $j1->state_or_province = $data["presentaddress"][3]; 
        $j1->postal_zip_code = $data["presentaddress"][4];
        //$j1->country = $data[""];
        $j1->no_years_in_address = $data["yearsin"]; 
        $j1->permanent_address1 = $data["permanent"][0];
        $j1->permanent_street_address = $data["permanent"][1];
        $j1->permanent_city = $data["permanent"][2];
        $j1->permanent_state_or_province = $data["permanent"][3]; 
        $j1->permanent_postal_zip_code = $data["permanent"][4];
        //$j1->permanent_country = $data[""];
        $j1->permanent_no_years_in_address = $data["yearsin35"]; 
        $j1->occupation_or_employer = $data["occupation"];
        $j1->email = $data["email32"];
 
        //format date
        //$j1->employment_date = $data["employmentdate"][0];
        //$j1->setEmploymentDate($data["employmentdate"][0],$data["employmentdate"][1],$data["employmentdate"][2]);
 
        
        $j1->flagged = 0;
        $j1->save();
            
   
        //return response()->json($r1->all());
        
        
    }
    
    public function createGyrtRegistration(Request $r1,$id){
        //$beneficiaries = json_decode($input["beneficiaries"]);
        
 
        
        //Convert post to assoc array
        $data = $r1->input();
       
        $j1 = new JfGyrtRegistration;
        
        $j1->reg_id = $id;
        //$j1->full_name = ;
        $j1->first_name = $data["fullname"][0];
        $j1->middle_name = $data["fullname"][1];
        $j1->last_name = $data["fullname"][2];
        $j1->suffix_name = $data["fullname"][3];
        $j1->nick_name = $data["nickname"];
        
        if (isset($data["nameof65"][0])){
        $j1->agent_first_name = $data["nameof65"][0];
        }
        if (isset($data["nameof65"][1])){
        $j1->agent_last_name = $data["nameof65"][1];
        }
        $j1->age = $data["age"];
        
        //format birthday
        //$j1->birthday = $data[""];
        $j1->setBirthday($data["dateof40"][0],$data["dateof40"][1],$data["dateof40"][2]);
        
        $j1->birth_place = $data["placeof"]; 
        $j1->number_of_siblings = $data["noof"];
        $j1->civil_status = $data["civilstatus"];
        $j1->sex = $data["sex"];
        $j1->religion = $data["religion"];
        $j1->education = $data["education"];
        $j1->phone1 = $data["contactnumber"][0];
        $j1->phone2 = $data["contactnumber"][1];
        $j1->address1 = $data["presentaddress"][0];
        $j1->street_address = $data["presentaddress"][1];
        $j1->city = $data["presentaddress"][2];
        $j1->state_or_province = $data["presentaddress"][3]; 
        $j1->postal_zip_code = $data["presentaddress"][4];
        //$j1->country = $data[""];
        $j1->no_years_in_address = $data["yearsin"]; 
        
        if (isset($data["permanent"][0])){
        $j1->permanent_address1 = $data["permanent"][0];
        }
        
        if (isset($data["permanent"][1])){
        $j1->permanent_street_address = $data["permanent"][1];
        }
        
        if (isset($data["permanent"][2])){
        $j1->permanent_city = $data["permanent"][2];
        }
        
        if (isset($data["permanent"][3])){
        $j1->permanent_state_or_province = $data["permanent"][3]; 
        }
        
        if (isset($data["permanent"][4])){
        $j1->permanent_postal_zip_code = $data["permanent"][4];
        }
        //$j1->permanent_country = $data[""];
        
        if (isset($data["yearsin35"])){
        $j1->permanent_no_years_in_address = $data["yearsin35"]; 
        }
        
        $j1->occupation_or_employer = $data["occupation"];
        $j1->email = $data["email32"];
 
        //format date
        //$j1->employment_date = $data["employmentdate"][0];
        //$j1->setEmploymentDate($data["employmentdate"][0],$data["employmentdate"][1],$data["employmentdate"][2]);
 
        
        $j1->flagged = 0;
        $j1->save();
            
   
        //return response()->json($r1->all());
        
        
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
    

 
    
    
    public function countForSweppId($id){
        
        $found = false;
        
        $count = JfSweppRegistration::where([
            ['reg_id', '=', $id  ],
        ])
        ->count();
            
        if ($count > 0){
            $found = true;
        }   
            
        //dd($count);
        return $found;
        
    }
     
    public function countForId($id){
        
        $found = false;
        
        $count = JfGyrtRegistration::where([
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
        $count = UserTesting2::where([
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
        $user = UserTesting2::where([
                        ['user_email', '=', $email  ],
                ])
        ->get();
        
        return $user[0];
        
        
    }
    
   
    
   
   
}
