<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JfSweppBeneficiaryRegistration extends Model
{
    //
    protected $table = 'jf_swepp_reg_beneficiary_record';
    
    public function formatDate($date){
        //FROM 01/02/1967
        //TO 2008-03-10
        $date1 = explode("/",$date);
        $date = $date1[2] . "-" . $date1[0] . "-" . $date1[1];
        
        return $date;
    }
    
    
    public function setBirthday($date){
        $this->birthday = $this->formatDate($date);
    }
    
    
}
