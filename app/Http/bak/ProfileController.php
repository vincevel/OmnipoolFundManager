<?php
namespace App\Http\Controllers;
use App\UserO;
use App\UserN;
use App\Transaction;

use Illuminate\Http\Request;
use PDF;

class ProfileController extends Controller
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
        $id = $this->numhash($r1->user_id);
        //id();
        $user = UserO::find($id);
        //dd();
        //dd($user);
        $bday = $user->birthday;
        
        if ($bday == NULL){
            $bday = "01/01/2020";
            
        }else {
            //
            //$bday = "01/01/2020";
            //$bday = $user->birthday->format('m/d/Y');
            
            $date = explode("-",$bday);
                     //2020-01-01 to 01/01/2020 
            $date2 = "$date[1]" . "/". "$date[2]" . "/" . "$date[0]";
        
            $bday = $date2;
            //dd($bday);
        }
        //dd($bday);
        //$date = $user->created_at->format('ymd');
        return view('profile.edit', [
            
            'user' => $user,
            'bday' => $bday
            
        ]);
        
    }
    
    public function checkVar($input){
        $marker = 0;
        
        if (isset($input)){
            $marker++;
        }
     
        if (trim($input!=NULL)){
            $marker++;
        } 
     
        return $marker;   
    }
    
    public function save(Request $r1)
    {
        //dd($r1);
        //'field' => 'regex:[a-zA-Z0-9\s]+',
        
        /*
        $this->validate($r1,[
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_no' => 'required',
            'address_line1' => 'required',
            'address_line2' => 'required',
            'city' => 'required',
            'state_province' => 'required',
            'postal_zip_code' => 'required|numeric',
            'country' => 'required|alpha' 
            
        ]);
        */
        
        /*
          $this->validate($r1,[
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'phone_no' => 'required|numeric',
            'address_line1' => 'required|alpha_num',
            'address_line2' => 'required|alpha_num',
            'city' => 'required|alpha_num',
            'state_province' => 'required|alpha_num',
            'postal_zip_code' => 'required|numeric',
            'country' => 'required|alpha',
            'beneficiary1_first_name' => 'required|alpha',
            'beneficiary1_middle_name' => ' ',
            'beneficiary1_last_name' => 'required|alpha',
            'beneficiary1_relationship' => 'required|alpha'
            
        ]);
        */
        
        //todate
      
        
        
        $user = UserO::find($r1->id);
        //$user->first_name = $r1->first_name;
        
        if($this->checkVar($r1->first_name)){
            $userb = UserN::find($r1->id);
            
            $user->first_name = $r1->first_name;
            $userb->first_name = $r1->first_name;
            
            
            $transactions = Transaction::where([
             ['user_id', '=', $r1->id ]
            ])->get();
            
            foreach ($transactions as $item){
            
                $item->first_name = $r1->first_name;
                $item->save();
            }
        
            $user->save();
            $userb->save();     
            
            return back()->with('message', 'Profile - First Name Updated Successfully!');
        }
        
        if($this->checkVar($r1->last_name)){
            $userb = UserN::find($r1->id);
            
            $user->last_name = $r1->last_name;
            $userb->last_name = $r1->last_name;
            
            $transactions = Transaction::where([
             ['user_id', '=', $r1->id ]
            ])->get();
            
            foreach ($transactions as $item){
            
                $item->last_name = $r1->last_name;
                $item->save();
            }
            
            $user->save(); 
            $userb->save(); 
            return back()->with('message', 'Profile - Last Name Updated Successfully!');
        }
        
        
        
        
        if($this->checkVar($r1->middle_name)){
            
            
            $user->middle_name = $r1->middle_name;
            $user->save(); 
            return back()->with('message', 'Profile - Middle Name Updated Successfully!');
        }
        //$user->last_name = $r1->last_name;
        
        if($this->checkVar($r1->phone_no)){
            $user->phone_no = $r1->phone_no;
            $user->save(); 
            return back()->with('message', 'Profile - Phone Number Updated Successfully!');
        }
        
        if($this->checkVar($r1->address_line1)){
            $user->address_line1 = $r1->address_line1;
            $user->save(); 
            return back()->with('message', 'Profile - Address Line 1 Updated Successfully!');
        }
        
        if($this->checkVar($r1->address_line2)){
            $user->address_line2 = $r1->address_line2;
            $user->save(); 
            return back()->with('message', 'Profile - Address Line 2 Updated Successfully!');
        }
        
        if($this->checkVar($r1->city)){
            $user->city = $r1->city;
            $user->save(); 
            return back()->with('message', 'Profile - City Updated Successfully!');
        }
        
        if($this->checkVar($r1->birthday)){
            
            $date = explode("/",$r1->birthday);
                     //01/01/2020 to  2020-01-01
            $date2 = "$date[2]" . "-". "$date[0]" . "-" . "$date[1]";
            
            $user->birthday = $date2;
            $user->save(); 
            return back()->with('message', 'Profile - Birthday Updated Successfully!');
            
        }
        
        if($this->checkVar($r1->state_province)){
            $user->state_province = $r1->state_province;
            $user->save(); 
            return back()->with('message', 'Profile - State/Province Updated Successfully!');
        }
        
        if($this->checkVar($r1->postal_zip_code)){
            $user->postal_zip_code = $r1->postal_zip_code;
            $user->save(); 
            return back()->with('message', 'Profile - Zip Code Updated Successfully!');
        }
        
        if($this->checkVar($r1->country)){
            $user->country = $r1->country;
            $user->save(); 
            return back()->with('message', 'Profile - Country Updated Successfully!');
        }
        
        if($this->checkVar($r1->beneficiary1_first_name)){
            $user->beneficiary1_first_name = $r1->beneficiary1_first_name;
            $user->save(); 
            return back()->with('message', 'Profile - Beneficiary First Name Updated Successfully!');
        }
        
        if($this->checkVar($r1->beneficiary1_middle_name)){
            $user->beneficiary1_middle_name = $r1->beneficiary1_middle_name;
            $user->save(); 
            return back()->with('message', 'Profile - Beneficiary Middle Name Updated Successfully!');
        }
        
        if($this->checkVar($r1->beneficiary1_last_name)){
            $user->beneficiary1_last_name = $r1->beneficiary1_last_name;
            $user->save(); 
            return back()->with('message', 'Profile - Beneficiary Last Name Updated Successfully!');
        }
        
        if($this->checkVar($r1->beneficiary1_relationship)){
            $user->beneficiary1_relationship = $r1->beneficiary1_relationship;
            $user->save(); 
            return back()->with('message', 'Profile - Beneficiary Relationship Updated Successfully!');
            
        }
        
         return back()->with('message', 'No Updates Done');
        
    }
    
}