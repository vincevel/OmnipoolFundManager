<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JfRegistration extends Model
{
    //
    protected $table = 'jf_reg_record';
    protected $primaryKey = 'reg_id';
    
    public function setDate($month,$day,$year){
        //FROM 03 16 2021
        //TO 2020-01-20
        
        return $year . "-" . $month . "-" . $day;
    }
    
    public function setBirthday($month,$day,$year){
        
        $this->birthday = $this->setDate($month,$day,$year);
    }
    
    public function setEmploymentDate($month,$day,$year){
        
        $this->employment_date = $this->setDate($month,$day,$year);
    }
    
    public function showTestString(){
        echo "Test String from within";
    }
    
}
