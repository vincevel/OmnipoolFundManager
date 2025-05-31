<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JfSweppRegistration extends Model
{
    //
    protected $table = 'jf_swepp_reg_record';
    
    public function setDate($month,$day,$year){
        //FROM 03 16 2021
        //TO 2020-01-20
        
        return $year . "-" . $month . "-" . $day;
    }
    
    
    public function setBirthday($month,$day,$year){
        
        $this->birthday = $this->setDate($month,$day,$year);
    }
    
    /*
    public function setEmploymentDate($month,$day,$year){
        
        $this->employment_date = $this->setDate($month,$day,$year);
    }
    */
    
    
    
}
