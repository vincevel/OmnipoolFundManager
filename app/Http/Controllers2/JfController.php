<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
 
use App\Mail\regMail;


use App\TransactionSync;
use App\Transaction;
use App\UserO;
use App\UserN;
use App\UserTesting;
 
use App\QueryString;
 

use Storage;
 
use App\JfRegistration;
use App\JfBeneficiaryRegistration;
use App\JfIdRegistration;


class JfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
 
    
    public function registertest(){
        //echo "Here at RegisterTest";
 
        
    }
    
 
    
    public function createAccount(Request $r1){
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
    
    public function shortRegister3(Request $r1){
        
        
        
        return redirect()->route('main');
        
    }
 

    public function checkEmptyFields(Request $r1){
        
        if (!$r1->has('maidenname4')) { 
            $r1->merge(['maidenname4' => array(NULL,NULL,NULL,NULL)]); 
        }
    
        if (!$r1->has('employmentstatus')) { 
            $r1->merge(['employmentstatus' => NULL]);     
        }
    
        return $r1;
    }

    public function shortRegisterUpdate(Request $r1){

        $r1 = $this->checkEmptyFields($r1);
        $data = $r1->input();
        //dd($data);
        //$JfRegistration
        //FIND RECORD TO UPDATE
        $user = JfRegistration::find($data["id"]);

        $id = $data["id"];
        //update all fields;
        //dd($user);
              

        $user->first_name = $data["name"][0];
        $user->middle_name = $data["name"][1];
        $user->last_name = $data["name"][2];
        $user->suffix_name = $data["name"][3];
        $user->nick_name = $data["nickname"];

        $user->first_maiden_name = $data["maidenname4"][0];
        $user->middle_maiden_name = $data["maidenname4"][1];
        $user->last_maiden_name = $data["maidenname4"][2];
        $user->suffix_maiden_name = $data["maidenname4"][3];

        if (is_array($data["maritalstatus"])){
            $user->civil_status = $data["maritalstatus"][0];
        }else{
            $user->civil_status = $data["maritalstatus"];
        }
        $user->sex = $data["sex"];
        $user->isOfw = $data["areyou"];
 
        $user->setBirthday($data["dateof"][0],$data["dateof"][1],$data["dateof"][2]);
 
        $user->birth_place = $data["typea"];

        $user->mothers_maiden_first_name = $data["mothersmaiden"][0];
        $user->mothers_maiden_middle_name = $data["mothersmaiden"][1];
        $user->mothers_maiden_last_name = $data["mothersmaiden"][2];
        $user->mothers_maiden_suffix_name = $data["mothersmaiden"][3];
        $user->fathers_first_name = $data["fathersname"][0];
        $user->fathers_middle_name = $data["fathersname"][1];
        $user->fathers_last_name = $data["fathersname"][2];
        $user->fathers_suffix_name = $data["fathersname"][3];

        if (isset($data["spouse"][0])){
        $user->spouses_first_name = $data["spouse"][0];
        }
        
        if (isset($data["spouse"][1])){
        $user->spouses_middle_name = $data["spouse"][1];
        }
        
        if (isset($data["spouse"][2])){
        $user->spouses_last_name = $data["spouse"][2];
        }
        
        if (isset($data["spouse"][3])){
        $user->spouses_suffix_name = $data["spouse"][3];
        }

        $user->address1 = $data["permanentaddress28"][0];
        $user->street_address = $data["permanentaddress28"][1];
        $user->city = $data["permanentaddress28"][2];
        $user->state_or_province = $data["permanentaddress28"][3];
        $user->postal_zip_code = $data["permanentaddress28"][4];
 

        $user->phone = $data["contactno"];
        $user->email = $data["emailaddress"];

        if (isset($data["employmentstatus"])){
            if (is_array($data["employmentstatus"])){
                $user->employment_status = $data["employmentstatus"][0];
            }else{
                $user->employment_status = $data["employmentstatus"];
            }
        }    

        $user->occupation = $data["occupation"];
        
         if (isset($data["emailaddress16"])){
            $user->employer = $data["emailaddress16"];
        }
        
        if (isset($data["employeraddress"])){
        $user->employers_address = $data["employeraddress"];
        }
           
        if (isset($data["employmentdate"][0])){
        //format date
        //$user->employment_date = $data["employmentdate"][0];
        $user->setEmploymentDate($data["employmentdate"][0],$data["employmentdate"][1],$data["employmentdate"][2]);
        } else {
             $user->employment_date = NULL;
        }

        if (isset($data["sssgsisnumber"])){
            $user->sss_number = $data["sssgsisnumber"];
        }
        if (isset($data["taxidentification"])){
        $user->tin_number = $data["taxidentification"];
        }
        $user->monthly_salary = $data["basicmonthly"];

        if (isset($data["uploadid"][0])){
            if ($data["uploadid"][0]!=NULL){
                $user->id_picture = $this->getJfImage($r1);
            }
        }    
   
        $user->save();


        $query = new QueryString;
        $query->addParam("fullName",$user->full_name);
        $query->addParam("name[first]",$user->first_name);
        $query->addParam("name[middle]",$user->middle_name);
        $query->addParam("name[last]",$user->last_name);
        $query->addParam("name[suffix]",$user->suffix_name);
        $query->addParam("nickname",$user->nick_name);
        
        $query->addParam("maidenName4[first]",$user->first_maiden_name);
        $query->addParam("maidenName4[middle]",$user->middle_maiden_name);
        $query->addParam("maidenName4[last]",$user->last_maiden_name);
        $query->addParam("maidenName4[suffix]",$user->suffix_maiden_name);
        
        $query->addParam("maritalStatus",$user->civil_status);
        $query->addParam("sex",$user->sex);
        $query->addParam("areYou",$user->isOfw);
        
        $bday = explode("-",$user->birthday);
        $query->addParam("dateOf[year]",$bday[0]);
        $query->addParam("dateOf[month]",$bday[1]);
        $query->addParam("dateOf[day]",$bday[2]);

        $query->addParam("typeA",$user->birth_place);


        $query->addParam("mothersMaiden[first]",$user->mothers_maiden_first_name);
        $query->addParam("mothersMaiden[middle]",$user->mothers_maiden_middle_name);
        $query->addParam("mothersMaiden[last]",$user->mothers_maiden_last_name);
        $query->addParam("mothersMaiden[suffix]",$user->mothers_maiden_suffix_name);

        $query->addParam("fathersName[first]",$user->fathers_first_name);
        $query->addParam("fathersName[middle]",$user->fathers_middle_name);
        $query->addParam("fathersName[last]",$user->fathers_last_name);
        $query->addParam("fathersName[suffix]",$user->fathers_suffix_name);

        $query->addParam("spouse[first]",$user->spouses_first_name);
        $query->addParam("spouse[middle]",$user->spouses_middle_name);
        $query->addParam("spouse[last]",$user->spouses_last_name);
        $query->addParam("spouse[suffix]",$user->spouses_suffix_name);

        $query->addParam("permanentAddress28[addr_line1]",$user->address1);
        $query->addParam("permanentAddress28[addr_line2]",$user->street_address);
        $query->addParam("permanentAddress28[city]",$user->city);
        $query->addParam("permanentAddress28[state]",$user->state_or_province);
        $query->addParam("permanentAddress28[postal]",$user->postal_zip_code);
 
        //$query->addParam("",$user->country);
        $query->addParam("contactNo",$user->phone);
        $query->addParam("emailAddress",$user->email);
        $query->addParam("occupation",$user->occupation);
        $query->addParam("employmentStatus",$user->employment_status);
        $query->addParam("emailAddress16",$user->employer);
        $query->addParam("employerAddress",$user->employers_address);

        $employmentDate = explode("-",$user->employment_date);
        
        if (isset($employmentDate[0])){
            $query->addParam("employmentDate[year]",$employmentDate[0]);
        }    
        
        if (isset($employmentDate[1])){
            $query->addParam("employmentDate[month]",$employmentDate[1]);
        }
        if (isset($employmentDate[2])){
            $query->addParam("employmentDate[day]",$employmentDate[2]);
        }

        $query->addParam("sssgsisNumber",$user->sss_number);
        $query->addParam("taxIdentification",$user->tin_number);
        $query->addParam("basicMonthly",$user->monthly_salary);
        $query->addParam("id",$id);

        $query = $query->getQString();

        //$r1->session()->flash('message', 'Profile Updated Successfully');
        $r1->session()->now('message', 'Profile Updated Successfully');

        return view('profile2.edit', [
            
            'query' => $query
            
        ]);


        //return redirect()->back();
    }

    public function shortRegister(Request $r1){
    
        $r1 = $this->checkEmptyFields($r1);
        
       
        $data = $r1->input();
     
        //ASSUMED TO HAVE AN ACCOUNT DUE TO SRI LOGIN
        $id = $this->getId($data["emailaddress"]);
        
        //Ensure existing account
        //Step 2. Check if User has existing registration account
        //If Yes - Do nothing.
        $hasRegAccount = $this->countForId($id);
        
        if ($hasRegAccount){
            //If Yes - Do nothing.
             
        }else{
             //If No - create registration account using ID
             //FIRST TIME REGISTER ONLY
            $this->createRegistration($r1,$id);
            
            //loop through beneficiary and ids and create matching .
            if (isset($data["beneficiaries"])){
                
                    $beneficiaries = json_decode($data["beneficiaries"]);
                
                if ($beneficiaries!=NULL){
                    //var_dump($beneficiaries);
                    foreach ($beneficiaries as $item){
                        $this->registerBeneficiary($item,$id);
                    }
                }
            }

            if (isset($data["iddetails"])){

                $ids = json_decode($data["iddetails"]);
            //var_dump($ids);
            
                if ($ids!=NULL){
                    foreach ($ids as $item){
                        $this->registerId($item,$id);
                    }
                }
            }
        }
        
        //SET USER FLAG TO PROFILE COMPLETED
        $userLoginItem = UserN::find($id);
        $userLoginItem->completed_profile = 1;
        $userLoginItem->save();
        //return a redirect to main page
        return redirect()->route('main')->with('message', 'Profile Updated Successfully');
        
        
    }
    
 
    
    
    public function register(Request $r1){
        //MAIN
        $data = $r1->input();
        //var_dump($data)
        
        
        $hasAccount = false;
        $hasRegAccount = false;
    
        //Step 1. Check if User has existing account - check email
        //If Yes - grab user ID
        
        //If No - create account then grab user ID
        
        $hasAccount = $this->countForEmail($data["emailaddress"]);
    
    
        if ($hasAccount){
            //echo "Has account registered";
            
            $item = $this->searchForEmail($data["emailaddress"]);
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
            $beneficiaries = json_decode($data["beneficiaries"]);
            
            //var_dump($beneficiaries);
            foreach ($beneficiaries as $item){
                $this->registerBeneficiary($item,$id);
            }
            
            $ids = json_decode($data["iddetails"]);
            //var_dump($ids);
            
            foreach ($ids as $item){
                $this->registerId($item,$id);
            }
        }
        
        return view('registration.thankyou', [
            
         
            
        ]);
        
      
    }
    
    public function registerBeneficiary($item,$id){
        $bene = new JfBeneficiaryRegistration;
        $bene->reg_id = $id;
        $bene->full_name = $item->{"Full Name"};
        
        if ($item->{"Relationship"}!=NULL){
            $bene->relationship = $item->{"Relationship"};
        }
        
        if ($item->{"Occupation"}!=NULL){
            $bene->occupation = $item->{"Occupation"};
        }
        
        if ($item->{"Sex"}!=NULL){
            $bene->sex = $item->{"Sex"};
        }
        
        //need to format birthdate.
        //$bene->birthday = $item->{"Birthdate"};
        
        if ($item->{"Birthdate"}!=NULL){
            $bene->setBirthday($item->{"Birthdate"});
        }
        
        $bene->save();
        
    }
    
    public function registerId($item,$id){
        
        
        $iden = new JfIdRegistration;
        $iden->reg_id = $id;
        $iden->id_type = $item->{"Kind of ID"};
        
        if (isset($item->{"ID Number"})){    
            if ($item->{"ID Number"}!=NULL){
                $iden->id_number = $item->{"ID Number"};
            }
        }    

        if (isset($item->{"Sex"})){    
            if ($item->{"Sex"}!=NULL){
                $iden->sex = $item->{"Sex"};
            }
        }
             //need to format dates.
             //01/02/1967
        
        if (isset($item->{"Date of issue"})){   
            //$iden->issue_date = $item->{"Date of issue"};
            if ($item->{"Date of issue"}!=NULL){
                $iden->setIssueDate($item->{"Date of issue"});
            }
        }   
            //$iden->expiry_date = $item->{"Date of expiry"};
        if (isset($item->{"Date of expiry"})){   
            if ($item->{"Date of expiry"}!=NULL){
                $iden->setExpiryDate($item->{"Date of expiry"});
            }
        }   
        
        if (isset($item->{"Place of issue"})){   
            if ($item->{"Place of issue"}!=NULL){
                $iden->place_issued = $item->{"Place of issue"};
            }
        }
    
        $iden->save();
        
    }
    
    
    public function createRegistration(Request $r1,$id){
        //$beneficiaries = json_decode($input["beneficiaries"]);
        
        //Convert post to assoc array
        $data = $r1->input();
       
        $j1 = new JfRegistration;
        
        $j1->reg_id = $id;
        //$j1->full_name = ;
        $j1->first_name = $data["name"][0];

        if (isset($data["name"][1])){
            $j1->middle_name = $data["name"][1];
        }
        
        $j1->last_name = $data["name"][2];

        if (isset($data["name"][3])){
            $j1->suffix_name = $data["name"][3];
        }

        $j1->nick_name = $data["nickname"];
        
        if (isset($data["maidenname4"][0])){
            $j1->first_maiden_name = $data["maidenname4"][0];
        }
        if (isset($data["maidenname4"][1])){
            $j1->middle_maiden_name = $data["maidenname4"][1];
        }
        if (isset($data["maidenname4"][2])){
            $j1->last_maiden_name = $data["maidenname4"][2];
        }
        if (isset($data["maidenname4"][3])){
            $j1->suffix_maiden_name = $data["maidenname4"][3];
        }
        
        //$j1->civil_status = $data["maritalstatus"];
        if (is_array($data["maritalstatus"])){
            $j1->civil_status = $data["maritalstatus"][0];
        }else{
            $j1->civil_status = $data["maritalstatus"];
        }


        $j1->sex = $data["sex"];
        $j1->isOfw = $data["areyou"];
        
        //Need date formatter
        //$j1->birthday = $data["dateof"][0];
        $j1->setBirthday($data["dateof"][0],$data["dateof"][1],$data["dateof"][2]);
        
        $j1->birth_place = $data["typea"];
        
        $j1->mothers_maiden_first_name = $data["mothersmaiden"][0];

        if (isset($data["mothersmaiden"][1])){
            $j1->mothers_maiden_middle_name = $data["mothersmaiden"][1];
        }
        $j1->mothers_maiden_last_name = $data["mothersmaiden"][2];
        
        if (isset($data["mothersmaiden"][3])){
            $j1->mothers_maiden_suffix_name = $data["mothersmaiden"][3];
        }

        $j1->fathers_first_name = $data["fathersname"][0];
        if (isset($data["fathersname"][1])){
            $j1->fathers_middle_name = $data["fathersname"][1];
        }
        
        $j1->fathers_last_name = $data["fathersname"][2];
        if (isset($data["fathersname"][3])){
            $j1->fathers_suffix_name = $data["fathersname"][3];
        }
        
        if (isset($data["spouse"][0])){
        $j1->spouses_first_name = $data["spouse"][0];
        }
        
        if (isset($data["spouse"][1])){
        $j1->spouses_middle_name = $data["spouse"][1];
        }
        
        if (isset($data["spouse"][2])){
        $j1->spouses_last_name = $data["spouse"][2];
        }
        
        if (isset($data["spouse"][3])){
        $j1->spouses_suffix_name = $data["spouse"][3];
        }
        
    
    
    
    
        
        $j1->address1 = $data["permanentaddress28"][0];
        
        if (isset($data["permanentaddress28"][1])){
            $j1->street_address = $data["permanentaddress28"][1];
        }
        
        $j1->city = $data["permanentaddress28"][2];
        $j1->state_or_province = $data["permanentaddress28"][3];
        $j1->postal_zip_code = $data["permanentaddress28"][4];
        
         
        
        //$j1->country = $data["permanentaddress28"][0]];
        
        $j1->phone = $data["contactno"];
        $j1->email = $data["emailaddress"];
        

        //$j1->employment_status = $data["employmentstatus"];
        if (isset($data["employmentstatus"])){
            if (is_array($data["employmentstatus"])){
                $j1->employment_status = $data["employmentstatus"][0];
            }else{
                $j1->employment_status = $data["employmentstatus"];
            }
        }  

        $j1->occupation = $data["occupation"];
        
        if (isset($data["emailaddress16"])){
            $j1->employer = $data["emailaddress16"];
        }
        
        if (isset($data["employeraddress"])){
        $j1->employers_address = $data["employeraddress"];
        }
           
        if (isset($data["employmentdate"][0])){
        //format date
        //$j1->employment_date = $data["employmentdate"][0];
        $j1->setEmploymentDate($data["employmentdate"][0],$data["employmentdate"][1],$data["employmentdate"][2]);
        }
        if (isset($data["sssgsisnumber"])){
            $j1->sss_number = $data["sssgsisnumber"];
        }
        if (isset($data["taxidentification"])){
        $j1->tin_number = $data["taxidentification"];
        }
        $j1->monthly_salary = $data["basicmonthly"];
        
        
        if (isset($data["uploadid"][0])){
            $j1->id_picture = $this->getJfImage($r1);
        }

        $j1->code = 1;
        
        $j1->flagged = 0;
    
  
        
        
        
        $j1->save();
            
   
        //return response()->json($r1->all());
        
        
    }
    
    public function getJfImage(Request $r1){
        $data = $r1->input();
        
        //perform function for picture storage.
        //$j1->id_picture = $data["uploadid"][0];
        
        //http://www.jotform.com/uploads/vincerap/YOUR_FORM_ID/{$SUBMISSION_ID_VARIABLE}/{$FILE_UPLOAD_VARIABLE}
        
        if (isset($data["uploadid"][0])){
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
    
     public function getId($email){
        //UserO
        $user = UserTesting::where([
                        ['user_email', '=', $email  ],
                ])
        ->get();
        
        return $user[0]->id;
        
        
    }
    
   
    
   
   
}
