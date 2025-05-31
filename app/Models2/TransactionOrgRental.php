<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TransactionT;
use App\Transaction;

class TransactionOrgRental extends Model
{
    protected $table = "transactions";

    protected $fillable = array('sent_certificate');
    
    /*
    public $date0 = "2020-03-31";
    public $date1 = "2020-06-30";
    public $date2 = "2020-09-30";
    public $date3 = "2020-12-31";
    
    */
    
    
    public $date0 = "2020-01-01";
    public $date1 = "2020-03-31";
    public $date2 = "2020-06-30";
    public $date3 = "2020-09-30";
    public $date4 = "2020-12-31";
    
    
    public function checkDiff($a,$b){
        
        $diff = date_diff($a,$b); 
        $daysdiff = $diff->format("%R%a");
        
        if ($daysdiff >= 0){
            return 1;
        }else {
            return 0;
        }
        
    }
    
    public function checkBetweenDates($a,$b,$c){
    
        //date format date_create("2020-09-30");
        $isBetween = 0;
        
        $a = date_create($a);
        $b = date_create($b);
        $c = date_create($c);
        
        if ($this->checkDiff($a,$b) && $this->checkDiff($b,$c)){
        
            $isBetween = 1;
        }
        
        return $isBetween;
    
    }
    
    public function getCode(){
        
        switch($this->investment_type){
        
            case "MARZAN1":
                $output0 = "a";
                break;
            
            case "MADDELA1":
                $output0 = "b";
                break;
        }
        
        $output1 = $this->checkBetweenDates($this->date0,$this->date_transaction,$this->date1);
        
        $output2 = $this->checkBetweenDates($this->date0,$this->date_transaction,$this->date2);

        $output3 = $this->checkBetweenDates($this->date0,$this->date_transaction,$this->date3);
        
        $output4 = $this->checkBetweenDates($this->date0,$this->date_transaction,$this->date4);

        $code = $output0 . "-" . $output1 . "-". $output2 . "-". $output3 . "-". $output4;
        
        return $code;
    }
    
    public function getUnits(){
        if($this->amount % 100000 == 0){
            //no remainder
            $units = $this->amount / 100000;
        } else {
            $units = intval($this->amount / 100000);
             
        }
    
        return $units;
    }
    
    public function daysBetween($a, $b){
        
        $a = date_create($a);
        $b = date_create($b);
        
        $diff = date_diff($a,$b); 
        $daysdiff = $diff->format("%R%a");
        
        if ($daysdiff > 0){
            return $daysdiff;
        }else {
            return 0;
        }
        
    }
    
    
    public function createWalletEntry($total){
        
        $transaction2 = new Transaction;
        $transaction2->last_name = $this->last_name;
        $transaction2->first_name = $this->first_name;

        $transaction2->user_id = $this->user_id;
        $transaction2->account_id = $this->account_id;
        $transaction2->email = $this->email;
                        
        //from form
        //$transaction2->date_transaction = "2020-09-30";
        $transaction2->date_transaction = "2020-12-31";
        
        $transaction2->status = "Verified2";
        //NEED TO DEFINE ORG
        $transaction2->investment_type = "My Wallet";
                       
        $transaction2->transaction_type_id = 7;
        
        //90 MARZAN
        $transaction2->testing = 90;
        //100 MADELA
        //$transaction2->testing = 100;
        
        
        switch($this->investment_type){
        
            case "MARZAN1":
                //$transaction2->remarks = "Wallet Marzan Rental Dividend Payout Sep 30";
                $transaction2->remarks = "Wallet Marzan Rental Dividend Payout Dec 31";
                break;
            
            case "MADDELA1":
                //$transaction2->remarks = "Wallet Maddela Rental Dividend Payout Sep 30";
                $transaction2->remarks = "Wallet Maddela Rental Dividend Payout Dec 31";
                break;
        }
        
        $transaction2->amount = $total;
        $transaction2->running_balance = $total;
 
              
        $transaction2->is_posted = 8;
        $transaction2->requested_by = $this->requested_by;
        $transaction2->save();
    }
    
