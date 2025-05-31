<?php
namespace App\Http\Controllers;
use App\UserO;
use App\UserN;
use App\Transaction;

use App\JfRegistration;
use App\QueryString;

use Illuminate\Http\Request;
use PDF;

class ProfileController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }
    
    public function numhash($n) {
        return (((0x0000FFFF & $n) << 16) + ((0xFFFF0000 & $n) >> 16));
    }
    
    public function edit(Request $r1)
    {
        //$id = "16215";
        $id = $this->numhash($r1->user_id2);
        //dd($id);



        $user = JfRegistration::find($id);
        // $user = JfRegistration::find($id);


        if ($user!=NULL){

        //dd($user);
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
        
        //$test = "Test String";
        return view('profile2.edit', [
            
            'query' => $query
            
        ]);
        //->with(compact('user'))

        } else {
            return redirect()->back();
        }
        
    }
    
 
    
}