<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionOrg extends Model
{
    protected $table = "transactions";

    protected $fillable = array('sent_certificate');
    
    public $rate1 = 0.09;
    public $rate2 = 0.07;
    
    public $rate3 = 0.12;
    public $rate4 = 0.10;
    
    //public $rate5 = 0.10;
    
    public $date1 = "mar31";
    public $date2 = "jun 30";
    public $date3 = "sep30";
    public $date4 = "";
    
    //public $edate4 = 
    
    public $yearDays = 365;
    
    public function increaseByTen(){
        
        //$this->amount = 0;
        
    }
    
    public function checkBeforeDate($a,$b){
        
        $a = date_create($a);
        $b = date_create($b);
        //$a is date in question
        //$b is target date
        
        //pos means a before b
        //0 means a = b
        //negative means a is after b
        
        //date format date_create("2020-09-30");
        $diff = date_diff($a,$b); 
        $daysdiff = $diff->format("%R%a");
        
        if ($daysdiff > 0){
            return 1;
        }else {
            return 0;
        }
        
        
    }
    
    public function getSriBalance(){
        //switch on the org
        
        $quarters = array();
        
        switch ($this->investment_type){
    
            case "United Sugar Planters of Digos": 
        
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-06-30";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;
            
            case "Alalay Sa Kaunlaran Inc":    
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;
                
            case "Pantukan Chess Club Cooperative":    
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;    
                
            case "NSCC":    
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;      
            
            case "Organic Options": 
        
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-06-30";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;
                
            case "Organic Options 2": 
        
        
                $quarters[] = "2020-12-31";
                break;    
                
                
            default:
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-06-30";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                
                
                
        }
        
        $count = 0;
        foreach ($quarters as $qtr){
            
            if ($this->checkBeforeDate($this->date_transaction,$qtr)){
                $count++;
            }
            //$mult = ($this->amount % 10000)
            
            if($this->amount % 10000 == 0){
                $cpayout = $this->amount / 4;
            } else {
                $temp = intval($this->amount / 10000);
                $localamt = $temp * 10000;
                $cpayout = $localamt / 4;
            }
            
            if($this->amount % 10000 == 0){
                $amount = $this->amount;
            } else {
                $temp = intval($this->amount / 10000);
                $amount = $temp * 10000;
                 
            }
            
            
        }
        
        $tempTotal = $amount - ($count * $cpayout);
        $tempTotal = number_format($tempTotal,2, '.', '');
        
        return $tempTotal;
        
    }
    
     public function getQuarters(){
        //switch on the org
        
        $quarters = array();
        
        switch ($this->investment_type){
    
            case "United Sugar Planters of Digos": 
        
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-06-30";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;
            
            case "Alalay Sa Kaunlaran Inc":    
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;
                
            case "Pantukan Chess Club Cooperative":    
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;    
                
            case "NSCC":    
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;      
            
            case "Organic Options": 
        
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-06-30";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;
                
            case "Organic Options2": 
        
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-06-30";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                break;
                
                
            default:
                $quarters[] = "2020-03-31";
                $quarters[] = "2020-06-30";
                $quarters[] = "2020-09-30";
                $quarters[] = "2020-12-31";
                
                
                
        }
        
        $count = 0;
        foreach ($quarters as $qtr){
            
            if ($this->checkBeforeDate($this->date_transaction,$qtr)){
                $count++;
            }
          
            
            
        }
        
      
        
        return ($count);
        
    }
    
    
    public function setDays(){
       // $sdate4 = date_create($this->date_transaction);
        
        $sdate4 = date_create($this->date_transaction);
        //$edate4 = date_create("2020-09-30");
        $edate4 = date_create("2020-12-31");
        
        $diff = date_diff($sdate4,$edate4); 
        //$diff->format("%R%a days")
        $daysdiff = $diff->format("%R%a");
        //$this->dividend_payout = $daysdiff;
        
        
        if ($daysdiff > 92){
            
            $daysdiff = 92;
        }
        
        if($this->investment_type=="AlalaySaKaunlaranIncLLLL"){
            
            if ($daysdiff > 29){
            
                $daysdiff = 29;
            }
            
        }
        
        
        if ($daysdiff <= 0){
            
            $daysdiff = 0;
        }
        
        
        
            return $daysdiff;
        
        
    }
    
     public function setDays2(){
       // $sdate4 = date_create($this->date_transaction);
        
        $sdate4 = date_create($this->date_transaction);
        $edate4 = date_create("2020-03-01");
        $diff = date_diff($sdate4,$edate4); 
        //$diff->format("%R%a days")
        $daysdiff = $diff->format("%R%a");
        //$this->dividend_payout = $daysdiff;
        
        //if positive - rate 1 
        //if negative - rate 2
        
        
            return $daysdiff;
        
        
    }
    
    public function setContributionPayout(){
           // $cpayout = $this->amount / 4;
            
         if($this->amount % 10000 == 0){
                $cpayout = $this->amount / 4;
            } else {
                $temp = intval($this->amount / 10000);
                $localamt = $temp * 10000;
                $cpayout = $localamt / 4;
            }
        
        

        return $cpayout;
    }
    
    public function getCapital($amount,$qtrs,$cpayout){
        
        //qtr1
        
        if ($qtrs > 0){
            $mult = $cpayout * ($qtrs - 1);  
         
            $final =  $amount - $mult;
            return $final;
            
        }
        //qtr2
        
        //qtr3
        
        //qtr4
        
    }
    
    public function setDividendPayout(){
        
          if($this->amount % 10000 == 0){
                $localamt = $this->amount;
            } else {
                $temp = intval($this->amount / 10000);
                $localamt = $temp * 10000;
            }
        
       
        $days = $this->setDays(); 
        
        $rateCheck = $this->setDays2();
        
        $qtrpayout = $this->setContributionPayout();
        
        $qtrs = $this->getQuarters();
        
     
        if ($qtrs > 0){
            
            //$localamt = $localamt - ($qtrpayout * $qtrs) ;
            $cpayout = $this->setContributionPayout();
            //if quarter = 0
            $localamt = $this->getCapital($localamt,$qtrs,$cpayout);
            /*
             first quarter
             10000 = 10000 - (2500 * 1); 7500 = 2500
             10000 = 10000 - (2500 * 2);5000 = 5000
             10000 = 10000 - (2500 * 3); 2500 = 7500
             10000 = 10000 - (2500 * 4);0 = 0
            
            
            */
        }
            
        if ($this->investment_type=="Organic Options" || $this->investment_type=="OOI2" ){
           
            
            
            if ($rateCheck > 0){
                $dailyrate = ($localamt * $this->rate3) / $this->yearDays;
            } else {
                $dailyrate = ($localamt * $this->rate4) / $this->yearDays;
            }
            
        } else {
            
            if ($rateCheck > 0){
                $dailyrate = ($localamt * $this->rate1) / $this->yearDays;
            } else {
                $dailyrate = ($localamt * $this->rate2) / $this->yearDays;
            }
            
            
        }
        
        $div_amount = $dailyrate * $days;
        
        $this->dividend_payout = bcdiv($div_amount,1,2);
        
        if ($days > 0){
        $cpayout = $this->setContributionPayout();
        $this->contribution_payout = $cpayout;
         $this->amount = $this->dividend_payout + $cpayout;
        }
       
        //$this->dividend_payout = $this->rate2;
        
        //Formula is dailyrate = (rate X amount) / 365
        //number of days start of period end - end of period end
        //divpayout = dailyrate * number of days
        
        //$this->date_transaction = "2020-09-30";
        //$this->remarks = "Dividend and Contribution Payout 30 Sep 2020";
        
        $dailyrate2 = bcdiv($dailyrate,1,2);
        $this->date_transaction = "2020-12-31";
        
        $this->remarks = "Dividend and Contribution Payout 31 Dec 2020";
        
        //$this->remarks = "Number of Quarters - $qtrs - Daily Rate - $dailyrate - Remaning Investment - $localamt - Number of Days - $days -  Dividend and Contribution Payout 31 Dec 2020";
        
        if ($days == 0){
            $this->status = "Error";
        }
        
        if ($this->amount == 0){
           $this->status = "Error";
        }
       
        //$this->remarks  = $days . " days " . $this->remarks;
    
        if ($qtrs > 0){
            // $this->remarks .= " 999999999999999";
             //$this->sri_balance = 999999.99;
        }
        
    }
}