    public function getDividends(){
        //date format date_create("2020-09-30");
        $code = $this->getCode();
        
        $units = $this->getUnits();
        
        $this->remarks = $units. " - " .$code . " Testing";
        
        $days = 0;
        $subt = 0;
        switch($code){
            
            case "a-0-1-1-1":
            case "a-0-0-1-1":    
                //NOT FIRST TIME
                $payout1 =  1009.80;
                
                $subt = $payout1 * $units;
                
                //$daysbetweenqtr2 = $this->daysBetween($this->date_transaction, $this->date2);
                $this->remarks = $subt . " + " . "0"  . " - " . "daysbetweenqtr" . "-" . $units. " - " .$code . " Testing";
                
                $this->createWalletEntry($subt);
            
                break;
                
            case "a-0-0-0-1":  
                //FIRST TIME
                
                $payout1 =  1009.80;
                
                $subsubt = $payout1 * $units;
                
                $daysbetweenqtr = $this->daysBetween($this->date_transaction, $this->date4);
                $subdays = $daysbetweenqtr / 90;
                
                $subt = $subsubt * $subdays;
                $days = $daysbetweenqtr;
                //NEED TO CALCULATE DAYS
                
                $this->remarks = $subt . " + " . "00"  . " - " . $daysbetweenqtr . "-" . $units. " - " .$code . " Testing";
                
                $this->createWalletEntry($subt);
                
                break;
            
            case "b-0-1-1-1":
            case "b-0-0-1-1":   
                //NOT FIRST TIME
                 //NOT FIRST TIME
                $payout1 =  1956.3;
                
                $subt = $payout1 * $units;
                
                //$daysbetweenqtr2 = $this->daysBetween($this->date_transaction, $this->date2);
                $this->remarks = $subt . " + " . "0"  . " - " . "daysbetweenqtr" . "-" . $units. " - " .$code . " Testing";
                
                $this->createWalletEntry($subt);
                
                break;
                
                
            case "b-0-0-0-1":  
                //FIRST TIME
                $payout1 =  1956.3;
                
                $subsubt = $payout1 * $units;
                
                $daysbetweenqtr = $this->daysBetween($this->date_transaction, $this->date4);
                $days = $daysbetweenqtr;
                
                $subdays = $daysbetweenqtr / 90;
                
                $subt = $subsubt * $subdays;
                
                //NEED TO CALCULATE DAYS
                
                $this->remarks = $subt . " + " . "00"  . " - " . $daysbetweenqtr . "-" . $units. " - " .$code . " Testing";
                
                $this->createWalletEntry($subt);
                
                break;
                
            case "a-0-1-1":
                $payout1 = 226.06;
                $payout2 = 530.10;
                $daysbetweenqtr2 = $this->daysBetween($this->date_transaction, $this->date2);
                
                $prorated_days = $daysbetweenqtr2 / 90;
                $subpayout = $units * $payout1;
                $subt1 = $subpayout * $prorated_days;
                
                $subt2 = $units * $payout2;
                
                //$daysbetweenqtr3 = $this->daysBetween($this->date_transaction, "2020-09-30");
                
                $subt3 = $subt1 + $subt2;
                $subt3 = number_format($subt3,2, '.', '');
                
                $this->remarks = $subt3 . " + " . 0  . " - " . $daysbetweenqtr2 . "-" . $units. " - " .$code . " Testing";
                
                $this->createWalletEntry($subt3);
                
                break;
            
            case "a-0-0-1":
                $payout1 = 530.10;
                $daysbetweenqtr3 = $this->daysBetween($this->date_transaction, $this->date3);
                $prorated_days = $daysbetweenqtr3 / 90;
                $subpayout = $units * $payout1;
                $subt1 = $subpayout * $prorated_days;
                $subt1 = number_format($subt1,2, '.', '');
                
                $this->remarks = $subt1 . " + " . "0"  . " - " . $daysbetweenqtr3 . "-" . $units. " - " .$code . " Testing";
                
                $this->createWalletEntry($subt1);
                
                break;
                
            case "b-0-0-1":  
                $payout1 =  1431.30;
                
                $daysbetweenqtr3 = $this->daysBetween($this->date_transaction, $this->date3);
                $prorated_days = $daysbetweenqtr3 / 90;
                $subpayout = $units * $payout1;
                $subt1 = $subpayout * $prorated_days;
                $subt1 = number_format($subt1,2, '.', '');
                
                $this->remarks = $subt1 . " + " . "0"  . " - " . $daysbetweenqtr3 . "-" . $units. " - " .$code . " Testing";
                
                $this->createWalletEntry($subt1);
                
                break;    
            
            case "b-0-0-0":  
                break;
                
            //default:
            //    break;
            
        }
        
        $this->remarks = $this->date_transaction . ",";
        $this->remarks .= $this->first_name . "," . $this->last_name . ",";
        $this->remarks .= $this->email . ",";
        $this->remarks .= $this->amount . ",";
        $this->remarks .= $this->investment_type . ",";
        $this->remarks .= $this->status . ",";
        $this->remarks .= $subt . ",";
        
        if ($days > 0){
            $this->remarks .= "Prorated days: " . $days . ",";
        }
            
    }
    
}
