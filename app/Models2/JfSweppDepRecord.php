<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JfSweppDepRecord extends Model
{
    protected $table = "jf_gsweppdep_record";

    protected $fillable = array('');
    
    public function setDate($month,$day,$year){
        //FROM 03 16 2021
        //TO 2020-01-20
        
        return $year . "-" . $month . "-" . $day;
    }
    
    public function setSriDepositDate($month,$day,$year){
        
        $this->sri_deposit_date = $this->setDate($month,$day,$year);
    } 
    
}
