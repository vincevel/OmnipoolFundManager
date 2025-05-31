<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JfIdRegistration extends Model
{
    //
    protected $table = 'jf_reg_id_record';
    
    public function formatDate($date){
        //FROM 01/02/1967
        //TO 2008-03-10
        $date1 = explode("/",$date);
        $date = $date1[2] . "-" . $date1[0] . "-" . $date1[1];
        
        return $date;
    }
    
    public function setIssueDate($date){
        $this->issue_date = $this->formatDate($date);
    }
    
    public function setExpiryDate($date){
        $this->expiry_date = $this->formatDate($date);
    }
     
}
